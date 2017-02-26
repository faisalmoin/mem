<?php
    require_once("SetupLeft.php");
    
//echo "SELECT * FROM [user] WHERE [ID] IN (SELECT [UserTableID] FROM [usermap] WHERE [CompanyTableID]='$CompName')";
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
<h2>Approval Master </h2>
<ul class="nav navbar-right panel_toolbox">
<!-- li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li -->
<!-- li><a href="CertificateNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li -->
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="ApprovalmasterAdd.php" method="post">
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
		<thead>
		<tr style="font-weight: bold;color: #0B3B2E;font-size: 15px">
			<td>SN</td>
			<td>Name</td>
			<td>User Type</td>
			<td>Approval Master</td>
		</tr>
		</thead>
		<tbody>
		<?php
			$i=1;
                        $result = odbc_exec($conn, "SELECT * FROM [user] WHERE [ID] IN (SELECT [UserTableID] FROM [usermap] WHERE [CompanyTableID]='$CompName')") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($result)){
                        $View = odbc_exec($conn, "SELECT * FROM [approvalmaster] WHERE [UserID]='".odbc_result($result, "id")."' AND [UserEmail]='".odbc_result($result, "Email")."' AND [CompanyName]='$CompName' ");
		       // echo odbc_result($View, "ApproverID");
                        $ViewUser = odbc_exec($conn, "SELECT * FROM [user] WHERE [ID]='".odbc_result($View, "ApproverID")."' AND [Email]='".odbc_result($View, "ApproverEmail")."' ");
                      // echo odbc_result($ViewUser, "UserType");
                         
                        ?>
		<tr>
			<td><?php echo $i;?></td>
                        <td>
                            <?php echo odbc_result($result, "FullName"); ?>
                            <input type="hidden" name="UserID[]" value="<?php echo odbc_result($result, "ID")?>" >
                            <input type="hidden" name="UserEmail[]" value="<?php echo odbc_result($result, "Email")?>" >
                        </td>
                        <td><?php echo odbc_result($result, "UserType"); ?></td>
                        <td>
                            <?php $mssql1="SELECT * FROM [user] WHERE [ID] IN (SELECT [UserTableID] FROM [usermap] WHERE [CompanyTableID]='$CompName')";
				$msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
				?>
				<select name="ApprovalMaster[]" class="form-control"
                <option value="0"></option>
				<option value="<?php echo odbc_result($ViewUser, "UserType");?>"></option>
				<?php while(odbc_fetch_array($msAY)){
                                echo "<option value='".odbc_result($msAY, "ID")."'";
                                if(odbc_result($msAY, "UserType") == odbc_result($ViewUser, "UserType") ){echo " selected";}
                                echo ">".odbc_result($msAY, "UserType")."</option>";
				 }?>
				</select>
                </td>
                        
		</tr>
		<?php	
				$i++;
			}
		?>
                <tr>
                <td>
                    <input type="hidden" value="<?php echo $CompName; ?>" name="CompName" />
                    <input type="hidden" value="<?php echo $i; ?>" name="count" id="count" />
	            <button type="submit" class="btn btn-success">Submit</button>
                </td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
		</tbody>
		</table>
            </form>

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

