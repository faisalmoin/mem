<?php
	require_once("../db.txt");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Educomp School Portal</title>
    
	<!-- Bootstrap core CSS -->
	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	
	  <link rel="stylesheet" href="../bs/css/jquery-ui.css">
  <script src="../bs/js/jquery-1.10.2.js"></script>
  <script src="../bs/js/jquery-ui.js"></script>
  <link rel="stylesheet" href="../bs/css/style.css">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<style type="text/css">
		.navbar-default {
			background-color: #e74c3c;
			border-color: #c0392b; }
		.navbar-default .navbar-brand {
			color: #ecf0f1; }
		.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
			color: #ffbbbc; }
			.navbar-default .navbar-nav > li > a {
			color: #ecf0f1; }
		.navbar-default .navbar-nav > li > a:hover,
		.navbar-default .navbar-nav > li > a:focus {
			color: #ffbbbc; }
		.navbar-default .navbar-nav .active > a,
		.navbar-default .navbar-nav .active > a:hover,
			.navbar-default .navbar-nav .active > a:focus {
					color: #ffbbbc;
					background-color: #c0392b; }
		.navbar-default .navbar-nav .open > a, .navbar-default .navbar-nav .open > a:hover,
		.navbar-default .navbar-nav .open > a:focus {
			color: #ffbbbc;
			background-color: #c0392b; }
		.navbar-default .navbar-nav .open > a .caret,
		.navbar-default .navbar-nav .open > a:hover .caret,
		.navbar-default .navbar-nav .open > a:focus .caret {
			border-top-color: #ffbbbc;
			border-bottom-color: #ffbbbc; }
		.navbar-default .navbar-nav > .dropdown > a .caret {
			border-top-color: #ecf0f1;
			border-bottom-color: #ecf0f1; }
		.navbar-default .navbar-nav > .dropdown > a:hover .caret,
		.navbar-default .navbar-nav > .dropdown > a:focus .caret {
			border-top-color: #ffbbbc;
			border-bottom-color: #ffbbbc; }
		.navbar-default .navbar-toggle {
			border-color: #c0392b; }
		.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
			background-color: #c0392b; }
		.navbar-default .navbar-toggle .icon-bar {
			background-color: #ecf0f1; }

		@media (max-width: 767px) {
			.navbar-default .navbar-nav .open .dropdown-menu > li > a {
			color: #ecf0f1;   }
		.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
		.navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
			color: #ffbbbc;
			background-color: #c0392b;   }
		}

		html {
			padding-top: 30px; }

		a.solink {
			position: fixed;
			top: 0;
			width: 100%;
			text-align: center;
			background: #f3f5f6;
			color: #cfd6d9;
			border: 1px solid #cfd6d9;
			line-height: 30px;
			text-decoration: none;
			transition: all 0.3s;
			z-index: 999; }

		a.solink::first-letter {
			text-transform: capitalize; }

		a.solink:hover {
			color: #428bca; }

		.btn, .form-control, input, select, navbar{
			border-radius: 0px;
		}
		#btn-create{
			position: fixed;
			bottom: 10px;
			right: 10px;
			z-index: 999999;
		}
	</style>	
	</head>
	
	<body>
	
	<!-- Fixed navbar -->
	<nav class="navbar-fixed-top" style="background-color: #fff;">
		<!-- <nav role="navigation" class="navbar navbar-inverse navbar-static-top"> -->
		<nav role="navigation" class="navbar navbar-default navbar-static-top">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">School ERP</a>
			</div>
			<!-- Collection of nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
					
				</ul>
				<form role="search" class="navbar-form navbar-left" action="Search.php" method="GET">
					<div class="input-group">
						<input type="text" placeholder="Search" class="form-control" name="AdmNo" required />
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</div>
					</div>
				</form>				
				<ul class="nav navbar-nav">
					<li><a href="Setup.php"><span class="glyphicon glyphicon-cog"></span> Setup</a></li><!--
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span> Settings <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Company</a></li>
							<li><a href="#">User</a></li>
							<li class="divider"></li>
							<li><a href="#" class="disabled">School</a></li>
							<li><a href="#">Academic Year</a></li>
							<li><a href="#">Class</a></li>
							<li><a href="#">Curriculum</a></li>
							<li><a href="#">Curriculum</a></li>
						</ul>
					</li> -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrator <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">My Account</a></li>
							<li><a href="ChangePassword.php">Change Password</a></li>
							<li class="divider"></li>
							<li><a href="../logout.php?id=<?php echo 'admin'?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
			</div>
		</nav>
	</nav>
	
	<br /><br />
