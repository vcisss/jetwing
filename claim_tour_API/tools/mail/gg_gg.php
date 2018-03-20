<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP

$mail->Debugoutput = 'html';
$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "sariling@promotion-genset.com";
$mail->Password = "selalusukses88";
$mail->SetFrom("sariling@promotion-genset.com");
$mail->Subject = "Testing untuk kirim email";
$mail->Body = "Contoh Email dari SMTP";
$mail->AddAddress("buddison@gmail.com");
$mail->AddAddress("chocoqz@gmail.com");
$mail->AddAddress("widyasetiawan@gmail.com");

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }