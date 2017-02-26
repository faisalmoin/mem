<?php
//you'll have to replace your credentials here
require_once("../db.txt");
 $vendorinput=$_REQUEST['vendorinput'];
     
$SQL = "SELECT [Mobile],[Email],[Address],[Post Code],[State],[City],[Country],[Contact Person Details],[Vendor Name] from [VMS Vendor Master] WHERE [VendorCode]='".trim($vendorinput)."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
     
 echo odbc_result($result, 'Mobile').",".odbc_result($result, 'Email').",".odbc_result($result, 'Address').",".odbc_result($result, 'Post Code').",".odbc_result($result, 'State').",".odbc_result($result, 'City').",".odbc_result($result, 'Country').",".odbc_result($result, 'Contact Person Details').",".odbc_result($result, 'Vendor Name')."";
?>