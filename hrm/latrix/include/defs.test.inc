<?php 

define('la_short_version','0.6.0 ');
define('la_version','LATRIX V'.la_short_version);

define("db_name","latrix");				// the name of the database
define("db_host","127.0.0.1");				// the name or IP address of the host computer
define("db_user","latrix");					// user name for this database
define("db_pw","latrix");						// password for this database 

define("la_adjustment", 60*35);				// subtract 30 minutes for lunch and 5 minutes for getting in and out
define("la_day_secs", 60*60*24);				// number of seconds in a normal day

define('la_admin_email','wolfgangs@manticoreit.com');
define('la_from_email','admin@latrix.co.uk');

// DO NOT CHANGE ANYTHING BELOW THIS LINE  

define("la_date", 0);							// enumeration for fields in rows
define("la_name",0);
define("la_start", 1);
define("la_end", 2);
define("la_target", 3);
define("la_raw", 4);
define("la_adjust", 5);
define("la_perc", 6);
define("la_late", 7);
define("la_awol", 8);
define("la_hol", 9);
define("la_leave",10);
define("la_mod", 11);

define ("la_first_line",0);
define ("la_line",1);							// types for show_totals()
define ("la_emp",2);
define ("la_team",3);
define ("la_dep",4);
define ("la_all",5);

define ("lu_employee",1);
define ("lu_manager",2);
define ("lu_admin",3);
define ("lu_gm",4);
define ("lu_owner",5);
define ("LEVEL_EMPLOYEE",1);
define ("LEVEL_MANAGER",2);
define ("LEVEL_ADMIN",3);
define ("LEVEL_GM",4);
define ("LEVEL_OWNER",5);

define ("la_startwork",1);
define ("la_breakin",2);
define ("la_transferin",3);
define ("la_stopwork",4);
define ("la_breakout",5);
define ("la_transferout",6);
define ("la_checkin",7);
define ("la_checkout",8);
define ("la_undefined",9);

define ("TPL_APP_LEAVE_EMP",1);
define ("TPL_APP_LEAVE_MGR",2);
define ("TPL_APR_LEAVE_EMP",3);
define ("TPL_APR_LEAVE_MGR",4);
define ("TPL_NEW_EMP_EMP",5);
define ("TPL_NEW_EMP_MGR",6);
define ("TPL_DIS_EMP_EMP",7);
define ("TPL_DIS_EMP_MGR",8);
define ("TPL_DEL_LEAVE_EMP",9);
define ("TPL_DEL_LEAVE_MGR",10);
define ("TPL_APP_EXC_EMP",11);
define ("TPL_APP_EXC_MGR",12);
define ("TPL_APR_EXC_EMP",13);
define ("TPL_APR_EXC_MGR",14);
define ("TPL_DEL_EXC_EMP",15);
define ("TPL_DEL_EXC_MGR",16);

define ("PAR_EMP_NAME", 0);
define ("PAR_START_DATE", 1);
define ("PAR_END_DATE", 2);
define ("PAR_RESULT", 3);
define ("PAR_DAYS", 4);
define ("PAR_UNAME", 5);
define ("PAR_PWORD", 6);
define ("PAR_CURDATE", 7);
define ("PAR_RECEIVER", 8);
define ("PAR_LEAVETYPE", 9);
define ("PAR_START_TIME", 10);
define ("PAR_END_TIME", 11);
define ("PAR_URL", 12);

define ("la_aes_key",'secrecy_is_good');
define ("debugging_on",1);

?>
