<?php
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/base_table.php');
require_once(__DIR__ .'/base_autonumber.php');

class base {

    protected $route_def = array(
                                    "add"           => "add_detail",
                                    "edit"          => "edit_detail",
                                    "delete"        => "delete_data",
                                    "select"        => "select_data",
                                    "combo"         => "combo_data",
                                    "datatable"     => "select_data_table",
                                    "unique-code"   => "unique_code",
                                    "autonumber"    => "get_autonumber",
                                    "trial-checker" => "get_trial_checker"
                                );

    private $arr_have_user_outlet = array('outlet','cassa');

    //set datatable class
    protected $table;
    protected $cond;
    protected $data;
    protected $order;
    protected $group;
    protected $filter_client;
    protected $print;

    protected $where;
    protected $data_where;

    protected $qry;
    protected $bs_tbl;
    protected $bs_number;

    function __construct() 
    {
        $this->qry        = new query();
        $this->bs_tbl     = new base_table();
        $this->bs_number  = new base_autonumber();
    }

	function bridge_to_function($json=null,$type="json",$print=0)
    {   
        if($type==="json")
        {
            $json = json_decode($json,true);
        }

        $function_name = $json["name"];
        $exe = $this->route[$function_name];
        if($json["param"]==="1")
        {
            $result = $this->$exe($json["data"],$print);
        }
        else
        {   
            $result = $this->$exe();
        }

        return $result;
    }

    function call_direct_function($func_name,$json=null)
    {
        if($json["param"]===1)
        {
            $result = $this->$func_name($json["data"]);
        }
        else
        {
            $result = $this->$func_name();
        }

        return $result;
    }

    // add delete detail
    function add_detail($json, $print=0)
    {
        $id=""; $conf_tbl=""; $table_detail="";
        $tmp_res    = array(); // all data temporary from result query
        $tmp_arr    = array();
        $error      = 0;
        $this->qry->beginTransaction();

        $table      = $this->table;
        $data       = $json["data"];

        $tmp_arr    = json_decode($this->qry->do_crud($table, $data, "", 0, $print), true); // decode return array result query
        $tmp_res[]  = $tmp_arr;
        if($tmp_arr["error"] !== "Success"){
            $error++;
        }
        if(isset($json["data_detail"])){
            $parent = $tmp_arr["data"];
            foreach ($json["data_detail"] as $key => $value) {
                $conf_tbl       = $this->setup_table_detail($value["name"]); // get all setup for detail with that name
                $where_detail   = array( $conf_tbl["index"] => $parent[$conf_tbl["parent"]] );
                $table_detail   = $conf_tbl["table"];
                $this->qry->do_crud($table_detail, "", $where_detail, 3, $print); // delete old detail
                foreach ($value["data"] as $k => $v) {
                    $v[$conf_tbl["index"]]  = $parent[$conf_tbl["parent"]];
                    $tmp_arr                = json_decode($this->qry->do_crud($table_detail, $v, "", 0, $print), true);
                    $tmp_res[]              = $tmp_arr;
                    if($tmp_arr["error"] !== "Success"){
                        $error++;
                    }
                }
            }
        }

        if($error > 0){
            $this->qry->cancelTransaction();
        }
        else{
            $this->qry->endTransaction();
        }

        echo json_encode($tmp_res);
    }

    function edit_detail($json, $print=0)
    {
        $id=""; $conf_tbl=""; $table_detail="";
        $tmp_res    = array(); // all data temporary from result query
        $tmp_arr    = array();
        $error      = 0;
        $this->qry->beginTransaction();

        $table      = $this->table;
        $data       = $json["data"];
        $data_where = $json["data_cond"];

        $tmp_arr    = json_decode($this->qry->do_crud($table, $data, $data_where, 1, $print), true); // decode return array result query
        $tmp_res[]  = $tmp_arr;
        if($tmp_arr["error"] !== "Success"){
            $error++;
        }
        if(isset($json["data_detail"])){
            $parent = $tmp_arr["data"];
            foreach ($json["data_detail"] as $key => $value) {
                $conf_tbl       = $this->setup_table_detail($value["name"]); // get all setup for detail with that name
                $where_detail   = array( $conf_tbl["index"] => $parent[$conf_tbl["parent"]] );
                $table_detail   = $conf_tbl["table"];
                $this->qry->do_crud($table_detail, "", $where_detail, 3, $print); // delete old detail
                foreach ($value["data"] as $k => $v) {
                    $v[$conf_tbl["index"]]  = $parent[$conf_tbl["parent"]];
                    $tmp_arr                = json_decode($this->qry->do_crud($table_detail, $v, "", 0, $print), true);
                    $tmp_res[]              = $tmp_arr;
                    if($tmp_arr["error"] !== "Success"){
                        $error++;
                    }
                }
            }
        }

        if($error > 0){
            $this->qry->cancelTransaction();
        }
        else{
            $this->qry->endTransaction();
        }

        echo json_encode($tmp_res);
    }
    // end delete detail

