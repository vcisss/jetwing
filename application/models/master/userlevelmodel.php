<?php
class Userlevelmodel extends CI_Model {
	
    function __construct()
	{
        parent::__construct();
    }

    function getuserlevelList($num, $offset,$id,$with)
	{
	 	if($offset !=''){
			$offset = $offset;
		}            
        else{
        	$offset = 0;
        }
		$clause="";
		if($id!=""){
			$clause = " where $with like '%$id%'";
		}
    	$sql = "SELECT UserLevelID, UserLevelName FROM userlevels $clause order by UserLevelID Limit $offset,$num";
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function num_userlevel_row($id,$with){
     	$clause="";
     	if($id!=''){
			$clause = " where $with like '%$id%'";
		}
		$sql = "SELECT UserLevelID FROM userlevels $clause";
        $qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
	}
    
    function getDetail($id){
    	$sql = "SELECT UserLevelID,UserLevelName from userlevels Where UserLevelID='$id'";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
    }
    
    function get_id($id){
		$sql = "SELECT UserLevelID FROM userlevels Where UserLevelID='$id'";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		$query->free_result();
		return $num;
	}
	
	function getMenu(){
		$sql = "select distinct nama from menu where url!='' order by nama";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		$qry->free_result($sql);
		return $row;
	}
	
	function getAllMenu($id){
		$sql = "select distinct * from menu where UserLevelID='$id' order by nama";
		$qry = $this->db->query($sql);
		$row = $qry->result_array();
		$qry->free_result($sql);
		return $row;
	}
	
	function getUserEditPermission($id)
	{
		$sql="select * from userlevelpermissions where tablename= 'User Permissions' and userlevelid='$id';";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	function cekDelete($id)
	{
		$sql = "SELECT UserLevel FROM user Where UserLevel='$id'";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		$query->free_result();
		return $num;
	}
}
?>