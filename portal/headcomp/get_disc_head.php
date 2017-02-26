<?php
//you'll have to replace your credentials here
require_once("../db.txt");
//perform lookup
$query = "SELECT [Fee Clasification Code], [Academic Year], [Curriculum], [Class] FROM [Discount Fee Header] WHERE [No_]='".$_GET['id']."' AND [Company Name]='".$_GET['cmp']."'";
//echo $query;
$all="AllClass";
$rs = odbc_exec($conn, $query);
if(odbc_result($rs, "Class")==""){
echo odbc_result($rs, "Fee Clasification Code").", ".ltrim(odbc_result($rs, "Academic Year")).", ".odbc_result($rs, "Curriculum").", ".$all;
} else {
    echo odbc_result($rs, "Fee Clasification Code").", ".ltrim(odbc_result($rs, "Academic Year")).", ".odbc_result($rs, "Curriculum").", ".odbc_result($rs, "Class");
}
?>