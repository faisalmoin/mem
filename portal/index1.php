<?php
/**
 * Created by Pallab DB.
 * User: Pallab DB
 * Date: 5/15/2015
 * Time: 2:51 PM
 */
 
	//Client Browser Detection
	$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
	$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
	
	//exit("Chrome: ".$chrome." // Firefox: ".$firefox);
	
	if ($firefox=="" && $chrome=="") {
		header('Location: BrowserCheck.php');
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>MEM-ERP</title>
<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<script src="bs/js/jquery.min.js"></script>
		<script src="bs/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="bs/css/bootstrap.min.css">
		<link rel="stylesheet" href="bs/css/sticky-footer-navbar.css">
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	  

</head>

<body >
	<div class="container" style="width:70%; padding: 20px;">
	<img src="img/Logo MEM.png" width="180px" />	
	</div>
<!--div class="container" style="width: 70%;">

</div-->

<div style="width: 100%; height: 80px; background-image: url(bg-blue.jpg);display: inline-block;vertical-align: middle;">
	<div class="container" style="vertical-align: middle; color: #ffffff;; line-height: 80px;font-family: 'Poiret One', cursive;width: 70%;">
		<h2>Login to ERP</h2>
	</div>
</div>
<br />
<div class="container" style="width: 70%;">
	<div class="row">
		<form class="sky-form" autocomplete="off" method="post" action="auth.php">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="form-group">
				<label>Username</label>
				<input id="username" name="LoginID" type="text" class="form-control input-lg" autocomplete="OFF"  autofocus required>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input id="password" name="Password" type="password" class="form-control input-lg" autocomplete="OFF"  autofocus required>
			</div>
			<div class="form-group">
				<a class="pull-left" href="ResetPassword.php">Forgot password?</a>
				<button id="log_in" class="pull-right btn btn-success loginBtn" type="submit" data-loading-text="Log In">Log In</button>
				<input type="hidden" value="<?php echo md5(date('Y-m-d H:s:i'))?>" name="session_id">
			</div>			
		</div>
		</form>
	</div>
	
</div>

<?php require_once("footer.php");?>