<?php
class Komisi_list extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('report/komisi_list_model');
    }

    function index() {
        $mylib = new globallib();
        //$sign = $mylib->getAllowList("all");
		$sign = "Y";
        if ($sign == "Y") 
        {
        	unset($arr_data);
        	
            $bulan = date('m');
            $tahun = date('Y');
            
        	$data["username"] = $this->session->userdata('username');
            $data["userlevel"] = $this->session->userdata('userlevel');
            
			$user = $this->session->userdata('username');
         
            $data['komisilist'] = $this->komisi_list_model->getKomisiList();
        
        	$data['btn_excel'] = "";
        	$data['flag'] = "analisa";
            
            $data['analisa'] = TRUE;
            
            $data['track'] = '';//$mylib->print_track();
            $this->load->view('report/komisi_list/views', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }

	function search_report()
	{
		//print_r($_POST);die;

		$mylib = new globallib();
		
    	$data["username"] = $this->session->userdata('username');
        $data["userlevel"] = $this->session->userdata('userlevel');
       
        $data['v_kdtour'] = $this->input->post("v_kdtour");
        
        $data['flag'] = $this->input->post("flag");
        $data['base_url'] = $this->input->post("base_url");
        $data['btn_excel'] = $this->input->post("btn_excel");
        
        $data['judul'] = "Reprot Komisi List";	
		$user = $this->session->userdata('username');
		
        $data['komisilist'] = $this->komisi_list_model->getKomisiList();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = '';//$mylib->print_track();
  
		$this->load->view('report/komisi_list/views', $data);
        
	}
		
}

?>