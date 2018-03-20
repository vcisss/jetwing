<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class templates extends base{

    // begin variable declaration
    private $template_stores;
    private $cond_status    = " AND status = ?";
    protected $table_set    = "template-templates";
    protected $route        = array (
                                        "template-all"                => "template_all"
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

    function template_all($json)
    {
        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;
        $result     = $this->query->select_all($table,$cond,'',$data);
        echo json_encode($result);
    }
}

?>
