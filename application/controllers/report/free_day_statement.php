<?php
class Free_day_statement extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('report/free_day_statement_model');
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
         
            $data['gouptour'] = $this->free_day_statement_model->getGroupTour();
        
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('report/free_day_statement/views', $data);
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
        $ttd = $this->free_day_statement_model->getTour($data['v_kdtour']);
        $data['template'] = $this->free_day_statement_model->getTemplate('FDS');
        $data['guest'] = $ttd->guest_sign;
        $data['tl'] = $ttd->tl_sign;
        $data['guide'] = $ttd->guide_sign;
        $data['group_code'] = $ttd->group_code;
        
        //echo $ttd->guest_sign."@@@@".$ttd->tl_sign."@@@@".$ttd->guide_signe;die;
        $data['judul'] = "Reprot Tour Guide Claim";
				
		$user = $this->session->userdata('username');
		
        $data['gouptour'] = $this->free_day_statement_model->getGroupTour();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
  
		$this->load->view('report/free_day_statement/views', $data);
        
	}
	
	function ajax_group(){
		$KdGroup = $this->input->post('id');
		$query = $this->free_day_statement_model->getGroup($KdGroup);
		 
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
        $ttd = $this->free_day_statement_model->getTour($tour);
        $data['template'] = $this->free_day_statement_model->getTemplate('FDS');
        $data['guest'] = $ttd->guest_sign;
        $data['tl'] = $ttd->tl_sign;
        $data['guide'] = $ttd->guide_sign;
        $data['group_code'] = $ttd->group_code;
        
        $html = $this->load->view('report/free_day_statement/view_print', $data, true);
        $this->load->library('m_pdf');

        $pdfFilePath = "the_pdf_visitor_information.pdf";
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);

        $pdf->Output();
        exit;
    }
}

?>