<?php
class aktivitas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();                           
        $this->load->library('globallib');
        $this->load->model('globalmodel');
		$this->load->model('master/aktivitas_model');
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
			
			$resSearch = "";
			$arr_search["search"]= array();
			$id_search = "";
			if($id*1>0)
			{	
				$resSearch = $this->globalmodel->getSearch($id,"aktivitas",$user);	
				if(count($resSearch)>0){
					$arrSearch = explode("&",$resSearch->query_string);
					
					$id_search = $resSearch->id;
					
					if($id_search)
					{
						$search_keyword = explode("=", $arrSearch[0]); // search keyword
						$arr_search["search"]["keyword"] = $search_keyword[1];
						
						$data["search_keyword"] = $search_keyword[1];
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
				$config['base_url'] = base_url() . 'index.php/master/aktivitas/index/'.$id_search.'/';
	            $config['uri_segment'] = 5;
	            $page = $this->uri->segment(5);
			}
			else
			{
				$config['base_url'] = base_url() . 'index.php/master/aktivitas/index/';
	            $config['uri_segment'] = 4;
	            $page = $this->uri->segment(4);
			}
			
            $config['total_rows'] = $this->aktivitas_model->num_tabel_row($arr_search["search"]);
            $data['data'] = $this->aktivitas_model->getTabelList($config['per_page'], $page, $arr_search["search"]);
            $data['track'] = $mylib->print_track();
            
            $this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
            $this->load->view('master/aktivitas/tabellist', $data);  
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
		$this->db->delete('ci_query', array('module' => 'aktivitas','AddUser' => $user)); 
		
		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		
		$data = array(
            'query_string' => $search_value,
            'module' => "aktivitas",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);
        
		$query_id = $this->db->insert_id();
		
        redirect('/master/aktivitas/index/'.$query_id.'');
		
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
            					'KdAktivitas'=>'Auto Generate',
            					'NamaAktivitas'=>'',
            					'IDR'=>0,
            					'USD'=>0,
            					'RMB'=>0,
            					'Jenis'=>1,
            					'isEdit'=>'T',
            					'Aktif'=>'Y'));
            $user = $this->session->userdata('username');
			
	    	$this->load->view('master/aktivitas/form_add',$data);
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
			$data['header']	= $this->aktivitas_model->getdata($id);
			
            $data['track'] 		= $mylib->print_track();
            
            $this->load->view('master/aktivitas/form_add', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }

    function save_data()
    {
        $mylib = new globallib();
                              
        $kdaktivitas = $this->input->post('v_kdaktivitas');
        $namaaktivitas = $this->input->post('v_namaaktivitas');
        $idr = $this->input->post('v_idr');
        $usd = $this->input->post('v_usd');
        $rmb = $this->input->post('v_rmb');
        $flag = $this->input->post('v_flag');
        $isedit = $this->input->post('v_isedit');
		$status = $this->input->post('v_status');
        $jenis = $this->input->post('v_jenis');
        
        $user = $this->session->userdata('username');
        
        
        if($flag=="Add")
        {
            $kdaktivitas = $this->aktivitas_model->save($namaaktivitas, $idr, $usd, $rmb, $isedit, $status, $jenis, $user);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah aktivias berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->aktivitas_model->update($namaaktivitas, $idr, $usd, $rmb, $isedit, $status, $jenis,$user, $kdaktivitas);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update berhasil','class' => 'success'));
        }
        
       redirect('/master/aktivitas/edit_form/'.$kdaktivitas);
    }
}

?>