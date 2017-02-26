<?php
	require_once("../db.txt");
	$id = $_REQUEST['id'];
	$type = $_REQUEST['type'];
	
	$outcome = odbc_exec($conn, "SELECT [Outcome] FROM [CRM Outcome Master] WHERE [Activity ID]='$id' AND [Type]='$type'") or die(odbc_errormsg($conn));
	//$outcome = odbc_exec($conn, "SELECT [Outcome] FROM [CRM Outcome Master] WHERE [Activity ID]='$id' ") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($outcome)){
		echo "<option value='".odbc_result($outcome, "Outcome")."'>".odbc_result($outcome, "Outcome")."</option>";
	}
?>