<?php
class user extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
        $this->load->model('master/usermodel');   
    }
    
    function index()
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("all");
    	if($sign=="Y")
		{
		 	$segs 		  = $this->uri->segment_array();
  		    $arr		  = "index.php/".$segs[1]."/".$segs[2]."/";
		 	$data['link'] = $mylib->restrictLink($arr);
	     	$id 		  = $this->input->post('stSearchingKey');
	        $with 		  = $this->input->post('searchby');
	     	$this->load->library('pagination');

            $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
            $config['per_page'] = '50';
            $config['first_link'] = 'First';
            $config['last_link'] = 'Last';
            
	        $config['num_links']  	  = 2;        
			$config['base_url']       = base_url().'index.php/master/user/index/';
			$page					  = $this->uri->segment(4);
			$config['uri_segment']    = 4;
			$with 					  = $this->input->post('searchby');
			$id   					  = "";
			$flag1					  = "";
			if($with!=""){
			 	$id    = $this->input->post('stSearchingKey');
		        if($id!=""&&$with!=""){
					$config['base_url']     = base_url().'index.php/master/user/index/'.$with."/".$id."/";
					$page 					= $this->uri->segment(6);
					$config['uri_segment']  = 6;
				}
			 	else{
					$page ="";
				}
			}
			else{
				if($this->uri->segment(5)!=""){
					$with 					= $this->uri->segment(4);
				 	$id 					= $this->uri->segment(5);
				 	$config['base_url']     = base_url().'index.php/master/user/index/'.$with."/".$id."/";
					$page 					= $this->uri->segment(6);
					$config['uri_segment']  = 6;
				}
			}
	        $config['total_rows']   = $this->usermodel->num_user_row($id,$with);
	        $data['userdata']    	= $this->usermodel->getuserList($config['per_page'],$page,$id,$with);
	        $data['track'] = $mylib->print_track();
			$this->pagination->initialize($config);
	        $this->load->view('master/user/viewuserlist', $data);
	    }
		else{
			$this->load->view('denied');
		}
    }
    
    function add_new()
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("add");
    	if($sign=="Y"){
	     	$data['msg']	= "";
	     	$data['id']		= "";
	     	$data['nama']	= "";
	     	$data['master'] = $this->usermodel->getMaster();
	     	$data['mnik'] = $this->usermodel->getNik();
	     	$data['master1']= "";
	     	$data['passw']	= "";
			$data['active']	= "";
	     	$data['page'] 	= $this->usermodel->getMenu();
	     	$data['page1']	= "";
	    	$this->load->view('master/user/adduser',$data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function view_user($id)
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("view");
    	if($sign=="Y"){
	     	$id 			  = $this->uri->segment(4);
	    	$data['viewuser'] = $this->usermodel->getDetail($id);
	    	$data['master']   = $this->usermodel->getMaster();
	    	$data['mnik'] 		= $this->usermodel->getNik();
	    	$data['page'] 	  = $this->usermodel->getMenu();
	    	$data['edit'] 	  = false;
    		$this->load->view('master/user/viewedituser', $data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function delete_user($id)
    {
     	/*$mylib = new globallib();
    	$sign  = $mylib->getAllowList("del");
    	if($sign=="Y"){
	     	$id 			  = $this->uri->segment(4);
	    	$data['viewuser'] = $this->usermodel->getDetail($id);
			$data['datalain'] = $this->usermodel->CekDelete($id);
	    	$this->load->view('master/user/deleteuser', $data);
    	}
		else{
			$this->load->view('denied');
		}*/

	$this->db->delete('user', array('Id' => $id));
		redirect('/master/user/');
    }    
    
    function delete_This()
    {
     	$id = $this->input->post('kode');
     	$this->db->delete('user', array('Id' => $id));
		redirect('/master/user/');
	}
    
    function edit_user($id)
    {
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("edit");
    	if($sign=="Y")
    	{
			$id 				= $this->uri->segment(4);
	    	$data['viewuser'] 	= $this->usermodel->getDetail($id);
	    	$data['mnik'] 		= $this->usermodel->getNik();
	    	$data['master'] 	= $this->usermodel->getMaster();
	    	$data['page'] 		= $this->usermodel->getMenu();
	    	$data['edit'] 		= true;
	    	
	    	$this->load->view('master/user/viewedituser', $data);
    	}
		else
		{
			$this->load->view('denied');
		}
    }
    
    function save_user()
    {
    	/*echo "<pre>";
    	print_r($_POST);
    	echo "</pre>";
    	die();*/
    	
    	$id 	 = $this->input->post('kode');
    	$v_userlevel = $this->input->post('v_userlevel');
    	//$v_employee_nik = $this->input->post('v_employee_nik');
		$v_employee_nik='-';
		$name 	 = trim($this->input->post('guidename'));
    	$nama 	 = trim($this->input->post('nama'));
    	//$page1 	 = $this->input->post('mainpage');
		$page1 	 ="HOME";
    	//$master1 = strtoupper(trim($this->input->post('master')));
		$master1 =trim($this->input->post('leveluser'));
		$active  = $this->input->post('statactive');
    	$data = array(
    		  'UserLevel'	=> $v_userlevel,
    		  'employee_nik'	=> $v_employee_nik,
    		  'Name'	=> $name,
    		  'UserName'	=> $nama,
    		  'UserLevel'	=> $master1,
    		  'MainPage'	=> $page1,
			  'Active'	=> $active,
              'EditDate'	=> $this->session->userdata('Tanggal_Trans')
			);
		$this->db->update('user', $data, array('Id' => $id));
    	redirect('/master/user/');
    }

    function save_new_user(){
		$id 	 = trim($this->input->post('kode'));
		$v_employee_nik='-';
    	//$v_employee_nik = $this->input->post('v_employee_nik');
    	$name 	 = trim($this->input->post('guidename'));
    	$nama 	 = trim($this->input->post('nama'));
    	//$master1 = strtoupper(trim($this->input->post('master')));
		$master1 =trim($this->input->post('leveluser'));
    	//$passw 	 = md5(trim($this->input->post('passw')));
		$passw 	 = md5(trim('123456'));
    	$page1 	 = $this->input->post('mainpage');
		$page1 	 ="HOME";
		$active  = $this->input->post('statactive');
    	$num 	 = $this->usermodel->get_id($id,$nama);
    	if($num == 0)
		{
		 	$data = array(
               'Id' 		=> $id ,
    	       'employee_nik'	=> $v_employee_nik,
    	       'Name' 	=> $name,
               'UserName' 	=> $nama ,
               'UserLevel' 	=> $master1 ,
               'Password' 	=> $passw,
               'MainPage' 	=> $page1,
			   'Active'	=> $active,
               'AddDate' 	=> $this->session->userdata('Tanggal_Trans')
            );
            
            $this->db->insert('user', $data);
			redirect('master/user');
		}
		else
		{
			$data['id'] 	 = $this->input->post('kode');
			$data['nama'] 	 = $this->input->post('nama');
			$data['NIK'] 	 = '-';
			$data['master']  = $this->usermodel->getMaster();
			$data['page'] 	 = $this->usermodel->getMenu();
			$data['master1'] = '-1';
			$data['passw'] 	 = $this->input->post('passw');
			$data['page1'] 	 = $page1;
			$data['active']  = $active;
			$data['msg'] 	 = "<font color='red'><b>Error : Data Dengan Kode $id Sudah Ada</b></font>";			
			$this->load->view('master/user/adduser', $data);
		}
	}
}
?>
