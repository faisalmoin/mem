
<?php
 require_once 'header.php';
  
$SQL = "SELECT * from [VMS Item Requisition] WHERE (Status='0' OR Status='3')  AND [Company Name]='$ms'";
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
<h2>PO Details </h2> <!-- Page Name -->

<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Section Content -->


<form action="Principal_Approval_Add.php" enctype="multipart/form-data" method="POST">
  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th class="col-sm-4 col-md-1">Sr</th>
        <th class="col-sm-4 col-md-2">Item Name</th>
        <th class="col-sm-4 col-md-2">Specifications</th>
        <th class="col-sm-4 col-md-2">Quantity</th>
        <th class="col-sm-4 col-md-2">Requested By</th>
        <th class="col-sm-4 col-md-1">View</th>
        <th class="col-sm-1 col-md-1">Approve</th>
        <th class="col-sm-1 col-md-1">Reject</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1;while(odbc_fetch_array($result)){?>
    <tr>
      <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
      <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
      <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
      <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
      <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Requested By") ?></td> 
      <td class="col-sm-4 col-md-1">
        <a href="#myModal<?php echo $i?>" class="text-primary" data-toggle="modal"  data-target="#myModal<?php echo $i?>">View</a>
        <div id="myModal<?php echo $i?>" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sr No.<?php echo $i?></h4>
              </div>
              <div class="modal-body">
                <table>
                  <tr>
                    <th class="col-sm-4 col-md-2">Item Name</th>
                    <th class="col-sm-4 col-md-2">Specifications</th>
                    <th class="col-sm-4 col-md-2">Quantity</th>
                    <th class="col-sm-4 col-md-2">Requested By</th>
                    <th class="col-sm-4 col-md-2">Purpose</th>
                  </tr>
                  <tr>
                    <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                    <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                    <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                    <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Requested By") ?></td> 
                    <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Purpose") ?></td> 
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </td> 
      <td> <input type="radio" name="approve<?php echo $i; ?>" value="approve" /></td>
      <td class="col-sm-1 col-md-1">  <input type="radio" name="approve<?php echo $i; ?>" value="reject" /></td>
      <input type="hidden" name="approval<?php echo $i?>" value="<?php echo odbc_result($result,"ID")?>"/>                 
    </tr>
    <?php $i++;} $count=$i;?>
    </tbody>
    <input type="hidden" value="<?php echo $i?>" name="count" />
  </table>

  </div>
  <div class="row">
    <div class="col-sm-12 col-md-12 ">
      <input class="btn btn-primary pull-right" type="submit" name="submit" value="submit" align="center"/>
      <input type="button" class="btn btn-warning" value="Director's Approval" onClick="document.location.href='TakeHeadApproval.php'" />
    </div> 
  </div>
</form>

<!-- /Section Content -->
</div>
</div>
</div>
</div>
<!-- /Section 1 -->

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