    function add_data($json, $print=0)
    {
        $table      = $this->table;
        $data       = $json["data"];
        echo $this->qry->do_crud($table, $data, "", 0, $print);
    }

    function edit_data($json, $print=0){
        $table      = $this->table;
        $data       = $json["data"];
        $data_where = $json["data_cond"];
        echo $this->qry->do_crud($table, $data, $data_where, 1, $print);
    }

    function delete_data($json, $print=0)
    {
        $table      = $this->table;
        $data       = $json["data"];
        $data_where = $json["data_cond"];
        echo $this->qry->do_crud($table, $data, $data_where, 2, $print);
    }

    function select_data($where="", $json="", $field="*", $print=0){
        $table  = $this->table;
        $result = $this->qry->select_all($table, $where, $json, $field, $print);
        if($print == 1){
            var_dump($result);
            var_dump($json);
            break;
        }
        return $result;
    }

    function select_query($query="",$print=0){
        if($print == 1){
            var_dump($result);
            break;
        }
        return $this->qry->select_query($query);
    }

    function unique_code($json)
    {
        $cond           = "AND status = 1";
        $arr_data       = array();
        foreach ($json['data'] as $key => $val) {
            $cond      .= " AND ".$val['name'] ."='".$val['value']."'";
            $arr_data[] = $val['value'];
        }
        $result         = 0;
        $tmp            = $this->select_data($cond,$arr_data,"1");
        if(count($tmp)>0)
            $result     = count($tmp);

        echo $result;
    }

    function get_trial_checker($json=""){
        $query      = "SELECT 1 FROM `pos_simple_register`.`company_data` 
                        WHERE db_name = database() AND status_trial = 1";
        $tmp        = $this->select_query($query);

        $query1     = "SELECT count(1) count FROM `".$this->table."` 
                        WHERE status <> 0";
        $tmp1       = $this->select_query($query1);

        $result['count']    = $tmp1[0]['count'];

        if(count($tmp)>0){
            $result['stop']     = array(
                                            "cassa"     => 1,
                                            "outlet"    => 1,
                                            "product"   => 10
                                        );
        }
        else{
            $result['stop']     = array(
                                            "cassa"     => 99999,
                                            "outlet"    => 99999,
                                            "product"   => 99999
                                        );
        }

        echo json_encode($result);
    }

    function get_autonumber($json=""){
        echo $this->bs_number->format_autonumber($this->table_set,$json['adding'],$json['data']);
    }

    function select_data_table($json = "",$print = 0)
    {
        $table         = $this->table;
        $field         = $this->data;
        $cond_default  = $this->cond;
        $order_default = $this->order;
        $group_default = $this->group;
        $filter_client = $this->filter_client;
        $print          = $this->print;
        $limit         = $this->bs_tbl->manage_limit($json); // manage limit
        $order         = $this->bs_tbl->manage_order($json,$field,$order_default); // manage order by
        $cond_client   = $this->bs_tbl->manage_cond_client($json,$filter_client); // manage condition client side
        $cond_data     = array();
        $cond_data     = $this->bs_tbl->manage_cond_client_data($json); // manage condition data client side

        foreach ($this->arr_have_user_outlet as $val_outlet) {
            if(strpos($table, $val_outlet) > -1){
                if(strpos($table, "report") > -1){
                    $cond_data = $cond_data;
                }
                else{
                    @session_start();
                    $cond_data[]   = $_SESSION['rcm_username'];
                }
            }
        }

        $data          = $this->select_data($cond_client.$cond_default.$group_default.$order.$limit, $cond_data, $field, $print); // select data from database
        $data_count    = $this->select_data($cond_client.$cond_default.$group_default, $cond_data, "1"); // select data all data for summary data
        echo $this->bs_tbl->to_data_table($data,$table,$json,$data_count);
    }

