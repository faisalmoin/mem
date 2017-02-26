<?php
require_once "../bs/class.phpmailer.php";
	$mail = new PHPMailer();
	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "125.16.64.67";  // specify main and backup server
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = "erpadministrator@mempl.com";  // SMTP username
	$mail->Password = "access@1234"; // SMTP password
	//$mail->SMTPDebug = 1;
	
	
	if(!$mail->Send())
	{
	   echo "<p>Message could not be sent.";
	   echo "Mailer Error: " . $mail->ErrorInfo."</p>";
	   //exit;
	}
	else{
		echo "<p>Message has been sent</p>";		
	}
	
?>
