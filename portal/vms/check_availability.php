<?php 
require_once("../db.txt");
if(!empty($_POST["textinput1"])) {
 $qry="SELECT count(*) AS [NUM] FROM [VMS Create PO] WHERE [VendorInvoiceNo]='".$_POST["textinput1"]."' AND [VendorCode]='".$_POST["textinput2"]."'";
 $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
echo $num=odbc_result($result,"NUM");

}

?>