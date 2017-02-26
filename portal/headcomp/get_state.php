
<?php
//you'll have to replace your credentials here
require_once("../db.txt");
//perform lookup
$query = "SELECT [City], [StateCode] FROM [postcode] WHERE [postcode]=".$_GET['zip'];
$row=odbc_exec($conn, $query) or die(odbc_errormsg($conn));
echo odbc_result($row, 'City').",".odbc_result($row, 'StateCode');

?>