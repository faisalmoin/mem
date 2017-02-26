<?php
	require_once("header.php");
	
?>
<div class="container">
	<h2 class="text-primary">Fee Outstanding </h2>
	<table class="table table-responsive table-striped">
		<thead>
			<tr>
				<th>S/N</th>
				<th>Customer No.</th>
				<th>Name</th>
				<th>Class</th>
				<th>Academic Year</th>
				<th>Debit Amount</th>
				<th>Credit Amount</th>
				<th>Due Amount</th>
			</tr>
		</thead>
		<tbody>
	<?php 
		
	$i = 1;
		
		$query = "SELECT distinct([Customer No]) FROM [Ledger Credit] WHERE [Company Name]='$ms' ";
		
		$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
			$x = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
			$y = odbc_exec($conn, "SELECT SUM([Debit Amount] + [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
			
			$diff = odbc_result($x, "") - odbc_result($y, "");
			
			if($diff > 0){
	?>
		<tr>
			<td><?php echo $i; ?>
			<td><a href="LedgerDetails.php?CustomerNo=<?php echo odbc_result($rs, "Customer No");?>"><?php echo odbc_result($rs, "Customer No");?></a></td>
			<?php 
				$cust = odbc_exec($conn, "SELECT [Name], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
			?>
			<td><?php echo odbc_result($cust, "Name")?></td>
			<td><?php echo odbc_result($cust, "Class")?></td>
			<td><?php echo odbc_result($cust, "Academic Year")?></td>
			<td><?php echo number_format(odbc_result($x, ""),2,'.',''); ?></td>
			<td><?php echo number_format(odbc_result($y, ""),2,'.',''); ?></td>
		   <td><?php echo $diff;?></td>
			</tr>
	<?php 
			}
			$i++;
		}
	?>
			
		</tbody>
	</table>
</div>

<?php require_once("../footer.php"); ?>