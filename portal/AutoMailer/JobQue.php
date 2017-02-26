<?php
	require_once("../db.txt");
	require_once "Mail.php";
	
	$sql = "select top 1 [Entry No_], [Start Date_Time], [Status], [Error Message], [Error Message 2], [Error Message 3], 
	[Error Message 4]  from schoolerp.dbo.[Training Company-TMS\$Job Queue Log Entry] ORDER BY [Entry No_] DESC";
	
	$result=odbc_exec($conn, $sql) or exit(odbc_errormsg($conn));
	$body="<html>
			<head></head>
			<body>
				<h3>JOB QUEUE Error:</h3>
				<p>ID:".odbc_result($result, "Entry No_")."</p>
				<p>Timestamp:".odbc_result($result, "Start Date_Time")."</p>
				<p>Error Message:".odbc_result($result, "Error Message")." ".odbc_result($result, "Error Message 2")." ".odbc_result($result, "Error Message 3")."".odbc_result($result, "Error Message 4")."</p>
			</body>
		</html>";
	
	$subject = "SchoolERP // Job Queue Error Message // ID: ".odbc_result($result, "Entry No_");
		
	
	if(odbc_result($result, "Status") != 0){
		
		$to = "anoop.bharti@educompschools.com, abuzar.shaikh@corporateserve.com, pallab.db@educomp.com, prabhakar.cs@educomp.com";
		//$to = "pallab.db@educomp.com";
		$from = "SchoolERP <donotreply@educompschools.com>";
		require_once("../smtp.php");
	
	}
	else{
		
		echo $body;
	}

?>