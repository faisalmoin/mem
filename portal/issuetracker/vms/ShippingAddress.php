<?php
//you'll have to replace your credentials here
require_once("../db.txt");
 $shippingname=$_REQUEST['textinput'];
   
$SQL = "SELECT * from [VMS Shipping Master] WHERE [StoreCode]='".trim($shippingname)."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
     
 echo odbc_result($result, 'Shipping Mobile').",".odbc_result($result, 'Shipping Email').",".odbc_result($result, 'Shipping Address').",".odbc_result($result, 'Shipping City').",".odbc_result($result, 'Shipping State').",".odbc_result($result, 'Shipping Country').",".odbc_result($result, 'Shipping Post Code').",".odbc_result($result, 'Shipping Contact Name').",".$id;
?>