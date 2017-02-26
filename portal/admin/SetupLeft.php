<?php
	require_once("header.php");
	
	//Get file name
	
	$file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
	
	$style="style='border-left: 2px solid #000;'";
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-3 col-md-3">
			<!-- Sidebar -->
				<ul class="nav nav-stacked">
					<li style="background-color: #000;color: #fff;"><a>Setup Page</a></li>			
					<li><a href="CompanyList.php">Company</a></li>
					<li><a href="AcademicYearList.php">Academic Year</a></li>
					<li><a href="#">Class & Section</a></li>
					<li><a href="#">Fees</a></li>
					<li><a href="#">Late Fee Charges</a></li>
					<li><a href="#">Discount Code</a></li>
					<li><a href="UserList.php" <?php if($file == "UserList" || $file == "UserEdit" || $file == "UserUpdate" || $file == "NewUser" || $file == "AddUser"){echo $style;}?>>User</a></li>
					<li><a href="#">Map User Company</a></li>
				</ul>        
		</div>
		<div class="col-xs-12 col-md-8">
				<!-- Page Content -->
				
	