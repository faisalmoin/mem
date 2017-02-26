<?php
	require_once("SetupLeft.php");
	 for($a=1; $a<=5; $a++){ 
	$sd .= "#startDate$a, ";
	$ed .= "#endDate$a, ";
  }
	$sd = substr($sd, 0,-2);	
	$ed = substr($ed, 0,-2);	
?>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" class="form-control" name="Code[]" required /></td><td><input type="text" name="Description[]" class="form-control" required></td><td><input type="text" name="startDate[]" class="datepicker_recurring_start form-control" required></td><td><input type="text" name="endDate[]" class="datepicker_recurring_start form-control" required></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		document.getElementById("count").value=cnt;
		cnt++;
	});
    $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
	document.getElementById("count").value=cnt;
	cnt--;
    });
    
});
}//]]> 

</script>


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
<h2>Fee Type </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeTypeAdd.php" method="post">
<table class="table table-responsive" id="customFields">
<tr>
<th style="border: none;">Academic Year</th>
<td style="border: none;">
				<select name="AcadYear" class="form-control" required>
					<option value=""></option>
                                        
					<?php						
						$ay = odbc_exec($conn, "SELECT DISTINCT([Academic Year]) FROM [Class Section] WHERE [Company Name]='$CompName' ORDER BY [Academic Year]");
						while(odbc_fetch_array($ay)){
							echo "<option value='".odbc_result($ay, 'Academic Year')."'>".odbc_result($ay, 'Academic Year')."</option>";
						}
					?>
				</select>
			</td></tr>
	<tr style="font-weight: bold;">
		<td>SN</td>
		<td>Fee Type</td>
		<td>Fee Description</td>
		<td>Start Date</td>
		<td>End Date</td>
		<td></td>
	</tr>
	<tr>
		<td>1</td>
		<td><input type="text" name="Code[]" class="form-control" maxlength="20" required></td>
		<td><input type="text" name="Description[]" class="form-control" maxlength="30" required></td>
	
		<td>
			<input type="text" name="startDate[]" class="datepicker_recurring_start form-control" required>
		</td>
		<td>
			<input type="text" name="endDate[]" class="datepicker_recurring_start form-control" required>
		</td>
		
		<td><a href="javascript:void(0);" class="addCF">Add More</a></td>
	</tr>
</table>
<input type="hidden" value="1" name="count" id="count" />
<button type="submit" class="btn btn-success">Submit</button>
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>


<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>


<script type='text/javascript'>//<![CDATA[
$(window).load(function(){

$('body').on('focus',".datepicker_recurring_start", function(){
    $(this).datepicker({ changeMonth: true,
      changeYear: true });
});
});//]]> 

</script>
<?php
	require_once("SetupRight.php");
?>