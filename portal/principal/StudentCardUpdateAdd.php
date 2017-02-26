<?php require_once('header.php');

echo "<br /><br /><br />";
$id=$_REQUEST['id'];

    $get_val_CustomerNo = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [No_]='$id' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
    $Customerno=odbc_result($get_val_CustomerNo, "Registration No_");
    
    for($i=0; $i<$_REQUEST['count']; $i++){
    //Table Namesa
    $TableName = $_REQUEST['TableName'.$i];
    $FieldName = $_REQUEST['FieldName'.$i];
    $Action = $_REQUEST['Action'.$i];
    $tb_id = $_REQUEST['tbl_id'.$i];
    
    $get_val = odbc_exec($conn, "SELECT * FROM [Student Card Changes] WHERE [ID]='$tb_id' ") or die(odbc_errormsg($conn));
     
    if($_REQUEST['ApproveStatus'.$i]==1){        
        if($Action == "Update" && $FieldName != "Route No_"){
            $SQL1 = "UPDATE [$TableName] SET [$FieldName]='".odbc_result($get_val, "New Value")."' WHERE [No_]='$id' AND [Company Name]='$ms'";
            odbc_exec($conn, $SQL1) or exit(odbc_errormsg($conn)); // OneTime
           echo "$SQL1<br>";
           echo "<br />";
             $sqlA = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sqlA) or exit(odbc_errormsg($conn)); // OneTime
         //echo $sqlA;
        //echo "<br />";  
        }
        else if($Action == "Insert"){
            $rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$ms' AND [ID]='".odbc_result($get_val, "New Value")."' ") or die(odbc_errormsg($conn));
          
            $cls = odbc_exec($conn, "select [Description] from [Fee Classification] where [Code]='".odbc_result($rs, 'Fee Clasification Code')."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
          
            $SQL2 = "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".odbc_result($get_val, "New Value")."','".odbc_result($cls, "Description")."','".odbc_result($rs, "No_")."')";
          odbc_exec($conn, $SQL2) or exit(odbc_errormsg($conn)); // OneTime
         // echo "$SQL2<br>";
         //  echo "<br />";
            $sqlB = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sqlB) or exit(odbc_errormsg($conn)); // OneTime
           //  echo $sqlB;
        //echo "<br />";
        }
        
        else if($Action == "Delete"){
            $SQL3 = "DELETE FROM [StudentDiscountDetails] WHERE [CompanyName]='$ms' AND [DiscountNo]='".odbc_result($get_val, "New Value")."' AND [ApplicationNo]='$Customerno' ";
           odbc_exec($conn, $SQL3) or exit(odbc_errormsg($conn)); // OneTime
         // echo "$SQL3<br>";
         //  echo "<br />";
            $sqlC = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sqlC) or exit(odbc_errormsg($conn)); // OneTime
            // echo $sqlC;
       // echo "<br />";
            }
 

      //*********************Transport Update And Insert*************************************    
      else if($Action == "Update" && $FieldName == "Route No_")
        {
            $transportSlab=odbc_exec($conn, "SELECT * FROM [Transport Slab] WHERE [Company Name]='$ms' AND [Slab Code]= '".odbc_result($get_val, "New Value")."' ") or die(odbc_errormsg($conn));
           


             $SQL4 = "UPDATE [$TableName] SET [Route No_]='".odbc_result($get_val, "New Value")."',
             [Slab Code]='".odbc_result($get_val, "New Value")."',
             [Distance Covered in KM]='".odbc_result($transportSlab, "Distance Covered")."',
             [Transport Fee]='".number_format(odbc_result($transportSlab, "Amount"),'2','.','')."'
              WHERE [No_]='$id' AND [Company Name]='$ms'";
            odbc_exec($conn, $SQL4) or exit(odbc_errormsg($conn)); // OneTime
           // echo "$SQL4<br>";
           // echo "<br />"; 

               $sqlD = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sqlD) or exit(odbc_errormsg($conn)); // OneTime
              //  echo $sqlD;
      //  echo "<br />";

        }
