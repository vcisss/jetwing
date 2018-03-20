<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require __DIR__ . "/../class/class/query.class.php";
	require __DIR__ . '/PHPMailerAutoload.php';

	//$no_req=3;
	$log 	= "";
	$no_req = $argv[1];
	$query 	= new query;

	date_default_timezone_set('Asia/Jakarta');
	
	function kirimEmail($kirim,$pengirim,$subject,$isi)
	{
		global $no_req,$query,$log;
		$info = getInfo($pengirim);

		$pass = $info["pass"];
		$name = $info["name"];
		//date_default_timezone_set('Etc/UTC');

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP

		/*$mail->Debugoutput = 'html';
		$mail->SMTPDebug = 1;*/ // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // or 587
		$mail->IsHTML(true);
		$mail->Username = $pengirim;
		$mail->Password = $pass;
		$mail->SetFrom($pengirim,$name);
		echo $name;
		$mail->Subject = $subject;
		$mail->Body = $isi;
		$mail->AddAddress($kirim);

		 if(!$mail->Send()) {
		    $queryupd = "insert into error_send_log (mail_id,email,fail_message,tanggal,sender)
		    			 values ('$no_req','$kirim','" . $mail->ErrorInfo . "',now(),'$pengirim')";
		    $query->custQuery($queryupd);

		    $msg =  "\r\nMailer Error: " . $mail->ErrorInfo;
		    echo $msg;

		    $msgtolog 	= str_replace("\r\n", "<br/>", $msg);
		    $log .= $msgtolog;

		    if (strpos($log, 'SMTP Error: data not accepted.') !== false)
		    {
		    	return false;
		    }
		    else if (strpos($log, 'Mailer Error: SMTP connect() failed.') !== false)
		    {
		    	return false;
		    }
		 } 
		 else {
		 	$queryupd 	= "UPDATE email_send_list set status=1 where email='$kirim' and mail_id='$no_req'";
		 	$query->custQuery($queryupd);
		    
		    $msg 		= "\r\nMessage has been sent to $kirim at " . date("Y-m-d H:i:s"); ;
		    echo $msg;
		    
		    $msgtolog 	= str_replace("\r\n", "<br/>", $msg);
		    $log .= $msgtolog;
		 }
		return true;
	}

	function getInfo($user)
	{
		global $query;
		$str = "select name,password from mst_data_user where email='$user'";
		$hasil = $query->selectQuery($str);
		return array("pass"=>$hasil[0]["password"],
					 "name"=>$hasil[0]["name"]);
	}

	$headmsg = "=====================================================\r\n";
	$headmsg .= "Process sending email start " . date("Y-m-d H:i:s") . "\r\n";
	echo $headmsg;

	$headlog 	= str_replace("\r\n", "<br/>", $headmsg);
	$log = $headlog; 

	$head 		= "select a.*,b.name,b.template from 
					hd_schedule_email a inner join mail_template b 
					on a.email_template = b.id 
					where a.id = '$no_req'";
	
	$hasilhead 	= $query->selectQuery($head);

	$sub 		= $hasilhead[0]["name"];
	$isi 		= $hasilhead[0]["template"];


	$str 		= "select * from det_contact_mailer where mail_id = '$no_req'";
	$hasil 		= $query->selectQuery($str);
	foreach($hasil as $temp)
	{
		/*email pengirim*/
		$email_pengirim = $temp["email"];
		$qty = $temp["estimate"];

		/*tujuan pengiriman*/
		$querykirim = "select * from email_send_list where status = 0 and mail_id = '$no_req' limit $qty";

		$hasilem = $query->selectQuery($querykirim);
		foreach($hasilem as $valueem)
		{
			$email_kirim = $valueem["email"];
			$cekemail = kirimEmail($email_kirim,$email_pengirim,$sub,$isi);
			if($cekemail==false)
			{
				break 1;
			}
			//fungsi kirim
		}
	}


	$endtime = date("Y-m-d H:i:s"); 

	$footmsg = "\r\n\r\nProcess sending email end at " . date("Y-m-d H:i:s"); 
	$footmsg .= "\r\n=====================================================\r\n\r\n"; 
	echo $footmsg;

	$footlog 	= str_replace("\r\n", "<br/>", $footmsg);
	$log .= $footlog;

	$log = addslashes($log);

	$querylog = "UPDATE hd_schedule_email set log = concat(log,' ','$log') where id='$no_req'";
	$query->custQuery($querylog);

	$querycek = "select * from email_send_list where mail_id = '$no_req' and status = 0";
	$hasil = $query->selectQuery($querycek);

	if(count($hasil)>0)
	{

		$date 		= date_create($endtime);

		$date->add(new DateInterval('P1DT30M'));
		
		$datestr 	= $date;
		$hasil 		= date_format($datestr, 'i/G/j/n');

		$temp 		= explode("/", $hasil);

		$min		= intval($temp[0]);
		$hour		= intval($temp[1]);
		$day		= intval($temp[2]);
		$month		= intval($temp[3]);


		$output 	= shell_exec('crontab -u www-data -l');
		file_put_contents(__DIR__ . '/crontab_upd.txt', $output."$min $hour $day $month * /usr/bin/php /var/www/html/mailing_system/main_system/cron/proc.php \"$no_req\" >> /var/www/html/mailing_system/main_system/cron/result.log".PHP_EOL);
		echo exec('crontab -u www-data ' . __DIR__ . '/crontab_upd.txt');
	}