<?php
	require_once("SetupLeft.php");
?>
<a href="RegistrationNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="50px" alt="Create New"></a>
<h1 class="text-primary">Registration</h1>
<table class="table table-responsive">
	<tr>
		<td>SN</td>
		<td>Academic Year</td>
		<td>Start Date</td>
		<td>End Date</td>
		<td>Fee Code</td>
		<td>Amount</td>
	</tr>
	<?php
		$i = 1;
		$sql = "SELECT [ID], [Academic Year],[Application Sales From] AS [StDt], [Application Sales To] AS [EndDt], 
					[Registration Batch Name] AS [Code], [Application Cost] AS [Amt] FROM [Admission Setup] 
					WHERE [Company Name]='$CompName' ORDER BY [Academic Year] DESC";
		$rs = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo odbc_result($rs, 'Academic Year'); ?></td>
		<td><?php echo date('d/M/Y', strtotime(odbc_result($rs, 'StDt'))); ?></td>
		<td><?php echo date('d/M/Y', strtotime(odbc_result($rs, 'EndDt'))); ?></td>
		<td><?php echo odbc_result($rs, 'Code'); ?></td>
		<td align="right"><?php echo number_format(odbc_result($rs, 'Amt'), 2, '.', ','); ?></td>
		
	</tr>
	<?php
			$i++;
		}	
	?>
</table>
<?php
	require_once("SetupRight.php");
?>