<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class photo_order extends base{
    // begin variable declaration

    private $product_stores;
    private $cond_status    = "";
    protected $table_set    = "sales-photo-order";
    protected $route        = array (
                                        "Photo-order"   =>  "photo_order_set"
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

    function photo_order_set($json)
    {
        $json_result    = array();
        
        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;
        $result     = $this->query->select_all($table,$cond,'',$data);
        echo json_encode($result);
    }
}
?>
