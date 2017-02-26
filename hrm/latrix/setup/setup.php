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
$pagetitle = "Setup";
$errorbox = new Errorbox();

function str_endswith($string, $token) {
	if(strlen($string) ==0) return false;
	if(substr_compare($string, $token, -strlen($token), strlen($token)) == 0) return TRUE;
	return FALSE; 
}
function setup_database($dbc, $company, $location) {
	global $errorbox;
	$file = fopen('create_db.sql','r');
	mysql_query('SET FOREIGN_KEY_CHECKS=0;',$dbc);
	while ($sql = fgets($file)) {
		while(!str_endswith(trim($sql), ';')) {
			if (!($sql .= fgets($file))) {
				return 'Premature end of script file, please re-install create_db.sql';
			}
		}
		if (!$result = mysql_query($sql, $dbc)) {
			return 'Cannot execute query : '.mysql_error($dbc).' Query was: '.$sql;
		}
	}
	fclose($file);

	$file = fopen('fill_db.sql','r'); 
	$sql = '';
	while ($sql = fgets($file)) {
		while(!str_endswith(trim($sql), ';')) {
			if (!($sql .= fgets($file))) {
				return 'Premature end of script file, please re-install fill_db.sql';
			}
		}
		$sql = str_replace('%company%',$company, $sql);
		$sql = str_replace('%location%', $location, $sql);
		$sql = str_replace('%ipadr%', $_SERVER['REMOTE_ADDR'], $sql);
		if (!$result = mysql_query($sql, $dbc)) {
			return 'Cannot execute query : '.mysql_error($dbc).' Query was: '.$sql;
		}
	}
	mysql_query('SET FOREIGN_KEY_CHECKS=1;',$dbc);
	// now we fill the dates table with dates so that the graphs show correct information
	$daysecs = 24 * 60 * 60;
	$start = strtotime(date('Y-m-d', strtotime('+1 days')));
	do {
		$date = date('Y-m-d',$start);
		$sql = "INSERT INTO dates VALUES(NULL,'".$date."',".date('W',$start).",".date('m',$start).",".date('Y',$start);
		$sql .= ",".date('d',$start).",".date('z',$start).",'".date('l',$start)."','".date('F',$start)."');";
		mysql_query($sql,$dbc);
		$start += $daysecs;
	} while (date('Y-m-d',$start) < date('Y-m-d', strtotime('+365 days')));
	
}

