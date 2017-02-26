<?php
	require_once("header.php");
?>
<table class="table table-responsive">
	<tr>
		<td colspan="6"><h3 class="text-danger" style="font-weight: bold;">Activity List</h3></td>
	</tr>
	<tr>
		<th>Date</th>
		<th>Activity</th>
		<th>Outcome</th>
		<th>Remarks</th>
		<th>Contact Person</th>
		<th>Contact No</th>
	</tr>
	<?php
		$act = odbc_exec($conn, "SELECT * FROM [CRM Activity] WHERE [Assign To]='$LoginID' AND [Lead ID]='".odbc_result($sql, "ID")."' ORDER [Date] DESC") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($act)){
	?>
	<tr>
		<td><?php echo odbc_result($act, "Date"); ?></td>
		<td><?php echo odbc_result($act, "Activities"); ?></td>
		<td><?php echo odbc_result($act, "Outcome"); ?></td>
		<td><?php echo odbc_result($act, "Remarks"); ?></td>
		<td><?php echo odbc_result($act, "Contact Person"); ?></td>
		<td><?php echo odbc_result($act, "Contact No"); ?></td>
	</tr>
	<?php
		}	
	?>
</table>

<?php require_once("../footer.php"); ?>