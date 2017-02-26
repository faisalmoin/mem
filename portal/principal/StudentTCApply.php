<?php
	require_once("header.php");
	
	$id = $_GET['id'];
	
	$Student = odbc_exec($conn, "SELECT [No_],[Name], [Father_s Name], [Mother_s Name],[Gender],[Class Code],[Class], [Section], [Curriculum], 
					[Academic Year], [Date Of Birth], [User ID], [Date Joined], [Student Status] FROM [Temp Student] WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$Bal = odbc_exec($conn, "SELECT SUM([Amount]) FROM schoolerp.dbo.[".$ms."\$Detailed Cust_ Ledg_ Entry] WHERE [Customer No_]='$id'");	
	$StuTC = odbc_exec($conn, "SELECT TOP 1 [Date of Issue], [Fee Cut off date], [Last Attented Date], [Conduct], [Reason], [Date of Inactive], [TC No_], [TC Issued], [User ID] FROM [Temp Transfer Certificate] WHERE [Student No_]='".odbc_result($Student, "No_")."' AND [Company Name]='$ms' ORDER BY [TC No_] DESC") or die(odbc_errormsg($conn));
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
<h2>TC Request Form </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<form name="form1" method="POST" action="StudentTCAdd.php">

	<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
	<thead>
		<tr>
			<td>Student No</td>
			<td>
				<input type="text" name="StudentNo" value="<?php echo odbc_result($Student, "No_");?>" readonly="true" class="form-control">
				<input type="hidden" name="DateJoined" value="<?php echo odbc_result($Student, "Date Joined");?>" readonly="true" class="form-control">
				<input type="hidden" name="StudentStatus" value="<?php echo odbc_result($Student, "Student Status");?>" readonly="true" class="form-control">
				<input type="hidden" name="TCNo" value="<?php echo odbc_result($StuTC, "TC No_");?>" readonly="true" class="form-control">
			</td>
			<td>Current Outstanding</td>
			<td><input type="text" name="Outstanding" style="font-weight: bold; text-align: right; color: #990000;" readonly="true" value="<?php echo number_format(odbc_result($Bal, ""),'2','.',''); ?>" class="form-control" /></td>
		</tr>
	</thead>
		<tr>
			<td>Student Name</td>
			<td colspan="3"><input type="text" name="StudentName" style="font-weight: bold; color: navy;" value="<?php echo odbc_result($Student, "Name");?>" readonly="true" class="form-control"></td>
		</tr>
		<tr>
			<td>Father's Name</td>
			<td><input type="text" name="FatherName" value="<?php echo odbc_result($Student, "Father_s Name");?>" readonly="true" class="form-control"></td>
			<td>Mother's Name</td>
			<td><input type="text" name="MotherName" value="<?php echo odbc_result($Student, "Mother_s Name");?>" readonly="true" class="form-control"></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>
				<input type="hidden" name="Gender" value="<?php echo odbc_result($Student, "Gender");?>" readonly="true" class="form-control">
				<input type="text" value="<?php if(odbc_result($Student, "Gender")==1) echo "Boy"; if(odbc_result($Student, "Gender")==2) echo "Girl";?>" readonly="true" class="form-control">
			</td>
			<td>Date of Birth</td>
			<td>
				<input type="text" name="DOB" value="<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date Of Birth"))); ?>" readonly="true" class="form-control">
			</td>
		</tr>
		<tr>
			<td>Academic Year</td>
			<td><input type="text" name="AcadYear" value="<?php echo odbc_result($Student, "Academic Year");?>" readonly="true" class="form-control"></td>
			<td>Class Code</td>
			<td><input type="text" name="ClassCode" value="<?php echo odbc_result($Student, "Class Code");?>" readonly="true" class="form-control"></td>
		</tr>
		<tr>
			<td>Class</td>
			<td><input type="text" name="Class" value="<?php echo odbc_result($Student, "Class");?>" readonly="true" class="form-control"></td>
			<td>Section</td>
			<td><input type="text" name="Section" value="<?php echo odbc_result($Student, "Section");?>" readonly="true" class="form-control"></td>
		</tr>
		<tr>
			<td>Curriculum</td>
			<td><input type="text" name="Curriculum" value="<?php echo odbc_result($Student, "Curriculum");?>" readonly="true" class="form-control"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>Date of Issue</td>
			<td><input type="text" name="DateIssue" id="datepicker1" class="form-control" required="true" value="<?php echo date('d/M/Y', strtotime(odbc_result($StuTC, 'Date of Issue')));?>" readonly="true"></td>
			<td>Date of In-active</td>
			<td><input type="text" name="DateInactive" id="datepicker5" class="form-control" required="true" value="<?php echo date('d/M/Y', strtotime(odbc_result($StuTC, 'Date of Inactive')));?>" readonly="true"></td>
		</tr>
		<tr>
			<td>Last Attend Date</td>
			<td><input type="text" name="DateLastClassAtnd" id="datepicker2" class="form-control" required="true"  value="<?php echo date('d/M/Y', strtotime(odbc_result($StuTC, 'Last Attented Date')));?>" readonly="true"></td>
			<td>Fee Cut-off Date</td>
			<td><input type="text" name="DateFeeCutoff" id="datepicker4" class="form-control" required="true" value="<?php echo date('d/M/Y', strtotime(odbc_result($StuTC, 'Fee Cut off date')));?>" readonly="true"></td>
		</tr>
		<tr>
			<td>Conduct</td>
			<td><input type="text" name="Conduct" id="datepicker2" class="form-control" maxlength="80" required="true" value="<?php echo odbc_result($StuTC, 'Conduct')?>" readonly="true"></td>
			<td>Reason for Leaving</td>
			<td><input type="text" name="Reason" id="datepicker2" class="form-control" maxlength="180" required="true" value="<?php echo odbc_result($StuTC, 'Reason')?>" readonly="true"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>User ID</td>
			<td><input type="text" name="UserID" value="<?php echo odbc_result($StuTC, "User ID")?>" class="form-control" readonly="true"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="3">
				<?php 
					if(odbc_result($Bal, "") > 1) {
						echo "<p class='text-danger'>TC can only be issued only if <b>Fee Outstanding is less than or equals to Rs. 0.00</b> ( Rupees Zero) ...</p>";
					}
					else{
						if(odbc_result($StuTC, 'TC Issued')==0)
						{
							echo "<input type='submit' name='btn' value='Approve' class='btn btn-primary' > &nbsp;&nbsp;";
							echo "<input type='submit' name='btn' value='Reject' class='btn btn-warning' >";
						}
					}					
				?>
			</td>
		</tr>
	</table>
</div>


<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>


<script type="text/javascript" charset="utf-8">
	$(function()
	{
		$("#datepicker1").datepicker({ minDate: -5, maxDate: 0});
		$("#datepicker2").datepicker({changeYear: true, changeMonth: true});
		$("#datepicker3").datepicker({ minDate: 0});
		$("#datepicker4").datepicker({changeMonth: true,minDate: '-5'});
	});
</script>
<?php require_once("../footer.php");?>