<div class="table-responsive">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Parents Details</h3></td></td></tr>
                <tr><td colspan="4"><h4 class="text-primary">Father's Details</h4></td></td></tr>
		<tr>
			<td>Father's Name</td>
			<td><input style="background-color: #FFFF00" type="text" maxlength="50" name="FatherName" onchange="document.getElementById('pFName').value=this.value;" class="form-control" value="<?php echo odbc_result($rs, 'Father_s Name'); ?>" /></td>
			<td>Religion</td>
                        <td><input type="text"name="Religion" maxlength="20" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father's Qualification</td>
			<td><input type="text" name="FatherQualification" maxlength="20" onchange="document.getElementById('pFQual').value=this.value;" class="form-control" value="<?php echo odbc_result($rs, 'Father_s Qualification'); ?>" /></td>
			<td>Caste</td>
			<td><input type="text"name="Caste" maxlength="20" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father's Occupation</td>
			<td><input style="background-color: #FFFF00" maxlength="20" type="text" name="FatherOccupation" onchange="document.getElementById('pFOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Father_s Occupation'); ?>" /></td>
			<td>Community</td>
			<td><input type="text"name="Community" maxlength="10" class="form-control" /></td>
		</tr>
		<tr>
			<td>Father's Annual Income</td>
			<td><input type="text" maxlength="10" name="FatherAnnualIncome" onchange="document.getElementById('pFAI').value=this.value;" onclick="javascript:if(this.value==0){this.value='';}" onblur="javascript: if(this.value==''){this.value='0.00'}" class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Father_s Annual Income'),'2','.',''); ?>" /></td>
			<td>Mother Tongue</td>
			<td><input type="text" maxlength="10" name="MotherTongue" class="form-control" /></td>
		</tr>
                <tr><td colspan="4"><h4 class="text-primary">Mother's Details</h4></td></td></tr>
		<tr>
			<td>Mother's Name</td>
			<td><input style="background-color: #FFFF00" type="text" maxlength="50" name="MotherName" onchange="document.getElementById('pMName').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Name'); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Qualification</td>
                        <td><input type="text" name="MotherQualification" maxlength="20" class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Qualification'); ?>" onchange="document.getElementById('pMQual').value=this.value;" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Occupation</td>
			<td><input style="background-color: #FFFF00" maxlength="20" type="text" name="MotherOccupation" onchange="document.getElementById('pMOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Mother_s Occupation'); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Annual Income</td>
			<td><input type="text" name="MotherAnnualIncome" maxlength="10" onchange="document.getElementById('pMAI').value=this.value;" onclick="javascript:if(this.value==0){this.value='';}" onblur="javascript: if(this.value==''){this.value='0.00'}"  class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Mother_s Annual Income'),'2','.',''); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
                <tr><td colspan="4"><h4 class="text-primary">Guardian's Details</h4></td></td></tr>
		<tr>
			<td>Guardian's Name</td>
			<td><input type="text" name="GaurdianName" maxlength="50" onchange="document.getElementById('pGName').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Guardian Name'); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td><input type="text" name="GaurdianQualification" maxlength="20" onchange="document.getElementById('pGQual').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Guardian Qualification'); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td><input type="text" name="GaurdianOccupation" maxlength="20" onchange="document.getElementById('pGOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($rs, 'Guardian Occupation'); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td><input type="text" name="GaurdianAnnualIncome" maxlength="10" onchange="document.getElementById('pGAI').value=this.value;" onclick="javascript:if(this.value==0){this.value='';}" onblur="javascript: if(this.value==''){this.value='0.00'}"  class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Guardian Annual Income'),'2','.',''); ?>" /></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>