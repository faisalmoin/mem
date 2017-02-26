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
		<link rel="stylesheet" type="text/css" href="bs/css/login-theme.css">
		<link rel="stylesheet" type="text/css" href="bs/css/login-styles.css">
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="css/sky-forms-ie8.css">
		<![endif]-->
		
		<!--[if lt IE 10]>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script src="js/jquery.placeholder.min.js"></script>
		<![endif]-->		
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="js/sky-forms-ie8.js"></script>
		<![endif]-->
</head>

<body class="bg-blue" style="background-image: url(bg-blue.jpg);">
	<?php
		if(isset($_GET['er'])<>""){
	?>
		<script type="text/javascript"> 
			var str = new String("Error! Authentication failed ...");
			alert(str);
		</script>
	<?php
		}
	?>
<div class="body body-s">
<br /><br />
<form class="sky-form" autocomplete="off" method="post" action="auth.php">

	<fieldset>	
		<header><center><img src="img/Logo MEM.png" width="90%" /></center></header>
					<section>
						<div class="row"><br />
							<label class="label col col-4">Login ID</label>
							<div class="col col-8">
								<label class="input">
									<i class="icon-append icon-user"></i>
									<input type="text" tabindex="1" placeholder="" name="LoginID" autocomplete="OFF"  autofocus required>
								</label>
							</div>
						</div>
					</section>
					
					<section>
						<div class="row">
							<label class="label col col-4">Password</label>
							<div class="col col-8">
								<label class="input">
									<i class="icon-append icon-lock"></i>
									<input type="password" name="Password"  autocomplete="off" tabindex="2" required>
								</label>
								<!-- <div class="note"><a href="#">Forgot password?</a></div> -->
							</div>
						</div>
					</section>
					
					<section>
						<div class="row">
							<div class="col col-4"></div>
							<div class="col col-8">
								<!-- <label class="checkbox"><input type="checkbox" name="checkbox-inline" checked><i></i>Keep me logged in</label> -->
							</div>
						</div>
					</section>
				</fieldset>
				<footer>
					<input type="hidden" value="<?php echo md5(date('Y-m-d H:s:i'))?>" name="session_id">
					<button type="submit" class="button">Log in</button>
					<!-- <a href="#" class="button button-secondary">Register</a> -->
				</footer>
			</form>
			
		</div>
		
				
		

</body>
</html>