<?php 
include(__DIR__ .'/../base/base.php');
include(__DIR__ .'/user_priv.php');
include(__DIR__ .'/user_access.php');
include(__DIR__ .'/user_management.php');
include(__DIR__ .'/user_specific.php');
include(__DIR__ .'/user_forgot.php');

class user extends base{

    private $priv,$management,$access,$user_person;
    protected $route = array (
                                "login"         =>"user_login",
                                "logout"        =>"user_logout",
                                "user_person"   =>"user_get_person",
                                "check_login"   =>"user_check_session",
                                "user_priv"     =>"user_privilege",
                                "user_check"    =>"privilege_check",
                                "get_priv"      =>"get_user_privilege",
                                "first_starter" =>"user_first_menu",
                                "change_pass"   =>"user_change_pass",
                                "user_specific" =>"user_identity",
                                "user_profile"  =>"user_session",
                                "company_data"  =>"get_company_data",
                                "add_det"       =>"detail_add_outlet",
                                "del_det"       =>"detail_add_priv",
                                "forgot"        =>"user_forgot_pass",
                                "guide_status"  =>"user_guide"
                            );
    protected $table_set    = "user-users";

    function __construct()
    {
        parent::__construct();
        $this->setup_table();
        $this->access        = new user_access();
        $this->priv          = new user_priv();
        $this->management    = new user_management();
        $this->specific      = new user_specific();
        $this->forgot        = new user_forgot();
    }

    function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

    //forgot password
    function user_forgot_pass($json)
    {
        $result = $this->forgot->forgot_password($json);
        echo json_encode($result);
    }

    // start section object access function
    function user_login($json)
    {   
        $homeurl     = "";
        $res         = $this->access->login($json);
        if(count($res) > 0){
            $this->__construct();
            $result = array(
                                "username"       => $res[0]["Username"],
                                "user_name"      => $res[0]["NamaTourGuide"],
                                "kd_tour"        => $res[0]["KdTourGuide"],
                                "level"          => $res[0]["Type"],
                                "level_name"     => $res[0]["TypeName"]
                            );
        }
        else{
            $result = 'fail';
        }
        echo json_encode($result);
    }

    function user_logout()
    {   
        $this->access->logout();
    }

    function get_company_data()
    {   
        echo $this->access->get_company_data();
    }

    function user_get_person()
    {
        $this->user_person = $this->access->get_user();
        return $this->user_person;
    }
    // end section object access function

    // start section object privilege function
    private function user_privilege($res)
    {   
        return $this->priv->set_user_privilege($res);
    }

    // start section object privilege function
    function privilege_check($json)
    {   
        echo json_encode($this->priv->check_privilege($json));
    }

    function get_user_privilege($json)
    {   
        return json_encode($this->priv->get_user_privilege($json));
    }

    function user_check_session()
    {   
        $this->priv->check_session();
    }

    function user_guide()
    {   
       echo json_encode($this->priv->user_guide());
    }
    // end section object privilege function

    // start section object management function
    private function user_first_menu()
    {
        return $this->management->menu_starter();
    }

    function user_change_pass($json)
    {
        echo $this->management->change_password($json);
    }
    // end section object management function

    // start section object specific function

    function user_identity($json)
    {
        echo json_encode($this->specific->user_identity($json));
    }

    function user_session($json)
    {
        echo json_encode($this->specific->user_identity_session($json));
    }
    // end section object specific function
}

?>
