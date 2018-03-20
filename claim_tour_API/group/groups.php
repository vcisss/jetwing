<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class groups extends base{
    // begin variable declaration

    private $group_stores;
    private $cond_status    = " AND status = ?";
    protected $table_set    = "group-groups";
    protected $route        = array (
                                        "group-all"                => "group_all"
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

    function group_all($json)
    {
        $where_temp     = $json['data']['kd_tour'];
        $json_select    = array($where_temp);

        $table      = $this->table;
        $cond       = $this->cond;
        $data       = $this->data;
        $result     = $this->query->select_all($table,$cond,$json_select,$data);
        echo json_encode($result);
    }
}
?>
