<?php
	require_once("SetupLeft.php");
	
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Transport Slab] WHERE [ID]='{$_POST['id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Transport Slab] SET 
					[Slab Code]='".ucwords(strtoupper($_REQUEST['SlabCode']))."',
					[Slab Name]='".ucwords(strtoupper($_REQUEST['SlabName']))."',
					[Route No_]='".$_REQUEST['SlabRoute']."',
					[Amount]=".(float)($_REQUEST['SlabAmount']).",
					[Total Amount]=".(float)($_REQUEST['TotalAmount']).",
					[Monthly Amount]=".(float)($_REQUEST['MonthlyAmount']).",
					[Distance covered]=".intval($_REQUEST['SlabDistance']).",
					[No_ of months]='".$_REQUEST['months']."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=FeeTransportList.php"> ';
	//}
	
	require_once("SetupRight.php");
	?>