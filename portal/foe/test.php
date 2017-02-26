<?php
	require_once("header.php");

	//End of Calculation
	
	//echo "Fin Yr - ".$FinYr. " // Qtr: ". $Qtr ." // Year: ". date("Y", $today)." // Month: ". date("m", $today);
	
	$CustomerNo = $_REQUEST['cust'];
	$stu = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Student] WHERE [Company Name]='$ms' AND [System Genrated No_]= '$CustomerNo'") or die(odbc_errormsg($conn));
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
<div class="container">
	<h2 class="text-primary">Fee Receipt - <?php echo $CustomerNo?></h2>
	<table class="table table-responsive">
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
		<!-- <tr>
			<td colspan="2">
				<h3>Account Summary</h3>
				<table class="table">
					
					<td align="center" style="border: none;background-color: #FFFFFF;border-radius:5px; ">
					<?php
						$sql1 = "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Billed = odbc_exec($conn,$sql1);
					?>
					<h1><?php echo number_format(odbc_result($Billed, ""),2,'.',',')?></h1>
								<strong>Billed</strong>
					</td>
					<td align="center" style="border: none;"><h1> - </h1></td>
					
					<td align="center" style="border: none;background-color: #FFFFFF;border-radius:5px; ">
					<?php
						$sql2 = "SELECT SUM([Adv Fee]) FROM [Ledger Credit] WHERE [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Adj = odbc_exec($conn,$sql2);
					?>
					<h1><?php echo number_format(odbc_result($Adj, ""), 2, '.',',') ?></h1>
								<strong> Adjustments </strong>
					</td>
					<td align="center" style="border: none;"><h1> - </h1></td>
					
					<td align="center" style="border: none;background-color: #FFFFFF;border-radius:5px; ">
					<?php
						$sql2 = "SELECT SUM([Debit Amount]) FROM [Ledger Debit] WHERE [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Payment = odbc_exec($conn,$sql2);
					?>
					<h1><?php echo number_format(odbc_result($Payment, ""),2,'.',',')?> </h1>
								<strong> Payment</strong>
					</td>
					<td align="center" style="border: none;"><h1> = </h1></td>
					
					<td align="center" style="border: none;background-color: #FFFFFF;border-radius:5px; ">
					<h1><?php echo number_format((odbc_result($Billed, "")-odbc_result($Payment, "")),2,'.',',') ?></h1>
								<strong> Due </strong>
					</td>
				</table>
				
			</td>
		</tr> -->
		<tr>
			<td colspan="2" style="border: none; ">
			
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
				$( "#PaymentDt" ).datepicker();
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
				
			</script>
			
			
			<form action="FeeReceiptAdd.php" method="post" >
				<input type="hidden" name="cust" value="<?php echo $CustomerNo?>">
				<table class="table jumbotron" style="width: 100%; ">
				<tr style="background-color: #ffffe3;">
					<th>Fee Description</th>
					<th>Fee O/S</th>
					<th>Payment recieved</th>
				</tr>
				<!-- ledger changes -->	
					
					<?php
					$invNo = "";
					$CreditInvNo = odbc_exec($conn, "SELECT * FROM [ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' ") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($CreditInvNo)){
						$a = odbc_result($CreditInvNo, "Credit Amount");
						$DebitInvNo = odbc_exec($conn, "SELECT * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No]='".odbc_result($CreditInvNo, "Invoice No")."' ") or die(odbc_errormsg($conn));
						
						$b=odbc_result($DebitInvNo, "Debit Amount")+odbc_result($DebitInvNo, "Adv Fee");
						
						if($a > $b || odbc_num_rows($DebitInvNo)==0)
						{
							$invNo .= "'".odbc_result($CreditInvNo, "Invoice No")."', ";
						}
					}
					
					$invNo = substr($invNo, 0, -2);
					$f=1;
					$nTot = 0;
					$rs = odbc_exec($conn, "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No] IN (".$invNo.") AND [Fee Description] LIKE 'Net%' AND [Fee Description] LIKE '%payable' ") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($rs)){
						$qry1 = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo'  AND  [Fee Description] = '".odbc_result($rs, "Fee Description")."' ") or die(odbc_errormsg($conn));
						$diff = odbc_result($rs, "Net Amount") - odbc_result($qry1, "");
						
						$nTot += odbc_result($rs, "Net Amount");
					?>		
							
	    	
					<tr>
						<td style="border: none; "><?php echo odbc_result($rs, "Fee Description"); ?></td>
						<td style="border: none; "><input value="<?php echo number_format(odbc_result($rs, "Net Amount"),2,".", "");?>" 
												type="text" name="Amount" 
												class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
												required readonly></td>
						<td><input value="<?php echo number_format($diff,0,".", ""); ?>" type="text"  
								name="amt_paid<?php echo $f;?>" 
								class="amt_paid" id="amt_paid<?php echo $f;?>" 
								style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
								onkeypress='return validateQty(event)'
								onchange="InputSum()"
								></td>
					    <input value="<?php echo odbc_result($rs, "Fee Description"); ?>" type="hidden"  name="Fee_description">					    
					</tr>
					<?php
							$f++;
						}					
					?>	
					<tr>
						<td style="border: none; ">Total</td>
						<td style="border: none; "><input type="text" id="total1" value="<?php echo number_format($nTot,2,".", "");?>" name="" class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
						<td style="border: none; "><input type="text" 
												id="total2" name="total2" class="total2 form-control" 
												style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
					</tr>
					
					<tr>
						<td style="border: none; " colspan="2">Amount Received</td>
						<td style="border: none; "><input type="text" name="Amount" class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  onkeypress='return validateQty(event)' required></td>
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
					<tr>
						<td style="border: none; " colspan="2"></td>
						<input type="hidden" value="<?php echo $CustomerNo;?>" name="cust_no" />
						<input type="hidden" value="<?php echo $f?>" name="fee_count">
						<td style="border: none; "><input type="submit" value="Submit" class="btn btn-success" /></td>
					</tr>
										
				</table>
			</form>
			</td>
		</tr>
	</table>	
	
	<script type="text/javascript">
		
	</script>
</div>
<?php
	require_once("../footer.php");
?>