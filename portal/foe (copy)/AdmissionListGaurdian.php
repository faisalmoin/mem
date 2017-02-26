<div class="table-responsive">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Gaurdian's Details</h3></td></tr>
		<tr>
			<td>Relationship with Student</td>
			<td><input readonly type="text" name="GaurdianRelationship" class="form-control" value="<?php echo odbc_result($rs, 'Applicant Relationship')?>" /></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>Gaurdian's Name</td>
			<td><input readonly type="text" name="GaurdianName" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Name')?>" /></td>
			<td>Gaurdian's Office Address 1</td>
			<td><input readonly type="text" name="GaurdianOfficeAddress1" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Office Address 1')?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td><input readonly type="text" name="GaurdianQualification" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Qualification')?>" /></td>
			<td>Gaurdian's Office Address 2</td>
			<td><input readonly type="text" name="GaurdianOfficeAddress2" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Office Address 2')?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td><input readonly type="text" name="GaurdianOccupation" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Occupation')?>" /></td>
			<td>Gaurdian's Office City</td>
			<td><input readonly type="text" name="GaurdianOfficeCity" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Office City')?>" /></td>
		</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td><input readonly type="text" name="GaurdianAnnualIncome" class="form-control" value="<?php echo number_format((float)odbc_result($rs, 'Guardian Annual Income'),'2','.','')?>" /></td>
			<td>Gaurdian's Office Post Code</td>
			<td><input readonly type="text" name="GaurdianOfficePostCode" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Office Post Code')?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Gaurdian's Office Country</td>
			<td><input readonly type="text" name="GaurdianOfficeCountry" class="form-control" value="<?php echo odbc_result($rs, 'Guardian Country Code')?>" /></td>
		</tr>
	</table>
</div>