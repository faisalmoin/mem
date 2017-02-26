<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MEM-ERP | Reset Password</title>
		<title>MEM-ERP</title>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
		<script src="bs/js/jquery.min.js"></script>
		<script src="bs/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="bs/css/bootstrap.min.css">
		<link rel="stylesheet" href="bs/css/sticky-footer-navbar.css">
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	  

		<script>
			function checkform (Login){
				if (form.UserName.value==""){
					alert ("Login ID cannot be blank.");
					form.UserName.focus();
					return false;
				}
				if(form.Password.value==""){
					alert ("Password cannot be blank.");
					form.Password.focus();
					return false;
				}
				if (form.UserName.value != "" && Login.Password.value != ""){
					document.form.submit.click();
					//window.location = "auth.php";
				}
			}

		</script>
		<style>
			html,
				body {
				margin:0;
				padding:0;
				height:100%;
				}
				#wrapper {
				min-height:0%;
				position:relative;
				}
				#header {
				//padding:10px;
				}
				#content {
				padding:40px;
				padding-bottom:23%; /* Height of the footer element */
				}
				#footer {
				width:100%;
				height:0px;
				position:absolute;
				bottom:0;
				left:0;
				}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div style="font-size: 20px; font-family: verdana; color: #FFF;background-color: #0088ff; padding:14px">
						MEM ERP
				</div>
			</div>
			<div id="content">	
				<form method="POST" action="RestPasswordConfirm.php">
				<table width="100%" cellspacing="0px" border="0" cellpadding="10">
					
					<tr  style="font-size: 15px; font-family: verdana; color: #000;background-color: #fff;">
						<td align="justify" style="padding:10px" valign="top">
							Enter your registered email address or Login ID
						</td>
					</tr>
					<tr  style="font-size: 15px; font-family: verdana; color: #000;background-color: #fff;">
						<td align="justify" style="padding:10px" valign="top">
							<input type="text" name="Email" size="45" style="font-family: arial; padding: 5px;" autocomplete="OFF" required />
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="login" style="font-family: tahoma; font-weight: normal; padding: 5px; width: 70px; color:#fff; background-color: #0066ff; border: 0px" value="Submit" />
							<input type="button" onclick="location.href='index.php'" name="login" style="font-family: tahoma; font-weight: normal; padding: 5px; width: 70px; color:#fff; background-color: #CCCCCC; border: 0px" value="Cancel" />
						</td>
					</tr>
				</table>
			</div>
			
		</div>
		
	</body>
</html>
<?php require_once("footer.php")?>