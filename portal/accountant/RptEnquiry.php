<?php
	require_once("header.php");
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
<h2>Enquiry Details  </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->


	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
		<thead>
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
		</thead>
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