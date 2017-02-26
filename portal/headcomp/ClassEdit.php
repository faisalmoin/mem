
<?php
require_once("SetupLeft.php");
?>

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
			$Class = odbc_exec($conn, "SELECT * FROM [Class Section] WHERE [ID]='{$_GET['SectionID']}'") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($Class))
		?>
		
	
	<form action="ClassEditAdd.php" method="post">
	<table class="table table-responsive" style="width:60%">
		
		<tr>
			<th>Academic Year</th>
			
			<td>
				<input type="text" value="<?php echo odbc_result($Class, "Academic Year")?>" name="Academic" class="form-control" readonly />
			</td>
			
		</tr>
		<tr>
			<th>Class</th>
			<td>
				<input type="text" value="<?php echo odbc_result($Class, "Class")?>" name="Class" class="form-control" readonly/>
			</td>
			
		</tr>
		
		
		<tr>
			<th>Section</th>
			<td>
				<input type="text" maxlength="3" name="Section" value="<?php echo odbc_result($Class, "Section")?>" class="form-control" readonly />
			</td>
		<tr>
		
		
		<tr>
			<th>Curriculum</th>
			<td>
				<input type="text" value="<?php echo odbc_result($Class, "Curriculum")?>" name="Curriculum" class="form-control" readonly/>
			</td>
			
		</tr>
		<tr>
			<td>Max <b>Capacity</b> of a section (numbers only)</td>
			<td>
				<input type="text"  name="Capacity" value="<?php echo round(odbc_result($Class, "Capacity"))?>" class="form-control" />
			</td>
			
		</tr>
		
		
		<tr>
			<td></td>
			<td>
			<input type="hidden" value="<?php echo odbc_result($Class, "ID");?>" name="id">
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

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
<?php
	require_once("SetupRight.php");
?>