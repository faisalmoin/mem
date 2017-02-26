<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
	require_once("include/defs.inc"); 
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("Mail.php");
	require_once("Mail/mime.php");

$errorbox = new Errorbox();
$dbc = new DB_Conn(); 

function secs2time($value) {
    // this will only work for time values up to 24 hours, beyond that the result is undefined
    $sign = '';
    if ($value < 0) {
            $sign = '-';
            $value = abs($value);
    }
    $hours = floor($value / 3600);
    $value -= $hours * 3600;
    $mins = floor($value / 60);
    $secs = $value - $mins * 60;
    return sprintf('%s%3d:%02d:%02d',$sign,$hours,$mins, $secs);
}

function time2secs($value) {
     // value must be in hh:mm:ss format
     return substr($value,0,2)*3600 + substr($value,3,2)*60 + substr($value,6,2);
}

function sendMail($to_address, &$body, $html_body) {
	global $company;
	if ($to_address == '') {
	   $msg = 'WARNING: There is no recipient address for'.$company[0]['name'].". Could not send the following message:\n";
           $body = $msg.$body;
	   $to_address = 'wolfgangs@manticoreit.com';
	}
	if ($body == '') {
		// there is no message, nothing to do;
		return;
	}
	$crlf = "\n";
	$mime = new Mail_mime($crlf);
	$headers = array('From' 	=> la_from_email,
						  'Subject' => '[LATRIX] Automated timestamp updates',
						  // Uncomment this to debug the script
						  // 'To' => 'la_admin_email');
						  // Uncomment  this to run the script live
						  'To'		=> $to_address);
	$mime->setTXTBody($body);
	// at the moment we won't do HTML messages, that's something for the future
	$mime->setHTMLBody($html_body);
	$msg_body = $mime->get();
	$headers = $mime->headers($headers);
	$mail =& Mail::factory('SMTP');
	if($err = $mail->send($to_address, $headers, $msg_body) != true) {
		if($err = $mail->send(la_admin_email, $headers, $msg_body) != true) {
			echo $err->toString();
		}
	}
}
/*
	This simple script will update various timestamps to default values, if real values are missing.
	These are the actions taken:
	a) if an employee has checked out, but not logged out, the logout time is set to checkout plus 15  seconds
	b) if an employee has logged out, but not checked out, the checkout time is set to logout minus 15 seconds
	c) if an employee has neither logged out nor checked out, checkout is set to 17:00, logout to 17:00:05
*/

$sql = "UPDATE presence p, attendance a SET p.end_time = sec_to_time(time_to_sec(a.end_time) + 15 )
		  WHERE p.att_date = a.att_date AND p.att_date = date_sub(curdate(), interval 1 day) 
		  AND p.emp_id = a.emp_id and p.start_time <= a.start_time
		  AND p.end_time = '00:00:00' and a.end_time <> '00:00:00'; ";
$dbc->exec($sql);
//echo ("logout times updated.");
$sql = "UPDATE presence p, attendance a SET a.end_time = sec_to_time(time_to_sec(p.end_time) - 15 )
		  WHERE p.att_date = a.att_date AND p.att_date = date_sub(curdate(), interval 1 day) 
		  AND p.emp_id = a.emp_id and p.start_time <= a.start_time
		  AND a.end_time = '00:00:00' and p.end_time <> '00:00:00'; ";
$dbc->exec($sql);
//echo ("checkout times updated.");
/* 
	For the remainder we have 2 different cases.
	Case 1: logout = 00:00:00 and no attendance record
	Case 2: logout = checkout = 00:00:00
	The theoretical 3rd case is not possible, as without presence record, no attendance record can exist

	For both cases we need to establish how long the employee concerned should have worked, add the default
	break length (unless they have taken breaks) and then subtract from the target end time 30 minutes.
	In case 1, staff will get punished anyway, as they have been AWOL as far as reporting is concerned. Therefore
	we will not create an attendance record, only update the presence record.
	In case 2, the above formula applies in full.
*/

$sql = "SELECT p.*, e.company_id, concat(e.sname, ',',e.fname) as emp_name FROM presence p INNER JOIN employees e using(emp_id) 
	LEFT JOIN attendance a on p.att_date = a.att_date and p.emp_id = a.emp_id
	WHERE p.att_date = date_sub(curdate(), interval 1 day) AND p.end_time = '00:00:00' and a.end_time IS NULL
	ORDER BY e.company_id;";
$rows = $dbc->query($sql);
$cid = 0;
if (count($rows) == 0) {	
	exit; 
	}
