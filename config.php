<?php
ini_set('session.gc_maxlifetime', 1800);
session_start();
date_default_timezone_set('Asia/Kolkata');
define('_DB_SERVER_', 'localhost');
define('_DB_NAME_', 'buddinfi_admin');
// define('_DB_USER_', 'buddinfi_holidays_admin');
// define('_DB_PASSWD_', 'buddy@2017');
define('_DB_USER_', 'root');
define('_DB_PASSWD_', '');
define('_COOKIE_KEY_', 'xCGoC0yRy1AOPu5Zem0U21f7dh4EvtyMFAcGcQBmYLggS3D9GQ9QLxSf');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function sendEmail($email,$subject,$message, $fileNamePDF = false, $filePathPDF = false){
			$mail             = new PHPMailer();
			$body             = preg_replace('/\[.*\]/', '',$message);
			$mail->IsSMTP(); // telling the class to use SMTP
			//$mail->Host       = "bh-67.webhostbox.net"; // SMTP server
			$mail->Host       = "mail.buddiesholidays.in"; // SMTP server
			$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
													   // 1 = errors and messages
													   // 2 = messages only
			//$mail->SMTPAuth   = true;                  // enable SMTP authentication

			$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
			$mail->Username   = "noreply@buddiesholidays.in"; // SMTP account username
			$mail->Password   = "noreply@123";        // SMTP account password
		
			$mail->SetFrom('noreply@buddiesholidays.in', "Buddiesholidays");
		
			$mail->Subject    = $subject;
		
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
			$mail->MsgHTML($body);
		
			if($fileNamePDF && $filePathPDF){
				if(is_array($fileNamePDF)){
					foreach($fileNamePDF as $filePDF)
						$mail->AddAttachment($filePathPDF.$filePDF, $name = $filePDF,  $encoding = 'base64', $type = 'application/pdf');
				}else
					$mail->AddAttachment($filePathPDF.$fileNamePDF, $name = $fileNamePDF,  $encoding = 'base64', $type = 'application/pdf');
			}
			$mail->AddAddress($email, $subject);
			$res=$mail->Send();
	    	if($res){
				echo "Your password has been emailed to you.";
			}
			else{
				echo "Error in sending email...Pls try again later";
			}


}
?>