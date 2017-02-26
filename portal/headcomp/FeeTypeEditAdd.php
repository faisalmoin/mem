<?php
	require_once("SetupLeft.php");
	
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [ID]='{$_POST['id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Fee Type] SET 
					[Code]='".ucwords(strtoupper($_REQUEST['Code']))."',
					[Description]='".ucwords(strtolower($_REQUEST['Description']))."',
					[Start Date]='".strtotime(str_replace("/", " ", $_REQUEST['startDate']." 01:00:00"))."', 
					[End Date]='".strtotime(str_replace("/", " ", $_REQUEST['endDate']." 01:00:00"))."',
					[Academic Year]='".$_REQUEST['Academic']."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=FeeTypeList.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>