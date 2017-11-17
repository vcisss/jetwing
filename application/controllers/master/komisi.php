<?php
class Komisi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();                           
        $this->load->library('globallib');
        $this->load->model('globalmodel');
		$this->load->model('master/komisi_model');
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
				$resSearch = $this->globalmodel->getSearch($id,"tourguide",$user);	
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
				$config['base_url'] = base_url() . 'index.php/master/tourguide/index/'.$id_search.'/';
	            $config['uri_segment'] = 5;
	            $page = $this->uri->segment(5);
			}
			else
			{
				$config['base_url'] = base_url() . 'index.php/master/tourguide/index/';
	            $config['uri_segment'] = 4;
	            $page = $this->uri->segment(4);
			}
			
            $config['total_rows'] = $this->komisi_model->num_tabel_row($arr_search["search"]);
            $data['data'] = $this->komisi_model->getTabelList($config['per_page'], $page, $arr_search["search"]);
            $data['track'] = $mylib->print_track();
            
            $this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
            $this->load->view('master/komisi/tabellist', $data);  
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
		$this->db->delete('ci_query', array('module' => 'tourguide','AddUser' => $user)); 
		
		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		
		$data = array(
            'query_string' => $search_value,
            'module' => "tourguide",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);
        
		$query_id = $this->db->insert_id();
		
        redirect('/master/tourguide/index/'.$query_id.'');
		
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
            					'GroupID'=>'',
            					'Nama'=>'',
            					'Komisi_Office'=>'',
            					'Komisi_TG'=>'',
            					'Komisi_TL'=>'',
            					'Komisi_Drv'=>''));
            								
	    	$this->load->view('master/komisi/form_add',$data);
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
            
            $data['flag'] = 'Edit';
			$data['header']	= $this->komisi_model->getdata($id);
			
            $data['track'] 		= $mylib->print_track();
            
            $this->load->view('master/komisi/form_add', $data);

        } 
        else 
        {
            $this->load->view('denied');
        }
    }
    
    function delete_data($id)
    {
    		$this->db->delete('komisi',array('GroupID'=>$id));
    		$this->session->set_flashdata('msg', array('message' => 'Proses Delete Data berhasil','class' => 'success'));
            redirect('/master/komisi/');

    }

    function save_data()
    {
        $mylib = new globallib();
        //echo "<pre>";print_r($_POST);echo "</pre>";die;                     
        $groupid = $this->input->post('v_groupid');
        $komisi_office = $this->input->post('v_komisi_office');
        $komisi_drv = $this->input->post('v_komisi_drv');
        $komisi_tl = $this->input->post('v_komisi_tl');
        $komisi_tg = $this->input->post('v_komisi_tg');
        
        $flag = $this->input->post('v_flag');
        
        $user = $this->session->userdata('username');
        
        if($flag=="Add")
        {
            $kdtourguide = $this->komisi_model->save($groupid, $komisi_office, $komisi_drv, $komisi_tl, $komisi_tg, $user);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah Komisi berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->komisi_model->update($groupid, $komisi_office, $komisi_drv, $komisi_tl, $komisi_tg, $user);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update berhasil','class' => 'success'));
        }
        
       redirect('/master/komisi/edit_form/'.$groupid);
    }
}

?>