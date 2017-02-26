<?php
	require_once("SetupLeft.php");
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
<h2>Calendar <small>2016</small> </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
<li><a href="CalendarNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>                              
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">


<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
    <tr style="background-color: #eee;">
            <th>SN</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Description</th>
            <th>Event Type</th>
            <th style="text-align: center;">No.  of Days</th>
    </tr>
    </thead>
    <tbody>
    <?php
            $i = 1;

            $result= odbc_exec($conn, "SELECT * FROM [Calendar] WHERE [Company Name]='$CompName' ORDER BY [Start Date] ASC") or die(odbc_errormsg($conn));
            while(odbc_fetch_array($result)){
    ?>
    <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date('d/M/Y', odbc_result($result, "Start Date")); ?></td>
    <td><?php echo date('d/M/Y', odbc_result($result, "End Date")); ?></td>
    <td><a href="CalendarEdit.php?id=<?php echo odbc_result($result, "ID");?>" class="text text-primary"><?php echo odbc_result($result, "Description"); ?></a></td>
    <td><?php 
        if(odbc_result($result, "Activity Type")==1) echo "Holiday"; 
        if(odbc_result($result, "Activity Type")==2) echo "Event"; 
        if(odbc_result($result, "Activity Type")==3) echo "Weekly off"; 
    ?></td>
    <td style="text-align: center;">
        <?php echo round(floor((odbc_result($result, "End Date"))-(odbc_result($result, "Start Date")))/(60*60*24)); ?>
    </td>
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
        $('#datatable-responsive').DataTable({
            fixedHeader: true
        });
    });
</script>
<!-- /Datatables -->
<?php
	require_once("SetupRight.php");
?>
