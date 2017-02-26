<?php
	require_once("SetupLeft.php");
?>

<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>New User </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

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
	<form class="form" method="POST" action="UserAdd.php">

	<table class="table table-responsive">
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
					<option value="SchoolDirector">School Director</option>
					<option value="Principal">Principal</option>
					<option value="School Admin">School Admin</option>
					<option value="Accountant">Accountant</option>
					<option value="FOE">Front Office Executive (FOE)</option>
					<option value="Librarian">Librarian</option>
					<option value="HOUser">HO User</option>
					<option value="Student">Student</option>
					<option value="Parent">Parent</option>
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

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("SetupRight.php");
?>