<?php

class Usermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getuserList($num, $offset, $id, $with) {
        if ($offset != '') {
            $offset = $offset;
        } else {
            $offset = 0;
        }
        $clause = "";
        if ($id != "") {
            $clause = " where $with like '%$id%'";
        }
        $sql = "
        	SELECT 
			  Id,
			  employee_nik,
			  Name,
			  UserName,
			  UserLevelName,
			  Active 
			FROM
			  (SELECT 
			    Id,
			    employee_nik,
			    Name,
			    UserName,
			    UserLevel,
			    Active 
			  FROM
			    user 
			  $clause
			  ORDER BY Id 
			  LIMIT $offset,$num) AS sub 
			  LEFT JOIN 
			    (SELECT 
			      UserLevelID,
			      UserLevelName 
			    FROM
			      userlevels) AS dive 
			    ON dive.UserLevelID = sub.UserLevel
		";
		
        $qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }

    function num_user_row($id, $with) {
        $clause = "";
        if ($id != '') {
            $clause = " where $with like '%$id%'";
        }
        $sql = "SELECT id FROM user $clause";
        $qry = $this->db->query($sql);
        $num = $qry->num_rows();
        $qry->free_result();
        return $num;
    }

    function getMaster() {
        $sql = "SELECT UserLevelID,UserLevelName from userlevels order by UserLevelID";
        $qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }
    
    function getNik() {
        $sql = "
	        SELECT 
			  employee.employee_nik,
			  employee.employee_name 
			FROM
			  employee 
			  -- LEFT JOIN user 
			    -- ON employee.employee_nik = user.employee_nik 
			WHERE 1 
			  -- AND user.employee_nik IS NULL 
			ORDER BY employee.employee_name ASC
        ";
        $qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }

    function getDetail($id) {
        $sql = "SELECT Id,employee_nik,UserName,UserLevel,MainPage,active from user Where Id='$id'";
        $qry = $this->db->query($sql);
        $row = $qry->row();
        $qry->free_result();
        return $row;
    }

    function get_id($id, $name) {
        $sql = "SELECT Id FROM user Where Id='$id' or UserName='$name'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $query->free_result();
        return $num;
    }

    function getMenu() {
        $sql = "select distinct nama from menu where url!='' and nama!='Logout' and FlagAktif='1' order by nama";
        $qry = $this->db->query($sql);
        $row = $qry->result_array();
        $qry->free_result();
        return $row;
    }

    function cekDelete($id) {
        $sql = "SELECT AddUser FROM trans_ambil_header Where AddUser='$id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $query->free_result();
        return $num;
    }

    //tambahan untuk module ganti password//
    function updatePassword2($userid, $password) {
        //$mdpassword = md5($password);
        $this->db->where('Id', $userid);
        $this->db->update('user', array('Password' => $password, "Active" => "Y", "EditDate" => $this->getNow()));
    }

    function cekdata($namatable, $where) {
        $returnvalue = 0;
        $this->db->select('count(*) as jumlah');
        //$this->db->from($namatable);
        $this->db->where($where);
        $result = $this->db->get($namatable);
        foreach ($result->result() as $row) {
            $returnvalue = $row->jumlah;
        }
        return $returnvalue;
    }

    function getNow() {
        $sql = "SELECT now()";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $v1) {
            foreach ($v1 as $v2) {
                return $v2;
            }
        }
    }
    
    function get_userid($userid){
        return $this->db->query("SELECT Password FROM user WHERE Id ='$userid'");
    }
    
    
    function cekPassword($username,$password_lama)
    {
    	$sql = "
            SELECT
                user.UserName
            FROM
                user
            WHERE
                user.UserName = '".$username."'
                AND user.Password = '".md5($password_lama)."'
            LIMIT 0,1
        ";
        
        $num = $this->NumResult($sql);
        
        if($num*1>0)
        {
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
    
    function updatePassword($username, $password)
    {
    	// tabel employee
    	$this->db->where('username', $username);
        $this->db->update('employee', array('password' => md5($password)));
        
    	// tabel user
    	$this->db->where('UserName', $username);
        $this->db->update('user', array('Password' => md5($password), "Active" => "Y", "EditDate" => $this->getNow()));
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

    /////////////////////////////////////////////
}

?>