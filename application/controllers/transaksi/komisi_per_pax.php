<?php
class Komisi_per_pax extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('transaksi/komisi_per_pax_model');
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
         
            $data['tourguide'] = $this->komisi_per_pax_model->getGroupTour();
        	$data['data'] = $this->komisi_per_pax_model->getData();
        	
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi_per_pax/tabellist', $data);
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
            
            $data['tourleader'] = $this->komisi_per_pax_model->getTourLeader();
            $data['tourguide'] = $this->komisi_per_pax_model->getGroupTour();
            $data['tourdriver'] = $this->komisi_per_pax_model->getTourDriver();
            
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi_per_pax/views', $data);
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
			$data['header']	= $this->komisi_per_pax_model->getdataheader($id);
			$data['detail']	= $this->komisi_per_pax_model->getDetailKomisi($id);
			
            $data['track'] 		= $mylib->print_track();
            $data['tourguide'] = $this->komisi_per_pax_model->getGroupTour();
            
            $this->load->view('transaksi/komisi/edit_form', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }

	function search()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";die;

		$mylib = new globallib();
		
    	$data["username"] = $this->session->userdata('username');
        $data["userlevel"] = $this->session->userdata('userlevel');
  
        $data['v_tgl'] = $this->input->post("v_tgl");        
        $data['v_guide'] = $this->input->post("v_guide");
        
        //untuk id user yang sudah dipilih
        $v_id_user = $this->input->post("v_id_user");
        $pisah_guide = explode("#",$data['v_guide']);
        
        $data['nama_user'] = $pisah_guide[1];
        $data['id_user'] = $pisah_guide[0];
        
        $data['tour_travel'] = $this->input->post("tour_travel");
        $data['nama_tour_travel'] = $this->input->post("nama_tour_travel");
        
        $tanggal = explode("-",$data['v_tgl']);
        $bln = $tanggal[1];
        $thn = $tanggal[2];
        
        $data['flag'] = $this->input->post("flag");
        $data['base_url'] = $this->input->post("base_url");
        $data['btn_excel'] = $this->input->post("btn_excel");
        $save = $this->input->post("btn_save");
        
        
        // detail
        $v_penjualanid1 = $this->input->post('v_penjualanid');
        $v_qty1 = $this->input->post('v_qty');
        $v_harga1 = $this->input->post('v_harga');
        $v_komisi_pers1 = $this->input->post('v_komisi_pers');
        $v_komisi1 = $this->input->post('v_komisi');
        $v_totkomisi = $this->input->post('v_totkomisi');
        
        $data['judul'] = "Komisi";
        
			//guide
			$data['detail_data'] = $this->komisi_per_pax_model->getDataKomisiGuide(
			$pisah_guide[0],$data['tour_travel'],$mylib->ubah_tanggal($data['v_tgl'])
			);
		
		//echo "<pre>";print_r($data['detail_data']);echo "</pre>";die;			
		$user = $this->session->userdata('username');
		
        $data['tourleader'] = $this->komisi_per_pax_model->getTourLeader();
        $data['tourguide'] = $this->komisi_per_pax_model->getGroupTour();
        $data['tourdriver'] = $this->komisi_per_pax_model->getTourDriver();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
		
		// -------------------------------------------------------------------------------------
		if($save=="Save"){
			
		   $v_no_transaksi = $mylib->get_code_counter("jetwings", "komisiguide_header","NoTransaksi", "KG", $bln, $thn);
        	
		   //insert komisiguide_header
		   $data_header = array('NoTransaksi'=>$v_no_transaksi,
						        'Guide_id'=>$v_id_user,
						        'Tanggal'=>$mylib->ubah_tanggal($data['v_tgl']),
						        'Total_Komisi'=>$v_totkomisi,
						        'AddUser'=>$data["username"],
						        'AddDate'=>date('Y-m-d'));
		   $this->db->insert('komisiguide_header',$data_header);
		   
			//insert komisiguide_detail
			for ($x = 0; $x < count($v_penjualanid1); $x++) 
			{
	            $v_penjualanid = $v_penjualanid1[$x]; 	
	            $v_qty = $v_qty1[$x];
	            $v_harga = $v_harga1[$x];
	            $v_komisi_pers = $v_komisi_pers1[$x];
	            $v_komisi = $v_komisi1[$x];
	            
	                   //insert detail
			           $data_detail = array('NoTrans'=>$v_no_transaksi,
									        'PenjualanID'=>$v_penjualanid,
									        'Komisi'=>$v_komisi);
            		   $this->db->insert('komisiguide_detail',$data_detail);
            }
              redirect('transaksi/komisi/');
		}else{
			$this->load->view('transaksi/komisi/hasil_views', $data);
		}
		// -------------------------------------------------------------------------------------       
	}
	
	function save_data()
	{
		print_r($_POST);die;
		
	}
	
	function ajax_guide(){
		$KdGuide = $this->input->post('id');
		$query = $this->komisi_per_pax_model->getGuide($KdGuide);
		 
	 echo "<option value=''> -- Pilih --</option>";
     foreach ($query as $cetak) {
	 echo "<option value=$cetak[Guide_id]#$cetak[Nama]>$cetak[Nama]</option>";
	 
	    }
    }
    
    function ajax_travel(){
		$Guide = $this->input->post('gd');
		$query = $this->komisi_per_pax_model->getTravel($Guide);
	foreach ($query as $cetak) {	 
	 echo "
	 		    <td class='title_table' width='150'>Travel Agent</td>
	            <td>
	            <input readonly type='hidden' class='form-control-new' size='20' name='tour_travel' id='tour_travel' value='$cetak[Tour_id]'> 
	            <input readonly type='text' class='form-control-new' size='20' name='nama_tour_travel' id='nama_tour_travel' value='$cetak[NamaTour]'> 
	            </td>
	 	  ";
     }
    }
    
    function create_pdf() {
        $NoTransaksi = $this->uri->segment(4);
        //echo $NoTransaksi;die;
        
        $getHeader = $this->komisi_per_pax_model->getHeader($NoTransaksi);
        $data['getDetail'] = $this->komisi_per_pax_model->getDetailKomisi($NoTransaksi);
		
		$data['results'] = $getHeader;
        $html = $this->load->view('transaksi/komisi/pdf_komisi', $data, true);
        $this->load->library('m_pdf');

        $pdfFilePath = "the_pdf_komisi.pdf";
        $pdf = $this->m_pdf->load();
        $pdf->WriteHTML($html);

        $pdf->Output();
        exit;
    }
    
    
}

?>