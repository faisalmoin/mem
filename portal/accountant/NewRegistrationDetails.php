<?php
	require_once("header.php");
	
    $_SESSION['token'] = md5(session_id() . time()); 
	$EnqNo=$_REQUEST['EnquiryNo'];
	$Error=$_REQUEST['Err'];
	if($Error != ""){
		$ErrMsg="<div class='container'><div class='alert alert-danger alert-error'>
			<a href='#' class='close' data-dismiss='alert'>&times;</a>
			<strong>Error!</strong> Application No. - $Error, already exist. Kindly verify.</div>.
		</div>";
	
	}


	$Student=odbc_exec($conn, "SELECT * FROM [Temp Enquiry] WHERE [No_]='".$EnqNo."' AND [Company Name]='$ms' ");
	$Stu=odbc_fetch_array($Student);
	/*
	$RegNo=mysql_query("SELECT LPAD((COUNT(`id`)+1),6,0) FROM `registration` WHERE `SchoolERPCode`='".$UsrComp[1]."'") or die(mysql_error());
	$rNo=mysql_fetch_array($RegNo);
	*/
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
<h2>Enquiry Form</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Start of Contant -->


<?php echo $ErrMsg; ?>
<form method="POST" action="AddRegistration.php" name="frmReg" id="frmReg"  enctype="multipart/form-data" onsubmit="return(validate());"  onkeypress="return event.keyCode != 13;">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />	
    <input type="hidden" name="EnqNo" value="<?php echo $EnqNo; ?>" />
