<?php
	require_once("header.php");
	$_SESSION['token'] = md5(session_id() . time()); 
	$err=$_REQUEST['err'];
	$ClassApplied=$_REQUEST['ClassApplied'];
	$ApplicationNo=$_REQUEST['ApplicationNo'];
	$RegistrationNo=$_REQUEST['RegistrationNo'];
    $StuName = $_REQUEST['StuName'];

    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE UPPER([Class])=UPPER('$ClassApplied') AND UPPER([Name]) LIKE UPPER('%$StuName%') OR (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([Name]) LIKE UPPER('%$StuName%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND (UPPER([Name]) LIKE UPPER('%$StuName%') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND UPPER([Name]) LIKE UPPER('%$StuName%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE  [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo != "" && $RegistrationNo != "" && $StuName != ""){
        $where=" WHERE UPPER([Class])=UPPER('$ClassApplied') AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%') AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') AND UPPER([Name]) LIKE UPPER('%$StuName%') AND [Registration Status] = 2";
    }

    $SQL = "SELECT [No_], [Registration No_], [Enquiry No_], [Name], [Gender], [Father_s Name], [Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year] FROM [Temp Application] ".$where."AND [Company Name]='$ms'";;
    //echo $SQL;
    $result=odbc_exec($conn, $SQL);

    if($err != ""){
        if(odbc_num_rows($result) == 0){
            $msg="<div class='alert alert-danger alert-error'>
    				<a href='#' class='close' data-dismiss='alert'>&times;</a>
    				<strong>Error!</strong> No candidate was found ...
    			</div>";
        }
    }
    /*else{
        $msg="<div class='alert alert-success alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Success!</strong> Selected student(s) has been selected for admission.
			</div>";
    }*/

	if($err == "0"){
		$msg="<div class='alert alert-danger alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Error!</strong> There is some error, kindly check.
			</div>";
	}
	if($err == "1"){
		$msg="<div class='alert alert-success alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Success!</strong> Selected student(s) has been selected for admission.
			</div>";
	}
    if($err == "2"){
        $msg="<div class='alert alert-danger alert-error'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Error!</strong> Kindly select atleast 1 (One) candidate ...
                </div>";
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
<h1>Selection Process</h1>
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel collapsed">
<div class="x_title">
<h2>Find Candidate</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

    
    <?php echo ($msg != "")?$msg:""; ?>
	    <form name="form1">
            
            <table class="table table-bordered">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                <tr style="font-weight: bold;">
                    <td colspan="5">Get Applicant</td>
                </tr>
                <tr>
                    <th height="40px">Class</th>
                    <th height="40px">Application No</th>
                    <th height="40px">Registration No</th>
                    <th height="40px">Applicant Name</th>
                    <th height="40px" rowspan="2" valign="middle"><input type="submit" class="btn btn-primary" value="Submit" /></th>
                </tr>
                 <tr>
                    <td height="40px">
                        <select name="ClassApplied" id="class" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" >
                            <option value=""></option>
                            <?php
                                $AppClass = odbc_exec($conn, "SELECT DISTINCT([Class]) FROM [Temp Application] WHERE [Company Name]='$ms' ORDER BY [Class]");
                                while(odbc_fetch_array($AppClass)){
                                     echo "<option value='".odbc_result($AppClass, 'Class')."'>".odbc_result($AppClass, 'Class')."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td height="40px"><input type="text" id="application" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="ApplicationNo" /></td>
                    <td height="40px"><input type="text" id="registration" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="RegistrationNo" /></td>
                    <td height="40px"><input type="text" id="applicant" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="StuName" /></td>
                </tr>
            </table>
            </form>		


</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Candidate List</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

 
<form name="form2" method="POST" action="UpdateSelection.php" onkeypress="return event.keyCode != 13;">
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
			<thead>
			<tr>
				<th>Application<br />No</th>
				<th>Registration<br />No</th>
				<th>Candidate<br />Name</th>
				<th>Gender</th>
				<th>Father<br />Name</th>
				<th>Mother<br />Name</th>
				<th>Date of<br />Birth</th>
				<th>Class</th>
				<th>Addmission<br />for Year</td>
				<th>Select</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
                $SelSQL=odbc_exec($conn, $SQL);
				while(odbc_fetch_array($SelSQL)){
			?>
			<tr>
				<td><?php echo odbc_result($SelSQL, "No_");?></td>
				<td><?php echo odbc_result($SelSQL, "Registration No_");?></td>
				<td><b><?php echo strtoupper(odbc_result($SelSQL, "Name"));?></b></td>
				<td><?php
                        if(odbc_result($SelSQL, "Gender")==1) echo "Boy";
                        if(odbc_result($SelSQL, "Gender")==2) echo "Girl";
                    ?></td>
				<td><?php echo odbc_result($SelSQL, "Father_s Name");?></td>
				<td><?php echo odbc_result($SelSQL, "Mother_s Name");?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($SelSQL, "Date Of Birth")));?></td>
				<td><?php echo odbc_result($SelSQL, "Class");?></td>
				<td><?php echo odbc_result($SelSQL, "Admission for Year");?></td>
				<td><input type="checkbox" id="checkme" class="checkme" style="padding: 4px" name="id<?=$i?>" value="<?php echo odbc_result($SelSQL, "Enquiry No_");?>" /></td>
			</tr>
			<?php
					$i += 1;
				}
			?>
			</tbody>
		</table>
        <input type="hidden" name="Count" value= "<?=$i?>" />
            <p align="right">
                <input type="submit" class="btn btn-primary" id="submit" disabled value="Update Status"  />
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

<script>
    $(document).ready(function() {
        $('.collapsed').css('height', 'auto');
        $('.collapsed').find('.x_content').css('display', 'none');
        $('.collapsed').find('i').toggleClass('fa-chevron-up fa-chevron-down');
  
        $('#datatable').dataTable();
        $('#datatable-responsive').DataTable({
            fixedHeader: true
        });
    
        var availableTags = [ <?php
                $City_Tag=odbc_exec($conn, "SELECT [No_], [Name], [Enquiry No_], [Registration No_] FROM [Temp Application] WHERE [Registration Status] = 2 AND [Company Name]='$ms'");
                while(odbc_fetch_array($City_Tag)){
                    echo "'". odbc_result($City_Tag, "No_")."', '". odbc_result($City_Tag, "Name")."', '".odbc_result($City_Tag, "Enquiry No_")."', '". odbc_result($City_Tag, "Registration No_")."', ";
                }
            ?> ];

        $( "#application, #registration, #applicant" ).autocomplete({
            source: availableTags
        });

        var checkboxes = $("input[class='checkme']"),
            submitButt = $("input[id='submit']");
            checkboxes.click(function() {
            submitButt.attr("disabled", !checkboxes.is(":checked"));
        });
    });

  
</script>
 
<?php require_once("../footer.php");?>
