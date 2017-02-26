<?php
//you'll have to replace your credentials here
require_once("../db.txt");
 $itemname=$_REQUEST['textinput'];
      $id=$_REQUEST['id'];
$SQL = "SELECT [Specifications],[UOM] from [VMS Item Master] WHERE [Item Name]='".trim($itemname)."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
     
 echo odbc_result($result, 'Specifications').",".odbc_result($result, 'UOM').",".$id;
?>