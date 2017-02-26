<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include('../db.txt');
if($_POST['id'])
{
    $id=$_POST['id'];
    
    if($id == 1){
        $query = "SELECT [Trust Name] AS [Name], [ID] AS [ID] FROM [CRM Agreement]";
    }    
    if($id == 2){
        $query = "SELECT [School Name] AS [Name], [ID] AS [ID] FROM [Company Information]";
    }

    $stmt = odbc_exec($conn, $query) or odbc_errormsg($conn);
    ?><option selected="selected" value=""></option><?php
    while(odbc_fetch_array($stmt))
    {
        ?>
        <option value="<?php echo odbc_result($stmt, "ID"); ?>"><?php echo odbc_result($stmt, "Name"); ?></option>
    <?php
    }
}
?>