<?php
	// error_reporting(E_ALL);
	// ini_set('display_errors', 0);
	include(__DIR__ .'/../pos/pos.php');
	$pos = new pos();
	$jsondata 	= isset($_POST["jsondata"])	? ($_POST["jsondata"])	: "";
	$jsondata 	= json_decode($jsondata, true);

	switch($jsondata["type"])
	{
		case "add-trans":
    		echo $pos->add_edit_trans($jsondata["data"]);
		break;

		case "edit-trans":
    		echo $pos->add_edit_trans($jsondata["data"],$jsondata["data_cond"],1);
		break;

		case "get-trans":
    		echo $pos->get_trans($jsondata["data"],$jsondata["data_cond"],1);
		break;

		case "get-activity-trans":
			// $pos->add();
			return true;
		break;

		case "cek-register":
    		echo $pos->cek_register($jsondata["data"]);
		break;

		case "open-register":
    		echo $pos->open_register($jsondata["data"]);
		break;

		case "close-register":
    		echo $pos->close_register($jsondata["data"],$jsondata["data_cond"]);
		break;

		case "get-product-category":
			echo $pos->get_category();
		break;

		case "get-product":
			echo $pos->get_product();
		break;

		case "get-product-variant":
			echo $pos->get_variant($jsondata["data"]);
		break;

		case "get-product-modifier":
			echo $pos->get_modifier($jsondata["data"]);
		break;

		case "get-discount":
			echo $pos->get_discount();
		break;

		case "get-tax":
			echo $pos->get_tax();
		break;

		case "get-outlet":
			echo $pos->get_outlet();
		break;
	}

?>