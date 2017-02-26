<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("../db.txt");

//echo "SELECT [Amount], [Distance covered] FROM [Transport Slab] WHERE [Slab Code]='".mysql_real_escape_string($_GET['slab'])."' AND [Company Name]='".mysql_real_escape_string($_GET['comp'])."'" ;
//perform lookup
$query = "SELECT [Amount], [Distance covered] FROM [Transport Slab] WHERE [Slab Code]='".mysql_real_escape_string($_GET['slab'])."' AND [Company Name]='".mysql_real_escape_string($_GET['comp'])."'" ;
$result=  odbc_exec($conn, $query) or die(mysql_error());

//print out results
//$row = mysql_fetch_array($result);
echo odbc_result($result, "Amount").", ".odbc_result($result, "Distance covered");
?>
