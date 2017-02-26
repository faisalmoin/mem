<?php
	require_once("SetupLeft.php");
?>
  
   <?php for($a=1; $a<=5; $a++){ 
	$sd .= "#startDate$a, ";
	$ed .= "#endDate$a, ";
  }
	$sd = substr($sd, 0,-2);	
	$ed = substr($ed, 0,-2);	
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
<h2>Academic Year </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

  <script>
   
  $(function() {

    $( "<?php echo $sd?>").datepicker({
      changeMonth: true,
      changeYear: true
    });
  $( "<?php echo $ed?>").datepicker({
      changeMonth: true,
      changeYear: true
    });
  
  });
  </script>

<form action="AcademicYearEditAdd.php">
<table class="table table-responsive">
	
	
	<?php
			$i =1;
			$Acad = odbc_exec($conn, "SELECT * FROM [Academic Year] WHERE [ID]='{$_GET['AcademicYear']}' ORDER BY [End Date] DESC") or exit(odbc_errormsg($conn));
			while(odbc_fetch_array($Acad))
		?>
	<tr><td>S/N</td>
		<td><?php echo $i;?></td>
		</tr>
		<tr>
		<td>Academic Year</td>
		<td><?php echo odbc_result($Acad, "Code")?></td>
		</tr>
		<tr>
		<td>Start Date</td>
		<td>
			<input type="text" name="startDate" value="<?php echo date('d/M/Y', strtotime(odbc_result($Acad, "Start Date")))?>" id="startDate<?php echo $i?>"  class="form-control">
		</td>
		</tr>
		<tr>
		<td>End Date</td>
		<td>
			<input type="text" name="endDate" value="<?php echo date('d/M/Y', strtotime(odbc_result($Acad, "End Date")))?>" id="endDate<?php echo $i?>"  class="form-control">
		</td>
		</tr>
		<tr>
						
			<td colspan="2"><button class="btn btn-primary">Submit</button>
			</td>
		</tr>
	
</table>
<input type="hidden" value="<?php echo odbc_result($Acad, "ID");?>" name="id">
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
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("SetupRight.php");
?>