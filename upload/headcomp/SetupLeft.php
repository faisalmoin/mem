<?php
	require_once("header.php");
	
	//Get file name
	
	$file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
	
	$style="style='background-color: #d3d3d3;'";
	$style1="style='background-color: #fff;'"
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-3 col-md-3">
			<h3>Setup Page</h3>
			<div class="panel-group" style="border: none;">
				<div class="panel panel-default" style="border: none;">
					<div class="panel-heading" <?php if(strpos($file, 'Company' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a href="CompanyView.php">School</a>
						</h4>
					</div>
                                        <div class="panel-heading" <?php if(strpos($file, 'Employee' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
                                                    <a href="EmployeeList.php">Employee</a>
						</h4>
					</div>
					<div class="panel-heading" <?php if(strpos($file, 'Calendar' ) !== false ){echo $style;}else{echo $style1;}?>>
						<h4 class="panel-title">
							<a href="CalendarList.php" >Calendar</a>
						</h4>
					</div>
					<div class="panel-heading"  <?php if(strpos($file, 'Acad' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a href="AcademicYearList.php">Academic Year</a>
						</h4>
					</div>
					<div class="panel-heading"  <?php if(strpos($file, 'Curri' ) !== false ){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a href="CurriculumList.php">Curriculum</a>
						</h4>
					</div>
					<div class="panel-heading"  <?php if(strpos($file, 'Class' ) !== false ){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a href="ClassList.php">Class &amp; Section</a>
						</h4>
					</div>					
					<div class="panel-heading"  <?php if(strpos($file, 'Fee' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse1">Fee Setup</a>
						</h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse">
						<div class="panel-body" <?php if(strpos($file, 'FeePay' ) !== false ){echo $style;}else{echo $style1;}?> ><a href="FeePaymentList.php">Payment Method</a></div>
						<div class="panel-body" <?php if(strpos($file, 'FeeComponent' ) !== false ){echo $style;}else{echo $style1;}?> ><a href="FeeComponentList.php">Fee Component</a></div>
						<div class="panel-body" <?php if(strpos($file, 'FeeType' ) !== false ){echo $style;}else{echo $style1;}?> ><a href="FeeTypeList.php">Fee Type</a></div>
						<div class="panel-body" <?php if(strpos($file, 'FeeStructure' ) !== false){echo $style;}else{echo $style1;}?> ><a href="FeeStructureList.php">Fee Structure</a></div>
						<div class="panel-body" <?php if(strpos($file, 'FeeDiscountCat' ) !== false){echo $style;}else{echo $style1;}?> ><a href="FeeDiscountCatList.php">Discount Category</a></div>
						<div class="panel-body" <?php if(strpos($file, 'FeeDiscLine' ) !== false){echo $style;}else{echo $style1;}?> ><a href="FeeDiscLineList.php">Discount Structure</a></div>
						<div class="panel-body">Late Fee Setup</div>
						<div class="panel-body" <?php if(strpos($file, 'Transport' ) !== false){echo $style;}else{echo $style1;}?> ><a href="FeeTransportList.php">Transport Slab</a></div>
						<!-- <div class="panel-footer">Panel Footer</div> -->
					</div> <!--
					<div class="panel-heading" <?php if(strpos($file, 'Registration' ) !== false ){echo $style;}else{echo $style1;}?>>
						<h4 class="panel-title">
							<a href="RegistrationList.php" >Registration Setup</a>
						</h4>
					</div> -->
					<div class="panel-heading" <?php if(strpos($file, 'Certificate' ) !== false ){echo $style;}else{echo $style1;}?>>
						<h4 class="panel-title">
							<a href="CertificateList.php" >Certificate Required</a>
						</h4>
					</div>
					<div class="panel-heading" <?php if(strpos($file, 'User' ) !== false ){echo $style;}else{echo $style1;}?>>
						<h4 class="panel-title">
							<a href="UserList.php" >User</a>
						</h4>
					</div>
					
					<div class="panel-heading" <?php if(strpos($file, 'Online' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
							<a href="FormDate.php">Online Registration</a>
						</h4>
					</div>

                                        <!--div class="panel-heading" <--?php if(strpos($file, 'Company' ) !== false){echo $style;}else{echo $style1;}?> >
						<h4 class="panel-title">
                                                    <a href="EmployeeNew.php">Employee New</a>
						</h4>
					</div-->
                                         
                                        
				</div>
			</div>
		</div>
		<div class="col-xs-14 col-md-9" >
				<!-- Page Content -->
				
	