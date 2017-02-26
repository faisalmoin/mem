<?php
	require_once("header.php");
	

	
	//$Student=mysql_query("SELECT b.`RegistrationNo`, b.`RegistrationFormNo`, b.`EnquiryNo`, a.`StudentName`, a.`Gender`, a.`FatherName`, a.`MotherName`, a.`DOB`, a.`Mobile`, a.`Email`, a.`ClassApplied`, a.`AcadYear`, b.`id`, b.`AdmissionNo` FROM `enquiry` a, `registration` b WHERE a.`SchoolERPCode`='$Comp[1]' ") or die(mysql_error());
	if($_GET['ePage']=="" || $_GET['ePage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$eCurr = $_GET['ePage'];
		$e_max=50*$eCurr;
		$e_min = ($e_max - 50);
	}
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
<?php
	if($_GET['eid']!="" && $_GET['Stu']!=""){
		echo "<div class='container'>
	                <div class='bs-example'>
	                    <div class='alert alert-success alert-error'>
	                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
	                        <strong>Success!</strong> Application No. <strong>".$_GET['eid']." (Student Name: ".$_GET['Stu'].")</strong> has been registered. You will get the status after few minutes.
	                    </div>
	                </div></div>";
	} ?>
<div class="x_panel">
<div class="x_title">
<h2>Selected Student List</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->	
	
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />

			
			<thead>
			<tr>
				<th>Application<br />No</th>
				<th>Registration<br />No</th>
				<!--<td>Enquiry No</td>-->
				<th>Candidate <br> Name</th>
				<th>Gender</th>
				<th>Father <br>Name</th>
				<th>Mother <br> Name</th>
				<th>Date of<br> Birth</th>
				<!--<td>Mobile</td>-->
				<th>Class</th>
				<th>Addmission <br> for Year</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
                //$SQL1 = "SELECT [No_],[Registration No_],[Enquiry No_],[Name],[Gender],[Father_s Name],[Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year] FROM [Temp Application] WHERE [Registration Status]=3 AND [Company Name]='$ms'";
                $SQL1 = "SELECT [No_],[Registration No_],[Enquiry No_],[Name],[Gender],[Father_s Name],[Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year]  FROM ( 
							SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Receive] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] = 3 AND [Allot Student]=0
							) a WHERE a.row > $e_min and a.row <= $e_max ";
                $SelSQL=odbc_exec($conn, $SQL1);
				while(odbc_fetch_array($SelSQL)){
			?>
			<tr >
                <td><?php echo odbc_result($SelSQL, "No_");?></td>
                <td><?php echo odbc_result($SelSQL, "Registration No_");?></td>
                <!--<td><?php //echo odbc_result($SelSQL, "Enquiry No_");?></td>-->
                <td><?php echo odbc_result($SelSQL, "Name");?></td>
                <td><?php
                    if(odbc_result($SelSQL, "Gender")==1) echo "Boy";
                    if(odbc_result($SelSQL, "Gender")==2) echo "Girl";
                    ?></td>
                <td><?php echo odbc_result($SelSQL, "Father_s Name");?></td>
                <td><?php echo odbc_result($SelSQL, "Mother_s Name");?></td>
                <td><?php echo date('d/M/Y', strtotime(odbc_result($SelSQL, "Date Of Birth")));?></td>
                <!--<td><?php //echo odbc_result($SelSQL, "Mobile Number");?></td>-->
                <td><?php echo odbc_result($SelSQL, "Class");?></td>
                <td><?php echo odbc_result($SelSQL, "Admission for Year");?></td>
				<td>
					<?php
						if($Stu[13] == ""){
					?>
					<a href="NewAdmission.php?id=<?php echo odbc_result($SelSQL, "Enquiry No_");?>" class="btn btn-primary">Admission</a>
					<?php
						}
						if($Stu[13] != ""){
						
					?>
					<a href="ListAdmission.php?id=<?php echo odbc_result($SelSQL, "Enquiry No_");?>" class="btn btn-primary">View</a>
					<?php 
						}
					?>
				</td>
			</tr>
			<?php
					$i += 1;
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

<?php
	require_once("../footer.php");
?>