<?php
//you'll have to replace your credentials here
require_once("../db.txt");
      $itemspecno=$_REQUEST['textinput'];
      $itemid=$_REQUEST['itemid'];
 
  
 $SQL2 = "SELECT * from [VMS Specifications Master] WHERE [ID]='".$itemspecno."'";
 $result2 = odbc_exec($conn, $SQL2) or die(odbc_errormsg($conn));
 
echo odbc_result($result2, 'Make').",".odbc_result($result2, 'Model').",".odbc_result($result2, 'Warranty').",".$itemid;
 
?>

