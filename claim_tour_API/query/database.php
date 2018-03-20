<?php

class database
{
	private $servername = "localhost";
	private $username 	= "root";
	private $password 	= "users3cabang";
	private $db 		= "jetwings";
	private $tempProc;
	public  $conn;
	public  $stmt;

	function __construct()
	{
		$this->connect();
	}
	
	function setServer($server)
	{
		$this->servername = $server;
	}

	function getServer()
	{
		return $this->servername;
	}

	function setUser($user)
	{
		$this->username = $user;
	}

	function setPass($pass)
	{
		$this->password = $pass;
	}

	function setDb($db)
	{
		$this->db = $db;
	}

	function getDb()
	{
		return $this->db;
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
	    }
		catch(PDOException $e)
	    {
	    	return "<br/>Connection failed: " . $e->getMessage();
	    }
	}

	function prepare($query)
	{
		$this->stmt = $this->conn->prepare($query);
	}

	function execute(){
		return $this->stmt->execute();
	}

	function lastInsertId($name = NULL) {
	    if(!$this->conn) {
	        throw new Exception('not connected');
	    }

	    return $this->conn->lastInsertId($name);
	}

	function select($query, $json="")
	{	
		try 
		{
			$temp = $this->conn->prepare($query);
			if($json === "")
				$temp->execute();
			else
				$temp->execute($json);
			$temp->setFetchMode(PDO::FETCH_ASSOC);
			return $temp->fetchAll(); 
		}
		catch(PDOException $e)
	    {
	    	$data  = array(
	    					"msg" 		=> "Data failed: " . $e->getMessage(),
	    					"status" 	=> false
	    				);
	    	return $data;
	    }
	}

	function beginTransaction(){
		return $this->conn->beginTransaction();
	}

	function endTransaction(){
		return $this->conn->commit();
	}

	function cancelTransaction(){
		return $this->conn->rollBack();
	}
	
	function bind($param, $value, $type = null){
		if(is_null($type)){
			switch (true){
			  case is_int($value):
			    $type = PDO::PARAM_INT;
			    break;
			  case is_bool($value):
			      $type = PDO::PARAM_BOOL;
			      break;
			  case is_null($value):
			      $type = PDO::PARAM_NULL;
			      break;
			  default:
			      $type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
}
