<?php
class Userpermissionmodel extends CI_Model {
	
    function __construct()
	{
        parent::__construct();
    }

    function getuserpermissionList($id)
	{
    	$sql = "SELECT * FROM userlevelpermissions where userlevelid='$id' order by tablename";
		$sql = "SELECT * FROM userlevelpermissions where userlevelid='$id'
union
select '$id',nama,'T','T','T','T' from menu where nama not in 
(select tablename from userlevelpermissions where userlevelid='$id') and url<>''
order by tablename";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    function getname($id,$tablename){
		$sql = "SELECT tablename FROM userlevelpermissions Where UserLevelID='$id' and tablename='$tablename'";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		$query->free_result();
		return $num;
	}
	function getUserEditPermission($id)
	{
		$sql="select * from userlevelpermissions where tablename= 'User Permissions' and userlevelid='$id';";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
}
?>