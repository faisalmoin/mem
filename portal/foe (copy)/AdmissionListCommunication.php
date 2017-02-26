<div class="table-responsive" style="width: 40%">
	<table class="table">
		<tr>
			<td>Address To</td>
			<td>
				<select readonly name="CommunicationReference" class="form-control" required>
					<option value=""></option>
					<option value="Father" <? if($row['CommunicationReference']=="Father") echo "Selected"; ?>>Father</option>
					<option value="Mother"<? if($row['CommunicationReference']=="Mother") echo "Selected"; ?>>Mother</option>
					<option value="Guardian"<? if($row['CommunicationReference']=="Guardian") echo "Selected"; ?>>Gaurdian</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Contact Name</td>
			<td><input readonly type="text" name="ContactName" value="<?
				if($row['CommunicationReference']=="Father") echo $row['FatherName'];
				if($row['CommunicationReference']=="Mother") echo $row['MotherName'];
				if($row['CommunicationReference']=="Gaurdian") echo $row['GaurdianName'];
			?>" class="form-control" required />
			</td>
		</tr>
		<tr>
			<td>Address 1</td>
			<td><input readonly type="text" name="Address1" value="<?=$row['Address1']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Address 2</td>
			<td><input readonly type="text" name="Address2" value="<?=$row['Address2']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>City</td>
			<td><input readonly type="text" name="City" value="<?=$row['City']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Post Code</td>
			<td><input readonly type="text" name="PostCode" value="<?=$row['PostCode']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>State</td>
			<td><input readonly type="text" name="State" value="<?=$row['State']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Country</td>
			<td><input readonly type="text" name="Country" value="<?=$row['Country']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Phone No</td>
			<td><input readonly type="text" name="PhoneNo" value="<?=$row['PhoneNo']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mobile</td>
			<td><input readonly type="text" name="MobileNo" value="<?=$row['MobileNo']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>E-Mail Address</td>
			<td><input readonly type="email" name="Email" value="<?=$row['Email']?>" class="form-control" required /></td>
		</tr>
		<tr>
			<td>Father Email</td>
			<td><input readonly type="email" name="FatherEmail" value="<?=$row['FatherEmail']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Mother Email</td>
			<td><input readonly type="email" name="MotherEmail" value="<?=$row['MotherEmail']?>" class="form-control" /></td>
		</tr>
	</table>
</div>