<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
*/
$page_load_start = microtime(true);
$pagetitle = "Time Tracker";

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

function checkButtons() {

global $db_conn, $errorbox, $msg, $user, $uid, $lid, $config, $sql_attendance, $sql_presence;

	$sql = "SELECT * FROM attendance a INNER JOIN employees e ON a.emp_id = e.emp_id WHERE e.emp_id = ".$uid
	." AND a.att_date = curdate() AND a.end_time ='00:00:00'"; 
	$stamp = $db_conn->query($sql);
	$sql = "SELECT * FROM presence a INNER JOIN employees e ON a.emp_id = e.emp_id WHERE e.emp_id = ".$uid
	." AND a.att_date = curdate() AND a.end_time ='00:00:00'"; 
	$presence = $db_conn->query($sql);
	// now we interpret the buttons (there must be one !!) and record attendance. 
	// error messages are only needed if we are on the password branch.
	switch ($_POST['logtype']) {
		case la_startwork:
			if (count($stamp) == 1 ) {
				$errorbox->add('You are already working, therefore you cannot start work again.');
			} elseif (count($presence) == 0) {
				$errorbox->add('You have not arrived yet, therefore you cannot start work.');
			} else {
				$sql_attendance = "INSERT INTO attendance (start_time,att_date,emp_id,location_id, start_type) VALUES(curtime(),curdate(),"
								 .$uid.",".$lid.",".la_startwork.")";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked in.";
				if ($config->company['double_login'] == 0) {
					$sql_presence = "INSERT INTO presence (start_time, att_date, emp_id, location_id, start_type) VALUES(curtime(),curdate(),"
								 .$uid.",".$lid.','.la_checkin.")";
				}
			}
			break;
		case la_breakin:
			if (count($stamp) == 1 ) {
				$errorbox->add('You are already at work, therefore you cannot come back from a break.');
			} elseif (count($presence) == 0) {
				$errorbox->add('You have not arrived yet, therefore you cannot come back from a break.');
			} else {
				$sql_attendance = "INSERT INTO attendance (start_time,att_date,emp_id,location_id, start_type) VALUES(curtime(),curdate(),"
								 .$uid.",".$lid.",".la_breakin.")";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked in.";
			}
			break;
		case la_transferin:
			if (count($presence) == 1) {
				$errorbox->add('You have already arrived, therefore you cannot transfer in.');
			} else {
				$sql_presence = "INSERT INTO presence (start_time, att_date, emp_id, location_id, start_type) VALUES(curtime(),curdate(),"
							 .$uid.",".$lid.','.la_transferin.")";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked in.";
			}
			break;
		case la_transferout:
			if (count($presence) == 0) {
				$errorbox->add('You have not arrived yet, therefore you cannot transfer out.');
			} else {
				$sql_presence = "UPDATE presence SET end_time = curtime(), end_type = ".la_transferout." WHERE emp_id = ".$uid." AND att_date = curdate() 
							 AND end_time = '00:00:00';";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked out.";
			}
			break;
		case la_breakout:
			if (count($stamp) == 0 ) {
				$errorbox->add('You are not currently logged in, therefore you cannot go on a break.');
			} elseif (count($presence) == 0) {
				$errorbox->add('You have not arrived yet, therefore you cannot go on a break.');
			} else {
				$sql_attendance = "UPDATE attendance SET end_time=curtime(), end_type=".la_breakout." WHERE att_date=curdate() AND emp_id=".$uid.
						" AND end_time='00:00:00'";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked out.";
			}
			break;
		case la_stopwork:
			if (count($stamp) == 0 ) {
				$errorbox->add('You are not currently working, therefore you cannot stop work.');
			} elseif (count($presence) == 0) {
				$errorbox->add('You have not arrived yet, therefore you cannot stop work.');
			} else {
				$sql_attendance = "UPDATE attendance SET end_time=curtime(), end_type=".la_stopwork." WHERE att_date=curdate() AND emp_id=".$uid.
						" AND end_time='00:00:00'";
				$msg = $user[0]['fname']." ".$user[0]['sname']." has checked out.";
				if ($config->company['double_login'] == 0) {
					$sql_presence = "UPDATE presence SET end_time = curtime(), end_type = ".la_checkout." WHERE emp_id = ".$uid." AND att_date = curdate() 
								 AND end_time = '00:00:00';";
					checkLoneWorker();
				}
			}
			break;
	}
}

