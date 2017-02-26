<?php
	require_once("header.php");
	$id=$_REQUEST['id'];
	$newPassword=$_REQUEST['newPassword'];
	$retPassword=$_REQUEST['retPassword'];
	
	//$result=mysql_query("SELECT * FROM `user` WHERE `id`='$LoginID'") or die(mysql_error());
	//$row=mysql_fetch_array($result);
	
    echo "<br /><br /><br /><br /><div class='container'><div class='bs-example'>";
	
		if($newPassword == $retPassword){
			//exit("UPDATE [user] SET [Password]='".$newPassword."' WHERE `id`='$id'");
			odbc_exec($conn, "UPDATE [user] SET [Password]='".$newPassword."' WHERE [id]='$id'") or die(odbc_errormsg($conn));
			echo "<div class='alert alert-primary alert-error'  align='center'><img src='img/tick.png' width='50px'>Your password has been reset. <a href='index.php'>Click here to login.</a></div>";
		}
		else{
			echo "<div class='alert alert-warning alert-error' style='background-color: #FFA500;color: #ffffff;'>New Password does not match with the Retype Password</div>";
		}	
    echo "</div></div>";
    require_once("footer.php");
?>