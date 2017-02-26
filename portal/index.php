<?php

$ip = $_SERVER['REMOTE_ADDR'];

?>

<!DOCTYPE html>
<html >
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MEM | School ERP</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<link rel="stylesheet" href="build/css/style.css"> 
<script type="text/javascript" src="build/js/index.js"></script>  
  
</head>

<body>
  <hgroup>
  <!-- h1>Material Design Form</h1>
  <h3>By Josh Adamous</h3>
</hgroup -->
<form  autocomplete="off" method="post" action="auth.php">
  <div class="group">
    <input type="text" id="username" name="LoginID" autocomplete="OFF"  autofocus required><span class="highlight"></span><span class="bar"></span>
    <label>Login ID</label>
  </div>
  <div class="group">
    <input id="password" name="Password" type="password"  autocomplete="OFF"  autofocus required><span class="highlight"></span><span class="bar"></span>
    <label>Password</label>
  </div>
  <button type="submit" class="button buttonBlue">Login
    <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
  </button>
  <a class="pull-left" href="ResetPassword.php">Forgot password?</a>
  <input type="hidden" value="<?php echo md5($ip." || ".date('Y-m-d H:s:i'))?>" name="session_id">
</form>
<footer><a href="http://www.themillenniumschools.com/" target="_blank"><img src="img/Logo MEM.png" style="min-width: 180px; max-width: auto;"></a>
<p>&copy; Millennium Education Management Pvt. Ltd.</p>
<p>Designed & developed by Educomp Process Development Team</p>
</footer>

</body>
</html>
