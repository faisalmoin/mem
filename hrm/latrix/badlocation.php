<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "Invalid Location";
$help_url = 'http://www.latrix.org.uk/node/17';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");
	
$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($dbc);

	require_once("include/header.php");
?>
<body>
<table class="maintable">
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr>
	<td class=maintable>
		<table align=center>
		<thead>
				<tr>
				<td class=bluehead>Location Error</td>
				</tr>
		</thead>
		<tbody>
			<tr>
				<td><br><br><br>
				I am sorry, the location from where you tried to access this site is not registered in my database.<br> 
				In order to use LATRIX, you need to be a registered company. Please contact the <a href="mailto:webmaster@manticore-uk.com">owner</a> 
				of this site to register your company.<br>
				If you are certain that your company is a registered LATRIX user, then please contact your HR Manager or General Manager to add this site
				to the database.<br><br>
				If you ended up on this page, because you were looking for the main web site of the LATRIX, then please try this <a class="inline-link" href="default.php">link</a>.
				</td>
			</tr>
		</tbody>
		</table>
	</td>
</tr>
<tr>
	<td>
	<?php include 'include/lfooter.php'; ?>
	</td>
</tr>
</table>
</body>
</html>

