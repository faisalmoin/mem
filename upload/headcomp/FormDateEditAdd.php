<?php
	require_once("SetupLeft.php");
	
		$sql_update = "UPDATE [RegFormToDate] SET 
					[Start Date]='".strtotime(str_replace("/", " ", $_REQUEST['startDate'.$i]))."',
					[End Date]='".strtotime(str_replace("/", " ", $_REQUEST['endDate'.$i]))."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
	echo '<META http-equiv="refresh" content="0;URL=LinkDetails.php"> ';
	require_once("SetupRight.php");
	?>