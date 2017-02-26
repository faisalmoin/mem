<?php
	require_once("Header1.php");
	//$id=$_REQUEST['id'];
	$oldPassword=md5($_REQUEST['oldPassword']);
	$newPassword=md5($_REQUEST['newPassword']);
	$retPassword=md5($_REQUEST['retPassword']);
	
	//exit("<br /><br /><br /><br />SELECT * FROM [user] WHERE [LoginID]='$LoginID'");
	
	$row=odbc_exec($conn, "SELECT * FROM [user] WHERE [LoginID]='$LoginID'") or die(odbc_errormsg($conn));
	
    echo "<br /><br /><br /><br /><div class='container'><div class='bs-example'>";
	if($oldPassword == odbc_result($row, "Password")){
		if($newPassword == $retPassword){
			odbc_exec($conn, "UPDATE [user] SET [Password]='".$newPassword."' WHERE [LoginID]='$LoginID'") or die(mysql_error());
			echo "<div class='alert alert-primary alert-error' style='background-color: #008000;color: #ffffff;'>Your password has been reset</div>";
		}
		else{
			echo "<div class='alert alert-warning alert-error' style='background-color: #FFA500;color: #ffffff;'>New Password does not match with the Retype Password</div>";
		}
	}
	else{
		echo "<div class='alert alert-danger alert-error' style='background-color: #990000;color: #ffffff;'>Current Password does not match.</div>";
	}
    echo "</div></div>";
    require_once("../footer.php");
?>