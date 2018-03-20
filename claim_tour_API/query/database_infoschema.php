<?php

class database_infoschema
{
	private $servername = "localhost";
	private $username 	= "root";
	private $password 	= "users3cabang";
	private $db 		= "information_schema";
	private $db_view	= "jetwings";
	private $tempProc;
	public  $conn;

	function __construct()
	{
		$this->connect();
	}

	function setDbView($db_view)
	{
		$this->db_view = $db_view;
	}

	function getDbView()
	{
		return $this->db_view;
	}

	function connect()
	{
		try 
		{
			$servername = $this->servername;
			$username 	= $this->username;
			$password 	= $this->password;
			$db 		= $this->db;
		    $this->conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return "<br/>koneksi sukses";
			//return true;
	    }
		catch(PDOException $e)
	    {
	    	return "<br/>Connection failed: " . $e->getMessage();
	    }
	}

	function prepare($query)
	{
		return $this->conn->prepare($query);
	}

	function getCol($table){
		try
		{
			$db_view 	= isset($_SESSION['db_name']) ? $_SESSION['db_name'] : $this->db_view;
			$query 		= "SELECT COLUMN_NAME FROM COLUMNS 
								WHERE TABLE_SCHEMA = '$db_view' AND TABLE_NAME = '$table' AND COLUMN_COMMENT != 'skip'";
			$stmt		= $this->conn->prepare($query);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$fetch_all 	= $stmt->fetchAll(); 

			$result 	= array();
			foreach ($fetch_all as $key => $value) {
				$result[] = $value['COLUMN_NAME'];
			}
			return $result;
		}
		catch(PDOException $e)
		{
			return "<br/>Error: " . $e->getMessage();
		}
	}

	function getColComment($table){
		try
		{
			$db_view 	= $this->db_view;
			$query 		= "SELECT COLUMN_NAME,COLUMN_COMMENT FROM COLUMNS 
								WHERE TABLE_SCHEMA = '$db_view' AND TABLE_NAME = '$table' AND COLUMN_COMMENT != 'skip'";
			$stmt		= $this->conn->prepare($query);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$fetch_all 	= $stmt->fetchAll(); 

			$result 	= array();
			foreach ($fetch_all as $key => $value) {
				$result[$value['COLUMN_NAME']] = $value['COLUMN_COMMENT'];
			}
			return $result;
		}
		catch(PDOException $e)
		{
			return "<br/>Error: " . $e->getMessage();
		}
	}
}
