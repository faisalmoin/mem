<div class="table-responsive">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Gaurdian's Details</h3></td></tr>
		<tr>
			<td>Relationship with Student</td>
			<td>
               <select name="GuardianRelationship" style="padding: 4px" class="form-control">
               <option value=""></option>
                <option value="BROTHER"  <?php if (odbc_result($rs, "Applicant Relationship") == "BROTHER") echo " selected";?>>Brother</option>
                <option value="BROTHER-IN-LAW"  <?php if (odbc_result($rs, "Applicant Relationship") == "BROTHER-IN-LAW") echo " selected";?>>Brother-in-Law</option>
                <option value="GRANDFATHER"  <?php if (odbc_result($rs, "Applicant Relationship") == "GRANDFATHER") echo " selected";?>>Grandfather</option>
                  <option value="GRANDMOTHER"  <?php if (odbc_result($rs, "Applicant Relationship") == "GRANDMOTHER") echo " selected";?>>Grandmother</option>
                <option value="FATHER-IN-LAW"  <?php if (odbc_result($rs, "Applicant Relationship") == "FATHER-IN-LAW") echo " selected";?>>Father-in-Law</option>
                <option value="MOTHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "MOTHER-IN-LAW") echo " selected";?>>Mother-in-Law</option>
                <option value="SISTER"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER") echo " selected";?>>Sister</option>
                 <option value="SISTER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER-IN-LAW") echo " selected";?>>Sister-in-Law</option>
                 </select>
                 </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>Gaurdian's Name</td>
			<td><input type="text" maxlength="30"  readonly="true" id='pGName' class="form-control" value="<?php echo odbc_result($rs, "Guardian Name");?>" /></td>
			<td>Gaurdian's Office Address 1</td>
			<td><input type="text" maxlength="50" name="GaurdianOfficeAddress1" class="form-control" value="<?php echo odbc_result($rs, "Guardian Office Address 1");?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td><input type="text" maxlength="30"  readonly="true" id='pGQual' class="form-control" value="<?php echo odbc_result($rs, "Guardian Qualification");?>" /></td>
			<td>Gaurdian's Office Address 2</td>
			<td><input type="text" maxlength="50" name="GaurdianOfficeAddress2" class="form-control" value="<?php echo odbc_result($rs, "Guardian Office Address 2");?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td><input type="text" maxlength="30"  readonly="true" id='pGOcc' class="form-control" value="<?php echo odbc_result($rs, "Guardian Occupation");?>" /></td>
			<td>Gaurdian's Office Post Code</td>
			<td><input type="text" maxlength="6" name="GaurdianOfficePostCode" class="form-control" value="<?php echo odbc_result($rs, "Guardian Office Post Code");?>" /></td>
		
			
			</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td><input type="text" maxlength="10"  readonly="true" id='pGAI' class="form-control" value="<?php echo number_format((float)odbc_result($rs, "Guardian Annual Income"),'2','.','');?>" /></td>
			<td>Gaurdian's Office Country</td>
            <td><input type="text" maxlength="10" name="GaurdianOfficeCountry" class="form-control" value="<?php echo odbc_result($rs, "Guardian Office Country Code");?>" /></td>
		   </tr>
		<tr>
			<td></td>
			<td></td>
			<td>Gaurdian's Office City</td>
			<td><input type="text" maxlength="30" name="GaurdianOfficeCity" class="form-control" value="<?php echo odbc_result($rs, "Guardian Office City");?>" /></td>
		
		</tr>
	</table>
</div>