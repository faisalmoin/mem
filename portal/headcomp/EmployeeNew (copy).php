<?php
	require_once("header.php");
	//require_once("ValidationEnquiry.php");
        $ms=$CompName;
	if($_GET['eid']!=""){
        echo "<div class='container'><div class='bs-example'>
                        <div class='alert alert-success alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Success!</strong> User enquiry <strong>".$_GET['eid']."</strong> has been registered.
                        </div>
                </div></div>";
    }
?>

<script>
    $(function() {

	  $("#date1").datepicker({ 
                      changeMonth: true, 
		      changeYear: true,
                      showButtonPanel: true,
                      yearRange: "1950:2016"
                      });
                      
                        $("#date2").datepicker({ 
                      changeMonth: true, 
		      changeYear: true,
                      showButtonPanel: true,
                      yearRange: "1950:2016"
                      });
                      
                        $("#date3").datepicker({ 
                      changeMonth: true, 
		      changeYear: true,
                      yearRange: "1950:2016"
                      });
                        $("#date4").datepicker({ 
                      changeMonth: true, 
		      changeYear: true,
                      yearRange: "1950:2016"
                      });
                      
		$("#dt1").datepicker({ 
			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
			minDate:0,
			//maxDate: 0, 
			changeMonth: true, 
			changeYear: true
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

                    city.value = citystatearr[0];
                    state.value = citystatearr[1];
                    country.value = citystatearr[2];
            }
    }
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
    //  change language
   $(function(){
    $('select').change(function() {            
            var selections = [];
            $('#select1 option:selected').each(function(){
                    if($(this).val())
                        selections.push($(this).val());
                }
            )
            $('#select2 option:selected').each(function(){
                    if($(this).val())
                        selections.push($(this).val());
                }
            )
            //console.log(selections );
            $('#select2 option').each(function() {
                $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
            });
            $('#select1 option').each(function() {
                $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
            });
        });
   
   });
    
    
</script>
<div class="container">
	<h3 class="text-primary"><strong>Employee</strong></h3>
	<div class="jumbotron">
	<form action="AddEnquiry.php" method="POST" name="form1"  onkeypress="return event.keyCode != 13;">
		<div class="table-responsive">
			<table border="0px" align="center"" class="table">
				<tr>
					<td colspan="6"><h3 class="text-primary">General</h3></td>
				</tr>
				<tr>
					<td colspan="6"><h4>Basic Information</h4></td>
				</tr>
				<tr>
					<td height="50px">First Name</td>
					<td height="50px" class="ss-item-required"><input type="text" class="form-control" name="fname"/></td>
					<td height="50px">Middle Name</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" name="mname"/></td>
                                        
				</tr>
				<tr>
                                        <td height="50px">Last Name</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" name="lname"/></td>
					
                                        <td height="50px">Date Of Birth</td>
					<td height="50px" class="ss-item-required">
						<input type="text" name="DOB" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" id="date1" required readonly />
					</td>
				</tr>	
                                
                                
                                
                                
				<tr>
					<td height="50px">Gender</td>
					<td height="50px" class="ss-item-required">
						<select name="Gender" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<option value="1">men</option>
							<option value="2">Female</option>
						</select>
					</td>
                                        <td height="50px">Company Name</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" name="companyname"/></td>
					
					
				</tr>
				
				
				<tr>
					<td>Citizenship</td>
					<td>
					<?php
						$mssql5="SELECT [Code] FROM [Citizenship]";
						$msCT1=  odbc_exec($conn, $mssql5) or die(odbc_errormsg($conn));
					?>
						<select name="Citizenship" style="padding: 4px; border: 0px solid #E5E4E2;" class="form-control">
							<option value=""></option>
							<?php
							while(odbc_fetch_array($msCT1)){
								echo "<option value='".odbc_result($msCT1, 'Code')."'";
								if(odbc_result($msCT1, 'Code') == "INDIAN") echo " selected";
								echo ">".odbc_result($msCT1, 'Code')."</option>";
							}
							?>
						</select>
					</td>
                                          <td height="50px">Employment Date</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="empdate"/></td>
					
					<td colspan="3"></td>
				</tr>
                                
                                <tr>
                                    
                                     <td height="50px">Employee Type</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="emptype"/></td>
					
                                        <td height="50px">Department</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="department"/></td>
					
                                </tr>  <tr>
                                    
                                     <td height="50px">Job Title</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="jobtype"/></td>
					 <td height="50px">CTC</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="ctc"/></td>
					
                                </tr>
                                
                                  <tr>
                                    
                                     <td height="50px">PAN Card No_</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="panno"/></td>
					  
                                        <td height="50px">Company E-Mail</td>
                                        <td><input type="email" class="form-control" name="CompanyEmail" size="92px" maxlength="50" style="padding: 4px;" /></td>
					  
                                </tr>
                                
                                
                                  <tr>
                                    
                                     <td height="50px">Blood Group</td>
                                        <td height="50px" class="ss-item-required"><input type="text" class="form-control" id="date2" name="Blood"/></td>
					
                                      
                                         <td height="50px">Image Upload</td>
                                       <td><input type="file" name="fileToUpload" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
                                        
                                </tr>
				
				<tr>
					<td colspan="6"><h3 class="text-primary">Communication</h3></td>
				</tr>
							
				<tr>
					<td>Address</td>
					<td colspan="5"><input type="text" name="Address" id="Addressee" size="92" maxlength="50" class="form-control" required="true" /></td>
				</tr>
				<tr>
					<td>Address 1</td>
					<td colspan="5"><input type="text" name="Address1" size="92" maxlength="50" class="form-control" /></td>
				</tr>
				
				<tr><td>Post Code</td>
					<td>
                      <input type="text" name="PostCode" maxlength="6" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" />
					</td>
					<td>State</td>
					<td><input type="text" name="State" style="padding: 4px;" id="state" maxlength="10" class="form-control" /></td>
				</tr>
				<tr>
					<td>Country</td><td><input type="text" name="Country" id="country" maxlength="10" style="padding: 4px;" class="form-control"/></td>
					<td>City</td><td><input type="text" name="City" id="city" maxlength="30" style="padding: 4px;" class="form-control"/></td>
					
				</tr>
				<tr>
					<td>Phone No. (Landline)</td><td><input type="tel" maxlength="15" class="form-control" name="Landline" style="padding: 4px;" class="isNumeric" /></td>
					<td>Mobile No.</td> <td><input type="text" class="form-control" name="Mobile" maxlength="13" style="padding: 4px;" class="isNumeric" onblur="if(this.value.length < 10){alert('Mobile number should not be less than 10 digit ...');}" /></td>
				</tr>
				<tr>
					<td>Email</td><td colspan="5"><input type="email" class="form-control" name="Email" size="92px" maxlength="50" style="padding: 4px;" /></td>
				</tr>
				
                                	<tr>
					<td colspan="6"><h3 class="text-primary">Previous Company details </h3></td>
				</tr>
							
				<tr>
					<td>Company Name</td>
					<td colspan="5"><input type="text" name="compnayname" id="Addressee" size="92" maxlength="50" class="form-control" required="true" /></td>
				</tr>
				<tr>
					<td>Address</td>
					<td colspan="5"><input type="text" name="Address" size="92" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Start Date</td>
                                        <td><input type="text" id="date3" name="startdate" class="form-control" /></td>
				        <td>End Date</td>
					<td>
                                        <input type="text" name="enddate"  id="date4" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" />
					</td>
                                      
                                </tr>
				<tr>
					<td>Previous Gross Salary</td>
                                        <td><input type="text" name="grosssalary" style="padding: 4px;" class="form-control" /></td>
				
                                        <td>Reason For Leaving</td>
                                     <td><input type="text" name="reasonforleaving"  style="padding: 4px;" id="date4" class="form-control" /></td>
					
					
                                </tr>
				
				
				
                                
				
				<tr>
					<td>
						<input type="submit" value="Submit" id="btnSubmit" class="btn btn-primary" onclick="formcheck();" onclick="setTimeout(disableFunction, 1);" />
					</td>
				</tr>
				
			</table>
		</div>
	</div>
	</form>
	</div>
</div>

<?php
	require_once("../footer.php");
?>