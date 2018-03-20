<?php
require_once(__DIR__ ."/database.php");
require_once(__DIR__ ."/database_infoschema.php");

class query {

    	// begin variable declaration
		private $conn;
		private $info;
    	// end variable declaration

		// begin setup
		function __construct($db="none")
		{
			$this->setup();
			if($db != "none"){
				$this->setupDB($db);
				$this->connect();
			}
		}

		private function setup()
		{
			$this->conn = new database;
			$this->info = new database_infoschema;
		}

		function setupDB($db="")
		{
			$this->conn->setDb($db);
			$this->info->setDbView($db);
		}

		function connect()
		{
			$this->conn->connect();
			$this->info->connect();
		}
		// end setup

		// begin cosmetic function
		private function make_str_query_temp($table,$json="",$json_where="")
		{	
			$prepare_tmp=""; $str_query_crud=""; $prepare_where_tmp=""; $str_query_crud_where="";
			$tmp_arr 					= array();
			$tbl_field 					= $this->info->getCol($table); // get field in database

			if($json !== "") {
				$prepare_tmp			= array_keys($json); // get key json data
				$str_query_crud 		= $this->make_array_intersect_to_str($tbl_field, $prepare_tmp); // make string for data
			}
			if($json_where !== "") {
				$prepare_where_tmp		= array_keys($json_where); // get key json data where/condition
				$str_query_crud_where 	= $this->make_array_intersect_to_str($tbl_field, $prepare_where_tmp, " AND "); // make string for where/condition
			}
			$tmp_arr = array(
								"prepare_tmp" 			=> $prepare_tmp,
								"str_query_crud" 		=> $str_query_crud,
								"prepare_where_tmp" 	=> $prepare_where_tmp,
								"str_query_crud_where" 	=> $str_query_crud_where
							);
			return $tmp_arr;
		}
		private function make_str_query_crud($tbl_field,$cond)
		{
			$updquery = array();
			for($i=0;$i<=count($tbl_field)-1;$i++)
			{
				$updquery[] = $tbl_field[$i] . "=:" . $tbl_field[$i];
			}

			$result = implode($cond,$updquery);
			return $result;
		}

		private function make_array_intersect_to_str($arr1,$arr2,$cond=",")
		{
			$arr_temp	= array_intersect($arr1, $arr2);
			$arr_str 	= array();
			foreach ($arr_temp as $value) {
				$arr_str[] = $value;
			}
			$result 	= $this->make_str_query_crud($arr_str,$cond);
			return $result;
		}

		private function type_query($type,$table,$str_query_crud="",$str_query_crud_where="")
		{	
			@session_start();
			$tmp_arr = array();
			switch ($type) {
				case 0: // insert data
					$type_audit = "insert";
					$query 		= "INSERT INTO `$table` SET $str_query_crud";
					break;
				case 1: // update data
					$type_audit = "update";
					$query 		= "UPDATE `$table` SET $str_query_crud WHERE $str_query_crud_where";
					break;
				case 2: // delete data set status 0
					$type_audit = "delete_status_0";
					$query 		= "UPDATE $table SET status = 0, deletedtime = now(), deletedby = '". $_SESSION['rcm_username'] ."', $str_query_crud WHERE $str_query_crud_where";
					break;
				case 3: // delete data permanent
					$type_audit = "delete";
					$query 		= "DELETE FROM $table WHERE $str_query_crud_where";
					break;
			}
			$tmp_arr = array(
								"type_audit" 	=> $type_audit,
								"query" 		=> $query
							);

			return $tmp_arr;
		}
		// end cosmetic function

		//begin main function
		function beginTransaction()
		{
			$this->conn->beginTransaction();
		}

		function endTransaction()
		{
			$this->conn->endTransaction();
		}

		function cancelTransaction()
		{
			$this->conn->cancelTransaction();
		}

