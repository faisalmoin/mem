<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$par = $_POST;

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");
	require_once("classes/control.php");
	require_once("classes/reportbase.php");
	require_once("Mail.php");
	require_once("Mail/mime.php");

$page_load_start = microtime(true);
$pagetitle = "Report Builder";
$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$config->checkUser();						// this checks the cookie and loads company information
/*
	Flow:
	1.) load all the POST data into an array. If the report is run from a cron job, the framework will provide 
		 this data, but it won't be in a superglobal, but at least we can explode it into an array that looks like
		 a POST.
	2.) Populate the employee data
	3.) depending on the report, populate leave, attendance, presence, exceptions (half-day leave), shifts
		 this should use a matrix, so we can easily extend it for future reports.
	4.) process the report data. This creates a second structure containing the actual report data.
		 The report data is basically a big spreadsheet of cells. Each cell contains one value.
	5.) fill the report template with the data. There has to be a template for each report. We could have more than 
		 one template per report (this would be an additional option when the report is selected).
	6.) provide the output as requested by the user. This could be a page, a file for download or attached to an e-mail.
*/
$report = new Report($db_conn, $_POST, $config, $errorbox);

if ($par['rb_action'] != 'sched') {
	$report->initialise();

// now we process the raw data.
	if ($errorbox->isEmpty()) {
		$report->process();

// and finally we output the data to the target. If the target is a page, it gets produced here.
// if the target is a mail attachment, we create the attachment, send the mail and we are done.
// if the target is scheduled run, then same as mail attachment
// if the target is a file for download, we create the file, open the download window and off we go.

// So all output will go through a file. simplest case is the CSV format.
// HTML format is a bit more complex and finally PDF gets created from HTML by going through a converter.
// (that is if I can get the converter to work. Otherwise I will have to use fdpf and create the PDF files
// from scratch (uuarghhh !!!)
// Display as a page simply forwards the client the newly created file. If it is HTML, it will display.
// Download points the header to the newly created file.
// mail attachment creates a mail object, attaches the file and sends it off.
// scheduling will display an confirmation page and then possibly show all scheduled reports for the current
// user. And of course, it has to insert the new schedule item into the schedule.

	$repname = $report->createFile();
}

	switch($par['rb_action']) {
		case 'html':
		case 'file':
			if ($errorbox->isEmpty()) {
				header('Location: '.$report->getFileName());
			}
			break;
		case 'mail':
			if ($errorbox->isEmpty()) {
				$mailadr = '';
				if ($par['rb_mailto'] == 'me') {
					$sql = "SELECT email from employees where emp_id = ".$config->config['user_id'];
					$maildata = $db_conn->query($sql);
					$mailadr = $maildata[0]['email'];
					$errorbox->debug('Mail address is: '.$mailadr);
				} else {
					$mailadr = trim($par['mail_adr']);
				}
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
			break;
		case 'sched':
			$pagetitle = 'Report Schedule';
			// OK, so how do we get the full POST into the database in such a manner that it can be reconstructed
			// later ? Well, we actually don't need the full POST.
			// We need type, group, range, the relevant group selector, relevant range selector, checkboxes, output 
			// format and e-mail address.
			// In order to run the scheduled report we also need the schedule date
			// This is aggravated by the fact that scheduled reports need to run on data with a date range difference
			// to the original selection (otherwise they are always out of date).
			switch($par['rb_att_group']) {
			case 'att_emp':
				$groups = implode(',',$par['sel_emp']);
				break;
			case 'att_team':
				$groups = implode(',',$par['sel_team']);
				break;
			case 'att_dept':
				$groups = implode(',',$par['sel_dep']);
				break;
			case 'att_all':
				$groups = '';
			}
			switch($par['rb_att_range']) {
			/* On top of getting the selected ranges, these also need to be converted into differences instead
				of absolute values. In this context 0 means the current day/week/month/year, positive figures 
				point into the past, negative into the future. At runtime these figures are then converted into
				actual dates, weeks, etc.
			*/
			case 'att_day':
				$range = convert2diff($par['in_dates'],1);
				break;
			case 'att_week':
				$range = convert2diff($par['in_weeks'],2);
				break;
			case 'att_month':
				$range = convert2diff($par['sel_months'],3);
				break;
			case 'att_year':
				$range = convert2diff($par['sel_years'],4);
			}
			if ($par['rb_mailto'] == 'rb_me') {
				$sql = "SELECT email from employees where emp_id = ".$config->config['user_id'];
				$mailadr = $db_conn->query($sql);
			} else {
				$mailadr = trim($par['mail_adr']);
			}
			switch($par['in_sched']) {
				case 1:	// daily
				case 2:	// Monday through Friday
					$schedtype = 0;
					break;
				case 3:	// Day of the week
					$schedtype = $par['in_schedday'];
					break;
				case 4:	// day of the month
					$schedtype = $par['in_monthday'];
			}
			$sql = "INSERT INTO report_schedule (report_name, user_id, rb_type, rb_group, groups, rb_range,
					  ranges, details, subtotals, totals, mailto, sched_type, sched_day, format) VALUES (
					  'My First Report',".$config->config['user_id'].",'".$par['rb_type']."','".$par['rb_att_group']."','
					  ".$groups."','".$par['rb_att_range']."','".$range."',";
			if ($par['cb_show_details'] == '') { $sql.= 0; } else { $sql .= 1; }
			$sql .= ',';
			if ($par['cb_show_subtotals'] == '') { $sql.= 0; } else { $sql .= 1; }
			$sql .= ',';
			if ($par['cb_show_totals'] == '') { $sql.= 0; } else { $sql .= 1; }
			$sql .= ",'".$mailadr."',".$par['in_sched'].",".$schedtype.",'".$par['in_file']."');";
			$errorbox->debug($sql);
			$db_conn->exec($sql);
			$errorbox->add('The requested report has been added to the list of scheduled reports. All scheduled
								 reports run at 00:30 in the morning.');
	}
}

function convert2diff($values,$type) {
	$cnt = 0;
	switch ($type) {
		case 1:	//	values are dates in format YYYY-MM-DD -> differences are in days
			$today = date('Y-m-d');
			foreach($values as $value) {
				$diff[$cnt++] =  floor((strtotime($today) - strtotime($value))/86400);
			}
			break;
		case 2:	// values are weeks in format YYYY-WW -> differences are in weeks
			$this_week = date('W');
			$this_year = date('Y');
			foreach($values as $value) {
				$diff[$cnt++] = (($this_year - substr($value,0,4)) * 52) + $this_week - substr($value,5,2);
			}
			break;
		case 3:	// values are months in format YYYY-MM
			$this_month = date('m');
			$this_year = date('Y');
			foreach($values as $value) {
				$diff[$cnt++] = (($this_year - substr($value,0,4)) * 52) + $this_month - substr($value,5,2);
			}
			break;
		case 4:	// values are business years
			$this_year = date('Y');
			foreach($values as $value) {
				$diff[$cnt++] = $this_year - $value;
			}
	}
	return implode(',',$diff);
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
<script language="JavaScript" src="include/showdiv.js"></script>
<script language="JavaScript" src="include/StandardScripts.js"></script>
<body>
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

