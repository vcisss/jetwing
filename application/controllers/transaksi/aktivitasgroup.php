<?php
class Aktivitasgroup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();                           
        $this->load->library('globallib');
        $this->load->model('globalmodel');
		$this->load->model('transaksi/aktivitasgroup_model');
    }

    function index()
    {    
        $mylib = new globallib();
        $sign = $mylib->getAllowList("all");
        
        if ($sign == "Y") 
        {
        	$id = $this->uri->segment(4);	
			$user = $this->session->userdata('username');
			
			$data["search_keyword"] = "";
			$data["v_tgl"] = '';
			
			$resSearch = "";
			$arr_search["search"]= array();
			$id_search = "";
			if($id*1>0)
			{	
				$resSearch = $this->globalmodel->getSearch($id,"group",$user);	
				if(count($resSearch)>0){
					$arrSearch = explode("&",$resSearch->query_string);
					
					$id_search = $resSearch->id;
					if($id_search)
					{
						$search_keyword = explode("=", $arrSearch[0]); // search keyword
						$arr_search["search"]["keyword"] = $search_keyword[1];
						$data["search_keyword"] = $search_keyword[1];
						$search_keyword = explode("=", $arrSearch[1]); // search keyword
						$arr_search["search"]["tanggal"] = $search_keyword[1];
						$data["v_tgl"] = $search_keyword[1];
					}	
				}
			}
			
            // pagination
            $this->load->library('pagination');
            $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
            $config['per_page'] = '10';
            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            $config['num_links'] = 2;
            
            if($id_search)
			{
				$config['base_url'] = base_url() . 'index.php/transaksi/group/index/'.$id_search.'/';
	            $config['uri_segment'] = 5;
	            $page = $this->uri->segment(5);
			}
			else
			{
				$config['base_url'] = base_url() . 'index.php/transaksi/group/index/';
	            $config['uri_segment'] = 4;
	            $page = $this->uri->segment(4);
			}
			
            $config['total_rows'] = $this->aktivitasgroup_model->num_tabel_row($arr_search["search"]);
            $data['data'] = $this->aktivitasgroup_model->getTabelList($config['per_page'], $page, $arr_search["search"]);
            $data['track'] = $mylib->print_track();
            
            $this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
            //$this->load->view('transaksi/aktivitasgroup/tabellist', $data);
            $this->add_new();   
        } 
        else 
        {
            $this->load->view('denied');
        }
    }     

    function search()
    {
        $mylib = new globallib();
        
		$user = $this->session->userdata('username');
		
		// hapus dulu yah
		$this->db->delete('ci_query', array('module' => 'group','AddUser' => $user)); 
		
		$tgl = $mylib->ubah_tanggal($this->input->post('v_tgl'));
		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		$search_value .= "&search_tanggal=".$tgl;
		
		$data = array(
            'query_string' => $search_value,
            'module' => "group",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);
        
		$query_id = $this->db->insert_id();
		
        redirect('/transaksi/group/index/'.$query_id.'');
		
	} 
	
    function add_new()
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("add");
    	if($sign=="Y")
    	{
     		$data['msg']	   	= "";
            
            $data['aktivitas']	= $this->aktivitasgroup_model->getAktivitas();
            			
	    	$this->load->view('transaksi/aktivitasgroup/form_add',$data);
    	}
		else{
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
			$data['header']	= $this->aktivitasgroup_model->getdata($id);
			$data['aktivitas']	= $this->aktivitasgroup_model->getAktivitas();
			
            $data['track'] 		= $mylib->print_track();
            
            $this->load->view('transaksi/group/form_add', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }

    function save_data()
    {
        $mylib = new globallib();
        echo "<pre>";print_r($_POST);echo "</pre>";die;                    
        $kdgroup = $this->input->post('KdGroup');
        $tgl = $this->input->post('v_tgl');
        $activity = $this->input->post('v_aktivitas');
        $pax = $this->input->post('v_pax');
        $idr = $this->input->post('v_idr');
        $usd = $this->input->post('v_usd');
        $rmb = $this->input->post('v_rmb');
        
        $ket = $this->input->post('v_ket');
		
		$flag = $this->input->post('v_flag');
		
        $user = $this->session->userdata('username');
        
        
        if($flag=="Add")
        {
            $kdgroup = $this->aktivitasgroup_model->save($kdgroup, $tgl, $activity, $pax, $idr, $usd, $rmb,  $user, $ket);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah aktivias group berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->aktivitasgroup_model->update($kdgroup, $namagroup, $tglmulai, $tglselesai, $pax, $kdtourguide, $persentaseguide, $user, $ket);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update berhasil','class' => 'success'));
        }
        
       redirect('/transaksi/group/edit_form/'.$kdgroup);
    }
    
    
    function getList()
    {
    	    $KdGroup = $this->input->post('group');
		    $cari = $this->input->post('cr');
		 
            $data['data'] = $this->aktivitasgroup_model->getlistdata($KdGroup, $cari);
			$this->load->view('transaksi/aktivitasgroup/list_history', $data);
	}
	
	function getListCari()
    {
    	    $KdGroup = $this->input->post('group');
		    $aktivitas = $this->input->post('actv');
		 
            $data['data'] = $this->aktivitasgroup_model->getlistdataCari($KdGroup, $aktivitas);
			$this->load->view('transaksi/aktivitasgroup/list_history', $data);
	}
	
	public function ajax_edit($kdgroup,$kdaktivitas) {
        $data = $this->aktivitasgroup_model->getlistDetaildata($kdgroup,$kdaktivitas);
        echo json_encode($data);
    }
	
	function cek_duplicate_aktivitas() 
    {  
    
		 $mylib_ = new globallib();
		 $kdgroup = $this->input->post('group');
		 $aktivitas = $this->input->post('actv');
		 
		 $hasil_cek = $this->aktivitasgroup_model->cekGandaAktivitas($kdgroup,$aktivitas);
		 
			 if($hasil_cek->KdGroup==$kdgroup AND $hasil_cek->KdAktivitas==$aktivitas){
			 $data['status']=TRUE;
			 }else{
			 $data['status']=FALSE;
			 }
		 
		 echo json_encode($data);
	
    }
	
	
	function getPax($kdgroup) 
    {
		$getPax = $this->aktivitasgroup_model->get_Pax($kdgroup);
		
		$data['Pax'] = $getPax->Pax_adult;		
		
		echo json_encode($data);			
    }
	
	function getHarga($aktivitas) 
    {
		$getHarga = $this->aktivitasgroup_model->get_Harga($aktivitas);
		
		if($getHarga->IDR > 0){
			$data['uang'] = "IDR";
			$data['jml'] = $getHarga->IDR;
		}else if($getHarga->USD > 0){
			$data['uang'] = "USD";
			$data['jml'] = $getHarga->USD;
		}else{
			$data['uang'] = "RMB";
			$data['jml'] = $getHarga->RMB;
		}
		
		$data['isEdit'] = $getHarga->isEdit;
		
		echo json_encode($data);			
    }
    
	public function ajax_save_data() {    	
        //$this->_validate();
        //echo "<pre>";print_r($_POST);echo "</pre>";die; 
        $user = $this->session->userdata('username');
        $mylib = new globallib(); 
        
        $kdgroup = $this->input->post('KdGroup');
        $tgl = $this->input->post('v_tgl');
        $activity = $this->input->post('v_aktivitas');
        $pax = $this->input->post('v_pax');
        $idr = $this->input->post('v_idr');
        $usd = $this->input->post('v_usd');
        $rmb = $this->input->post('v_rmb');
        $ket = $this->input->post('v_ket');
		
		$flag = $this->input->post('v_flag');
		
        $user = $this->session->userdata('username');
        
        
        if($flag=="Add")
        {
            $kdgroup = $this->aktivitasgroup_model->save($kdgroup, $tgl, $activity, $pax, $idr, $usd, $rmb,  $user, $ket);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah aktivias group berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->aktivitasgroup_model->update($kdgroup, $tgl, $activity, $pax, $idr, $usd, $rmb,  $user, $ket);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update aktivias group berhasil','class' => 'success'));
        }
        
        echo json_encode(array("status" => TRUE));
    }
    
    function delete_data(){
		$kdgroup = $this->input->post('group');
		$aktivitas = $this->input->post('actv');
		
		$this->db->delete('aktivitasgroup',array('KdGroup'=>$kdgroup,'KdAktivitas'=>$aktivitas));
		
		echo json_encode(array("status" => TRUE));
	}
	
}

?>