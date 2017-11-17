<?php
class Welcome extends CI_Controller {

	function Welcome()
	{
		parent::__construct();
		$this->load->model("Loginmodel");
	}
	function index()
	{
		
	 	$result = $this->Loginmodel->findNamaLogo();
		$data['namaPT'] = $result->NamaPT;
		$data['logoPT'] = $result->Logo;
		$data['msg']="";
		$this->load->view('login.php',$data);
	}
	function verified()
	{
		//print_r($_POST);die();
		$id = trim($this->input->post('kode'));
    	$passw = md5(trim($this->input->post('nama')));
    	$result = $this->Loginmodel->loginquery($id,$passw);
    	$number = $this->Loginmodel->num_user($id,$passw);

    	if($number==1){
			$main = $this->Loginmodel->findTglGudang();
    	 	//$this->db->update('user', array('Active' =>'Y'), array('Id' => $result->Id));
    	 	$last_page = $this->session->userdata('last_page');
    	 	
    	 	$sessiondata = array(
                   'username'  => $id,
                   'userlevel' => $result->UserLevel,
                   'userid'    => $result->Id,
				   'Tanggal_Trans' => $main->TglTrans,
				   'bulanaktif' => $result->Bulan,
				   'tahunaktif' => $result->Tahun,
				   'last_page' => ''
               );
			$this->session->set_userdata($sessiondata);
			
			$main = $this->Loginmodel->findAddress($result->MainPage);
			$address = explode("/",$main->url);
			$str = "";
			for($s =1;$s<count($address);$s++)
			{
				$str = $str."/".$address[$s];
			}
			$date = date("Y-m-d H:i:s");
			$data = array
			(
				"IDUser"    => $result->Id,
				"DateLogin" => $date
			);
			$this->db->insert("log_user",$data);
			
			//echo $str;die();
			if($last_page!='')
				redirect($last_page);
			else
				redirect($str);
		}
		else{
		    $result = $this->Loginmodel->findNamaLogo();
			$data['namaPT'] = $result->NamaPT;
			$data['logoPT'] = $result->Logo;
		 	$data['id']="";
			$data['msg'] =  "<b>User Name Atau Password Salah</b>";
			$this->load->view("login",$data);
		}
	}
	
	function verified_system($id,$passw)
	{
		//print_r($_POST);die();
		//$id = trim($this->input->post('kode'));
    	//$passw = md5(trim($this->input->post('nama')));
    	$result = $this->Loginmodel->loginquery($id,$passw);
    	$number = $this->Loginmodel->num_user($id,$passw);

    	if($number==1){
			$main = $this->Loginmodel->findTglGudang();
    	 	//$this->db->update('user', array('Active' =>'Y'), array('Id' => $result->Id));
    	 	$last_page = $this->session->userdata('last_page');
    	 	$sessiondata = array(
                   'username'  => $id,
                   'userlevel' => $result->UserLevel,
                   'userid'    => $result->Id,
				   'Tanggal_Trans' => $main->TglTrans,
				   'bulanaktif' => $result->Bulan,
				   'tahunaktif' => $result->Tahun,
				   'last_page' => ''
               );
			$this->session->set_userdata($sessiondata);
			
			$main = $this->Loginmodel->findAddress($result->MainPage);
			$address = explode("/",$main->url);
			$str = "";
			for($s =1;$s<count($address);$s++)
			{
				$str = $str."/".$address[$s];
			}
			$date = date("Y-m-d H:i:s");
			$data = array
			(
				"IDUser"    => $result->Id,
				"DateLogin" => $date
			);
			
			$this->db->insert("log_user",$data);
			//echo $str;die();
			if($last_page!='')
				redirect($last_page);
			else
				redirect($str);
		}
		else{
		    $result = $this->Loginmodel->findNamaLogo();
			$data['namaPT'] = $result->NamaPT;
			$data['logoPT'] = $result->Logo;
		 	$data['id']="";
			$data['msg'] =  "<b>User Name Atau Password Salah</b>";
			$this->load->view("login",$data);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
?>