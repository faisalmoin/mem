<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
*/
	require_once("include/defs.inc"); 
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");

$errorbox = new Errorbox();
$dbc = new DB_Conn(); 

/*
	This simple script will update various timestamps to default values, if real values are missing.
	These are the actions taken:
	a) if an employee has checked out, but not logged out, the logout time is set to checkout plus 5 seconds
	b) if an employee has logged out, but not checked out, the checkout time is set to logout minus 5 seconds
	c) if an employee has neither logged out nor checked out, checkout is set to 17:00, logout to 17:00:05
*/

$sql = "UPDATE presence p, attendance a SET p.end_time = sec_to_time(time_to_sec(a.end_time) + 5)
		  WHERE p.att_date = a.att_date AND p.att_date = date_sub(curdate(), interval 3 day) 
		  AND p.emp_id = a.emp_id and p.start_time <= a.start_time
		  AND p.end_time = '00:00:00' and a.end_time <> '00:00:00'; ";
$dbc->exec($sql);
echo ("logout times updated.\t");
$sql = "UPDATE presence p, attendance a SET a.end_time = sec_to_time(time_to_sec(p.end_time) - 5)
		  WHERE p.att_date = a.att_date AND p.att_date = date_sub(curdate(), interval 3 day) 
		  AND p.emp_id = a.emp_id and p.start_time <= a.start_time
		  AND a.end_time = '00:00:00' and p.end_time <> '00:00:00'; ";
$dbc->exec($sql);
echo ("checkout times updated.\t");
$sql = "UPDATE presence p, attendance a SET p.end_time = '17:00:05', a.end_time = '17:00:00'
		  WHERE p.att_date = a.att_date AND p.att_date = date_sub(curdate(), interval 3 day) 
		  AND p.emp_id = a.emp_id and p.start_time <= a.start_time
		  AND a.end_time = '00:00:00' and p.end_time = '00:00:00'; ";
$dbc->exec($sql);
echo ("missing timestamps set to defaults.\n");
?>
