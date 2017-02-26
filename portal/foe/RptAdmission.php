<?php
	require_once("header.php");
?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #FBF8EF}
</style>
<div class="container">
	<table class="table table-responsive">
		<tr>
			<td colspan="13" style="border-top: none;"><h3 class="text-primary">Admission Details</td>
		</tr>
		<tr style="font-weight: bold;">
			<td>Year</td>
			<td>Jan</td>
			<td>Feb</td>
			<td>Mar</td>
			<td>Apl</td>
			<td>May</td>
			<td>Jun</td>
			<td>Jul</td>
			<td>Aug</td>
			<td>Sep</td>
			<td>Oct</td>
			<td>Nov</td>
			<td>Dec</td>
			<td>TOTAL</td>
		</tr>
		<?php
			$Enq = odbc_exec($conn, "SELECT YEAR([Date Joined]) AS report_year FROM [Temp Student] (NOLOCK) WHERE [Company Name]='$ms'  GROUP BY YEAR([Date Joined]) ORDER BY YEAR([Date Joined]) DESC;") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($Enq)){
		?>
		<tr>
			<td><?php echo odbc_result($Enq, 'report_year');?></td>
			<?php 
				for($i=1; $i<=12; $i++){
					$Count = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND YEAR([Date Joined])='".odbc_result($Enq, 'report_year')."' AND MONTH([Date Joined])='$i'") or die(odbc_errormsg($conn));
			?>
			<td><a href="RptListAdmission.php?y=<?php echo odbc_result($Enq, 'report_year')?>&m=<?php echo $i?>"><?php echo odbc_result($Count, '');?></a></td>
			<?php
				}
			?>
			<td><?php 
				$TotCount = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND YEAR([Date Joined])='".odbc_result($Enq, 'report_year')."' ") or die(odbc_errormsg($conn));
				echo "<a href='RptListAdmission.php?y=".odbc_result($Enq, 'report_year')."'>".odbc_result($TotCount, '')."</a>";
			?></td>
		</tr>
		<?php
			}
		?>
	</table>
</div>
<?php
	require_once("../footer.php");
?>