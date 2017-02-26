<?php
	require_once("header.php");
	//$id=$_REQUEST['id'];
	$oldPassword=md5($_REQUEST['oldPassword']);
	$newPassword=$_REQUEST['newPassword'];
	$retPassword=$_REQUEST['retPassword'];
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

<?php	
	$row=odbc_exec($conn, "SELECT * FROM [user] WHERE [LoginID]='$LoginID'") or die(odbc_errormsg($conn));
	
    echo "<br /><br /><br /><br />";
	if($oldPassword == odbc_result($row, "Password")){
		if($newPassword == $retPassword){
			odbc_exec($conn, "UPDATE [user] SET [Password]='".md5($newPassword)."' WHERE [LoginID]='$LoginID'") or die(mysql_error());
			echo "<div class='alert alert-primary alert-error' style='background-color: #008000;color: #ffffff;'>Your password has been reset</div>";
		}
		else{
			echo "<div class='alert alert-warning alert-error' style='background-color: #FFA500;color: #ffffff;'>New Password does not match with the Retype Password</div>";
		}
	}
	else{
		echo "<div class='alert alert-danger alert-error' style='background-color: #990000;color: #ffffff;'>Current Password does not match.</div>";
	}
?>

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