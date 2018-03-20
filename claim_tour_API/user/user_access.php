<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class user_access extends base{
    // begin variable declaration

    private $query;

    // variable for this user
    private $db_name        = "jetwings";
    protected $table_set    = "user-access";
    private $index          = "username";
    private $user_person;

    // declare time timeout
    private $time_total     = 5000000000; // 5000 is 20 seconds

    // end variable declaration

    function __construct() {
        $this->query = new query();
        $this->setup_table();
    }

    function login($json){
        $_SESSION['db_name'] = $this->db_name;
        try {
            $this->__construct();
            $result = $this->tryConnectToDB($json);
        }
        catch (Exception $e) {

            try {
                $this->__construct();
                $result = $this->tryConnectToDB($json);
            }
            catch (Exception $e) {
                $result = 99;
            }
        }

        if($result == 0){ return $result; }
        return $this->login_user($json);
    }

    private function tryConnectToDB($json){
        $this->query->setupDB($this->db_name);
        $this->query->connect();
        return 1;
    }

    private function login_user($json){
        $json_data  = $json['data'];
        $user       = $json_data['username'];
        $pass       = $json_data['password'];
        $json_set   = array($user,$pass);
        $result     = "";
        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;
        $data_tmp   = $this->query->select_all($table, $cond, $json_set, $data);

        return $data_tmp;
    }

    function logout(){
        $this->set_att_logout();
    }

    private function create_array_user($json){
        $table      = $this->table;
        $cond       = $this->cond;
        $data_tmp   = $this->query->select_all($table, $cond, $json, "*");
        $this->user_person = $data_tmp;
    }

    function get_user(){
        return $this->user_person;
    }

    private function timeout(){
        $time                   = $this->time_total;
        $_SESSION['timeout']    = time() + $time;
    }

    private function set_att_logout(){
        $table      = $this->table;
        $index      = $this->index;
        $date       = date('Y-m-d H:i:s');

        $data       = array(
                                "logout_time" => $date
                            );
        $data_where = array(
                                "username"   => $_SESSION['rcm_'.$index]
                            );
        $this->query->do_crud($table, $data, $data_where, 1);
    }

    private function get_client_ip_env(){
        $ipaddress = "";
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}
?>