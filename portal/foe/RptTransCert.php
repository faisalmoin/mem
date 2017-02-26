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
			<td colspan="13" style="border-top: none;"><h3 class="text-primary">Transfer Certificate Details</td>
		</tr>
		<tr style="font-weight: bold;">
			<td>Year</td>
			<td align='center'>Jan</td>
			<td align='center'>Feb</td>
			<td align='center'>Mar</td>
			<td align='center'>Apl</td>
			<td align='center'>May</td>
			<td align='center'>Jun</td>
			<td align='center'>Jul</td>
			<td align='center'>Aug</td>
			<td align='center'>Sep</td>
			<td align='center'>Oct</td>
			<td align='center'>Nov</td>
			<td align='center'>Dec</td>
			<td align='center'>TOTAL</td>
		</tr>
		<?php
			$Enq = odbc_exec($conn, "SELECT YEAR([Date of Issue]) AS report_year FROM [Temp Transfer Certificate] (NOLOCK) WHERE [Company Name]='$ms'  GROUP BY YEAR([Date of Issue]) ORDER BY YEAR([Date of Issue]) DESC;") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($Enq)){
		?>
		<tr>
			<td><?php echo odbc_result($Enq, 'report_year');?></td>
			<?php 
				for($i=1; $i<=12; $i++){
					$Count = odbc_exec($conn, "SELECT COUNT([TC No_]) FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND [TC Issued]=1 AND YEAR([Date of Issue])='".odbc_result($Enq, 'report_year')."' AND MONTH([Date of Issue])='$i'") or die(odbc_errormsg($conn));
					if(odbc_result($Count, '') != 0){
			?>			
			<td align='center'><a href="RptListTransCert.php?y=<?php echo odbc_result($Enq, 'report_year')?>&m=<?php echo $i?>"><?php echo odbc_result($Count, '');?></a>
			<?php
					}
					else{
					echo "<td align='center' style='color: #E3E4FB'>".odbc_result($Count, '')."</td>";
					}
				}
			?>
			<?php 
				$TotCount = odbc_exec($conn, "SELECT COUNT([TC No_]) FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND [TC Issued]=1 AND YEAR([Date of Issue])='".odbc_result($Enq, 'report_year')."' ") or die(odbc_errormsg($conn));
				if(odbc_result($TotCount, '') != 0){
					echo "<td align='center'><a href='ListTransCert.php?y=".odbc_result($Enq, 'report_year')."'>".odbc_result($TotCount, '')."</a>";
				}
				else{
					echo "<td align='center' style='color: #E3E4FB'>".odbc_result($TotCount, '');
				}
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