//***************************************************************************************************************
  else if($Action == "Reverse And Generate" && $TableName == "Ledger Credit")
  {
    $today = time();;
   if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
            $FinYr = date('y', $today)."-".(date('y', $today)+1);
        } else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
            $FinYr = (date('y', $today)-1)."-".date('y', $today);
        }
    if($inv_dt >= $q1Sdt && $inv_dt <= $q1Edt ) {$Qtr = 2;}
    elseif($inv_dt >= $q2Sdt && $inv_dt <= $q2Edt ) {$Qtr = 3;}
    elseif($inv_dt >= $q3Sdt && $inv_dt <= $q3Edt ) {$Qtr = 4;}
    elseif($inv_dt >= $q4Sdt && $inv_dt <= $q4Edt ) {$Qtr = 5;}
    else{
        $Qtr = 2;
    }
    
    $invoice = odbc_result($get_val, "New Value");
    $CustomerNo = $Customerno;
    $stu = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Student] WHERE [Company Name]='$ms' AND [Registration No_]= '$CustomerNo'") or die(odbc_errormsg($conn));
    if(odbc_num_rows($stu) == 0){
        $stu1 = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]= '$CustomerNo'") or die(odbc_errormsg($conn));
        $Name = odbc_result($stu1, "Name");
        $Addressee = odbc_result($stu1, "Addressee");
        $Class = odbc_result($stu1, "Class");
        $Acad = odbc_result($stu1, "Academic Year");
    }
    else{
        $Name = odbc_result($stu, "Name");
        $Addressee = odbc_result($stu, "Addressee");
        $Class = odbc_result($stu, "Class");
        $Acad = odbc_result($stu, "Academic Year");
    }
    //echo "Error";
?>
 
        <div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Enquiry Form</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>


