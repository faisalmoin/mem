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
	$L_ID=$_SESSION['ID']; // Company ID
	
	//Get School Name
	$SchoolName = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [id]='$CompName'") or exit(odbc_errormsg($conn));
	$SchName = odbc_result($SchoolName, "School Name"); //SchoolName
	
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
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">
              <div class="menu_section">
                <h3>Setup Page</h3>
                <ul class="nav side-menu">
                  <li><a href="CompanyView.php"> School </a></li>
                  <li><a href="EmployeeList.php"> Employee </a></li>
                  <li><a href="CalendarList.php" > Calendar </a></li>
                  <li><a href="AcademicYearList.php"> Academic Year </a></li>
                  <li><a href="CurriculumList.php"> Curriculum </a></li>
                  <li><a href="ClassList.php"> Class &amp; Section </a></li>
                  <li><a> Fee Setup <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="FeePaymentList.php">Payment Method</a></li>
                      <li><a href="FeeComponentList.php">Fee Component</a></li>
                      <li><a href="FeeTypeList.php">Fee Type</a></li>
                      <li><a href="FeeStructureList.php">Fee Structure</a></li>
                      <li><a href="FeeDiscountCatList.php">Discount Category</a></li>
                      <li><a href="FeeDiscLineList.php">Discount Structure</a></li>
                    </ul>
                  </li>
                  <li><a href="FeeTransportList.php">Transport Slab</a></li>
                  <li><a href="CertificateList.php" >Certificate Required</a></li>
                  <li><a href="UserList.php" >User</a></li>
                  <li><a href="FormDate.php">Online Registration</a></li>
                  <li><a href="ApprovalMaster.php">Approval Master</a></li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
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
            </div>
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
