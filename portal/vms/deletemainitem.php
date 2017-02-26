<?php 
require_once("../db.txt");
$poid=$_GET['poid'];
$id=$_GET['id'];
$sum=$_GET['sum'];
$sums=number_format((float)$sum, 2, '.', '');
echo $upt="UPDATE [VMS Final PO] SET
          [Gtotal]='".$sums."'
          WHERE [PO ID]='".$poid."'";
 odbc_exec($conn, $upt) or die(odbc_errormsg($conn));

if($id!=0){
  $select="delete from [VMS Final PO] where [PO ID]='".$poid."' AND [ID]='".$id."' ";
odbc_exec($conn, $select) or die(odbc_errormsg($conn));
}
header("Location: PurchaseOrderListEdit.php?ID=$poid");
?>