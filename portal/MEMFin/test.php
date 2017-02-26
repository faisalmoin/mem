
<?php
	require_once("../db.txt");
	//require_once("header.php");
	$CompName=6;
	//$CompName = $_REQUEST['CompName'];
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
	
	$Agreement = odbc_exec($conn, "SELECT TOP 1 * FROM [CRM Agreement] ") or die(odbc_errormsg($conn));
?>
<!-- -----------------header start------------------ -->

	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="../bs/css/jquery-ui.css">
    <script src="../bs/js/jquery-1.10.2.js"></script>
    <script src="../bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../bs/css/style.css">
	<title>Royality</title>
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
	 <!-- Bootstrap core CSS -->
	 <link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	</style>
 <script type="text/javascript" charset="utf-8">
   $(function(){
	     $("#initialDate").datepicker({
			changeYear: true, 
			changeMonth: true,  
			dateFormat: 'dd/M/yy',
			minDate: '0',
			numberofMonths: '12'
			//yearRange: '<!--?php echo (date('Y')-3).":".(date('Y')-2)?>',  
			//defaultDate: '01/Dec/<--?php echo date('Y')-3;?>' ,
			//minDate: '01/Dec/<--?php echo (date('Y')-3); ?>',
			//maxDate: '30/Nov/<--?php echo (date('Y')-2); ?>'
		});
	});
 </script>
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
			<?php $headcmp = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
							?>
			<div class="container">
			<form method="post" action="RoyaltyAdd.php">
			<table width='100%'>
				<tr style='background-color: #0080cc'>
					<td style='padding: 15px;  border: none;'>
						<!--h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						Royalty
						</h2-->
						<h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						<?php echo odbc_result($headcmp, "Name")?>
						</h2>
						
					</td>
					
					
					
					<td style='padding: 15px; border: none; color: #ffffff;' valign='top'>
						<!--?php require_once("menu.php")?-->
				</td></tr>
				
				<tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
					<!-- Royalti Calculation -->
					<h3 class="text-primary">Financial Year: <?php echo $FinYr; ?></h3>	
					<?php
					    $c=0;
					    $rs = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
					    while(odbc_fetch_array($rs)){
					    	
						$td ="";
						$FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup]") or die(odbc_errormsg($conn));
						$colspan = odbc_num_rows($FeeHead);
						while(odbc_fetch_array($FeeHead)){
							$td .= "<th>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
							?>
							 <!--input type="hidden" class="form-control" name="Description<--?php echo $c?>" value="<--?php echo odbc_result($FeeHead, "Fee Description")?>" /--> 
		                   
							<?php 
						}
					?>
					
					<table class="table table-responsive " border="1" width="100%" id="abc">
						<thead>
						<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
							<th rowspan="2" style="text-align: center;">Class</th>
							<th rowspan="2" style="text-align: center;" >Total Student</th>
							
							<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Fee Code</th>
							<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Total</th>
						</tr>
						<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
							<?php echo $td; ?>
							<td colspan="2" style="text-align: center;">Total</td>
							<td colspan="2"style="text-align: center;">Yearly Total</td>
						</tr>
						</thead>
						<?php
							//Get Quarter
						  
							
						?>
						<tr class="level<?php echo $c?>" style="background-color: #E6E6E6; font-weight: bold;">
							<!--td style="text-align: center"><--?php echo $c; ?></td-->
						  <?php $rs1 = odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($rs1)){
							?>
							<td><?php echo odbc_result($rs1, "Code")?>
							  </td>
							  <!--input type="hidden" class="form-control" name="Class<--?php echo $c?>" value="<--?php echo odbc_result($rs1, "Code")?>" /--> 
		                   
							<?php 
							
							$rs2 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' ") or die(odbc_errormsg($conn));
							
							while(odbc_fetch_array($rs2)){
							?>
							<td><?php echo odbc_result($rs2, "")?>
							</td>
							<!--input type="hidden" class="form-control" name="studentcount<--?php echo $c?>" value="<--?php echo odbc_result($rs2, "")?>" /--> 
							
							
					<?php
						$FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup]  ") or die(odbc_errormsg($conn));
						$gTotal = 0;
						while(odbc_fetch_array($FeeHead)){
							$new_amt= 0;
							$Check_Fee = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");
							
							echo "<td style='text-align: right;'>";
							if(odbc_num_rows($Check_Fee) != 0){
							
							$Inv = odbc_exec($conn, "SELECT [Amount] FROM [Royalty Setup] 
									WHERE [Fee Description] LIKE '".ucwords(strtolower(odbc_result($Check_Fee, "Fee Description")))."' 
									AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Academic Year]='$FinYr' ");						
							
							echo number_format(odbc_result($Inv, "Amount"), "2", ".", "");
							
							$new_amt = odbc_result($Inv, "Amount");
							$gTotal += $new_amt;
							}
							else{echo "0.00"; }
							echo "</td>";
							
							
						} // Fee Head
						
					?>	
					<!--input type="hidden" class="form-control" name="invAmount<--?php echo $c?>" value="<--?php echo number_format(odbc_result($Inv, "Amount"), "2", ".", "")?>" /--> 
					
					<td colspan="2" style='text-align: right;'><?php echo number_format($gTotal,2,'.',''); ?>
					</td>
					<!--input type="hidden" class="form-control" name="gTotal<--?php echo $c?>" value="<--?php echo number_format($gTotal, "2", ".", "");?>" /--> 
						
					<td colspan="3" style='text-align: right;'><?php 
						echo odbc_result($rs2, "")*$gTotal;
						$G_Total += odbc_result($rs2, "")*$gTotal;
					?>
					</td>	
					</tr>
			
				</tbody>
					<?php
					}
					}
					$c++;
					} // Quarter							
					?>
					<tr><td>Total Amount</td>
					<td colspan="9"></td>
					<td colspan="3" style="text-align: right;"><?php echo $G_Total; ?></td></tr>
					<!--input type="hidden" class="form-control" name="G_Total" value="<--?php echo $G_Total;?>"/--> 				
					</table>
				</td>
			</tr>
		</table>
		
		<script>
		
			//fee amount 
			function myFunction() {
			    var x = document.getElementById("Generate").value;// select box id
			    var tot_amt = document.getElementById("totalRoyalty").value;
			    var r;
			    var k;
			    var a;
			   var jsvar = <?php echo json_encode(odbc_result($Agreement, "R_Tax"));?>;
			   // var jsvar = <--?php echo "1";?>;
			    if(x == "Yearly"){
				r = parseFloat(tot_amt/1).toFixed(2);		
			    }
			    if(x == "Halfyearly"){
				r = parseFloat(tot_amt/2).toFixed(2);		
			    }
			    if(x == "Quarterly"){
				r = parseFloat(tot_amt/3).toFixed(2);	
			    }
			    if(x == "BiMonthly"){
				r = parseFloat(tot_amt/6).toFixed(2);		
			    }
			    if(x == "Monthly"){
				r = parseFloat(tot_amt/12).toFixed(2);		
			    }
			    
			    //document.getElementById("servisetax").value = parseFloat(r*100/115).toFixed(2);
			    //document.getElementById("netpayble").value = parseFloat(r) + parseFloat(parseFloat(r*100/115).toFixed(2));;
			    if(jsvar == "1"){
				document.getElementById("demo").value = parseFloat(r).toFixed(2);
				document.getElementById("servicetax").value = parseFloat(r *15/100).toFixed(2);
				k =  parseFloat(r)+ parseFloat((r *15/100));
				document.getElementById("payble").value = k;
			     }
			     if(jsvar == "-1"){
				document.getElementById("payble").value = parseFloat(r).toFixed(2);
				k = parseFloat(r*(100/115)).toFixed(2);
				document.getElementById("demo").value = parseFloat(k).toFixed(2);
				document.getElementById("servicetax").value = parseFloat(r-k).toFixed(2);
			    }
			    }
				

			 function isNumberKey(evt)
		       {
		          var charCode = (evt.which) ? evt.which : event.keyCode;
		          if (charCode != 46 && charCode > 31 
		            && (charCode < 48 || charCode > 57))
		             return false;
		
		          return true;
		       }
			
		</script>
		
		<table class="table table-responsive " border="1" width="100%">
		<tr><td>Fee Generate</td><td>
		<select name="Generate" id="Generate" class="form-control" style="width: 180px;padding: 8px;" onchange="myFunction()" required>
		<option value=""></option>
		<option value="Yearly">Yearly</option>
		<option value="Halfyearly">Half yearly</option>
		<option value="Quarterly">Quarterly</option>
		<option value="BiMonthly">BiMonthly</option>
		<option value="Monthly">Monthly</option>
		</select></td></tr>
		<tr><td>Invoice Number</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="Invoiceno" value="" required /></td></tr>
		<tr><td>Date</td><td><input style="width: 180px;padding: 8px;" id="initialDate" type="text" class="form-control" name="Date" value="" required /></td></tr>
		<tr><td>Total Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="totalamount" id="totalamount" readonly value="<?php echo $G_Total;?>" /></td></tr>
		<tr><td>Royalty Percentage</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="perRoyalty" id="perRoyalty" readonly value="<?php echo odbc_result($Agreement, "Royaly %");?>%"/></td></tr>
		<tr><td>Total Royalty</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="totalRoyalty" id="totalRoyalty" readonly value="<?php echo $G_Total*odbc_result($Agreement, "Royaly %")/100;?>" /><!--p style="color: red;">(<--?php echo odbc_result($Agreement, "Royaly %");?>% Royalty Amount)</p--></td></tr>
		<tr><td>Invoice Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="feeamount" id="demo" value="" required/></td></tr>
		<tr><td>Service Tax 
		     <?php if(odbc_result($Agreement, "R_Tax") == "1" ) echo " (Exclusive)";
			  if(odbc_result($Agreement, "R_Tax") == "-1" ) echo " (Inclusive)";
			  ?> 
		</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="netpayble" id="netpayble" value="15%" readonly/></td></tr>
		<tr><td>Taxable Amount </td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="servisetax" id="servicetax" value="" onkeypress="return isNumberKey(event)" required/></td></tr>
		<tr><td>Net Payble</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="payble" id="payble" value="" onkeypress="return isNumberKey(event)" required/></td></tr>
		<tr><td colspan="2"><button class="btn btn-primary">Next</button></td></tr>
		</table>
		<input type="hidden" class="form-control" name="companyName" value="<?php echo odbc_result($rs, "ID")?>" /> 
		<input type="hidden" class="form-control" name="FinYr" value="<?php echo $FinYr; ?>" />
		<!--input type="hidden" name="count" value="<--?php echo $c;?>"/--> 
							
		</form>
		</div>
		
	