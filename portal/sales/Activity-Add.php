<?php
	require_once("header.php");
	
	$d= $_REQUEST['LeadDT'];
	$dt = explode('/', $d);
	$dt = $dt[0]." ".$dt[1]." ". $dt[2];
	
	echo "<div class='container'>";
	
	//Get Activity
	$act = odbc_exec($conn, "SELECT [Text] FROM [CRM Activity Master] WHERE [ID]='".$_REQUEST['Activity']."'") or die(odbc_errormsg($conn));
	
	$SQL = "INSERT INTO [CRM Daily Activity] ([Lead ID], [Activity Type], [Date], [Start Time], [End Time], [Activities], [Contact Person], [Contact No], [Remarks], 
			[Status], [Post Date], [Assign To], [Outcome], [Activity For])			
			VALUES ('".$_REQUEST['LeadID']."', 'Lead', '".strtotime($dt)."', '".$_REQUEST['StartTime']."', '".$_REQUEST['EndTime']."', '".odbc_result($act, "Text")."',
			'".$_REQUEST['ContactPerson']."', '".$_REQUEST['ContactNo']."', '".str_replace("'", "''",$_REQUEST['LeadRem'])."', '".$_REQUEST['LeadStat']."',  '".strtotime(date('Y-m-d'))."', 
			'$LoginID', '".$_REQUEST['Outcome']."', '' )";
	
	$result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
	
	if($result) echo '<script>alert("Daily Activity has been successfully created ..."); window.location = "Lead-List.php";</script>';
	else echo '<script>alert("Error encountered while creating Activity ..."); window.location = "Activity-New.php";</script>';
		
	echo "</div>";
	require_once("../footer.php")

?>