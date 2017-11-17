<?php
class Tour_guide_claim extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('report/tour_guide_claim_model');
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
         
            $data['gouptour'] = $this->tour_guide_claim_model->getGroupTour();
        
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('report/tour_guide_claim/views', $data);
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
        
        $data['judul'] = "Reprot Tour Guide Claim";
        
       $data['headerjenis1'] = $this->tour_guide_claim_model->getArrayHeaderJenis1(
			$data['v_kdtour']
		);
	
		$data['headerjenis2'] = $this->tour_guide_claim_model->getArrayHeaderJenis2(
			$data['v_kdtour']
		);
		
		$data['headeroptional'] = $this->tour_guide_claim_model->getArrayHeaderOptional(
			$data['v_kdtour']
		);
		
		//cari detail opt
		$data['sumheaderoptional'] = $this->tour_guide_claim_model->getArrayHeaderSumOptional(
			$data['v_kdtour']
		);
				
		$user = $this->session->userdata('username');
		
        $data['gouptour'] = $this->tour_guide_claim_model->getGroupTour();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
  
		$this->load->view('report/tour_guide_claim/views', $data);
        
	}
	
	function ajax_group(){
		$KdGroup = $this->input->post('id');
		$query = $this->tour_guide_claim_model->getGroup($KdGroup);
		 
	 echo "<option value=''> -- Pilih --</option>";
     foreach ($query as $cetak) {
	 echo "<option value=$cetak[KdGroup]>$cetak[NamaGroup]</option>";
	 
	    }
    }
}

?>