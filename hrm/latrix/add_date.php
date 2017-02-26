<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,7,8 Manticore Software
*/
require_once("include/defs.inc"); 
require_once("classes/errorbox.php");
require_once("classes/db_conn.php");

$errorbox = new Errorbox();
$dbc = new DB_Conn(); 
$sql = "SELECT max(short_date) AS max_date FROM dates;";
$last_date = $dbc->query($sql);
$daysecs = 24 * 60 * 60;
$start = strtotime(date('Y-m-d', strtotime($last_date[0]['max_date'])+$daysecs));
$date = date('Y-m-d',$start);
$sql = "INSERT INTO dates VALUES(NULL,'".$date."',".date('W',$start).",".date('m',$start).",".date('Y',$start);
$sql .= ",".date('d',$start).",".date('z',$start).",'".date('l',$start)."','".date('F',$start)."');";
$dbc->exec($sql);
?>