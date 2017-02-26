<?php 
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
 
	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

$errorbox = new Errorbox(); 
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
if (isset($_COOKIE['latrax-session'])) {
	$config->endSession($_COOKIE['latrax-session']);
} else {
	$config->endSession(NULL);
}

?>
