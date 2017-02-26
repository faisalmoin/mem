<?php
	require_once("SetupLeft.php");
	
	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$count; $i++){
		if($_REQUEST['Code'][$i] != ""){
			
			$Check = odbc_exec($conn, "SELECT [Code] FROM [payment method] WHERE [Code]='".$_REQUEST['Code'][$i]."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($Check)==0){
				odbc_exec($conn, "INSERT INTO [Payment Method] (Code, Description, [Bal_ Account Type], [Bal_ Account No_], Synchronization, [Company Name], InsertStatus, UpdateStatus) VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst($_REQUEST['Description'][$i])."', 0, '', 0, '$CompName', 1,0)") or exit(odbc_errormsg($conn));
			}
		}
	}
          if(odbc_num_rows($Check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Already Exist')
        window.history.go(-2);
        </SCRIPT>");
            }
?>
<meta http-equiv='refresh' content="0;URL='FeePaymentList.php'" />
<?php
	require_once("SetupRight.php"); 
?>