<?php
require_once(__DIR__ ."/../query/database_infoschema.php");
@session_start();

class base_table{
        
    private $info;

    function __construct()
    {
        $this->info = new database_infoschema;
    }

    function attr_manage($data_array="",$table=""){
        $res        = array();
        $result     = array();
        $attr       = $this->info->getColComment($table);
        $attr_key   = array_keys($attr);
        $data_key   = array_keys($data_array[0]);
        $data_tmp   = array_intersect($data_key,$attr_key);
        foreach ($data_tmp as $value) {
            $result[$value] = $attr[$value];
        }

        $result_def = array();
        foreach ($data_key as $val) {
            if($val == "numbering" || $val == "checkbox"){
                $result_def[$val] = "";
            }
        }

        $res        = array_merge($result_def, $result);

        return $res;
    }

    function to_data_table($data_array="",$table="",$json="",$count=""){
        $priv                           = $_SESSION['privilege'];
        $module                         = $json["module"];
        $priv_active                    = $priv[$module];
        $data_count                     = count($count);
        $data_result                    = array();
        
        if($data_count > 0){
            $data_attr                  = $this->attr_manage($data_array,$table);
            foreach ($data_array as $key => $value) {
                $data_result["dataOri"][]= $value;
                $data_tmp = array();
                foreach ($value as $k => $v) {
                    $data_tmp[] = $v;
                }
                $data_result["data"][]  = $data_tmp;
            }
        }
        else{
            $data_attr                  = "";
            $data_result["data"]        = array();
        }

        $data_result["dataAttr"]        = $data_attr;
        $data_result["recordsTotal"]    = $data_count;
        $data_result["recordsFiltered"] = $data_count;
        $data_result["draw"]            = $json["datatable"]["draw"];
        $data_result["priv"]            = $this->manage_arr_priv($priv_active);
        
        return json_encode($data_result);
    }

    private function manage_arr_priv($json="")
    {
        $data_tmp = array();
        foreach ($json as $key => $value) {
            if($value == 1){
                $data_tmp[] = $key;
            }

            if($value == 1 && $key == "add"){
                $data_tmp[] = "clone";
            }
        }

        return $data_tmp;
    }

    function manage_limit($json="")
    {
        //limit activity from client side
        $str_arr                = $json["datatable"];
        $limit                  = $str_arr["limit"];
        $offset                 = $str_arr["offset"];
        if($offset == '-1'){
            $limit_str          = "";
        }
        else{

            $limit_str          = " limit ". $limit .",". $offset;
        }

        return $limit_str;
    }

    private function clearFunctionMysql($str="")
    {
        $str = str_replace("sum(", "", $str);
        $str = str_replace("SUM ( ", "", $str);
        $str = str_replace("SUM (", "", $str);
        $str = str_replace("SUM( ", "", $str);
        $str = str_replace("count(", "", $str);
        $str = str_replace("COUNT ( ", "", $str);
        $str = str_replace("COUNT (", "", $str);
        $str = str_replace("COUNT( ", "", $str);
        $str = str_replace(")", "", $str);
        $str = explode(" ", $str);
        
        if(count($str) == 1){
            return $str[0];
        }

        return $str[1];
    }

    function manage_order($json="",$field="",$order="")
    {
        //order activity from client side or constanta
        $str_arr                = $json["datatable"];
        $order_str              = $str_arr["order"];
        $orderby_str            = $str_arr["orderBy"];
        $order_arr              = explode(",", $field);
        if($order_str == "0"){
            //order activity from constanta
            $order              = " order by ". $order;
        }
        else{
            //order default from client side
            $order              = " order by ". $this->clearFunctionMysql($order_arr[$order_str]) ." ". $orderby_str;
        }

        return $order;
    }

    function manage_cond_client($json="",$filter_arr="")
    {
        // filter activity from client side
        $str_arr    = $json["filter"];
        $str_cond   = $this->manage_arr_cond_client($str_arr,$filter_arr);
        return $str_cond;
    }

    private function manage_arr_cond_client($json="",$filter_arr="")
    {
        $str_cond   = "";
        if($json !== ""){
            foreach ($json as $key => $value) {
                if($value == ""){
                    continue;
                }

                if(is_array($value)){
                    if($value[0] == "" || $value[1] == "")
                        continue;
                }

                $str_cond .=  $this->set_cond($filter_arr[$key]["field"],$filter_arr[$key]["bridge"]);
            }
        }
        return $str_cond;
    }

    function manage_cond_client_data($json="")
    {
        $json       = $json["filter"];
        $str_arr    = array();
        if($json !== ""){
            foreach ($json as $key => $value) {
                if(is_array($value)){
                    if($value[0] !== "" || $value[1] !== ""){
                        $str_arr[] = $value[0];
                        $str_arr[] = $value[1];
                    }
                }
                elseif($value !== ""){
                    $str_arr[] = $value;
                }
            }
        }

        return $str_arr;
    }

    private function set_cond($field,$cond)
    {
        switch($cond)
        {
            case "between":
                $query = " AND $field $cond ? and ? ";
                break;
            case "=":
                $query = " AND $field $cond ? ";
                break;
            case "<>":
                $query = " AND $field $cond ? ";
                break;
            case "like":
                $query = " AND $field $cond concat('%', ?, '%') ";
                break;
        }

        return $query;
    }
}

?>