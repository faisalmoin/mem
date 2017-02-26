<?php
	//require_once("../db.txt");
	require_once("header.php");
	$CompName = $_REQUEST['CompName'];
	$today = strtotime(date('d M Y'));
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	}
	
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
		$Qtr = "Q1";
	}
	//Q2 Calculation
	if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
		$Qtr = "Q2";
	}
	//Q3 Calculation
	if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
		$Qtr = "Q3";
	}
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
		$Qtr = "Q4";
	}
	//$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] WHERE [ID]='$CompName'") or die(odbc_errormsg($conn));
	$AgrID = odbc_exec($conn, "SELECT * FROM [Company Information] Where [ID]='$CompName' ") or die(odbc_errormsg($conn));
	$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] where [ID]='".odbc_result($AgrID, "Trust")."' ") or die(odbc_errormsg($conn));
	
?>
<!-- -----------------header start------------------ -->

	<!--link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="../bs/css/jquery-ui.css">
    <script src="../bs/js/jquery-1.10.2.js"></script>
    <script src="../bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../bs/css/style.css">
	<title>Royalty Debit</title>
    <style>
	.input{
		font-family: 'Josefin Sans', 'arial'; 
		font-size: 18px; 
		text-transform: uppercase;        
		color: #0072BC;
	 }
	.borderless tbody tr td, .borderless tbody tr th, .borderless thead tr th {
		border: none;
	 }
	 <!-- Bootstrap core CSS>
	 <link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	</style-->

 <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 13px;
					padding: 0px;
				}
				table td {
					width: 160px;
					height: 40px;
					border: 1px solid #d3d3d3;
					font-size: 13px;
				}
				
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
			
			<script>
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
				 //Calender
				$( "#PaymentDt" ).datepicker({maxDate: 15});
				$( "#DDDt" ).datepicker();
                   //only number
				 $('.number-only').keypress(function(evt) {
			            var charCode = (evt.which) ? evt.which : event.keyCode;

			            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
			              return false;
			            }

			            return true;
			        });

				});
			</script>
			
			    <div class="container">
			        <h4>School Information</h4>
		<table class="table table-responsive" style="border: 1px solid #d3d3d3;">
                    <tr>
                    <td style="border: none">School Name</td>
                    <td style="border: none; font-weight: normal;font-size: 18px;" colspan="5"><?php echo strtoupper(odbc_result($AgrID, "Name"))?></td>
                    </tr>
                    <tr>
                    <td style="border: none">Trust Name</td>
                    <td style="border: none; font-weight: normal;" colspan="3"><?php 
                        $Trust = odbc_exec($conn, "SELECT [Trust Name] FROM [CRM Agreement] WHERE [ID]= '".odbc_result($AgrID, "Trust")."'");
                        echo strtoupper(odbc_result($Trust, "Trust Name"))
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">City</td>
                    <td style="border: none"><?php echo strtoupper(odbc_result($AgrID, "City"))?></td>
                    <td style="border: none">State</td>
                    <td style="border: none"><?php echo strtoupper(odbc_result($AgrID, "State"))?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">Brand</td>
                    <td style="border: none"><?php 
                        echo odbc_result($AgrID, "Brand")==1?"TKS":""; 
                        echo odbc_result($AgrID, "Brand")==2?"TMS":""; 
                        echo odbc_result($AgrID, "Brand")==3?"UA":""; 
                        echo odbc_result($AgrID, "Brand")==4?"PSBB MS":""; 
                        echo odbc_result($AgrID, "Brand")==5?"TSMS":""; 
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                </table>
			     
					<h3 class="text-primary">Financial Year: <?php echo $FinYr; ?></h3>	
					<form method="post" action="RoyaltyDebitAdd.php" name="myForm" onsubmit="return myForm()">
					<table class="table table-responsive " border="1" width="100%" id="abc">
					<thead>
					<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
					<th colspan="2" style="text-align: center;">Royalty Debit Form</th>
					
					</tr>
					</thead>
					
					
					<tr>
					<td  style="border: none; ">Amount</td>
					<td style="border: none; "><input type="text" class="number-only" id="Amount" name="Amount" style="padding:4px;width: 170px" class="form-control" required /></td>
					</tr>
					<tr>
					<td  style="border: none; ">Deduction Amount</td>
					<td style="border: none; "><input type="text" class="number-only" id="DeductionAmt" name="DeductionAmt" style="padding:4px;width: 170px" class="form-control" /></td>
					</tr>
					<tr>
					<td  style="border: none; ">Total Amount</td>
					<td style="border: none; "><input type="text" class="number-only" id=TotalAmt name="TotalAmt" style="padding:4px;width: 170px" class="form-control" required /></td>
					</tr>					
					<tr>
					<td  style="border: none; ">Acknowledge Number</td>
					<td style="border: none; "><input type="text" name="VoucherNo" style="padding:4px;width: 170px" class="form-control" required /></td>
					</tr>
					<tr>
					<tr>
					<td  style="border: none; ">Date</td>
					<td style="border: none; "><input type="text" id="PaymentDt" name="Date" maxlength="6" style="padding:4px;width: 170px" class="form-control" readonly  required/></td>
					</tr>
					<tr>
						<td  style="border: none; ">Mode Of Payment</td>
						<td style="border: none; ">
						<select name="PaymentMode" class="form-control" style="padding:4px; background-color: #7FFFD4; border: 1px solid #C0C0C0;width: 170px" id="PayMode" required>
							<option value=""></option>
						<?php
							$Bal = odbc_exec($conn, "SELECT Distinct([Code]) FROM [Payment Method]");
							while(odbc_fetch_array($Bal)){
								echo "<option value='".odbc_result($Bal, "Code")."'>".odbc_result($Bal, "Code")."</option>";
							}
						?>
						</select>
						</td>
					</tr>
					<tr>
						<td  style="border: none; ">Bank Name</td>
						<td style="border: none; "><input type="text" name="BankName" id="BankName" style="padding:4px;width: 170px" class="form-control" disabled="true" /></td>
					</tr>
						<td  style="border: none; ">Cheque / DD No.</td>
						<td style="border: none; "><input type="text" name="ChequeDDNo" id="DDNo" maxlength="6" style="padding:4px;width: 170px" class="form-control" onkeypress='return validateQty(event)' onblur="if(this.value.length < 6){alert('Cheque No. must be 6 digit ...');}" disabled="true" /></td>
					</tr>
						<td  style="border: none; ">Cheque / DD Date.</td>
						<td style="border: none; "><input type="text" id="DDDt" name="ChequeDDt" maxlength="6" style="padding:4px;width: 170px" class="form-control" disabled="true" readonly /></td>
					</tr>
					<tr>
                                            <td style="border: none; "></td>
                                            <td style="border: none; "><input type="submit" value="Submit" class="btn btn-success"   />
                                            <input type="hidden"  name="TrustName" value="<?php echo odbc_result($Agreement, "Trust Name") ?>" />
                                            <input type="hidden"  name="ID" value="<?php echo odbc_result($Agreement, "ID") ?>" />
                                            <input type="hidden"  name="companyName" value="<?php echo $CompName ?>" />
                                            </td>
                                        </tr>
				</tbody>
					
					</table>
					</form>
				
	</div>
	<!--script type="text/javascript">
	$(function() {
	$('.common').change(function () {
	    $('#TotalAmt').val(parseFloat("0"+$('#Amount').val()) + parseFloat("0"+$('#DeductionAmt').val()));
	});
	});
</script-->
  <script type="text/javascript">
	var input = $('[name="Amount"],[name="DeductionAmt"]'),
    input1 = $('[name="Amount"]'),
    input2 = $('[name="DeductionAmt"]'),
    input3 = $('[name="TotalAmt"]');
    input.change(function () {
    var val1 = (isNaN(parseInt(input1.val()))) ? 0 : parseInt(input1.val());
    var val2 = (isNaN(parseInt(input2.val()))) ? 0 : parseInt(input2.val());
    input3.val(val1 + val2);
     });
   </script>	
   <?php require_once("../footer.php"); ?>
	