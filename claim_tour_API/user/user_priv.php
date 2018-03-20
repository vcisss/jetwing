<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class user_priv extends base{
   
    // begin variable declaration

    private $query;

    // variable for priv attribute
    protected $table_set;

    function __construct() 
    {
        $this->setup_user_priv();
        
    }

    function setup_user_priv() 
    {
       $this->query = new query();
    }

    function set_user_privilege($json)
    {
        $user        = $json['UserName'];
        $json_select = array($user);

        $this->table_set = 'user-priv';
        $this->setup_table();

        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;

         return $this->query->select_all($table,$cond,$json_select,$data);
        
    }

    private function manage_json_priv($json)
    {
        $data_tmp               = array();
        $tmp_arr                = array("username","menuadmincd");
        foreach ($json as $key => $value) {
            $det_tmp            = array();
            foreach ($value as $k => $v) {
                if(in_array($k, $tmp_arr)){
                    continue;
                }

                $arr            = str_replace("_pr", "", $k);
                $det_tmp[$arr]  = $v;
            }
            $data_tmp[$value["menu"]] = $det_tmp;
        }

        return $data_tmp;
    }

    function check_session(){
        @session_start();
        $table      = "check_login";
        $cond       = " AND username = ? AND status = 1";
        $json       = array($_SESSION["rcm_username"]);
        $data_tmp   = $this->query->select_all($table, $cond, $json, "1");
        if(count($data_tmp) > 0){
            $this->set_user_privilege();

            $data       = array(
                                    "status" => "0"
                                );
            $data_where = array(
                                    "username"   => $_SESSION['rcm_username']
                                );
            $this->query->do_crud($table, $data, $data_where, 1);
        }
    }

    function get_user_privilege($user)
    {
        $json_select = array($user);

        $this->table_set = 'view-user-priv';
        $this->setup_table();

        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;

        $data_select_privilege = $this->query->select_all($table,$cond,$json_select,$data);
    }

    function check_privilege($json)
    {

        $this->table_set = 'privilege-name';
        $this->setup_table();

        $user               = $json['data']['code'];
        $json_where         = array($user);

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_privilege = $this->query->select_all($table,$cond,$json_where,$data);
        return $data_select_privilege;
    }

     function user_guide()
    {
        @session_start();
        $json_where         = array($_SESSION["rcm_username"]);
        
        $this->table_set    = 'user-specific';
        $this->setup_table();

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_privilege = $this->query->select_all($table,$cond,$json_where,$data);
        return $data_select_privilege[0];
    }
}
?>