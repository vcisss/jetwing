<?php 
include_once(__DIR__ .'/../base/base.php');

class users extends base{
    // begin variable declaration

    protected $user_people;
    private $cond_level     = " AND level = ?";
    private $cond_status    = " AND status = ?";
    protected $table_set    = "user-users";
    protected $route        = array (
                                        "user_people_set"        =>"user_set_people",
                                        "user_people_level_set"  =>"user_set_people_by_level",
                                        "user_people_status_set" =>"user_set_people_by_status",
                                        "user_people"            =>"user_get_people"
                                    );

    // end variable declaration

    function __construct()
    {
        parent::__construct();
        $this->setup_table();
    }

    function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

    function user_set_people()
    {
        $cond       = $this->cond;
        $data       = $this->data;
        $result     = $this->select_data($cond, "", $data);
        $this->user_people = $result;
    }

    function user_set_people_by_level($json=[1])
    {
        $cond       = $this->cond_level;
        $data       = $this->data;
        $result     = $this->select_data($cond, $json, $data);
        $this->user_people = $result;
    }

    function user_set_people_by_status($json=[1])
    {
        $cond       = $this->cond_status;
        $data       = $this->data;
        $result     = $this->select_data($cond, $json, $data);
        $this->user_people = $result;
    }

    function user_get_people()
    {
        echo json_encode($this->user_people);
    }
}

?>
