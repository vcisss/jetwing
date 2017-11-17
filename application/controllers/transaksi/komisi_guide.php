<?php
class Komisi_guide extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('transaksi/komisi_guide_model');
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
         
            $data['tourguide'] = $this->komisi_guide_model->getGroupTour();
        	$data['data'] = $this->komisi_guide_model->getData();
        	
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi_guide/tabellist', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }
    
    function add_new() {
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
         
            $data['tourguide'] = $this->komisi_guide_model->getGroupTour();
        
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi_guide/views', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }
    
    function edit_form($id)
    {
        $mylib = new globallib();
        $sign = $mylib->getAllowList("edit");
        if ($sign == "Y") {
            $id = $this->uri->segment(4);
            
			$user = $this->session->userdata('username');
            
            $data['flag'] = 'Edit';
			$data['header']	= $this->komisi_guide_model->getdataheader($id);
			$data['detail']	= $this->komisi_guide_model->getDetailKomisi($id);
			
            $data['track'] 		= $mylib->print_track();
            $data['tourguide'] = $this->komisi_guide_model->getGroupTour();
            
            $this->load->view('transaksi/komisi_guide/edit_form', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }

	function search_guide()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";die;

		$mylib = new globallib();
		
    	$data["username"] = $this->session->userdata('username');
        $data["userlevel"] = $this->session->userdata('userlevel');
       
        $data['v_guide'] = $this->input->post("v_guide");
        $data['v_tgl'] = $this->input->post("v_tgl");
        
        $tanggal = explode("-",$data['v_tgl']);
        $bln = $tanggal[1];
        $thn = $tanggal[2];
        
        $data['flag'] = $this->input->post("flag");
        $data['base_url'] = $this->input->post("base_url");
        $data['btn_excel'] = $this->input->post("btn_excel");
        $save = $this->input->post("btn_save");
        
        
        // detail
        $v_penjualanid1 = $this->input->post('v_penjualanid');
        $v_struk1 = $this->input->post('v_struk');
        $v_qty1 = $this->input->post('v_qty');
        $v_harga1 = $this->input->post('v_harga');
        $v_komisi_guide1 = $this->input->post('v_komisi_guide');
        $v_komisi1 = $this->input->post('v_komisi');
        
        $v_totkomisi = $this->input->post('v_totkomisi');
        
        
        if($save=="Save"){
        	
        	$v_no_transaksi = $mylib->get_code_counter("jetwings", "komisiguide_header","NoTransaksi", "KG", $bln, $thn);
        	
		   //insert komisiguide_header
		   $data_header = array('NoTransaksi'=>$v_no_transaksi,
						        'PelangganID'=>$data['v_guide'],
						        'Tanggal'=>$mylib->ubah_tanggal($data['v_tgl']),
						        'Total_Komisi'=>$v_totkomisi,
						        'AddUser'=>$data["username"],
						        'AddDate'=>date('Y-m-d'));
		   $this->db->insert('komisiguide_header',$data_header);
		   
			//insert komisiguide_detail
			for ($x = 0; $x < count($v_penjualanid1); $x++) 
			{
	            $v_penjualanid = $v_penjualanid1[$x];    
	            $v_struk = $v_struk1[$x];	
	            $v_qty = $v_qty1[$x];
	            $v_harga = $v_harga1[$x];
	            $v_komisi_guide = $v_komisi_guide1[$x];
	            $v_komisi = $v_komisi1[$x];
	            
	                   //insert detail
			           $data_detail = array('NoTrans'=>$v_no_transaksi,
									        'PenjualanID'=>$v_penjualanid,
									        'Komisi'=>$v_komisi_guide);
            		   $this->db->insert('komisiguide_detail',$data_detail);
            }
            
		}
        
        $data['judul'] = "Komisi Guide";
        
        
        
        $data['detail_data'] = $this->komisi_guide_model->getDataKomisi(
			$data['v_guide'],$mylib->ubah_tanggal($data['v_tgl'])
		);
		//echo "<pre>";print_r($data['detail_data']);echo "</pre>";die;			
		$user = $this->session->userdata('username');
		
        $data['tourguide'] = $this->komisi_guide_model->getGroupTour();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
		
		
		if($save=="Save"){
			
		   $v_no_transaksi = $mylib->get_code_counter("jetwings", "komisiguide_header","NoTransaksi", "KG", $bln, $thn);
        	
		   //insert komisiguide_header
		   $data_header = array('NoTransaksi'=>$v_no_transaksi,
						        'PelangganID'=>$data['v_guide'],
						        'Tanggal'=>$mylib->ubah_tanggal($data['v_tgl']),
						        'Total_Komisi'=>$v_totkomisi,
						        'AddUser'=>$data["username"],
						        'AddDate'=>date('Y-m-d'));
		   $this->db->insert('komisiguide_header',$data_header);
		   
			//insert komisiguide_detail
			for ($x = 0; $x < count($v_penjualanid1); $x++) 
			{
	            $v_penjualanid = $v_penjualanid1[$x];    
	            $v_struk = $v_struk1[$x];	
	            $v_qty = $v_qty1[$x];
	            $v_harga = $v_harga1[$x];
	            $v_komisi_guide = $v_komisi_guide1[$x];
	            $v_komisi = $v_komisi1[$x];
	            
	                   //insert detail
			           $data_detail = array('NoTrans'=>$v_no_transaksi,
									        'PenjualanID'=>$v_penjualanid,
									        'Komisi'=>$v_komisi);
            		   $this->db->insert('komisiguide_detail',$data_detail);
            }
              redirect('transaksi/komisi_guide/');
		}else{
			$this->load->view('transaksi/komisi_guide/views', $data);
		}
		        
	}
	
	function save_data()
	{
		print_r($_POST);die;
		
	}
	
	function ajax_guide(){
		$KdGuide = $this->input->post('id');
		$query = $this->komisi_guide_model->getGuide($KdGuide);
		 
	 //echo "<option value=''> -- Pilih --</option>";
     foreach ($query as $cetak) {
	 echo "<option value=$cetak[KdTourGuide]>$cetak[NamaTourGuide]</option>";
	 
	    }
    }
    
    function create_pdf() {
        $NoTransaksi = $this->uri->segment(4);
        //echo $NoTransaksi;die;
        
        $getHeader = $this->komisi_guide_model->getHeader($NoTransaksi);
        $data['getDetail'] = $this->komisi_guide_model->getDetailKomisi($NoTransaksi);
		
		$data['results'] = $getHeader;
        $html = $this->load->view('transaksi/komisi_guide/pdf_komisi_guide', $data, true);
        $this->load->library('m_pdf');

        $pdfFilePath = "the_pdf_komisi.pdf";
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);

        $pdf->Output();
        exit;
    }
    
    
}

?>