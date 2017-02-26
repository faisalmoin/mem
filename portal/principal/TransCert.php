<?php
	require_once("header.php");
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


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
<h2>Transfer Certificate Details </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
	<thead>
		<tr>
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
	</thead>
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
			<td align='center'><a href="ListTransCert.php?y=<?php echo odbc_result($Enq, 'report_year')?>&m=<?php echo $i?>"><?php echo odbc_result($Count, '');?></a>
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
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<!-- Datatables -->
<script>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<!-- /Datatables -->

<?php
	require_once("../footer.php");
?>