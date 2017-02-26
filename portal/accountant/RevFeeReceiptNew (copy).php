<?php
	require_once("header.php");
	$inv_dt = time();
	
	//Quarter calculation
	$qDate = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='$AcadYear' AND [Company Name]='$ms'");
	$q1Sdt = strtotime(odbc_result($qDate, "Start Date"));
	$q1Edt = strtotime("+3 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q2Sdt = strtotime("+3 months", strtotime(odbc_result($qDate, "Start Date")));
	$q2Edt = strtotime("+6 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q3Sdt = strtotime("+6 months", strtotime(odbc_result($qDate, "Start Date")));
	$q3Edt = strtotime("+9 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q4Sdt = strtotime("+9 months", strtotime(odbc_result($qDate, "Start Date")));
	$q4Edt = strtotime(odbc_result($qDate, "Start Date"));
	//echo $q1Edt;
	//Get Quarter as per current date
        $today = $inv_dt;
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		    $FinYr = date('y', $today)."-".(date('y', $today)+1);
		}
	if($inv_dt >= $q1Sdt && $inv_dt <= $q1Edt ) {$Qtr = 2;}
	elseif($inv_dt >= $q2Sdt && $inv_dt <= $q2Edt ) {$Qtr = 3;}
	elseif($inv_dt >= $q3Sdt && $inv_dt <= $q3Edt ) {$Qtr = 4;}
	elseif($inv_dt >= $q4Sdt && $inv_dt <= $q4Edt ) {$Qtr = 5;}
	else{
		$Qtr = 2;
	}
	//echo "Fin Yr - ".$FinYr. " // Qtr: ". $Qtr ." // Year: ". date("Y", $today)." // Month: ". date("m", $today);
	$invoice = $_REQUEST['invoice'];
	$CustomerNo = $_REQUEST['ID'];
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
	<script  type='text/javascript'>
		function validateQty(event) {
			var key = window.event ? event.keyCode : event.which;

			if (event.keyCode == 8 || event.keyCode == 46
			|| event.keyCode == 37 || event.keyCode == 39) {
			return true;
			}
			else if ( key < 48 || key > 57 ) {
			return false;
			}
			else return true;
		};
		
		$(function() {
		$("#PayMode").change(function() {
			if($(this).val() == "CASH") {
                            $("#BankName").attr("disabled", "disabled");
                            $("#DDNo").attr("disabled", "disabled");
                            $("#DDDt").attr("disabled", "disabled");
			}
		else {    
			$("#BankName").removeAttr("disabled");
			$("#DDNo").removeAttr("disabled");
			$("#DDDt").removeAttr("disabled");
			}
		});
		$( "#PaymentDt" ).datepicker({maxDate: 15});
		$( "#DDDt" ).datepicker();
		});
		
		$(document).ready(function(){
			InputSum();
		 });
		
		function InputSum() {
			var sum = 0;
			$('input[id^="amt_paid"]').each(function () {
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
  <div class="container">
      <?php 
      $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$CustomerNo' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
      ?>
   <h2 class="text-primary">Student No - <?php echo $AdmissionNo?></h2>
	<table class="table table-responsive">
		<tr>
			<!--td style="background-color: #D8D8D8; width: 40%;" valign="top">
				<table class="table table-responsive" style="background-color: #D8D8D8;">
					<tr>
						<td colspan="2"><h3>Account Information</h3></td>
					<tr>
					<tr>
						<td style="border: none; ">Student Name</td>
						<td style="border: none; ">Ward of</td>
					</tr>
					<tr>
						<td style="border: none; "><span class="text-danger" style="font-weight: bold;"><?php echo strtoupper($Name)?></span></td>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Addressee?></span></td>
					</tr>
					<tr>
						<td style="border: none; ">Academic Year</td>
						<td style="border: none; ">Class</td>
					</tr>
					<tr>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Acad?></span></td>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Class?></span></td>
					</tr>
				</table>
			</td-->
                        
                        
                        
                <td style="border: none;">
                <form action="RevFeeReceiptNewAdd.php" method="post" name="form" onsubmit="return CheckThis(this)">
                        <?php
                            $invNo = "";
                                $CreditInvNo = odbc_exec($conn, "SELECT * FROM [ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo'" ) or die(odbc_errormsg(odbc_errormsg()));
                               // if(odbc_num_rows($CreditInvNo) != 0){
                        ?>
                        <table class="table jumbotron" style="width: 100%; ">
                                <?php
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
                                        $nTot = 0;
                                        //if($invNo == 0 || $invNo == "" ){							
                                        //	echo '<tr><td colspan="3"><div class="alert alert-warning">No dues ... </div></td></tr>';
                                        //}
                                        //else{
                                ?>
                                <tr style="background-color: #ffffe3;">
                                        <th style="border: none;">Fee Description</th>
                                        <th style="border: none;">Old Fee Invoice</th>
                                        <th style="border: none;">Fee Description</th>
                                        <th style="border: none;">New Fee Invoice</th>
                                </tr>					
                                <?php
                                        $sql1 = "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' "; 
                                        $rs = odbc_exec($conn, $sql1) or die(odbc_errormsg($conn));
                                        while(odbc_fetch_array($rs)){
                                        $qry1 = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo'  AND  [Fee Description] = '".odbc_result($rs, "Fee Description")."' AND [Qtr]= '$Qtr'") or die(odbc_errormsg($conn));
                                        $diff = odbc_result($rs, "Net Amount") - odbc_result($qry1, "");
                                        $nTot += odbc_result($rs, "Net Amount");
                                ?>		
                                    <tr>
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
                                        </td>
                                        
                                  
                                        
             <!------------------------------------------------------------------------------------------->
                                        
                <?php $f=1;
		$gTotal = 0;
		$Fee = odbc_exec($conn, "Select * FROM [StudentFee] where [ApplicationNo]='$CustomerNo' AND [CompanyName]='$ms'");
               // echo "Select * FROM [StudentFee] where [ApplicationNo]='$CustomerNo' AND [CompanyName]='$ms'";
		
                while(odbc_fetch_array($Fee)){
			if(odbc_result($Fee, "FeeNo") != ""){
                            //echo odbc_result($Fee, "FeeNo");
                          $rs1 = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [id]='".odbc_result($Fee, "FeeNo")."' And [Description]='".odbc_result($rs, "Fee Description")."' ") or die(odbc_errormsg($conn));
			//echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [id]='".odbc_result($Fee, "FeeNo")."' And [Description]='".odbc_result($rs, "Fee Description")."' ";	
                          while(odbc_fetch_array($rs1)){
			
		      

		?>
             
             <td style="border: none; "><?php echo odbc_result($rs1, "Description"); 
                ?><input value="<?php echo odbc_result($rs1, "Description"); ?>" type="text" name="DescriptionA<?php echo $f;?>" > </td>
             <td style="border: none;">
             <?php if(odbc_result($rs1, "Total Amount")!=0){?>
                 <input value="<?php echo number_format(odbc_result($rs1, "Total Amount"),2,".", ""); ?>" type="text"  
                                        name="amt_paidA<?php echo $f;?>" 
                                        class="amt_paid" id="amt_paid<?php echo $f;?>" 
                                        class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;" 
                                       onkeypress='return validateQty(event)'
                                        onchange="InputSum()"
                                        onblur="myFunction()" >
                <?php } ?>
		</td>
		<?php			
			
                    $new_amt = odbc_result($rs1, "Total Amount");
                    $d=1;
                    $Discount = odbc_exec($conn, "Select * FROM [StudentDiscountDetails] where [ApplicationNo]='$CustomerNo' AND [CompanyName]='$ms'");
                    while(odbc_fetch_array($Discount)){ 
                    $e=0;
                    if(odbc_result($Discount, "DiscountNo") != ""){
                    $disc_fee_hdr = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [id]='".odbc_result($Discount, "DiscountNo")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                    //echo "SELECT [No_] FROM [Discount Fee Header] WHERE [id]='".odbc_result($Discount, "DiscountNo")."' AND [Company Name]='$ms'";
                    $disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$ms' AND [Fee Code]='".odbc_result($rs1, "Fee Code")."' AND [Academic Year]='$FinYr' AND [Document No_]='".odbc_result($disc_fee_hdr, "No_")."' ") or die(odbc_errormsg($conn));
                   // echo "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$ms' AND [Fee Code]='".odbc_result($rs1, "Fee Code")."' AND [Academic Year]='$FinYr' AND [Document No_]='".odbc_result($disc_fee_hdr, "No_")."' ";
                    if(odbc_result($disc_fee_line, "Description") != ""){
                            $e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
                            $new_amt = $new_amt - $e;?>
                
                     <?php if($e!=0){?>
                  <td style="border: none; "><?php echo odbc_result($disc_fee_line, "Description"); ?>
                  <input value="<?php echo odbc_result($disc_fee_line, "Description"); ?>" type="text" name="DescriptionB<?php echo $f;?>" > <td>
                            <td><input value="<?php echo number_format($e,2,".", ""); ?>" type="text"  
                               name="amt_paidB<?php echo $f;?>" 
                               class="amt_paid" id="amt_paid<?php echo $f;?>" 
                               class="form-control" style="padding:4px; background-color: Green; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                               onkeypress='return validateQty(event)'
                               onchange="InputSum()"
                               onblur="myFunction()"
                               ></td>
                             <?php
                               }
                               }
                   //  if($new_amt!=0){
                         ?>
                      <td style="border: none; "><?php echo "Net ".odbc_result($rs1, "Description")." payable"; ?>
                      <input value="<?php echo "Net ".odbc_result($rs1, "Description")." payable"; ?>" type="text" name="DescriptionC<?php echo $f;?>" > </td>
                      <td><input value="<?php echo number_format($new_amt,2,".", ""); ?>" type="text"  
                      name="amt_paidC<?php echo $f;?>" 
                      class="amt_paid" id="amt_paid<?php echo $f;?>" 
                       class="form-control" style="padding:4px; background-color: red; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                      onkeypress='return validateQty(event)'
                      onchange="InputSum()"
                      onblur="myFunction()"
                      ></td>
                     <?php //} 
                               }
                               $d++;
                               }
                   // $gTotal = $gTotal + $new_amt;
                    
                            }
                            }
                     $f++;	
                    }
		
		    ?>
                 
                                   
              <!-------------------------------------------------------------------------------------------->
                         
                               <!--input value="<--?php echo odbc_result($rs, "Fee Description"); ?>" type="hidden"  name="Fee_description<--?php echo $f?>"-->					    
                                    </tr>
                                    <?php
                                        $m++;
                                        }	

                                //} // End of Invoice Check
                                        ?>	
                              
                        <tr>
                                <td style="border: none; ">Total</td>
                                <td style="border: none; "><input type="text" id="total1" value="<?php echo number_format($nTot,2,".", "");?>" name="" class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                                <td style="border: none; "><input type="text" id="total2" name="total2" class="total2 form-control" value="<?php echo number_format($gTotal,2,".", "");?>"
                                    style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Amount Received</td>
                                <td style="border: none; "><input type="text" name="Amount" id="Amount" 
                                        class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        onkeypress='return validateQty(event)'
                                        required></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Payment Date</td>
                                <td style="border: none; "><input type="text" name="PaymentDt" id="PaymentDt" class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" required readonly></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Mode of Payment</td>
                                <td style="border: none; ">
                                    <select name="PaymentMode" class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="PayMode" required>
                                    <option value=""></option>
                                    <?php
                                        $Bal = odbc_exec($conn, "SELECT [Code] FROM [Payment Method] WHERE [Company Name]='$ms'");
                                        while(odbc_fetch_array($Bal)){
                                        echo "<option value='".odbc_result($Bal, "Code")."'>".odbc_result($Bal, "Code")."</option>";
                                        }
                                    ?>
                                    </select>
                                </td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Bank Name</td>
                                <td style="border: none; "><input type="text" name="BankName" id="BankName" style="padding:4px;width: 170px" class="form-control" disabled="true" /></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Cheque / DD No.</td>
                                <td style="border: none; "><input type="text" name="ChequeDDNo" id="DDNo" maxlength="6" style="padding:4px;width: 170px" class="form-control" onkeypress='return validateQty(event)' onblur="if(this.value.length < 6){alert('Cheque No. must be 6 digit ...');}" disabled="true" /></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="2">Cheque / DD Date.</td>
                                <td style="border: none; "><input type="text" id="DDDt" name="ChequeDDt" maxlength="6" style="padding:4px;width: 170px" class="form-control" disabled="true" readonly /></td>
                        </tr>
                          <?php 
                          $creditp = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' ") or die(odbc_errormsg($conn));
                        //echo "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='$invoice' ";
                          ?>
                        <tr>
                                <td style="border: none; " colspan="2"></td>
                                <input type="hidden" value="<?php echo $CustomerNo;?>" name="ID" />
                                <input type="hidden" value="<?php echo $f;?>" name="fee_count">
                                <input type="hidden" value="<?php echo $invoice;?>" name="invoice">
                                <input type="hidden" value="<?php echo odbc_result($rs, "Invoice Date" );?>" name="InvDate">
                                 <input type="hidden" value="<?php echo odbc_result($creditp, "Posting No" );?>" name="PostingNo">
                                
                                
                           
                                <td style="border: none; "><input type="submit" value="Submit" class="btn btn-success"   /></td>
                        </tr>
                        </table>
                <?php
                /*}
                else{
                        echo '<div class="alert alert-warning">';
                        echo "No dues ...";
                        echo '</div>';
                  }*/
        ?>
        </form>	
        </td>
</tr>
	</table>	
	</div>
<?php require_once("../footer.php");?>