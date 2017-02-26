<?php
	require_once("SetupLeft.php");
	
	//Check for same user
	$result=odbc_exec($conn, "SELECT COUNT([id]) FROM [user] WHERE [LoginID]='".$_REQUEST['LoginID']."'") or die("odbc_errormsg($conn)");
	$row=odbc_result($result, "" );
	
	if($row==0){
		$AddUser=odbc_exec($conn, "INSERT INTO [user]([FullName], [Email], [LoginID], [Password], [ContactNo], 
		[UserType], [UserStatus]) VALUES
		('".$_REQUEST['FullName']."', '".$_REQUEST['Email']."', '".strtoupper($_REQUEST['LoginID'])."', 
		'".md5('password')."', '".$_REQUEST['ContactNo']."', 
		'".$_REQUEST['UserType']."', 'Active')") or die(odbc_errormsg($conn));
		
		if($AddUser){
			echo "<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User <strong>".$_REQUEST['FullName'] ."</strong> has been registered.
					</div>
				</div>";			
			echo	"<h1 class='text-primary'>Map <strong>".$_REQUEST['FullName']."</strong> with Company</h1>
					<a class='btn btn-primary' href='MapUser.php?LoginID=".$_REQUEST['LoginID']."'>Yes</a> <a class='btn btn-default' href='NewUser.php'>No</a>
				</div>";
			
			//Send Email...
			
			$subject = "MEM ERP: New user - ".$_REQUEST['FullName'];
			$body = "
				<p>Dear ".$_REQUEST['FullName'].",</p>
				<p>This is to inform you that your account has been created for MEMPL ERP to record the ".$_REQUEST['UserType']." activities. Your login credentials is hereunder.</p>
				<p>
					URL: <b>http://erp.mempl.com</b><br>
					Login ID: <b>".strtoupper($_REQUEST['LoginID'])."</b><br>
					Login ID: <b>password</b>
				</p>
				<br />
				<p>Regards</p>
				<br /><br />
				<p>This is a system generated email, PLEASE DO NOT RESPOND.</p>
			";
			
			require_once "../bs/class.phpmailer.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->Host = "125.16.64.67";  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = "erpadministrator@mempl.com";  // SMTP username
			$mail->Password = "access@1234"; // SMTP password
			$mail->SMTPDebug = 1;
			
			$mail->From = "erpadministrator@mempl.com";
			$mail->FromName = "MEM ERP";
			
			//Get user Name
			$mail->AddAddress($_REQUEST['Email'], $_REQUEST['FullName']);
			//CC & BCC Email
			//$mail->addCC("Email", "FullName");
			$mail->addBCC("erpadministrator@mempl.com", "MEM ERP");
			//$mail->AddReplyTo("erpadministrator@mempl.com", "MEM ERP");

			//$mail->AddAttachment($MOUFiile);         // add attachments
			//$mail->AddAttachment($LOIFile);    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML

			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->AltBody = $body;
			$mail->Body;
				
			if(!$mail->Send())
			{
			   echo "<p>Message could not be sent.";
			   echo "Mailer Error: " . $mail->ErrorInfo."</p>";
			}
			else{
				echo "<p>Message has been sent</p>";		
			}
		}
		else{
			echo "<div class='container'><div class='bs-example'><div class='alert alert-danger alert-error'><a href='#' class='close' data-dismiss='alert'><strong>Error!</strong> There is some problem, please check.</div></div>";
		}
	}
	else{
		echo "<div class='container'>
			<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> User <strong>".$_REQUEST['FullName'] ."</strong> already registered.
				</div>
			</div>";
		echo	"<h1 class='text-primary'><small>Map <strong>".$_REQUEST['FullName']."</strong> with Company?</small></h1>
				<a class='btn btn-primary' href='MapUser.php?LoginID=".$_REQUEST['LoginID']."'>Yes</a> <a class='btn btn-default' href='NewUser.php'>No</a>
			</div>";
	}


	//Email


	require_once("SetupRight.php");
?>