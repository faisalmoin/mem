<?php
	require_once("header.php");
?>
<div class="table">
<table class="table" style="color: #736f6e;">
<tr style="font-weight: bold;">
	<td>Class</td>
	<?php
		$StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
		$colspan = odbc_num_rows($StuSec);
		while(odbc_fetch_array($StuSec)){
			echo "<td align='center'>".odbc_result($StuSec, 'Section')."</td>";
		}
	?>
	<td align="center">TOTAL</td>
</tr>
<?php
	$StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='$ms' ORDER BY [Sequence]");
	
	while(odbc_fetch_array($StuClass)){
?>
<tr><td>
<?php echo odbc_result($StuClass, 'Description'); ?>
</td>
<?php
	$StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($StuSecCount)){
		
		$CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
		if(odbc_result($CountStu, '') != 0){
			echo "<td align='center'>";
			echo odbc_result($CountStu, '');
		}
		else{
			echo "<td align='center' style='color: #E3E4FB'>";
			echo odbc_result($CountStu, '');
		}
		echo "</td>";
	}
	$ClassStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
	echo "<td style='color: #000000;' align='center'>".odbc_result($ClassStrength, '')."</td>";
?>
</tr>
<?php
	}
?>
<tr style="font-size: 18px;">
	<td colspan="<?php echo ($colspan+1)?>"><strong>TOTAL</strong></td>
	<td style="color: #000000;" align="center"><b>
		<?php
			$SchStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
			echo odbc_result($SchStrength, '');
		?></b>
	</td>
</tr>
</table>
</div>