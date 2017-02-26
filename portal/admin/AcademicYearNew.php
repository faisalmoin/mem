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

<h1 class="text-primary">Academic Year</h1>
<form action="AcademicYearAdd.php">
<table class="table table-responsive">
	<tr>
		<td colspan="2">Select company</td>
		<td colspan="2">
			<select name="Company" class="form-control">
				<option value="*">All Companies</option>
			<?php
				$Comp = odbc_exec($conn, "SELECT [ID], [School Name] FROM [Company Information] WHERE [Company Status]=1 ORDER BY [School Name]") or exit(odbc_errormsg($conn));
				while(odbc_fetch_array($Comp)){
					echo "<option value='".odbc_result($Comp, "ID")."'>".odbc_result($Comp, "School Name")."</option>";
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>S/N</td>
		<td align="center">Academic Year</td>
		<td>Start Date</td>
		<td>End Date</td>
		<td align="center">Insert</td>
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
<?php
	require_once("SetupRight.php");
?>