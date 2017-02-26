<?php
	require_once("SetupLeft.php");
?>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" class="form-control" name="Code[]" required /></td><td><input type="text" name="Description[]" class="form-control" required></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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
<li><a href="FeeTypeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<?php
		$rs = odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [ID]='{$_GET['FeeId']}' ORDER BY [Code]") or exit(odbc_errormsg($conn));
		while(odbc_fetch_array($rs))
		
	?>

<form action="FeeTypeEditAdd.php" method="post">
<table class="table table-responsive" id="customFields">
<tr style="font-weight: bold;">
		<th style="border: none;">Academic Year</th>
		<td style="border: none;">
			
			<?php $mssql1="SELECT DISTINCT([Academic Year]) FROM [Class Section] WHERE [Company Name]='$CompName' ORDER BY [Academic Year]";
				$msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
				?>
				<select name="Academic" class="form-control" required>
				<option value="<?php echo odbc_result($rs, "Academic Year");?>"></option>
				<?php while(odbc_fetch_array($msAY)){
		         echo "<option value='".odbc_result($msAY, "Academic Year")."'";
		         if(odbc_result($msAY, "Academic Year") == odbc_result($rs, "Academic Year") ){echo " selected";}
		         echo ">".odbc_result($msAY, "Academic Year")."</option>";
				 }?>
				</select>
			</td></tr>
		
	</tr>
	<tr style="font-weight: bold;">
		
		<td>Fee Code</td>
		<td>Fee Description</td>
		<td>Start Date</td>
		<td>End Date</td>
		
	</tr>
	<tr>
		
		<td><input type="text" name="Code" value="<?php echo odbc_result($rs, "Code"); ?>" class="form-control" maxlength="20" required></td>
		<td><input type="text" name="Description" value="<?php echo odbc_result($rs, "Description"); ?>" class="form-control" maxlength="30" required></td>
		<td>
			<input type="text" name="startDate" value="<?php echo date('d/M/Y',odbc_result($rs, "Start Date"));?>" class="datepicker form-control" required>
		</td>
		<td>
			<input type="text" name="endDate" value="<?php echo date('d/M/Y',odbc_result($rs, "End Date"));?>" class="datepicker form-control" required>
		</td>
		
	</tr>
</table>
<input type="hidden" value="<?php echo odbc_result($rs,"ID");?>" name="id">
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


<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
<script>
   
  $(function() {


 $( ".datepicker" ).datepicker({  changeMonth: true,
      changeYear: true });
  $( ".datepicker1" ).datepicker({  changeMonth: true,
      changeYear: true });


  });
</script>
<?php
	require_once("SetupRight.php");
?>