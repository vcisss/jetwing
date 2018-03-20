<?php
require_once(__DIR__. "/../query/query.php");
require_once(__DIR__. "/mail/PHPMailerAutoload.php");

class eXMail
{
	private $qry;
	private $IsSMTP 		= true; 			// enable SMTP
	private $SMTPDebug 		= false; 			// enable SMTP Debug
	private $SMTPDebugVal 	= 2; 				// enable SMTP Debug Value
	private $SMTPAuth 		= true; 			// authentication enabled
	private $SMTPSecure 	= 'ssl'; 			// secure transfer enabled REQUIRED for Gmail
	private $Host 			= "smtp.gmail.com";	// host name
	private $Port 			= 465; 				// or 587
	
	function __construct()
	{
		$this->qry 	= new query();
	}
	
	function sendEmail($dataEmail=array(),$dataRecipient=array(),$dataSender=array(),$modul,$db_name="none")
	{	
		$subjectMail	= isset($dataEmail['subject']) 	? $dataEmail['subject'] 	: "New Mail";
		$bodyMail		= isset($dataEmail['body']) 	? $dataEmail['body'] 		: "New Mail";
		$attachMail		= isset($dataEmail['attach']) 	? $dataEmail['attach'] 		: array();
		$ccMail			= isset($dataEmail['CC']) 		? $dataEmail['CC'] 			: array();
		$bccMail		= isset($dataEmail['BCC']) 		? $dataEmail['BCC'] 		: array();

		$usernameSender = isset($dataSender['username']) ? $dataSender['username'] 	: "";
		$passwordSender = isset($dataSender['password']) ? $dataSender['password'] 	: "";
		$nameSender 	= isset($dataSender['name']) 	 ? $dataSender['name'] 	   	: "";

		$result = array();
		$mail 	= new PHPMailer(); 							// create a new object
		if($this->IsSMTP == true) 
			$mail->IsSMTP();								// enable SMTP

		if($this->SMTPDebug == true) 
			$mail->SMTPDebug 			= $this->SMTPDebugVal;	// enable SMTP Debug

		$mail->SMTPAuth 				= $this->SMTPAuth; 	// authentication enabled
		$mail->SMTPSecure 				= $this->SMTPSecure;// secure transfer enabled REQUIRED for Gmail
		$mail->Host 					= $this->Host;
		$mail->Port 					= $this->Port; 		// or 587
		$mail->IsHTML(true);
		$mail->Username 				= $usernameSender;
		$mail->Password 				= $passwordSender;
		$mail->SetFrom($usernameSender,$nameSender);
		$mail->Subject 					= $subjectMail;

		foreach ($dataRecipient as $k_send => $send) {
			$mail->ClearAllRecipients();					// clear all recipients
			$mail->clearAttachments();						// clear all attachments

			$email 						= $send['email'];
			$mail->AddAddress($email); 						// set email address recipient
			
			$mail->Body 				= $bodyMail;		// set email body	

			foreach ($ccMail as $k_cc => $cc) {
				$mail->AddCC($cc['email'],$cc['name']); 	// add cc mail
			}

			foreach ($bccMail as $k_bcc => $bcc) {
				$mail->AddBCC($bcc['email'],$bcc['name']); 	// add bcc mail
			}

			foreach ($attachMail as $k_file => $file) {
				$file_to_attach = __DIR__ . $file['file'];
				$mail->AddAttachment( $file_to_attach ); 	// add attachments
			}

			if($db_name == "none"){
				@session_start();
				$db_name = $_SESSION['db_name'];
			}
			
			if( !$mail->Send() ) {
	 			$msg 			= $mail->ErrorInfo;
				$dataHistory 	= array(
											"msg" 		=> $msg,
											"modul"		=> $modul,
											"result"	=> 500,
											"db_name"	=> $db_name
										);
	    		$result[] 		= $dataHistory;
			} 
			else {
			 	$msg 			= "Message has been sent to $email at " . date("Y-m-d H:i:s");
				$dataHistory 	= array(
											"msg" 		=> $msg,
											"modul"		=> $modul,
											"result"	=> 200,
											"db_name"	=> $db_name
										);
			    $result[] 		= $dataHistory;
			}
			$this->insToHistoryMail($dataHistory);			
		}

		return $result;
	}

	function insToHistoryMail($dataHistory=array()){
		$msg 		= $dataHistory['msg'];
		$modul 		= $dataHistory['modul'];
		$db_name 	= $dataHistory['db_name'];

	    $queryIns 	= "insert into `pos_simple_register`.`email_history`(msg,modul,db_name)
	    				values('$msg','$modul','$db_name')";
		$this->qry->custQuery($queryIns);
	}
}
?>