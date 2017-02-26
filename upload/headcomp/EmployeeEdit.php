<?php
	require_once("SetupLeft.php");
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
                       $("#date5").datepicker({ 
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
<?php
    $id = $_REQUEST['Id'];
       
    $i=1;
    $rs = odbc_exec($conn, "SELECT * FROM [Employee] WHERE [ID]='$id' AND [Company Name]='$CompName'");
?>
<h1 class="text-primary">Edit Employee </h1>

<form action="EmployeeEditAdd.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" value="<?php echo $id?>" name="id" />
	<ul id="myTab" class="nav nav-tabs">
		<li class="active"><a href="#gen" data-toggle="tab">General</a></li>
		<li><a href="#com" data-toggle="tab">Communication</a></li>
		<li><a href="#tax" data-toggle="tab">Qualification</a></li>
		<li><a href="#efil" data-toggle="tab">Legal Details</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="gen">
				<table class="table table-responsive">                                    
                                    <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">General Information</td>
					</tr>
                                         <tr>
						<td height="50px">Employee Id</td>
                                                <td height="50px"><input type="text" name="employeeid" value=" <?php echo odbc_result($rs, "No_")?>" readonly class="form-control"></td>
					</tr>
                                       
                                        <tr>
						<td height="50px">Title</td>
						<td height="50px"><select name="Title" required class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($rs, "Title") == 1) { echo "selected='selected'"; } ?> value="1">Miss</option>
								<option <?php if(odbc_result($rs, "Title") == 2) { echo "selected='selected'"; } ?> value="2">Mr.</option>
                                                                <option <?php if(odbc_result($rs, "Title") == 3) { echo "selected='selected'"; } ?> value="3">Ms.</option>
                                                                <option <?php if(odbc_result($rs, "Title") == 4) { echo "selected='selected'"; } ?> value="4">Dr.</option>
                                                    </select></td>
					</tr>
					<tr>
						<td height="50px">First Name</td>
						<td height="50px"><input type="text" name="Name" value="<?php echo odbc_result($rs, "First Name");?>" required class="form-control text-uppercase" placeholder="First Name" /></td>
					</tr>
					<tr>
						<td height="50px">Middle Name</td>
						<td height="50px"><input type="text" name="MidName" value="<?php echo odbc_result($rs, "Middle Name");?>" required class="form-control" placeholder="Middle Name" /></td>
					</tr>
					<tr>
						<td height="50px">Last Name</td>
						<td height="50px"><input type="text" name="LName" class="form-control" value ="<?php echo odbc_result($rs, "Last Name");?>" placeholder="Last Name" /></td>
					</tr>
					
					 <td height="50px">Date Of Birth</td>
					<td height="50px">
						<input type="text" name="DOB" class="form-control" id="date1" value="<?php echo date('d/M/Y', strtotime(odbc_result($rs, "Birth Date")));?>"/>
					</td>
                                        </tr>
                                       <tr>
					<td height="50px">Gender</td>
					<td height="50px">
						<select name="Gender" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<option <?php if(odbc_result($rs, "Gender") == 1) { echo "selected='selected'"; } ?> value="1">Male</option>
							<option <?php if(odbc_result($rs, "Gender") == 2) { echo "selected='selected'"; } ?> value="2">Female</option>
						</select>
					</td>
                                       </tr>
                                     
				
				
				<tr>
				<td height="50px">Citizenship</td>
                                    
                                <td>
                                    <?php $mssql2="SELECT [Code],[ID] FROM [Citizenship]";
                                    $msAY2=odbc_exec($conn, $mssql2) or die(odbc_errormsg());
                                    ?>
                                    <select name="Citizenship" class="form-control" required>
                                    <option value="<?php echo odbc_result($rs, "ID");?>"></option>
                                    <?php while(odbc_fetch_array($msAY2)){
                                    echo "<option value='".odbc_result($msAY2, "ID")."'";
                                    if(odbc_result($msAY2, "ID") == odbc_result($rs, "Country_Region Code") ){echo " selected";}
                                    echo ">".odbc_result($msAY2, "Code")."</option>";
                                     }?>
                                    </select>
			       </td>
                              
                                </tr>
                                <tr>
                                          <td height="50px">Employment Date</td>
                                          <td height="50px"><input type="text" class="form-control" id="date2" value="<?php echo date('d/M/Y', strtotime(odbc_result($rs, "Employment Date")));?>" name="empdate"/></td>
					
					
				</tr>
                                
                                <tr>
                                    
                                     <td height="50px">Employee Type</td>
                                       <td height="50px"><select name="emptype" required class="form-control">
                                            <option value=""></option>
                                            <option <?php if(odbc_result($rs, "Employee Type") == 1) { echo "selected='selected'"; } ?> value="1">Full Time</option>
                                            <option <?php if(odbc_result($rs, "Employee Type") == 2) { echo "selected='selected'"; } ?> value="2">part-time</option>
                                            <option <?php if(odbc_result($rs, "Employee Type") == 3) { echo "selected='selected'"; } ?> value="3">Contractual</option>
                                            <option <?php if(odbc_result($rs, "Employee Type") == 4) { echo "selected='selected'"; } ?> value="4">Trainees</option>
                                            <option <?php if(odbc_result($rs, "Employee Type") == 5) { echo "selected='selected'"; } ?> value="5">Contract to Hire</option>
                                         </select></td>
                                </tr>
                                <tr>
                                        <td height="50px">Department</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" value="<?php echo odbc_result($rs, "Department")?>" name="department"/></td>
					
                                </tr> 
                                <tr>
                                    
                                     <td height="50px">Job Title</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" value="<?php echo odbc_result($rs,"Job Title") ?>" name="jobtype"/></td>
                                <tr>
                                        <td height="50px">CTC</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" name="ctc" value="<?php echo number_format(odbc_result($rs, "CTC"),2,'.','')?>"/></td>
					
                                </tr>
                                
                               
                                  <tr>
                                   
                                     <td height="50px">Blood Group</td>
                                        <td height="50px"><select name="Blood" required class="form-control">
                                                    <option value=""></option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 1) { echo "selected='selected'"; } ?> value="1">O+</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 2) { echo "selected='selected'"; } ?> value="2">O-</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 3) { echo "selected='selected'"; } ?> value="3">A+</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 4) { echo "selected='selected'"; } ?> value="4">A-</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 5) { echo "selected='selected'"; } ?> value="5">B+</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 6) { echo "selected='selected'"; } ?> value="6">B-</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 7) { echo "selected='selected'"; } ?> value="7">AB+</option>
                                                    <option <?php if(odbc_result($rs, "Blood Group") == 8) { echo "selected='selected'"; } ?> value="8">AB-</option>
                                                    </select></td>
                                  </tr>
                                  
                                  	<tr>
						<td height="50px">Teaching / Non Teaching</td>
						<td height="50px"><select name="Teaching" required class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($rs, "Teaching Type") == 1) { echo "selected='selected'"; } ?> value="1">Teaching</option>
								<option <?php if(odbc_result($rs, "Teaching Type") == 0) { echo "selected='selected'"; } ?> value="0">Non Teaching</option>
                                                    </select></td>
					</tr>
                                        <tr>
					<td height="50px">Company Email ID</td>
                                        <td height="50px"><input type="email" class="form-control" name="CompanyEmail" value="<?php echo odbc_result($rs, "Company E-Mail")?>" size="92px" maxlength="50" style="padding: 4px;" /></td>
				</tr>
					
				</table>
			
		</div>
            <!---------first page end---------->
		<div class="tab-pane fade" id="com">
				<table class="table table-responsive">
                                    <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Communication Details</td>
					</tr>
					<tr>
					<td height="50px">Address</td>
                                        <td height="50px"><input type="text" placeholder="Address 1" name="Address1" value="<?php echo odbc_result($rs, "Address")?>" id="Addressee" size="92" class="form-control" required="true" /></td>
				</tr>
				<tr>
					<td height="50px">Address</td>
                                        <td height="50px"><input type="text" placeholder="Address 2" name="Address2" value="<?php echo odbc_result($rs, "Address 2")?>" size="92" class="form-control" /></td>
				</tr>
				
				<tr><td height="50px">Post Code</td>
                                <td height="50px">
                                    <input type="text" name="PostCode" maxlength="6" value="<?php echo odbc_result($rs, "Post Code")?>" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" />
				</td>
                                </tr>
                                <tr>
				<td height="50px">State</td>
                                <td height="50px"><input type="text" name="State" value="<?php echo odbc_result($rs, "State1")?>" style="padding: 4px;" id="state" maxlength="10" class="form-control" /></td>
				</tr>
				<tr>
					<td height="50px">Country</td>
                                        <td height="50px"><input type="text" name="Country" id="country" value="<?php echo odbc_result($rs, "County")?>" maxlength="10" style="padding: 4px;" class="form-control"/></td>
                                </tr>
                                <tr>
                                        <td height="50px">City</td>
                                        <td height="50px"><input type="text" name="City" id="city" maxlength="30" value="<?php echo odbc_result($rs, "City")?>" style="padding: 4px;" class="form-control"/></td>
					
				</tr>
				<tr>
					<td height="50px">Phone No. (Landline)</td>
                                        <td height="50px"><input type="tel" maxlength="15" class="form-control" value="<?php echo odbc_result($rs, "Phone No_")?>" name="Landline" style="padding: 4px;" class="isNumeric" /></td>
                                </tr>
                                <tr>
                                        <td height="50px">Mobile No.</td> 
                                        <td height="50px"><input type="text" class="form-control" name="Mobile" value="<?php echo odbc_result($rs, "Mobile Phone No_")?>" maxlength="13" style="padding: 4px;" class="isNumeric" onblur="if(this.value.length < 10){alert('Mobile number should not be less than 10 digit ...');}" /></td>
				</tr>
				<tr>
					<td height="50px">Email</td>
                                        <td height="50px"><input type="email" class="form-control" name="Email" size="92px" value="<?php echo odbc_result($rs, "E-Mail")?>" maxlength="50" style="padding: 4px;" /></td>
				</tr>
                               
				</table>
			
		</div>
		<div class="tab-pane fade" id="tax"> 
				<table class="table table-responsive">
					<tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Qualification Details</td>
					</tr>
					<tr>
						<td height="50px">Highest Qualification</td>
						<td height="50px"><select name="Qualification" required class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($rs, "Qualification") == 1) { echo "selected='selected'"; } ?> value="1">Diploma</option>
								<option <?php if(odbc_result($rs, "Qualification") == 2) { echo "selected='selected'"; } ?> value="2">Graduate</option>
                                                               <option <?php if(odbc_result($rs, "Qualification") == 3) { echo "selected='selected'"; } ?> value="3">Ph.D</option>
                                                                <option <?php if(odbc_result($rs, "Qualification") == 4) { echo "selected='selected'"; } ?> value="4">Professional Degree</option>
								<option <?php if(odbc_result($rs, "Qualification") == 5) { echo "selected='selected'"; } ?> value="5">Post Graduate</option>
                                                                <option <?php if(odbc_result($rs, "Qualification") == 6) { echo "selected='selected'"; } ?> value="6">Under Graduate</option>
                                                                <option <?php if(odbc_result($rs, "Qualification") == 7) { echo "selected='selected'"; } ?> value="7">Post Graduate Diploma</option>
                                                                <option <?php if(odbc_result($rs, "Qualification") == 8) { echo "selected='selected'"; } ?> value="8">Non Graduate</option>
                                                                 <option <?php if(odbc_result($rs, "Qualification") == 9) { echo "selected='selected'"; } ?> value="9">Other</option>
                                                    </select></td>
					</tr>
					<tr>
						<td height="50px">Degree</td>
                                                <td height="50px"><input type="text" name="Degree" value="<?php echo odbc_result($rs, "Degree");?>" class="form-control" /></td>
					</tr>
					
					<tr>
						<td height="50px">Institute/University</td>
                                                <td height="50px"><input type="text" name="University" value="<?php echo odbc_result($rs, "University");?>"  class="form-control" /></td>
					</tr>
					<tr>
						<td height="50px">Country</td>
                                                <td height="50px"><input type="text" name="Country1"  class="form-control" value="<?php echo odbc_result($rs, "Qual Country")?>" /></td>
					</tr>
					<tr>
						<td height="50px">State</td>
                                                <td height="50px"><input type="text" name="State1"  class="form-control" value="<?php echo odbc_result($rs, "Qual State")?>" /></td>
					</tr>
					<tr>
						<td height="50px">City</td>
                                                <td height="50px"><input type="text" name="City1" class="form-control" value="<?php echo odbc_result($rs, "Qual City")?>" /></td>
					</tr>
					<!--tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Income Tax</strong></td>
					</tr-->
					<tr>
						<td height="50px">Passing Year</td>
                                                
                                                <td height="50px"><input type="text" name="Passingyear" value="<?php echo date('d/M/Y', strtotime(odbc_result($rs, "Qual Passing Year")))?>" class="form-control" id="date5" /></td>
					</tr>
                                        <tr>
						<td height="50px">B_ED</td>
                                                <td> <input type="checkbox" name="B_ED" value="1"
                                                <?php
                                                        if(odbc_result($rs, "B_ED") == 1) echo " checked ";
                                                ?>
                                                            ></td>
                                                <!--td height="50px"><input type="checkbox"  name="B_ED" value="<--?php odbc_result($rs, "B_ED") ?>"/></td-->
					</tr>
				
					
				</table>
			
		</div>
		<div class="tab-pane fade" id="efil">
				<table class="table table-responsive">
				 <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Legal Documents</td>
					</tr>
                                    <tr> 
                                         <td height="50px">Passport Size Photo</td>
                                         <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload" value="<?Php echo odbc_result($rs, "Image") ?>">
							<!--small>File Size <= 300KB</small-->
						</td>
                                        
                                </tr>	
                                   
					<tr>
						<td height="50px">PAN No.</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" value="<?php echo odbc_result($rs, "PanCard") ?>" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
					<tr>
						<td height="50px">Aadhar No </td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" value="<?Php echo odbc_result($rs, "Aadhar") ?>" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                        
                                        <tr>
						<td height="50px">Apointment letter </td>
						 <td height="50px"><input type="file" name="fileToUpload[]" value="<?php odbc_result($rs, "Apointment Letter") ?>" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                        <tr>
						<td height="50px">Highest Qualification Certificate</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload" value="<?php odbc_result($rs, "H Qualification")?>">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                       
                                        <tr>
						<td height="50px"> Previous Employment Certificate</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload" value="<?php odbc_result($rs, "Prev Employment") ?>">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                         <tr>
						<td height="50px">DOB Certificate</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload" value="<?php odbc_result($rs, "Dob") ?>">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                          <tr>
						<td height="50px">Voter Id</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload"  value="<?php odbc_result($rs, "Voter Id")?>">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                          <tr>
						<td height="50px">Passport</td>
                                                <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload" value="<?php odbc_result($rs, "Passport")?>">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
					
				</table>
                     
                    <td height="50px"><input type="hidden" class="form-control" value="<?php echo $CompName; ?>" name="companyname"/></td>
				
			</div>			
		<br />
		<button type="submit" class="btn btn-success">Update</button>
	</div>
	
</form>
<?php
	require_once("SetupRight.php");
?>