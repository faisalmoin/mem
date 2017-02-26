<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "Select a company";
$help_url = 'http://www.latrix.org.uk/node/49';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$config->checkUser();		//this will forward the user to the login page, should the cookie be missing.
$uri = $_SERVER['REQUEST_URI'];
$target = '';
$out = '';

// Separate the page name from the rest of the URI. If the requested page is the login page itself, then
// go to default (admin.php), otherwise go wherever requested. On this page, the actual target uri is in the POST 
//$bits = explode("/",$_POST['txturi']); 
//if ($bits[count($bits)-1] == 'login.php') {
//	$target = 'admin.php';
//} else {
//	$target = $uri;
//}
$target = 'admin.php';
//$errorbox->debug("URI in POST:".$_POST['txturi'].", new target: ".$uri);

if (isset($_POST['btnsubmit'])) {
	// the user has selected a company from the list. He can only be the owner, otherwise he wouldn't be here.
	$company = $_POST['sbCompany'];
	// now store this new information in the cookie.
	$config->updateSession($company,$_COOKIE['latrax-session']);
	header ('Location: '.$target);
}
$SQL = "SELECT DISTINCT company_id, name FROM companies";
$data = $db_conn->query($SQL);
if ($data != NULL && count($data) ==  1) {			// if there is only one company then there is no need to bore the Owner with this page.
	$config->updateSession($data[0]['company_id'],$_COOKIE['latrax-session']);
	header ('Location: '.$target);
}

	require_once("include/header.php");
?>
<body onLoad="document.getElementById('sbCompany').focus();">
<form method="post" action="select_company.php" name="latform" id="latform">
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
				<td colspan=2>Hello Owner! Nice to have you back. Select the company you want to work on today.</td>
				<td rowspan=4 style="width: 25%;"></td>
			</tr>
			<tr>
				<td class="td-right">Company</td>
				<td class="td-left"><select name="sbCompany" id="sbCompany" size="1" class="edit-ctrl"> 
				<?php
					foreach ($data as $row) {
						echo("<option value=\"".$row['company_id']."\">".$row['name']."</option>\n"); 
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="td-left">
					<input type="submit" value="Select" name="btnsubmit" id="btnsubmit">
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

