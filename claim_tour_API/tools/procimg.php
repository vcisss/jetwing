<?php 
/*

date_default_timezone_set("Asia/Jakarta");

$dir_date = date("Ymd_h_i_s");
*/
$dir_name = $_REQUEST["folder"];
if(!file_exists($dir_name))
{
	mkdir($dir_name);
}

$data = json_decode($_REQUEST["data"],true);

foreach ($data as $key => $value) {
	$picname 	= explode(".",$value["name"]);
	//var_dump($picname);
	$pic 		= $value["data"];
	$img 		= str_replace('data:image/png;base64,', '', $pic);
	$img 		= str_replace(' ', '+', $img);
	$data 		= base64_decode($img);

	$filename 	= "../../$dir_name/" . $picname[0] . ".png";
	$ffilename 	= "../../$dir_name/" . $picname[0] . ".jpg";

	file_put_contents($filename, $data);

	//resizing
	$info = getimagesize($filename);
	$widthconv = $_REQUEST["width"];
	$heightconv = $_REQUEST["height"];

	list($width, $height) = getimagesize($filename);
	$newwidth 	= $widthconv ;
	$newheight 	= $heightconv ;

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefrompng($filename);

	// Resize
	$a = imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	$b = imagejpeg($thumb,$ffilename);
}
