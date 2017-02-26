<?php
	require_once("header.php");
	
	
	$id=$_REQUEST['id'];
	$financialyeardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
	
	$result=odbc_exec($conn, "SELECT * FROM [Temp Enquiry] WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
    if(!$result){
        exit("Error in SQL execution...");
    }
    odbc_fetch_row($result)
?>

<!-- Body Start -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Edit Enquiry Form <?php echo $id;?></h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Start of Contant -->

	<form action="UpdateEnquiry.php" method="POST" id="form1"  onkeypress="return event.keyCode != 13;" >
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<ul class="nav nav-tabs" id="StuTab">
			<li class="active"><a href="#StuTab1" data-toggle="tab">General</a></li>
			<li><a href="#StuTab2" data-toggle="tab">Communication</a></li>
			<li><a href="#StuTab3" data-toggle="tab">Parent Information</a></li>
			<li><a href="#StuTab4" data-toggle="tab">Enquiry Details</a></li>
			<li><a href="#StuTab5" data-toggle="tab">Follow-up</a></li>
		</ul>
		<div class="tab-content" id="StuTabContent">
			<div class="tab-pane face in active" id="StuTab1">
				<div class="table-responsive">
					<table border="0px" align="center"" class="table">
						<tr>
					<td style="border: none;" colspan="6"><h4>Basic Information</h4></td>
				</tr>
					<td style="border: none;" height="50px">Enquiry No</td>
					<td style="border: none;" height="50px" colspan="5" class="ss-item-required">
						<input type="text" class="form-control" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" readonly="true" value="<?php echo odbc_result($result, 'System Genrated No_')?>"  required />
					<input type="hidden" name="EnquiryNo" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" readonly="true" value="<?php echo odbc_result($result, 'No_')?>" required />
						</td>
				</tr>
				<tr>
					<td style="border: none;" height="50px">Enquiry Date</td>
					<td style="border: none;" height="50px" class="ss-item-required"><input type="text" class="form-control" size="25" name="EnquiryDate" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required value="<?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($result, 'Enquiry Date')))) ?>" id="datepicker1" /></td>
					<td style="border: none;" height="50px">Admission for Year</td>
					<td style="border: none;" height="50px" class="ss-item-required">
					<?php
                        $mssql1="SELECT [Code] FROM [Academic Year] WHERE [Company Name]='$ms'";
                        $msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
                    ?>
					<select name="AcadYear" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
						<option value=""></option>
						<?php
                            while(odbc_fetch_array($msAY)){
                                echo "<option value='".odbc_result($msAY, "Code")."'";
                                    if(odbc_result($msAY, "Code") == odbc_result($result, "Admission For Year")) echo "selected ";
                                echo ">".odbc_result($msAY, "Code")."</option>";
                            }
                        ?>
					</select>
					</td>
				</tr>
				<tr>
					<td style="border: none;" height="50px">Student Name</td>
					<td style="border: none;" height="50px" colspan="5" class="ss-item-required">
						<input type="text" class="form-control" Name="StudentName" value="<?php echo odbc_result($result, 'Name')?>" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" size="80" title="Student's Name" required />
					</td>
				</tr>
				<tr>
					<td style="border: none;" height="50px">Gender</td>
					<td style="border: none;" height="50px" class="ss-item-required">
						<select name="Gender" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
							<option value=""></option>
							<option value="1" <?php if(odbc_result($result, "Gender")==1) echo " selected"?>>Boy</option>
							<option value="2" <?php if(odbc_result($result, "Gender")==2) echo " selected"?>>Girl</option>
						</select>
					</td>
					<td style="border: none;" height="50px">Date of Birth</td>
					<td style="border: none;" height="50px" class="ss-item-required"><input type="text" class="form-control" name="DOB" value="<?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($result, 'date of birth')))) ?>" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" id="datepicker2" required /></td>
				</tr>
				<tr>
					<td style="border: none;" height="50px">Class Applied</td>
					<td style="border: none;" height="50px" class="ss-item-required">
					<?php
                        $mssql2="SELECT [Code] FROM [Class] WHERE [Company Name]='$ms'";
                        $msCA=odbc_exec($conn, $mssql2) or die(odbc_errormsg());
                    ?>
						<select name="ClassApplied" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" onChange="
							if (this.value == 'XI' || this.value == 'XII') {
								document.getElementById('Stream').disabled=false;
							} 
							else {
								document.getElementById('Stream').disabled=true;
							}
						" required>
							<option value=""></option>
							<?php
                                while(odbc_fetch_array($msCA)){
                                    echo "<option value='".odbc_result($msCA, "Code")."'";
                                    if(odbc_result($msCA, "Code") == odbc_result($result, "class applied")) echo " selected";
                                    echo ">".odbc_result($msCA, "Code")."</option>";
                                }
                            ?>
						</select>
					</td>
					<td style="border: none;" height="50px">Curricullum Interested</td>
					<td style="border: none;" height="50px" class="ss-item-required">
						<?php
							$mssql3="SELECT [Code] FROM [Curriculum] WHERE [Company Name]='$CompName'";
							$msCU1=odbc_exec($conn, $mssql3) or die(odbc_errormsg($conn));			
						?>
						<select name="Curricullum" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
							<option value=""></option>
							<?php
								while(odbc_fetch_array($msCU1)){
									echo "<option value='".odbc_result($msCU1, "Code")."'";
									if(odbc_result($msCU1, "Code") == odbc_result($result, "Curriculum Intrested")) echo " selected";
									echo ">".odbc_result($msCU1, "Code")."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
				    <td style="border: none;">Stream</td>
				    <td style="border: none;" colspan="3">
				        <select name="Stream" disabled="true"  id="Stream" style="padding: 4px;">
						    <option value="0" <?php if(odbc_result($result, "Stream") == 0) echo " selected"; ?>></option>
						    <option value="1" <?php if(odbc_result($result, "Stream") == 1) echo " selected"; ?>>Science</option>
						    <option value="2" <?php if(odbc_result($result, "Stream") == 2) echo " selected"; ?>>Science Non-Medical</option>
						    <option value="3" <?php if(odbc_result($result, "Stream") == 3) echo " selected"; ?>>Science Medical</option>
						    <option value="4" <?php if(odbc_result($result, "Stream") == 4) echo " selected"; ?>>Commerce</option>
						    <option value="5" <?php if(odbc_result($result, "Stream") == 5) echo " selected"; ?>>Atrs</option>
						</select>
                    </td>
                </tr>
				<tr>
					<td style="border: none;">Mother's Name</td>
					<td style="border: none;" class="ss-item-required">
						<select name="MotherPreffix" style="padding: 3px">
							<option value="0" <?php if(odbc_result($result, "Intials")==0) echo " selected"?>>Mrs.</option>
							<option value="1" <?php if(odbc_result($result, "Intials")==1) echo " selected"?>>Dr.</option>
							<option value="2" <?php if(odbc_result($result, "Intials")==2) echo " selected"?>>Miss</option>
							<option value="3" <?php if(odbc_result($result, "Intials")==3) echo " selected"?>>Late Smt.</option>
						</select>
						<input type="text" class="form-control" name="MotherName" value="<?php echo odbc_result($result, 'Mother_s Name')?>" size="35" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required /></td>
					<td style="border: none;">Father's Name</td>
					<td style="border: none;" class="ss-item-required">
						<select name="FatherPreffix" style="padding: 3px">
							<option value="0" <?php if(odbc_result($result, "Intials1")==0) echo " selected"?>>Mr.</option>
							<option value="1" <?php if(odbc_result($result, "Intials1")==1) echo " selected"?>>Dr.</option>
							<option value="2" <?php if(odbc_result($result, "Intials1")==2) echo " selected"?>>Late Shri</option>
						</select>
						<input type="text" class="form-control" name="FatherName" value="<?php echo odbc_result($result, 'Father_s Name')?>" size="35" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required /></td>
				</tr>
				<tr>
					<td style="border: none;">Gurdian Name</td>
					<td style="border: none;" colspan="5">
						<select name="GuardianPreffix" style="padding: 3px">
							<option value="0"></option>
							<option value="1" <?php if(odbc_result($result, "Intials2")==1) echo " selected"?>>Dr.</option>
							<option value="2" <?php if(odbc_result($result, "Intials2")==2) echo " selected"?>>Mr.</option>
							<option value="3" <?php if(odbc_result($result, "Intials2")==3) echo " selected"?>>Mrs.</option>
							<option value="4" <?php if(odbc_result($result, "Intials2")==4) echo " selected"?>>Late Smt.</option>
							<option value="5" <?php if(odbc_result($result, "Intials2")==5) echo " selected"?>>Late Shri</option>
						</select>
						<input type="text" class="form-control" name="GuardianName" value="<?php echo odbc_result($result, 'Guardian Name')?>" size="35" />
					</td>
				</tr>
				<tr>
					<td style="border: none;">Physically Challenged</td>
					<td style="border: none;" colspan="5"><input type="checkbox" style="padding: 4px" value="1" <?php if(odbc_result($result, "Physically Challenged") == 1) echo " checked"?> name="PhysicallyChallanged" /></td>
				</tr>
				<tr>
					<td style="border: none;">Concession Category</td>
					<td style="border: none;" colspan="5">
						<select name="ConcessionCategory" style="padding: 4px">
							
							<option value="0" <?php if(odbc_result($result, "Category")==1) echo " selected"; ?>>General</option>
							<option value="1" <?php if(odbc_result($result, "Category")==2) echo " selected"; ?>>Defence</option>
							<option value="2" <?php if(odbc_result($result, "Category")==3) echo " selected"; ?>>Staff</option>
							<option value="3" <?php if(odbc_result($result, "Category")==4) echo " selected"; ?>>Sibling</option>
							<option value="4" <?php if(odbc_result($result, "Category")==5) echo " selected"; ?>>Other</option>
							<option value="5" <?php if(odbc_result($result, "EWS")==1) echo " selected"; ?>>RTE/EWS</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="border: none;">Language 2</td>
					<td style="border: none;" colspan="5">
						<select name="Language2" style="padding: 4px">
							<option value="0"></option>
							<option value="1" <?php if(odbc_result($result, "langauge 1")==1) echo " selected"?>>Hindi</option>
							<option value="2" <?php if(odbc_result($result, "langauge 1")==2) echo " selected"?>>Tamil</option>
							<option value="3" <?php if(odbc_result($result, "langauge 1")==3) echo " selected"?>>Sanskrit</option>
							<option value="4" <?php if(odbc_result($result, "langauge 1")==4) echo " selected"?>>Kannada</option>
							<option value="5" <?php if(odbc_result($result, "langauge 1")==5) echo " selected"?>>French</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="border: none;">Language 3</td>
					<td style="border: none;" colspan="5">
						<select name="Language3" style="padding: 4px">
							<option value="0"></option>
							<option value="1" <?php if(odbc_result($result, "language 2")==1) echo " selected"?>>Hindi</option>
							<option value="2" <?php if(odbc_result($result, "language 2")==2) echo " selected"?>>Tamil</option>
							<option value="4" <?php if(odbc_result($result, "language 2")==4) echo " selected"?>>Sanskrit</option>
							<option value="3" <?php if(odbc_result($result, "language 2")==3) echo " selected"?>>Kannada</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="border: none;">Citizenship</td>
					<td style="border: none;" colspan="5">
					<?php
						$mssql5="SELECT [Code] FROM [Citizenship]";
						$msCT1=odbc_exec($conn, $mssql5);
					?>
						<select name="Citizenship" style="padding: 4px; border: 0px solid #E5E4E2;">
							<option value=""></option>
							<?php
								while(odbc_fetch_array($msCT1)){
								    echo "<option value='".odbc_result($msCT1, "Code")."'";
								    if(odbc_result($msCT1, "Code") == odbc_result($result, "Citizenship")) echo " selected";
								    echo ">".odbc_result($msCT1, "Code")."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="border: none;" colspan="6"><h4>Details of the Institution last attended</h4></td>
				</tr>
				<tr>
					<td style="border: none;">Name of the Previous School</td>
					<td style="border: none;" colspan="5"><input type="text" class="form-control" value="<?php echo odbc_result($result, 'Name Of The Previous Institute')?>" style="padding: 4px;" size="80" name="PreviousSchool" /></td>
				</tr>
				<tr>
					<td style="border: none;">Last class attended</td>
					<td style="border: none;" colspan="5"><input type="text" class="form-control" value="<?php echo odbc_result($result, 'Class Last Attended')?>" style="padding: 4px;" size="10" name="PrevSchLastClass" /></td>
				</tr>
				<tr>
					<td style="border: none;">Curricullum Followed</td>
					<td style="border: none;" colspan="5"><input type="text" class="form-control" value="<?php echo odbc_result($result, 'Curriculum Followed')?>" style="padding: 4px;" size="10" name="PrevSchCurricullum" /></td>
				</tr>
				<tr>
					<td style="border: none;">Medium of Instruction</td>
					<td style="border: none;" colspan="5"><input type="text" class="form-control" value="<?php echo odbc_result($result, 'Medium Of Instruction')?>" style="padding: 4px;" size="10" name="PrevSchMedium" /></td>
				</tr>
					</table>
				</div>
			</div>
			<div class="tab-pane face in " id="StuTab2">
				<div class="table-responsive">
					<table border="0px" align="center"" class="table">
						<tr>
							<td style="border: none;">Address of</td>
							<td style="border: none;" colspan="2" class="ss-item-required">
								<select name="CommunicationReference" style="padding: 4px" id="CommunicationReference">
									<option value=""></option>
									<option value="FATHER"  <?php if (odbc_result($result, "Address To") == "FATHER") echo " selected";?>>Father</option>
									<option value="MOTHER"  <?php if (odbc_result($result, "Address To") == "MOTHER") echo " selected";?>>Mother</option>
									<option value="GUARDIAN"  <?php if (odbc_result($result, "Address To") == "GUARDIAN") echo " selected";?>>Guardian</option>
								</select>
								If Guardian then please specify the relationship</td>
							<td style="border: none;">
								<select name="GuardianRelationship" style="padding: 4px" id="GuardianRelationship" >
									<option value=""></option>
									<option value="BROTHER"  <?php if (odbc_result($result, "Relationship with Applicant") == "BROTHER") echo " selected";?>>Brother</option>
									<option value="BROTHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "BROTHER-IN-LAW") echo " selected";?>>Brother-in-Law</option>
									<option value="GRANDFATHER"  <?php if (odbc_result($result, "Relationship with Applicant") == "GRANDFATHER") echo " selected";?>>Grandfather</option>
									<option value="GRANDMOTHER"  <?php if (odbc_result($result, "Relationship with Applicant") == "GRANDMOTHER") echo " selected";?>>Grandmother</option>
									<option value="FATHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "FATHER-IN-LAW") echo " selected";?>>Father-in-Law</option>
									<option value="MOTHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "MOTHER-IN-LAW") echo " selected";?>>Mother-in-Law</option>
									<option value="SISTER"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER") echo " selected";?>>Sister</option>
									<option value="SISTER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER-IN-LAW") echo " selected";?>>Sister-in-Law</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Addressee</td>
							<td style="border: none;" colspan="5"><input type="text" class="form-control" name="Address" value="<?php echo odbc_result($result, "Addressee")?>" size="92" /></td>
						</tr>
						<tr>
							<td style="border: none;">Address 1</td>
							<td style="border: none;" colspan="5"><input type="text" class="form-control" name="Address1" value="<?php echo odbc_result($result, "Address 1")?>" size="92" /></td>
						</tr>
						<tr>
							<td style="border: none;">Address2</td>
							<td style="border: none;" colspan="5"><input type="text" class="form-control" name="Address2" size="92"  value="<?php echo odbc_result($result, "Address 2")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">City</td><td style="border: none;"><input type="text" class="form-control" name="City" style="padding: 4px;"  value="<?php echo odbc_result($result, "City")?>" id="city" /></td>
							<td style="border: none;" colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="text" class="form-control" name="State" style="padding: 4px;"  value="<?php echo odbc_result($result, "State")?>" id="state" /></td>
						</tr>
						<tr>
							<td style="border: none;">Country</td><td style="border: none;"><input type="text" class="form-control" name="Country" style="padding: 4px;"  value="<?php echo odbc_result($result, "Country Code")?>" /></td>
							<td style="border: none;" colspan="2">Post Code &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="PostCode" style="padding: 4px;"  value="<?php echo odbc_result($result, "Post Code")?>" class="isNumeric" /></td>
						</tr>
						<tr>
							<td style="border: none;">Phone No. (Landline)</td><td style="border: none;"><input type="text" class="form-control" name="Landline" style="padding: 4px;"  value="<?php echo odbc_result($result, "Phone Number")?>" class="isNumeric" /></td>
							<td style="border: none;" colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="Mobile" style="padding: 4px;"  value="<?php echo odbc_result($result, "Mobile Number")?>" class="isNumeric" /></td>
						</tr>
						<tr>
							<td style="border: none;">Email</td><td style="border: none;" colspan="5"><input type="text" class="form-control" name="Email" size="92px" style="padding: 4px;"  value="<?php echo odbc_result($result, "E-Mail Address")?>" /></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="tab-pane face in " id="StuTab3">
				<div class="table-responsive">
					<table border="0px" align="center"" class="table">
						<tr>
							<td style="border: none;" colspan="6"><h4>Father's Detail</h4></td>
						</tr>
						<tr>
							<td style="border: none;">Qualification</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherQualification"  value="<?php echo odbc_result($result, "Father_s Qualification")?>" /></td>
							<td style="border: none;">Office Address 1</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherOfficeAddress1" value="<?php echo odbc_result($result, "Father Office Address 1")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Occupation</td>
							<td style="border: none;"><input type="text" class="form-control"  style="padding: 4px; background-color: #FFFF00; border: 1px solid #E5E4E2;" name="FatherOccupation" value="<?php echo odbc_result($result, "Father_s Occupation")?>"  /></td>
							<td style="border: none;">Office Address 2</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherOfficeAddress2" value="<?php echo odbc_result($result, "Father Office Address 2")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Annual Income</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($result, "Father_s Annual Income"), 2, '.', '')?>" /></td>
							<td style="border: none;">Office Post Code</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherOfficePostCode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" value="<?php echo odbc_result($result, "Father Office Post Code")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Office City</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherOfficeCity" id="city1" value="<?php echo odbc_result($result, "Father Office City")?>" /></td>
							<td style="border: none;">Office Country</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="FatherOfficeCountry" id="country1" value="<?php echo odbc_result($result, "Father Office Country Code")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;" colspan="6"><h4>Mother's Detail</h4></td>
						</tr>
						<tr>
							<td style="border: none;">Qualification</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherQualification" value="<?php echo odbc_result($result, "Mother_s Qualification")?>" /></td>
							<td style="border: none;">Office Address 1</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherOfficeAddress1" value="<?php echo odbc_result($result, "Mother Office Address 1")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Occupation</td>
							<td style="border: none;"><input type="text" class="form-control"  style="padding: 4px; background-color: #FFFF00; border: 1px solid #E5E4E2;" name="MotherOccupation" value="<?php echo odbc_result($result, "Mother_s Occupation")?>" /></td>
							<td style="border: none;">Office Address 2</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherOfficeAddress2" value="<?php echo odbc_result($result, "Mother Office Address 2")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Annual Income</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherAnnualIncome" value="<?php echo number_format((float)odbc_result($result, "Mother_s Annual Income"), 2, '.', '')?>" /></td>
							<td style="border: none;">Office Post Code</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherOfficePostCode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" value="<?php echo odbc_result($result, "Mother Office Post Code")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Office City</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherOfficeCity" id="city2" value="<?php echo odbc_result($result, "Mother Office City")?>" /></td>
							<td style="border: none;">Office Country</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="MotherOfficeCountry" id="country2" value="<?php echo odbc_result($result, "Mother Office Country Code")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;" colspan="6"><h4>Guardian's Detail</h4></td>
						</tr>
						<tr>
							<td style="border: none;">Qualification</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianQualification" value="<?php echo odbc_result($result, "Guardian Qualification")?>" /></td>
							<td style="border: none;">Office Address 1</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOfficeAddress1" value="<?php echo odbc_result($result, "Guardian Office Address 1")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Occupation</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOccupation" value="<?php echo odbc_result($result, "Guardian Occupation")?>" /></td>
							<td style="border: none;">Office Address 2</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOfficeAddress2" value="<?php echo odbc_result($result, "Guardian Office Address 2")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Annual Income</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianAnnualIncome" value="<?php echo number_format((float)odbc_result($result, "Guardian Annual Income"),2, '.','')?>" /></td>
							<td style="border: none;">Office Post Code</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOfficePostCode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" value="<?php echo odbc_result($result, "Guardian Office Post Code")?>" /></td>
						</tr>
						<tr>
							<td style="border: none;">Office City</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOfficeCity" id="city3" value="<?php echo odbc_result($result, "Guardian Office City")?>" /></td>
							<td style="border: none;">Office Country</td>
							<td style="border: none;"><input type="text" class="form-control" style="padding: 4px" name="GuardianOfficeCountry" id="country3" value="<?php echo odbc_result($result, "Guardian Office Country Code")?>" /></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="tab-pane face in " id="StuTab4">
				<div class="table-responsive">
					<table border="0px" align="center"" class="table">
						<tr>
							<td style="border: none;">Type of Enquiry</td>
							<td style="border: none;" colspan="3" class="ss-item-required">
								<select name="EnquiryType"  style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
									<option value=""></option>
									<option value="WALK-IN"  <?php if (odbc_result($result, "Type Of Enquiry") == "WALK-IN") echo " selected";?>>WALK-IN</option>
									<option value="PHONE"  <?php if (odbc_result($result, "Type Of Enquiry") == "PHONE") echo " selected";?>>PHONE</option>
									<option value="EMAIL"  <?php if (odbc_result($result, "Type Of Enquiry") == "EMAIL") echo " selected";?>>EMAIL</option>
									<option value="COM_CONCT"  <?php if (odbc_result($result, "Type Of Enquiry") == "COMMUNITY CONNECT") echo " selected";?>>COMMUNITY CONNECT</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Enquiry Source</td>
							<td style="border: none;" colspan="3" class="ss-item-required">
								<?php
                                    $mssql4="SELECT [Code] FROM [EnquirySource]";
                                    $msES1=  odbc_exec($conn, $mssql4) or die(odbc_errormsg($conn));
                                ?>
                                <select name="EnquirySource"  style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" required>
                                    <option value=""></option>
                                    <?php
                                        while(odbc_fetch_array($msES1)){
                                            echo "<option value='".odbc_result($msES1, "Code")."'";
                                            if(odbc_result($msES1, "Code") == odbc_result($result, "Enquiry Source")) echo " selected";
                                            echo ">".odbc_result($msES1, "Code")."</option>";
                                        }
                                    ?>
                                </select>
							</td>
						</tr>	
						<tr>
							<td style="border: none;">Transport Required</td>
							<td style="border: none;" colspan="5">
								<select name="Transport" id="Trans" style="padding: 4px">
									<option value="0"></option>
									<option value="1" <?php if (odbc_result($result, "Transport Required") == 1) echo " selected";?>>Yes</option>
									<option value="2" <?php if (odbc_result($result, "Transport Required") == 2) echo " selected";?>>No</option>
								</select>
							</td>	
						</tr>						
						<tr>
							<td style="border: none;">Distance (in KM)</td>
							<td style="border: none;" colspan="3">
								<input type="text" class="form-control" name="Distance" class="isNumeric" onblur="if(document.getElementById('Trans') != 1 && this.value < 1){alert('Distance should be greater than 0 KM ...');this.focus();}" style="padding: 4px"  value="<?php echo odbc_result($result, 'Distance') ?>" />
							</td>
						</tr>
						<tr>
							<td style="border: none;">Enquiry Remarks</td>
							<td style="border: none;" colspan="3">
								<input type="text" class="form-control" name="EnquiryRemarks" style="padding: 4px" size="92px"  value="<?php echo odbc_result($result, 'Remarks') ?>" />
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="tab-pane face in " id="StuTab5">
				<div class="table-responsive">
					<table border="0px" align="center"" class="table">
					    <tr>
							<td style="border: none;">Follow-up Date</td>
							<td style="border: none;" colspan="4">
								<b><?php echo date("d/M/Y", strtotime(odbc_result($result, "Next FollowUp Date"))) ?></b>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Followup Status</td>
							<td style="border: none;">
								<select name="EnquiryStatus" style="padding: 4px; background-color: #FFFF00; border: 1px solid #E5E4E2;">
									<option value=""></option>
									<option value="2"  <?php if (odbc_result($result, 'Enquiry Status') == 2) echo " selected";?>>Warm</option>
									<option value="0"  <?php if (odbc_result($result, 'Enquiry Status') == 0) echo " selected";?>>Hot</option>
									<option value="1"  <?php if (odbc_result($result, 'Enquiry Status') == 1) echo " selected";?>>Cold</option>
								</select>
							</td>
							<td style="border: none;">Next Follow-up Date</td>
							<td style="border: none;" colspan="3">
								<input type="text" class="form-control" name="NextFollowupDate" style="padding: 4px; background-color: #FFFF00; border: 1px solid #E5E4E2;" id="datepicker4" size="12px"  />
							</td>
						</tr>
						<tr>
							<td style="border: none;">Follow-up Remarks</td>
							<td style="border: none;" colspan="4">
								<input type="text" class="form-control" name="Followup" style="padding: 4px" size="92px"  <?php if(odbc_result($result, "FollowUP3") != "") echo "readonly = 'true'"?>  />
							</td>
						</tr>

						<tr>
						    <td style="border: none;">Inactive</td>
						    <td style="border: none;" colspan="4">

						        <script type='text/javascript'>//<![CDATA[
                                    $(window).load(function(){
                                    $('#inactive').click(function() {
                                        $("#remarks1").toggle(this.checked);
                                    });

                                    var form1 = document.getElementById("form1"); // assuming <form id="form1"
                                    form1.onsubmit = function () {
                                        if (this.inactive.checked && this.remarks1.value == "") {
                                            alert("Please provide remarks for in-active...");
                                            this.remarks1.focus();
                                            return false;
                                        }
                                    }
                                    });
                                    //]]>
                                </script>

                                <input type="checkbox" value="1" name="In-active" id="inactive" style="padding: 4px; background-color: #FFFF00; border: 1px solid #E5E4E2;" <?php if (odbc_result($result, 'Inactive') == 1) echo " checked";?> />
                                <input type="text" class="form-control" name="Remarks1" id="remarks1" style="display:none; padding: 4px" size="92px"  <?php echo odbc_result($result, "Remarks1"); ?> placeholder="Remarks for inactive"  />
                                <?php echo odbc_result($result, "Remarks1"); ?>
						    </td>
                        </tr>
						<tr>
							<td style="border: none;" colspan="4"><h4>Previous Follow-up Status</h4></td>
						</tr>
						<tr>
							<td style="border: none;" colspan="6">
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<tbody>
                                        <tr><td style="border: none;">Follow-up 1</td><td style="border: none;"><?php echo odbc_result($result, 'FollowUP1'); ?></td></tr>
                                        <tr><td style="border: none;">Follow-up 2</td><td style="border: none;"><?php echo odbc_result($result, 'FollowUP2'); ?></td></tr>
                                        <tr><td style="border: none;">Follow-up 3</td><td style="border: none;"><?php echo odbc_result($result, 'FollowUP3'); ?></td></tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>		
		<input type="button" value="Back" class="btn btn-default" onclick="history.go(-1)" />
		<?php 
			if(odbc_result($result, "Registration Status") == 0 && odbc_result($result, "AdmissionStatus") == 0 ){
		?>
		<input type="submit" value="Submit" class="btn btn-primary" onsubmit="formcheck(); return false;" onclick="setTimeout(disableFunction, 1);" />
		<?php
			}
		?>
	</form>
	</div>
</div>

<!-- End of Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("../footer.php");
	require_once("ValidationEnquiry.php");
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
</script>

