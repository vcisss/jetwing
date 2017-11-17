<?php
class userlevel extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
        $this->load->model('master/userlevelmodel');   
    }
    
    function index(){
     	$session_level = $this->session->userdata('userlevel');
     	$mylib 	= new globallib();
    	$sign 	= $mylib->getAllowList("all");
    	if($sign=="Y")
		{
		 	$segs 			= $this->uri->segment_array();
  		    $arr 			= "index.php/".$segs[1]."/".$segs[2]."/";
		 	$data['link'] 	= $mylib->restrictLink($arr);
	     	$id 			= $this->input->post('stSearchingKey');
	        $with 			= $this->input->post('searchby');
	        $data['permit']	= $this->userlevelmodel->getUserEditPermission($session_level);
	        $this->load->library('pagination');

	        $config['full_tag_open']  = '<div class="pagination">';
	        $config['full_tag_close'] = '</div>';
	        $config['cur_tag_open']   = '<span class="current">';
	        $config['cur_tag_close']  = '</span>';
	        $config['per_page']       = '20';
	        $config['first_link'] 	  = 'First';
	        $config['last_link'] 	  = 'Last';
	        $config['num_links']  	  = 2;        
			$config['base_url']       = base_url().'index.php/master/userlevel/index/';
			$page					  = $this->uri->segment(4);
			$config['uri_segment']    = 4;
			$with 					  = $this->input->post('searchby');
			$id   					  = "";
			$flag1					  = "";
			if($with!=""){
			 	$id    = $this->input->post('stSearchingKey');
		        if($id!=""&&$with!=""){
					$config['base_url']     = base_url().'index.php/master/userlevel/index/'.$with."/".$id."/";
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
				 	$config['base_url']     = base_url().'index.php/master/userlevel/index/'.$with."/".$id."/";
					$page 					= $this->uri->segment(6);
					$config['uri_segment']  = 6;
				}
			}
//            die();
	        $config['total_rows']     	= $this->userlevelmodel->num_userlevel_row($id,$with);
	        $data['userleveldata']      = $this->userlevelmodel->getuserlevelList($config['per_page'],$page,$id,$with);
            //print_r($config['total_rows'] );die();
//            echo "masuk";
	        $data['track'] = $mylib->print_track();
			$this->pagination->initialize($config);
	        $this->load->view('master/userlevel/viewuserlevellist', $data);
	    }
		else{
			$this->load->view('denied');
		}
    }
    
    function add_new(){
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("add");
    	if($sign=="Y"){
	     	$data['msg']  = "";
	     	$data['id']	  = "";
	     	$data['nama'] = "";
	    	$this->load->view('master/userlevel/adduserlevel',$data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function view_userlevel($id){
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("view");
    	if($sign=="Y"){
	     	$id 					= $this->uri->segment(4);
	    	$data['viewuserlevel'] 	= $this->userlevelmodel->getDetail($id);
	    	$data['edit'] 			= false;
	    	$this->load->view('master/userlevel/viewedituserlevel', $data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function delete_userlevel($id){
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("del");
    	if($sign=="Y"){
	     	$id 					= $this->uri->segment(4);
	    	$data['viewuserlevel'] 	= $this->userlevelmodel->getDetail($id);
			$data['datalain'] = $this->userlevelmodel->CekDelete($id);
	    	$this->load->view('master/userlevel/deleteuserlevel', $data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function delete_This(){
     	$id = $this->input->post('kode');
     	$this->db->delete('userlevelpermissions', array('userlevelid' => $id));
		$this->db->delete('userlevels', array('UserLevelID' => $id));
		$this->db->delete('user', array('UserLevel' => $id));
		redirect('/master/userlevel/');
	}
    
    function edit_userlevel($id){
     	$mylib = new globallib();
    	$sign  = $mylib->getAllowList("edit");
    	if($sign=="Y"){
			$id 					= $this->uri->segment(4);
	    	$data['viewuserlevel'] 	= $this->userlevelmodel->getDetail($id);
	    	$data['edit'] 			= true;
	    	$this->load->view('master/userlevel/viewedituserlevel', $data);
    	}
		else{
			$this->load->view('denied');
		}
    }
    
    function save_userlevel(){
    	$id   = $this->input->post('kode');
    	$nama = strtoupper(trim($this->input->post('nama')));
    	$data = array(
    		  'UserLevelName'	=> $nama,
              'EditDate'		=> $this->session->userdata('Tanggal_Trans')
			);
		$this->db->update('userlevels', $data, array('UserLevelID' => $id));
    	redirect('/master/userlevel/');
    }
    function save_new_userlevel(){
		$id 	= strtoupper(trim($this->input->post('kode')));
    	$nama 	= strtoupper(trim($this->input->post('nama')));
    	$num 	= $this->userlevelmodel->get_id($id); // dibuat defould aja id referensi -1;
//        $num    = '-1';
    	if($num!=0){
			$data['id'] 	= $this->input->post('kode');
			$data['nama']	= $this->input->post('nama');
			$data['msg'] 	= "<font color='red'><b>Error : Data Dengan Kode $id Sudah Ada</b></font>";
			$this->load->view('master/userlevel/adduserlevel', $data);
		}
		else{
		 	$data = array(
               'UserLevelID' 	=> $id ,
               'UserLevelName'	=> $nama ,
               'AddDate' 		=> $this->session->userdata('Tanggal_Trans')
            );
            $this->db->insert('userlevels', $data);
            $menu = $this->userlevelmodel->getMenu();
            for($a=0;$a<count($menu);$a++){
             	unset($dataMenu);
				$dataMenu = array(
	               'userlevelid' => $id ,
	               'tablename' 	 => $menu[$a]['nama']
	            );
	            $this->db->insert('userlevelpermissions', $dataMenu);
			}



//			unset($dataMenu);
//			$dataMenu = array(
//               'userlevelid' => $id ,
//               'tablename' 	 => "User Permissions"
//            );
//            $this->db->insert('userlevelpermissions', $dataMenu);
//			$idlvl  = '-1';
//			$Allmenu = $this->userlevelmodel->getAllMenu($idlvl);
//            for($a=0;$a<count($Allmenu);$a++){
//                unset($dataM);
//                $dataM = array(
//                    'nama'  => $Allmenu[$a]['nama'],
//                    'ulid'  => $Allmenu[$a]['ulid'],
//                    'root'  => $Allmenu[$a]['root'],
//                    'url'   => $Allmenu[$a]['url'],
//                    'urutan'        => $Allmenu[$a]['urutan'],
//                    'FlagAktif'     => $Allmenu[$a]['FlagAktif'],
//                    'UserLevelID'   =>$id,
//                    'icon'          => $Allmenu[$a]['icon'],
//                    'UserLevelID'   => $id
//                );
//                $this->db->insert('menu', $dataM);
//            }
//            die();
			redirect('/master/userlevel/');
		}
	}
}
?>