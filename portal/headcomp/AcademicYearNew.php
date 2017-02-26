<?php
	require_once("SetupLeft.php");

 for($a=1; $a<=5; $a++){ 
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

<form action="AcademicYearAdd.php">
<table class="table table-responsive">
	<tr>
		<td>S/N</td>
		<td align="center">Academic Year</td>
		<td>Start Date</td>
		<td>End Date</td>
		<td align="center">Create Year</td>
	</tr>
	<?php
		$j=0;
		for($i=1; $i<=5; $i++){
			
	?>
	<tr>
		<td align="center"><?php echo $i;?></td>
		<td align="center"><?php echo (date('y')+$j)."-".(date('y')+$i);?>
			<input type="hidden" name="Code<?php echo $i?>" value="<?php echo (date('y')+$j)."-".(date('y')+$i);?>" >
		</td>
		<td>
			<input type="text" name="startDate<?php echo $i?>" value="01/Apr/<?php echo (date('Y')+$j)?>" id="startDate<?php echo $i?>"  class="form-control">
		</td>
		<td>
			<input type="text" name="endDate<?php echo $i?>" value="31/Mar/<?php echo (date('Y')+$i)?>" id="endDate<?php echo $i?>"  class="form-control">
		</td>
		<td align="center">
			<input type="checkbox" name="insert<?php echo $i?>" checked value="1" >
		</td>
	</tr>
	<?php
			$j++;
		}
	?>
	<tr>
		<td colspan="2"><button class="btn btn-primary">Submit</button>
		</td>
	</tr>
	
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
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
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

<?php
	require_once("SetupRight.php");
?>