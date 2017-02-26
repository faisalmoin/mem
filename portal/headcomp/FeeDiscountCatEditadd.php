<?php
	require_once("SetupLeft.php");
	
	$Acad = odbc_exec($conn, "SELECT * FROM [Fee Classification] WHERE [ID]='{$_POST['Id']}'") or exit(odbc_errormsg($conn));
	
		$sql_update = "UPDATE [Fee Classification] SET 
					[Description]='".$_REQUEST['Description']."'
					where [ID]='".$_REQUEST['Id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
                
                
                
                // class Edit
                /*
                if($_REQUEST['Class']== 'AllClass'){
                    
                $Acad1 = odbc_exec($conn, "SELECT * FROM [Fee Classification] WHERE [ID]='{$_POST['ClsId']}'") or exit(odbc_errormsg($conn));
	
		$sql_update1 = "UPDATE [Discount Fee Header] SET 
					[Class]=''
					where [ID]='".$_REQUEST['ClsId']."' ";
		odbc_exec($conn, $sql_update1) or die(odbc_errormsg($conn));
                }
                
                else{
                 * */
                 
                    $Acad1 = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [ID]='{$_POST['ClsId']}'") or exit(odbc_errormsg($conn));
	
		$sql_update1 = "UPDATE [Discount Fee Header] SET 
					[Class]='".$_REQUEST['Class']."',
                                        [Curriculum]='".$_REQUEST['Curriculum']."',
                                        [Academic Year]='".$_REQUEST['Academic']."'
                                       where [ID]='".$_REQUEST['ClsId']."' ";
		odbc_exec($conn, $sql_update1) or die(odbc_errormsg($conn));
               // }
                    
		//exit($sql_update);
		echo '<META http-equiv="refresh" content="0;URL=FeeDiscountCatList.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>