<?php
class userpermission extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
        $this->load->model('master/userpermissionmodel');
    }

    function permission_list()
	{

	 	//$session_level 	= $this->session->userdata('userlevel');
	 	//$permit			= $this->userpermissionmodel->getUserEditPermission($session_level,"all");
	 	//if($permit->view=="Y"||$permit->edit=="Y"||$permit->delete=="Y"||$permit->add=="Y")
		//{
		 	$id 						= $this->uri->segment(4);
			$data['userpermissiondata'] = $this->userpermissionmodel->getuserpermissionList($id);
			$data['cekaddAll'] 	= "";
			$data['cekeditAll'] = "";
			$data['cekdelAll']	= "";
			$data['cekviewAll']	= "";
			$data['id']	 =  $id;
			$data['track'] = "";
	        $this->load->view('master/userpermission/viewuserpermission', $data);
        //}
    	//else
    	//{
			//$this->load->view('denied');
		//}
    }

    function save_permission(){
	    $add    = $this->input->post('add');
    	$edit   = $this->input->post('edit');
    	$del    = $this->input->post('del');
        $view 	= $this->input->post('view');
    	$id 	= $this->input->post('id');

        $db = array(
            'add'=>'T',
            'edit'=>'T',
            'delete'=>'T',
            'view'=>'T'
            );
		$this->db->update('userlevelpermissions', $db, array('userlevelid'=>$id));
        $this->db->update('menu', array('FlagAktif' =>'1'), array('userlevelid'=>$id));
        $this->db->set('FlagAktif', '0');
        $this->db->where('UserLevelID', $id);
        $this->db->where("(root <> '1' OR url <> '')", NULL, FALSE);
        $this->db->update('menu'); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2

//		$this->db->update('menu', array('FlagAktif' =>'0'), "'UserLevelID'=>$id and ('root' <> '1' OR 'url' != '')"));

//		$this->db->update('userlevelpermissions', array( ),  array('userlevelid'=>$id));
//		$this->db->update('userlevelpermissions', array(' ),  array('userlevelid'=>$id));
//		$this->db->update('userlevelpermissions', array( ),  array('userlevelid'=>$id));
		for($a=0;$a<count($add);$a++){
		    $num 	= $this->userpermissionmodel->getname($id,$add[$a]);
			if($num!=0){
			   $this->db->update('userlevelpermissions', array('add'=>'Y' ),  array('tablename' => $add[$a],'userlevelid'=>$id));
			   $this->db->update('menu', array('FlagAktif'=>'1' ),  array('nama' => $add[$a],'UserLevelID'=>$id));
			}
			else
			{  
			   $this->db->insert('userlevelpermissions', array('userlevelid'=>$id, 'tablename' => $add[$a], 'add'=>'Y','edit'=>'T','delete'=>'T','view'=>'T'));
			}
		}
		for($a=0;$a<count($edit);$a++){
		    $num 	= $this->userpermissionmodel->getname($id,$edit[$a]);
			if($num!=0){
			    $this->db->update('userlevelpermissions', array('edit'=>'Y' ),  array('tablename' => $edit[$a],'userlevelid'=>$id));
                $this->db->update('menu', array('FlagAktif'=>'1' ),  array('nama' => $add[$a],'UserLevelID'=>$id));
			}
			else
			{  
			   $this->db->insert('userlevelpermissions', array('userlevelid'=>$id, 'tablename' => $edit[$a], 'add'=>'T','edit'=>'Y','delete'=>'T','view'=>'T'));
			}
		}
		for($a=0;$a<count($del);$a++){
		    $num 	= $this->userpermissionmodel->getname($id,$del[$a]);
			if($num!=0){
			    $this->db->update('userlevelpermissions', array('delete'=>'Y' ),  array('tablename' => $del[$a],'userlevelid'=>$id));
                $this->db->update('menu', array('FlagAktif'=>'1' ),  array('nama' => $add[$a],'UserLevelID'=>$id));
			}
			else
			{  
			   $this->db->insert('userlevelpermissions', array('userlevelid'=>$id, 'tablename' => $del[$a], 'add'=>'T','edit'=>'T','delete'=>'Y','view'=>'T'));
			}
		}
		for($a=0;$a<count($view);$a++){
			$num 	= $this->userpermissionmodel->getname($id,$view[$a]);
			if($num!=0){
				$this->db->update('userlevelpermissions', array('view'=>'Y' ),  array('tablename' => $view[$a],'userlevelid'=>$id));
                $this->db->update('menu', array('FlagAktif'=>'1' ),  array('nama' => $add[$a],'UserLevelID'=>$id));
			}
			else
			{  
			   $this->db->insert('userlevelpermissions', array('userlevelid'=>$id, 'tablename' => $view[$a], 'add'=>'T','edit'=>'T','delete'=>'T','view'=>'Y'));
			}
		}
		redirect("/master/userlevel/");
    }
}
?>