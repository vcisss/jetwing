<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class opts extends base{

    // begin variable declaration
    private $opt_stores;
    private $cond_status    = " AND status = ?";
    protected $table_set    = "opt-opts";
    protected $route        = array (
                                        "opt-all"                => "opt_all"
                                    );

    // end variable declaration

    function __construct()
    {
        parent::__construct();
        $this->query = new query();
        $this->setup_table();
    }

    function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

    function opt_all($json)
    {
        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;
        $result     = $this->query->select_all($table,$cond,'',$data);
        echo json_encode($result);
    }
}
?>
