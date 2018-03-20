<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/notif-base.php');
require_once(__DIR__ .'/../base/base.php');

class notif extends base{

    protected $route        = array (
                                        "notif_get"  => "check_notification",
                                        "notif_spec" => "specific_notification",
                                    );

    function __construct()
    {
        parent::__construct();
        $this->query        = new query();
        $this->base_notif   = new base_notif();
    }

    function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

    function check_notification()
    {
        $data_notif = $this->base_notif->setup_all_notif();
        echo json_encode($data_notif);
    }

    function specific_notification()
    {
        $data_notif = $this->base_notif->setup_group_notif();
        echo json_encode($data_notif);
    }
}
?>
