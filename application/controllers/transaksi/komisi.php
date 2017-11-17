<?php
class Komisi extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->library('globallib');
        $this->load->library('report_lib');
        $this->load->model('globalmodel');
        $this->load->model('transaksi/komisi_model');
    }

    function index() {
        $mylib = new globallib();
        //$sign = $mylib->getAllowList("all");
		$sign = "Y";
        if ($sign == "Y") 
        {
        	$id = $this->uri->segment(4);
            $user = $this->session->userdata('username');
            
        	$data["search_keyword"] = "";
            $data["search_tanggal"] = "";
        	$resSearch = "";
            $arr_search["search"] = array();
            $id_search = "";
            if ($id * 1 > 0) {
                $resSearch = $this->globalmodel->getSearch($id, "komisi", $user);
                $arrSearch = explode("&", $resSearch->query_string);
				
                $id_search = $resSearch->id;
				//echo $id_search;die;
                if ($id_search) {
                    $search_keyword = explode("=", $arrSearch[0]); // search keyword
                    $arr_search["search"]["keyword"] = $search_keyword[1];
                    $search_tanggal = explode("=", $arrSearch[1]); // search tanggal
                    $arr_search["search"]["tanggal"] = $search_tanggal[1];

                    $data["search_keyword"] = $search_keyword[1];
                    $data["search_tanggal"] = $search_tanggal[1];
                }
            }
            
            
            // pagination
            $this->load->library('pagination');
            $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
            $config['per_page'] = '50';
            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['num_links'] = 2;
 
            if ($id_search) {
                $config['base_url'] = base_url() . 'index.php/transaksi/komisi/index/' . $id_search . '/';
                $config['uri_segment'] = 5;
                $page = $this->uri->segment(5);
            } else {
                $config['base_url'] = base_url() . 'index.php/transaksi/komisi/index/';
                $config['uri_segment'] = 4;
                $page = $this->uri->segment(4);
            }
        	
        	unset($arr_data);
        	
            $bulan = date('m');
            $tahun = date('Y');
            
        	$data["username"] = $this->session->userdata('username');
            $data["userlevel"] = $this->session->userdata('userlevel');
            
			$user = $this->session->userdata('username');
         	
            $data['tourguide'] = $this->komisi_model->getGroupTour();
        	$data['data'] = $this->komisi_model->getData($arr_search["search"]);
        	
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi/tabellist', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }
    
    function cari(){
		//echo "<pre>";print_r($_POST);echo "</pre>";die;
		$mylib = new globallib();
    	
        $user = $this->session->userdata('username');

        // hapus dulu yah
        $this->db->delete('ci_query', array('module' => 'komisi', 'AddUser' => $user));

		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		$search_value .= "&search_tanggal=".$this->input->post('v_tgl');
		
		$data = array(
            'query_string' => $search_value,
            'module' => "komisi",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);

        $query_id = $this->db->insert_id();

        redirect('/transaksi/komisi/index/' . $query_id . '');
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
            
            $data['tourleader'] = $this->komisi_model->getTourLeader();
            $data['tourguide'] = $this->komisi_model->getGroupTour();
            $data['tourdriver'] = $this->komisi_model->getTourDriver();
            
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi/views', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }
    
    function add_new_komisi_tertentu() {
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
            
            $data['tourleader'] = $this->komisi_model->getTourLeader();
            $data['tourguide'] = $this->komisi_model->getGroupTour();
            $data['tourdriver'] = $this->komisi_model->getTourDriver();
            
        	$data['btn_excel'] = "";
        	$data['flag'] = "";
            
            $data['analisa'] = FALSE;
            
            $data['track'] = $mylib->print_track();
            $this->load->view('transaksi/komisi/views_komisi_tertentu', $data);
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
			$data['header']	= $this->komisi_model->getdataheader($id);
			$data['detail']	= $this->komisi_model->getDetailKomisi($id);
			
            $data['track'] 		= $mylib->print_track();
            $data['tourguide'] = $this->komisi_model->getGroupTour();
            
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
        $data['v_leader'] = $this->input->post("v_leader");
        $data['v_driver'] = $this->input->post("v_driver");
        
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
			$data['detail_data'] = $this->komisi_model->getDataKomisiGuide(
			$pisah_guide[0],$data['tour_travel'],$mylib->ubah_tanggal($data['v_tgl'])
			);
		
		//echo "<pre>";print_r($data['detail_data']);echo "</pre>";die;			
		$user = $this->session->userdata('username');
		
        $data['tourleader'] = $this->komisi_model->getTourLeader();
        $data['tourguide'] = $this->komisi_model->getGroupTour();
        $data['tourdriver'] = $this->komisi_model->getTourDriver();
		
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
	
	function search_komisi_tertentu()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";die;

		$mylib = new globallib();
		
    	$data["username"] = $this->session->userdata('username');
        $data["userlevel"] = $this->session->userdata('userlevel');
  
        $data['v_tgl'] = $this->input->post("v_tgl"); 
        $data['v_tipe_user'] = $this->input->post("v_tipe_user");       
        $data['v_guide'] = $this->input->post("v_guide");
        $data['v_leader'] = $this->input->post("v_leader");
        $data['v_driver'] = $this->input->post("v_driver");        
        $data['tour_travel'] = $this->input->post("tour_travel");
        $data['nama_tour_travel'] = $this->input->post("nama_tour_travel");
        
        $v_id_user = $this->input->post("v_id_user"); 
        
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
        $v_totkomisitg1 = $this->input->post('v_totkomisitg');
        $v_totkomisitl1 = $this->input->post('v_totkomisitl');
        $v_totkomisidrv1 = $this->input->post('v_totkomisidrv');
        
        $data['judul'] = "Komisi";
        
        if($data['v_tipe_user']=="1"){
			//leader
			$data['detail_data'] = $this->komisi_model->getDataKomisiLeader($data['v_leader'],$data['tour_travel'],
																		   $mylib->ubah_tanggal($data['v_tgl'])
																		   );
																		   
		    $data['tourleaders'] = $this->komisi_model->getNamaLeader($data['v_leader']);
		    $types = "TL";
		    $v_totkomisi = $v_totkomisitl1;
		    
		}else if($data['v_tipe_user']=="2"){
			//guide
			$data['detail_data'] = $this->komisi_model->getDataKomisiGuide($data['v_guide'],$data['tour_travel'],
																		   $mylib->ubah_tanggal($data['v_tgl'])
																		   );
			$data['tourguides'] = $this->komisi_model->getNamaGuide($data['v_guide']);
			$types = "TG";
			$v_totkomisi = $v_totkomisitg1;
		}else if($data['v_tipe_user']=="3"){
			//driver
			$data['detail_data'] = $this->komisi_model->getDataKomisiDriver($data['v_driver'],$data['tour_travel'],
																		   $mylib->ubah_tanggal($data['v_tgl'])
																		   );
			$data['drivers'] = $this->komisi_model->getNamaDriver($data['v_driver']);
			$types = "DV";
			$v_totkomisi = $v_totkomisidrv1;
		}else{
			$types = "";
		}
			
		
		//echo "<pre>";print_r($data['detail_data']);echo "</pre>";die;			
		$user = $this->session->userdata('username');
		
        $data['tourleader'] = $this->komisi_model->getTourLeader();
        $data['tourguide'] = $this->komisi_model->getGroupTour();
        $data['tourdriver'] = $this->komisi_model->getTourDriver();
		
        $data['analisa'] = TRUE;
			
		$data['track'] = $mylib->print_track();
		
		// -------------------------------------------------------------------------------------
		if($save=="Save"){
			
		   $v_no_transaksi = $mylib->get_code_counter("herbal", "komisiguide_header","NoTransaksi", "KG", $bln, $thn);
        	
		   //insert komisiguide_header
		   $data_header = array('NoTransaksi'=>$v_no_transaksi,
						        'Guide_id'=>$v_id_user,
						        'Tanggal'=>$mylib->ubah_tanggal($data['v_tgl']),
						        'Total_Komisi'=>$v_totkomisi,
						        'AddUser'=>$data["username"],
						        'AddDate'=>date('Y-m-d'),
						        'Type'=>$types);
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
			$this->load->view('transaksi/komisi/hasil_views_komisi_tertentu', $data);
		}
		// -------------------------------------------------------------------------------------       
	}
	
	function save_data()
	{
		print_r($_POST);die;
		
	}
	
	function ajax_guide(){
		$KdGuide = $this->input->post('id');
		$query = $this->komisi_model->getGuide($KdGuide);
		 
	 echo "<option value=''> -- Pilih --</option>";
     foreach ($query as $cetak) {
	 echo "<option value=$cetak[Guide_id]#$cetak[Nama]>$cetak[Nama]</option>";
	 
	    }
    }
    
    function ajax_travel($tipe){
		$jenis = $this->input->post('jns');
		if($tipe=="1"){
			//leader
			$query = $this->komisi_model->getTravel_leader($jenis);	
		}else if($tipe=="2"){
			//guide
			$query = $this->komisi_model->getTravel_guide($jenis);
		}else if($tipe=="3"){
			//driver
			$query = $this->komisi_model->getTravel_driver($jenis);
		}
		
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
        
        $cekJenisKomisi = $this->komisi_model->cekHeader($NoTransaksi);
        $data['tipe_komisi']=$cekJenisKomisi->Type;
        
        $getHeader = $this->komisi_model->getHeader($NoTransaksi);
        $data['getDetail'] = $this->komisi_model->getDetailKomisi($NoTransaksi);
		
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