<script>
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtCity").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtCity").value = xmlhttp.responseText;
                    document.getElementById("txtState").value = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","PostCode.php?q="+str,true);
            xmlhttp.send();
        }
    }
    
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

                    city.value = citystatearr[0];
                    state.value = citystatearr[1];
                    country.value = citystatearr[2];
            }
    }

    // End of Get City State
    
	function ChooseContact(data) {
		//alert(document.getElementById ("CommunicationReference").value);
		if(document.getElementById ("CommunicationReference").value == "FATHER"){
			document.getElementById ("txtBox").value = "<?php echo odbc_result($rs, 'Father_s Name'); ?>";
		}
		if(document.getElementById ("CommunicationReference").value == "MOTHER"){
			document.getElementById ("txtBox").value = "<?php echo odbc_result($rs, 'Mother_s Name'); ?>";
		}
		if(document.getElementById ("CommunicationReference").value == "GUARDIAN"){
			document.getElementById ("txtBox").value = "<?php echo odbc_result($rs, 'Guardian Name'); ?>";
		}
	}
</script>

<div class="table-responsive" style="width: 40%">
	<table class="table">
		<tr>
			<td>Address To</td>
			<td>
                            <select name="CommunicationReference" id="CommunicationReference" class="form-control" style="background-color: #ffff00;" onchange="ChooseContact(this)">
									<option value=""></option>
									<option value="FATHER"  <?php if (odbc_result($rs, "Address To") == "FATHER") echo " selected";?>>Father</option>
									<option value="MOTHER"  <?php if (odbc_result($rs, "Address To") == "MOTHER") echo " selected";?>>Mother</option>
									<option value="GUARDIAN"  <?php if (odbc_result($rs, "Address To") == "GUARDIAN") echo " selected";?>>Guardian</option>
								</select>
			</td>
		</tr>
		<tr>
			<td>Contact Name</td>
			<td><input type="text" id="txtBox" name="ContactName" style="background-color: #ffff00;" value="<?php 
                                                                if(odbc_result($rs, 'Addressee') != "") echo odbc_result($rs, 'Addressee');
                                                                //if(odbc_result($rs, 'Address To') == "FATHER") echo odbc_result($rs, 'Father_s Name');
                                                                //if(odbc_result($rs, 'Address To') == "MOTHER") echo odbc_result($rs, 'Mother_s Name'); 
                                                                ?>" class="form-control" required />
			</td>
			
		</tr>
		<tr>
			<td>Address 1</td>
			<td><input type="text" maxlength="50" name="Address1" style="background-color: #ffff00;" value="<?php echo odbc_result($rs, 'Address1')?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Address 2</td>
			<td><input type="text" maxlength="50" name="Address2" value="<?php echo odbc_result($rs, 'Address2')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>City</td>
			<td><input type="text" maxlength="30" style="background-color: #ffff00;" name="City" value="<?php echo odbc_result($rs, 'City')?>" class="form-control" id="city" required /></td>
		</tr>
		<tr>
			<td>Post Code</td>
			<td><input type="text" maxlength="6" style="background-color: #ffff00;" name="PostCode" value="<?php echo odbc_result($rs, 'Post Code')?>" class="form-control" required id="postcode" onkeyup="updateCityState()" /></td>
		</tr>
		<tr>
			<td>State</td>
			<td><input type="text" maxlength="20" style="background-color: #ffff00;" name="State" value="<?php echo odbc_result($rs, 'State')?>" class="form-control" id="state" required /></td>
		</tr>
		<tr>
			<td>Country</td>
			<td><input type="text" maxlength="20" style="background-color: #ffff00;" name="Country" value="<?php echo odbc_result($rs, 'Country')?>" id="country" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Phone No</td>
			<td><input type="text" name="PhoneNo" value="<?php echo odbc_result($rs, 'phone number')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mobile</td>
			<td><input type="text" maxlength="30" style="background-color: #ffff00;" name="MobileNo" value="<?php echo odbc_result($rs, 'mobile number')?>" class="form-control" maxlength="13" required /></td>
		</tr>
		<tr>
			<td>E-Mail Address</td>
			<td><input type="email" maxlength="50" name="Email" value="<?php echo odbc_result($rs, 'e-mail address')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father Email</td>
			<td><input type="email" maxlength="50" name="FatherEmail" value="<?php echo odbc_result($rs, 'father email')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father Mobile No</td>
			<td><input maxlength="13" name="FatherMobile" value="<?php echo odbc_result($rs, 'Father Mobile')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mother Email</td>
			<td><input type="email" maxlength="50" name="MotherEmail" value="<?php echo odbc_result($rs, 'mother email')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mother Mobile No</td>
			<td><input maxlength="13" name="MotherMobile" value="<?php echo odbc_result($rs, 'Mother Mobile')?>" class="form-control" /></td>
		</tr>
	</table>
</div>