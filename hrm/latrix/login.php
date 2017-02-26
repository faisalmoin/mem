<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "Login";
$help_url = 'http://www.latrix.org.uk/node/49';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$uri = $_SERVER['REQUEST_URI'];
$target = '';
$out = '';

// Separate the page name from the rest of the URI. If the requested page is the login page itself, then
// go to default (admin.php), otherwise go wherever requested. 
$bits = explode("/",$uri);
if ($bits[count($bits)-1] == 'login.php') {
	$target = 'home.php';
} else {
	$target = $uri;
}

$cid = $config->getCompanyID();
//var_dump($_SERVER);
if (isset($_POST['btnPassword'])) { header ('Location: sendpassword.php');}

if (isset($_POST['btnsubmit'])) {
	if (($_POST['TxtUName'] == '')||($_POST['TxtPWord'] == '')) {
		$errorbox->add('You must enter a user name and a password to log in');
	} else {
		// need to hash the password here
		//		$pword = hash('tiger128,4',$_POST['TxtPWord']); for now we'll do it in the database only. 
		// however, we do need to check for the superuser(owner) first, who may be a part of any company. 
		$sql = "SELECT emp_id, username, user_level_id, company_id FROM employees WHERE username='${_POST['TxtUName']}' AND password=AES_ENCRYPT('${_POST['TxtPWord']}','".la_aes_key."') and user_level_id = 5;";
		$login = $db_conn->query($sql);
		if (count($login) == 1) {
			$config->setCookie($config->setSession($login));
			header ('Location: select_company.php');			//Owner is logging in, needs to select a company
		} else {
			$sql = "SELECT emp_id, username, user_level_id, company_id FROM employees WHERE username='${_POST['TxtUName']}' AND password=AES_ENCRYPT('${_POST['TxtPWord']}','".la_aes_key."') and company_id =".$cid;
			$errorbox->debug($sql);
			$login = $db_conn->query($sql);
			if (count($login) == 1) {
				// create a session in the database: session ID, user ID, expiry, access level. Pass the session ID as a parameter
				$config->setCookie($config->setSession($login));
				// then to go to the page that called us originally. This may have to change to accommodate other login scenarios (e.g. following
				// a link in an e-mail).
				$errorbox->debug("Target was: ".$uri.', new target is:'.$target);
				header ('Location: '.$target);
			} else {
				$errorbox->add('Sorry, there is a problem with your username or password. Please correct and try again.');
			}
		}
	}
}

	require_once("include/header.php");
?>
<body onLoad="document.getElementById('TxtUName').focus();">
<script type="text/javascript" src="include/StandardScripts.js"></script>
<form method="post" action="login.php" name="latform" id="latform">
<table class="maintable">
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr>
	<td>
		<table>
			<tr>
				<td rowspan=5 style="width: 25%;"></td>
				<td colspan=2>Please enter your username 
	and password into the input boxes and click on the button to log in.</td>
				<td rowspan=5 style="width: 25%;"></td>
			</tr>
			<tr>
				<td class="td-right">Username</td>
				<td class="td-left"><input type="text" id="TxtUName" name="TxtUName" value="<?php echo $_POST["TxtUName"]?>" size="20"></td>
			</tr>
			<tr>
				<td class="td-right">Password</td>
				<td class="td-left"><input type="password" id="TxtPWord" name="TxtPWord" value="" size="20"></td>
			</tr>
			<tr>
				<td></td>
				<td class="td-left">
					<input type="submit" value="Log In" name="btnsubmit" id="btnsubmit">
					<input type="submit" value="Password forgotten" name="btnPassword" id="btnPassword">
<?php
	$out .= "\t\t<input type=\"hidden\" name=\"txtsubject\" id=\"txtsubject\" value=\"".$config->ctrl['subject']."\">\n"; 
	$out .= "\t\t<input type=\"hidden\" name=\"txtsubsubject\" id=\"txtsubsubject\" value=\"".$config->ctrl['subsubject']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtrecord\" id=\"txtrecord\" value=\"".$config->ctrl['record']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtdisplay\" id=\"txtdisplay\" value=\"".$config->ctrl['display']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtsubrecord\" id=\"txtsubrecord\" value=\"".$config->ctrl['subrecord']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txttitle\" id=\"txttitle\" value=\"".$config->ctrl['title']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtaction\" id=\"txtaction\" value=\"".$config->ctrl['action']."\">\n"; 
	$out .= "\t\t<input type=\"hidden\" name=\"txtmode\" id=\"txtmode\" value=\"".$config->ctrl['mode']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtpage\" id=\"txtpage\" value=\"".$config->ctrl['page']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtcolumn\" id=\"txtcolumn\" value=\"".$config->ctrl['column']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txtorder\" id=\"txtorder\" value=\"".$config->ctrl['order']."\">\n";
	$out .= "\t\t<input type=\"hidden\" name=\"txturi\" id=\"txturi\" value=\"".$uri."\">\n";
	echo $out;
?>
				</td>
			</tr>
			<tr>
				<td colspan=2><br>Please note that usage of this site without authorization to do so represents a 
	legal offense and will be prosecuted by the site owner.</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
	<?php include 'include/lfooter.php'; ?>
	</td>
</tr>
</table>
</form>
</body>
</html>

