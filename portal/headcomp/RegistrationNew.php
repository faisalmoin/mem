<?php require_once("SetupLeft.php"); ?>

<script>
	$(function() {
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			//numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			//numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
</script>


<h1 class="text-primary">Registration</h1>
<form action="RegistrationAdd.php" method="post">
<table class="table table-responsive">
	<tr>
		<td>Academic Year</td>
		<td>
			<select name="AcadYr" class="form-control" required>
				<option value=""></option>
				<?php
					$Acad = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Company Name]='$CompName' AND
						[Code] NOT IN (SELECT [Admission Year] FROM [Admission Setup] WHERE [Company Name]='$CompName')");
					while(odbc_fetch_array($Acad)){
						echo "<option value='".odbc_result($Acad, 'Code')."'>".odbc_result($Acad, 'Code')."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Registration Start Date</td>
		<td>
			<input type="text" class="form-control" id="from" name="StartDt" />
		</td>
	</tr>
	<tr>
		<td>Registration End Date</td>
		<td>
			<input type="text" class="form-control" id="to" name="EndDt" />
		</td>
	</tr>
	<tr>
		<td>Registration Fee Code</td>
		<td>
			<select name="Fee" class="form-control" required>
				<option value=""></option>
				<?php
					$Fee = odbc_exec($conn, "SELECT [Code], [Description] FROM [Fee Components] WHERE [Company Name]='$CompName' ");
					while(odbc_fetch_array($Fee)){
						echo "<option value='".odbc_result($Fee, 'Code')."'>".odbc_result($Fee, 'Description')."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn btn-primary">Submit</button>
		</td>
	</tr>
</table>
</form>
<?php require_once("SetupRight.php"); ?>