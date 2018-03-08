<?php
class Optional_tour_agreement extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('report/optional_tour_agreement_model');
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
         
            $data['gouptour'] = $this->optional_tour_agreement_model->getGroupTour();
        
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('report/optional_tour_agreement/views', $data);
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
        $data['tour'] = $this->optional_tour_agreement_model->getTour($data['v_kdtour']);
        $data['template'] = $this->optional_tour_agreement_model->getTemplate('VI');
        $data['guest'] = $data['tour'][0]['guest_sign'];
        $data['tl'] = $data['tour'][0]['tl_sign'];
        $data['judul'] = "Reprot Tour Guide Claim";
        
       $data['headerjenis1'] = $this->optional_tour_agreement_model->getArrayHeaderJenis1(
			$data['v_kdtour']
		);
	
		$data['headerjenis2'] = $this->optional_tour_agreement_model->getArrayHeaderJenis2(
			$data['v_kdtour']
		);
		
		$data['headeroptional'] = $this->optional_tour_agreement_model->getArrayHeaderOptional(
			$data['v_kdtour']
		);
		
		//cari detail opt
		$data['sumheaderoptional'] = $this->optional_tour_agreement_model->getArrayHeaderSumOptional(
			$data['v_kdtour']
		);
				
		$user = $this->session->userdata('username');
		
        $data['gouptour'] = $this->optional_tour_agreement_model->getGroupTour();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
  
		$this->load->view('report/optional_tour_agreement/views', $data);
        
	}
	
	function ajax_group(){
		$KdGroup = $this->input->post('id');
		$query = $this->optional_tour_agreement_model->getGroup($KdGroup);
		 
	 echo "<option value=''> -- Pilih --</option>";
     foreach ($query as $cetak) {
	 echo "<option value=$cetak[KdGroup]>$cetak[NamaGroup]</option>";
	 
	    }
    }
    
    function viewPrint()
    {
        $this->load->library('printreportlib');
        $printlib = new printreportlib();
        
        $tour = $this->uri->segment(4);
        //echo $tour;die;
        
        $data['tour'] = $this->optional_tour_agreement_model->getTour($tour);
        $data['template'] = $this->optional_tour_agreement_model->getTemplate('VI');
        $data['guest'] = $data['tour'][0]['guest_sign'];
        $data['tl'] = $data['tour'][0]['tl_sign'];
        $data['judul'] = "Reprot Tour Guide Claim";
        
        $html = $this->load->view('report/optional_tour_agreement/view_print', $data, true);
        $this->load->library('m_pdf');

        $pdfFilePath = "the_pdf_visitor_information.pdf";
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);

        $pdf->Output();
        exit;
    }
}

?>