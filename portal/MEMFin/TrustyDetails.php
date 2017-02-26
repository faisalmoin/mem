
<?php
	//require_once("../db.txt");
	require_once("header.php");
	//$CompName=6;
	$TrustID = $_REQUEST['ID'];
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

	<!--link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="../bs/css/jquery-ui.css">
    <script src="../bs/js/jquery-1.10.2.js"></script>
    <script src="../bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../bs/css/style.css">
	<title>Ledger Details</title>
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
	
	 <link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	</style-->

 <!-- link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css' -->
			
			    <div class="container">
			      
			      <table width='100%'>
			       <h3 class="text-primary">Franchisee Information</h3>
                                <table class="table table-responsive" style="border: 1px solid #d3d3d3;">
                                    <tr>
                                        <td style="border: none">Name</td>
                                        <td style="border: none; font-weight: normal;font-size: 18px;" colspan="5"><?php echo strtoupper(odbc_result($Agreement, "Trust Name"))?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">City</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "City"))?></td>
                                        <td style="border: none">State</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "State"))?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Agreement Signing Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "Sign Date"))?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Duration</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "Duration"))?></td>
                                        <td style="border: none">From Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "From Date"))?></td>
                                        <td style="border: none">To Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "To Date"))?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Outstanding</td>
                                        <td style="border: none; background-color: #FFC088; font-weight: normal;font-size: 18px;"><?php 
                                            $Invoice = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Trust ID]='".$TrustID."' ") or die(odbc_errormsg($conn));
                                            $Payment = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Trust ID]='".$TrustID."' ") or die(odbc_errormsg($conn));
                                            
                                            $Outstanding = odbc_result($Invoice, "") - odbc_result($Payment, "");
                                            echo number_format($Outstanding, 2, ".", ',');
                                        ?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                </table>
				  <!--tr style='background-color: #0080cc'>
					<td style='padding: 15px;  border: none;'>
						
						<h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						<--?php echo "Welcome"?>
						</h2>
					</td>
					<td style='padding: 15px; border: none; color: #ffffff;' valign='top'>
						<!--?php require_once("menu.php")?>
				    </td>
				    </tr-->
				    <tr>
				    <td colspan='2' style='padding: 25px; border: none;' valign="top">
					<h3 class="text-primary">Franchisee Ledger Details<?php //echo $FinYr; ?></h3>	
					<table class="table table-responsive table-bordered" width="100%" id="abc">
					<thead>
						<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
							<th rowspan="2" style="text-align: center;vertical-align: middle;">SN</th>
							<th rowspan="2" style="text-align: center;vertical-align: middle;" >Transactions</th>
							<th rowspan="2" style="text-align: center;vertical-align: middle;" >Description</th>
							<th colspan="3" style="text-align: center;vertical-align: middle;" >Amount (INR)</th>
						</tr>
						<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
							<th style="text-align: center;vertical-align: middle;" >Credit</th>
							<th style="text-align: center;vertical-align: middle;" >Debit</th>
							<th style="text-align: center;vertical-align: middle;" >Balance</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$c = 0;
						$Cr = 0;
						$Dr = 0;
						$Bal = 0;
						//Get dates
						$end_date = time();	
						$start_date = odbc_result($Agreement, "From Date").', ';
						
						$get_dates1 = odbc_exec($conn, "SELECT [Date] FROM [MemFin Franchisee Credit] WHERE [Trust ID]='$TrustID' ") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($get_dates1)){
							$start_date .= odbc_result($get_dates1, "Date").", ";
						}
						$get_dates2 = odbc_exec($conn, "SELECT [Date] FROM [MemFin Franchisee Debit] WHERE [Trust ID]='$TrustID' ") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($get_dates2)){
							$start_date .= odbc_result($get_dates2, "Date").", ";
						}
						
						$gDate = explode(", ", $start_date);
						sort($gDate);
						for($i=0; $i< count($gDate); $i++){
							
							if(substr($gDate[$i],1,-1) != ""){								
								//Check invoice
								$credit = odbc_exec($conn, "SELECT * FROM [MemFin Franchisee Credit] WHERE [Date]='".$gDate[$i]."' AND [Trust ID]='$TrustID' ") or die(odbc_errormsg($conn));
								$debit = odbc_exec($conn, "SELECT * FROM [MemFin Franchisee Debit] WHERE [Date]='".$gDate[$i]."' AND [Trust ID]='$TrustID' ") or die(odbc_errormsg($conn));
								if(odbc_num_rows($credit) != 0 || odbc_num_rows($debit) != 0 ){								
									
					?>
					<tr>
						<td style="text-align: center;"><?php echo $c; ?></td>
						<td><?php echo date("d/M/Y H:i:s", $gDate[$i]); ?></td>
						<td>
						<?php 
							if(odbc_num_rows($credit) != 0) echo "Invoice generated vide Invoice No. - ".odbc_result($credit, "Invoice No");
							else if(odbc_num_rows($debit) != 0) echo "Payment received vide Voucher No. - ".odbc_result($debit, "Voucher Number");
						?>
						</td>
						<td style="text-align: right;"><?php echo number_format(odbc_result($credit, "Net Payble"), 2,'.',','); $Cr += odbc_result($credit, "Net Payble"); ?></td>
						<td style="text-align: right;"><?php echo number_format(odbc_result($debit, "Total Amount"), 2,'.',','); $Dr += odbc_result($debit, "Total Amount"); ?></td>
						<td style="text-align: right;">
						<?php 
							$Bal = $Bal + (odbc_result($credit, "Net Payble")-odbc_result($debit, "Total Amount"));
							echo number_format($Bal, 2, '.', ',');
						?>
						</td>
					</tr>
					<?php 
								}
								$c++;								
							}							
						}										
					?>
					<tr style="font-weight: bold;">
						<td colspan="3">TOTAL</td>
						<td style="text-align: right;"><?php echo number_format($Cr, 2, '.', ','); ?></td>
						<td style="text-align: right;"><?php echo number_format($Dr, 2, '.', ','); ?></td>
						<td style="text-align: right;"><?php echo number_format($Bal, 2, '.', ','); ?></td>
					</tr>
					</tbody>
				</table>
					
				</td>
			</tr>
		</table>
	</div>
		<?php require_once("../footer.php"); ?>
	