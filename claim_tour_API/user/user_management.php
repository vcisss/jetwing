<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class user_management extends base{

	// begin variable declaration
    private $query;

    // variable for management attribute
    protected $table_set      = "user-priv";
    public $homeurl; 

    function __construct() 
    {
        $this->setup_user_management();
        $this->setup_table();
    }

    function setup_user_management() 
    {
       	$this->query = new query();
    }

    function change_password($json)
    {
        $query_update = "UPDATE user SET Password = md5('".$json["data"]["new_password"]."') WHERE UserName = '".$json["data"]["username"]."' AND Password = md5('".$json["data"]["old_password"]."')";
        $test = count($this->query->select_all('user', " AND UserName = ? AND Password = md5(?)", array($json["data"]["username"],$json["data"]["old_password"])));
        if ($test > 0) {
            $this->query->custQuery($query_update);
            return 'success';
        }
        else{
            return 'fail';
        }

    }
}
?>
