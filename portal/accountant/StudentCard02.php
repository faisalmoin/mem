<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

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

    function changetextbox()
    {
        if (document.getElementById("ClassApplied").value == "XI" || document.getElementById("ClassApplied").value == "XII") {
            document.getElementById("Stream").disabled=false;
        } 
        else {
            document.getElementById("Stream").disabled=true;
        }
    }
    
    function copy()
    {
        var FatherName = document.getElementById("FatherName");
        var MotherName = document.getElementById("MotherName");
        var GuardianName = document.getElementById("GuardianName");
        var Addressee = document.getElementById("Addressee");
        var CommunicationReference = document.getElementById("CommunicationReference");
        var CommRef = CommunicationReference.options[CommunicationReference.selectedIndex].text;
        
        if(CommRef == "Father"){
            Addressee.value = FatherName.value;
        }
        if(CommRef == "Mother"){
            Addressee.value = MotherName.value;
        }
        if(CommRef == "Guardian"){
            Addressee.value = GuardianName.value;
        }
        //Addressee.value = CommRef;
    }
    
</script>

<div class="table-responsive" style="width: 40%">
	<table class="table">
		<tr>
			<td>Address To</td>
			<td>
                            <select name="CommunicationReference" class="form-control" style="background-color: #ffff00;" id="CommunicationReference" onchange="copy();">
                                    <option value=""></option>
                                    <option value="FATHER"  <?php if (odbc_result($row,  "Address To") == "FATHER") echo " selected";?>>Father</option>
                                    <option value="MOTHER"  <?php if (odbc_result($row,  "Address To") == "MOTHER") echo " selected";?>>Mother</option>
                                    <option value="GUARDIAN"  <?php if (odbc_result($row,  "Address To") == "GUARDIAN") echo " selected";?>>Guardian</option>
                            </select>
			</td>
		</tr>
		<tr>
			<td>Contact Name</td>
			<td><input type="text" name="ContactName" id="Addressee" style="background-color: #ffff00;" value="<?php echo odbc_result($row,  'Addressee'); ?>" class="form-control" required />
			</td>
		</tr>
		<tr>
			<td>Address 1</td>
			<td><input type="text" name="Address11" style="background-color: #ffff00;" value="<?php echo odbc_result($row,  'Address1')?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Address 2</td>
			<td><input type="text" name="Address2" value="<?php echo odbc_result($row, 'Address2')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>City</td>
			<td><input type="text" style="background-color: #ffff00;" name="City" value="<?php echo odbc_result($row, 'City')?>" class="form-control" id="city" required /></td>
		</tr>
		<tr>
			<td>Post Code</td>
			<td><input type="text" style="background-color: #ffff00;" name="PostCode" value="<?php echo odbc_result($row,  'Post Code')?>" class="form-control" required id="postcode" onchange="updateCityState()" /></td>
		</tr>
		<tr>
			<td>State</td>
			<td><input type="text" style="background-color: #ffff00;" name="State" value="<?php echo odbc_result($row,  'State')?>" class="form-control" id="state" required /></td>
		</tr>
		<tr>
			<td>Country</td>
			<td><input type="text" style="background-color: #ffff00;" name="Country" value="<?php echo odbc_result($row,  'Country')?>" id="country" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Phone No</td>
			<td><input type="text" name="PhoneNo" value="<?php echo odbc_result($row,  'phone number')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mobile</td>
			<td><input type="text" style="background-color: #ffff00;" name="MobileNo" value="<?php echo odbc_result($row,  'mobile number')?>" class="form-control" maxlength="13" required /></td>
		</tr>
		<tr>
			<td>E-Mail Address</td>
			<td><input type="email" name="Email" value="<?php echo odbc_result($row,  'e-mail address')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father Email</td>
			<td><input type="email" name="FatherEmail" value="<?php echo odbc_result($row,  'father email')?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mother Email</td>
			<td><input type="email" name="MotherEmail" value="<?php echo odbc_result($row,  'mother email')?>" class="form-control" /></td>
		</tr>
	</table>
</div>