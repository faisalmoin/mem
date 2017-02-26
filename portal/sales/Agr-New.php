<?php
	require_once("header.php");
?>
<script>
	// Ajax for City & Country on PIN Code
	var ajax = getHTTPObject();

	function getHTTPObject()
	{
		var xmlhttp;
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else if (window.ActiveXObject) {
		// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		} else {
		//alert("Your browser does not support XMLHTTP!");
		}
		return xmlhttp;
	}
	
	//Communication Post Code
	function getClient()
	{
		if (ajax)
		{
			var OppNo = document.getElementById("OppNo").value;
			if(OppNo)
			{
				var url = "get_client.php";
				var param = "?OppNo=" + escape(OppNo);

				ajax.open("GET", url + param, true);
				ajax.onreadystatechange = handleAjax;
				ajax.send(null);
			}
		}
	}

	function handleAjax()
	{
		if (ajax.readyState == 4)
		{
			citystatearr = ajax.responseText.split(",");

			var MOUDt = document.getElementById('MOUDt');
			var Brand = document.getElementById('Brand');
			var City = document.getElementById('City');
			var State = document.getElementById('State');
			var Client = document.getElementById('Client');
			var CreatedBy = document.getElementById('CreatedBy');
			var AssignTo = document.getElementById('AssignTo');
			var LOIFile = document.getElementById('LOIFile');
			var MOUFile = document.getElementById('MOUFile');

			MOUDt.value = citystatearr[0];
			Client.value = citystatearr[1];
			City.value = citystatearr[2];
			State.value = citystatearr[3];
			Brand.value = citystatearr[4];
			CreatedBy.value = citystatearr[5];
			AssignTo.value = citystatearr[6];
			LOIFile.value = citystatearr[7];
			MOUFile.value = citystatearr[8];
		}
	}

	$(function() {
		$( "#MOUDt" ).datepicker({maxDate: 0});
				
		$( "#FromDt" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			//numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#ToDt" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#ToDt" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			//numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#FromDt" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});

	$(document).ready(function () {
		//called when key is pressed in textbox
		$("#Fee, #Royalty, #Duration").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) {
				//display error message
				$("#errmsg").html("Digits Only").show().fadeOut("slow");
				return false;
			}
		});
		$("input").prop('required',true);
		$("select").prop('required',true);
	});

</script>
<style>
	.table {
	    border-bottom:0px !important;
	}
	.table th, .table td {
	    border: 1px !important;
	}
	.fixed-table-container {
	    border:0px !important;
	}
</style>
<div class="container">
	<form action="Agr-Add.php" method="POST">
	<table class='table borderless' style="width:60%; background-color: #f4f6f6" align="center">
		<tr>
			<td colspan="4"><h1>Agreement New <hr  style="border-bottom:1px solid #abb2b9; " /></td>
		</tr>
		<tr>
			<td>Oppurtunity No</td>
			<td>
				<select name="OppNo" id="OppNo" class="form-control" onchange="getClient()">
					<option value=""></option>
					<?php
						$cnt = odbc_exec($conn, "SELECT [Opp No] FROM [CRM Oppurtunity] WHERE [Opp No] NOT IN (SELECT [Opp No] FROM [CRM Agreement]) AND [Level] = 'Agreement signed' ") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($cnt)){
							echo '<option value="'.odbc_result($cnt, "Opp No").'">'.odbc_result($cnt, "Opp No").'</option>';
						}
					?>
				</select>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>MOU signing Date</td>
			<td><input type="text" maxlength="11" name="MOUDt" id="MOUDt" class="form-control"></td>
			<td>Brand</td>
			<td><input type="text" maxlength="11" name="Brand" id="Brand" class="form-control" readonly></td>
		</tr>
		<tr>
			<td>Trust</td>
			<td colspan="3"><input type="text" maxlength="100" name="Trust" id="Trust" class="form-control"></td>
		</tr>
		<tr>
			<td>Client Name</td>
			<td colspan="3"><input type="text" maxlength="100" name="Client" id="Client" class="form-control"></td>
		</tr>
		<tr>
			<td>City</td>
			<td><input type="text" name="City" id="City" class="form-control" readonly></td>
			<td>State</td>
			<td><input type="text" name="State" id="State" class="form-control" readonly></td>
		</tr>
		<tr>
			<td>Effective Date</td>
			<td><input type="text" maxlength="11" name="FromDt" id="FromDt" class="form-control" ></td>
			<td>Duration</td>
			<td><input type="text" maxlength="3" name="Duration" id="Duration" class="form-control" ></td>			
		</tr>
		<tr>
			<td>Franchisee Fee</td>
			<td><input type="text" maxlength="11" name="Fee" id="Fee" class="form-control"></td>
			<td>Taxes on Franchisee Fee</td>
			<td>
				<select name="taxes" class="form-control">
					<option value=""></option>
					<option value="1">Exclusive</option>
					<option value="-1">Inclusive</option>
					<option value="0">NULL</option>
				</select>
			</td>
			
		</tr>
		
		<tr>
			<td>Royalty %</td>
			<td><input type="text" maxlength="3" name="Royalty" id="Royalty" class="form-control" ></td>
			<td>Taxes on Royalty %</td>
			<td>
				<select name="r_taxes" class="form-control">
					<option value=""></option>
					<option value="1">Exclusive</option>
					<option value="-1">Inclusive</option>
					<option value="0">NULL</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td><input type="submit" value="Add" class="btn btn-primary" style="border: 1px solid #fff;width:80px;"></td>
			<td colspan="3">
				<span id="errmsg" style="color: red;" ></span>
			</td>
		</tr>
		
	</table>
	</form>
</div>
<?php require_once("../footer.php"); ?>