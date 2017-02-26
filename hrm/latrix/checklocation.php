<?php

	require_once("classes/config.php");

$ipadr = $_SERVER['REMOTE_ADDR'];
$config = new Config($db_conn, $ipadr);
if (!$config->isValid()) { header ('Location: badlocation.php');}

?>