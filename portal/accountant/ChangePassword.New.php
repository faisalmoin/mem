<?php
	require_once("header.php");
	
?>

<!-- Body -->
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
<h2>Change Password </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

			<form name="form" action="ChangePassword.Update.php" method="POST">
				<table class="table">
					<input type="hidden" name="id" value="<?=$LoginID?>" />
					<tr>
						<td align="right" style="border: none; ">Current Password</td>
						<td style="border: none; "><input type="password" class="form-control" style="width: 250px;" name="oldPassword" size="32" required />
					</tr>
					<tr>
						<td align="right"  style="border: none; ">New Password</td>
						<td style="border: none; "><input type="password" name="newPassword"  class="form-control" style="width: 250px;"required />
					</tr>
					<tr>
						<td align="right" style="border: none; ">Re-type Password</td>
						<td style="border: none; "><input type="password" name="retPassword"  class="form-control" style="width: 250px;"required />
					</tr>
					<tr>
						<td align="right" style="border: none; "></td>
						<td style="border: none; "><input type="submit" value="Change" class="btn btn-primary" />
					</tr>	
				</table>
			</form>

<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->

<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php require_once("../footer.php");
