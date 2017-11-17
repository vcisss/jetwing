<?php

class Globalmodel extends CI_Model {	
    function __construct(){
        parent::__construct();
    }
    
	function getSearch($id,$module,$user)
	{
		$sql = "SELECT * FROM ci_query WHERE id ='$id' AND module='$module' AND AddUser='$user' ";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
    
	function getGudangAdmin($user)
	{
		$sql = "SELECT gudang_admin.KdGudang FROM db_natura.gudang_admin WHERE 1 AND gudang_admin.UserName = '".$user."'";
		$qry 	= $this->db->query($sql);
        return $qry->result_array();
	}

	function getPermission($str,$id)
	{
//        echo $str."||".$id;
		$sql="select * from userlevelpermissions where tablename=(select nama from menu where url='$str' and UserLevelID='$id') and UserLevelID='$id'";

		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function getValidation($menu,$user)
	{
//        echo $str."||".$id;
		$sql="SELECT * FROM `menu_validation` a WHERE a.`user_id`='$user' AND a.`user_form`='$menu'";

		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function getGenereteNumberTicket($sql){
		$sql 	="SELECT ".$sql." ";
        $qry 	= $this->db->query($sql);
        return $qry->result_array();
	}
	function getQuery($sql){
		$sql 	="SELECT ".$sql." ";
        $qry 	= $this->db->query($sql);
        return $qry->result_array();
	}
	function queryInsert($table,$data){
		$this->db->insert($table,$data);
        return true;
	}
	function queryUpdate($table,$data,$where){
		$this->db->where($where);
		$this->db->update($table,$data);
        return true;
	}
	function queryDelete($table,$where){
		$this->db->where($where);
		$this->db->delete($table);
	}
	function getName($url)
	{
		$sql="select distinct nama,root,ulid from menu where url='$url';";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	function getName2($root)
	{
		$sql="select distinct nama,root,ulid from menu where nama='$root';";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	function getRoot($ulid)
	{
		$sql="select distinct nama,root,ulid from menu where ulid='$ulid' and root='1';";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function getLogPrint($nodok,$type="")
	{
		$where_type="";
		if($type)
		{
			$where_type="AND form_data = '".$type."' ";	
		}
		
		$sql = "
			SELECT 
			  log_print.sid
			FROM
			  db_natura.log_print 
			WHERE 1 
			  AND noreferensi = '".$nodok."' 
			  ".$where_type."
		";
		$qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
	}
	
	function getEmail()
	{
		$sql="
			SELECT 
			  email.email_id,
			  email.host,
			  email.port,
			  email.subject,
			  email.email_address,
			  email.password,
			  email.status
			FROM
			  db_natura.email 
			LIMIT 0, 01
		";
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function function_email($menu)
	{
		$sql="
			SELECT
				a.`email_address` AS email,
				a.`email_name` AS employee_name 
			FROM
			    `function_email` a 
			WHERE a.`func_name` = '$menu'
		";
		$qry 	= $this->db->query($sql);
        return $qry->result_array();
	}

}
?>