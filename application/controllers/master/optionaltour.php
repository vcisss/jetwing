<?php
class OptionalTour extends CI_Controller
{
    function __construct()
    {
        parent::__construct();                           
        $this->load->library('globallib');
        $this->load->model('globalmodel');
		$this->load->model('master/optionaltour_model');
		$this->load->model('master/groupoptionaltour_model');
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
				$resSearch = $this->globalmodel->getSearch($id,"optionaltour",$user);	
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
				$config['base_url'] = base_url() . 'index.php/master/optionaltour/index/'.$id_search.'/';
	            $config['uri_segment'] = 5;
	            $page = $this->uri->segment(5);
			}
			else
			{
				$config['base_url'] = base_url() . 'index.php/master/optionaltour/index/';
	            $config['uri_segment'] = 4;
	            $page = $this->uri->segment(4);
			}
			
            $config['total_rows'] = $this->optionaltour_model->num_tabel_row($arr_search["search"]);
            $data['data'] = $this->optionaltour_model->getTabelList($config['per_page'], $page, $arr_search["search"]);
            $data['track'] = $mylib->print_track();
            
            $this->pagination->initialize($config);
            $data["pagination"] = $this->pagination->create_links();
            
            $this->load->view('master/optionaltour/tabellist', $data);  
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
		$this->db->delete('ci_query', array('module' => 'optionaltour','AddUser' => $user)); 
		
		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		
		$data = array(
            'query_string' => $search_value,
            'module' => "optionaltour",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);
        
		$query_id = $this->db->insert_id();
		
        redirect('/master/optionaltour/index/'.$query_id.'');
		
	} 
	
    function add_new()
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("add");
    	if($sign=="Y")
    	{
     		$data['msg']	   	= "";
     		$data['flag']       = "Add";
     		$data['groupoptional'] = $this->groupoptionaltour_model->dropdown();
            $data['header'] = array(array(
            					'KdTour'=>'Auto Generate',
            					'NamaTour'=>'',
            					'KdGroupOptional'=>'',
            					'HargaJualUSD' => 0,
            					'HPP' => 0
            					));			
	    	$this->load->view('master/optionaltour/form_add',$data);
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
			$data['header']	= $this->optionaltour_model->getdata($id);
			$data['groupoptional'] = $this->groupoptionaltour_model->dropdown();
			
            $data['track'] 		= $mylib->print_track();
            
            $this->load->view('master/optionaltour/form_add', $data);
        } 
        else 
        {
            $this->load->view('denied');
        }
    }

    function save_data()
    {
        $mylib = new globallib();
                              
        $kdtour = $this->input->post('v_kdtour');
        $namatour = $this->input->post('v_namatour');
        $kdgroupoptional = $this->input->post('v_kdgroupoptional');
        $hargajualusd = $this->input->post('v_hargajualusd');
        $hpp = $this->input->post('v_hargabeli');
        
        $flag = $this->input->post('v_flag');
        
        $user = $this->session->userdata('username');
        
        
        if($flag=="Add")
        {
            $kdtour = $this->optionaltour_model->save($namatour, $kdgroupoptional, $hargajualusd, $hpp, $user);
       		 
       		$this->session->set_flashdata('msg', array('message' => 'Proses tambah Optional Tour berhasil','class' => 'success'));
       	} 
        else if($flag=="Edit")
        {
        	$this->optionaltour_model->update($namatour, $kdgroupoptional, $hargajualusd, $hpp, $user, $kdtour);
        	
        	$this->session->set_flashdata('msg', array('message' => 'Proses update berhasil','class' => 'success'));
        }
        
       redirect('/master/optionaltour/edit_form/'.$kdtour);
    }
}

?>