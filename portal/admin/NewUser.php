<?php
	require_once("SetupLeft.php");
?>

<script type='text/javascript'>//<![CDATA[ 
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

</script>
	<form class="form" method="POST" action="AddUser.php">

	<table class="table table-responsive">
		<tr>
			<td style="height: 60px" colspan="2"><h1 class="text-primary">New User</h1></td>
		</tr>
		<tr>
			<td height="50px"><label>Full Name</label></td>
			<td><input type="text" name="FullName" class="form-control" required placeholder="[First Name] [Middle Name] [Last Name]" style="padding: 8px;" /></td>
		</tr>
		<tr>
			<td height="50px"><label>Email</label></td>
			<td><input type="email" name="Email" class="form-control" id="email" required placeholder="someone@domain.com" style="padding: 8px;" /></td>
		</tr>
		<tr>
			<td height="50px"><label>Login ID</label></td>
			<td><input id="hiddenfield" name="LoginID" class="form-control" value="" required style="padding: 8px;"/></td>
		</tr>
		<tr>
			<td height="50px"><label>Contact No.</label></td>
			<td><input type="text" name="ContactNo" class="form-control" required placeholder="+919812345678" style="padding: 8px;" /></td>
		</tr>
		<tr>
			<td height="50px"><label>User Type</label></td>
			<td>
				<div class="form-group">
				<select name="UserType" class="form-control" style="padding: 8px;" required >
					<option value=""></option>
					<option value="HEADCOMP">School's Head Computer</option>
					<option value="Director">MEM Director</option>
					<option value="Sales">MEM Sales People</option>
					<option value="SalesManager">MEM Sales Manager</option>
					<option value="MEMAccountant">MEM Accountant</option>
					<option value="MEMOperation">MEM Operation</option>
					<option value="MEMAcademics">MEM Academics</option>
					<option value="MEMProcurement">MEM Procurement</option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td height="50px"></td>
			<td><button type="submit" style="padding: 8px;" class="btn btn-primary">Create</button></td>
		</tr>
	</table>

	</form>
	
<?php
	require_once("SetupRight.php");
?>