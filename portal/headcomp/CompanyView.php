<?php
	require_once("SetupLeft.php");
?>

<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>School Information </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

            <?php require_once "CompanyView.php"; ?>
<h1 class="text-primary"><?php echo $SchName?></h1>
<form action="CompanyAdd.php" enctype="multipart/form-data" method="POST">
    
	<ul id="myTab" class="nav nav-tabs">
		<li class="active"><a href="#gen" data-toggle="tab">General</a></li>
		<li><a href="#com" data-toggle="tab">Communication</a></li>
		<!--li><a href="#tax" data-toggle="tab">Tax Information</a></li>
		<li><a href="#efil" data-toggle="tab">E-Filling</a></li-->
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="gen">
				<table class="table table-responsive">
					<tr>
						<td style="color: #3B0B2E"><b>Name</b></td>
						<td colspan="2"><?php echo odbc_result($SchoolName, "Name")?></td>
						
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Address</b></td>
						<td><?php echo odbc_result($SchoolName, "Address")?></td>
                                                <?php if(odbc_result($SchoolName, "Picture")!=""){ ?>
						<td rowspan="4" align="center" style="border: 0px solid #d3d3d3;">
							<img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 150px; height: 150px">
						</td>
                                                <?php } ?>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Address 2</b></td>
						<td ><?php echo odbc_result($SchoolName, "Address 2")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Address 3</b></td>
						<td ><?php echo odbc_result($SchoolName, "Adress3")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Post Code / City</b></td>
						<td><?php echo odbc_result($SchoolName, "Post Code")?> / 
						<?php echo odbc_result($SchoolName, "City")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Country/Region Code</b></td>
						<td><?php echo odbc_result($SchoolName, "County")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>State</b></td>
						<td><?php echo odbc_result($SchoolName, "State")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Phone No.</b></td>
						<td><?php echo odbc_result($SchoolName, "Phone No_")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Trust</b></td>
						<td><?php 
							$Bal = odbc_exec($conn, "SELECT Distinct [ID],[Trust Name] FROM [CRM Agreement] WHERE [ID] ='".odbc_result($SchoolName, "Trust")."' ");
							echo odbc_result($Bal, "Trust Name" )?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>School Type</b></td>
						<td><?php 
							if(odbc_result($SchoolName, "School Type") == 1) echo "Primary School";
							if(odbc_result($SchoolName, "School Type") == 2) echo "Middle School";
							if(odbc_result($SchoolName, "School Type") == 3) echo "Senior School";
						?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>School Name</b></td>
						<td><?php echo odbc_result($SchoolName, "School Name")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Name 2</b></td>
						<td><?php echo odbc_result($SchoolName, "Name 2")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Brand</b></td>
						<td><?php 
							if(odbc_result($SchoolName, "Brand") == 1) echo "TKS";
							if(odbc_result($SchoolName, "Brand") == 2) echo "TMS";
							if(odbc_result($SchoolName, "Brand") == 3) echo "UA";
							if(odbc_result($SchoolName, "Brand") == 4) echo "PSBB";
							if(odbc_result($SchoolName, "Brand") == 5) echo "TSMS";						
						?></td>						
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Company Status</b></td>
						<td><?php
							if(odbc_result($SchoolName, "Company Status") == 1) echo "Active";
							if(odbc_result($SchoolName, "Company Status") == 0) echo "In-Active";
							if(odbc_result($SchoolName, "Company Status") == 3) echo "Others";
						
						?></td>
					</tr>
					
				</table>
			
		</div>
		<div class="tab-pane fade" id="com">
				<table class="table table-responsive">
					<tr>
						<td style="color: #3B0B2E"><b>Phone No.</b></td>
						<td><?php echo odbc_result($SchoolName, "Phone No_ 2")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Fax No.</b></td>
						<td><?php echo odbc_result($SchoolName, "Fax No_")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Email</b></td>
						<td><?php echo odbc_result($SchoolName, "E-mail")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Home Page</b></td>
						<td><a href="http://<?php echo odbc_result($SchoolName, "Home Page")?>" target="_BLANK" ><?php echo odbc_result($SchoolName, "Home Page")?></a></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>IC Partner Code</b></td>
						<td><?php echo odbc_result($SchoolName, "IC Partner Code")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>IC Inbox Type</b></td>
						<td><?php 
							if(odbc_result($SchoolName, "IC Inbox Type") == 1) echo "File Location";
							if(odbc_result($SchoolName, "IC Inbox Type") == 2) echo "Database";
						?></td>		
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>IC Inbox Details</b></td>
						<td><?php echo odbc_result($SchoolName, "IC Inbox Details")?></td>
					</tr>
				</table>
			
		</div>
	</div>	
	<a href="CompanyEdit.php?CompanyId=<?php echo odbc_result($SchoolName, "ID")?>" class="btn btn-primary">Edit</a>
	
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div> 


<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        
<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php require_once("SetupRight.php"); ?>