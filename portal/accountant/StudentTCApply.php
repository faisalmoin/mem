<?php
	require_once("header.php");
	
	$id = $_GET['id'];
	
	$Student = odbc_exec($conn, "SELECT [No_],[Name], [Father_s Name], [Mother_s Name],[Gender],[Class Code],[Class], [Section], [Curriculum], 
					[Academic Year], [Date Of Birth], [User ID], [Date Joined], [Student Status], [User ID] FROM [Temp Student] WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$Bal = odbc_exec($conn, "SELECT SUM([Amount]) FROM schoolerp.dbo.[".$ms."\$Detailed Cust_ Ledg_ Entry] WHERE [Customer No_]='$id'");	
?>
<script type="text/javascript" charset="utf-8">
	$(function()
	{
		$("#datepicker1").datepicker({ changeMonth: true, minDate: -90, maxDate: 0});
		$("#datepicker2").datepicker({changeYear: true, changeMonth: true,maxDate: 0});
		$("#datepicker3").datepicker({ minDate: 0});
		$("#datepicker4").datepicker({changeMonth: true,maxDate: 0});
		$("#datepicker5").datepicker({changeMonth: true,maxDate: 0});
	});
</script>

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
<h2>TC Request Form </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->


<form name="form1" method="POST" action="StudentTCAdd.php" onkeypress="return event.keyCode != 13;">
	<table id="datatable" class="table table-responsive">
		<tr>
			<td>Student No</td>
			<td>
				<input type="text" name="StudentNo" value="<?php echo odbc_result($Student, "No_");?>" readonly="true" class="form-control">
				<input type="hidden" name="DateJoined" value="<?php echo odbc_result($Student, "Date Joined");?>" readonly="true" class="form-control">
				<input type="hidden" name="StudentStatus" value="<?php echo odbc_result($Student, "Student Status");?>" readonly="true" class="form-control">
			</td>
			<td>Current Outstanding</td>
			<td><input type="text" name="Outstanding" style="font-weight: bold; text-align: right; color: #990000;" readonly="true" value="<?php echo number_format(odbc_result($Bal, ""),'2','.',''); ?>" class="form-control" /></td>
		</tr>
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
			<td><input type="text" name="DateIssue" id="datepicker1" class="form-control" style="background-color: #ffff00;" required="true"></td>
			<td>Date of In-active</td>
			<td><input type="text" name="DateInactive" id="datepicker5" class="form-control" style="background-color: #ffff00;" required="true"></td>
		</tr>
		<tr>
			<td>Last Attend Date</td>
			<td><input type="text" name="DateLastClassAtnd" id="datepicker2" style="background-color: #ffff00;" class="form-control" required="true"></td>
			<td>Fee Cut-off Date</td>
			<td><input type="text" name="DateFeeCutoff" id="datepicker4" style="background-color: #ffff00;" class="form-control" required="true"></td>
		</tr>
		<tr>
			<td>Conduct</td>
			<td><input type="text" name="Conduct" id="datepicker2" style="background-color: #ffff00;" class="form-control" maxlength="80" required="true"></td>
			<td>Reason for Leaving</td>
			<td><input type="text" name="Reason" id="datepicker2" style="background-color: #ffff00;" class="form-control" maxlength="180" required="true"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>User ID</td>
			<td><input type="text" name="UserID" value="<?php echo odbc_result($Student, "User ID")?>" class="form-control" readonly="true"></td>
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
						//Check if exists...
						$TcCheck = odbc_exec($conn, "SELECT TOP 1 [Date of Issue] FROM [Temp Transfer Certificate] WHERE [Student No_]='".odbc_result($Student, "No_")."' AND [Company Name]='$ms' AND [TC Issued]=0  ") or die($odbc_errormsg());
						if(odbc_num_rows($TcCheck)==0){
							echo "<input type='submit' value='Submit' class='btn btn-primary' >";
						}
						else{
							echo "<p class='text-primary'>TC already applied on <b>".date('d/M/Y', strtotime(odbc_result($TcCheck, 'Date of Issue')))." </b> and pending for approval...</p>";
						}
					}					
				?>
			</td>
		</tr>
	</table>
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

<?php require_once("../footer.php");?>