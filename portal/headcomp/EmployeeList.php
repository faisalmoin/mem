<?php 
require_once("SetupLeft.php"); 

if(isset($_GET['delete_id']))
{
	$Acad = odbc_exec($conn, "Delete FROM [Employee] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));

	echo '<META http-equiv="refresh" content="0;URL=EmployeeList.php"> ';
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
<h2>Employee List </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
<li><a href="EmployeeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>               
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
	<tr style="color: #0B3B2E;font-size: 15px">
        <th>SN</th>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Job type</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Employee] WHERE [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><a href="EmployeeDetails.php?Id=<?php echo odbc_result($rs, "ID")?>"><?php echo odbc_result($rs, "No_")?></a></td>
		<td><?php echo odbc_result($rs, "First Name");?></td>
                <td><?php echo odbc_result($rs, "Department");?></td>
                <td><?php echo odbc_result($rs, "Job Title");?></td>
                <td><?php if(odbc_result($rs, "Status") == 1) { echo "Active"; }
                if(odbc_result($rs, "Status") == 0) { echo "InActive"; }?></td>
                <td><a href="EmployeeEdit.php?Id=<?php echo odbc_result($rs, "ID")?>"><img src="Edit.png" alt="Delete" style="width:17px;height:17px;" /></a></td>		
	</tr>
	<?php
			$i++;
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
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
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
        window.location.href='EmployeeList.php?delete_id='+ID;
     }
}
</script>

<?php require_once("SetupRight.php"); ?>