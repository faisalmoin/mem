<?php 
require_once 'header.php';
$CurrDate = date('Y-m-d')." 00:00:000";		
	$AcadSQL = odbc_exec($conn, "SELECT MAX([Code]) FROM [Academic Year] WHERE  [Start Date] <= '".$CurrDate."' AND [Company Name]='$ms'");
	$AcadYr = odbc_result($AcadSQL, '');
?>
<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Academic Year <?php echo $AcadYr; ?> </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
		
		<thead>
<tr style="font-weight: bold;">
	<td style="border: 0px;">Class</td>
	<?php
		$StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
		$colspan = odbc_num_rows($StuSec);
		while(odbc_fetch_array($StuSec)){
			echo "<td  style='border: 0px;' align='center'>".odbc_result($StuSec, 'Section')."</td>";
		}
	?>
	<td style="border: 0px;" align="center">TOTAL</td>
</tr></thead>
<?php
	$StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='$ms' ORDER BY [Sequence]");
	while(odbc_fetch_array($StuClass)){
?>
<tbody>
<tr><td>
<?php echo odbc_result($StuClass, 'Description'); ?>
</td>
<?php
	$StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($StuSecCount)){
		
		$CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student]  WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
		if(odbc_result($CountStu, '') != 0){
			echo "<td align='center'>";
			echo "<a href='RptStudentClass.php?y=$AcadYr&c=".odbc_result($StuClass, 'Code')."&s=".odbc_result($StuSecCount, 'Section')." '>".odbc_result($CountStu, '')."</a>";
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
</tbody>
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

<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->


<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php require_once("../footer.php");?>