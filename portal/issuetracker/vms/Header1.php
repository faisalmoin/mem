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
       
	
	
	$SchoolName = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [id]='$CompName'") or exit(odbc_errormsg($conn));
	$SchName = odbc_result($SchoolName, "School Name");
    $address = odbc_result($SchoolName, "Address");
    $city = odbc_result($SchoolName, "City");
	$phone = odbc_result($SchoolName, "Phone No_"); //SchoolName
	
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>MEM School Portal</title>
    
    <link href="../bs/css/bootstrap.min.css" rel="stylesheet" /><link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../bs/js/ie-emulation-modes-warning.js"></script>
    <script src="../bs/js/jquery.min.js"></script>
    <script src="../bs/js/bootstrap.js"></script>
	
    <link rel="stylesheet" href="../bs/css/jquery-ui.css">
    <script src="../bs/js/jquery-1.10.2.js"></script>
    <script src="../bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,300italic,400italic,600italic'>
    <link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Raleway:200,300,400,700,200italic,300italic,400italic,700italic'>
    
  <!--link rel="stylesheet" href="../bs/css/style.css" -->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
        <style>
	    body{
                font-family: 'Open Sans',serif;
            }
            * {
                border-radius: 0 !important;
            }
            div{
                padding: 3px;
            }

        </style>
	</head>
	
	<body>
	
	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<!-- <nav role="navigation" class="navbar navbar-inverse navbar-static-top"> -->
		<nav role="navigation" class="">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><b><?php echo $SchName;?></b></a>
			</div>
			<!-- Collection of nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
                                    <li><a href="Dashboard.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaction <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                           <li><a href="Create_PO_Order.php">Create Purchase Order</a></li>
                                            <li><a href="Enquiry_List.php">Requisition List</a></li>
                                            <li><a href="Item_List.php">Item List</a></li>
                                            <li><a href="VendorItemList.php">Vendor's Master List</a></li>
                                            <li><a href="PurchaseOrderList.php">Purchase Order List</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="Create_Item.php">Create Item</a></li>
                                            <li><a href="Create_Vendor.php">Create Vendor</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Approvals <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="Principal_Approval.php">Principal Approval</a></li>
                                            <li><a href="HeadApproval.php">Head Approval</a></li>                                            
                                        </ul>
                                    </li>
				</ul>
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $UserName;?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">My Account</a></li>
							<li><a href="ChangePassword.php">Change Password</a></li>
							<li class="divider"></li>
							<li><a href="../logout.php?id=<?php echo $LoginID?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
			</div>
		</nav>
	</nav>
	<br /><br />
        