<?php
	require_once("SetupLeft.php");
	
	
	//$Acad = odbc_exec($conn, "SELECT * FROM [Academic Year] WHERE [ID]='{$_POST['id']}'") or exit(odbc_errormsg($conn));
	//$sql_update2 = "Select sum([Capacity]) FROM [Class Section] where [Company Name]='$CompName'AND [Class]='".$_REQUEST['Class']."' AND [Section]<> 'SNA' AND [Curriculum]='".$_REQUEST['Curriculum']."' AND [Academic Year]='".$_REQUEST['Academic']."'";
	
		$sql_update = "UPDATE [Class Section] SET				
					[Capacity]='".$_REQUEST['Capacity']."'
					where [ID]='".$_REQUEST['id']."' ";
		
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		
		$sql_sna = "SELECT sum([Capacity]) FROM [Class Section] where [Company Name]='$CompName' AND [Class]='".$_REQUEST['Class']."' AND [Section]<> 'SNA' AND [Curriculum]='".$_REQUEST['Curriculum']."' AND [Academic Year]='".$_REQUEST['Academic']."'";
		$sql2 = odbc_exec($conn, $sql_sna) or die(odbc_errormsg($conn));
		$update_sna = "UPDATE [Class Section] SET [Capacity]=".odbc_result($sql2, "")." where [Company Name]='$CompName' AND [Class]='".$_REQUEST['Class']."' AND [Section]= 'SNA' AND [Curriculum]='".$_REQUEST['Curriculum']."' AND [Academic Year]='".$_REQUEST['Academic']."'";
				
		odbc_exec($conn, $update_sna) or die(odbc_errormsg($conn));
		
	echo '<META http-equiv="refresh" content="0;URL=ClassList.php"> ';
	require_once("SetupRight.php");
?>