<div class="container">	
	<h1 class="text-primary">Registration for <?php echo odbc_result($Student, "name")?></h1>        
	<ul class="nav nav-tabs" id="StuTab">
		<li class="active"><a href="#StuTab1" data-toggle="tab">General</a></li>
		<li><a href="#StuTab2" data-toggle="tab">Communication</a></li>
		<li><a href="#StuTab3" data-toggle="tab">Parent Information</a></li>
	</ul>

	<div class="tab-content" id="StuTabContent">
		<div class="tab-pane face in active" id="StuTab1">
			<div class="table-responsive">
				<table class="table" border="0px" width="60%" align="center">
					<tr>
                        <td style="border: none;" style="border: none;">Enquiry No.</td>
                        <td style="border: none;" class="ss-item-required">
				<input type="text" class="form-control"  name="SystemGenratedNo" style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;width: 170px" value="<?php echo odbc_result($Student, "System Genrated No_")?>" readonly="true" />
				<input type="hidden" style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;" name="EnquiryNo" value="<?php echo odbc_result($Student, "No_")?>" readonly="true" />
			</td>
						<td style="border: none;" height="50px">Admission for Year</td>
						<td style="border: none;" height="50px" class="ss-item-required">
                            <select name="FinYear" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px">
                                <option value=""></option>
                                <?php
                                    $FYr = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Company Name]='$ms'");
                                    while(odbc_fetch_array($FYr)){
                                        echo "<option value='".odbc_result($FYr, "Code")."'";
                                        if(odbc_result($FYr, "Code") == odbc_result($Student, "Admission For Year")) echo " selected";
                                        echo " >".odbc_result($FYr, "Code")."</option>";
                                    }
                                ?>
                            </select>
                        </td>
					</tr>
					<tr>
                        <td style="border: none;" style="border: none;">Candidate's Name</td>
                        <td style="border: none;" class="ss-item-required"><input type="text" class="form-control"  style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;width: 170px" name="Student" value="<?php echo odbc_result($Student, "Name"); ?>" /></td>
						<td style="border: none;" style="border: none;">Registration Form No.</td>
						<td style="border: none;" class="ss-item-required">
                            <input type="text" class="form-control"  name="RegistrationFormNo" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="username" onblur="return check_username();" required />
                            <div id="Info"></div>
                            <span id="Loading"><img src="loader.gif" alt="" /></span>
                        </td>
					</tr>
					<tr>
                        <td style="border: none;" style="border: none;">Class</td>
                        <td style="border: none;" class="ss-item-required">
                            <select name="ClassApplied" id="ClassApplied" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" onChange="changetextbox();">
                            <?php
                                $ClassApp = odbc_exec($conn, "SELECT [Code] FROM [Class]  WHERE [Company Name]='$ms'");
                                while(odbc_fetch_array($ClassApp)){
                                    echo "<option value='".odbc_result($ClassApp, "Code")."'";
                                    if(odbc_result($ClassApp, "Code") == odbc_result($Student, "Class Applied")) echo " selected";
                                    echo ">".odbc_result($ClassApp, "Code")."</option>";
                                }
                            ?>
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Date of Sale</td>
						<td style="border: none;" class="ss-item-required">
                        <input type="text" class="form-control"  name="SaleDate" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="date1" readonly="true" required/></td>
					</tr>
					<tr>
                        <td style="border: none;" style="border: none;">Curricullum Interested</td>
                        <td style="border: none;" class="ss-item-required">
                            <select name="Curricullum" style="padding:4px;background-color: #FFFF00; border: 1px solid #c0c0c0;width: 170px" required>
                                <option value="<?php odbc_result($Student, "Curriculum Intrested") ?>"></option>
                                <?php
                                    $Curr1 = odbc_exec($conn, "SELECT [Code] FROM [Curriculum] WHERE [Company Name]='$ms'");
                                    while(odbc_fetch_array($Curr1)){
                                        echo "<option value='".odbc_result($Curr1, 'Code')."'";
                                         if(odbc_result($Curr1, 'Code') == odbc_result($Student, "Curriculum Intrested")) echo " selected";
                                          //  if(odbc_result($Student, "Curriculum Intrested") == odbc_result($Curr1, 'Code')) echo " selected";
                                        echo ">".odbc_result($Curr1, 'Code')."</option>";
                                    }
                                ?>
                            </select>
                            
                         
                            
                            
                        </td>
						<td style="border: none;" style="border: none;">EWS / RTE </td>
						<td style="border: none;" style="border: none;">
							<input type="checkbox" name="EWSStatus" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;" value="1" <?php if(odbc_result($Student, 'EWS')==1) echo ' checked'; ?> id="checkme"  />
						</td>
					</tr>
					<tr>
                        <td style="border: none;" style="border: none;">Stream</td>
                        <td style="border: none;" style="border: none;">
                            <select name="Stream" id="Stream" disabled="true" style="padding:4px; border: 1px solid #C0C0C0;width: 170px">
                                <option value="0" <?php if(odbc_result($Student, 'Stream')==0) echo ' selected'; ?> ></option>
                                <option value="1" <?php if(odbc_result($Student, 'Stream')==1) echo ' selected'; ?>>Science</option>
                                <option value="2" <?php if(odbc_result($Student, 'Stream')==2) echo ' selected'; ?>>Science Non-Medical</option>
                                <option value="3" <?php if(odbc_result($Student, 'Stream')==3) echo ' selected'; ?>>Science Medical</option>
                                <option value="4" <?php if(odbc_result($Student, 'Stream')==4) echo ' selected'; ?>>Commerce</option>
                                <option value="5" <?php if(odbc_result($Student, 'Stream')==5) echo ' selected'; ?>>Atrs</option>
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Registration Cost</td>
						<td style="border: none;" style="border: none;">
                            <input type="text" class="form-control"  name="RegistrationCost" style="text-align: right; padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px " id="RegCost" value="<?php
                                $Rcost=odbc_exec($conn, "SELECT [Amount] FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [Group Code]='REG'");
                                odbc_fetch_array($Rcost);
                                echo number_format((float)odbc_result($Rcost,"Amount"),'0','.','');
                            ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly required />
                        </td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Gender</td>
						<td style="border: none;" class="ss-item-required">
                            <select name="Gender"  style="padding:4px;background-color: #FFFF00; border: 1px solid #c0c0c0;width: 170px" required>
                                <option value=""></option>
                                <option value="1" <?php if(odbc_result($Student, "Gender")==1) echo " selected"; ?>>Boy</option>
                                <option value="2" <?php if(odbc_result($Student, "Gender")==2) echo " selected"; ?>>Girl</option>
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Mode of Payment</td>
						<td style="border: none;" style="border: none;">
							<select name="PaymentMode" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="PayMode" required>
								<option value=""></option>
                                <?php
                                    $Bal = odbc_exec($conn, "SELECT [Code] FROM [Payment Method] WHERE [Company Name]='$ms'");
                                    while(odbc_fetch_array($Bal)){
                                        echo "<option value=".odbc_result($Bal, "Code").">".odbc_result($Bal, "Code")."</option>";
                                    }
                                ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Date of Birth</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="DOB" style="padding:4px;width: 170px" value="<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>"  id="dt1" readonly="true" /></td>
						<td style="border: none;" style="border: none;">Bank Name</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="BankName" style="padding:4px;width: 170px" id="BankName"  /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Language 1</td>
						<td style="border: none;" style="border: none;">
                            <select name="Language1"  style="padding:4px; width: 170px" class="form-control" >
                                <option value=""></option>
                                <?php
                                    $Lang1a = odbc_exec($conn, "SELECT [Code] FROM [MediumofInstruction]");
                                    while(odbc_fetch_array($Lang1a)){
                                        echo "<option value='".odbc_result($Lang1a, 'Code')."'";
                                        if(odbc_result($Lang1a, 'Code') == odbc_result($Student, "Medium Of Instruction")) echo " selected";
                                        echo ">".odbc_result($Lang1a, 'Code')."</option>";
                                    }

                                ?>
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Cheque / DD No.</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="ChequeDDNo" maxlength="6" style="padding:4px;width: 170px" id="DDNo" onkeypress="return isNumber(event)" onblur="if(this.value.length < 6){alert('Cheque No. must be 6 digit ...');}" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Language 2</td>
						<td style="border: none;" style="border: none;"><select name="Language2" style="padding:4px;width: 170px" id="select1" class="form-control" >
                                <option value="0"></option>
                                <option value="1" <?php if(odbc_result($Student, "Langauge 1")==1) echo "selected";?>>Hindi</option>
                                <option value="2" <?php if(odbc_result($Student, "Langauge 1")==2) echo "selected";?>>Tamil</option>
                                <option value="3" <?php if(odbc_result($Student, "Langauge 1")==3) echo "selected";?>>Sanskrit</option>
                                <option value="4" <?php if(odbc_result($Student, "Langauge 1")==4) echo "selected";?>>Kannada</option>
                                
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Cheque / DD Date</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="ChequeDDDate" style="padding:4px;width: 170px" id="datepicker3" readonly /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Language 3</td>
						<td style="border: none;" style="border: none;">
                            <select name="Language3" style="padding:4px;width: 170px" id="select2" class="form-control" >
                                <option value=""></option>
                                <option value="1" <?php if(odbc_result($Student, "Language 2")==1) echo " selected";?>>Hindi</option>
                                <option value="2" <?php if(odbc_result($Student, "Language 2")==2) echo " selected";?>>Tamil</option>
                                <option value="4" <?php if(odbc_result($Student, "Language 2")==3) echo " selected";?>>Sanskrit</option>
                                <option value="3" <?php if(odbc_result($Student, "Language 2")==4) echo " selected";?>>Kannada</option>
                            </select>
                        </td>
						<td style="border: none;" style="border: none;">Application Status</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="ApplicationStatus" style="padding:4px;background-color: #d2d2d2;border: 1px solid #d3d3d3;width: 170px" readonly="true"  /></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane fade" id="StuTab2">
			<div class="table-responsive">
				<table border="0px" align="center"" class="table">
					<tr>
						<td style="border: none;" style="border: none;">Address of</td>
						<td style="border: none;" colspan="5">
							<select name="CommunicationReference" style="padding: 4px" class="form-control">
								<option value=""></option>
								<option value="Father" <?php if(odbc_result($Student, "Address To") =="FATHER") echo "selected" ?>>Father</option>
								<option value="Mother" <?php if(odbc_result($Student, "Address To")=="MOTHER") echo "selected" ?>>Mother</option>
								<option value="Guardian" <?php if(odbc_result($Student, "Address To")=="GUARDIAN") echo "selected" ?>>Guardian</option>
							</select>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Addressee</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="Address" size="92" value="<?php echo odbc_result($Student, "Addressee"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Address 1</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="Address1" size="92" value="<?php echo odbc_result($Student, "Address 1"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Address2</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="Address2" size="92" value="<?php echo odbc_result($Student, "Address 2"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">City</td><td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="City" id="city" style="padding: 4px;" value="<?php echo odbc_result($Student, "City"); ?>" /></td>
						<td style="border: none;" colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" class="form-control"  name="State" id="state" style="padding: 4px;" value="<?php echo odbc_result($Student, "State"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Country</td><td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="Country" id="country" style="padding: 4px;" value="<?php echo odbc_result($Student, "Country Code"); ?>" /></td>
						<td style="border: none;" colspan="2">Post Code &nbsp;&nbsp;&nbsp;<input type="text" class="form-control"  class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" name="PostCode" style="padding: 4px;" value="<?php echo odbc_result($Student, "Post Code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Phone No. (Landline)</td><td style="border: none;" style="border: none;"><input type="text" class="form-control"  name="Landline" class="isNumeric" style="padding: 4px;" value="<?php echo odbc_result($Student, "Phone Number"); ?>" /></td>
						<td style="border: none;" colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<input type="text" class="form-control"  name="Mobile" isNumeric style="padding: 4px;" value="<?php echo odbc_result($Student, "Mobile Number"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Email</td><td style="border: none;" colspan="5"><input type="text" class="form-control"  name="Email" size="92px" style="padding: 4px;" value="<?php echo odbc_result($Student, "E-Mail Address"); ?>" /></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane fade" id="StuTab3">
			<div class="table-responsive">
				<table border="0px" align="center"" class="table">
					<tr>
						<td style="border: none;" colspan="6"><h4>Father's Detail</h4></td>
					</tr>
					<td style="border: none;" style="border: none;">Name</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="FatherName" size="92" value="<?php echo odbc_result($Student, "father_s name"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Qualification</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherQualification" value="<?php echo odbc_result($Student, "father_s qualification"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 1</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOfficeAddress1" value="<?php echo odbc_result($Student, "father office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Occupation</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOccupation" value="<?php echo odbc_result($Student, "father_s occupation"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 2</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOfficeAddress2" value="<?php echo odbc_result($Student, "father office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Annual Income</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "father_s annual income"),2,'.',''); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Post Code</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "father office post code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Office City</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOfficeCity" id="city1" value="<?php echo odbc_result($Student, "father office city"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Country</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="FatherOfficeCountry" id="country1" value="<?php echo odbc_result($Student, "father office country code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" colspan="6"><h4>Mother's Detail</h4></td>
					</tr>
					<td style="border: none;" style="border: none;">Name</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="MotherName" size="92" value="<?php echo odbc_result($Student, "mother_s name"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Qualification</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherQualification" value="<?php echo odbc_result($Student, "mother_s qualification"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 1</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOfficeAddress1" value="<?php echo odbc_result($Student, "mother office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Occupation</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOccupation" value="<?php echo odbc_result($Student, "mother_s occupation"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 2</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOfficeAddress2" value="<?php echo odbc_result($Student, "mother office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Annual Income</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "father_s name"),2,'.',''); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Post Code</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "mother office post code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Office City</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOfficeCity" id="city2" value="<?php echo odbc_result($Student, "mother office city"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Country</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="MotherOfficeCountry" id="country2" value="<?php echo odbc_result($Student, "mother office country code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" colspan="6"><h4>Guardian's Detail</h4></td>
					</tr>
						<td style="border: none;" style="border: none;">Name</td>
						<td style="border: none;" colspan="5"><input type="text" class="form-control"  name="GaurdianName" size="92" value="<?php echo odbc_result($Student, "guardian name"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" colspan="1">If Guardian then please specify the relationship</td>
						<td style="border: none;" colspan="3"><input type="text" class="form-control"  name="GuardianRelationship" style="padding: 4px" value="<?php echo odbc_result($Student, "relationship with applicant"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Qualification</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianQualification" value="<?php echo odbc_result($Student, "guardian qualification"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 1</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOfficeAddress1" value="<?php echo odbc_result($Student, "guardian office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Occupation</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOccupation" value="<?php echo odbc_result($Student, "guardian occupation"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Address 2</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOfficeAddress2" value="<?php echo odbc_result($Student, "guardian office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Annual Income</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "guardian annual income"),2, '.', ''); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Post Code</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "guardian office post code"); ?>" /></td>
					</tr>
					<tr>
						<td style="border: none;" style="border: none;">Office City</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOfficeCity" id="city3" value="<?php echo odbc_result($Student, "guardian office city"); ?>" /></td>
						<td style="border: none;" style="border: none;">Office Country</td>
						<td style="border: none;" style="border: none;"><input type="text" class="form-control"  style="padding: 4px" name="GuardianOfficeCountry" id="country3" value="<?php echo odbc_result($Student, "guardian office country code"); ?>" /></td>
					</tr>
				</table>
			</div>
		</div>
		<input type="hidden" name="StuTblID" value="<?php echo $Stu[0]?>" />
		<?php
			if(odbc_result($Student, "System Genrated No_") != ""){
		?>
		<button type='submit' class='btn btn-primary' name="myButton" onclick="formcheck(); ">Register</button>
		<?php
			}
			else{
				echo "<p class='alert alert-warning'>Please wait for 2 minutes to register the candidate ...</p>";
			}
		?>
	</div>
</div></div>
</form>


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
    require_once("ValidationRegistration.php");    
	require_once("../footer.php");
?>

<!-- Registration Form No Check -->
    <script type="text/javascript">
function validate()
      {
      
         if( document.frmReg.EnquiryNo.value == "" )
         {
            alert( "Please provide Enquiry No.!" );
            document.frmReg.EnquiryNo.focus() ;
            return false;
         }
         if( document.frmReg.FinYear.value == "" )
         {
            alert( "Please provide Academic Year!" );
            document.frmReg.FinYear.focus() ;
            return false;
         }
         if( document.frmReg.Student.value == "" )
         {
            alert( "Please provide Candidate's Name!" );
            document.frmReg.Student.focus() ;
            return false;
         }
         if( document.frmReg.RegistrationFormNo.value == "" )
         {
            alert( "Please provide Registration Form No. !" );
            document.frmReg.RegistrationFormNo.focus() ;
            return false;
         }
         if( document.frmReg.ClassApplied.value == "" )
         {
            alert( "Please provide Class !" );
            document.frmReg.ClassApplied.focus() ;
            return false;
         }
         if( document.frmReg.SaleDate.value == "" )
         {
            alert( "Please provide Date of Sale !" );
            document.frmReg.SaleDate.focus() ;
            return false;
         }
         if( document.frmReg.Curricullum.value == "" )
         {
            alert( "Please provide Curriculum Interested !" );
            document.frmReg.Curricullum.focus() ;
            return false;
         }
         if( document.frmReg.RegistrationCost.value == "" )
         {
            alert( "Please provide Registration Cost !" );
            document.frmReg.RegistrationCost.focus() ;
            return false;
         }
         if( document.frmReg.RegistrationCost.value == 0  && document.frmReg.checkme.checked !="1")
         {
            alert( "Please provide Registration Cost !" );
            document.frmReg.RegistrationCost.focus() ;
            return false;
         }
         if( document.frmReg.Gender.value == "" )
         {
            alert( "Please provide Gender !" );
            document.frmReg.Gender.focus() ;
            return false;
         }
    
         if( document.frmReg.PaymentMode.value == ""  && document.frmReg.checkme.checked=="true")
         {
            alert( "Please provide Payment Mode !" );
            document.frmReg.PaymentMode.focus() ;
            return false;
         }
        
         return( true );
      }


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
   $("#date1").datepicker({minDate: "<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Enquiry Date")))?>",maxDate: 0});
    $("#dt1").datepicker({ 
        //minDate: "<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
        maxDate: 10, 
        changeMonth: true, 
        changeYear: true
    });

});

</script>
<!-- End of Registration Form No Check -->

