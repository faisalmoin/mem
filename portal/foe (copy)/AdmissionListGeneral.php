<div class="table-responsive">
	<table class="table">
		<tr>
			<td>Registration No.</td>
			<td><input readonly type="text" value="<?=$row['RegistrationNo']?>" class="form-control" name="RegistrationNo" readonly="true" required /></td>
			<td>Medium of Instruction</td>
			<td><input readonly type="text" value="<?=$row['MediumInstruction']?>" class="form-control" name="MediumInstruction" required /></td>
		</tr>
		<tr>
			<td>Student Name</td>
			<td><input readonly type="text" value="<?=$row['StudentName']?>" class="form-control" name="StudentName" required /></td>
			<td>Hostel Accomodation</td>
			<td><input readonly type="checkbox" value="Yes" name="HostelAccomodation" <? if($row['HostelAccomodation'] == "Yes") echo "checked"?> /></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td><input readonly type="text" value="<?=$row['Gender']?>" class="form-control" name="Gender" required /></td>
			<td>Registration Status</td>
			<td><input readonly type="text" value="<?=$row['RegistrationStatus']?>" class="form-control" readonly="true" name="RegistrationStatus" required /></td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><input readonly type="text" value="<?=$row['DOB']?>" class="form-control" name="DOB" readonly="true" required /></td>
			<td>Registration No</td>
			<td><input readonly type="text" value="<?=$row['RegistrationNo']?>" class="form-control" readonly="true" name="RegistrationFormNo" required /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Admission for Year</td>
			<td><input readonly type="text" value="<?=$row['AdmissionYear']?>" class="form-control" name="AdmissionYear" required /></td>
		</tr>
		<tr>
			<td>Class</td>
			<td><input readonly type="text" value="<?=$row['Class']?>" class="form-control" name="Class" required /></td>
		</tr>
		<tr>
			<td>Section</td>
			<td><input readonly type="text" value="<?=$row['Section']?>" class="form-control" name="Section" required /></td>
		</tr>
		<tr>
			<td>Curriculum Interested</td>
			<td><input readonly type="text" value="<?=$row['CurriculumInterested']?>" class="form-control" name="CurriculumInterested" required /></td>
			<td>Language 2</td>
			<td><input readonly type="text" value="<?=$row['Language2']?>" class="form-control" name="Language2" required /></td>
		</tr>
		<tr>
			<td>Citizenship</td>
			<td><input readonly type="text" value="<?=$row['Citizenship']?>" class="form-control" name="Citizenship" required /></td>
			<td>Language 3</td>
			<td><input readonly type="text" value="<?=$row['Language3']?>" class="form-control" name="Language3" required /></td>
		</tr>
		<tr>
			<td>Fee Classification</td>
			<td><input readonly type="text" value="<?=$row['FeeClassification']?>" class="form-control" name="FeeClassification" required /></td>
			<td>Remarks</td>
			<td><input readonly type="text" value="<?=$row['Remarks']?>" class="form-control" name="Remarks" required /></td>
		</tr>
		<tr>
			<td></td><td></td>
			<td>Admission Date</td>
			<td><input readonly type="text" value="<?=$row['AdmissionDate']?>" class="form-control" name="AdmissionDate" required /></td>
		</tr>
	</table>
</div>