<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();
require_once("db.txt");
$Login = $_REQUEST['id'];

$UserDetails = odbc_exec($conn, "SELECT [Password] FROM [user] WHERE [LoginID]='$Login'") or die(odbc_errormsg($conn));

odbc_exec($conn, "INSERT INTO [login] ([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '".odbc_result($UserDetails, "Password")."', '0', '".time()."') ") or die(odbc_errormsg());

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$(function() {
  var value = 0;
  var interval = setInterval(function() {
      value += 10;
      $("#progress-bar")
      .css("width", value + "%")
      .attr("aria-valuenow", value)
      .text(value + "%");
      if (value >= 100)
          clearInterval(interval);
  }, 1000);
});
});//]]>  

</script>
<!-- progress bar -->
<div class="container col-xs-4"></div>
<div class="container col-xs-4">
	<div class="progress progress-striped">
		<div class="progress-bar progress-bar-striped active" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
    progress 
		</div>
	</div>
</div>
<?php
header("Location: index.php");
?>