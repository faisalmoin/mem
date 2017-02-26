<?php
	require_once("SetupLeft.php");
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Discount Fee Line] WHERE [ID]='{$_POST['Id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Discount Fee Line] SET 
				   [Discount%]='".$_REQUEST['Discount']."',
					[Description]='".$_REQUEST['Description']."'
					where [ID]='".$_REQUEST['Id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=FeeDiscLineList.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>