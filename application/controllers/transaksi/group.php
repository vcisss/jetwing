<?php
class Group extends CI_Controller
{
    function __construct()
    {
        parent::__construct();                           
        $this->load->library('globallib');
        $this->load->model('globalmodel');
		$this->load->model('transaksi/group_model');
		$this->load->model('master/tourguide_model');
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
			
            $config['total_rows'] = $this->group_model->num_tabel_row($arr_search["search"]);
            $data['data'] = $this->group_model->getTabelList($config['per_page'], $page, $arr_search["search"]);
            $data['track'] = $mylib->print_track();
			
			$data['otorisasi'] = $this->group_model->getOtorisasi("open_lock_tour",$user);
            
            $this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
            $this->load->view('transaksi/group/tabellist', $data);  
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
     		$data['flag']       = "Add";
            $data['header'] = array(array(
            					'KdGroup'=>'Auto Generate',
            					'NamaGroup'=>'',
            					'TanggalMulai'=>'',
            					'TanggalSelesai'=>'',
            					'Pax_adult'=>'',
            					'Pax_child'=>'',
            					'KdTourGuide'=>'',
            					'PersentaseGuide'=>'',
            					'TipeOptionTour'=>''));
            $data['tourguide'] = $this->group_model->dropdown();
			
	    	$this->load->view('transaksi/group/form_add',$data);
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
			$data['header']	= $this->group_model->getdata($id);
			
            $data['track'] 		= $mylib->print_track();
            $data['tourguide'] = $this->group_model->dropdown();
            
            $this->load->view('transaksi/group/form_add', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }

	function lock_form($id)
    {
		$this->db->update("group_tour",array("Status"=>"2"),array("KdGroup"=>$id));
        redirect('/transaksi/group/'); 
    }
	
	function open_lock($id)
    {
		$this->db->update("group_tour",array("Status"=>"1"),array("KdGroup"=>$id));
        redirect('/transaksi/group/'); 
    }
	
	
    function save_data()
    {
        $mylib = new globallib();
                              
        $kdgroup = $this->input->post('v_kdgroup');
        $namagroup = $this->input->post('v_namagroup');
        $tglmulai = $this->input->post('v_tglmulai');
        $tglselesai = $this->input->post('v_tglselesai');
        $pax_adl = $this->input->post('v_pax_adl');
        $pax_chl = $this->input->post('v_pax_chl');
        $kdtourguide = $this->input->post('v_kdtourguide');
        $tipeoptiontour = $this->input->post('v_tipeoptiontour');
		$persentaseguide = $this->input->post('v_persentaseguide');
		
		$flag = $this->input->post('v_flag');
		
        $user = $this->session->userdata('username');
        
        
        if($flag=="Add")
        {
            $kdgroup = $this->group_model->save($kdgroup, $namagroup, $tglmulai, $tglselesai, $pax_adl, $pax_chl, $kdtourguide, $tipeoptiontour, $persentaseguide, $user);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah aktivias berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->group_model->update($kdgroup, $namagroup, $tglmulai, $tglselesai, $pax_adl, $pax_chl, $kdtourguide, $tipeoptiontour , $persentaseguide, $user);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update berhasil','class' => 'success'));
        }
        
       redirect('/transaksi/group/edit_form/'.$kdgroup);
    }
}

?>