<?php

class gantipassword extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('globallib');
        $this->load->model('master/usermodel');
        $userid = $this->session->userdata('Id');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    function index() {
        $mylib = new globallib();
        $sign = $mylib->getAllowList("all");
        if ($sign == "Y") {
            //$data['track'] = $mylib->print_track();
            $data['userid'] = $this->session->userdata('Id'); //--------
			$data['username'] = $this->session->userdata('username');
            
            $data['track'] = $mylib->print_track();
            $data['pesan'] = "";
            $this->load->view('master/user/formgantipassword', $data);
        } else {
            $this->load->view('denied');
        }
    }
    
    function save_data()
    {
    	$mylib = new globallib();
    	
        $v_username = $this->input->post('v_username');
        $v_password_lama = $this->input->post('v_password_lama');
        $v_password_baru = $this->input->post('v_password_baru');
        $v_ulang_password_baru = $this->input->post('v_ulang_password_baru');
        
    	$cekAda = $this->usermodel->cekPassword($v_username,$v_password_lama);
    	
        if($v_password_lama=="")
        {
			$this->session->set_flashdata('msg', array('message' => 'Password Lama harus diisi.','class' => 'danger'));	
			redirect('/master/gantipassword/');
		}
		else if($v_password_baru=="")
        {
			$this->session->set_flashdata('msg', array('message' => 'Password Baru harus diisi.','class' => 'danger'));	
			redirect('/master/gantipassword/');
		}
		else if($v_password_baru!=$v_ulang_password_baru)
        {
			$this->session->set_flashdata('msg', array('message' => 'Ulangin Password tidak sama dengan Password Baru','class' => 'danger'));	
			redirect('/master/gantipassword/');
		}
		else if($cekAda)
        {
			$this->session->set_flashdata('msg', array('message' => 'Password Lama tidak ada.','class' => 'danger'));	
			redirect('/master/gantipassword/');
		}
		else
		{
			$validasi = $mylib->validasi_password($v_password_baru, $v_password_lama);
			
			if($validasi["status"]==0)
            {
            	$this->session->set_flashdata('msg', array('message' => $validasi["msg"],'class' => 'danger'));	
				redirect('/master/gantipassword/');
            }
            else if($validasi["status"]==1)
            {
            	$this->usermodel->updatePassword($v_username,$v_password_baru);
            	
            	$this->session->set_flashdata('msg', array('message' => 'Proses update password berhasil, Silahkan Logout dan Login Kembali','class' => 'success'));	
				redirect('/master/gantipassword/');
            }
		}        
    }

    function changePassword() {
        $userid = $this->input->post('userid');
        $passwordlama = md5($this->input->post('passwordlama'));
        $newpassword = md5($this->input->post('newpassword'));

        $this->_set_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('master/user/formgantipassword');
        } else {
            $this->usermodel->updatePassword($userid, $newpassword);
            $data['userid'] = $this->session->userdata('Id'); //--------
            $data['username'] = $this->session->userdata('UserName'); //--------
            $data['pesan'] = "Update Password Berhasil";
            $this->load->view('master/user/formgantipassword', $data);
        }
    }

    function _set_rules() {
        $this->form_validation->set_rules('passwordlama', 'passwordlama', 'trim|required|min_length[4]|callback_pwdlama_check');
        $this->form_validation->set_rules('newpassword', 'passwordbaru', 'trim|required|min_length[4]|matches[konfpassword]|md5');
        $this->form_validation->set_rules('konfpassword', 'konfpassword', 'trim|required');

        $this->form_validation->set_message('required', '<font color=red>* Harus isi</font>');
        $this->form_validation->set_message('min_length', '<font color=red>* Minimal 4 karakter</font>');
        $this->form_validation->set_message('matches', '<font color=red>* Konfirmasi Password tidak sama</font>');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    function pwdlama_check($passwordlama) {
        $userid = $this->input->post('userid');
        $passwordlama = md5($this->input->post('passwordlama'));
        $dtpwdlama = $this->usermodel->get_userid($userid);
        foreach ($dtpwdlama->result() as $value) {
            $pwd = $value->Password;
            if ($pwd != $passwordlama) {
                $this->form_validation->set_message('pwdlama_check', '<font color=red>* Password Lama Anda Salah</font>');
                return FALSE;
            } else {
                return TRUE;
                $passwordlama = "";
            }
        }
//        echo $this->db->last_query();
    }

   

}

?>