<?php
require_once(__DIR__ .'/../query/query.php');

class base_autonumber{

	private $arr_tmp;
	private $qry;

	function __construct()
	{
        $this->qry      = new query();
	}

	private function get_attr_number($json=""){
        $json_data 		= file_get_contents(__DIR__ .'/data_autonumber.php');
		$tmp 		 	= json_decode($json_data, true);
		$this->arr_tmp 	= $tmp[$json];
	}

	private function get_run_number($json=""){
		$table 			= $this->arr_tmp["table"];
		$cond 			= $this->arr_tmp["cond"];
		$autonumber 	= $this->arr_tmp["autonumber"];
		$print 			= isset($this->arr_tmp["print"]) ? $this->arr_tmp["print"] : 0;

        $data_array 	= $this->qry->select_all($table, $cond, $json, $autonumber, $print);
		if($print == 1){
			var_dump($data_array);
			var_dump($json);
			break;
		}

		$autonumber 	= $data_array[0]["no"];

		return $autonumber;
	}

	function format_autonumber($tabReference="",$jsonJS="none",$jsonData=""){
		//formating all data to one format that defined in autonumber.php
		$this->get_attr_number($tabReference);
		$autonumber 	= $this->get_run_number($jsonData);
		$format 		= $this->arr_tmp["format"];
		$format_arr 	= explode(",", $format);

		if(gettype($jsonJS) == "array"){
			foreach ($jsonJS as $k => $v) {
				${"jsonJS".$k} = $v;
			}
		}

		$textAutonumber = "";
		foreach ($format_arr as $key => $value) {
			$cekValue 		 = $$value;
			$textAutonumber .= $$value;

			if($cekValue == ""){
				if($value == "date"){
					$textAutonumber .= date($this->arr_tmp["attr"][$value]);
				}
				else if($value == "dateRomanic"){
					$date 			 = date($this->arr_tmp["attr"][$value]);
					$date_tmp	 	 = $this->romanic_number($date, true);
					$textAutonumber .= $date_tmp;
				}
				else{
					$textAutonumber .= $this->arr_tmp["attr"][$value];
				}
			}
		}

		return $textAutonumber;
	}


	private function romanic_number($number, $upcase = true){ 
	    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
	    $return = ''; 
	    while($number > 0){ 
	        foreach($table as $rom=>$arb){ 
	            if($number >= $arb){ 
	                $number -= $arb; 
	                $return .= $rom; 
	                break; 
	            } 
	        } 
	    }  
	    return $return; 
	}
}

?>