<?php
	require_once("SetupLeft.php");
	
	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$count; $i++){
		if($_REQUEST['Code'][$i] != ""){
			$Check = odbc_exec($conn, "SELECT [Code] FROM [Fee Components] WHERE [Code]='".$_REQUEST['Code'][$i]."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($Check)==0){
				odbc_exec($conn, "INSERT INTO [Fee Components]([Code], [Description], [G_L Account], [Fee Group],[Check Duplication],[No Of Months],[User ID],[Portal ID],[Batch Report],[Pay in Slip],Synchronization,[Company Name],InsertStatus,UpdateStatus) 
				VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst($_REQUEST['Description'][$i])."', '', 0,0,0,'$LoginID','$LoginID',0, '',0, '$CompName',0,0)") or exit(odbc_errormsg($conn));
			}
		}
	}
          if(odbc_num_rows($Check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Already Exists')
        window.history.go(-2);
        </SCRIPT>");
            }
?>
<meta http-equiv='refresh' content="0;URL='FeeComponentList.php'" />
<?php
	require_once("SetupRight.php"); 
?>