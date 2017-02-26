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
if (date("d") != '01') return; 

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
						  'Subject' => '[LATRIX] Remaining leave for your team members',
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
	// Just for debugging
	echo $body;
	return;
	// end debugging
	if($err = $mail->send($to_address, $headers, $msg_body) != true) {
		if($err = $mail->send(la_admin_email, $headers, $msg_body) != true) {
			echo $err->toString();
		}
	}
}

/*
	This simple script will inform managers of the days of annual leave left for each of their team members.
	Prerequisites for this are:
	a) the manager has team members
	b) the manager has an email address
	The script is run daily from a cron job, but should only really email managers at the end of each month, so
	it first needs to figure out whether the current date is the start of the month.
	It then creates a list of managers (for all companies in the database) and works through that list
	For each manager it compiles a list of employees, complete with annual leave left.
	It then compiles an email to the manager, listing all employees with their remaining leave.
	Finally it sends the emails.
	Done.
*/

$sql = "SELECT d.name, sum(if(e.emp_id is not null and e.enabled = 1,1,0))  as members, 
		  concat(e2.fname,' ',e2.sname) as manager, e2.email, group_concat(e.emp_id) as emp_ids 
		  FROM departments d INNER JOIN companies c using ( company_id) LEFT JOIN teams t using (dept_id) 
		  LEFT JOIN employees e on t.team_id = e.team_id LEFT JOIN employees e2 on d.manager_id = e2.emp_id 
		  GROUP BY d.name HAVING members > 0;";
$managers = $dbc->query($sql);
foreach ($managers as $manager) {
	if ($manager['emp_ids'] != '') {
		$sql = "select concat(e.fname, ' ', e.sname) as name, a.leave_left
				  from employees e inner join annual_leave a on e.emp_id = a.emp_id 
				  inner join business_years b on a.year_id = b.business_year_id
				  where e.emp_id in (".$manager['emp_ids'].") and e.enabled = 1 
				  and b.year_start < now() and b.year_end > now();";
		$employees = $dbc->query($sql);
		$body = "Dear ".$manager['manager'].",\n\n";
		$body .= "your team members have the following amount of annual leave left in the current business year:\n\n";
		if (count($employees) != 0) {
			foreach ($employees as $employee) {
				$body .= $employee['name']."\t\t\t".$employee['leave_left']." days\n";
			}
			$body .= "\nbest regards\n\nthe LATRIX (is with you all the way)\n";
			sendMail($manager['email'], $body, '');
		}
	}
}

?>

