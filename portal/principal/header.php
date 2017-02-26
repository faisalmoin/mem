<?php
	session_start();
	//Client Browser Detection
	$firefox = strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false;
	$chrome = strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome') ? true : false;
	$safari = strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') ? true : false;
	
	//exit("Chrome: ".$chrome." // Firefox: ".$firefox);
	
	if ($firefox=="" && $chrome=="" && $safari=="") {
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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MEM School ERP | <?php echo $UserName?></title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- div class="col-md-3 left_col menu_fixed" -->
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><img src="../img/logo_sm.png" style="width: 42px"> <span>School ERP</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../img/profile.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $UserName?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
              <div class="menu_section">
                <!--h3>Setup Page</h3-->
                <ul class="nav side-menu">
                  <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                  <li><a><i class="fa fa-pencil-square-o"></i>  Approvals  <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      	<li><a href="StudentCardApp.php">Student Card</a></li>
						            <li><a href="TCApply.php">Transfer Certificate</a></li>
                        <li><a href="Principal_Approval.php">PO Approval</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i>  Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      	<li><a href="Enquiry.php">Enquiry</a></li>
            						<li><a href="Admission.php">Admission</a></li>
            						<li><a href="StuStrength.php">Student Strength</a></li>
            						<li><a href="TransCert.php">Transfer Certificate</a></li>
            						<li><a href="Fee14.php">Fee Structure</a></li>
                        <li><a href="FeeOutstanding.php">Fee Outstanding</a></li>
                        <li><a href="FeePipeline.php">Fee-in-Pipeline</a></li>
            						<li><a href="EmployeeList.php"> Employee </a></li>
            						<li><a href="CalendarList.php" > Calendar </a></li>
            						<li><a href="AcademicYearList.php"> Academic Year </a></li>
            						<li><a href="ClassList.php"> Class &amp; Section </a></li>
            						<li><a href="FeeTransportList.php">Transport Slab</a></li>
                  		  <li><a href="CertificateList.php" >Certificate Required</a></li>
                        <li><a href="PurchaseOrderList.php" >PO List</a></li>
                        <li><a href="VendorItemList.php" >Vendor List</a></li>
                    </ul>
                  </li>                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!--div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a href="../logout.php?id=<?php echo $LoginID; ?>" data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>                               
              </div>
              <!--ul class="nav navbar-nav">
                <li class="" style="text-align:center;"><h2><?php echo $SchName;?><h2></li>
              </ul-->
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../img/profile.jpg" alt=""><?php echo $UserName?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="ChangePassword.php"> Change Password</a></li>
                    <!-- li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li -->
                    <li><a href="../logout.php?id=<?php echo $LoginID; ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

