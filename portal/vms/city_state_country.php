<?php

require_once("../db.txt");

$query = "SELECT [City], [State], [Country] FROM [postcode] WHERE [PostCode]='".$_REQUEST['textinput']."'";
$result=odbc_exec($conn, $query) or die(odbc_errormsg($conn));
echo odbc_result($result, 'City').",".odbc_result($result, 'State').",".odbc_result($result, 'Country');
?>