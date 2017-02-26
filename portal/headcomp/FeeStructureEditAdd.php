<?php
	require_once("SetupLeft.php");
	
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [ID]='{$_POST['Id']}'") or exit(odbc_errormsg($conn));
	//  $check = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Description]='".$_REQUEST['Description']."' AND [Company Name]='$CompName' AND ([Class]='".$_REQUEST['Class']."' OR [Class]='') AND [Academic Year]='".$_REQUEST['Academic']."' ");
         //  if(odbc_num_rows($check)==0){
		$sql_update = "UPDATE [Class Fee Line] SET 
					[Academic Year]='".$_REQUEST['Academic']."',
					[Class]='".$_REQUEST['Class']."',
					[Description]='".$_REQUEST['Description']."',
					[Amount]=".(float)$_REQUEST['Amount'].",
					[No_ of months]='".$_REQUEST['months']."',
					[Total Amount]=".(float)($_REQUEST['toAmount']).",
					[Monthly Amount]=".(float)($_REQUEST['MonthlyAmount']).",
                    [Group Code]='".$_REQUEST['GroupCode']."'
					where [ID]='".$_REQUEST['Id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
          /* }
	//	exit($sql_update);
                   if(odbc_num_rows($check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Fee Structure Already Exist')
        window.history.go(-2);
        </SCRIPT>");
            }*/
		echo '<META http-equiv="refresh" content="0;URL=FeeStructureList.php"> ';
	//}
	require_once("SetupRight.php");
	?>