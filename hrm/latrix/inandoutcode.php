<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "In & Out Access Code";
$help_url = 'http://www.latrix.org.uk/node/51';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

// load three recordsets: ins, leaves and outs
$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
	print '<title>'.la_version.$pagetitle.'</title>';
?>
<meta name="author" content="Wolfgang Schulze-Zachau">
<meta name="copyright" content="Manticore Software 2006">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<LINK href="include/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<form method="post" action="<?php echo $_GET['target'] ?>.php" name="latform" id="latform">
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
				<td rowspan=3 style="width: 25%;"></td>
				<td colspan=2>Please enter your access code.</td>
				<td rowspan=3 style="width: 25%;"></td>
			</tr>
			<tr>
				<td class="td-right">Access Code</td>
				<td class="td-left"><input type="text" id="txtaccesscode" name="txtaccesscode" size="10"></td>
			</tr>
			<tr>
				<td></td>
				<td class="td-left">
					<input type="submit" value="Submit" name="btnsubmit" id="btnsubmit">
				</td>
				<td></td>
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
