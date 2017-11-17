<?php

class logout extends CI_Controller {

	function Welcome()
	{
		parent::__construct;		
		
	}
	function index()
	{
		$session_id = $this->session->userdata('userid');
	 	//$this->db->update('user', array('Active' =>'T'), array('Id' => $session_id));
	 	$this->session->sess_destroy();
		redirect("welcome");
	}
}