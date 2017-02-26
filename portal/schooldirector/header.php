<?php
	session_start();
	//Client Browser Detection
	$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
	$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
	
	//exit("Chrome: ".$chrome." // Firefox: ".$firefox);
	
	if ($firefox=="" && $chrome=="") {
		header('Location: BrowserCheck.php');
	}
	
	require_once("../db.txt");
	
	$UserName=strtoupper($_SESSION['UserName']);
	$LoginID=strtoupper($_SESSION['LoginID']);
	$Email=$_SESSION['Email'];
	$UserType=$_SESSION['UserType'];
	$SessionID=$_SESSION['SessionID'] ;
	$CompName=$_SESSION['CompName'] ;
	
	if($LoginID == ""){
		header("location:../index.php");
	}
	if(isset($SessionID)=="") exit("Security bridge...");
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="../favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>MEM Director Account</title>
    
	<!-- Bootstrap core CSS -->
	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<script>
		/*function BrowserDetection() {
			if (navigator.userAgent.search("Firefox") >= 0) {
			
			}
			else{
				window.location.assign("BrowserCheck.php");
			}
		}*/
		
		//******** Disable F5 key ***********//
		$(document).bind('keydown keyup', function(e) {
			if(e.which === 116) {
				console.log('blocked');
				return false;
			}
			if(e.which === 82 && e.ctrlKey) {
				console.log('blocked');
				return false;
			}
		});
	</script>
	 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="../bs/js/jquery-1.10.2.js"></script>
	<script src="../bs/js/jquery-ui.js"></script>
	
	<script src="../bs/js/logout.js"></script>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<style id="jsbin-css">		
		table.floatThead-table {
			border-top: none;
			border-bottom: none;
			background-color: #fff;
		}
		</style>	
	</head>
	
	<body  oncontextmenu="return false" >