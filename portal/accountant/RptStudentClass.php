<?php
	require_once("header.php");
	$e=isset($_REQUST['e']);
	$Enqr=isset($_REQUEST['enq']);
	if($Enqr != ""){
		if($e=1){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User enqury has been updated.
					</div>
				</div>
			</div></div>";
		}
		if($e=0){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Error!</strong> There is some error, kindly check.
					</div>
				</div>
				</div>";
		}
	}
	
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
<h2>Student List for <?php echo $_GET['c']?> - <?php echo $_GET['s']?> </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
			<thead>
				<tr>
					<td>SN</td>
					<td>Admission No.</td>
					<td>Student Name</td>
					<td>Academic Year</td>
					<td>Class & Section</td>
					<td>Addresse</td>
					<td>Contact No</td>
					<td>Date Joined</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$stu3=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number], [Date Joined] FROM [Temp Student] WHERE [Company Name]='$ms' AND [Academic Year]='".$_GET['y']."' AND [Class] LIKE '".$_GET['c']."' AND [Section] LIKE '".$_GET['s']."%' AND [Student Status]=1 ORDER BY [Date Joined] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($stu3)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i; ?></td>
					<td><a href="StudentCard.php?id=<?php echo odbc_result($stu3, "No_"); ?>"><?php echo odbc_result($stu3, "No_"); ?></a></td>
					<td><?php echo odbc_result($stu3, "Name"); ?></td>
					<td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
					<td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
					<td><?php echo odbc_result($stu3, "Addressee"); ?></td>
					<td><?php echo odbc_result($stu3, "Mobile Number"); ?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($stu3, "Date Joined"))); ?></td>
				</tr>
				<?php
						$i += 1;
					}					
				?>
			</tbody>
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