    function setup_table() 
    {
        $json_data              = file_get_contents(__DIR__ .'/data_table.php');
        $data                   = json_decode($json_data, true);
        $this->table            = isset($data[$this->table_set]["table"])   ? $data[$this->table_set]["table"]  : "";
        $this->cond             = isset($data[$this->table_set]["cond"])    ? $data[$this->table_set]["cond"]   : "";
        $this->data             = isset($data[$this->table_set]["data"])    ? $data[$this->table_set]["data"]   : "";
        $this->order            = isset($data[$this->table_set]["order"])   ? $data[$this->table_set]["order"]  : "";
        $this->group            = isset($data[$this->table_set]["group"])   ? $data[$this->table_set]["group"]  : "";
        $this->filter_client    = isset($data[$this->table_set]["filter"])  ? $data[$this->table_set]["filter"] : "";
        $this->print            = isset($data[$this->table_set]["print"])   ? $data[$this->table_set]["print"]  : 0;
    }

    function setup_table_detail($param="") 
    {
        $arr_tmp                     = array();
        $json_data                   = file_get_contents(__DIR__ .'/data_detail.php');
        $data                        = json_decode($json_data, true);
        $arr_tmp["table"]            = isset($data[$param]["table"])   ? $data[$param]["table"]  : "";
        $arr_tmp["index"]            = isset($data[$param]["index"])   ? $data[$param]["index"]  : "";
        $arr_tmp["parent"]           = isset($data[$param]["parent"])  ? $data[$param]["parent"] : "";

        return $arr_tmp;
    }

    function combo_data($json=""){
        $arr_return             = array();
        $data_temp              = '';
        $where                  = '';
        $json_where             = array();
        $arr_temp2              = array();
        foreach ($json['data'] as $get_key => $get_value) {
            $data_combo         = $this->setup_combo($get_value);
            if($json['data_cond'] != NULL){
                $data_where     = $this->combo_change($json['data_cond'][$get_key]);
                $where          = $data_where['where'];
                $json_where     = $data_where['json_where'];
            }

            $table              = $data_combo['table'];
            $cond               = $data_combo['cond'].$where;
            $field              = $data_combo['data'];
            
            if(strpos($table, 'outlet') > -1){
                @session_start();
                $json_where[]   = $_SESSION['rcm_username'];
            }
            
            $data_all_combo     = $this->qry->select_all($table,$cond,$json_where,$field);
            $arr_temp           = array();
            foreach ($data_all_combo as $key => $value) {
                $arr_temp[]     = $value;
            }

            $arr_return[]       = $arr_temp;
        }
        echo json_encode($arr_return);
    }

    function combo_change($json=""){
        $json_where = array();
        $where      = '';
        foreach ($json as $key_cond => $value_cond) {
            if($key_cond == "false"){
                $where = '';
            }
            elseif($key_cond == "cond_val"){
                if(is_array($value_cond)){
                    $json_where[] = implode(",",$value_cond);
                }
                else{
                    $json_where[] = $value_cond;
                }
            }
            else{
                $where      = ' AND '.$key_cond.' = ? ';
                $json_where[] = $value_cond;
            }
        }  
        $arr_where = array("where" => $where,"json_where" => $json_where);
        return $arr_where;
    }

    function setup_combo($param="") 
    {
        $arr_tmp                     = array();
        $json_data                   = file_get_contents(__DIR__ .'/data_combo.php');
        $data                        = json_decode($json_data, true);
        $arr_tmp["table"]            = isset($data[$param]["table"])   ? $data[$param]["table"]  : "";
        $arr_tmp["cond"]             = isset($data[$param]["cond"])    ? $data[$param]["cond"]   : "";
        $arr_tmp["data"]             = isset($data[$param]["data"])    ? $data[$param]["data"]   : "";

        return $arr_tmp;
    }



    function setup_filter($json) 
    {
        $where = "";
        $data_where = array();
        foreach ($json["where"] as $key => $value) {
            if (is_array($value['data'])){
                foreach ($value['data'] as $detkey => $detvalue) {
                    array_push($data_where,$detvalue);
                }
                $where .= " AND ".$value['fill']." ".$value['operator']." ? AND ?";
            }
            else{
                $where .= " AND ".$value['fill']." ".$value['operator']." ? ";
                array_push($data_where,$value['data']);
            }
        }
        $this->where        = $where;
        $this->data_where   = $data_where;
    }
}
?>