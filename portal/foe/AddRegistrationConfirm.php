<?php
	require_once("header.php");
	$id=$_REQUEST['id'];
	echo "<br /><br /><br /><br />";
	//$sql1 = "UPDATE [Temp Application] SET [Registration Status]='2', [Date of Receive]='".date('Y-m-d H:i:s', strtotime(str_replace('/', '-',$_REQUEST['ReceivedDate'])))."', [Remarks]='".$_REQUEST['Remarks']."', [UpdateStatus]=1 WHERE [Enquiry No_]='$id' AND [Company Name]='$ms' ";
	$sql1 = "UPDATE [Temp Application] SET [Registration Status]='2', [Date of Receive]='".$_REQUEST['ReceivedDate']."', [Remarks]='".$_REQUEST['Remarks']."', [UpdateStatus]=1 WHERE [No_]='".$_REQUEST['RegistrationNo']."'  AND [Company Name]='$ms' ";
    
	$result=odbc_prepare($conn, $sql1);
	if(!odbc_execute($result)){
	
		exit("<div class='container'>
			<div class='alert alert-danger alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Error!</strong> There is some error, kindly check. <br />odbc_errormsg($conn);
			</div>
			</div>");
	}
	else{
		echo "<META http-equiv='refresh' content='0;URL=RegistrationConfirmationList.php?id=".$_REQUEST['RegistrationFormNo']."'>";

	}

	require_once("../footer.php");
?>
