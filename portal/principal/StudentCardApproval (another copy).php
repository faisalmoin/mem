<?php
	require_once("header.php");
	
	
?>
<div class="container">
	<h3 class="text-primary">Student Card Approval</h3>
	<table class="table table-responsive">
		<tr>
			<td>SN</td>
			<td>Admission No</td>
			<td>Name</td>
			<td>Class</td>
			<td>Section</td>
			<td>Issue Date</td>
			<td>Approval Date</td>
		</tr>
		<?php
			$i=1;
			$result = odbc_exec($conn, "SELECT DISTINCT([AdmissionNo]), [Name], [RequestDateTime], [ApproverDateTime] FROM [approvalrequest] WHERE [CompanyName]='$ms' AND [ApproverID]='$LoginID' AND [ApproverDateTime]='' ORDER BY [id] DESC") or die(mysql_error());
			while($row=odbc_fetch_array($result)){
				$rs = odbc_exec($conn, "SELECT [Name], [Class], [Section] FROM [Temp Student] WHERE [No_]='".odbc_result($row, "")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));				
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><a href="StudentCard.php?id=<?php echo odbc_result($row, "");?>"><?php echo odbc_result($row, "");?></a></td>
			<td><?php echo odbc_result($rs, 'Name');?></td>
			<td><?php echo odbc_result($rs, 'Class');?></td>
			<td><?php echo odbc_result($rs, 'Section');?></td>
			<td><?php echo odbc_result($row, "RequestDateTime");?></td>
			<td><?php echo odbc_result($row, "ApproverDateTime");?></td>
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