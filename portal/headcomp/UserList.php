<?php
    require_once("SetupLeft.php");
    $result = odbc_exec($conn, "SELECT * FROM [user] WHERE [ID] IN (SELECT [UserTableID] FROM [usermap] WHERE [CompanyTableID]='$CompName')") or die(odbc_errormsg($conn));
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
<h2>User List </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="CertificateNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">


<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
			
			<tr style="font-weight: bold;color: #0B3B2E;font-size: 15px">
				<td>SN</td>
				<td>Name</td>
				<td>Contact No.</td>
				<td>Email</td>
				<td>UserType</td>
				<td>Status</td>
				<td>Online Status</td>
			</tr>
			</thead>
		<tbody>
		<?php
			$i=1;
			while(odbc_fetch_array($result)){
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><a href="UserEdit.php?id=<?php echo odbc_result($result, "id");?>"><?php echo odbc_result($result, "FullName");?></a></td>
			<td><?php echo odbc_result($result, "ContactNo");?></td>
			<td><?php echo odbc_result($result, "Email");?></td>
			<td><?php echo odbc_result($result, "UserType")?></td>
			<td><?php echo odbc_result($result, "UserStatus"); ?></td>
			<td align="center"><?php  
				$Online = odbc_exec($conn, "select [ActiveStat] FROM [login] 
						WHERE [Login] IN (SELECT [LoginID] FROM [user] WHERE ID=".odbc_result($result, "id").") AND
						[LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login] IN 
						(SELECT [LoginID] FROM [user] WHERE ID=".odbc_result($result, "id").")
						)") or exit(odbc_errormsg($conn));
				if(odbc_result($Online, "ActiveStat")==1){
					echo "<div style='width: 14px;height: 14px;background: rgb(0,255,0);-moz-border-radius: 70px;-webkit-border-radius: 70px;border-radius: 70px;'> </div>";
				}
				if(odbc_result($Online, "ActiveStat")==0){
					echo	"<div style='width: 14px;height: 14px;background: rgb(128,128,128);-moz-border-radius: 70px;-webkit-border-radius: 70px;border-radius: 70px;'></div>";
				}
			?></td>
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
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<?php require_once("SetupRight.php"); ?>

