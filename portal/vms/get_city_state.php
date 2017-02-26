<?php
//you'll have to replace your credentials here
require_once("../db.txt");
//perform lookup
$query = "SELECT [City], [StateCode], [Country] FROM [postcode] WHERE [postcode]=".$_GET['zip'];
$row=odbc_exec($conn, $query) or die(odbc_errormsg($conn));

//print out results
//$row = mysql_fetch_array($result);
echo odbc_result($row, 'City').",".odbc_result($row, 'StateCode').",".odbc_result($row, 'Country');
?>