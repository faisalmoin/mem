<?php 
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software

*/
	require_once("Image/Barcode/Code39.php");
	require_once("Image/Barcode.php");
	$code = "0000";
	$format = "png";
	$hideText = false;
	$height = 50;

	if ($_REQUEST['keycode'] != "") {
		$code = $_REQUEST['keycode'];
	}
	if ($_REQUEST['format'] != "") {
		$format = $_REQUEST['format'];
	}
	if ($_REQUEST['hide'] != "") {
		$hideText = $_REQUEST['hide'];
	}
	if ($_REQUEST['height'] != "") {
		$height = $_REQUEST['height'];
	}

	Image_Barcode::draw($code,'Code39','png');
?>
