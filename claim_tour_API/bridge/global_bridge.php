<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	
	header("Access-Control-Allow-Origin: *");

	$postdata 		= file_get_contents("php://input");
	$r_request 		= json_decode($postdata,true);
	$request 		= isset($r_request["json_post"])	? $r_request["json_post"]								: "";

	$array_post 	= (isset($_POST["json_post"])		? ($_POST["json_post"])	: (isset($request)	? $request	: ""));
	$json_object   	= $array_post['json_global'];
	$json_cycle   	= $array_post['cycle'];


	//$postdata 		= file_get_contents("php://input");

	$array_filter 	= isset($_POST["json_filter"])	? ($_POST["json_filter"])	: "";

	//handle datatable server side
	$limit		= isset($_REQUEST["start"])					? addslashes($_REQUEST["start"])				: "0";
	$offset		= isset($_REQUEST["length"])				? addslashes($_REQUEST["length"])				: "10";
	$draw		= isset($_REQUEST["draw"])					? addslashes($_REQUEST["draw"])					: "1";
	$order		= isset($_REQUEST["order"][0]["column"])	? addslashes($_REQUEST["order"][0]["column"])	: "0";
	$orderBy	= isset($_REQUEST["order"][0]["dir"])		? addslashes($_REQUEST["order"][0]["dir"])		: "ASC";
	$search		= isset($_REQUEST["search"]["value"])		? addslashes($_REQUEST["search"]["value"])		: "";

	//manage paramater datatable server side to one array
	$str_to_arr = array();
	$str_to_arr["limit"] 			= $limit;
	$str_to_arr["offset"] 			= $offset;
	$str_to_arr["draw"] 			= $draw;
	$str_to_arr["order"] 			= $order;
	$str_to_arr["orderBy"] 			= $orderBy;
	if($json_cycle["name"] == "datatable")
		$json_cycle["data"]["datatable"]= $str_to_arr;

	//manage parameter json filter to one array
	if($json_cycle["name"] == "datatable")
		$json_cycle["data"]["filter"] = $array_filter;
	switch($json_object)
	{
		case "user":
			include(__DIR__ .'/../user/user.php');
			$mod = new user();
			$mod->set_function($json_cycle);
		break;

		case "users":
			include(__DIR__ .'/../user/users.php');
			$mod = new users();
			$mod->set_function($json_cycle);
		break;

		case "groups":
			include(__DIR__ .'/../group/groups.php');
			$mod = new groups();
			$mod->set_function($json_cycle);
		break;

		case "activitys":
			include(__DIR__ .'/../activity/activitys.php');
			$mod = new activitys();
			$mod->set_function($json_cycle);
		break;

		case "optional-tours":
			include(__DIR__ .'/../optional-tour/optional_tour.php');
			$mod = new optional_tours();
			$mod->set_function($json_cycle);
		break;

		case "optional-tour-activitys":
			include(__DIR__ .'/../optional_tour_activity/optional_tour_activity.php');
			$mod = new optional_tour_activitys();
			$mod->set_function($json_cycle);
		break;

		case "main-activity":
			include(__DIR__ .'/../main_activity/main_activity.php');
			$mod = new main_activitys();
			$mod->set_function($json_cycle);
		break;
		case "report-tour":
			include(__DIR__ .'/../report/report.php');
			$mod = new report();
			$mod->set_function($json_cycle);
		break;
		case "template":
			include(__DIR__ .'/../template/template.php');
			$mod = new templates();
			$mod->set_function($json_cycle);
		break;

		case "visitor":
			include(__DIR__ .'/../visitor/visitor.php');
			$mod = new visitors();
			$mod->set_function($json_cycle);
		break;

		case "visitor-detail":
			include(__DIR__ .'/../visitor/visitor_detail.php');
			$mod = new visitor_details();
			$mod->set_function($json_cycle);
		break;

		case "cancel":
			include(__DIR__ .'/../cancel/cancel.php');
			$mod = new cancels();
			$mod->set_function($json_cycle);
		break;

		case "cancel-detail":
			include(__DIR__ .'/../cancel/cancel_detail.php');
			$mod = new cancel_details();
			$mod->set_function($json_cycle);
		break;

		case "freeday":
			include(__DIR__ .'/../freeday/freeday.php');
			$mod = new freedays();
			$mod->set_function($json_cycle);
		break;

		case "opt":
			include(__DIR__ .'/../opt/opt.php');
			$mod = new opts();
			$mod->set_function($json_cycle);
		break;
	}

?>