<?php
	
	require_once("SetupLeft.php");
	
	$count = 5;
	$SQL = "";
	$Company = $_REQUEST['Company'];
	if($Company == "*"){
		$Comp = odbc_exec($conn, "SELECT [ID], [Name] FROM [Company Information]") or exit(odbc_errormsg($conn));
		while(odbc_fetch_array($Comp)){
			for($i=1; $i<=5; $i++){
				if($_REQUEST['insert'.$i] == 1){
					$SQL .= "INSERT INTO [Academic Year] ([Code], [Description], [Sequence], [Closed], [Start Date], [End Date], [User ID], [Portal ID], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) VALUES  ('".$_REQUEST["Code".$i]."','".$_REQUEST["Code".$i]."', 0,0,'".
					$_REQUEST["startDate".$i]."',  '".$_REQUEST["endDate".$i]."', 'ADMIN', 'ADMIN',0,'".odbc_result($Comp, "ID")."',0,0)"; 
					
					$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
					odbc_close ( $conn );
					if(!$result){
						exit ("Unable to insert record for Academic Year : ".$_REQUEST["Code".$i]." ...");
					}
					else{
						$result++;
					}
				}
			}
		}
	
	}
	else{
		for($i=1; $i<=5; $i++){
			if($_REQUEST['insert'.$i] == 1){
				
				$SQL = "INSERT INTO [Academic Year] ([Code], [Description], [Sequence], [Closed], [Start Date], [End Date], [User ID], [Portal ID], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) VALUES  ('".$_REQUEST["Code".$i]."','".$_REQUEST["Code".$i]."', 0,0,'".
				$_REQUEST["startDate".$i]."',  '".$_REQUEST["endDate".$i]."', 'ADMIN', 'ADMIN',0,'".$Company."',0,0)"; 
				
				$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
				if(!$result){
					exit ("Unable to insert record for Academic Year : ".$_REQUEST["Code".$i]." ...");
				}
				else{
					$result++;
				}
				
			}
		}
		
	
	}
	
	if($result > 0){
		echo "Academic Year recorded successfully ...";
	}
	
	require_once("SetupRight.php");
?>