<?php
include(__DIR__ .'/excel/excel_reader2.php');
include(__DIR__ .'/excel/SpreadsheetReader.php');
include(__DIR__ .'/../query/query.php');
include(__DIR__ .'/lib/phpexcel/PHPExcel/IOFactory.php');
include(__DIR__ .'/../base/base.php');

class FilterAB implements PHPExcel_Reader_IReadFilter
{
	public function readCell($column, $row, $worksheetName = '') {
		// Read rows 1 to 7 and columns A to E only
		if ($row >= 2) 
		{
			if (in_array($column,array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','Y','Z'))) {
				return true;
			}
		}
		return false;
	}
}

class import extends base{
	/* Declare included Class */
	private $query_class;
	private $db_schema;
	private $form;
	protected $route        = array (
                                        "import-data"      => "getData"
                                    );
	/* End Included Class */

	/* Declare Used Variable */
	/* End Used Variable */

	function __construct()
	{	
		parent::__construct();
		$this->setupClass();
	}

	function setupClass()
	{

		$this->query_class 	= new query();
		$this->db_schema 	= new database_infoschema();
	}

	function set_function($json="")
    {   
        $this->route = array_merge($this->route_def,$this->route);
        $data = json_encode($json);
        return $this->bridge_to_function($data);
    }

	function select($table, $cond, $val, $query = 0)
	{
		$tamp 	= $this->query_class->selectAll($table,$cond,$val,$query);
		return $tamp;
	}



	function getDetail($file_name)
	{
		if (isset($argv[1]))
		{
			$Filepath = $argv[1];
		}
		elseif (isset($file_name))
		{
			$Filepath = "../../asset/import/".$file_name;
		}
		else
		{
			if (php_sapi_name() == 'cli')
			{
				echo 'Please specify filename as the first argument'.PHP_EOL;
			}
			else
			{
				echo 'Please specify filename as a HTTP GET parameter "File", e.g., "/test.php?File=test.xlsx"';
			}
			exit;
		}

		try
		{
			$Spreadsheet = new SpreadsheetReader($Filepath);

			$Sheets = $Spreadsheet -> Sheets();

			foreach ($Sheets as $Index => $Name)
			{
				$Spreadsheet -> ChangeSheet($Index);

				foreach ($Spreadsheet as $Key => $Row)
				{

					echo $Index.': ';
					if ($Row)
					{
						print_r($Row);
					}
					else
					{
						var_dump($Row);
					}

					echo '<br><br>';
				}
			}
			
		}
		catch (Exception $E)
		{
			echo $E -> getMessage();
		}
	}

	function getData($json)
	{
		$excel = $json["data"]["file"];

		$dir = "../../temp/".$excel;

		$exts = array('xlsx');
		if(in_array(end(explode('.', $excel)), $exts)){
			$inputFileType 	= 'Excel2007';
		}
		else{
			$inputFileType 	= 'Excel5';
		}

		$filterSubset 	= new FilterAB();
		
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$sheetname = 'IMPORT';
		$objReader->setLoadSheetsOnly($sheetname);
		$objReader->setReadFilter($filterSubset);
		$objPHPExcel = $objReader->load($dir);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true);

		$arrcek = array();

		$data_import_global   	= json_decode(file_get_contents(__DIR__ .'/data_import.php'), true);
		$format_import 			= $data_import_global[$sheetData[2]["B"]];
		$data_fail 				= 0;
		$data_success 			= 0;
		foreach($sheetData as $key_data => $value_data)
		{
			if($key_data == 1 || $key_data == 2 || $key_data == 3){

			}
			else{
				$check = $this->cekDataTable($value_data,$format_import);
				$temp_json = array();
				if($check == 0){
					foreach($format_import["body"] as $key_format => $value_format)
					{
						$temp_json[$key_format] = $value_data[$value_format];
					}
					$arrcek[] = array($temp_json);
					$data_success++;
				}
				else{
					$data_fail++;
				}
			}
		}
		$this->addDataTable($arrcek,$format_import);
		$json_return_status = array(
                          				"success_uniq"        => $data_success,
                          				"fail_uniq"           => $data_fail
							);
		echo json_encode($json_return_status); 
	}

	function cekDataTable($value,$format_import){
		$unique    			= $format_import["unique"];
		$cond_ext    		= '';
        $json_where         = [];
        foreach ($unique as $key => $value_uniq) {
        	if($key == 0){
				$cond_ext      .= $value_uniq." = ? ";
				array_push($json_where, $value[$format_import["body"][$value_uniq]]);
        	}
        	else{
        		$cond_ext      .= " OR ".$value_uniq." = ? ";
        		array_push($json_where, $value[$format_import["body"][$value_uniq]]);
        	}
        }
        if($value[$format_import["body"][$value_uniq]] != null && $value[$format_import["body"][$value_uniq]] != '' && $value[$format_import["body"][$value_uniq]] != NULL){
	        $table              = $format_import["table"];
	        $cond               = 'ANd status = 1 AND ( '.$cond_ext.' )';
	        $data               = ' count(*) count ';
	        $count 				= $this->query_class->select_all($table,$cond,$json_where,$data);
			return $count[0]["count"];
        }else{
        	return 1;
        }
	}

	function addDataTable($json_get,$format_import){
		$data_success = 0;
		$data_fail    = 0;
		foreach ($json_get as $key => $value) {
			$json = array(
                          "data"          => $value[0]
						);
            $this->table = trim($format_import["table"]);
            $data = $this->add_import($json);
		}
	}

	// add delete detail
    function add_import($json, $print=0)
    {
        $id=""; $conf_tbl=""; $table_detail="";
        $tmp_res    = array(); // all data temporary from result query
        $tmp_arr    = array();
        $error      = 0;
        $this->qry->beginTransaction();

        $table      = $this->table;
        $data       = $json["data"];

        $tmp_arr    = json_decode($this->qry->do_crud($table, $data, "", 0, $print), true); // decode return array result query
        $tmp_res[]  = $tmp_arr;
        if($tmp_arr["error"] !== "Success"){
            $error++;
        }
        if(isset($json["data_detail"])){
            $parent = $tmp_arr["data"];
            foreach ($json["data_detail"] as $key => $value) {
                $conf_tbl       = $this->setup_table_detail($value["name"]); // get all setup for detail with that name
                $where_detail   = array( $conf_tbl["index"] => $parent[$conf_tbl["parent"]] );
                $table_detail   = $conf_tbl["table"];
                $this->qry->do_crud($table_detail, "", $where_detail, 3, $print); // delete old detail
                foreach ($value["data"] as $k => $v) {
                    $v[$conf_tbl["index"]]  = $parent[$conf_tbl["parent"]];
                    $tmp_arr                = json_decode($this->qry->do_crud($table_detail, $v, "", 0, $print), true);
                    $tmp_res[]              = $tmp_arr;
                    if($tmp_arr["error"] !== "Success"){
                        $error++;
                    }
                }
            }
        }

        if($error > 0){
            $this->qry->cancelTransaction();
        }
        else{
            $this->qry->endTransaction();
        }
    }
}

?>