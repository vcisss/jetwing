<?php
$this->load->view("header");
$this->session->set_userdata('last_page', current_url());
echo "<b><font color='#FF0000'>Anda Tidak Berhak Mengakses Halaman Ini<br>Silakan <a href='".base_url()."/index.php'>Login</a> Kembali</font></b>";
$this->load->view("footer");
?>