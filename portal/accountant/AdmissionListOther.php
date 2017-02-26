<div class="table-responsive" style="width:40%;">
	<table class="table">
		<tr>
			<td>Food Habits</td>
			<td><input readonly type="text" name="FoodHabits" value="<?=$row['FoodHabits']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Quota</td>
			<td><input readonly type="text" name="Quota" value="<?=$row['Quota']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Physically Challanged</td>
			<td><input readonly type="checkbox" name="PhysicallyChallenged" value="Yes" <? if($row['PhysicallyChallenged']=="Yes") echo "checked"; ?> /></td>
		</tr>
		<tr>
			<td>Staff Child</td>
			<td><input readonly type="checkbox" name="StaffChild" value="Yes" <? if($row['StaffChild']=="Yes") echo "checked"; ?>  /></td>
		</tr>
		<tr>
			<td>Staff Code</td>
			<td>
                <input readonly type="text"  value="<?=$row['StaffCode']?>"  />
            </td>
		</tr>
		<tr>
			<td>Height</td>
			<td><input readonly type="text" name="Height" value="<?=$row['Height']?>" class="form-control" /></td>
		</tr>
		<tr>
			<td>Weight</td>
			<td><input readonly type="text" name="Weight" value="<?=$row['Weight']?>" class="form-control" /></td>
		</tr>
	</table>
</div>