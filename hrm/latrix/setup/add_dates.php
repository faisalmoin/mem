<?php
$page_load_start = microtime(true);
$pagetitle = "Administration";
//var_dump($_POST);
//print_r($_POST);
	require_once("../include/defs.inc");	//this can be moved down, once the page size is established from the company settings.
	require_once("../classes/errorbox.php");
	require_once("../classes/db_conn.php");

$errorbox = new Errorbox();
//var_dump($page->ctrl);
//var_dump($_POST);
$db_conn = new DB_Conn();
$daysecs = 24 * 60 * 60;
$start = strtotime(date('Y-m-d', strtotime('-750 days')));
do {
	$date = date('Y-m-d',$start);
	$sql = "INSERT INTO dates VALUES(NULL,'".$date."',".date('W',$start).",".date('m',$start).",".date('Y',$start);
	$sql .= ",".date('d',$start).",".date('z',$start).",'".date('l',$start)."','".date('F',$start)."');";
	$db_conn->exec($sql);
	/*
  `date_id` int  NOT NULL AUTO_INCREMENT,
  `short_date` date  NOT NULL,
  `week` SMALLINT  NOT NULL,
  `month` smallint  NOT NULL,
  `year` int  NOT NULL,
  `day` smallint  NOT NULL,
  `yearday` MEDIUMINT  NOT NULL,
  `weekday` varchar(10)  NOT NULL,
  `month_name` varchar(10)  NOT NULL,
	*/
	$start += $daysecs;
} while (date('Y-m-d',$start) < date('Y-m-d', strtotime('+365 days')));

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
	<meta name="document-state" content="dynamic">
	<LINK href="include/styles.css" type="text/css" rel="stylesheet">
	<LINK href="include/admin-styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<p>Done.</p>
			<?php include '../include/lfooter.php'; ?>
</body>
</html>