<div class="clearfix"></div>
</div>
<div class="x_content">
            <?php 
            $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$CustomerNo' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
               $AdmissionNo = odbc_result($Admission, "No_");
            ?>
            <!--h3 style="float: left; background-color: #c8fca1" class="text-primary">Student No - <?php echo $AdmissionNo?></h3> <h3 class="text-primary" style="background-color: #c8fca1;float: right">Invoice No - <?php echo $invoice?></h3-->
              <table class="table table-responsive" hidden="true">
                <tr>
                    <!-----------------------------old Invoice------------------------------>
                    <form action="RevFeeReceiptNewAdd.php" id="dateForm" method="post" name="form" onsubmit="return CheckThis(this)">
            <td style="background-color: #e4f1fe ; width: 50%;" valign="top">
                        <table class="table table-responsive" style="background-color: #e4f1fe;">
            <?php
            $invNo = "";
                $CreditInvNo = odbc_exec($conn, "SELECT * FROM [ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo'" ) or die(odbc_errormsg(odbc_errormsg()));
               
                        while(odbc_fetch_array($CreditInvNo)){
                            $a = odbc_result($CreditInvNo, "Credit Amount");
                            $DebitInvNo = odbc_exec($conn, "SELECT * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='".odbc_result($CreditInvNo, "Invoice No")."' ") or die(odbc_errormsg("133"));
                            $b=odbc_result($DebitInvNo, "Debit Amount")+odbc_result($DebitInvNo, "Adv Fee");


                            if($a >= $b || odbc_num_rows($DebitInvNo)==0)
                            {
                                    $invNo .= "'".odbc_result($CreditInvNo, "Invoice No")."', ";
                            }
                         }

                        $invNo = substr($invNo, 0, -2);
                        $m=1;
                        $n=1;
                        $nTot = 0;
                        
                        
                        //----------------------------------------------
                        $Old = "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' AND"; 
                        $Old .= " [Fee Description] LIKE 'Net %' AND [Fee Description] LIKE '% payable' ";
                       // echo $Old;
                        $OldValue = odbc_exec($conn, $Old) or die(odbc_errormsg($conn));
                         while(odbc_fetch_array($OldValue)){
                             ?>
            <input value="<?php echo number_format(odbc_result($OldValue, "Net Amount"),2,".", "");?>"  type="hidden" name="OldAmount<?php echo $n; ?>">
            <input value="<?php echo odbc_result($OldValue, "Fee Description");?>"  type="hidden" name="OldDescription<?php echo $n; ?>">
                            <input type="hidden" name="feecount" value ="<?php echo $n; ?>" />
                            
                            
                             <?php
                             $n++;
                         }?>
                  
                        <!-------------------------------------------->
                <tr style="background-color: #ffffe3;">
                        <th style="border: none;">Fee Description</th>
                        <th style="border: none;">Old Fee Invoice</th>
                       
                </tr>                   
                <?php
                        $sql1 = "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' "; 
                        $rs = odbc_exec($conn, $sql1) or die(odbc_errormsg($conn));
                        ?>
                <tr>
                    <?php
                        while(odbc_fetch_array($rs)){
                        $qry1 = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo'  AND  [Fee Description] = '".odbc_result($rs, "Fee Description")."' AND [Qtr]= '$Qtr'") or die(odbc_errormsg($conn));
                        $diff = odbc_result($rs, "Net Amount") - odbc_result($qry1, "");
                        $nTot += odbc_result($rs, "Net Amount");
                    ?>      
                    
                        <td style="border: none; "><?php echo odbc_result($rs, "Fee Description"); 
        if( odbc_result($rs, "Discount Code1") != "" ||  odbc_result($rs, "Discount Code1") == "-"  ) {
            echo " ".odbc_result($rs, "Discount Code1" )."";
        }
        else{
            echo "";
        }                       
    ?></td>
                        <td style="border: none; ">
                            <?php if(odbc_result($rs, "Amount")!=0){?>
                            <input value="<?php echo number_format(odbc_result($rs, "Amount"),2,".", "");?>"  type="text" name="net_amt<?php echo $m; ?>" 
                            class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                            required readonly><?php } ?>
                            <?php if(odbc_result($rs, "Discount Code1 Amount")!=0){?>
                            <input value="<?php echo number_format(odbc_result($rs, "Discount Code1 Amount"),2,".", "");?>" 
                            type="text" name="net_amt<?php echo $m; ?>" 
                            class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                            required readonly><?php } ?>
                            <?php if( odbc_result($rs, "Amount")  == 0 && odbc_result($rs, "Discount Code1 Amount") == 0 ){?>
                            <input value="<?php echo number_format(odbc_result($rs, "Net Amount"),2,".", "");?>" 
                            type="text" name="net_amt<?php echo $m; ?>" 
                            class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                            required readonly><?php } ?>
                            <input value="<?php echo odbc_result($rs, "ID");?>"  type="hidden" name="InvoiceID<?php echo $m; ?>" >
                        </td>
                        
                </tr>
                  
            
                         <?php
                        $m++;
                        }   
                        ?>
                <tr>
                        <td style="border: none; ">Total</td>
                        <td style="border: none; "><input type="text" id="total1" value="<?php echo number_format($nTot,2,".", "");?>" name="" class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                </tr>
