<?
	require_once("header.php");
	
	$EnqNo=$_REQUEST['EnquiryNo'];
	
	$Student=odbc_exec($conn, "SELECT * FROM [".$ms."Application] WHERE [Enquiry No_]='".$EnqNo."' ");
	odbc_fetch_array($Student);

	
?>

<script type="text/javascript" charset="utf-8">
    function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

	function popitup(url) {
		newwindow=window.open(url,'name','height=430,width=700');
		if (window.focus) {newwindow.focus()}
		return false;
	}
</script>
<?php echo $ErrMsg; ?>

<div class="container">	
	<h1 class="text-primary">Registration for <?=$Stu[7]?></h1>
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
						<td>Registration No</td>
						<td><input type="text" required style="padding:4px;" name="RegistrationNo" value="<?php echo odbc_result($Student, 'No_');?>" readonly="true" /></td>
						<td height="50px">Admission for Year</td>
						<td height="50px"><input type="text" name="AcadYear" style="padding: 4px" size="8" value="<?php echo odbc_result($Student, 'Academic Year'); ?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Enquiry No.</td>
						<td><input type="text" style="padding:4px;" name="EnquiryNo" value="<?php echo odbc_result($Student, 'Enquiry No_'); ?>" readonly="true" /></td>
						<td>Registration Form No.</td>
						<td><input type="text" name="RegistrationFormNo" style="padding:4px;" value="<?php echo odbc_result($Student, 'Registration No_'); ?>"  readonly="true" /></td>
					</tr>
					<tr>
						<td>Candidate's Name</td>
						<td><input type="text" style="padding:4px;" name="Student" value="<?php echo odbc_result($Student, 'Name'); ?>" readonly="true" /></td>
						<td>Date of Sale</td>
						<td><input type="text" name="SaleDate" style="padding:4px;" value="<?php echo date('d/m/Y', strtotime(odbc_result($Student, 'Date of Sale'))); ?>"   readonly="true" /></td>
					</tr>
					<tr>
						<td>Class</td>
						<td><input type="text" name="ClassApplied" style="padding:4px;" value="<?php echo odbc_result($Student, 'Class'); ?>" readonly="true" /></td>
						<td>EWS / RTE</td>
						<td>
							<input type="checkbox" name="EWSStatus" style="padding: 4px;" value="Yes" id="checkme" <? 
								if(odbc_result($Student, 'EWS')=="1") echo "checked"; ?> disabled />
						</td>
					</tr>
					<tr>
						<td>Curricullum Interested</td>
						<td><input type="text" name="Curricullum" style="padding:4px;" value="<?php echo odbc_result($Student, 'Curriculum Intrested'); ?>" readonly="true" /></td>
						<td>Registration Cost</td>
						<td><input type="text" name="RegistrationCost" style="padding:4px; text-align: right" value="<?php echo number_format((float)odbc_result($Student, 'Registration Cost'),'2','.',''); ?>"   readonly="true" /></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><input type="text" name="Gender" style="padding:4px;" value="<?php
                                    if(odbc_result($Student, 'Gender')==1) echo "BOY";
                                    if(odbc_result($Student, 'Gender')==2) echo "GIRL";
                        ?>" readonly="true" /></td>
						<td>Mode of Payment</td>
						<td><input type="text" name="PaymentMode" style="padding:4px;" value="<?php echo odbc_result($Student, 'Mode of Payment'); ?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Date of Birth</td>
						<td><input type="text" name="DOB" style="padding:4px;" value="<?php echo date('d/m/Y', strtotime(odbc_result($Student, 'Date Of Birth'))); ?>"  readonly="true" /></td>
						<td>Bank Name</td>
						<td><input type="text" name="BankName" style="padding:4px;" value="<?php echo odbc_result($Student, 'Bank Name'); ?>" readonly="true"  /></td>
					</tr>
					<tr>
						<td>Language 1</td>
						<td><input type="text" name="Language1" style="padding:4px;" value="<?php echo odbc_result($Student, 'Medium of Instruction'); ?>"  readonly="true" /></td>
						<td>Cheque / DD No.</td>
						<td><input type="text" name="ChequeDDNo" style="padding:4px;" value="<?php echo odbc_result($Student, 'Cheque _ DD No_'); ?>" readonly="true"  /></td>
					</tr>
					<tr>
						<td>Language 2</td>
						<td><input type="text" name="Language2" style="padding:4px;" value="<?php
                                    if(odbc_result($Student, 'Langauge 1')==1) echo "HINDI";
                                    if(odbc_result($Student, 'Langauge 1')==2) echo "TAMIL";
                                    if(odbc_result($Student, 'Langauge 1')==3) echo "SANSKRIT";
                                    if(odbc_result($Student, 'Langauge 1')==4) echo "KANNADA";
                                    if(odbc_result($Student, 'Langauge 1')==5) echo "FRENCH";
                            ?>" readonly="true"  /></td>
						<td>Cheque / DD Date</td>
						<td><input type="text" name="ChequeDDDate" style="padding:4px;" value="<?php echo date('d/m/Y', strtotime(odbc_result($Student, 'Cheque _ DD Date'))); ?>"  readonly="true" /></td>
					</tr>
					<tr>
						<td>Language 3</td>
						<td><input type="text" name="Language3" style="padding:4px;" value="<?php
                                    if(odbc_result($Student, 'Language 2')==1) echo "HINDI";
                                    if(odbc_result($Student, 'Language 2')==2) echo "TAMIL";
                                    if(odbc_result($Student, 'Language 2')==3) echo "SANSKRIT";
                                    if(odbc_result($Student, 'Language 2')==4) echo "KANNADA";
                                    if(odbc_result($Student, 'Language 2')==5) echo "FRENCH";
                            ?>" readonly="true"  /></td>
						<td>Application Status</td>
						<td><input type="text" name="ApplicationStatus" style="padding:4px; color: #4961E1; font-weight: bold;" readonly="true" size="15px" value="<?php
                                if(odbc_result($Student, 'Registration Status') == 1) echo "SOLD";
                                if(odbc_result($Student, 'Registration Status') == 2) echo "RECEIVED";
                                if(odbc_result($Student, 'Registration Status') == 3) echo "SELECTED";
                                if(odbc_result($Student, 'Registration Status') == 4) echo "PENDING APPROVAL";
                                if(odbc_result($Student, 'Registration Status') == 5) echo "APPROVED";
                                if(odbc_result($Student, 'Registration Status') == 6) echo "ADMITTED";
                            ?>" readonly="true" /></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="tab-pane fade" id="StuTab2">
			<div class="table-responsive">
				<table border="0px" align="center"" class="table">
					<tr>
						<td>Address of</td>
						<td colspan="5"><input type="text" name="Language3" style="padding:4px;" value="<?php echo odbc_result($Student, 'Address To');?>" readonly="true"  />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<td>Addressee</td>
						<td colspan="5"><input type="text" name="Address" size="92" value="<?php echo odbc_result($Student, 'Addressee');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Address 1</td>
						<td colspan="5"><input type="text" name="Address1" size="92" value="<?php echo odbc_result($Student, 'Address1');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Address2</td>
						<td colspan="5"><input type="text" name="Address2" size="92" value="<?php echo odbc_result($Student, 'Address 2');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>City</td><td><input type="text" name="City" style="padding: 4px;" value="<?php echo odbc_result($Student, 'City');?>" readonly="true" /></td>
						<td colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="State" style="padding: 4px;" value="<?php echo odbc_result($Student, 'State');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Country</td><td><input type="text" name="Country" style="padding: 4px;" value="<?php echo odbc_result($Student, 'Country');?>" readonly="true" /></td>
						<td colspan="2">Post Code &nbsp;&nbsp;&nbsp;<input type="text" name="PostCode" style="padding: 4px;" value="<?php echo odbc_result($Student, 'Post Code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Phone No. (Landline)</td><td><input type="text" name="Landline" style="padding: 4px;" value="<?php echo odbc_result($Student, 'Phone number');?>" readonly="true" /></td>
						<td colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<input type="text" name="Mobile" style="padding: 4px;" value="<?php echo odbc_result($Student, 'mobile number');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Email</td><td colspan="5"><input type="text" name="Email" size="92px" style="padding: 4px;" value="<?php echo odbc_result($Student, 'E-Mail Address');?>" readonly="true" /></td>
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
						<td colspan="5"><input type="text" name="FatherName" size="92" value="<?php echo odbc_result($Student, 'father_s name');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="FatherQualification" value="<?php echo odbc_result($Student, 'father_s qualification');?>" readonly="true" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeAddress1" value="<?php echo odbc_result($Student, 'father office address 1');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="FatherOccupation" value="<?php echo odbc_result($Student, 'father_s occupation');?>" readonly="true" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeAddress2" value="<?php echo odbc_result($Student, 'father office address 2');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="FatherAnnualIncome" value="<?php echo number_format((float)odbc_result($Student, 'father_s annual income'),'2','.','');?>" readonly="true" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficePostCode" value="<?php echo odbc_result($Student, 'father office post code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeCity" value="<?php echo odbc_result($Student, 'father office city');?>" readonly="true" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="FatherOfficeCountry" value="<?php echo odbc_result($Student, 'father office country code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td colspan="6"><h4>Mother's Detail</h4></td>
					</tr>
					<td>Name</td>
						<td colspan="5"><input type="text" name="MotherName" size="92" value="<?php echo odbc_result($Student, 'Mother_s Name');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="MotherQualification" value="<?php echo odbc_result($Student, 'Mother_s Qualification');?>" readonly="true" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeAddress1" value="<?php echo odbc_result($Student, 'Mother Office Address 1');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="MotherOccupation" value="<?php echo odbc_result($Student, 'Mother_s Occupation');?>" readonly="true" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeAddress2" value="<?php echo odbc_result($Student, 'Mother Office Address 2');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="MotherAnnualIncome" value="<?php echo number_format((float)odbc_result($Student, 'Mother_s Anuaal Income'),'2','.','');?>" readonly="true" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficePostCode" value="<?php echo odbc_result($Student, 'Mother Office Post Code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeCity" value="<?php echo odbc_result($Student, 'Mother Office City');?>" readonly="true" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="MotherOfficeCountry" value="<?php echo odbc_result($Student, 'Mother Office Country Code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td colspan="6"><h4>Guardian's Detail</h4></td>
					</tr>
						<td>Name</td>
						<td colspan="5"><input type="text" name="GaurdianName" size="92" value="<?php echo odbc_result($Student, 'Guardian Name');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td colspan="2">If Guardian then please specify the relationship</td>
						<td colspan="2"><input type="text" name="GuardianRelationship" style="padding: 4px" value="<?php echo odbc_result($Student, 'Applicant Relationship');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Qualification</td>
						<td><input type="text" style="padding: 4px" name="GuardianQualification" value="<?php echo odbc_result($Student, 'Guardian Qualification');?>" readonly="true" /></td>
						<td>Office Address 1</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress1" value="<?php echo odbc_result($Student, 'Guardian Office Address 1');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" style="padding: 4px" name="GuardianOccupation" value="<?php echo odbc_result($Student, 'Guardian Occupation');?>" readonly="true" /></td>
						<td>Office Address 2</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeAddress2" value="<?php echo odbc_result($Student, 'Guardian Office Address 2');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Annual Income</td>
						<td><input type="text" style="padding: 4px" name="GuardianAnnualIncome" value="<?php echo number_format((float)odbc_result($Student, 'Guardian Annual Income'),'2','.','');?>" readonly="true" /></td>
						<td>Office Post Code</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficePostCode" value="<?php echo odbc_result($Student, 'Guardian Office Post Code');?>" readonly="true" /></td>
					</tr>
					<tr>
						<td>Office City</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeCity" value="<?php echo odbc_result($Student, 'Guardian Office City');?>" readonly="true" /></td>
						<td>Office Country</td>
						<td><input type="text" style="padding: 4px" name="GuardianOfficeCountry" value="<?php echo odbc_result($Student, 'Guardian Office Country Code');?>" readonly="true" /></td>
					</tr>
				</table>
			</div>
		</div>
		<button type='button' class='btn btn-primary' onclick="PopupCenter('ReceiptRegistration.php?id=<?=$EnqNo?>','xtf','900','500');">Registation Receipt</button>
	</div>
</div></div>
<?
	require_once("../footer.php");
?>