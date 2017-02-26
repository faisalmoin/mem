<?php
/**
 * Created by Pallab DB.
 * User: Pallab DB
 * Date: 5/8/2015
 * Time: 4:46 PM
 */

    require_once("header.php");

    if(isset($_REQUEST['submit'])) {
        if (!empty($_REQUEST['AdmNo'])) {
            $Stu = "SELECT * FROM [Temp Student] WHERE [Company Name] = '$ms' AND [Student Status] <3 AND (lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Mobile Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Phone Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Enquiry No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Application No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Registration No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
            $check = odbc_exec($conn, $Stu);
            if(odbc_num_rows($check) < 1){
                echo("<div class='container'>
				        <div class='bs-example'>
					        <div class='alert alert-danger alert-error'>
						        <a href='#' class='close' data-dismiss='alert'>&times;</a>
						        <strong>Error!</strong> Data not found, kindly check ...
					        </div>
				        </div>
				    </div>");
            }
            /*else{
                header("Location: StudentCard.php?q=".odbc_result($check, 'No_'));
            }*/
        } else {
            echo "<div class='container'>
				    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Error!</strong> Please provide Student's Enrollment/Admission Number ...
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
<h2>Student's Card </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

        <div class="panel-heading"><h3 class="text-primary"></h3></div>
            <div class="panel-body">
                <form role="form" method="get">
                    <div class="row form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"><label class="control-label">Student Enrollment No.</label></div>
                        <div class="col-sm-4"><input type="text" name="AdmNo" title="Enter Student's Name / Application No / Registration No / Mobile Number / Phone Number / Enquiry No. ..." class="form-control input-lg" required autocomplete="Off" autofocus="true" style="text-transform: uppercase" /></div>
                        <div class="col-sm-2"><button type="submit" class="btn btn-primary input-lg" name="submit">Submit</button></div>
                        </div>
                </form>
            </div>
        </div>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Student List </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

        <div class="table-responsive">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
                <thead>
                    <tr style="font-weight: bold;" class="warning">
                        <td>SN</td>
                        <td>Registration No</td>
                        <td>Student Name</td>
                        <td>Gender</td>
                        <td>Class</td>
                        <td>Section</td>
                        <td>Academic Year</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    $Student = odbc_exec($conn, $Stu);
                    while(odbc_fetch_array($Student)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <a href="StudentCard.php?id=<?php echo odbc_result($Student, "No_")?>" class="text-primary"><?php echo odbc_result($Student, "No_"); ?></a>
                        <?php
                            //require("ModalStuCard.php");
                        ?>
                    </td>
                    <td><?php echo odbc_result($Student, "Name"); ?></td>
                    <td><?php
                            if(odbc_result($Student, "Gender") == 1) echo "Boy";
                            if(odbc_result($Student, "Gender") == 2) echo "Girl";
                        ?></td>
                    <td><?php echo odbc_result($Student, "Class"); ?></td>
                    <td><?php echo odbc_result($Student, "Section"); ?></td>
                    <td><?php echo odbc_result($Student, "Academic Year"); ?></td>
                    <td><?php
                            if(odbc_result($Student, "Student Status")== 0) echo "";
                            if(odbc_result($Student, "Student Status")== 1) echo "Active";
                            if(odbc_result($Student, "Student Status")== 2) echo "In-Active";
                            if(odbc_result($Student, "Student Status")== 3) echo "Alumni";
                        ?></td>
                </tr>
                <?php
                        $i += 1;
                    }
                ?>
                </tbody>
            </table>
        </div>

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

<?php require_once("../footer.php"); ?>