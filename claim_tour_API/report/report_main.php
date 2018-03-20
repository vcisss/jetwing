<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class report_main extends base{

    // begin variable declaration
    private $query;
    private $json_product;
    protected $table_set    = "report-main";

    // variable for management attribute

    function __construct() 
    {
        $this->query = new query();
        $this->setup_table();
    }

    function report_data_main($json){
        $report             = $json['data']['id'];
        $type               = $json['data']['type'];
        $json_where         = array($report,$type);

        $table              = $this->table;
        $cond               = $this->cond;
        $data               = $this->data;

        $data_select_report = $this->query->select_all($table,$cond,$json_where,$data);
        return $data_select_report;
    }
}
?>