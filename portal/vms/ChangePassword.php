<?php
	require_once("Header1.php");
	
?>
	</br></br>
	<div class="container" >
		<center>
			<form name="form" action="ChangePasswordUpdate.php" method="POST" >
			<fieldset style="width: 40%">
				<legend style="color: #0088ff;">Change Password</legend>
				<table width="100%" style="font-size: 12px;" >
					<input type="hidden" name="id" value="<?=$LoginID?>" />
					<tr>
						<td align="right" height="40px">Current Password:</td>
						<td><input type="password" name="oldPassword" size="32" required />
					</tr>
					<tr>
						<td align="right" height="40px">New Password:</td>
						<td><input type="password" name="newPassword" size="32" required />
					</tr>
					<tr>
						<td align="right" height="40px">Re-type Password:</td>
						<td><input type="password" name="retPassword" size="32" required />
					</tr>
					<tr>
						<td align="right"></td>
						<td><input type="submit" value="Change" class="btn btn-primary" />
					</tr>	
				</table>
			</fieldset>
			</form>
		</center>
	</div>

