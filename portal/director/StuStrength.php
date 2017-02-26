<?php 
$cmp=$_GET['c']; 
$AcadYr=$_GET['y']; 
require_once 'header.php';
$CurrDate = date('Y-m-d')." 00:00:000";		
	//$AcadSQL = odbc_exec($conn, "SELECT MAX([Code]) FROM [Academic Year] WHERE  [Start Date] <= '".$CurrDate."' AND [Company Name]='$ms'");
	//$AcadYr = odbc_result($AcadSQL, '');
?>

<div class="container">
<div style="border: 0px solid #d3d3d3; background-color: #FFFFFF;border-radius: 5px;">

<div style="text-align: center;">
<h2 class="text-primary"><?php 
	$comp_name = odbc_exec($conn, "SELECT [Name] FROM [Company Information] WHERE [ID]='".$_GET['c']."'") or die("Line 159");
	echo odbc_result($comp_name, "Name");					
?></h2>
<h3 class="text-primary" align="center">Student Strength</h3>
 <h3><?php echo $_GET['y']; ?></h3>
	<!-- <h3 class="text-primary" align="left">Academic Year </h3> -->
</div>
<hr />
<div class="table">
<table class="table" style="color: #736f6e;">
<tr style="font-weight: bold;">
	<td style="border: 0px;">Class</td>
	<?php
		$StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='".$_GET['c']."' ORDER BY [Section]") or die(odbc_errormsg($conn));
		$colspan = odbc_num_rows($StuSec);
		while(odbc_fetch_array($StuSec)){
			echo "<td  style='border: 0px;' align='center'>".odbc_result($StuSec, 'Section')."</td>";
		}
	?>
	<td style="border: 0px;" align="center">TOTAL</td>
</tr>
<?php
	$StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='".$_GET['c']."' ORDER BY [Sequence]");
	while(odbc_fetch_array($StuClass)){
?>
<tr><td>
<?php echo odbc_result($StuClass, 'Description'); ?>
</td>
<?php 
$StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='".$_GET['c']."' ORDER BY [Section]") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($StuSecCount)){
	$CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student]  WHERE [Company Name]='".$_GET['c']."'  AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '".$_GET['y']."'  AND [Student Status] = 1 ");
		if(odbc_result($CountStu, '') != 0){
			echo "<td align='center'>";
			//echo "<a href='RptStudentClass.php?cmp=$cmp&y=$AcadYr&c=".odbc_result($StuClass, 'Code')."&s=".odbc_result($StuSecCount, 'Section')." '>".odbc_result($CountStu, '')."</a>";
			echo odbc_result($CountStu, '');
		}
		else{
			echo "<td align='center' style='color: #E3E4FB'>";
			echo odbc_result($CountStu, '');
		}
		echo "</td>";
	}
	$ClassStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".$_GET['c']."' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Academic Year] = '".$_GET['y']."'  AND [Student Status] = 1 ");
	echo "<td style='";
	echo odbc_result($ClassStrength, '')!=0? "color: #000000;":"color: #E3E4FB;";
	echo"' align='center'>".odbc_result($ClassStrength, '')."</td>";
?>
</tr>

<?php
	}
?>

<tr style="font-size: 18px;">
	<td colspan="<?php echo ($colspan+1)?>"><strong>TOTAL</strong></td>
	<td style="color: #000000;" align="center"><b>
		<?php
			$SchStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".$_GET['c']."'  AND [Academic Year] = '".$_GET['y']."'  AND [Student Status] = 1 ");
			echo odbc_result($SchStrength, '');
		?></b>
	</td>
</tr>
</table>
</div>
</div>
</div>
<?php require_once("footer.php");?>