<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
    
*/
	require_once("../include/defs.inc");
	require_once("../classes/db_conn.php");
	require_once("../classes/errorbox.php");

$page_load_start = microtime(true);
$pagetitle = "Upgrade";
$errorbox = new Errorbox();
$dbc = new DB_Conn();

function str_endswith($string, $token) {
	if(strlen($string) ==0) return false;
	if(substr_compare($string, $token, -strlen($token), strlen($token)) == 0) return TRUE;
	return FALSE; 
}
function upgrade_database($version) {
	global $errorbox;
	global $dbc;
	$file = fopen('upgrade_db.sql','r');
	if (strcmp($version,'0.5.1a') < 0) {
		return ('Your version of LATRIX is too old to run an automated upgrade. Contact latrix.org for details how to proceed.');
	}
	if (strcmp($version,'0.5.1a') == 0) {
		$version_token = '/* [ANY] */';
	} else {
		$version_token = '/* ['.$version.'] */';
	}
	// Fast forward the sql script to the correct entry, i.e. ignore previous upgrade sections
	echo "looking for token '".$version_token."'\n";
	$cnt =1;
	while ($line = fgets($file)) {
		echo $cnt++.': '.$line."\n";
		if (strcmp(trim($line),$version_token) == 0) break;
	}
	// Now execute everything from here to the end of the file. 
	while ($sql = fgets($file)) {
		while(!str_endswith(trim($sql), ';')) {
			if (!($sql .= fgets($file))) {
				return 'Premature end of script file, please re-install upgrade_db.sql';
			}
		}
		$dbc->exec($sql);
	}
	fclose($file);

}

// retrieve the current version from the database;
// On sites prior to V0.6.0 this would result in an error, because the version table doesn't exist
$data = $dbc->query("SHOW TABLES LIKE 'ver%';");
if ($data != NULL) {
	$data = $dbc->query("SELECT * FROM version;");
}
if ($data == NULL) {
	$version = "0.5.1a";
} else {
	$version = $data[0]['version'];
}

if (isset($_POST['btn_upgrade'])) { 
	$errorbox->add(upgrade_database($version));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
	print '<title>'.la_version.$pagetitle.'</title>';
?>
	<meta name="author" content="Wolfgang Schulze-Zachau">
	<meta name="copyright" content="Manticore Software">
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta name="document-state" content="dynamic">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<LINK href="../include/styles.css" type="text/css" rel="stylesheet">
	<LINK href="../include/admin-styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<form id="latform" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<table class="maintable" cellspacing="0px" cellpadding="0px" style="margin:0px; padding:0px; ">
<tr class="banner">
	<td>
		<div class="banner-left">
			<a href="http://www.latrix.org.uk"><img src="../images/LATRIX-logo-1.png" alt="clock" noresize ></a>
		</div>
		<div class="banner-center">
			<h1 class="pagetitle"><?php echo $pagetitle ?></h1>
		</div>
		<div class="banner-right">
			<a href="http://www.latrix.org.uk/content/upgrading">Upgrade Help</a><br>
			<?php 
				echo("Version ".la_short_version);
			?>
		</div>
	</td>
</tr>
<tr>
	<td>
		<table>
		<?php
			if (isset($_POST['btn_upgrade'])) {
		?>
			<tr>
				<td width="20%">&nbsp;</td>
				<td colspan="3">
					<div>
						<h2>Welcome to the new version of LATRIX</h2>
						Congratulations! You have successfully upgraded your database.<br>
						If you can see a box with a red frame and some text inside, please click on the help link 
						above to be taken to the upgrade help page on the latrix.org website, where you will be able 
						to find information of what can be done. If there is no box with a red frame, then the upgrade
						went completely without problems, as it should, and you can now carry on using the site.<br>
					</div>
				</td>
				<td width="20%">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><hr class="separator"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3">
					<h3>Some useful links to get started:</h3>
					<a class="inline" href="../admin.php">The Administration section</a>
					<a class="inline" href="../checkin.php">The Check In page</a>
					<a class="inline" href="../logger.php">The Time Recorder page</a>
					<a class="inline" href="../inandout.php">The Fire Register</a>
				</td>
				<td></td>
			</tr>
		<?php
			} else {
		?>
			<tr>
				<td width="20%">&nbsp;</td>
				<td colspan="3">
					<div>
						<h2>Welcome to the latest version of LATRIX</h2>
						This page allows you to upgrade your database to the latest version.<br><br>
						Your current version is <?php echo $version ?><br>
						Your new version is <?php echo la_short_version ?><br><br>
						Before you upgrade, you should make a backup of your current database, just in case anything 
						goes wrong. Better safe than sorry.<br>
						When you are ready, click on the button below.
					</div>
				</td>
				<td width="20%">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><hr class="separator"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td class="td-left-top" colspan="3" style="text-align:center">
					<input type="hidden" name="flag" id="flag" value="set">
					<input type="submit" name="btn_upgrade" id="btn_upgrade" value="Go !!!">
				</td>
				<td></td>
			</tr>
		<?php
			}
		?>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table width="100%">
			<tr>
				<td colspan=3>
				<?php echo $errorbox->out(); ?>
				</td>
			</tr>
			<tr>
				<td width="20%"></td>
				<td width="60%" style="text-align:center">
					<hr class="ruler">
					<a href="http://www.manticore-uk.com">
						<img src="../images/manlogo.jpg" noresize WIDTH="100" HEIGHT="64" border=0></a><br>
					<font style="font-size:8pt">
					<?php
					$page_load_time = microtime(true)-$page_load_start;
					?>
					LATRIX Attendance Recording powered by Manticore Software<br>
					This page took <?php echo round($page_load_time,4) ?> seconds to build.
					Page loaded at <?php echo date('Y-M-d H:i:s') ?><br>
					Version <?php echo la_short_version ?>Copyright &copy; 2006,2009 Manticore Software
					</font>
					</td>
				<td width="20%"></td>
			</tr>
		</table>
	</td>
</tr>
</table>
</form>
</body>
</html>

