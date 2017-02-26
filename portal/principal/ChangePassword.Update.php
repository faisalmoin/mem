<?php
	require_once("header.php");
	//$id=$_REQUEST['id'];
	$oldPassword=$_REQUEST['oldPassword'];
	$newPassword=$_REQUEST['newPassword'];
	$retPassword=$_REQUEST['retPassword'];
	
	$result=mysql_query("SELECT * FROM `user` WHERE `LoginID`='$LoginID'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	
    echo "<br /><br /><br /><br /><div class='container'><div class='bs-example'>";
	if($oldPassword == $row[4]){
		if($newPassword == $retPassword){
			mysql_query("UPDATE `user` SET `Password`='".$newPassword."' WHERE `LoginID`='$LoginID'") or die(mysql_error());
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