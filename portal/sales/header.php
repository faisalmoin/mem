<?php
	session_start();
	//Client Browser Detection
	$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
	$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
	
	//exit("Chrome: ".$chrome." // Firefox: ".$firefox);
	
	if ($firefox=="" && $chrome=="") {
		header('Location: ../BrowserCheck.php');
	}
	
	require_once("../db.txt");
	
	$UserName=strtoupper($_SESSION['UserName']);
	$LoginID=strtoupper($_SESSION['LoginID']);
	$Email=$_SESSION['Email'];
	$UserType=$_SESSION['UserType'];
	$SessionID=$_SESSION['SessionID'] ;
	$CompName=$_SESSION['CompName'];
	
	
	if(!isset($_SESSION['UserName'])){
		header("location:../index.php");
	}
	if(isset($SessionID)=="") exit("Security bridge...");
	
	//Get School Name
	$SchoolName = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [id]='$CompName'") or exit(odbc_errormsg($conn));
	$SchName = odbc_result($SchoolName, "School Name"); // Company Name
	$ms = $CompName; // Company ID
	
	if(!isset($UserName)){
		header("location:../logout.php?id=$LoginID");
	}
	
	if(isset($SessionID)=="") exit("Security bridge...");

	$LogDet = odbc_exec($conn, "SELECT [ActiveStat] FROM [login] WHERE [login]='$LoginID' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [login]='$LoginID')") or die(odbc_errormsg($conn));
	if(odbc_result($LogDet, "ActiveStat") != 1){
		header("location: ../logout.php?id=$LoginID");
	}

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
	<title>MEM ERP - Sales </title>
    
	<!-- Bootstrap core CSS -->
	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	
	<!-- link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" -->
	<link rel="stylesheet" href="../bs/css/jquery-ui.css">
	<script src="../bs/js/jquery-1.10.2.js"></script>
	<script src="../bs/js/jquery-ui.js"></script>
		
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
		<style>
			/* enable absolute positioning */
				.inner-addon { 
				position: relative; 
			}

			/* style icon */
			.inner-addon .glyphicon {
				position: absolute;
				padding: 10px;
				pointer-events: none;
			}

			/* align icon */
			.left-addon .glyphicon  { left:  0px;}
			.right-addon .glyphicon { right: 0px;}

			/* add padding  */
			.left-addon input  { padding-left:  30px; }
			.right-addon input { padding-right: 30px; }
			
			.modal-content{
				max-height: calc(100vh - 1px);
				overflow-y: auto;
			}
		</style>
	</head>
	
	<body oncontextmenu="return false">
	<?php echo $SchName;?>
		<div class="bs-example">
			<nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
				<div class="navbar-header">
					<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">
						<img src="../img/Logo MEM.png" alt="" style="width: 120px;">
					</a>
				</div>
				<div id="navbarCollapse" class="collapse navbar-collapse navbar-right">
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li class="dropdown">
							<a  class="dropdown-toggle" data-toggle="dropdown" href="#">Transactions <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<!--li><a href="Lead-List.php">Leads</a></li>
								<!-- li><a href="Lead-List.php">Activity</a></li>
								<li><a href="Lead-List.php">Meeting</a></li --> 
								<li><a href="Opp-List.php">Opportunity</a></li>
								<li><a href="Agr-List.php">Agreements</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a  class="dropdown-toggle" data-toggle="dropdown" href="#">Reports <span class="caret"></span></a>							
							<ul class="dropdown-menu">
								<li><a href="DailyActivity.php">Daily Activity</a></li>
								<li><a href="Agreement.php">Agreement</a></li>
							</ul>
						</li>
						<!--
						<form role="search" class="navbar-form navbar-left">
							<div class="input-group">
								<input type="text" placeholder="Search" class="form-control" required />
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</form>
						-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $UserName?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">My Account</a></li>
								<li><a href="ChangePassword.New.php">Change Password</a></li>
								<li class="divider"></li>
								<li><a href="../logout.php?id=<?php echo $LoginID?>">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<?php
			$Agr = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp No] NOT IN (SELECT [Opp No] FROM [CRM Agreement]) AND [Level] = 'Agreement signed' AND [Assign To]='$LoginID'");
			echo "Agreements: ". odbc_result($Agr, "");
			if(odbc_result($Agr, "") != 0){
				echo '<div class="container"><div class="container-fluid"><div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<a href="Agr-New.php" class="text-danger"><strong>Info!</strong> You have not filled up details of <b>'.odbc_result($Agr, "").'</b> Agreement records ...</a>
				</div></div></div>';
			}
		?>