<?php
/*
   LATRIX - attendance tracking and reporting
   Copyright (C) 2006,7 Manticore Software
   Published under GPL V3, see admin.php for more detail

	Report Runner 
	
	This file provides the framework to run scheduled reports at night time. It loads all relevant
	data from the database, figures out which reports need running, then builds the parameter array
	from the various data provided in the database, instantiates the correct report and runs it.
	Finally, the results are mailed to the requested email address.
	Simple, isn't it ?
	
	OK let's get about it.
*/

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("Mail.php");
	require_once("Mail/mime.php");

	$page_load_start = microtime(true);
	$pagetitle = "Report Runner";
	$errorbox = new Errorbox();
	$db_conn = new DB_Conn();
	$config = new Config($db_conn);
	/* As there is no post, the new config object is mssing some data and we cannot simply call the other
		functions that would set the data, as we are not in a page context. Therefore we now need to populate
		the necessary data from the user_id in the report definition. This happens further down
	*/

	$day_of_week = date('w');
	$day_of_month = date('j');
	$sql = "SELECT * FROM report_schedule WHERE (sched_type = 4 AND sched_day = ".$day_of_month.") OR
			  (sched_type = 3 AND sched_day = ".$day_of_week.") OR sched_type = 1";
	if ($day_of_week > 0 && $day_of_week < 6) {
		$sql .= " OR sched_type = 2";
	}
	$sql .= " ORDER BY rb_type, rb_group, groups, rb_range, ranges, details, subtotals, totals;";
	$reports = $db_conn->query($sql);
	
	foreach ($reports as $report) {
	
		$par = buildParArray($report);
		$config->loadFromUser($report['user_id']);
		execute($par);
	}
	
function buildParArray($def) {
	/* Now we convert the parameters in the datarow back into an array that looks like a POST,
		except it isn't. The ranges are given as differences to the current day, with positive values
		pointing into the past and negative values into the future. 0 indicates the current day/week/month/year.
	*/
	$par['rb_type'] = $def['rb_type'];
	$par['rb_att_group'] = $def['rb_group'];
	$par['rb_att_range'] = $def['rb_range'];
	switch($par['rb_att_group']) {
		case 'att_emp':
			$par['sel_emp'] = explode(',',$def['groups']);
			break;
		case 'att_team':
			$par['sel_team'] = explode(',',$def['groups']);
			break;
		case 'att_dept':
			$par['sel_dep'] = explode(',',$def['groups']);
			break;
	}
	if ($def['details'] == 0) { $par['cb_show_details'] = ''; } else { $par['cb_show_details'] = 'checked'; }
	if ($def['subtotals'] == 0) { $par['cb_show_subtotals'] = ''; } else { $par['cb_show_subtotals'] = 'checked'; }
	if ($def['totals'] == 0) { $par['cb_show_totals'] = ''; } else { $par['cb_show_totals'] = 'checked'; }
	switch ($par['rb_att_range']) {
		case 'att_day':
			$par['in_dates'] = convertFromDiff($def['ranges'],1);
			break;
		case 'att_week':
			$par['in_weeks'] = convertFromDiff($def['ranges'],2);
			break;
		case 'att_month':
			$par['sel_months'] = convertFromDiff($def['ranges'],3);
			break;
		case 'att_year':
			$par['sel_years'] = convertFromDiff($def['ranges'],4);
	}
	$par['rb_action'] = 'mail';
	$par['rb_mailto'] = 'rb_other';
	$par['mail_adr'] = $def['mailto'];
	$par['in_file'] = $def['format'];
	return $par;
}

function convertFromDiff($value,$type) {
	$values = explode(',',$value);
	switch ($type) {
	case 1:	// values are day differences
		foreach ($values as $diff) {
			$res[$cnt++] = date('Y-m-d',strtotime((-1*$diff).' days'));
		}
	case 2:	// values are week differences
		foreach ($values as $diff) {
			$res[$cnt++] = date('Y-m-d',strtotime((-1*$diff).' week'));
		}
	case 3:	// values are month differences
		foreach ($values as $diff) {
			$res[$cnt++] = date('Y-m-d',strtotime((-1*$diff).' month'));
		}
	case 4:	// values are year differences
		foreach ($values as $diff) {
			$res[$cnt++] = date('Y-m-d',strtotime((-1*$diff).' year'));
		}
	}

function execute($par) {

	global $errorbox, $db_conn, $config;

	// this has to be a separate function to keep the include at a function level. Only then the
	// class included will be dropped after the function execution and replace with a different one
	// when the function is called on the next turn. 

	// this instantiates the correct type of report based on the values in $par
	require_once("classes/reportbase.php");		// only now we know what type of report we need
	$report = new Report($db_conn, $par, $config, $errorbox);
	$report->initialise();
	if ($errorbox->isEmpty()) {
		$report->process();
	} else {
		// report an error to the system admin
	}
	$repname = $report->createFile();

	$mailadr = trim($par['mail_adr']);
	if ($mailadr != '') {
		$crlf = "\n";
		$mime = new Mail_mime($crlf);
		$headers = array('From' => 	'admin@latrix.co.uk',
							  'Subject' => 'LATRIX Report : '.$repname,
							  'To'	=> 	$mailadr);
		$mime->setTXTBody('I have been requested to mail the attached report to this address.');
		$mime->setHTMLBody('');
		$mime->addAttachment($repname,'text/plain'); 
		$body = $mime->get();
		$headers = $mime->headers($headers);
		$recipients = $mailadr;
		$mail =& Mail::factory('SMTP');
		if($err = $mail->send($recipients, $headers, $body) != true) {
			$errorbox->add($err->toString()); 
		}
		$errorbox->add('This report has been emailed to the address given.');
		break;
	} else {
		$errorbox->add('You do not have an email address (or have not entered one), cannot mail to you.');
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
	print '<title>'.la_version.$pagetitle.'</title>';
?>
<meta name="generator" content="Bluefish 1.0.7">
<meta name="author" content="Wolfgang Schulze-Zachau">
<meta name="copyright" content="Manticore Software">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<LINK href="include/styles.css" type="text/css" rel="stylesheet">
<link href="include/admin-styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<script type="text/javascript" src="include/StandardScripts.js"></script>
<script type="text/javascript" src="include/showdiv.js"></script>
<form id="latform" method="post" action="reportbuilder.php">
<table class="maintable" cellspacing="0px" cellpadding="0px">
<tr>
	<td>
	<?php include 'include/lheader.php'; ?>
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

