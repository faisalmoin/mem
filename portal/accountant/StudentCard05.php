<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="table-responsive">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Father's Details</h3></td></tr>
		<tr>
			<td>Father's Name</td>
                        <td><input style="background-color: #FFFF00;" type="text" readonly="true" id='pFName' class="form-control" value="<?php echo odbc_result($row,  'Father_s Name')?>" /></td>
			<td>Father's Office Address 1</td>
			<td><input type="text" name="FatherOfficeAddress1" class="form-control" value="<?php echo odbc_result($row,  'Father Office Address 1')?>" /></td>
		</tr>
		<tr>
			<td>Father's Qualification</td>
			<td><input type="text"  readonly="true" id='pFQual' class="form-control" value="<?php echo odbc_result($row,  'Father_s Qualification')?>" /></td>
			<td>Father's Office Address 2</td>
			<td><input type="text" name="FatherOfficeAddress2" class="form-control" value="<?php echo odbc_result($row,  'Father Office Address 2')?>" /></td>
		</tr>
		<tr>
			<td>Father's Occupation</td>
			<td><input style="background-color: #FFFF00;" type="text"  readonly="true" id='pFOcc' class="form-control" value="<?php echo odbc_result($row,  'Father_s Occupation')?>" /></td>
			<td>Father's Office City</td>
			<td><input type="text" name="FatherOfficeCity" class="form-control" value="<?php echo odbc_result($row,  'Father Office City')?>" /></td>
		</tr>
		<tr>
			<td>Father's Annual Income</td>
			<td><input type="text"  readonly="true" id='pFAI' class="form-control" value="<?php echo number_format((float)odbc_result($row,  'Father_s Annual Income'),'2','.','')?>" /></td>
			<td>Father's Office Post Code</td>
			<td><input type="text" name="FatherOfficePostCode" class="form-control" value="<?php echo odbc_result($row,  'Father Post Code')?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Father's Office Country</td>
			<td><input type="text" name="FatherOfficeCountry" class="form-control" value="<?php echo odbc_result($row,  'Father Office Country Code')?>" /></td>
		</tr>
		<tr><td colspan="4"><h3 class="text-primary">Mother's Details</h3></td></tr>
		<tr>
			<td>Mother's Name</td>
			<td><input style="background-color: #FFFF00;" type="text"  readonly="true" id='pMName'  class="form-control" value="<?php echo odbc_result($row,  'Mother_s Name')?>" /></td>
			<td>Mother's Office Address 1</td>
			<td><input type="text" name="MotherOfficeAddress1" class="form-control" value="<?php echo odbc_result($row,  'Mother Office Address 1')?>" /></td>
		</tr>
		<tr>
			<td>Mother's Qualification</td>
                        <td><input type="text" readonly="true" class="form-control" value="<?php echo odbc_result($row,  'Mother_s Qualification')?>" id="pMQual" /></td>
			<td>Mother's Office Address 2</td>
			<td><input type="text" name="MotherOfficeAddress2" class="form-control" value="<?php echo odbc_result($row,  'Mother Office Address 2')?>" /></td>
		</tr>
		<tr>
			<td>Mother's Occupation</td>
			<td><input style="background-color: #FFFF00;" type="text"  readonly="true" id='pMOcc'  class="form-control" value="<?php echo odbc_result($row,  'Mother_s Occupation')?>" /></td>
			<td>Mother's Office City</td>
			<td><input type="text" name="MotherOfficeCity" class="form-control" value="<?php echo odbc_result($row,  'Mother Office City')?>" /></td>
		</tr>
		<tr>
			<td>Mother's Annual Income</td>
			<td><input type="text"  readonly="true" id='pMAI'  class="form-control" value="<?php echo number_format((float)odbc_result($row,  'Mother_s Annual Income'),'2','.','')?>" /></td>
			<td>Mother's Office Post Code</td>
			<td><input type="text" name="MotherOfficePostCode" class="form-control" value="<?php echo odbc_result($row,  'Mother Office Post Code')?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Mother's Office Country</td>
			<td><input type="text" name="MotherOfficeCountry" class="form-control" value="<?php echo odbc_result($row,  'Mother Office Country Code')?>" /></td>
		</tr>
                <tr><td colspan="4"><h3 class="text-primary">Gaurdian's Details</h3></td></tr>
		<tr>
			<td>Relationship with Student</td>
			<td>
                                                                    <select name="GuardianRelationship" style="padding: 4px" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="BROTHER"  <?php if (odbc_result($row,  "Applicant Relationship") == "BROTHER") echo " selected";?>>Brother</option>
                                                                            <option value="BROTHER-IN-LAW"  <?php if (odbc_result($row,  "Applicant Relationship") == "BROTHER-IN-LAW") echo " selected";?>>Brother-in-Law</option>
                                                                            <option value="GRANDFATHER"  <?php if (odbc_result($row,  "Applicant Relationship") == "GRANDFATHER") echo " selected";?>>Grandfather</option>
                                                                            <option value="GRANDMOTHER"  <?php if (odbc_result($row,  "Applicant Relationship") == "GRANDMOTHER") echo " selected";?>>Grandmother</option>
                                                                            <option value="FATHER-IN-LAW"  <?php if (odbc_result($row,  "Applicant Relationship") == "FATHER-IN-LAW") echo " selected";?>>Father-in-Law</option>
                                                                            <option value="MOTHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "MOTHER-IN-LAW") echo " selected";?>>Mother-in-Law</option>
                                                                            <option value="SISTER"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER") echo " selected";?>>Sister</option>
                                                                            <option value="SISTER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER-IN-LAW") echo " selected";?>>Sister-in-Law</option>
                                                                    </select>
                        </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>Gaurdian's Name</td>
			<td><input type="text"  readonly="true" id='pGName' class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Name");?>" /></td>
			<td>Gaurdian's Office Address 1</td>
			<td><input type="text" name="GaurdianOfficeAddress1" class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Office Address1");?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td><input type="text"  readonly="true" id='pGQual' class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Qualification");?>" /></td>
			<td>Gaurdian's Office Address 2</td>
			<td><input type="text" name="GaurdianOfficeAddress2" class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Office Address2");?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td><input type="text"  readonly="true" id='pGOcc' class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Occupation");?>" /></td>
			<td>Gaurdian's Office City</td>
			<td><input type="text" name="GaurdianOfficeCity" class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Office City");?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td><input type="text"  readonly="true" id='pGAI' class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Annual Income");?>" /></td>
			<td>Gaurdian's Office Post Code</td>
			<td><input type="text" name="GaurdianOfficePostCode" class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Office Post Code");?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Gaurdian's Office Country</td>
                        <td><input type="text" name="GaurdianOfficeCountry" class="form-control" value="<?php echo odbc_result($row,  "Gaurdian Office Country");?>" /></td>
		</tr>
	</table>
</div>
