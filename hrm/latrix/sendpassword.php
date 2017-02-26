<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "Resend Password";
$help_url = 'http://www.latrix.org.uk/node/49';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
//$config->checkUser();						// this checks the cookie and loads company information 

if (isset($_POST['btnsubmit'])) {
	if (!isset($_POST['TxtEmail'])) {
		$errorbox->add('You must enter an e-mail address that I can send to.');
	} else {
		$email = $db_conn->query("SELECT AES_DECRYPT(password,'".la_aes_key."') as password, fname, username FROM employees WHERE email='".$_POST['TxtEmail']."'");
		if (count($email) == 1) {
			// get the password, decrypt it and send the email.
			// then show confirmation page.
			$this->mailer =& MAIL::factory("smtp");
			$headers['From'] = 'admin@latrix.co.uk';
			$headers['To'] = $_POST['TxtEmail'];
	//		$headers['To'] = 'wolfgangs@manticoreit.com';
			$headers['Subject'] = 'Login Details for your LATRIX login';
			$recipients = $email[0]['email'];
	//		$recipients = 'wolfgangs@manticoreit.com';
			$body = file_get_contents('include/templates/login-details.email',true);
			$body = str_replace('%firstname%', $email[0]['fname'], $body);
			$body = str_replace('%username%', $email[0]['username'], $body);
			$body = str_replace('%password%', $password,$body);
			//$body = str_replace('%action%',$action, $body); 
			if($err = $this->mailer->send($recipients, $headers, $body) != true) {
				$this->error->add($err->toString());
			}
			$errorbox->add('Thank you. An e-mail has been sent to this address. Please open the message and follow the instructions.'); 
		} else {
			$errorbox->add('Sorry, I cannot find this address in my database. Please contact your HR Manager.');
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
				<td rowspan=4 style="width: 25%;"></td>
				<td colspan=2><br>Please enter your email address into the input box and click on the button. LATRIX will send you an email with instructions.</td>
				<td rowspan=4 style="width: 25%;"></td>
			</tr>
			<tr>
				<td class="td-right"><br>E-mail address</td>
				<td class="td-left"><br><input type="text" id="TxtEmail" name="TxtEmail" size="20"></td>
			</tr>
			<tr>
				<td><br></td>
				<td class="td-left"><br>
					<input type="submit" value="Resend Password" name="btnPassword" id="btnPassword">
				</td>
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

