<?php
	
	require_once("SetupLeft.php");
	$ins = 0;
	$count = 5;
	for($i=1; $i<=5; $i++){
		if($_REQUEST['insert'.$i] == 1){
			$Check = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Code]='".$_REQUEST["Code".$i]."' AND [Company Name]='$CompName' ") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($Check) == 0){
			
				$SQL = "INSERT INTO [Academic Year] ([Code], [Description], [Sequence], [Closed], [Start Date], [End Date], [User ID], [Portal ID], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) VALUES  
					('".$_REQUEST["Code".$i]."','".$_REQUEST["Code".$i]."', 0,0,'".$_REQUEST["startDate".$i]."',  '".$_REQUEST["endDate".$i]."', '$LoginID', '$LoginID',0,'".$CompName."',0,0)"; 
			/*	print_r("INSERT INTO [Academic Year] ([Code], [Description], [Sequence], [Closed], [Start Date], [End Date], [User ID], [Portal ID], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) VALUES  
					('".$_REQUEST["Code".$i]."','".$_REQUEST["Code".$i]."', 0,0,'".
					$_REQUEST["startDate".$i]."',  '".$_REQUEST["endDate".$i]."', '$LoginID', '$LoginID',0,'".$CompName."',0,0)");
				die; */
				$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
				var_dump($result);
				if(!$result){
					exit ("Unable to insert record for Academic Year : ".$_REQUEST["Code".$i]." ...");					
				}
			}
		}
	}	
          if(odbc_num_rows($check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Fee Structure already exist')
        window.history.go(-2);
        </SCRIPT>");
            }
?>

<meta http-equiv='refresh' content="0;URL='AcademicYearList.php'" />

<?php require_once("SetupRight.php"); ?>