<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	
	header("Access-Control-Allow-Origin: *");

	$postdata 		= file_get_contents("php://input");
	$r_request 		= json_decode($postdata,true);
	$json 			= isset($r_request["jsondata"]) ? $r_request["jsondata"] : "";
	var_dump($json);
	$path_move 		= $json['pathmove'];
	$file_name 		= $json['filename'];
	$file_type 		= $json['filetype'];
	$search_image 	= strpos($file_type,"image");
	$dir_tmp 		= "../../temp/";
    $dir_upload 	= "../../asset/image-data/$path_move/";

  	$file_upload 	= $dir_upload . $file_name;

  	$hasil = copy($dir_tmp.$file_name, $file_upload);
	
	unlink($dir_tmp.$file_name);

  	if($search_image > -1){
		$tmp_arr 		= explode(".",$file_name);
		$tmp_arr1 		= end($tmp_arr);
		if($tmp_arr1 !== "png"){
			//identitas file asli
			$im_src 		= @imagecreatefromjpeg($file_upload);
			$src_width 		= imageSX($im_src);
			$src_height 	= imageSY($im_src);

			if($src_width > $dst_width){
				//Set ukuran gambar hasil perubahan
				$dst_width 		= 500;
				$dst_height 	= ($dst_width/$src_width)*$src_height;

				//proses perubahan ukuran
				$im 			= imagecreatetruecolor($dst_width,$dst_height);
				imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

				//Simpan gambar
				// $a = imagejpeg($im,$dir_upload . $file_name);
				$a = imagejpeg($im,$dir_upload . "small_" . $file_name);
			}
		}
		else{
		    $im_src 		= @imagecreatefrompng($file_upload);
			$src_width 		= imageSX($im_src);
			$src_height 	= imageSY($im_src);

			//Set ukuran gambar hasil perubahan

			$dst_width 		= 500;
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
				$a = imagepng($im,$dir_upload . "small_" . $file_name);
			}
		}
	}
?>