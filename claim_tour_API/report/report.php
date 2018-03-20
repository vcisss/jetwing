<?php 
include(__DIR__ .'/../base/base.php');
include(__DIR__ .'/report_main.php');
include(__DIR__ .'/report_optional.php');
require_once(__DIR__ .'/../query/query.php');

class report extends base{

    private $priv,$management,$access,$user_person;
    protected $route = array (
                                "report-header"   =>"header_set",
                                "report-main"     =>"main_set",
                                "report-optional" =>"optional_set"
                            );
    protected $table_set    = "report-report";

    function __construct()
    {
        parent::__construct();
        $this->setup_table();
        $this->main        = new report_main();
        $this->optional    = new report_optional();
        $this->query       = new query();
    }

    function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

    // start section 
    function header_set($json){
        $report             = $json['data']['id'];
        $json_where         = array($report);

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_report = $this->query->select_all($table,$cond,$json_where,$data);
        echo json_encode($data_select_report);
    }

    function main_set($json)
    {
        $result = $this->main->report_data_main($json);
        echo json_encode($result);
    }

    function optional_set($json)
    {
        $result = $this->optional->report_data_optional($json);
        echo json_encode($result);
    }
}

?>
