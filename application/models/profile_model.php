<?php
class Profile_model extends CI_Model {
	
    function __construct(){
        parent::__construct();
        $this->load->library('globallib');
    }
    
    function cekEmployee($username)
    {
		$sql = "SELECT * FROM employee WHERE 1 AND username ='$username' LIMIT 1 ";	
		$num = $this->NumResult($sql);
		
		if($num*1>0)
		{
			return TRUE;	
		}
		else
		{
			return FALSE;
		}
		
	}
    
	function getEmployee($username)
	{
		$sql = "SELECT * FROM employee WHERE 1 AND username ='$username' LIMIT 1 ";
		
        return $this->getRow($sql);	
	}

	function getDate()
	{
    	$sql = "SELECT date_format(TglTrans,'%d-%m-%Y') as TglTrans from aplikasi";
        return $this->getRow($sql);
    }

	function locktables($table)
	{
		$this->db->simple_query("LOCK TABLES $table");
	}

	function unlocktables()
	{
		$this->db->simple_query("UNLOCK TABLES");
	}
	
	function getRow($sql)
	{
		$qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
	}
	
	function getArrayResult($sql)
	{
		$qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
	}
	
	function NumResult($sql)
	{
		$qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
	}
}
?>