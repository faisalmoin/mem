<?php
	require_once("header.php");
?>
<div class="container">
	<table class="table table-responsive">
		<tr>
			<td colspan="13" style="border-top: none;"><h3 class="text-primary">Enquiry Details</td>
		</tr>
		<tr>
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
			$Enq = odbc_exec($conn, "SELECT YEAR([Enquiry Date]) AS report_year FROM [Temp Enquiry] (NOLOCK) WHERE [Company Name]='$ms'  GROUP BY YEAR([Enquiry Date]) ORDER BY YEAR([Enquiry Date]) DESC;") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($Enq)){
		?>
		<tr>
			<td><?php echo odbc_result($Enq, 'report_year');?></td>
			<?php 
				for($i=1; $i<=12; $i++){
					$Count = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND YEAR([Enquiry Date])='".odbc_result($Enq, 'report_year')."' AND MONTH([Enquiry Date])='$i'") or die(odbc_errormsg($conn));
			?>
			<td><a href="RptListEnquiry.php?y=<?php echo odbc_result($Enq, 'report_year')?>&m=<?php echo $i?>"><?php echo odbc_result($Count, '');?></a></td>
			<?php
				}
			?>
			<td><?php 
				$TotCount = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND YEAR([Enquiry Date])='".odbc_result($Enq, 'report_year')."' ") or die(odbc_errormsg($conn));
				echo "<a href='RptListEnquiry.php?y=".odbc_result($Enq, 'report_year')."'>".odbc_result($TotCount, '')."</a>";
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