function checkPresence() {

	global $sql_presence, $db_conn, $uid, $user, $msg, $lid, $cid;

	$sql = "SELECT * FROM presence a INNER JOIN employees e ON a.emp_id = e.emp_id WHERE e.emp_id = ".$uid
	." AND a.att_date = curdate() AND a.end_time ='00:00:00'"; 
	$presence = $db_conn->query($sql);
	if (count($presence) > 0) {
		$sql_presence = "UPDATE presence SET end_time = curtime(), end_type = ".la_checkout." WHERE emp_id = ".$uid." AND att_date = curdate() 
					 AND end_time = '00:00:00';";
		$msg = $user[0]['fname']." ".$user[0]['sname']." has logged out.";
		checkLoneWorker();
	} else {
		$sql_presence = "INSERT INTO presence (start_time, att_date, emp_id, location_id, start_type) VALUES(curtime(),curdate(),"
					 .$uid.",".$lid.",".la_checkin.")";
		$msg = $user[0]['fname']." ".$user[0]['sname']." has logged in.";
	}
}

function checkLoneWorker() {

	global $db_conn, $errorbox, $config, $lid, $cid;

	if ($config->company['lone_worker_warning'] == 1) {
		$sql = "SELECT count(*) AS emps FROM presence p INNER JOIN employees e ON p.emp_id = e.emp_id WHERE e.company_id = ".$cid;
		$sql .= " AND p.att_date = curdate() AND p.end_time = '00:00:00' AND p.location_id = ".$lid;
		$workers = $db_conn->query($sql);
		if ($workers[0]['emps'] == 2) {
			$errorbox->add("<div style=\"font-size: 16pt;\">You are leaving a lone worker behind.</div>");
		}
		if ($workers[0]['emps'] == 1) {
			$errorbox->add("<div style=\"font-size: 16pt;\">You are the last person leaving this location.</div>");
		}
	}
}

$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();

//print_r($_POST);
$cid = $config->getCompanyID();
$lid = $config->getLocationID();

// First establish the user ID from the keycode or username/password. If neither is valid, no further processing takes place
// and an appropriate message is displayed.
// if neither is present, nothing happens. 
$uid = 0;
$msg = '';
$sql_presence = '';
$sql_attendance = '';
if (isset($_POST['txtcode'])) {
	$code = trim($_POST['txtcode']);
	if (strpos($code,'*') === false) {
		$code = ltrim($code,'*');
		$code = rtrim($code,'*');
	}
	$sql = "SELECT * FROM employees WHERE company_id = ".$cid." and upper(keycode)='".strtoupper($code)."'";
	$user = $db_conn->query($sql);
	if (count($user) == 1) {
		$uid = $user[0]['emp_id'];
	} else {
		$errorbox->add('This keycode is not in my database. Please contact the HR Manager.');
		$msg = '';
	}
} elseif (isset($_POST['TxtUName'])) {
	$sql = "SELECT * FROM employees WHERE company_id = ".$cid." AND username='${_POST['TxtUName']}' AND password=AES_ENCRYPT('${_POST['TxtPWord']}','".la_aes_key."')"; 
	$user = $db_conn->query($sql);
	if ($user != NULL && count($user) == 1) {
		$uid = $user[0]['emp_id'];
	} else {
		$errorbox->add('This username/password combination is not in my database. Please contact the HR Manager.');
		$msg = '';
	}
}
if (isset($user) && count($user) > 1) {
	$errorbox->add("There is more than one user with this keycode or username/password, please contact the site owner.");
}
// Then check all possible conditions:
if ($uid != 0) {
// holiday login
	$leave = $db_conn->query("SELECT * FROM emp_leave l INNER JOIN employees e ON l.emp_id = e.emp_id ".
		"INNER JOIN leave_types lt ON l.type_id = lt.leave_type_id ".
		"WHERE e.emp_id='".$uid."' AND l.start_date < curdate() AND l.end_date > curdate() and e.company_id = ".$cid." AND (approved = 1 ".
		"AND lt.isAnnual = 1)");
	$holiday = $db_conn->query('SELECT * FROM holidays WHERE company_id = '.$cid.' and hdate = curdate()');
	if ($holiday != NULL && count($holiday) != 0 && $config->company['holiday_login'] ==0) {
		$errorbox->add('Today is a holiday. You cannot log in.');
		$msg = '';
	} elseif ($leave != NULL && count($leave) != 0 && $config->company['leave_login'] == 0) {
	// leave login (this should exclude half days, as this could cause problems if the employee leaves just after the half-day has started !!)
			$errorbox->add('You are on leave. You cannot log in.');
		$msg = '';
	} elseif (isset($_POST['txtcode'])) {
		// this is executed on the logger page.
		if ($config->company['double_login'] == 1) {
			//record presence or message 
			checkPresence();
		} else { //single login and keycode => logger page with all buttons
			//In this case a successful button check then creates also a presence recording 
			checkButtons();
		}
	} else {
		// this is executed on the checkin page (second stage login) => no presence recording.
		checkButtons();
	}
	if (count($holiday) != 0) {
		$errorbox->add("Today is a public holiday !! What are you doing here ?");
	}
	if (count($leave) != 0) {
		$errorbox->add("You are supposed to be on leave and enjoying yourself !! What are you doing here ?");
	}
	if ($sql_attendance != '') {
		$db_conn->exec($sql_attendance);
	}
	if ($sql_presence != '') {
		$db_conn->exec($sql_presence);
	}
}
	
	require_once("include/header.php");
