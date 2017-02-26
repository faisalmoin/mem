<script>
//Father Postcode
    function FatherOffice()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode1").value;
                    if(zipValue)
                    {
                            var url = "get_city_state.php";
                            var param = "?zip=" + escape(zipValue);

                            ajax.open("GET", url + param, true);
                            ajax.onreadystatechange = handleAjax1;
                            ajax.send(null);
                    }
            }
    }
    
    function handleAjax1()
    {
            if (ajax.readyState == 4)
            {
                    citystatearr1 = ajax.responseText.split(",");

                    var city1 = document.getElementById('city1');
                    var state1 = document.getElementById('state1');
                    var state1 = document.getElementById('country1');

                    city1.value = citystatearr1[0];
                    state1.value = citystatearr1[1];
                    country1.value = citystatearr1[2];
            }
    }
    
    //Mother Postcode
    function MotherOffice()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode2").value;
                    if(zipValue)
                    {
                            var url = "get_city_state.php";
                            var param = "?zip=" + escape(zipValue);

                            ajax.open("GET", url + param, true);
                            ajax.onreadystatechange = handleAjax2;
                            ajax.send(null);
                    }
            }
    }
    
    function handleAjax2()
    {
            if (ajax.readyState == 4)
            {
                    citystatearr2 = ajax.responseText.split(",");

                    var city2 = document.getElementById('city2');
                    var state2 = document.getElementById('state2');
                    var state2 = document.getElementById('country2');

                    city2.value = citystatearr2[0];
                    state2.value = citystatearr2[1];
                    country2.value = citystatearr2[2];
            }
    }

    //Gaurdian Postcode
    function GaurdianOffice()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode3").value;
                    if(zipValue)
                    {
                            var url = "get_city_state.php";
                            var param = "?zip=" + escape(zipValue);

                            ajax.open("GET", url + param, true);
                            ajax.onreadystatechange = handleAjax3;
                            ajax.send(null);
                    }
            }
    }
    
    function handleAjax3()
    {
            if (ajax.readyState == 4)
            {
                    citystatearr3 = ajax.responseText.split(",");

                    var city3 = document.getElementById('city3');
                    var state3 = document.getElementById('state3');
                    var state3 = document.getElementById('country3');

                    city3.value = citystatearr3[0];
                    state3.value = citystatearr3[1];
                    country3.value = citystatearr3[2];
            }
    }

    // End of Get City State
</script>
<div class="table-responsive">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Father's Details</h3></td></tr>
		<tr>
			<td>Father's Name</td>
			<td><input style="background-color: #FFFF00;" type="text" maxlength="50" readonly="true" id='pFName' class="form-control" value="<?php echo odbc_result($rs, 'Father_s Name')?>" /></td>
			<td>Father's Office Address 1</td>
			<td><input type="text" maxlength="50" name="FatherOfficeAddress1" class="form-control" value="<?php echo odbc_result($rs, 'Father Office Address 1')?>" /></td>
		</tr>
		<tr>
			<td>Father's Qualification</td>
			<td><input type="text" maxlength="30"  readonly="true" id='pFQual' class="form-control" value="<?php echo odbc_result($rs, 'Father_s Qualification')?>" /></td>
			<td>Father's Office Address 2</td>
			<td><input type="text" maxlength="50" name="FatherOfficeAddress2" class="form-control" value="<?php echo odbc_result($rs, 'Father Office Address 2')?>" /></td>
		</tr>
		<tr>
			<td>Father's Occupation</td>
			<td><input style="background-color: #FFFF00;" type="text" maxlength="30"  readonly="true" id='pFOcc' class="form-control" value="<?php echo odbc_result($rs, 'Father_s Occupation')?>" /></td>
			
			<td>Father's Office Post Code</td>
			<td><input type="text" maxlength="6" name="FatherOfficePostCode" id="postcode1" class="form-control" value="<?php echo odbc_result($rs, 'Father Post Code')?>"  onchange="FatherOffice()" maxlength="6" /></td>
		
			</tr>
		<tr>
			<td>Father's Annual Income</td>
			<td><input type="text" maxlength="10"  readonly="true" id='pFAI' class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Father_s Annual Income'),'2','.','')?>" /></td>
			<td>Father's Office Country</td>
			<td><input type="text" maxlength="10" name="FatherOfficeCountry" id="country1" class="form-control" value="<?php echo odbc_result($rs, 'Father Office Country Code')?>" /></td>
		    </tr>
		<tr>
			<td></td>
			<td></td>
			<td>Father's Office City</td>
			<td><input type="text" name="FatherOfficeCity" maxlength="30" id="city1" class="form-control" value="<?php echo odbc_result($rs, 'Father Office City')?>" /></td>
		
		
		</tr>
		<tr><td colspan="4"><h3 class="text-primary">Mother's Details</h3></td></tr>
		<tr>
			<td>Mother's Name</td>
			<td><input style="background-color: #FFFF00;" type="text" maxlength="50"  readonly="true" id='pMName'  class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Name')?>" /></td>
			<td>Mother's Office Address 1</td>
			<td><input type="text" name="MotherOfficeAddress1" maxlength="50" class="form-control" value="<?php echo odbc_result($rs, 'Mother Office Address 1')?>" /></td>
		</tr>
		<tr>
			<td>Mother's Qualification</td>
                        <td><input type="text" readonly="true" maxlength="30" class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Qualification')?>" id="pMQual" /></td>
			<td>Mother's Office Address 2</td>
			<td><input type="text" name="MotherOfficeAddress2" maxlength="50" class="form-control" value="<?php echo odbc_result($rs, 'Mother Office Address 2')?>" /></td>
		</tr>
		<tr>
			<td>Mother's Occupation</td>
			<td><input style="background-color: #FFFF00;" maxlength="30" type="text"  readonly="true" id='pMOcc'  class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Occupation')?>" /></td>
			<td>Mother's Office Post Code</td>
			<td><input type="text" maxlength="60" name="MotherOfficePostCode" id="postcode2" class="form-control" value="<?php echo odbc_result($rs, 'Mother Office Post Code')?>" onchange="MotherOffice()" maxlength="6" /></td>
		
			
			</tr>
		<tr>
			<td>Mother's Annual Income</td>
			<td><input type="text" maxlength="10"  readonly="true" id='pMAI'  class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Mother_s Annual Income'),'2','.','')?>" /></td>
			<td>Mother's Office Country</td>
			<td><input type="text" name="MotherOfficeCountry" maxlength="10" id="country2" class="form-control" value="<?php echo odbc_result($rs, 'Mother Office Country Code')?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Mother's Office City</td>
			<td><input type="text" name="MotherOfficeCity" maxlength="30" id="city2" class="form-control" value="<?php echo odbc_result($rs, 'Mother Office City')?>" /></td>
		
		</tr>
	</table>
</div>