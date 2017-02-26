<?php
	set_time_limit(0);
	
	
		$myServer = ".\SQLEXPRESS";
		//$myServer = ".\SQLEXPRESS";
		$myUser = "root";
		$myPass = "schools@514";
		$myDB = "VMS_School";

		//$conn = odbc_connect("Driver={SQL Server};Server=$myServer;Database=$myDB;", $myUser, $myPass);
		$conn = odbc_connect("Driver={SQL Server};Server=$myServer;Database=$myDB;", $myUser, $myPass);
	
		if(!$conn){
			exit("<p style='color: #990000;'>Connection to DB via ODBC failed ...</p>");
		}
		

	error_reporting(E_USER_WARNING);
?>