		function do_crud($table, $json="", $json_where="", $type=0, $print=0)
		{
			$lastId = ""; $errorLog=""; $query_txt=""; $no_ref=""; $code=""; $user_audit=""; $query=""; $str_query_crud=""; 
			$str_query_crud_where=""; 
			$tmp_query=""; $tmp_str_query=""; $prepare_tmp=""; $prepare_where_tmp="";
			try
			{
				$tmp_str_query 			= $this->make_str_query_temp($table,$json,$json_where);
				$prepare_tmp 			= $tmp_str_query["prepare_tmp"];
				$str_query_crud 		= $tmp_str_query["str_query_crud"];
				$prepare_where_tmp 		= $tmp_str_query["prepare_where_tmp"];
				$str_query_crud_where	= $tmp_str_query["str_query_crud_where"];

				// return array query and type audit suitable to type
				$tmp_query 	= $this->type_query($type,$table,$str_query_crud,$str_query_crud_where);

				$type_audit	= $tmp_query["type_audit"]; // string for type audit
				$query 	   	= $tmp_query["query"]; // string for query
				$this->conn->prepare($query); // prepare query

				if($json !== "") {
					foreach ($prepare_tmp as $val) {
						$this->conn->bind(":$val",$json[$val]); // bind data
						if($val == "KdGroup"){
							$no_ref = $json[$val];
						}
						else if($val == "KdAktivitas"){
							$code 	= $json[$val];
						}
						else if($val == "KdTour"){
							$code 	= $json[$val];
						}
						else if($val == "image_name"){
							$image 	= $json[$val];
						}
						else if($val == "sign_id_set"){
							$no_ref = $json[$val];
						}
						else if($val == "cancel_id_set"){
							$no_ref = $json[$val];
						}
						else if($val == "freeday_id_set"){
							$no_ref = $json[$val];
						}
						else if($val == "opt_id_set"){
							$no_ref = $json[$val];
						}
					}
				}
				if($json_where !== "") {
					foreach ($prepare_where_tmp as $val) {
						$this->conn->bind(":$val",$json_where[$val]); // bind data where/condition
					}
				}
				$this->conn->execute(); // execute query and value after prepare and binding value
				
				$lastId 		=  array(
											"id"	 => $this->conn->lastInsertId(),
											"code"	 => $code,
											"no_ref" => $no_ref,
											"image"  => $image
										);
				if(($lastId['code'] == "" ) && $table == "product_mst"){
					$arr_hasil  = $this->select_all($table, " AND id = ? ", array($this->conn->lastInsertId()));
					$lastId['code'] = $arr_hasil[0]['code'];
				}

				if($type !== 0)
					$lastId 		=  array_merge($lastId,$json_where);

				$errorLog 	= "Success";
			}
			catch(PDOException $e)
			{
				$errorLog 	= "Error: " . $e->getMessage();
			}

			@session_start();
			$data_audit 	= array(
										"type" 		=> $type_audit,
										"table" 	=> $table,
										"query" 	=> $query,
										"data" 		=> $json,
										"data_cond" => $json_where
									);
			if($errorLog === "Success") { $this->audit_trail($data_audit); } // function to insert to auditrail

			if($print === 1) { $query_txt = $query; } // print query decision

			$data 	= array(
								"data" 	=> $lastId,
								"error"	=> $errorLog,
								"query"	=> $query_txt
							);
			return json_encode($data);
		}

		function custQuery($query)
		{
			try
			{
				$this->conn->prepare($query);
				$this->conn->execute();
				return "<br/>Query Executed";
			}
			catch(PDOException $e)
			{
				return "<br/>Error: " . $e->getMessage();
			}
		}

		function select_all($table, $where="", $json="", $field="*", $print=0)
		{
			$query = "select $field from $table where 1=1 $where";
			if($print == 1)
			{
				return array(
								"query" => $query,
								"json"  => $json
							);
			}
			else
			{
				return $this->conn->select($query,$json);
			}
		}

		function select_query($query,$json="")
		{
			return $this->conn->select($query,$json);
		}

		private function audit_trail($json)
		{
			try
			{
				$type 		= $json["type"];
				$table 		= $json["table"];	
				$query 		= $json["query"];	
				$data 		= json_encode($json["data"]);		
				$data_cond 	= json_encode($json["data_cond"]);
				$query 		= "INSERT INTO audit_trail(aud_type,aud_table,aud_query,aud_data,aud_data_cond) 
								VALUES('$type','$table','$query','$data','$data_cond')";
				$this->conn->prepare($query);
				$this->conn->execute();
				return 1;
			}
			catch(PDOException $e)
			{
				return "<br/>Error: " . $e->getMessage();
			}
		}
		//end main function
	}
?>