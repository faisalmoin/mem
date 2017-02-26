<?php
	require_once("header.php");
	$id = $_REQUEST['id'];
	
	$rs = odbc_exec($conn, "SELECT * FROM [CRM Lead] WHERE [Lead No]='$id'") or die(odbc_errormsg($conn));
?>
<script src='plugins/customselect.js'></script>
<link href='plugins/customselect.css' rel='stylesheet' />

<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$("input#LeadDT").datepicker({
    maxDate: 0  
});
});
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
    function updateCityState()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode").value;
                    if(zipValue)
                    {
                            var url = "get_city_state.php";
                            var param = "?zip=" + escape(zipValue);

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

                    var city = document.getElementById('city');
                    var state = document.getElementById('state');
                    var country = document.getElementById('country');

                    city.value = citystatearr[0];
                    state.value = citystatearr[1];
                    country.value = citystatearr[2];
            }
    }

$(function() {
        //$("#state").customselect();
});


//]]> 
</script>

<div class="container">
	<form method="POST" action="Lead-Update.php">
	<input type="hidden" value="<?php echo $id?>" name="id">
	<table class="table table-responsive table-stripped" style="width: 75%; margin-left:15%; margin-right:15%;">
		<tr style=" background-color: #ffffff;">
			<td colspan="6" style="border-top:none; border-bottom: 1px solid #d3d3d3;"><h3 class="text-primary">Edit Lead</h3></td>
		</tr>
		<tr>
			<td style="border:none;">Date <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>
			<td style="border:none;">
					<input type="text" class="form-control" name="LeadDT"  value="<?php echo date('d/M/Y', odbc_result($rs, "Lead Date"));?>" readonly required>
			</td>
			<td style="border:none;">Status <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>
			<td style="border:none;">
				<select name="Status" class="form-control" required >
					<option value=""></option>
					<option value="Open" <?php echo (odbc_result($rs, "Status")==="Open")? " selected":"";?>>Open</option>
					<option value="Qualify" <?php echo (odbc_result($rs, "Status")==="Qualify")? " selected":"";?>>Qualified</option>
					<option value="Dis-qualify" <?php echo (odbc_result($rs, "Status")==="Dis-qualify")? " selected":"";?>>Dis-qualified</option>
					<option value="Reopen" <?php echo (odbc_result($rs, "Status")==="Reopen")? " selected":"";?>>Reopen</option>
					<option value="Lost" <?php echo (odbc_result($rs, "Status")==="Lost")? " selected":"";?>>Lost</option>
				</select>
			</td>
			<td colspan="2" rowspan="5" style="background-color: #d3d3d3;">
				Likely Brand <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup>:
				<select class="form-control" name="Brand" required>
					<option value=""></option>
					<option value="TMS" <?php echo (odbc_result($rs, "Likely Brand")==="TMS")? " selected":"";?>>TMS</option>
					<option value="UA" <?php echo (odbc_result($rs, "Likely Brand")==="UA")? " selected":"";?>>UA</option>
				</select>
				<br />
				Created By <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup>:
				<input type="text" name="UserID" value="<?php echo $LoginID; ?>" class="form-control" readonly>
				<br />
				Assigned To:
				<select name="AssignTo" class="form-control">
					<?php
						echo '<option value="'.odbc_result($rs, 'Assign To').'">'.odbc_result($rs, 'Assign To').'</option>';
						$assignto = odbc_exec($conn, "SELECT [LoginID], [FullName] FROM [User] WHERE [UserType] NOT IN ('Admin', 'HEADCOMP', 'FOE', 'Accountant', 'SchoolDirector', 'Principal') AND [LoginID] <> '$LoginID'") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($assignto)){
							echo '<option value="'.odbc_result($assignto, 'LoginID').'" >'.odbc_result($assignto, 'FullName').'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td style="border:none;">Name <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>			
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="Name" value="<?php echo odbc_result($rs, "Name")?>" required></td>
		</tr>
		<tr>
			<td style="border:none;">Job Title</td>			
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="JobTitle" value="<?php echo odbc_result($rs, "Job Title")?>"></td>
		</tr>
		<tr>
			<td style="border:none;">Company Name</td>			
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="CompanyName" value="<?php echo odbc_result($rs, "Company Name")?>" ></td>
		</tr>
		<tr>
			<td style="border:none;">Address</td>			
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="Address1" value="<?php echo odbc_result($rs, "Address 1")?>" ></td>
		</tr>
		<tr>
			<td style="border:none;"></td>			
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="Address2" value="<?php echo odbc_result($rs, "Address 2")?>"></td>
		</tr>
		<tr>
			<td style="border:none;">City / District</td>			
			<td style="border:none;"><input type="text" class="form-control" name="City" id="city" value="<?php echo odbc_result($rs, "City")?>" ></td>
		
			<td style="border:none;">State</td>			
			<td style="border:none;">
				<select class="form-control custom-select" name="State" id="state" maxlength="50" required>
					<option value=""></option>
					<?php
						$c_State = odbc_exec($conn, "SELECT DISTINCT[State], [StateCode] FROM [postcode] ORDER BY [State] ASC") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($c_State)){
							echo '<option value="'.odbc_result($c_State, "StateCode").'"';
							echo (odbc_result($c_State, "StateCode") == odbc_result($rs, "State"))?' selected':'';
							echo '>'.odbc_result($c_State, "State").'</option>';
						}
					?>
				</select>
			<!--input type="text" class="form-control" name="State" id="state" value="<?php echo odbc_result($rs, "State")?>" required></td-->
		</tr><tr>
			<td style="border:none;">Country</td>			
			<td style="border:none;"><input type="text" class="form-control" name="Country" id="country" value="<?php echo odbc_result($rs, "Country")?>" ></td>
			<td style="border:none;">PIN <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>			
			<td style="border:none;"><input type="text" class="form-control" name="PostCode" id="postcode" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" value="<?php echo odbc_result($rs, "Post Code")?>" ></td>
		</tr>
		<tr>
			<td style="border:none;">Office Phone</td>			
			<td style="border:none;"><input type="text" class="form-control" name="OfficePhone" value="<?php echo odbc_result($rs, "Office Phone")?>"></td>
			<td style="border:none;">Office Fax</td>			
			<td style="border:none;"><input type="text" class="form-control" name="OfficeFax" value="<?php echo odbc_result($rs, "Office Fax")?>"></td>			
		</tr>
		<tr>
			<td style="border:none;">Mobile <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>			
			<td style="border:none;"><input type="text" class="form-control" name="Mobile" value="<?php echo odbc_result($rs, "Mobile")?>" required></td>
		</tr>
		<tr>
			<td style="border:none;">Email <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>
			<td colspan="3" style="border:none;"><input type="email" class="form-control" name="Email" value="<?php echo odbc_result($rs, "Email")?>" required></td>
		</tr>
		<tr>
			<td style="border:none;">Website</td>
			<td colspan="3" style="border:none;"><input type="text" class="form-control" name="Website" value="<?php echo odbc_result($rs, "Website")?>"></td>
		</tr>
		<tr>
			<td style="border:none;">Lead Source <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>			
			<td colspan="3" style="border:none;">
				<select name="LeadSource" class="form-control" required>
					<option value=""></option>
					<option value="Cold Call" <?php echo (odbc_result($rs, "Source")==="Cold Call")? " selected":"";?>>Cold Call</option>
					<option value="Email" <?php echo (odbc_result($rs, "Source")==="Email")? " selected":"";?>>Email</option>
					<option value="Reference" <?php echo (odbc_result($rs, "Source")==="Reference")? " selected":"";?>>Reference</option>
					<option value="Website" <?php echo (odbc_result($rs, "Source")==="Website")? " selected":"";?>>Website</option>
					<option value="Campaign" <?php echo (odbc_result($rs, "Source")==="Campaign")? " selected":"";?>>Campaign</option>
					<option value="Word of Mouth" <?php echo (odbc_result($rs, "Source")==="Word of Mouth")? " selected":"";?>>Word of Mouth</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="text-align: center">
				<input type="submit" class="btn btn-primary" value="Edit">
			</td>
		</tr>
	</table>
	</form>
</div>

<?php require_once("../footer.php"); ?>