<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class user_specific extends base{

    // begin variable declaration
    private $query;
    private $json_product;
    protected $table_set    = "user-specific";

    // variable for management attribute

    function __construct() 
    {
        $this->query = new query();
        $this->setup_table();
    }

    function user_identity($json){
        $user               = $json['data']['code'];
        $json_where         = array($user);

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_user = $this->query->select_all($table,$cond,$json_where,$data);
        return $data_select_user[0];
    }

    function user_identity_session($json){
        @session_start();
        $json_where         = array($_SESSION["rcm_username"]);

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_user = $this->query->select_all($table,$cond,$json_where,$data);
        return $data_select_user[0];
    }
}
?>