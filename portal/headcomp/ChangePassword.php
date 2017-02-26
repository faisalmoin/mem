<?php
	require_once("header.php");
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
<h2>Change Password </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<div class="container col-xs-4"></div>
<div class="container col-xs-4">
	<form role="form" id="identicalForm" class="form-horizontal" data-fv-framework="bootstrap"
    data-fv-icon-valid="glyphicon glyphicon-ok"
    data-fv-icon-invalid="glyphicon glyphicon-remove"
    data-fv-icon-validating="glyphicon glyphicon-refresh" method="post" action="ChangePassword.Update.php">
		<div class="form-group row-xs-4">
			<label for="pwd">Current Password:</label>
			<input type="password" class="form-control" id="pwd" name="oldPassword" required />
		</div>
		<div class="form-group row-xs-4">
			<label for="control-label">New Password:</label>
			<input type="password" class="form-control" name="newPassword" required />
		</div>
		<div class="form-group row-xs-4">
			<label for="control-label">Re-Type Password:</label>
			<input type="password" class="form-control" name="retPassword" data-fv-identical="true"
                data-fv-identical-field="password"
                data-fv-identical-message="The password and its confirm are not the same" required />
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>
<div class="container col-xs-4"></div>

<script>
$(document).ready(function() {
    $('#identicalForm').formValidation();
});
</script>

</div>
</div>
</div>
</div>
</div>
</div>
</div>


<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("../footer.php");
?>