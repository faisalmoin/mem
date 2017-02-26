<?php
	require_once("header.php");
	require_once("ValidationEnquiry.php");
    
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
	<h3 class="text-primary"><strong>Enquiry Form</strong></h3>
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
					<td height="50px">Enquiry Date</td>
					<td height="50px" class="ss-item-required"><input type="text" class="form-control" maxlength="16" size="25" name="EnquiryDate" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required value="<?=date("d/M/Y", time())?>" id="datepicker1" readonly/></td>
					<td height="50px">Admission for Year</td>
					<td height="50px" class="ss-item-required">
					<?php
                                            $Year = date('y'); 
                                            $AcadYr = ($Year-1)."-".($Year);
                                            $mssql1="SELECT [Code] FROM [Academic Year] WHERE [Code] >= '$AcadYr'  AND  [Company Name]='".$ms."' ORDER BY [Code]" ;
                                            $msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
					?>
					<select name="AcadYear" class="form-control" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
						<option value=""></option>
						<?php
							while(odbc_fetch_array($msAY)){
								echo "<option value='".odbc_result($msAY, "Code")."'>".odbc_result($msAY, "Code")."</option>";
							}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td height="50px">Student Name</td>
					<td height="50px" colspan="5" class="ss-item-required">
						<input type="text" Name="StudentName" maxlength="50" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" size="80" title="Student's Name" required='required' />
					</td>
				</tr>		
				<tr>
					<td height="50px">Gender</td>
					<td height="50px" class="ss-item-required">
						<select name="Gender" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<option value="1">Boy</option>
							<option value="2">Girl</option>
						</select>
					</td>
					<script type="text/javascript">
						
					</script>
					<td height="50px">Date of Birth</td>
					<td height="50px" class="ss-item-required"><input type="text" name="DOB" maxlength="16" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" id="datepicker2" onchange="checkDiff(this.value)" required readonly /></td>
				</tr>
				<script type="text/javascript">
					
				</script>
				<tr>
					<td height="50px">Class Applied</td>
					<td height="50px" class="ss-item-required">
					<?php
						$mssql2="SELECT [Code],[Sequence] FROM [Class] WHERE [Company Name]='".$ms."' ORDER BY [Sequence]	";
						$msCA=odbc_exec($conn, $mssql2) or die(odbc_errormsg());
					?>
						<select name="ClassApplied" id="ClassApplied" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" onChange="changetextbox();" required>
							<option value=""></option>
							<?php
							while(odbc_fetch_array($msCA)){
								echo "<option value='".odbc_result($msCA, "Code")."' class='".odbc_result($msCA, "Sequence")."'>".odbc_result($msCA, "Code")."</option>";
							}
							?>
						</select>
					</td>
					<td height="50px">Curriculum Interested</td>
					<td height="50px" class="ss-item-required">
						<?php
						//$mssql3="SELECT [Code] FROM [Curriculum] WHERE  [Company Name]='".$ms."'";
						$mssql3="SELECT DISTINCT([Curriculum]) FROM [Class Section] WHERE [Company Name]='$ms' ORDER BY [Curriculum]";
						$msCU=odbc_exec($conn, $mssql3) or die(odbc_errormsg($conn));
						?>
						<select name="Curricullum" class="form-control" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
							<option value=""></option>
							<?php
							while(odbc_fetch_array($msCU)){
								echo "<option value='".odbc_result($msCU, "Curriculum")."'>".odbc_result($msCU, "Curriculum")."</option>";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
				    <td>Stream</td>
				    <td>
				        <select name="Stream" id="Stream" class="form-control" style="padding: 4px;" disabled="true">
						    <option value="0"></option>
						    <option value="1">Science</option>
						    <option value="2">Science Non-Medical</option>
						    <option value="3">Science Medical</option>
						    <option value="4">Commerce</option>
						    <option value="5">Atrs</option>
						</select>
                    </td>
                    <td colspan="2"></td>
                </tr>
				<tr>
					<td>Mother's Name</td>
					<td class="ss-item-required">
						<select name="MotherPreffix" style="padding: 3px" class="form-control">
							<option value="0">Mrs.</option>
							<option value="1">Dr.</option>
							<option value="2">Miss</option>
							<option value="3">Late Smt.</option>
						</select>
						<input type="text" name="MotherName" id="MotherName" size="35" maxlength="50" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" /></td>
					<td>Father's Name</td>
					<td class="ss-item-required">
						<select name="FatherPreffix" style="padding: 3px" class="form-control">
							<option value="0">Mr.</option>
							<option value="1">Dr.</option>
							<option value="2">Late Shri</option>
						</select>
						<input type="text" name="FatherName" id="FatherName" size="35" maxlength="50" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" /></td>
				</tr>
				<tr>
					<td>Guardian Name</td>
					<td>
						<select name="GuardianPreffix" style="padding: 3px" class="form-control">
							<option value=""></option>
							<option value="1">Dr.</option>
							<option value="2">Mr.</option>
							<option value="3">Mrs.</option>
							<option value="4">Late Smt.</option>
							<option value="5">Late Shri</option>
						</select>
						<input type="text" name="GuardianName" id="GuardianName" maxlength="50" class="form-control" size="35" />
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td>Physically Challenged</td>
					<td colspan="5"><input type="checkbox" style="padding: 4px" value="1" name="PhysicallyChallanged" /></td>
				</tr>
				<tr>
					<td>Concession Category</td>
					<td>
						<select name="ConcessionCategory" style="padding: 4px" class="form-control">
							<option value="0" selected>General</option>
							<option value="1">Defence</option>
							<option value="2">Staff</option>
							<option value="3">Sibling</option>
							<option value="4">Other</option>
							<option value="5">RTE/EWS</option>
						</select>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td>Language 2</td>
					<td>
						<select name="Language2" style="padding: 4px" class="form-control" id="select1">
							<option value="0"></option>							
							<option value="1">Hindi</option>							
							<option value="2">Tamil</option>							
							<option value="3">Sanskrit</option>							
							<option value="4">French</option>							
						</select>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td>Language 3</td>
					<td>
						<select name="Language3" style="padding: 4px" class="form-control" id="select2">
							<option value="0"></option>							
							<option value="1">Hindi</option>							
							<option value="2">Tamil</option>							
							<option value="3">Sanskrit</option>
							<option value="4">French</option>
						</select>
					</td>
					<td colspan="3"></td>
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
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="6"><h4>Details of the Institution last attended</h4></td>
				</tr>
				<tr>
					<td>Name of the Previous School</td>
					<td colspan="5"><input type="text" style="padding: 4px;" size="80" maxlength="80" name="PreviousSchool" class="form-control" /></td>
				</tr>
				<tr>
					<td>Last class attended</td>
					<td class="ss-item-required">
						<select name="PrevSchLastClass" id="PrevSchLastClass" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" disabled="true" class="form-control">
								<option value=""></option>
                                <?php
                                $mssql2="SELECT [Code], [Sequence] FROM [Class] WHERE [Company Name]='".$ms."' ORDER BY [Sequence]";
                                $msCA=odbc_exec($conn, $mssql2) or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($msCA)){
                                    echo "<option value='".odbc_result($msCA, "Code")."' class='".odbc_result($msCA, "Sequence")."'>".odbc_result($msCA, "Code")."</option>";
                                }
                                ?>
                        </select>
                    </td>
                    <td colspan="3"></td>
                </tr>
                    <tr>
                        <td>Curriculum Followed</td>
                        <td class="ss-item-required">
                            <select name="PrevSchCurricullum" id="PrevSchCurricullum" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" disabled="false" >
                                <option value=""></option>
                                <?php				
                                    $mssql3="SELECT DISTINCT([Code]) FROM [Curriculum] WHERE [Company Name]='$CompName'";
                                    $msCU1=odbc_exec($conn, $mssql3) or die(odbc_errormsg($conn));
                                    while(odbc_fetch_array($msCU1)){
                                        echo "<option value='".odbc_result($msCU1, 'Code')."'>".odbc_result($msCU1, 'Code')."</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    <td colspan="3"></td>
				</tr>
				<tr>
					<td>Medium of Instruction</td>
					<td>
					    <select name="PrevSchMedium" style="padding: 4px;" class="form-control">
					        <option value=""></option>
					        <?php
						$medinst="SELECT [Code] FROM [MediumofInstruction]";
						$msIN1=odbc_exec($conn, $medinst) or die(odbc_errormsg($conn));
						while(odbc_fetch_array($msIN1)){
						    echo "<option value='".odbc_result($msIN1, "Code")."'";
							    if(odbc_result($msIN1, "Code") == 'English' || odbc_result($msIN1, "Code") == 'ENGLISH') echo ' selected';
						    echo ">".odbc_result($msIN1, "Code")."</option>";
						}
					    ?>
					    </select>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="6"><h3 class="text-primary">Communication</h3></td>
				</tr>
				<tr>
					<td>Address of</td>
					<td colspan="2" class="ss-item-required">
						<select name="CommunicationReference" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" id="CommunicationReference" onChange="copy();" required="true">
							<option value=""></option>
							<option value="FATHER">Father</option>
							<option value="MOTHER">Mother</option>
							<option value="GUARDIAN">Guardian</option>
						</select>
						If Guardian then please specify the relationship</td>
					<td>
						<select name="GuardianRelationship" style="padding: 4px" id="GuardianRelationship" >
							<option value=""></option>
							<option value="BROTHER">Brother</option>
							<option value="BROTHER-IN-LAW">Brother-in-Law</option>
							<option value="GRANDFATHER">Grandfather</option>
							<option value="GRANDMOTHER">Grandmother</option>
							<option value="FATHER-IN-LAW">Father-in-Law</option>
							<option value="MOTHER-IN-LAW">Mother-in-Law</option>
							<option value="SISTER">Sister</option>
							<option value="SISTER-IN-LAW">Sister-in-Law</option>
						</select>
					</td>
				</tr>				
				<tr>
					<td>Addressee</td>
					<td colspan="5"><input type="text" name="Address" id="Addressee" size="92" maxlength="50" class="form-control" readonly="true" required="true" /></td>
				</tr>
				<tr>
					<td>Address 1</td>
					<td colspan="5"><input type="text" name="Address1" size="92" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address2</td>
					<td colspan="5"><input type="text" name="Address2" size="92" maxlength="50" class="form-control" /></td>
				</tr>
				<tr><td>Post Code</td>
					<td>
                      <input type="text" name="PostCode" maxlength="6" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" />
					</td>
					<td>State</td>
					<td><input type="text" name="State" style="padding: 4px;" id="state" maxlength="10" class="form-control" /></td>
				</tr>
				<tr>
					<td>Country</td><td><input type="text" name="Country" id="country" maxlength="10" style="padding: 4px;" /></td>
					<td>City</td><td><input type="text" name="City" id="city" maxlength="30" style="padding: 4px;" /></td>
					
				</tr>
				<tr>
					<td>Phone No. (Landline)</td><td><input type="tel" maxlength="15" class="form-control" name="Landline" style="padding: 4px;" class="isNumeric" /></td>
					<td>Mobile No.</td> <td><input type="text" class="form-control" name="Mobile" maxlength="13" style="padding: 4px;" class="isNumeric" onblur="if(this.value.length < 10){alert('Mobile number should not be less than 10 digit ...');}" /></td>
				</tr>
				<tr>
					<td>Email</td><td colspan="5"><input type="email" class="form-control" name="Email" size="92px" maxlength="50" style="padding: 4px;" /></td>
				</tr>
				<tr>
					<td colspan="6"><h3 class="text-primary">Parent Information</h3></td>
				</tr>
				<tr>
					<td colspan="6"><h4>Father's Detail</h4></td>
				</tr>
				<tr>
					<td>Qualification</td>
					<td><input type="text" style="padding: 4px" name="FatherQualification" maxlength="30" class="form-control" /></td>
					<td>Office Address 1</td>
					<td><input type="text" style="padding: 4px" name="FatherOfficeAddress1" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td><input type="text"  style="padding: 4px;" name="FatherOccupation" maxlength="30" class="form-control" /></td>
					<td>Office Address 2</td>
					<td><input type="text" style="padding: 4px" name="FatherOfficeAddress2" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Annual Income</td>
					<td><input type="text" style="padding: 4px" class="isNumeric form-control" name="FatherAnnualIncome" onblur="if(this.value < 0){alert('Annual Income should not be less than 0 ...'); this.focus();}" /></td>
					<td>Office Post Code</td>
					<td><input type="text" style="padding: 4px" class="isNumeric form-control" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" name="FatherOfficePostCode" onchange="FatherOffice()" id="postcode1" /></td>
				</tr>
				<tr>
					<td>Office City</td>
					<td><input type="text" style="padding: 4px" name="FatherOfficeCity" maxlength="30"  id="city1" class="form-control" /></td>
					<td>Office Country</td>
					<td><input type="text" style="padding: 4px" name="FatherOfficeCountry" maxlength="10" id="country1" class="form-control" /></td>
				</tr>
				<tr>
					<td colspan="6"><h4>Mother's Detail</h4></td>
				</tr>
				<tr>
					<td>Qualification</td>
					<td><input type="text" style="padding: 4px" name="MotherQualification" maxlength="30" class="form-control" /></td>
					<td>Office Address 1</td>
					<td><input type="text" style="padding: 4px" name="MotherOfficeAddress1" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td><input type="text"  style="padding: 4px;"  name="MotherOccupation" maxlength="30" class="form-control" /></td>
					<td>Office Address 2</td>
					<td><input type="text" style="padding: 4px" name="MotherOfficeAddress2" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Annual Income</td>
					<td><input type="text" style="padding: 4px" class="isNumeric form-control" name="MotherAnnualIncome" onblur="if(this.value < 0){alert('Annual Income should not be less than 0 ...'); this.focus();}" /></td>
					<td>Office Post Code</td>
                                        <td><input type="text" style="padding: 4px" class="isNumeric form-control" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" name="MotherOfficePostCode" onchange="MotherOffice()" id="postcode2" /></td>
				</tr>
				<tr>
					<td>Office City</td>
					<td><input type="text" style="padding: 4px" id="city2" name="MotherOfficeCity" maxlength="30" class="form-control" /></td>
					<td>Office Country</td>
					<td><input type="text" style="padding: 4px" id="country2" name="MotherOfficeCountry" maxlength="10" class="form-control" /></td>
				</tr>
				<tr>
					<td colspan="6"><h4>Guardian's Detail</h4></td>
				</tr>
				<tr>
					<td>Qualification</td>
					<td><input type="text" style="padding: 4px" name="GuardianQualification" maxlength="30" class="form-control" /></td>
					<td>Office Address 1</td>
					<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress1" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td><input type="text" style="padding: 4px" name="GuardianOccupation" maxlength="30" class="form-control" /></td>
					<td>Office Address 2</td>
					<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress2" maxlength="50" class="form-control" /></td>
				</tr>
				<tr>
					<td>Annual Income</td>
					<td><input type="text" class="isNumeric form-control" style="padding: 4px" name="GuardianAnnualIncome" onblur="if(this.value < 0){alert('Annual Income should not be less than 0 ...'); this.focus();}" /></td>
					<td>Office Post Code</td>
                                        <td><input type="text" class="isNumeric form-control" style="padding: 4px" maxlength="6" name="GuardianOfficePostCode" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="GaurdianOffice()" id="postcode3" /></td>
				</tr>
				<tr>
					<td>Office City</td>
					<td><input type="text" style="padding: 4px" name="GuardianOfficeCity" id="city3" maxlength="30" class="form-control" class="form-control" /></td>
					<td>Office Country</td>
					<td><input type="text" style="padding: 4px" name="GuardianOfficeCountry" maxlength="10" id="country3" class="form-control" /></td>
				</tr>
				<tr>
					<td colspan="6"><h3 class="text-primary">Enquiry Details</h3></td>
				</tr>
				<tr>
					<td>Type of Enquiry</td>
					<td class="ss-item-required">
						<select name="EnquiryType"  style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<option value="WALK-IN">Walk-in</option>
							<option value="PHONE">Phone</option>
							<option value="EMAIL">Email</option>
							<option value="COM_CONCT">Community Connect</option>
						</select>
					</td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td>Enquiry Source</td>
					<td class="ss-item-required">
						<select name="EnquirySource"  style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<?php
								$msES1=odbc_exec($conn, "SELECT [Code] FROM [enquirysource]") or die(odbc_errormsg($conn));
								while(odbc_fetch_array($msES1)){
							?>
							<option value="<?php echo odbc_result($msES1, "Code"); ?>">
								<?php echo odbc_result($msES1, "Code"); ?></option>
							<?php
								}
							?>
						</select>
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>Enquiry Status</td>
					<td class="ss-item-required">
						<select name="EnquiryStatus" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required class="form-control">
							<option value="0" selected>Hot</option>
							<option value="1">Cold</option>
							<option value="2">Warm</option>
						</select>
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>Transport Required</td>
					<td>
						<select name="Transport" id="Trans" style="padding: 4px" class="form-control"
						onChange="if(this.value=='2' || this.value==''){document.getElementById('Distance').value='0';document.getElementById('Distance').disabled='true' ;} 
						if(this.value=='1'){document.getElementById('Distance').value='';document.getElementById('Distance').disabled='' ;}">
							<option value="0"></option>
							<option value="1">Yes</option>
							<option value="2">No</option>
						</select>
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>Distance (in KM)</td>
					<td>
						<input type="text" name="Distance" id="Distance" maxlength="5" class="isNumeric form-control" style="padding: 4px" onblur="if(document.getElementById('Trans') != 1 && this.value < 0){alert('Distance should be greater than 0 KM ...');this.focus();}" />
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td>Enquiry Remarks</td>
					<td colspan="3">
						<input type="text" class="form-control" maxlength="39" name="EnquiryRemarks" style="padding: 4px" size="92px" />
					</td>
				</tr>
				<tr>
					<td>First Follow-up Remarks</td>
					<td colspan="3">
						<input type="text" class="form-control" maxlength="50" name="Followup" style="padding: 4px; " size="92px" />
					</td>
				</tr>
				<tr>
					<td>Next Follow-up Date</td>
					<td>
						<input type="text" class="form-control" maxlength="16" name="NextFollowupDate" style="padding: 4px;" id="datepicker3" size="12px" />
					</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4" align="center">
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