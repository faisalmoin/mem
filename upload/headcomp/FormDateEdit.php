<?php
    require_once("SetupLeft.php");
	$Company = odbc_exec($conn, "SELECT * FROM [RegFormToDate] WHERE [Company Name]= '$CompName' ") or exit(odbc_errormsg($conn));
	while(odbc_fetch_array($Company))
?>
  
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
<?php require_once("SetupLeft.php"); ?> 
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

<?php require_once("SetupRight.php");?>