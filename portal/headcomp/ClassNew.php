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
<h2>Class & Section Setup </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="ClassAdd.php" method="post">
	<table class="table table-stripped" id="datatable" style="width:60%">
		<tr>
			<td>Curriculum</td>
			<td>
				<select name="Curriculum" required class="form-control">
					<option value=""></option>
					<?php
						$Curr = odbc_exec($conn, "SELECT [Code] FROM [curriculum] WHERE [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
						while(odbc_fetch_array($Curr)){
							echo "<option value='".odbc_result($Curr, "Code")."'>".odbc_result($Curr, "Code")."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Academic Year</td>
			<td>
				<select name="AcadYear" required class="form-control">
					<option value=""></option>
					<?php
						$Acad = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
						while(odbc_fetch_array($Acad)){
							echo "<option value='".odbc_result($Acad, "Code")."'>".odbc_result($Acad, "Code")."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Max <b>Class</b> in Academic Year</td>
			<td>
				<select name="Class" required class="form-control">
					<option value=""></option>
					<?php
						for($cl=1; $cl<16;$cl++){
							echo "<option value='$cl'>";
							if($cl==1) echo "Pre Nursery</option>";
							if($cl==2) echo "Nursery</option>";
							if($cl==3) echo "KG</option>";
							if($cl==4) echo "Class I</option>";
							if($cl==5) echo "Class II</option>";
							if($cl==6) echo "Class III</option>";
							if($cl==7) echo "Class IV</option>";
							if($cl==8) echo "Class V</option>";
							if($cl==9) echo "Class VI</option>";
							if($cl==10) echo "Class VII</option>";
							if($cl==11) echo "Class VIII</option>";
							if($cl==12) echo "Class IX</option>";
							if($cl==13) echo "Class X</option>";
							if($cl==14) echo "Class XI</option>";
							if($cl==15) echo "Class XII</option>";
						}
					?>
				</select>
			</td>
		<tr>
		<tr>
			<td>Max <b>Section</b> of a Class (numbers only)</td>
			<td>
				<input type="text" maxlength="3" name="Sec" style="text-align: right;" value="1" onclick="this.value=''" onblur="if(this.value == '' ){this.value='1';}" onkeypress='return validateQty(event);' class="form-control" />
			</td>
		<tr>
		<tr>
			<td>Max <b>Capacity</b> of a section (numbers only)</td>
			<td>
				<input type="text" maxlength="3" name="Capacity" style="text-align: right;" value="1" onclick="this.value=''" onblur="if(this.value == ''){this.value='1';}"  onkeypress='return validateQty(event);' class="form-control" />
			</td>
		<tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="btn btn-primary" value="Submit" />
			</td>
		<tr>
	</table>
	</form>

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
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<!-- /Datatables -->
<script>
	function validateQty(event) {
	var key = window.event ? event.keyCode : event.which;

	if (event.keyCode == 8 || event.keyCode == 46
	|| event.keyCode == 37 || event.keyCode == 39) {
		return true;
	}
	else if ( key < 48 || key > 57 ) {
		return false;
	}
	else return true;
	};

</script>
<?php
	require_once("SetupRight.php");
?>