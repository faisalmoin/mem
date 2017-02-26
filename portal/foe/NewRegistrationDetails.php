<?php
	require_once("header.php");
	require_once("ValidationRegistration.php");
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
    <br /><br />
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
   $("#date1").datepicker({ minDate: 0,});
	$("#dt1").datepicker({ 
		minDate: "<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
		maxDate: 0, 
		changeMonth: true, 
		changeYear: true
	});

});

</script>
<!-- End of Registration Form No Check -->

<?php echo $ErrMsg; ?>
<form method="POST" action="AddRegistration.php" name="frmReg" id="frmReg"  enctype="multipart/form-data" onsubmit="return(validate());"  onkeypress="return event.keyCode != 13;">
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
                        <td>Enquiry No.</td>
                        <td class="ss-item-required">
				<input type="text" name="SystemGenratedNo" style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;width: 170px" value="<?php echo odbc_result($Student, "System Genrated No_")?>" readonly="true" />
				<input type="hidden" style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;" name="EnquiryNo" value="<?php echo odbc_result($Student, "No_")?>" readonly="true" />
			</td>
						<td height="50px">Admission for Year</td>
						<td height="50px" class="ss-item-required">
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
                        <td>Candidate's Name</td>
                        <td class="ss-item-required"><input type="text" style="padding:4px;background-color:#FFFF00; border: 1px solid #c0c0c0;width: 170px" name="Student" value="<?php echo odbc_result($Student, "Name"); ?>" /></td>
						<td>Registration Form No.</td>
						<td class="ss-item-required">
                            <input type="text" name="RegistrationFormNo" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="username" onblur="return check_username();" required />
                            <div id="Info"></div>
                            <span id="Loading"><img src="loader.gif" alt="" /></span>
                        </td>
					</tr>
					<tr>
                        <td>Class</td>
                        <td class="ss-item-required">
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
						<td>Date of Sale</td>
						<td class="ss-item-required"><input type="text" name="SaleDate" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="date1" readonly="true" required/></td>
					</tr>
					<tr>
                        <td>Curricullum Interested</td>
                        <td class="ss-item-required">
                            <select name="Curricullum" style="padding:4px;background-color: #FFFF00; border: 1px solid #c0c0c0;width: 170px" required>
                                <option value=""></option>
                                <?php
                                    $Curr1 = odbc_exec($conn, "SELECT [Code] FROM [Curriculum] WHERE [Company Name]='$ms'");
                                    while(odbc_fetch_array($Curr1)){
                                        echo "<option value='".odbc_result($Curr1, 'Code')."'";
                                            if(odbc_result($Student, "Curriculum Intrested") == odbc_result($Curr1, 'Code')) echo " selected";
                                        echo ">".odbc_result($Curr1, 'Code')."</option>";
                                    }
                                ?>
                            </select>
                        </td>
						<td>EWS / RTE </td>
						<td>
							<input type="checkbox" name="EWSStatus" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;" value="1" <?php if(odbc_result($Student, 'EWS')==1) echo ' checked'; ?> id="checkme"  />
						</td>
					</tr>
					<tr>
                        <td>Stream</td>
                        <td>
                            <select name="Stream" id="Stream" disabled="true" style="padding:4px; border: 1px solid #C0C0C0;width: 170px">
                                <option value="0" <?php if(odbc_result($Student, 'Stream')==0) echo ' selected'; ?> ></option>
                                <option value="1" <?php if(odbc_result($Student, 'Stream')==1) echo ' selected'; ?>>Science</option>
                                <option value="2" <?php if(odbc_result($Student, 'Stream')==2) echo ' selected'; ?>>Science Non-Medical</option>
                                <option value="3" <?php if(odbc_result($Student, 'Stream')==3) echo ' selected'; ?>>Science Medical</option>
                                <option value="4" <?php if(odbc_result($Student, 'Stream')==4) echo ' selected'; ?>>Commerce</option>
                                <option value="5" <?php if(odbc_result($Student, 'Stream')==5) echo ' selected'; ?>>Atrs</option>
                            </select>
                        </td>
						<td>Registration Cost</td>
						<td>
                            <input type="text" name="RegistrationCost" style="text-align: right; padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px " id="RegCost" value="<?php
                                $Rcost=odbc_exec($conn, "SELECT [Amount] FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [Group Code]='REG'");
                                odbc_fetch_array($Rcost);
                                echo number_format((float)odbc_result($Rcost,"Amount"),'0','.','');
                            ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly required />
                        </td>
					</tr>
					<tr>
						<td>Gender</td>
						<td class="ss-item-required">
                            <select name="Gender"  style="padding:4px;background-color: #FFFF00; border: 1px solid #c0c0c0;width: 170px" required>
                                <option value=""></option>
                                <option value="1" <?php if(odbc_result($Student, "Gender")==1) echo " selected"; ?>>Boy</option>
                                <option value="2" <?php if(odbc_result($Student, "Gender")==2) echo " selected"; ?>>Girl</option>
                            </select>
                        </td>
						<td>Mode of Payment</td>
						<td>
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
						<td>Date of Birth</td>
						<td><input type="text" name="DOB" style="padding:4px;width: 170px" value="<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>"  id="dt1" readonly="true" /></td>
						<td>Bank Name</td>
						<td><input type="text" name="BankName" style="padding:4px;width: 170px" id="BankName"  /></td>
					</tr>
					<tr>
						<td>Language 1</td>
						<td>
                            <select name="Language1"  style="padding:4px; width: 170px">
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
						<td>Cheque / DD No.</td>
						<td><input type="text" name="ChequeDDNo" maxlength="6" style="padding:4px;width: 170px" id="DDNo" onkeypress="return isNumber(event)" onblur="if(this.value.length < 6){alert('Cheque No. must be 6 digit ...');}" /></td>
					</tr>
					<tr>
						<td>Language 2</td>
						<td><select name="Language2" style="padding:4px;width: 170px" id="select1">
                                <option value="0"></option>
                                <option value="1" <?php if(odbc_result($Student, "Langauge 1")==1) echo "selected";?>>Hindi</option>
                                <option value="2" <?php if(odbc_result($Student, "Langauge 1")==2) echo "selected";?>>Tamil</option>
                                <option value="3" <?php if(odbc_result($Student, "Langauge 1")==3) echo "selected";?>>Sanskrit</option>
                                <option value="4" <?php if(odbc_result($Student, "Langauge 1")==4) echo "selected";?>>Kannada</option>
                                
                            </select>
                        </td>
						<td>Cheque / DD Date</td>
						<td><input type="text" name="ChequeDDDate" style="padding:4px;width: 170px" id="datepicker3" readonly /></td>
					</tr>
					<tr>
						<td>Language 3</td>
						<td>
                            <select name="Language3" style="padding:4px;width: 170px" id="select2">
                                <option value=""></option>
                                <option value="1" <?php if(odbc_result($Student, "Language 2")==1) echo " selected";?>>Hindi</option>
                                <option value="2" <?php if(odbc_result($Student, "Language 2")==2) echo " selected";?>>Tamil</option>
                                <option value="4" <?php if(odbc_result($Student, "Language 2")==3) echo " selected";?>>Sanskrit</option>
                                <option value="3" <?php if(odbc_result($Student, "Language 2")==4) echo " selected";?>>Kannada</option>
                            </select>
                        </td>
						<td>Application Status</td>
						<td><input type="text" name="ApplicationStatus" style="padding:4px;background-color: #d2d2d2;border: 1px solid #d3d3d3;width: 170px" readonly="true"  /></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane fade" id="StuTab2">
			<div class="table-responsive">
				<table border="0px" align="center"" class="table">
					<tr>
						<td>Address of</td>
						<td colspan="5">
							<select name="CommunicationReference" style="padding: 4px">
								<option value=""></option>
								<option value="Father" <?php if(odbc_result($Student, "Address To") =="FATHER") echo "selected" ?>>Father</option>
								<option value="Mother" <?php if(odbc_result($Student, "Address To")=="MOTHER") echo "selected" ?>>Mother</option>
								<option value="Guardian" <?php if(odbc_result($Student, "Address To")=="GUARDIAN") echo "selected" ?>>Guardian</option>
							</select>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td>Addressee</td>
						<td colspan="5"><input type="text" name="Address" size="92" value="<?php echo odbc_result($Student, "Addressee"); ?>" /></td>
					</tr>
					<tr>
						<td>Address 1</td>
						<td colspan="5"><input type="text" name="Address1" size="92" value="<?php echo odbc_result($Student, "Address 1"); ?>" /></td>
					</tr>
					<tr>
						<td>Address2</td>
						<td colspan="5"><input type="text" name="Address2" size="92" value="<?php echo odbc_result($Student, "Address 2"); ?>" /></td>
					</tr>
					<tr>
						<td>City</td><td><input type="text" name="City" id="city" style="padding: 4px;" value="<?php echo odbc_result($Student, "City"); ?>" /></td>
						<td colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="State" id="state" style="padding: 4px;" value="<?php echo odbc_result($Student, "State"); ?>" /></td>
					</tr>
					<tr>
						<td>Country</td><td><input type="text" name="Country" id="country" style="padding: 4px;" value="<?php echo odbc_result($Student, "Country Code"); ?>" /></td>
						<td colspan="2">Post Code &nbsp;&nbsp;&nbsp;<input type="text" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');this.focus();}" name="PostCode" style="padding: 4px;" value="<?php echo odbc_result($Student, "Post Code"); ?>" /></td>
					</tr>
					<tr>
						<td>Phone No. (Landline)</td><td><input type="text" name="Landline" class="isNumeric" style="padding: 4px;" value="<?php echo odbc_result($Student, "Phone Number"); ?>" /></td>
						<td colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<input type="text" name="Mobile" isNumeric style="padding: 4px;" value="<?php echo odbc_result($Student, "Mobile Number"); ?>" /></td>
					</tr>
					<tr>
						<td>Email</td><td colspan="5"><input type="text" name="Email" size="92px" style="padding: 4px;" value="<?php echo odbc_result($Student, "E-Mail Address"); ?>" /></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane fade" id="StuTab3">
			<div class="table-responsive">
				<table border="0px" align="center"" class="table">
					<tr>
						<td colspan="6"><h4>Father's Detail</h4></td>
					</tr>
					<td>Name</td>
						<td colspan="5"><input type="text" name="FatherName" size="92" value="<?php echo odbc_result($Student, "father_s name"); ?>" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="FatherQualification" value="<?php echo odbc_result($Student, "father_s qualification"); ?>" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeAddress1" value="<?php echo odbc_result($Student, "father office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="FatherOccupation" value="<?php echo odbc_result($Student, "father_s occupation"); ?>" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeAddress2" value="<?php echo odbc_result($Student, "father office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="FatherAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "father_s annual income"),2,'.',''); ?>" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "father office post code"); ?>" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeCity" id="city1" value="<?php echo odbc_result($Student, "father office city"); ?>" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeCountry" id="country1" value="<?php echo odbc_result($Student, "father office country code"); ?>" /></td>
					</tr>
					<tr>
						<td colspan="6"><h4>Mother's Detail</h4></td>
					</tr>
					<td>Name</td>
						<td colspan="5"><input type="text" name="MotherName" size="92" value="<?php echo odbc_result($Student, "mother_s name"); ?>" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="MotherQualification" value="<?php echo odbc_result($Student, "mother_s qualification"); ?>" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeAddress1" value="<?php echo odbc_result($Student, "mother office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="MotherOccupation" value="<?php echo odbc_result($Student, "mother_s occupation"); ?>" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeAddress2" value="<?php echo odbc_result($Student, "mother office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="MotherAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "father_s name"),2,'.',''); ?>" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "mother office post code"); ?>" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeCity" id="city2" value="<?php echo odbc_result($Student, "mother office city"); ?>" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeCountry" id="country2" value="<?php echo odbc_result($Student, "mother office country code"); ?>" /></td>
					</tr>
					<tr>
						<td colspan="6"><h4>Guardian's Detail</h4></td>
					</tr>
						<td>Name</td>
						<td colspan="5"><input type="text" name="GaurdianName" size="92" value="<?php echo odbc_result($Student, "guardian name"); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">If Guardian then please specify the relationship</td>
						<td colspan="2"><input type="text" name="GuardianRelationship" style="padding: 4px" value="<?php echo odbc_result($Student, "relationship with applicant"); ?>" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="GuardianQualification" value="<?php echo odbc_result($Student, "guardian qualification"); ?>" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress1" value="<?php echo odbc_result($Student, "guardian office address 1"); ?>" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="GuardianOccupation" value="<?php echo odbc_result($Student, "guardian occupation"); ?>" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress2" value="<?php echo odbc_result($Student, "guardian office address 2"); ?>" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="GuardianAnnualIncome" class="isNumeric" value="<?php echo number_format((float)odbc_result($Student, "guardian annual income"),2, '.', ''); ?>" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficePostCode" class="isNumeric" maxlength="6" value="<?php echo odbc_result($Student, "guardian office post code"); ?>" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeCity" id="city3" value="<?php echo odbc_result($Student, "guardian office city"); ?>" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeCountry" id="country3" value="<?php echo odbc_result($Student, "guardian office country code"); ?>" /></td>
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
<?php
	require_once("../footer.php");
?>