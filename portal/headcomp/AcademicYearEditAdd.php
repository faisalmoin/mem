<?php
	require_once("SetupLeft.php");
	
	
	//$Acad = odbc_exec($conn, "SELECT * FROM [Academic Year] WHERE [ID]='{$_POST['id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Academic Year] SET 
					[Start Date]='".$_REQUEST['startDate']."',
					[End Date]='".$_REQUEST['endDate']."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=AcademicYearList.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>