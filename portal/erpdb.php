<?
	require_once("mssql.php");
	
	$mssql1="SELECT * FROM [Training Company-TMS\$Language]";
	$msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
?>

<?
	//echo odbc_result($msAY, "");
	
	
	while($rs=odbc_fetch_array($msAY)){
		print_r($rs);
	}
	
	/*
	while(odbc_fetch_array($msAY)){
		echo odbc_result($msAY, "Code")." - ".odbc_result($msAY, "City")."<br />";
	}
	*/
	
	/*
	while(odbc_fetch_array($msAY)){
		$PCid .= "{".odbc_result($msAY, "Code").": {".odbc_result($msAY, "City")."},";
	}
	$PCid .= "}";
	
	echo $PCid;
	*/
?>
