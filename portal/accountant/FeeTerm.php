<?php require_once("header.php");
    $CompName = $ms;
	
	$today = strtotime(date('d M Y'));

    $Acad = odbc_exec($conn, "SELECT * FROM [Academic Year] WHERE [Company Name]='$CompName' ORDER BY [End Date] DESC") or exit(odbc_errormsg($conn));

	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	} else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
        $FinYr = (date('y', $today)-1)."-".date('y', $today);
    }

	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
		$Qtr = "Q1";
	}
	//Q2 Calculation
	if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
		$Qtr = "Q2";
	}
	//Q3 Calculation
	if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
		$Qtr = "Q3";
	}
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
		$Qtr = "Q4";
	}

	$headcmp = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
	
	?>



<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- /Datatable -->

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
<h2>Term Fee</h2>

<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeTypeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->
<form action="qut.php" method="POST">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">        
        <thead>
            <tr>
                <th style="border: none">SN.</th>
                <th style="border: none">Fee Type</th>
                <th style="border: none">Description</th>
                <th style="border: none">Start Date</th>
                <th style="border: none">End Date</th>
                <th style="border: none">No Of Student</th>
                <th style="border: none">Status</th>
                <th style="border: none">Total Amount</th>
                <th style="border: none"></th>
            </tr>
       </thead>
       <tbody>
        <?php 
        $i=1;
         $FeeCode=odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [Academic Year]='$FinYr' AND [Company Name]='$ms' ");
         
        while(odbc_fetch_array($FeeCode)){
        ?>
              
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo odbc_result($FeeCode, 'Code');?></td>
                <td><?php echo odbc_result($FeeCode, 'Description');?></td>
                <td><?php echo date('d/M/Y',odbc_result($FeeCode, 'Start Date'));?></td>
                <td><?php echo date('d/M/Y',odbc_result($FeeCode, 'End Date'));?></td>
                <?php  $NoStudent=odbc_exec($conn, "SELECT count([ID]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [FinYr]='$FinYr' AND [Description]= '".odbc_result($FeeCode, 'Code')."' "); 
               
                ?>
                <td><?php echo odbc_result($NoStudent, '') ?></td>
                   <?php  $gen=odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [FinYr]='$FinYr' AND [Description]= '".odbc_result($FeeCode, 'Code')."' ");
                      if(odbc_num_rows($gen)==0){ 
                    ?>
                <td></td>
                <?php }else{?>
                <td>Generated</td>
                 <?php }
                  $Amount=odbc_exec($conn, "SELECT sum([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [FinYr]='$FinYr' AND [Reverse]=0 AND [Description]= '".odbc_result($FeeCode, 'Code')."' "); ?>
                <td><?php echo number_format(odbc_result($Amount, ""),2,'.','') ?></td>
                <!--?php if(odbc_num_rows($gen)==0){ ?-->
                <td><input type="radio" name="FeeType" required="true" value="<?php echo odbc_result($FeeCode, 'Code') ?>"></td>
                <!--?php }else{ ?>
                <td></td>
                <!--?php } ?-->
                        </tr>
            <?php
                        $i++;
                    }
                ?>
           </tbody>
    </table>
    <input type="submit" value="Submit" class="btn btn-primary">
<!--
   <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
        <form action="qut.php" method="POST">
            <tr>
                <td style="border: none;text-align: right;">Select Term Fee</td>
                <td style="border: none">
                    <select class="form-control" name="FeeType" id="section" required>
                        <option value=""></option>
                        <?php
                            $FeeCode=odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Fee Type] WHERE [Company Name]='$ms' AND [Code] NOT IN (SELECT DISTINCT([Description]) FROM [Ledger Credit] WHERE [FinYr]='$FinYr' AND [Company Name]='$ms') ");
                            while(odbc_fetch_array($FeeCode)){
                                echo "<option value='".odbc_result($FeeCode, 'Code')."'";
                                echo ">".odbc_result($FeeCode, 'Code')."</option>";
                            }
                        ?>
                    </select>
                </td>
                <td style="border: none">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </td>
            </tr>
    </table-->


    <table class="table table-responsive" hidden="true">
        <thead>
            <tr>
                <th>SN</th>
                <th>Cust. No.</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Academic Year</th>
                <th>Class</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $i = 1;
            $query = "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND 
            [Student Status]=1 AND [EWS]=0  ";

            $rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
            while(odbc_fetch_array($rs)){
        ?>
        <tr>
            <td><?php echo $i?></td>
            <td><?php echo odbc_result($rs, "System Genrated No_");?></td>
            <td><?php echo odbc_result($rs, "Name");?></td>
            <td><?php 
                if(odbc_result($rs, "Gender")==1) echo "Boy";
                if(odbc_result($rs, "Gender")==2) echo "Girl";
        ?></td>
            <td><?php echo odbc_result($rs, "Academic Year");?></td>
            <td><?php echo odbc_result($rs, "Class");?></td>
            <td>
                <input type="checkbox" name="fee<?php echo $i?>" value="1" checked />
                <input type="hidden" name="registration<?php echo $i?>" value="<?php echo odbc_result($rs, "Registration No_");?>" />
                <input type="hidden" name="Class<?php echo $i?>" value="<?php echo odbc_result($rs, "Class");?>" />
            </td>
        </tr>
    <?php 
    $i++;
    }
    //}

    ?>
    </tbody>
    </table>
    <tr><td>
    <input type="hidden" name="Academic" value="<?php echo odbc_result($rs, "Academic Year");?>" />
    <input type="hidden" value="<?php echo $i;?>" name="fee_count">           
    </td> </tr>
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

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
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


<?php require_once("../footer.php"); ?>