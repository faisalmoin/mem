<?php
	echo date("t");
	exit();
	//require_once("db.txt");
	//$id="12";
	$id = $_REQUEST['id'];
?>
<!-- http://phppot.com/jquery/jquery-dependent-dropdown-list-countries-and-states/ -->
<h1 class="text-primary">Royalty</h1>
<?php
	$td ="";
	$FeeHead = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
	$colspan = odbc_num_rows($FeeHead);
	while(odbc_fetch_array($FeeHead)){
		$td .= "<th>".odbc_result($FeeHead, "Fee Description")."</th>";
	}
?>
<table class="table table-responsive" border="1">
	<tr>
		<th rowspan="2" style="text-align: center;">Qtr</th>
		<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Generated</th>
		<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Collected</th>
	</tr>
	<tr>
		<?php echo $td; ?>
		<?php echo $td; ?>
	</tr>
	<?php
		$Fin = odbc_exec($conn, "SELECT DISTINCT([FinYr]) FROM [Ledger Invoice] WHERE [Company Name]='$id' ORDER BY [FinYr] DESC") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($Fin)){
	?>
	<tr>
		<td colspan="<?php echo ($colspan*2)+1?>" style="text-align: center; font-weight: bold;"><?php echo odbc_result($Fin, "FinYr") ?></td>
	</tr>
	<?php
		//Get Quarter
		$Qtr = odbc_exec($conn, "SELECT DISTINCT([Qtr]) FROM [Ledger Invoice] WHERE [Company Name]='$id'") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($Qtr)){
	?>
	<tr>
		<td><?php echo odbc_result($Qtr, "Qtr") ?></td>
		<?php
			$FeeHead = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($FeeHead)){
				echo "<td style='text-align: right;'>";
				$Inv = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] 
						WHERE [Fee Description] LIKE '%".odbc_result($FeeHead, "Fee Description")."%' 
						AND [Company Name]='$id' AND [Qtr]='".odbc_result($Qtr, "Qtr")."'  AND [FinYr]='".odbc_result($Fin, "FinYr")."' ");
				
				echo number_format(odbc_result($Inv, ""), "2", ".", "");
				echo "</td>";
				
			} // Fee Head
			
			$FeeHead1 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($FeeHead1)){
				echo "<td style='text-align: right;'>";
				$Pay = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] 
						WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($FeeHead1, "Fee Description")))." payable' 
						AND [Company Name]='$id' AND [Qtr]='".odbc_result($Qtr, "Qtr")."'  AND [FinYr]='".odbc_result($Fin, "FinYr")."' ");
				
				echo number_format(odbc_result($Pay, ""), "2", ".", ""); 
				echo "</td>";
			}
		?>
		
	</tr>

<?php
		} // Quarter
	} //Fin Year

?>
</table>