if ($page_title == "checkin") {
print ("<body onload=\"document.getElementById('TxtUName').focus();\">");
} else {
print ("<body onload=\"document.getElementById('txtcode').focus(); Timer();\">");
}
?>
<script type="text/javascript" src="include/StandardScripts.js"></script>
<script type="text/javascript" src="include/ServerTime.js"></script>
<script type="text/javascript">
function Logger(type) {
	document.getElementById('logtype').value = type;
	document.getElementById('loggerme').click();
}
</script>
<?php
print("<form method=\"post\" action=\"".$page_title.".php\">\n");
?>
<table class="maintable">
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr>
	<td>
		<div class="bluehead"><?php echo $config->getCompanyName()?> Attendance Logger
		<input type="hidden" name="systime" id="systime" value="<?php echo date('H:i:s'); ?>"></div>
		<div class="showtime" id="timestamp"><?php echo date('H:i:s'); ?></div>
		<div class="serverdown" id="serverdown" style="visibility: hidden">
		<?php echo $msg?>
		</div>
		<div><br><?php echo "Welcome to ".$config->getLocationName() ?><br>
				Ready for the next employee.<br>
<?php
if ($page_title == 'logger') {
	if ($config->company['double_login'] == 0) {
		echo "\t\t<br>Please enter your staff key code or scan your ID card and press the relevant button\n";
	} else {
		echo "\t\t<br>Please enter your staff key code or scan your ID card\n";
	}
	echo "\t\t<br><input type=\"password\" name=\"txtcode\" id=\"txtcode\">\n";
} else {
?>
		<table>
			<tr>
				<td rowspan="5" style="width: 25%;"></td>
				<td colspan="2">Please enter your username 
	and password into the input boxes and click on the relevant button.</td>
				<td rowspan="5" style="width: 25%;"></td>
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
				<td colspan=2><br>Please note that usage of this site without authorization to do so represents a 
	legal offence and will be prosecuted by the site owner.</td>
			</tr>
		</table>
<?php 
}
?>
		</div>
	</td>
</tr>
<tr>
	<td><br>
<?php
if ($config->company['double_login'] == 0 || $page_title == "checkin") {?>
		<input type="button" onclick="Logger(1);" class="big-button" name="btnCheckIn" id="btnCheckIn" value="Start Work">
		<input type="button" onclick="Logger(2);" class="big-button" name="btnBreakIn" id="btnBreakIn" value="Back from Break">
		<input type="button" onclick="Logger(3);" class="big-button" name="btnTransferIn" id="btnTransferIn" value="Transfer In">
		<input type="button" onclick="Logger(6);" class="big-button" name="btnTransferOut" id="btnTransferOut" value="Transfer Out">
		<input type="button" onclick="Logger(5);" class="big-button" name="btnBreakOut" id="btnBreakOut" value="Out for Break">
		<input type="button" onclick="Logger(4);" class="big-button" name="btnCheckOut" id="btnCheckout" value="Finish Work">
		<input type="hidden" name="logtype" id="logtype" value="0">
		<input type="submit" value="submit" name="loggerme" id="loggerme" style="visibility: hidden;">
<?php } ?>
		<br>
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

