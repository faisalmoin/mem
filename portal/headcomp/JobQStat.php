<?php
	require_once("header.php");
?>
	<script>
		setInterval(function() {
			window.location.reload();
			}, 10000); 
	</script>
	
	<div class="container">
		<h2 class="text-primary">Job Queue Status <small>last 100 records</small></h2>
		<table  class="table table-stripped table-bordered">
			<tr>
				<td>SN</td>
				<td>ID</td>
				<td>Start Time</td>
				<td>End Time</td>
				<td>Status</td>
				<td>Mesage</td>
			</tr>
			<?php
				$i=1;
				$sql = "select top 100 [Entry No_],[Start Date_Time], [End Date_Time], [Status], [Error Message], [Error Message 2], [Error Message 3], [Error Message 4] FROM schoolerp.dbo.[Training Company-TMS\$Job Queue Log Entry] ORDER BY [Entry No_] DESC";
				
				$rs = odbc_exec($conn, $sql) or exit(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
			?>
			<tr>
				<td><?php echo $i?></td>
				<td><?php echo odbc_result($rs, "Entry No_"); ?></td>
				<td><?php echo date("d/M/Y H:i:s", strtotime(odbc_result($rs, "Start Date_Time"))); ?></td>
				<td><?php echo date("d/M/Y H:i:s", strtotime(odbc_result($rs, "End Date_Time"))); ?></td>
				<td><?php if(odbc_result($rs, "Status") > 0) {echo "ERROR";} else{ echo "Success";} ?></td>
				<td><?php echo odbc_result($rs, "Error Message") ."  ". odbc_result($rs, "Error Message 2") ."  ". odbc_result($rs, "Error Message 3") ."  ". odbc_result($rs, "Error Message 4"); ?></td>
			</tr>
			<?php
					$i++;
				}
			?>
		</table>
	</div>
<?php 
	require_once("../footer.php"); 
?>