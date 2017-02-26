<?php
	require_once("SetupLeft.php");
	$id = $_REQUEST['id'];
	$Request = $_REQUEST['Response'];
	
	if($Request == 'Update'){
		
		$AddUser=odbc_exec($conn, "UPDATE [user] SET 
			[FullName]='".addslashes($_REQUEST['FullName'])."', 
			[Email]='".addslashes($_REQUEST['Email'])."', 
			[LoginID]='".strtoupper($_REQUEST['LoginID'])."',
			[ContactNo]='".$_REQUEST['ContactNo']."', 
			[UserType]='".$_REQUEST['UserType']."', 
			[UserStatus]='".$_REQUEST['UserStatus']."'
			WHERE [id]='".$id."'") or die(odbc_errormsg($conn));
		if($AddUser){
			echo "<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User <strong>".$_REQUEST['FullName'] ."</strong> has been updated.
					</div>
				</div>";
		}
		else{
			echo "<div class='bs-example'><div class='alert alert-danger alert-error'><a href='#' class='close' data-dismiss='alert'><strong>Error!</strong> There is some problem, please check.</div>";
		}
	}
	
	if($Request == "Reset Password"){
		//mysql_query("UPDATE `user` SET `Password`='' WHERE `id`='".$id."'") or die(mysql_error());
		
		//Send Email.
		$to = addslashes($_REQUEST['Email']);
		$from = "donotreply@mempl.com";
		$subject = "School ERP Web Portal Password Request";
		$body = "<html><body style='font-family: arial; padding: 10px; font-size: 12px'>
			<p align='justify'>Dear ".addslashes($_REQUEST['FullName']).", </p>
			<p align='justify'>This is to inform you that your password has been reset. Please click on the link below to active your account.</p>
			<p align='justify'><a href='http://202.54.232.182/MEF/portal/ChangePassword.New.php?id=$id' style='font-size: 14px; text-decoration: none;'>Reset Password</a></p>
			<br />
			<p align='justify'>
				Thanks & Regards,<br />
				Support Team,<br />
				Educomp Solutions Ltd.<br />
				Gurgaon
			</p>
		</body></html>";
		require_once("../smtp.php");
				
	}
	
	require_once("SetupRight.php");
?>