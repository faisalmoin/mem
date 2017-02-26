<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MEM-ERP | Reset Password</title>
		<title>MEM-ERP</title>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<script src="bs/js/jquery.min.js"></script>
		<script src="bs/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="bs/css/bootstrap.min.css">
		<link rel="stylesheet" href="bs/css/sticky-footer-navbar.css">
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	  

		<script>
			function checkform (Login){
				if (form.UserName.value==""){
					alert ("Login ID cannot be blank.");
					form.UserName.focus();
					return false;
				}
				if(form.Password.value==""){
					alert ("Password cannot be blank.");
					form.Password.focus();
					return false;
				}
				if (form.UserName.value != "" && Login.Password.value != ""){
					document.form.submit.click();
					//window.location = "auth.php";
				}
			}

		</script>
		<style>
			html,
				body {
				margin:0;
				padding:0;
				height:100%;
				}
				#wrapper {
				min-height:0%;
				position:relative;
				}
				#header {
				//padding:10px;
				}
				#content {
				padding:40px;
				padding-bottom:23%; /* Height of the footer element */
				}
				#footer {
				width:100%;
				height:0px;
				position:absolute;
				bottom:0;
				left:0;
				}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div style="font-size: 20px; font-family: verdana; color: #FFF;background-color: #0088ff; padding:14px">
						MEM ERP
				</div>
			</div>
			<div id="content">
	<?php
		require_once("db.txt");
		
		$Login = $_REQUEST['Email'];
		
		$Check = odbc_exec($conn, "SELECT * FROM [user] WHERE [LoginID]='$Login' OR [Email]='$Login'");
		
		if(odbc_num_rows($Check) != 1){
			echo "<div class='alert alert-danger'>User does not exist in the database ...</div>";			
		}
		else{
			
			odbc_exec($conn, "UPDATE [user] SET [Password]='".md5('password')."' WHERE [ID]='".odbc_result($Check, "ID")."' ");
			
			//Email to user.
			require_once "bs/class.phpmailer.php";
			
			$to = odbc_result($Check, "Email");
			$subject = "MEMPL ERP: Password change request - regarding";
			$body = "
			<p >Dear ".odbc_result($Check, "FullName").",</p>
			<p></p>
			<p>
			This is to inform you that your password has been reset from MEMPL ERP as per your request placed on ".date("d/M/Y H:i:s").". <br />
			Your login credentials is hereunder:<br />
			<p>URL: <b><a href='http://erp.mempl.com'>http://erp.mempl.com</a></b></p>
			<p>Login ID: <b>".odbc_result($Check, "LoginID")."</b></p>
			<p>Password: <b>password</b></p>
			</p>
			<p></p>
			<p>THIS IS A SYSTEM GENERATED EMAIL, PLEASE DO NOT RESPOND.</p>
			<p></p>
			<p>Regards.</p>
			";
			
			$mail = new PHPMailer();
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->Host = "125.16.64.67";  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = "erpadministrator@mempl.com";  // SMTP username
			$mail->Password = "access@1234"; // SMTP password
			$mail->SMTPDebug = 0;
		
			$mail->From = "erpadministrator@mempl.com";
			$mail->FromName = "MEM ERP";
			
			$mail->AddAddress(odbc_result($Check, "Email"), odbc_result($Check, "FullName"));
			
			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->AltBody = $body;
			$mail->Body;
				
			if(!$mail->Send())
			{
			   echo "<div class='alert alert-danger'><p>Message could not be sent.";
			   echo "Mailer Error: " . $mail->ErrorInfo."</p></div>";
			}
			else{
				echo '<div class="alert alert-success"><p>Message has been sent to '.odbc_result($Check, "Email").'</p></div>';
			}
			
		}
	?>	
		</div>
	</div>
	<?php require_once("footer.php")?>