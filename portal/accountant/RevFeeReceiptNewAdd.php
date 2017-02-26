<?php require_once("header.php");?>
	
	
	
	<?php
	require_once("../ConvertNum2Words.php");
        echo "<br/><br/><br/>";
  

?>
<!------------------------------------------------------------------------------>
<div class="container">	
	
  
	<?php
	        $cust_no=$_REQUEST['ID'];
                $InvoiceNo=$_REQUEST['invoice'];
                $InvDate= $_REQUEST['InvDate'];
           
                
	
//***************************************************approval Table Start *********************************

$Student = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Registration No_]='$cust_no' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
if($_REQUEST['Reverse']==1){

$Sql=odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login],[Invoice Date],[Remark]) "
        . "VALUES ('".time()."', '".odbc_result($Student, "No_")."','Reverse Invoice', '$InvoiceNo', '', '$ms', '0','Reverse','Ledger Credit','$LoginID','$InvDate','".$_REQUEST['Remark']."')") or die(odbc_errormsg($conn));

       
     //***************************************approval Table End*********************************   
     }else{
     
$Sql=odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login],[Invoice Date],[Remark]) "
        . "VALUES ('".time()."', '".odbc_result($Student, "No_")."','Reverse Invoice', '$InvoiceNo', '', '$ms', '0','Reverse And Generate','Ledger Credit','$LoginID','$InvDate','".$_REQUEST['Remark']."')") or die(odbc_errormsg($conn));

     
     }
     if($Sql){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Approval Request Succesfull')
    window.history.go(-2);
    </SCRIPT>");
	}         
            ?>
      
        
</div>

<!--script>
	var childWindows = [];
	
	var win = window.open("RevReceiptAdmission.php?id=<?php echo $cust_no?>&ms=<?php echo $ms?>&inv=<?php echo $inv_no ?>&loop=1","windowName", "width=900,height=500,scrollbars=no");
	win.focus();
	childWindows.push(win);	
	
</script-->



 
