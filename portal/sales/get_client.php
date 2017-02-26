<?php
//you'll have to replace your credentials here
require_once("../db.txt");
//perform lookup
$query1 = "SELECT [Date] FROM [CRM Opp Activity] WHERE [Opp ID]='".$_GET['OppNo']."' AND [Stage]='Agreement' AND [Level]='Agreement Signed'";
$row1=odbc_exec($conn, $query1) or die(odbc_errormsg($conn));

$query2 = "SELECT [Name], [City], [State], [Likely Brand], [User ID], [Assign To], [LOI File], [MOU File] FROM [CRM Oppurtunity] WHERE [Opp No]='".$_GET['OppNo']."' AND [Stage]='Agreement' AND [Level]='Agreement Signed'";
$row2=odbc_exec($conn, $query2) or die(odbc_errormsg($conn));



//print out results
//$row = mysql_fetch_array($result);
echo date('d/M/Y', odbc_result($row1, 'Date')).",".odbc_result($row2, 'Name').",".odbc_result($row2, 'City').",".odbc_result($row2, 'State').",".odbc_result($row2, 'Likely Brand').",".odbc_result($row2, 'LOI File').",".odbc_result($row2, 'MOU File').",".odbc_result($row2, 'Assign To').",".odbc_result($row2, 'Assign To');
?>
