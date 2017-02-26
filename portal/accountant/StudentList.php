<?php
    require_once("header.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #FBF8EF}
</style>

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
<h2>School List </h2> <!-- Page Name -->
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

    
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#active" data-toggle="tab">Active</a></li>
        <li><a href="#inactive" data-toggle="tab">In-Active</a></li>
        <li><a href="#alumni" data-toggle="tab">Alumni</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content">
        
        <div class="tab-pane fade in active" id="active">
            <h3 class="text-primary">Active Student List</h3>
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
                <thead>
                <tr >
                    <th>SN</th>
                    <th>Admission<br>No.</th>
                    <th>Student<br>Name</th>
                    <th>Academic<br>Year</th>
                    <th>Class & Section</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Addresse</th>
                    <th>Contact<br>No</th>
                </tr>
                </thead>
                <?php
                    $i=1;
                    $stu2=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Date Of Birth], [Gender], [Addressee], [Mobile Number] FROM [Temp Student] WHERE [Student Status]=1 AND [Company Name]='$ms' ORDER BY [Academic Year], [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu2)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu2, "No_"); ?>"><?php echo odbc_result($stu2, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu2, "Name"); ?></td>
                    <td><?php echo odbc_result($stu2, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu2, "Class")." ".odbc_result($stu2, "Section"); ?></td>
                    <td><?php echo date('d/M/Y', strtotime(odbc_result($stu2, "Date Of Birth"))); ?></td>
                    <td><?php 
			if(odbc_result($stu2, "Gender")==1) echo "Boy"; 
			if(odbc_result($stu2, "Gender")==2) echo "Girl"; 
		    ?></td>
                    <td><?php echo odbc_result($stu2, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu2, "Mobile Number"); ?></td>		
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
        <div class="tab-pane fade in" id="inactive">
            <h3 class="text-primary">In-Active Student List</h3>
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Admission<br />No.</th>
                    <th>Student<br />Name</th>
                    <th>Academic<br />Year</th>
                    <th>Class & Section</th>
                    <th>Addresse</th>
                    <th>Contact<br />No</th>
                    <th>Effective<br />From</th>
                </tr>
                </thead>
                <?php
                    $i=1;
                    $stu3=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number],[Withdrwal Applied Date] FROM [Temp Student] WHERE [Student Status]=3 AND [Company Name]='$ms' ORDER BY [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu3)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu3, "No_"); ?>"><?php echo odbc_result($stu3, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu3, "Name"); ?></td>
                    <td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
                    <td><?php echo odbc_result($stu3, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu3, "Mobile Number"); ?></td>
                    <td><?php if(odbc_result($stu3, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($stu3, "Withdrwal Applied Date"))); ?></td>
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
        <div class="tab-pane fade in" id="alumni">
            <h3 class="text-primary">Alumni Student List</h3>
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Admission<br />No.</th>
                    <th>Student<br />Name</th>
                    <th>Academic<br />Year</th>
                    <th>Class & Section</th>
                    <th>Addresse</th>
                    <th>Contact<br />No</th>
                    <th>Effective<br />From</th>
                </tr>
                </thead>
                <?php
                    $i=1;
                    $stu=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number],[Withdrwal Applied Date] FROM [Temp Student] WHERE [Student Status]=2 AND [Company Name]='$ms' ORDER BY [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu, "No_"); ?>"><?php echo odbc_result($stu, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu, "Name"); ?></td>
                    <td><?php echo odbc_result($stu, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu, "Class")." ".odbc_result($stu, "Section"); ?></td>
                    <td><?php echo odbc_result($stu, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu, "Mobile Number"); ?></td>
                    <td><?php if(odbc_result($stu3, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($stu2, "Withdrwal Applied Date"))); ?></td>
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
    </div>
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

 
<?php require_once("../footer.php");?>