<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');

class base_notif extends base {

    function __construct()
    {
        parent::__construct();
        $this->query = new query();
    }

    function setup_all_notif()
    {
        $html_data = $this->setup_file_notif();
        $html_count = $this->setup_data_notif($html_data);
        return $html_count;
    }

    function setup_group_notif()
    {
        $html_data      = $this->setup_file_notif();
        $html_specific  = $this->setup_data_notif_category($html_data);
        return $html_specific;
    }

    function setup_file_notif() 
    {
        $json_data              = file_get_contents(__DIR__ .'/../base/data_notif.php');
        $data                   = json_decode($json_data, true);
        return $data;
    }

    function setup_data_notif($data) 
    {
        $datain = 0;

        $html   = array();
        foreach ($data as $key => $value) {
            $table              = $value["table"];
            $cond               = $value["cond"];
            $data               = $value["data"];
            $data_select_detail = $this->query->select_all($table,$cond,'',$data);
            foreach ($data_select_detail as $key_detail => $value_detail) {
                $result   =array();
                $result[] = array(
                    'date_due'          => $value_detail['date_due'],
                    'colour'            => $value['colour'],
                    'icon'              => trim($value['icon']),
                    'module_used'       => trim($value['module_used']),
                    'show_fill'         => $value_detail['show_fill']
                );
                array_push($html, $result[0]);
            }
            $datain += count($data_select_detail);
        }
        $all = array('html' => $html,'count' => $datain);
        return $all;
    }

    function setup_data_notif_category($data) 
    {
        $datain = 0;

        $html   = array();
        foreach ($data as $key => $value) {
            $table              = $value["table"];
            $cond               = $value["cond"];
            $data               = $value["data"];
            $type               = $value["type"];
            $data_select_detail = $this->query->select_all($table,$cond,'',$data);
            $result   =array();
            foreach ($data_select_detail as $key_detail => $value_detail) {
                array_push($result,array(
                    'date_due'          => $value_detail['date_due'],
                    'colour'            => $value['colour'],
                    'icon'              => trim($value['icon']),
                    'module_used'       => trim($value['module_used']),
                    'show_fill'         => $value_detail['show_fill']
                ));
            }
            $html[trim($value['type'])] = $result;
        }
        $all = array('html' => $html,'count' => $datain);
        return $all;
    }
}
?>