</table>
            </td>
                    
                <!-----------------------------New Invoice------------------------------>
                <td style="border: none;">
                
                   <table class="table jumbotron" style="width: 100%; ">
                   <tr style="background-color: #ffffe3;">
                        <th style="border: none;">Fee Description</th>
                        <th style="border: none;">New Fee Invoice</th>
                    </tr>     
                    <tr>
                    <?php $f=1;
                    $gTotal = 0;
                    $Fee = odbc_exec($conn, "Select * FROM [StudentFee] where [ApplicationNo]='$CustomerNo' AND [CompanyName]='$ms'");
                    while(odbc_fetch_array($Fee)){
                           if(odbc_result($Fee, "FeeNo") != ""){
                           $rs1 = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [id]='".odbc_result($Fee, "FeeNo")."' ") or die(odbc_errormsg($conn));
                           while(odbc_fetch_array($rs1)){
                           ?>
            
                    <td style="border: none; "><?php echo odbc_result($rs1, "Description"); ?>
                    <input value="<?php echo odbc_result($rs1, "Description"); ?>" type="hidden" name="DescriptionA<?php echo $f;?>" > </td>
                    <td style="border: none;">
                    <?php if(odbc_result($rs1, "Amount")!=0){?>
                    <input value="<?php echo number_format(odbc_result($rs1, "Amount"),2,".", ""); ?>" type="text"  
                            name="amt_paidA<?php echo $f;?>" 
                            class="amt_paid form-control" id="amt_paidA<?php echo $f;?>" readonly="true" 
                            style="padding:4px; background-color: #f6fca1 ; border: 1px solid #C0C0C0;width: 170px; text-align: right;" 
                            onkeypress='return validateQty(event)'
                            onchange="InputSum()"
                            onblur="myFunction()" >
                    <?php } ?>
                    </td></tr>
                    <?php           
            
                    $new_amt = odbc_result($rs1, "Amount");
                    $d=1;
                    $Discount = odbc_exec($conn, "Select * FROM [StudentDiscountDetails] where [ApplicationNo]='$CustomerNo' AND [CompanyName]='$ms'");
                    while(odbc_fetch_array($Discount)){ 
                    $e=0;
                    if(odbc_result($Discount, "DiscountNo") != ""){
                    $disc_fee_hdr = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [id]='".odbc_result($Discount, "DiscountNo")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                    $disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$ms' AND [Fee Code]='".odbc_result($rs1, "Fee Code")."' AND [Academic Year]='$FinYr' AND [Document No_]='".odbc_result($disc_fee_hdr, "No_")."' ") or die(odbc_errormsg($conn));

                    if(odbc_result($disc_fee_line, "Description") != ""){
                            $e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
                            $new_amt = $new_amt - $e;?>
                 
                     <?php if($e!=0){?>
                   <tr>
                    <td style="border: none; "><?php echo odbc_result($disc_fee_line, "Description"); ?>
                    <input value="<?php echo odbc_result($disc_fee_line, "Description"); ?>" type="hidden" name="DescriptionB<?php echo $f;?>"> </td>
                     <td style="border: none;"><input value="<?php echo number_format($e,2,".", ""); ?>" type="text"  
                            name="amt_paidB<?php echo $f;?>" readonly="true" 
                            class="amt_paid form-control" id="amt_paidB<?php echo $f;?>" 
                            style="padding:4px; background-color: #f6fca1 ; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                            onkeypress='return validateQty(event)'
                            onchange="InputSum()"
                            onblur="myFunction()"
                            ></td>
                   </tr>
                             <?php
                                }
                                }
                                }
                                }
                                $d++;
                                }
                                }
                   //  if($new_amt!=0){
                         ?>
                    <tr>
                      <td style="border: none; "><b><?php echo "Net ".odbc_result($rs1, "Description")." payable"; ?>
                      <input value="<?php echo "Net ".odbc_result($rs1, "Description")." payable"; ?>" type="hidden" name="DescriptionC<?php echo $f;?>" ></b> </td>
                      <td style="border: none;"><input value="<?php echo number_format($new_amt,2,".", ""); ?>" type="text" readonly="true" 
                      name="amt_paidC<?php echo $f;?>" 
                      class="amt_paid form-control" id="amt_paidC<?php echo $f;?>" 
                      style="padding:4px; background-color: #F5BCA9 ; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                      onkeypress='return validateQty(event)'
                      onchange="InputSum()"
                      onblur="myFunction()"
                      ></td> 
                    </tr>
                     <?php 
                      $f++; 
                    } ?>
                                   
              <!-------------------------------------------------------------------------------------------->
                        <tr>
                            <td style="border: none; color: #0B0B61;font-size: 20px "><b>Total Amount</b></td>
                            <td style="border: none; "><input type="text" id="total2" name="total2" class="total2 form-control" readonly="true" value="<?php echo number_format($gTotal,2,".", "");?>"
                                    style="background-color: #c8fca1; padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;"></td>
                        </tr>
                   
                        <?php 
                          $creditp = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' ") or die(odbc_errormsg($conn));
                        ?>
                        <tr>
                                <td style="border: none; "></td>
                                <input type="hidden" value="<?php echo $AdmissionNo;?>" name="AdmissionNo" />
                                <input type="hidden" value="<?php echo $CustomerNo;?>" name="ID" />
                                <input type="hidden" value="<?php echo $f;?>" name="fee_count">
                                <input type="hidden" value="<?php echo $invoice;?>" name="invoice">
                                <input type="hidden" value="<?php echo $tb_id;?>" name="tb_id">
                                <input type="hidden" value="<?php echo odbc_result($rs, "Invoice Date" );?>" name="InvDate">
                                <input type="hidden" value="<?php echo odbc_result($creditp, "Posting No" );?>" name="PostingNo">
                                <td style="border: none; "><input type="submit" value="submit" class="btn btn-success"/></td>
                        </tr>
                        </table>
               
                    </form> 
              </td>
            </tr>
    </table> 
   
  <?php      }
 //********************************************************************************************************
    
        else if($Action == "Reverse" && $TableName == "Ledger Credit")
        {   $invoice = odbc_result($get_val, "New Value");
            $CustomerNo = $Customerno;
    
             
               if($invoice!="" && $CustomerNo!=""){
                $LedInvUpdate= "UPDATE [Ledger Invoice] SET [Reverse]=1 WHERE [Customer No] = '$CustomerNo'
                        AND [Company Name]='$ms' AND 
                        [Invoice No] ='$invoice' ";
               odbc_exec($conn, $LedInvUpdate) or exit(odbc_errormsg($conn));
               //  echo $LedInvUpdate;
                 // echo "<br />";
                }
              
                if($invoice!="" && $CustomerNo!=""){
                $LedCreUpdate= "UPDATE [Ledger Credit] SET [Reverse]=1 WHERE [Customer No] = '$CustomerNo'
                        AND [Company Name]='$ms' AND 
                        [Invoice No] ='$invoice' ";
               odbc_exec($conn, $LedCreUpdate) or exit(odbc_errormsg($conn));
                 //echo $LedCreUpdate;
                 //echo "<br />";
                }


                 if($invoice!="" && $CustomerNo!=""){
                $LedDebUpdate= "UPDATE [Ledger Debit] SET [Reverse]=1 WHERE [Customer No] = '$CustomerNo'
                        AND [Company Name]='$ms' AND 
                        [Invoice No] ='$invoice' ";
               odbc_exec($conn, $LedDebUpdate) or exit(odbc_errormsg($conn));
                //echo $LedDebUpdate;
                //echo "<br />";
                }

                 if($invoice!="" && $CustomerNo!=""){
                $LedPayUpdate= "UPDATE [Ledger Payment] SET [Reverse]=1 WHERE [Customer No] = '$CustomerNo'
                        AND [Company Name]='$ms' AND 
                        [Invoice No] ='$invoice' ";
               odbc_exec($conn, $LedPayUpdate) or exit(odbc_errormsg($conn));
               //  echo $LedPayUpdate;
               //echo "<br />";
                }
                   $sqlF = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sqlF) or exit(odbc_errormsg($conn)); // OneTime
        }
         //*********************Transport Update And Insert End************************************* 
    }// ApproveStatus=1 End


 if($_REQUEST['ApproveStatus'.$i]==2){
       $sql = "UPDATE [Student Card Changes] SET [Status]= 2 WHERE [ID]='".$tb_id."' AND [Student No_]='$id' AND [Company Name]='$ms'";
       odbc_exec($conn, $sql) or exit(odbc_errormsg($conn)); // OneTime
       // echo $sql;
      //  echo "<br />";
    }
    
}

echo '<META http-equiv="refresh" content="0;URL=StudentCardApp.php"> ';

/*
if($sql_update){
        echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    window.history.go(-2);
    </SCRIPT>");
    }*/

//}


?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
   <script  type='text/javascript'>
       
        
        $(document).ready(function(){
            InputSum();
         });
        
        function InputSum() {
            var sum = 0;
            $('input[id^="amt_paidC"]').each(function () {
                sum += parseInt($(this).val(), 10);
            });
                
            document.getElementById("total2").value = sum;
        }
        
        function CheckThis(form) {
            var a = document.getElementById("total2").value;
            var b = document.getElementById("Amount").value;
        
            if (a === '' || b ==='') {
                alert("Amount Received field is empty ...");
                document.getElementById("Amount").focus();
                return false;
            }
            if (b < a) {
                alert("Amount Received is lesser than sum total of Payment Recieved ...");
                document.getElementById("Amount").focus();
                
                return false;
            }

            if (d === '') {
                alert("Amount Received field is empty ...");
                document.getElementById("Amount").focus();
                return false;
            }
        }
    </script>

  <script type="text/javascript">
    document.getElementById('dateForm').submit(); // SUBMIT FORM
</script>  
<?php require_once '../footer.php';?>