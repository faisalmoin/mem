<?php
	require_once("header.php");
?>
<div class="container col-xs-4"></div>
<div class="container col-xs-4">
	<form role="form" id="identicalForm" class="form-horizontal" data-fv-framework="bootstrap"
    data-fv-icon-valid="glyphicon glyphicon-ok"
    data-fv-icon-invalid="glyphicon glyphicon-remove"
    data-fv-icon-validating="glyphicon glyphicon-refresh">
		<div class="form-group row-xs-4">
			<label for="pwd">Current Password:</label>
			<input type="password" class="form-control" id="pwd" required />
		</div>
		<div class="form-group row-xs-4">
			<label for="control-label">New Password:</label>
			<input type="password" class="form-control" name="password" required />
		</div>
		<div class="form-group row-xs-4">
			<label for="control-label">Re-Type Password:</label>
			<input type="password" class="form-control" name="confirmPassword" data-fv-identical="true"
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

<?php
	require_once("../footer.php");
?>