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
<h2>TC Request Form </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<form name="form1" method="POST" action="StudentTCAdd.php">
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
			<thead>
				<tr>
					<td>SN</td>
					<td>Admission No.</td>
					<td>Date of Joining</td>
					<td>Student Name</td>
					<td>Gender</td>
					<td>Academic Year</td>
					<td>Class & Section</td>					
					<td>Last Class Attended</td>
					<td>Fee Cut-off Date</td>
					<td>TC No.</td>
					<td>TC Issue Date</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$stu3=odbc_exec($conn, "SELECT [TC No_], [Student Name], [Academic Year],[Fee Cut off date],[Last Attented Date], [Class], [Section], [Academic Year], [Student No_], [Date of Issue], [Gender], [Date of Joining] FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND [TC Issued]=0 ORDER BY [Date of Issue] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($stu3)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i; ?></td>
					<td><a href="StudentTCApply.php?id=<?php echo odbc_result($stu3, "Student No_"); ?>"><?php echo odbc_result($stu3, "Student No_"); ?></a></td>
					<td><?php echo ((odbc_result($stu3, "Date of Joining") != NULL)?date('d/M/Y', strtotime(odbc_result($stu3, "Date of Joining"))): ""); ?></td>
					<td><?php echo odbc_result($stu3, "Student Name"); ?></td>
					<td><?php 
							if(odbc_result($stu3, "Gender")==1) echo "Boy"; 
							if(odbc_result($stu3, "Gender")==2) echo "Girl";
							else echo odbc_result($stu3, "Gender")
					?></td>
					<td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
					<td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
					<td><?php echo ((odbc_result($stu3, "Last Attented Date") != NULL)?date('d/M/Y', strtotime(odbc_result($stu3, "Last Attented Date"))): ""); ?></td>
					<td><?php echo ((odbc_result($stu3, "Fee Cut off date") != NULL)?date('d/M/Y', strtotime(odbc_result($stu3, "Fee Cut off date"))): ""); ?></td>
					<td><?php echo odbc_result($stu3, "TC No_"); ?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($stu3, "Date of Issue"))); ?></td>
				</tr>
				<?php
						$i += 1;
					}					
				?>
			</tbody>
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

<script type="text/javascript" charset="utf-8">
	$(function()
	{
		$("#datepicker1").datepicker({ minDate: -5, maxDate: 0});
		$("#datepicker2").datepicker({changeYear: true, changeMonth: true});
		$("#datepicker3").datepicker({ minDate: 0});
		$("#datepicker4").datepicker({changeMonth: true,minDate: '-5'});
	});
</script>
<?php
	require_once("../footer.php");
?>