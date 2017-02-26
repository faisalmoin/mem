<?php
	require_once("header.php");
	
?>
	<script>
		 function checkPass()
		{
			//Store the password field objects into variables ...
			var pass1 = document.getElementById('newPassword');
			var pass2 = document.getElementById('retPassword');
			//Store the Confimation Message Object ...
			var message = document.getElementById('confirmMessage');
			//Set the colors we will be using ...
			var goodColor = "#66cc66";
			var badColor = "#ff6666";
			//Compare the values in the password field 
			//and the confirmation field
			if(pass1.value == pass2.value){
				//The passwords match. 
				//Set the color to the good color and inform
				//the user that they have entered the correct password 
				pass2.style.backgroundColor = goodColor;
				message.style.color = goodColor;
				message.innerHTML = "Passwords Match!";
				document.getElementById("submit").disabled = false;
			}else{
				//The passwords do not match.
				//Set the color to the bad color and
				//notify the user.
				pass2.style.backgroundColor = badColor;
				message.style.color = badColor;
				message.innerHTML = "Passwords Do Not Match!";
				document.getElementById("submit").disabled = true;
			}
		}  
	</script>
	<br /><br /><br /><br />
		<center>
			<form name="form" action="ChangePassword.Update.php" method="POST"  onkeypress="return event.keyCode != 13;">
			<fieldset style="width: 40%">
				<legend style="color: #0088ff;">Change Password</legend>
				<table width="100%" style="font-size: 12px;">
					<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
					<tr>
						<td align="right" height="40px">New Password</td>
						<td><input type="password" name="newPassword" id="newPassword" size="32" style="padding: 7px; border: 1px solid #000;" required />
					</tr>
					<tr>
						<td align="right" height="40px">Re-type Password</td>
						<td><input type="password" name="retPassword" id="retPassword" size="32" style="padding: 7px; border: 1px solid #000;" required onkeyup="checkPass()" />
						
					</tr>
					<tr>
						<td align="right" height="30px"></td>
						<td><span id="confirmMessage"></span></td>
					</tr>
					<tr>
						<td align="right"></td>
						<td><input type="submit" id="submit" disabled="true" value="Change" class="btn btn-primary" /></td>
					</tr>	
				</table>
			</fieldset>
			</form>
		</center>

<?php require_once("footer.php");
