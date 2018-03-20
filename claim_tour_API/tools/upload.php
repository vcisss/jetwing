<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	
	require_once(__DIR__ .'/../query/query.php');

	function makeDir($path="")
	{
	     $ret = @mkdir($path, 0777, true);
	     return $ret === true || is_dir($path);
	}

	function makeDirDynamic($arr_path=array(),$path=""){
		$arr 		= $arr_path;
		$arr_tmp 	= array();
		foreach ($arr as $val) {
			$arr_tmp[] 	= $val;
			$tmp 		= $path . implode("/", $arr_tmp);
			makeDir($tmp);
		}
	}

	function setDirectory($id="",$module="",$path="",$jsonindex=""){
		@session_start();
		$arr_module = array(
								"product" => "product_mst"
							);
	
        $qry 	= new query();
		$table 	= $arr_module[$module];
		$query 	= "UPDATE ". $table ." SET directory_pict='". $path ."' WHERE ". $jsonindex ."='". $id ."';";
		$hasil 	= $qry->custQuery($query);
	}

	header("Access-Control-Allow-Origin: *");

	$postdata 		= file_get_contents("php://input");
	$r_request 		= json_decode($postdata,true);
	$json 			= isset($r_request["jsondata"]) ? $r_request["jsondata"] : "";
	$path_move 		= $json['pathmove'];
	$file_name 		= $json['filename'];
	$file_change 	= $json['filechange'];
	$file_type 		= $json['filetype'];
	$id_parent 		= $json['id_parent'];
	$jsonindex 		= $json['jsonindex'];
	$search_image 	= strpos($file_type,"image");
	$dir_tmp 		= "../../temp/";
    $dir_upload 	= "../../asset/image-data/". $path_move ."/";

    if($path_move == "product"){
    	$dir_upload = '../../asset/image-data/'. $path_move .'/';
    	$date_year 	= date('Y');
    	$date_month = date('m');
    	$arr_date 	= array($date_year,$date_month);
    	makeDirDynamic($arr_date,$dir_upload);
    	$dir_upload = '../../asset/image-data/'. $path_move .'/'. $date_year .'/'. $date_month .'/';
    }
    
  	$file_tmp 		= $dir_tmp . $file_name;
  	$file_upload 	= $dir_upload . $file_change;

  	if($search_image > -1){
		$tmp_arr 		= explode(".",$file_name);
		$tmp_arr1 		= end($tmp_arr);
		if($tmp_arr1 !== "png"){
			//identitas file asli
			$im_src 		= @imagecreatefromjpeg($file_tmp);
			$src_width 		= imagesx($im_src);
			$src_height 	= imagesy($im_src);

			//Set ukuran gambar hasil perubahan
			$dst_width 		= 400;
			$dst_height 	= ($dst_width/$src_width)*$src_height;

			if($src_width > $dst_width){

				//proses perubahan ukuran
				$im 			= imagecreatetruecolor($dst_width,$dst_height);
				imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

				//Simpan gambar
				$a = imagejpeg($im,$dir_upload . $file_change);
			}
			else{
  				$hasil = copy($dir_tmp.$file_name, $file_upload);
			}
		}
		else{
		    $im_src 		= @imagecreatefrompng($file_tmp);
			$src_width 		= imagesx($im_src);
			$src_height 	= imagesy($im_src);

			//Set ukuran gambar hasil perubahan

			$dst_width 		= 300;
			$dst_height 	= ($dst_width/$src_width)*$src_height;

			if($src_width > $dst_width){
				//proses perubahan ukuran
		        $im  			= imagecreatetruecolor($dst_width,$dst_height);

		        //transparancy
			    imagecolortransparent($im, imagecolorallocatealpha($im, 0, 0, 0, 127));
			    imagealphablending($im, false);
			    imagesavealpha($im, true);
				imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

				//Simpan gambar
				$a = imagepng($im,$dir_upload . $file_change);
			}
			else{
  				$hasil = copy($dir_tmp.$file_name, $file_upload);
			}
		}
    	$path_folder 	= $date_year .'/'. $date_month .'/';
		setDirectory($id_parent,$path_move,$path_folder,$jsonindex);
	}
	else{
  		$hasil = copy($dir_tmp.$file_name, $file_upload);
	}

	unlink($dir_tmp.$file_name);
?>