if (isset($_POST['flag'])) {
	if (!isset($_POST['in_company'])) $errorbox->add('You must provide a company name, please.');
	if (!isset($_POST['in_location'])) $errorbox->add('You must provide a location name, please.');
	if (!isset($_POST['in_db_name'])) $errorbox->add('You must provide a database name, please.');
	if (!isset($_POST['in_db_user'])) $errorbox->add('You must provide a database user name, please.');
	if (!isset($_POST['in_db_pass'])) $errorbox->add('You must provide a database user password, please.');
	if (!isset($_POST['in_email'])) $errorbox->add('You must provide an admin email address, please.');
	if (!isset($_POST['in_from'])) $errorbox->add('You must provide a from email address, please.');
	
	if (isset($_POST['in_db_host'])) {
		// we have a post, let's try a connection
		$dbc = mysql_connect($_POST['in_db_host'], $_POST['in_db_user'],$_POST['in_db_pass']);
		if (!$dbc || mysql_error($dbc) != "") {
			$errorbox->add("Could not connect to database server " .$_POST['in_db_host'] );
		} else {
			if (!mysql_select_db($_POST['in_db_name'], $dbc)) {
				$errorbox->add('Could not select database : ' .  mysql_error($dbc));
			} else { 
				$result = mysql_query("SHOW TABLES;", $dbc);
				$tables = NULL;
			   while ($row = mysql_fetch_array($result)) {
					$tables[] = $row; 
			   }				
			   if ($tables != NULL) {
			   	$errorbox->add('The database is not empty, this won\'t work');
			   } else {
					// OK, we have a connection. Now let's try to run the setup script. This has to be done statement by statement,
					// just in case somebody is using an old connector.
					$errorbox->add(setup_database($dbc, $_POST['in_company'], $_POST['in_location']));
					// now we write the config values to the file
					$filename = '../include/config.empty.inc';
					$file = fopen($filename,'r');
					$conf = fread($file, filesize($filename));
					$conf = str_replace('%db_host%', $_POST['in_db_host'], $conf);
					$conf = str_replace('%db_name%', $_POST['in_db_name'], $conf);
					$conf = str_replace('%db_user%', $_POST['in_db_user'], $conf);
					$conf = str_replace('%db_pass%', $_POST['in_db_pass'], $conf);
					$conf = str_replace('%admin_email%', $_POST['in_email'], $conf);
					$conf = str_replace('%from_email%', $_POST['in_from'], $conf);
					fclose($file);
					$file = fopen('../include/config.inc','w');
					$result = fwrite($file, $conf);
					if ($result == FALSE) {
						$errorbox->add('Could not write to the config file, check permissions of the include folder'); 
					}
				}
			}
		}
	} else $errorbox->add('You must provide a hostname or IP address for the database server.');
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
<table class="maintable" width="100%" cellspacing="0px" cellpadding="0px" style="margin:0px; padding:0px; ">
<tr class="banner">
	<td>
		<div class="banner-left">
			<a href="http://www.latrix.org.uk"><img src="../images/LATRIX-logo-1.png" alt="clock" noresize ></a>
		</div>
		<div class="banner-center">
			<h1 class="pagetitle"><?php echo $pagetitle ?></h1>
		</div>
		<div class="banner-right">
			<a href="http://www.latrix.org.uk/node/16">Installation Help</a><br>
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
			if (isset($_POST['in_db_host']) && $errorbox->isEmpty()) {
		?>
			<tr>
				<td width="20%">&nbsp;</td>
				<td colspan="3">
					<div>
						<h2>Welcome to the LATRIX</h2>
						Congratulations! You have successfully set up your database connection and the database has
						been filled with an initial set of a few (very few!) records that allow site operation.<br><br>
						Please make a note of the following:<br>
						<ul>
							<li>At the moment there is only one user account. The username is admin and the password is p4ssw0rd.
							This user is the site superuser. It has access to anything and everything and should not be used for daily operations.
							Please change the password immediately to something else and create additional user accounts.</li>
							<li>At the moment only one location is defined, using the IP address of your computer, as seen by the 
							web server where you installed the LATRIX (<?php echo $_SERVER['REMOTE_ADDR']?>). If you need additional locations, you must configure
							them individually. If you don't know how to find out the relevant IP addresses, consult the 
							online manual for the LATRIX.</li>
							<li>In order to ensure continued operation of the site, a script has to be executed on a daily basis.
							Under linux, you will use cron for this, under Windows you will use the task scheduler. The script is 
							named stamp_dates.sh (for Linux) or stamp_dates.bat (for Windows). You must manually create the
							required cron job or scheduled task. Best do it now before you forget it.</li>
						</ul>
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
						<h2>Welcome to the LATRIX</h2>
						This page allows you to enter your initial configuration settings and
						create the first few records in the database, just enough to get you going, but without getting
						in the way.<br>
						In the first section you will need to enter the values that are required to connect to the 
						database. These values will be stored in a file on your server and for this the web site needs 
						write access permission to the folder /include. If you see an error message indicating that the
						config file could not be saved, you will need to change these permissions first.
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
				<td><div><p>Database Connection Parameters:</p></div></td>
				<td>Host Name: <br>Database Name: <br>User Name: <br>Password: </td>
				<td><input id="in_db_host" name="in_db_host" value="<?php echo $_POST['in_db_host']?>"><br>
					 <input id="in_db_name" name="in_db_name" value="<?php echo $_POST['in_db_name']?>"><br>
					 <input id="in_db_user" name="in_db_user" value="<?php echo $_POST['in_db_user']?>"><br>
					 <input id="in_db_pass" name="in_db_pass" value="<?php echo $_POST['in_db_pass']?>"><br>
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><hr class="separator"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3">
					<div>
						In the second section you will need to enter your company's name and the name of your current
						location (this will be used by the scanning stations and on reports, and you can add other
						locations later on).<br>
						The admin email address receives emails about system failures or other situations that need
						administrator intervention. A good idea is your personal email address.<br>
						The final email address is used as the sender of all messages. An example could be something
						like latrix@&lt;yourdomain.com&gt;. Obviously your mail server must be configured to accept email
						from this address (and the server where the site is hosted).<br>
						The setup process automatically determines your IP address (as seen by the web server), but you
						can alter these settings later. 
					</div>
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><hr class="separator"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td><div><p>Initial Configuration Values:</p></div></td>
				<td>Company Name: <br>Your location: <br>The admin email address: <br>The email address to send from: </td>
				<td><input id="in_company" name="in_company" value="<?php echo $_POST['in_company']?>"><br>
					 <input id="in_location" name="in_location" value="<?php echo $_POST['in_location']?>"><br>
					 <input id="in_email" name="in_email" value="<?php echo $_POST['in_email']?>"><br>
					 <input id="in_from" name="in_from" value="<?php echo $_POST['in_from']?>"><br>
				</td>
				<td></td>
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
					<input type="submit" name="btn_run" id="btn_run" value="Go !!!">
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

