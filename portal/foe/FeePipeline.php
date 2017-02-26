<?php
	require_once("header.php");
	
?>
<div class="container">
	<h2 class="text-primary">Fee in Pipeline <small>Fees not yet realised</small></h2>
	<table class="table table-responsive table-striped">
		<thead>
			<tr>
				<th>S/N</th>
				<th>Customer No.</th>
				<th>Name</th>
				<th>Class</th>
				<th>Payment Mode</th>
				<th>Payment Date</th>
				<th>Instr. No.</th>
				<th>Instr. Date</th>
				<th>Bank & Branch Name</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
	<?php 
		$i = 1;
		
		$query = "SELECT * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Payment Realization]=0";
		
		$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
		<tr>
			<td><?php echo $i; ?>
			<td><a href="Pipeline.php?cust=<?php echo odbc_result($rs, "Customer No");?>"><?php echo odbc_result($rs, "Customer No");?></a></td>
			<?php 
				$cust = odbc_exec($conn, "SELECT [Name], [Class] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
			?>
			<td><?php echo odbc_result($cust, "Name")?></td>
			<td><?php echo odbc_result($cust, "Class")?></td>
			<td><?php echo odbc_result($rs, "Payment Mode")?></td>
			<td><?php echo date('d/M/Y', odbc_result($rs, "Payment Date"))?></td>
			<td><?php echo odbc_result($rs, "Cheque No")?></td>
			<td><?php echo odbc_result($rs, "Cheque Date")!="1900-01-01 00:00:00.000"?date('d/M/Y', strtotime(odbc_result($rs, "Cheque Date"))):"";?></td>
			<td><?php echo odbc_result($rs, "Bank Name")?></td>
			<td style="text-align: right;"><?php echo number_format((odbc_result($rs, "Debit Amount")+odbc_result($rs, "Adv Fee")),2,'.','')?></td>
		</tr>
	<?php 
			$i++;
		}
	?>
			<tr style="font-weight: bold;">
				<td colspan="9">TOTAL</td>
				<td style="text-align: right;">
					<?php 
						$tot_amt = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
						echo number_format(odbc_result($tot_amt, ""),2,'.','');
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<?php require_once("../footer.php"); ?>