$rowcount = 0;
foreach ($rows as $row) {
	if ($cid != $row['company_id']) {
		$cid = $row['company_id'];
		$sql = "SELECT * FROM companies WHERE company_id = ".$cid;
		$company = $dbc->query($sql);
		$out = 'The following records were updated:<br><br>';
	}
	$emp_id = $row["emp_id"];
	$log_time = $row['start_time'];
	// now load the shift for this employee on this date. If there is no shift, use the default shift.
	// if the default shift shows no work time, this has been an unrequired presence and we set the end_time
	// to the start_time + 1 minute (after all, this is all after the fact and people don't stay overnight).
	$sql = "SELECT s.* from emp_shifts e INNER JOIN shifts s USING(shift_id) WHERE 
		shift_date=date_sub(curdate(), interval 1 day) AND emp_id=".$emp_id;
	$shift = $dbc->query($sql);
	if (count($shift) < 1) {
		$sql = "SELECT default_shift, default_shift_wend, default_hours FROM companies 
			WHERE company_id = ".$row["company_id"];
		$company = $dbc->query($sql);
		// get the default shift. Must differentiate between weekend and workdays.
		$info = getdate(time()-(24*60*60));
		if ($info['weekday'] == 'Sunday' || $info['weekday'] == 'Saturday') {
			$sql = "SELECT * from shifts WHERE shift_id = ".$company[0]["default_shift_wend"];
		} else {
			$sql = "SELECT * from shifts WHERE shift_id = ".$company[0]["default_shift"];
		}
		$shift = $dbc->query($sql);
	}
	if ($shift[0]["start_time"] == $shift[0]["end_time"]) {
		$diff = 60;
	} else {
		// now check if the difference between start and end is bigger than the default work time. If yes,
		// then this is a full work day -> use default work time minus 30 minutes.
		// if no, then this is a reduced day -> use the difference between start and end time minus 30 minutes.
		$daylength = time2secs($shift[0]["end_time"]) - time2secs($shift[0]["start_time"]);
		if ($daylength > time2secs($company[0]["default_hours"])) {
			$diff = time2secs($company[0]["default_hours"]) - 30*60;
		} else {
			$diff = $daylength - 30*60;
		}
		// echo("day: ".$daylength."diff: ".$diff."\n");
	}
	/*
	 so far so good. Now we cannot simply add the difference to the start time, because this employee could
	have logged in and out several times. Here are the different cases and the solutions for them:
	a) The employee logged in in the morning, but never out.
	b) The employee logged in and out several times, but forgot to log out in the afternoon
	c) The employee forgot to log in in the morning and instead logged in in the afternoon. Logout is missing
	algorithm:
	Find the first login time for the day.
	If this time is closer to the shift start than the shift end, then use it as the start time.
	If it is closer to the shift end, use it as the end time
	Calculate total presence time. There are 2 possible results: 0 and not 0
	If the result is 0 and the start time is given, the end time is start time plus diff
	If the result is 0 and the end time is given, the start time is end time minus diff
	If the result is not 0, the total work time is diff. In this case set the missing end time to start time plus diff minus
	the sum of all previous presence time.
	*/
	$sql = "SELECT min(p.start_time) AS min_time FROM presence p WHERE att_date = date_sub(curdate(),interval 1 day) AND emp_id = ".$emp_id;
	$data = $dbc->query($sql);
	$min_time = $data[0]['min_time'];
	$diff2start = abs(time2secs($min_time) - time2secs($shift[0]['start_time']));
	$diff2end = abs(time2secs($shift[0]['end_time']) - time2secs($min_time));
	$sql = "SELECT sum(time_to_sec(end_time) - time_to_sec(start_time)) AS total_time FROM presence WHERE
			  att_date = date_sub(curdate(), interval 1 day) and end_time <> '00:00:00' and emp_id = ".$emp_id;
	$data = $dbc->query($sql);
	$total_time = $data[0]['total_time'];
	if ($total_time == 0) {
		if ($diff2start < $diff2end) {
			// case a
			$end_time = secs2time(time2secs($log_time) + $diff);
			$sql = "UPDATE presence SET end_time = '".$end_time."' WHERE presence_id=".$row["presence_id"];
		} else {
			// case c
			$start_time = secs2time(time2secs($log_time) - $diff);
			$end_time = $log_time;
			$sql = "UPDATE presence SET end_time = '".$log_time."', start_time = '".$start_time."' WHERE presence_id=".$row['presence_id'];
		}
	} else {
		// case b
		$end_time = secs2time(time2secs($log_time) + $diff - $total_time);
		$sql = "UPDATE presence SET end_time = '".$end_time."' WHERE presence_id=".$row['presence_id'];
	}
	$dbc->exec($sql);
	$out .= $row['emp_name']." : required work time is ".secs2time($daylength).", adjusted to ".secs2time($diff).", new end time is ".$end_time."\n";
	if ($cid != $rows[$rowcount+1]['company_id']) {
		// next record is for a different company -> now send the email
		sendMail($company[0]['hr_email_adr'], $out, '');
	}
}

?>
