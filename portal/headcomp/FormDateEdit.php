<?php
    require_once("SetupLeft.php");
	$Company = odbc_exec($conn, "SELECT * FROM [RegFormToDate] WHERE [Company Name]= '$CompName' ") or exit(odbc_errormsg($conn));
	while(odbc_fetch_array($Company))
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
<h2>Online Registration From </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">


<h1 class="text-primary">Edit Registration From Validity </h1>
<form action="FormDateEditAdd.php">
<table class="table table-responsive">
<tr>
  <td>Start Date</td>
  <td>End Date</td>
</tr>
<tr>
	<td>
	<input type="text" name="startDate" value="<?php echo date('d/M/Y', odbc_result($Company, "Start Date"));?>" id="date1" class="form-control" required>
	</td>
	<td> 
	<input type="text" name="endDate" value="<?php echo date('d/M/Y', odbc_result($Company, "End Date"));?>" id="dt1" class="form-control" required>
	</td>
</tr>
<tr>
	<td colspan="2"><button class="btn btn-primary">Submit</button></td>
</tr>
</table>
 <input type="hidden" value="<?php echo odbc_result($Company, "ID");?>" name="id">
</form>
<!--?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?-->


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


<script>
$(function() {

	  $("#date1").datepicker({ minDate: 0,});
		$("#dt1").datepicker({ 
			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
			minDate:0,
			//maxDate: 0, 
			changeMonth: true, 
			changeYear: true
		});
  
  });
  </script>

<?php require_once("SetupRight.php");?>