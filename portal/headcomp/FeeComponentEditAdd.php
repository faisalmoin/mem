<?php
	require_once("SetupLeft.php");
	
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Fee Components] WHERE [ID]='{$_POST['id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Fee Components] SET 
					[Code]='".ucwords(strtoupper($_REQUEST['Code']))."',
					[Description]='".ucwords(strtolower($_REQUEST['Description']))."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=FeeComponentList.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>