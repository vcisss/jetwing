<?php
class Loginmodel extends CI_Model {
	
    function __construct(){
       parent::__construct();
    }
	function loginquery($id,$passw){
		$sql = "select count(Id) as counter,Id,UserLevel,UserName,MainPage,Bulan,Tahun from user where UserName='$id' and Password='$passw' group by Id";
		$qry = $this->db->query($sql);
		$num = $qry->row();
		$qry->free_result();
		return $num;
	}
	
	function num_user($id,$passw){
		$sql = "select Id from user where UserName='$id' and Password='$passw' group by Id";
		$qry = $this->db->query($sql);
		$num = $qry->num_rows();
		$qry->free_result();
		return $num;
	}
	function findAddress($name)
	{
		$sql = "select url from menu where nama = '$name'";
		$qry = $this->db->query($sql);
		$num = $qry->row();
		$qry->free_result();
		return $num;
	}
	function findTglGudang()
	{
		$sql = "select TglTrans from aplikasi";
		$qry = $this->db->query($sql);
		$num = $qry->row();
		$qry->free_result();
		return $num;
	}
	function findNamaLogo()
	{
		$sql = "select NamaPT,Logo from aplikasi";
		$qry = $this->db->query($sql);
		$num = $qry->row();
		$qry->free_result();
		return $num;
	}
}
?>