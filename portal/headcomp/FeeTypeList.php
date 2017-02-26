<?php
	require_once("SetupLeft.php");
	
	if(isset($_GET['delete_id']))
	{
		$Acad = odbc_exec($conn, "Delete FROM [Fee Type] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));
	
		echo '<META http-equiv="refresh" content="0;URL=FeeTypeList.php"> ';
	}
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- /Datatable -->

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
<h2>Fee Type </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeTypeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr style="font-weight: bold;color: #0B3B2E;font-size: 15px">
		<td>SN</td>
		<td>Fee Type</td>
		<td>Fee Description</td>
		<td>Start Date</td>
		<td>End Date</td>
		<td>Academic Year</td>
                <!--td></td-->
	</tr>
	</thead>
	<tbody>
	<?php
		$i = 1;
		$rs = odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><a href="FeeTypeEdit.php?FeeId=<?php echo odbc_result($rs, "ID")?>"><?php echo odbc_result($rs, "Code")?></a></td>
		<td><?php echo odbc_result($rs, "Description"); ?></td>
		<td><?php echo date('d/M/Y',odbc_result($rs, "Start Date")); ?></td>
		<td><?php echo date('d/M/Y',odbc_result($rs, "End Date")); ?></td>
		<td><?php echo odbc_result($rs, "Academic Year"); ?></td>
	</tr>
	<?php
			$i++;
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

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
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


<script type="text/javascript">
function delete_id(ID)
{
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='FeeTypeList.php?delete_id='+ID;
     }
}
</script>
<?php
	require_once("SetupRight.php");
?>