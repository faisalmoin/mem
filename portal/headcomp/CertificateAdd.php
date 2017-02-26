<?php
	require_once("SetupLeft.php");
	
	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$count; $i++){
		if($_REQUEST['Code'][$i] != ""){
			$Check = odbc_exec($conn, "SELECT [Code] FROM [Certificate] WHERE [Code]='".$_REQUEST['Code'][$i]."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($Check)==0){
				odbc_exec($conn, "INSERT INTO [Certificate]([Code], [Description],[User ID],[Portal ID],Synchronization,[Company Name],InsertStatus,UpdateStatus) 
				VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst(strtolower($_REQUEST['Description'][$i]))."', '$LoginID','$LoginID',0, '$CompName',1,0)") or exit(odbc_errormsg($conn));
			}
		}
	}
?>
<meta http-equiv='refresh' content="0;URL='CertificateList.php'" />
<?php
	require_once("SetupRight.php"); 
?>