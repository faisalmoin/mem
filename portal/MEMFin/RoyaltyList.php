
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
			    <div class="container">
			                <div class="row">
                                            <div class="col-md-6"><span class="text-primary" style="font-size: 28px;">Royalty List</span></div>
                                            <div class="col-md-6" style="vertical-align: bottom; text-align: right;">
                                                <a href="RoyaltySetup.php?pg_id=3" title="Create New ..." class="btn btn-success"><b>Create New Invoice</b></a>
                                            </div>
                                        </div>
					<table class="table table-responsive " border="1" width="100%" id="abc">
					<thead>
					<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
					<th  style="text-align: center;">School Name</th>
					<th style="text-align: center;" >Trusty Name</th>
					<th style="text-align: center;" >City</th>
					<th style="text-align: center;" >Brand</th>
					<th style="text-align: center;" >Total Credit Amount</th>
					<th style="text-align: center;" >Total Debit Amount</th>
					<th style="text-align: center;" >Balance Amount</th>					
					</tr>
					</thead>
                                        <tbody>
					<?php 
					$c=0;
					$rs1 = odbc_exec($conn, "SELECT * FROM [CRM Agreement] ") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($rs1)){						
					?>
					<tr>
					<?php $rs = odbc_exec($conn, "SELECT Distinct ID,Name FROM [Company Information] where [Trust]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));?>
					<td><a href="RoyaltyLedgerDetails.php?ID=<?php echo odbc_result($rs, "ID");?>"><?php echo odbc_result($rs, "Name");?></a></td>
					<td><?php echo odbc_result($rs1, "Trust Name")?></td>
					<td><?php echo odbc_result($rs1, "City")?></td>
					<td><?php echo odbc_result($rs1, "Brand")?></td>
					
					<?php 
					//$tot_amt = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
					$rs4 = odbc_exec($conn, "SELECT * FROM [MemFin Royalty Credit] WHERE [Trust ID]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));
						
					$rs2 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Trust ID]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));
					$rs3 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Trust ID]='".odbc_result($rs1, "ID")."' ") or die(odbc_errormsg($conn));
						
					//echo "SELECT * FROM [CRM Agreement] WHERE [Trust Name]='".odbc_result($rs1, "Trust Name")."'";
					while(odbc_fetch_array($rs2)){
					?>
					
					<td><?php echo number_format(odbc_result($rs4, "Total Amount"),2,'.','')?></td>
					<!--td><--?php echo number_format(odbc_result($rs4, "Total Amount"),2,'.','')- number_format(odbc_result($rs2, ""),2,'.','');?></td-->
					<td><?php echo number_format(odbc_result($rs2, ""),2,'.','');?></td>
					<td><?php echo number_format(odbc_result($rs2, "") - odbc_result($rs3, ""),2,'.','');?></td>
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
	