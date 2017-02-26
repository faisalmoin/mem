<?php
	require_once("header.php");

	if ($_SERVER['REQUEST_METHOD'] == "POST"){
	
		$curr = md5($_REQUEST['cur_passwd']);
		$pwd = md5($_REQUEST['password']);
		$re_pass = md5($_REQUEST['confirmPassword']);
		
		$check = odbc_exec($conn, "SELECT [password] FROM [user] WHERE [LoginID]='$LoginID' AND [password]='$curr'") or die(odbc_errormsg($conn));
		if(odbc_num_rows($check) == 1){
			if($pwd == $re_pass){
				$result = odbc_exec($conn, "UPDATE [user] SET [password]='$pwd' WHERE [LoginID]='$LoginID' ") or die(odbc_errormsg($conn));
				echo "A";
				if(!result){
					$msg = "<p class='text-danger'>Unable to change password ...</p>";
				} else {
					$msg = "<p class='text-success'>Password changed successfully ...</p>";
				}
			}
			else{
				$msg = "<p class='text-danger'>New password and Re-Type password did not matched ...</p>";
			}
		}
		else{
			$msg = "<p class='text-danger'>Current password does not matched ... </p>";
		}
	}

?>
<div class="container">
	<div class="row" style="background-color: #ffffff;">
		<div class="container col-xs-4"></div>
		<div class="container col-xs-4">
			<form role="form" id="identicalForm" class="form-horizontal" data-fv-framework="bootstrap"
			name="submitted"
			method="POST"
			data-fv-icon-valid="glyphicon glyphicon-ok"
			data-fv-icon-invalid="glyphicon glyphicon-remove"
			data-fv-icon-validating="glyphicon glyphicon-refresh">
				<div class="form-group row-xs-4">
					<label for="pwd">Current Password:</label>
					<input type="password" class="form-control" id="pwd" name="cur_passwd" required />
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
	</div>
	<div class="row">
		<div class="container col-xs-4"></div>
		<div class="container col-xs-4"><?php echo $msg; ?></div>
		<div class="container col-xs-4"></div>
	</div>
</div>
<?php
	require_once("../footer.php");
?>