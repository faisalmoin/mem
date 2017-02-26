<?php require_once('SetupLeft.php');
require_once("SetupLeft.php");
/*if(isset($_GET['delete_id']) || ($_GET['des']))
{
	$Acad = odbc_exec($conn, "Delete FROM [Discount Fee Header] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));

	$Acad1 = odbc_exec($conn, "Delete FROM [Fee Classification] WHERE [ID]='{$_REQUEST['des']}'") or exit(odbc_errormsg($conn));

	echo '<META http-equiv="refresh" content="0;URL=FeeDiscountCatList.php"> ';
}
?>
<script type="text/javascript">
function delete_id(ID,des)
{
     if(confirm('Sure To Remove This Record ?'))
     {
    	// alert(ID);
        window.location.href="FeeDiscountCatList.php?delete_id="+ID+"&des="+des;
     }
}
</script>
 * 
 */
if(isset($_GET['delete_id']))
{
	$Acad = odbc_exec($conn, "Delete FROM [Discount Fee Header] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));

	
	echo '<META http-equiv="refresh" content="0;URL=FeeDiscountCatList.php"> ';
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
<h2>Discount Fee Category </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeDiscountCatNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="30px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<script type="text/javascript">
function delete_id(ID,des)
{
     if(confirm('Sure To Remove This Record ?'))
     {
    	// alert(ID);
        window.location.href="FeeDiscountCatList.php?delete_id="+ID;
     }
}
</script>

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr style="font-weight: bold;color: #0B3B2E;font-size: 15px">
		<td>SN</td>
		<td>Code</td>
		<td>Description</td>
		<td>Academic Year</td>
		<td>Curriculum</td>
                <!--td></td-->
	</tr>
	</thead>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i?></td>
		<td><a href="FeeDiscountCatEdit.php?Id=<?php echo odbc_result($rs, "ID")?>"><?php echo odbc_result($rs, "No_")?></a></td>
		<td><?php
			$get = odbc_exec($conn, "SELECT [ID], [Description] FROM [Fee Classification] WHERE [Code]='".odbc_result($rs, "Fee Clasification Code")."' AND [Company name]='$CompName'");
			echo odbc_result($get, "Description");
		?></td>
		<td><?php echo odbc_result($rs, "Academic Year")?></td>
		<td><?php echo odbc_result($rs, "Curriculum")?></td>
		<!--td><a href="javascript:delete_id(<?php echo odbc_result($rs, "ID")?>)"><img src="wrong.jpeg" alt="Delete" style="width:20px;height:20px;" /></a></td-->
	        <!--td><a href="javascript:delete_id(<--?php echo odbc_result($rs, "ID")?>,<--?php echo odbc_result($get, "ID")?>)"><img src="wrong.jpeg" alt="Delete" style="width:20px;height:20px;" /></a></td-->
	</tr>
	<?php
			$i++;
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
<?php require_once('SetupRight.php'); ?>