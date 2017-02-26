<?php
	require_once("SetupLeft.php");
	
	$id = $_REQUEST['id'];
	$rs = odbc_exec($conn, "SELECT * FROM [user] WHERE [id]='$id'") or die(odbc_errormsg($conn));	
	
?>

<script type='text/javascript'>/*//<![CDATA[ 
window.onload=function(){
var email = document.getElementById("email"),
    hidden = document.getElementById("hiddenfield");

function transferTruncated() {
    var target = this,
        name;

    if (target.value.indexOf("@") !== -1) {
        name = target.value.split("@")[0].trim();

        if (name && name.search(/\s/) === -1) {
            hidden.value = name;
        } else {
            hidden.value = "truncated email";
        }
    } else {
        hidden.value = "truncated email";
    }
}

email.addEventListener("change", transferTruncated, false);
}//]]>  
*/
</script>
	<form class="form" method="GET" action="UserUpdate.php">
	<input type="hidden" name="id" value="<?php echo odbc_result($rs, 'id'); ?>">
	<div class="form-group">
	<table align="center" width="60%">
		<tr>
			<td style="height: 60px" colspan="2"><h1 class="text-primary">Edit User</h1></td>
		</tr>
		<tr>
			<td height="50px"><label>Full Name</label></td>
			<td><input type="text" name="FullName" required placeholder="[First Name] [Middle Name] [Last Name]" class="form-control" style="padding: 8px;" value="<?php echo odbc_result($rs, 'FullName')?>" /></td>
		</tr>
		<tr>
			<td height="50px"><label>Email</label></td>
			<td><input type="email" name="Email" id="email" required placeholder="someone@domain.com" class="form-control" style="padding: 8px;" value="<?php echo odbc_result($rs, 'Email')?>" /></td>
		</tr>
		<tr>
			<td height="50px"><label>Login ID</label></td>
			<td><input id="hiddenfield" name="LoginID" required class="form-control" style="padding: 8px;background-color: #d3d3d3; border: 1px solid #d3d3d3;"  value="<?php echo odbc_result($rs, 'LoginID')?>" readonly /></td>
		</tr>
		<tr>
			<td height="50px"><label>Contact No.</label></td>
			<td><input type="text" name="ContactNo" required placeholder="+919812345678" class="form-control" style="padding: 8px;" value="<?php echo odbc_result($rs, 'ContactNo')?>" /></td>
		</tr>
		<tr>
			<td height="50px"><label>User Type</label></td>
			<td>
				<select name="UserType" style="padding: 8px;" required class="form-control">
					<option value=""></option>
					<option value="User" <?php if(odbc_result($rs, 'UserType') == "User") echo "selected"; ?>>User</option>
					<option value="Support" <?php if(odbc_result($rs, 'UserType') == "Support") echo " selected"; ?>>Support</option>
					<option value="Supervisor" <?php if(odbc_result($rs, 'UserType') == "Supervisor") echo " selected"; ?>>Supervisor</option>					
					<option value="SchoolDirector" <?php if(odbc_result($rs, 'UserType') == "SchoolDirector") echo " selected"; ?>>School Director</option>
					<option value="Principal" <?php if(odbc_result($rs, 'UserType') == "Principal") echo " selected"; ?>>Principal</option>
					<option value="School Admin" <?php if(odbc_result($rs, 'UserType') == "School Admin") echo " selected"; ?>>School Admin</option>
					<option value="Accountant" <?php if(odbc_result($rs, 'UserType') == "Accountant") echo "selected"; ?>>Accountant</option>
					<option value="FOE" <?php if(odbc_result($rs, 'UserType') == "FOE") echo " selected"; ?>>Front Office Executive (FOE)</option>
					<option value="Librarian" <?php if(odbc_result($rs, 'UserType') == "Librarian") echo " selected"; ?>>Librarian</option>
					<option value="HOUser" <?php if(odbc_result($rs, 'UserType') == "HOUser") echo " selected"; ?>>HO User</option>
					<option value="Student" <?php if(odbc_result($rs, 'UserType') == "Student") echo " selected"; ?>>Student</option>
					<option value="Parent" <?php if(odbc_result($rs, 'UserType') == "Parent") echo " selected"; ?>>Parent</option>
				</select>
				
			</td>
		</tr>
		<tr>
			<td><label>Status</label></td>
			<td>
				<select name="UserStatus" style="padding: 8px;" required class="form-control">
					<option value=""></option>
					<option value="Active" <?php if(odbc_result($rs, 'UserStatus') == 'Active') echo " selected"; ?> >Active</option>
					<option value="In-Active"<?php if(odbc_result($rs, 'UserStatus') == 'In-Active') echo " selected"; ?> >In-Active</option>
				</select>
			</td>
		</tr>
		<tr>
			<td height="50px"></td>
			<td>
				<input type="submit" value="Update" style="padding: 8px;" class="btn btn-primary" name='Response'>
				<input type="submit" value="Reset Password" style="padding: 8px;" class="btn btn-warning" name='Response'>
			</td>
		</tr>
	</table>
	</div>
	</form>

<?php
	require_once("SetupRight.php");
?>