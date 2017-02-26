
<?php
	//require_once("../db.txt");
	require_once("header.php");
	//$CompName=6;
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
	
	$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] ") or die(odbc_errormsg($conn));
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
	<title>Franchisee List</title>
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
			
			    <div class="container">
			      
                                        <div class="row">
                                            <div class="col-md-6"><span class="text-primary" style="font-size: 28px;">Franchisee List</span></div>
                                            <div class="col-md-6" style="vertical-align: bottom; text-align: right;">
                                                <a href="RoyaltySetup.php?pg_id=2" title="Create New ..." class="btn btn-success"><b>Create New Invoice</b></a>
                                            </div>
                                        </div>
					<table class="table table-responsive " border="1" width="100%" id="abc">
					<thead>
					<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
					<th  style="text-align: center;">Opp No</th>
					<th style="text-align: center;" >Trust Name</th>
					<th style="text-align: center;" >Trusty Name</th>
					<th style="text-align: center;" >City</th>
					<th style="text-align: center;" >Duration</th>
					<th style="text-align: center;" >Brand</th>
					<th style="text-align: center;" >From Date</th>
					<th style="text-align: center;" >To Date</th>
					<th style="text-align: center;" >Franchisee Fee</th>
					<th style="text-align: center;" >Balance Invoice Amount</th>
					<th style="text-align: center;" >Outstanding Amount</th>
					
					</tr>
					</thead>
					
					<?php 
					$c=0;
					$rs1 = odbc_exec($conn, "SELECT * FROM [CRM Agreement] ") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($rs1)){
					?>
					<tr>
					<td><?php echo odbc_result($rs1, "Opp No")?></td>
					<td><a href="TrustyDetails.php?ID=<?php echo odbc_result($rs1, "ID");?>"><?php echo odbc_result($rs1, "Trust Name")?></a></td>
					<td><?php echo odbc_result($rs1, "Name")?></td>
					<td><?php echo odbc_result($rs1, "City")?></td>
					<td><?php echo odbc_result($rs1, "Duration")?></td>
					<td><?php echo odbc_result($rs1, "Brand")?></td>
					<td><?php echo date('d/M/Y', odbc_result($rs1, "From Date"));?></td>
					<td><?php echo date('d/M/Y', odbc_result($rs1, "To Date"));?></td>
					<td><?php echo odbc_result($rs1, "Franchisee Fee")?></td>
					<!--td><--?php echo odbc_result($rs1, "Royaly %")?></td-->
					
					<?php 
					//$tot_amt = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
					$rs2 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Trust Name]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));
					$rs3 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Trust ID]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));
						
					//echo "SELECT * FROM [CRM Agreement] WHERE [Trust Name]='".odbc_result($rs1, "Trust Name")."'";
					while(odbc_fetch_array($rs2)){
					?>
					
					
					<td><?php echo number_format(odbc_result($rs1, "Franchisee Fee"),2,'.','')- number_format(odbc_result($rs2, ""),2,'.','');?></td>
					<td><?php echo number_format(odbc_result($rs2, ""),2,'.','') - number_format(odbc_result($rs3, ""),2,'.','');?></td>
					</tr>
			
				
					<?php
					
					}
					$c++;
					} // Quarter							
					?>
                                        </tbody>
					</table>
	</div>
		
	<?php require_once("../footer.php"); ?>