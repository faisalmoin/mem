<?php
	session_start();
	require_once("../db.txt");
	
	$UserName=$_SESSION['UserName'];
	
	$UserCompany=mysql_query("SELECT `CompanyTableID`, `CompanyERPCode` FROM `usermap` WHERE `UserLoginID`='$LoginID'") or die(mysql_error());
	$UsrComp=mysql_fetch_array($UserCompany);
	
	$Company=mysql_query("SELECT * FROM `company` WHERE `id`='$UsrComp[0]'") or die(mysql_error());
	$Comp=mysql_fetch_array($Company);

	//Connect to SchoolERP DB
	$CompanyName=mysql_query("SELECT `Name` FROM `company` WHERE `id`='".$UsrComp[0]."'") or die(mysql_error());
	$CompName=mysql_fetch_array($CompanyName);
	
	$ms="$CompName[0]\$";
	
	$id = $_REQUEST['id'];
	
	if($_REQUEST['id'])
	{
		$id=$_REQUEST['id'];
		$sql = "SELECT [No_], [Fee Clasification Code] FROM [".$ms."Discount Fee Header] WHERE [Academic Year]='$id' ";
		
		$sql=odbc_exec($conn, $sql);
		while(odbc_fetch_array($sql))
		{
			echo '<option value="'.odbc_result($sql, "No_").'">'.odbc_result($sql, "Fee Clasification Code").'</option>';
		}
	}
?>
