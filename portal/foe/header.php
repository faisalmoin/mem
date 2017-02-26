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
	<title>MEM School Portal</title>
    
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
			if (navigator.userAgent.search("Firefox") >= 0 || navigator.userAgent.search("Chrome") >= 0) {
			
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
	
	<!--<body  oncontextmenu="return true" onload="BrowserDetection();" > -->
	<body  oncontextmenu="return true" >
		<div id="timer">1250</div>
		<div class="bs-example">
			<nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
				<div class="navbar-header">
					<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<a href="#" class="navbar-brand"><?php echo $SchName;?></a>
				</div>
				<!-- <div id="navbarCollapse" class="collapse navbar-collapse navbar-right"> -->
				<div id="navbarCollapse" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="home.php">Home</a></li>
						<li class="dropdown">
							<a  class="dropdown-toggle" data-toggle="dropdown" href="#">Admission Module <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="disabled" style="background-color: #E5E4E2;"><a>Enquiry</a></li>
								<li><a href="NewEnquiry.php">New Enquiry</a></li>
								<li><a href="ListEnquiry.php">List Enquiry</a></li>
								<li class="divider"></li>
								<li class="disabled" style="background-color: #E5E4E2;"><a tabindex="-1" href="#">Registration</a></li>
								<li><a href="EnquiryDone.php">Sale of Registration</a></li>
								<li><a href="RegistrationConfirmationList.php">Registration Confirmation</a></li>
								<li><a href="RegistrationList.php">List Registration</a></li>
								<li class="divider"></li>
								<li class="disabled" style="background-color: #E5E4E2;"><a tabindex="-1" href="#">Selection</a></li>
								<li><a href="NewSelection.php">New Selection</a></li>
								<li><a href="ListSelection.php">List Selected Candidate</a></li>
							</ul>
						</li>
						<!--
						<li class="dropdown">
							<a  class="dropdown-toggle" data-toggle="dropdown" href="#">Enquiry <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="NewEnquiry.php">New Enquiry</a></li>
								<li><a href="ListEnquiry.php">List Enquiry</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Registration <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="EnquiryDone.php">Sale of Registration</a></li>
								<li><a href="RegistrationConfirmationList.php">Registration Confirmation</a></li>
								<li><a href="RegistrationList.php">List Registration</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Selection <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="NewSelection.php">New Selection</a></li>
									<li><a href="ListSelection.php">List Selected Candidate</a></li>
								</ul>
						</li>
						-->
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Student <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="StudentList.php">Student List</a></li>
									<li><a href="Card.php">Student Card</a></li>
									<li><a href="StudentTC.php">Transfer Certificate</a></li>
								</ul>
						</li>
						<li class="dropdown">
							<a  class="dropdown-toggle" data-toggle="dropdown" href="#">Reports <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="RptEnquiry.php">Enquiry</a></li>
								<li><a href="RptAdmission.php">Admission</a></li>
								<li><a href="RptStuStrength.php">Student Strength</a></li>
								<li><a href="RptTransCert.php">Transfer Certificate</a></li>
                                                                <li><a href="Fee14.php">Fee Structure</a></li>
								<!-- <li><a href="ListEnquiry.php">List Enquiry</a></li> -->
							</ul>
						</li>
						<!-- <li><a href="Search.php">Search</a></li> -->
						<form role="search" class="navbar-form navbar-left" method="GET" action="Search.php">
							<div class="input-group">
								<input type="text" placeholder="Search" name="AdmNo" class="form-control" required />
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</form>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $UserName?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">My Account</a></li>
								<li><a href="ChangePassword.New.php">Change Password</a></li>
								<!-- <li><a href="../../issuetrack/user/">Issue Tracker</a></li> -->
								<li class="divider"></li>
								<li><a href="../logout.php?id=<?php echo $LoginID?>">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>

				<?php $Approval = odbc_exec($conn, "SELECT [ApproverID] FROM [approvalmaster] WHERE [UserID]='$L_ID' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
				if(odbc_result($Approval, "ApproverID")==""){ 
             ?>
             <div>
             	
				<div class="alert alert-warning">
                <strong>Warning!</strong>  Approval ID Not Assigned for this Account.</div>
             </div>
             <?php }

             ?>
			</nav>
		</div>
            
		