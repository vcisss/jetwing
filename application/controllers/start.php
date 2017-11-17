<?php
class start extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("Loginmodel");
		$this->load->model("profile_model", "profile");
	}
	
	function index()
	{
		if($this->session->userdata('userlevel'))
		{
			$this->load->library('globallib');
			$mylib = new globallib();
			$data['track'] = $mylib->print_track();
			$result = $this->Loginmodel->findNamaLogo();
			$data['namaPT'] = $result->NamaPT;
			$data['logoPT'] = $result->Logo;
			
			
			// profile
			$data["username"] = $this->session->userdata('username');
			$data['bulan'] = $this->session->userdata('bulanaktif');
            $data['tahun'] = $this->session->userdata('tahunaktif');
            
            $thnbln = $data['tahun'] . $data['bulan'];
            
            $cekEmployee = $this->profile->cekEmployee($data["username"]);
            
            if($cekEmployee)
            {
				$data["myprofile"] = $this->profile->getEmployee($data["username"]);	
				$data["employee_id"] = $data["myprofile"]->employee_id;	
			}
			else
			{
				$data["myprofile"] = "";
				$data["employee_id"] = "";	
			}
			
			$this->load->view("indexstart",$data);
		}
		else
		{
		    $result = $this->Loginmodel->findNamaLogo();
			$data['namaPT'] = $result->NamaPT;
			$data['logoPT'] = $result->Logo;
			$data['msg']="";
			$this->load->view('login.php',$data);
		}
	}
}
?>