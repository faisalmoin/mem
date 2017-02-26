
<?php

$myServer = "10.0.0.37";
$myUser = "kanchan";
$myPass = "gold@1235";
$myDB = "schoolerp";

$conn = odbc_connect("Driver={SQL Server};Server=$myServer;Database=$myDB;", $myUser, $myPass);
if($conn){
	echo "<p>Connection to Database - Success</p>";
}
else{
		echo "<p>Connection to DB via ODBC failed: ";
		echo odbc_errormsg ($conn );
		echo "</p>\n";
}

$SQL = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ORDER BY TABLE_NAME";
$rs = odbc_exec($conn,$SQL);
echo "<table><tr><td>Table_Name</td></tr>";
while (odbc_fetch_row($rs)){
	$result = odbc_result($rs,"TABLE_NAME");
	echo "<tr><td>$result</td></tr>";
}
odbc_close($conn);
echo "</table>";

//select a database to work with
//$selected = odbc_select_db($myDB, $dbhandle) or die("Couldn't open database $myDB"); 

/*
phpinfo();
*/
?>
