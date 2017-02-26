<?php
	require_once("SetupLeft.php");
	
	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$count; $i++){
		if($_REQUEST['Code'][$i] != ""){
			$Check = odbc_exec($conn, "SELECT [Code] FROM [curriculum] WHERE [Code]='".$_REQUEST['Code'][$i]."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($Check)==0){
				odbc_exec($conn, "INSERT INTO [curriculum] VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst($_REQUEST['Description'][$i])."', '$CompName')") or exit(odbc_errormsg($conn));
			}
		}
	}
?>
<meta http-equiv='refresh' content="0;URL='CurriculumList.php'" />
<?php
	require_once("SetupRight.php"); 
?>