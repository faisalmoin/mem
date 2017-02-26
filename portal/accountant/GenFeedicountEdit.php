<?php
    require_once 'header.php';
    $id = $_REQUEST['invoice'];
    if($_REQUEST['msg'] != ""){
        if($_REQUEST['msg']==1){
            echo "<div class='container'><div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Error!</strong> There is some error, kindly check.<br />".odbc_errormsg($conn)."
                        </div>
                </div></div>";
        }
        if($_REQUEST['msg']==0){
            echo "<div class='container'><div class='bs-example'>
                            <div class='alert alert-success alert-error'>
                                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                    <strong>Success!</strong> Student card updated successfully.
                            </div>
                    </div></div>";
        }
        if($_REQUEST['msg']==2){
            echo("<div class='container'><div class='bs-example'>
                <div class='alert alert-danger alert-error'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Error!</strong> Class Section code not defined for Academic Year: ".odbc_result($row, "Academic Year").", Class: ".  odbc_result($row, "Class")." Section: ".odbc_result($row, "Section").". Kindly contact your administrator ...<br />".odbc_errormsg($conn)."
                </div>
            </div></div>");
        }
        if($_REQUEST['msg']==3){
            echo("<div class='container'><div class='bs-example'>
                <div class='alert alert-danger alert-error'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Error!</strong> Approver ID un-defined. Contact your ERP Administrator ...
                </div>
            </div></div>");
        }
    }
    $row = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));
    $cust = odbc_exec($conn, "SELECT * FROM [Temp Customer] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));
    
    $StuDOB = date("Y-m-d", strtotime(str_replace("-", "/", odbc_result($row, "Date Of Birth"))));
    $today = date("Y-m-d");


    $diff = abs(strtotime($today) - strtotime($StuDOB));

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    
?>

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
<h2>Student Card </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->


<form name="form" action='GenAdmissiondiscountEdit.php' method='Post' onkeypress="return event.keyCode != 13;">
    <input type="hidden" value="<?php echo $id; ?>" name="id">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">General</a></li>
            <li><a data-toggle="tab" href="#tab7">Fee</a></li>
            <li><a data-toggle="tab" href="#tab8">Discount</a></li>
            <li><a data-toggle="tab" href="#tab9">Transport</a></li>
            <!--li><a data-toggle="tab" href="#tab10">Ledger Summary</a></li-->
        </ul>

        <div class="tab-content">
            <!-- General -->
            <div id="tab1" class="tab-pane fade in active">
                <?php require_once("RevStudentCard.php"); ?>
            </div>        

            <div id="tab7" class="tab-pane fade">

             <?php require_once("GenAdmFeesEdit.php"); ?>
           </div>
            <div id="tab8" class="tab-pane fade">
                <?php require_once("GenAdmDiscEdit.php"); ?>
            </div>
            <div id="tab9" class="tab-pane fade">
                <?php require_once("GenTransportEdit.php"); ?>
            </div>

        </div>  

<p style="border-top: 1px solid #d2d2d2; padding: 10px;text-align: right;">
<input type="button" value="Cancel" class="btn btn-warning" onclick="javascript:window.history.go(-1);">

<input type="submit" value="Apply Changes" class="btn btn-success">

</p>
</form>


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


<?php require_once '../footer.php';?>




