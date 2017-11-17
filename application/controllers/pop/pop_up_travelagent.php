<?php
class Pop_up_travelagent extends CI_Controller
{
	function __construct()
	{
        parent::__construct();
        error_reporting(0);       
		$this->load->library('globallib');
        $this->load->model('globalmodel');
        $this->load->model('pop/pop_up_travelagent_model');
    }

    function index()
	{
        $mylib = new globallib();
        	
		$sid_detail = $this->uri->segment(4);
        $id = $this->uri->segment(5);
		$user = $this->session->userdata('username');
		
		$data["search_keyword"] = "";
		$data["search_group_stk_id"] = "";
		
		$resSearch = "";
		$arr_search["search"]= array();
		$id_search = "";
		if($id*1>0)
		{
			$resSearch = $this->globalmodel->getSearch($id,"pop_up_travelagent",$user);	
			$arrSearch = explode("&",$resSearch->query_string);
			
			$id_search = $resSearch->id;
			if($id_search)
			{
				$search_keyword = explode("=", $arrSearch[0]); // search keyword
				$arr_search["search"]["keyword"] = $search_keyword[1];
				
				$data["search_keyword"] = $search_keyword[1];
			}
		}
		
		// pagingtion
        $this->load->library('pagination');
		$config = array();
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['per_page'] = '100';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['num_links'] = 2;
        
        if($id_search)
		{
			$config['base_url'] = base_url() . 'index.php/pop/pop_up_travelagent/index/'.$sid_detail.'/'.$id_search.'/';
            $config['uri_segment'] = 6;
            $page = $this->uri->segment(6);
		}
		else
		{
			$config['base_url'] = base_url() . 'index.php/pop/pop_up_travelagent/index/'.$sid_detail.'/';
            $config['uri_segment'] = 5;
            $page = $this->uri->segment(5);
		}
		
		$config['total_rows'] = $this->pop_up_travelagent_model->num_travel_row($arr_search["search"]);
        $data['tour'] = $this->pop_up_travelagent_model->getTourList($config['per_page'], $page, $arr_search["search"]);
        $data['group'] = $this->pop_up_travelagent_model->getGroup();
        
        $this->pagination->initialize($config);
        $data["pagination"] = $this->pagination->create_links();
        
        $this->load->view('pop/pop_up_travelagent', $data); 
    }
	
	function search()
	{
        $mylib = new globallib();
        
		$sid_detail = $this->input->post('v_nilai');
		$user = $this->session->userdata('username');
		
		// Delete
		$this->db->delete('ci_query', array('module' => 'pop_up_travelagent','AddUser' => $user)); 
		
		$search_value = "";
		$search_value .= "search_keyword=".$mylib->save_char($this->input->post('search_keyword'));
		
		$data = array(
            'query_string' => $search_value,
            'module' => "pop_up_travelagent",
            'AddUser' => $user
        );
		
        $this->db->insert('ci_query', $data);
        
		$query_id = $this->db->insert_id();
		
        redirect('/pop/pop_up_travelagent/index/'.$sid_detail.'/'.$query_id.'');
	}

}
?>
