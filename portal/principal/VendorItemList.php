
<?php
require_once 'header.php';

 
  $SQL = "SELECT * from [VMS Vendor Master]";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
    if(!result){
        exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
    }		
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<!-- Body -->
<div class="right_col" role="main" style="border-left: 1px solid #d2d2d2;">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<!-- Section 1 -->
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Vendor List </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Section Content -->


                 <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Vendor</th>
                            <th>Vendor Name</th>
                            <th>Address</th>   
                            <th>TIN</th>
                            <th>CST</th>
                            <th>PAN</th>
                            <th>TAN</th>
                            <th>Service Tax</th>                            
                        </tr>
                    </thead>
                    <tbody>
                       <?php $i=1;while(odbc_fetch_array($result)){?>                    
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo odbc_result($result,"Vendor") ?></td>
                            <td><?php echo odbc_result($result,"Vendor Name") ?></td>
                            <td><?php echo odbc_result($result,"Address") ?></td>
                            <td><?php echo odbc_result($result,"TIN") ?></td>
                            <td><?php echo odbc_result($result,"CST") ?></td>
                            <td><?php echo odbc_result($result,"PAN") ?></td>
                            <td><?php echo odbc_result($result,"TAN") ?></td>
                            <td><?php echo odbc_result($result,"Service Tax Number") ?></td>
                        </tr>
                       <?php $i++;}?>
                    </tbody>
                </table>
                                              
<!-- /Section Content 2 -->
</div>
</div>
</div>
</div>
<!-- /Section 2 -->

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

<?php require_once("../footer.php");?>