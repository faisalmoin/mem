<?php
	require_once("../db.txt");

	$PostCode = intval($_GET['q']);
	
	$SQL = odbc_exec($conn, "SELECT * FROM [PostCode] WHERE [PostCode]='$PostCode'");
	//$SQL = mysql_fetch_array($SQL1);
	$City = odbc_result($SQL, 'City');
	$PC = odbc_result($SQL, 'PostCode');
	$State = odbc_result($SQL, 'City');
	$Country = odbc_result($SQL, 'Country');
	
	echo "$City, $State";
?>