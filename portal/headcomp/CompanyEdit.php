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


<h1 class="text-primary"><?php echo $SchName?></h1>
<form action="companyEditadd.php" enctype="multipart/form-data" method="POST">
    <ul id="myTab" class="nav nav-tabs">
		<li class="active"><a href="#gen" data-toggle="tab">General</a></li>
		<li><a href="#com" data-toggle="tab">Communication</a></li>
		<li><a href="#tax" data-toggle="tab">Tax Information</a></li>
		<li><a href="#efil" data-toggle="tab">E-Filling</a></li>
	</ul>
    
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="gen">
				<table class="table table-responsive">
					<tr>
						<td>Name</td>
						<td colspan="2"><input type="text" name="name" value="<?php echo odbc_result($SchoolName, "Name")?>" class="form-control text-uppercase" readonly /></td>
						<!--td colspan="2"><--?php echo odbc_result($SchoolName, "Name")?></td-->
						
					</tr>
					<tr>
						<td>Address</td>
						<td colspan="2"><input type="text" name="address" value="<?php echo odbc_result($SchoolName, "Address")?>" class="form-control text-uppercase" /></td>
						
						<td rowspan="4" align="center" style="border: 0px solid #d3d3d3;">
						<img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 150px; height: 150px">
						<input type="file" name="fileToUpload" id="fileToUpload">
							<small>File Size <= 300KB</small>
						</td>
					
					</tr>
					<tr>
						<td>Address 2</td>
						<td colspan="2"><input type="text" name="address2" class="form-control text-uppercase"   value="<?php echo odbc_result($SchoolName, "Address 2")?>"/></td>
						
					</tr>
					<tr>
						<td>Address 3</td>
						<td colspan="2"><input type="text" name="address3" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "Adress3")?>"/></td>
						</tr>
												
					<tr>
						<td>Post Code</td>
						<td colspan="2"><input type="text" class="form-control text-uppercase"  name="postCode" value="<?php echo odbc_result($SchoolName, "Post Code")?>"/></td>
					</tr>
					<tr>
						<td>City</td>
						<td colspan="2"><input type="text" class="form-control text-uppercase"  name="City" value="<?php echo odbc_result($SchoolName, "City")?>"/></td>
						
					</tr>
					
					<tr>
						<td>Country/Region Code</td>
						<td colspan="2"><input type="text" class="form-control text-uppercase"  name="regionCode" value="<?php echo odbc_result($SchoolName, "County")?>"/></td>
						</tr>
						
					<tr>
						<td>State</td>
						<td colspan="2"><input type="text" name="state" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "State")?>"/></td>
						</tr>
						
						<tr>
						<td>Phone No.</td>
						<td colspan="2"><input type="text" name="phoneNo1" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "Phone No_")?>"/></td>
						</tr>
						
					<tr>
						<td>Trust</td>
						<td colspan="2"><input type="text" name="trust" class="form-control text-uppercase"  value="<?php $Bal = odbc_exec($conn, "SELECT Distinct [ID],[Trust Name] FROM [CRM Agreement] WHERE [ID] ='".odbc_result($SchoolName, "Trust")."' ");
							echo odbc_result($Bal, "Trust Name" )?>"  readonly /></td>
						</tr>
					
					<!--tr>
						<td>School Type</td>
						<td colspan="2"><input type="text" name="schoolType" class="form-control text-uppercase"  value="<--?php 
							if(odbc_result($SchoolName, "School Type") == 1) echo "Primary School";
							if(odbc_result($SchoolName, "School Type") == 2) echo "Middle School";
							if(odbc_result($SchoolName, "School Type") == 3) echo "Senior School";
						?>"/></td>
						</tr-->
						
		
					
						
						<tr>
						<td>School Type</td>
						<td>
							<select name="SchoolType" class="form-control" required>
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "School Type") == 1) { echo "selected='selected'"; } ?> value="1">Primary</option>
								<option <?php if(odbc_result($SchoolName, "School Type") == 2) { echo "selected='selected'"; } ?> value="2">Middle School</option>
								<option <?php if(odbc_result($SchoolName, "School Type") == 3) { echo "selected='selected'"; } ?> value="3">Senior Secondary</option>
							</select>
						</td>
					</tr>
						
						
						
						<tr>
						<td>School Name</td>
						<td colspan="2"><input type="text" name="schoolName" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "School Name")?>" required /></td>
						</tr>
					<tr>
						<td>Name 2</td>
						<td colspan="2"><input type="text" name="name2" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "Name 2")?>"/></td>
						</tr>
						
					<tr>
						<td>Brand</td>
						
						<td>
							<select name="Brand" class="form-control" required>
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "Brand") == 1) { echo "selected='selected'"; } ?> value="1">TKS</option>
								<option <?php if(odbc_result($SchoolName, "Brand") == 2) { echo "selected='selected'"; } ?> value="2">TMS</option>
								<option <?php if(odbc_result($SchoolName, "Brand") == 3) { echo "selected='selected'"; } ?> value="3">UA</option>
								<option <?php if(odbc_result($SchoolName, "Brand") == 4) { echo "selected='selected'"; } ?> value="4">PSBB MS</option>
								<option <?php if(odbc_result($SchoolName, "Brand") == 5) { echo "selected='selected'"; } ?> value="5">TSMS</option>
							</select>
						</td>
						
						
						<!--td colspan="2"><input type="text" name="brand" class="form-control text-uppercase"  value="<--?php 
							if(odbc_result($SchoolName, "Brand") == 1) echo "TKS";
							if(odbc_result($SchoolName, "Brand") == 2) echo "TMS";
							if(odbc_result($SchoolName, "Brand") == 3) echo "UA";
							if(odbc_result($SchoolName, "Brand") == 4) echo "PSBB";
							if(odbc_result($SchoolName, "Brand") == 5) echo "TSMS";						
						?>"/></td-->
						</tr>
						
					<tr>
						<td>Company Status</td>
						
						<td>
							<select name="CompanyStatus" class="form-control" required>
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "Company Status") == 1) { echo "selected='selected'"; } ?> value="1" selected>Active</option>
								<option <?php if(odbc_result($SchoolName, "Company Status") == 0) { echo "selected='selected'"; } ?> value="0">In-Active</option>
								<option <?php if(odbc_result($SchoolName, "Company Status") == 3) { echo "selected='selected'"; } ?> value="3">Other</option>
							</select>
						</td>
						
						<!--td colspan="2"><input type="text" name="companyStatus" class="form-control text-uppercase"  value="<--?php
							if(odbc_result($SchoolName, "Company Status") == 1) echo "Active";
							if(odbc_result($SchoolName, "Company Status") == 0) echo "In-Active";
							if(odbc_result($SchoolName, "Company Status") == 3) echo "Others";?>"/></td-->
						</tr>
						
						</table>
			
		                </div>
		            <div class="tab-pane fade" id="com">
				     <table class="table table-responsive">
						
					<tr>
						<td>Phone No.</td>
						<td colspan="2"><input type="text" name="phoneNo2" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "Phone No_ 2")?>"/></td>
						</tr>
					<tr>
						<td>Fax No.</td>
						<td colspan="2"><input type="text" name="faxNo" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "Fax No_")?>"/></td>
						</tr>
					<tr>
						<td>Email</td>
						<td colspan="2"><input type="text" name="email" class="form-control text-uppercase"  value="<?php echo odbc_result($SchoolName, "E-mail")?>"/></td>
						</tr>
					<tr>
						<td>Home Page</td>
						
						<td><a href="http://<?php echo odbc_result($SchoolName, "Home Page")?>" target="_BLANK" ><?php echo odbc_result($SchoolName, "Home Page")?></a></td>
					</tr>
					<tr>
						<td>IC Partner Code</td>
						<td colspan="2"><input type="text" name="partnerCode" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "IC Partner Code")?>"/></td>
						</tr>
					<tr>
						<td>IC Inbox Type</td>
						<!--td colspan="2"><input type="text" name="inboxType" class="form-control text-uppercase" value="<--?php 
							if(odbc_result($SchoolName, "IC Inbox Type") == 1) echo "File Location";
							if(odbc_result($SchoolName, "IC Inbox Type") == 2) echo "Database";
						?>"/></td-->
						
						<td>
							<select name="ICInboxType" class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "IC Inbox Type") == 1) { echo "selected='selected'"; } ?> value="1">File Location</option>
								<option <?php if(odbc_result($SchoolName, "IC Inbox Type") == 2) { echo "selected='selected'"; } ?> value="2">Database</option>
							</select>
						</td>
						</tr>
					<tr>
						<td>IC Inbox Details</td>
						<td colspan="2"><input type="text" name="inboxDetail" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "IC Inbox Details")?>"/></td>
						</tr>
						</table>
			
					</div>
					<div class="tab-pane fade" id="tax">
					<table class="table table-responsive">
					<tr>
						<td colspan="2" style="background-color: #E5E4E2; height: 50px"><strong>Tax / VAT</strong></td>
					</tr>
					<tr>
						<td>Export or Deemed Export</td>
						<td colspan="2"><input type="text" name="deemedExport" class="form-control text-uppercase" value="<?php echo (odbc_result($SchoolName, "Export or Deemed Export")==1)? "&#x2714;": "-" ;?>"/></td>
						</tr>
					<tr>
						<td>Composition</td>
						<td colspan="2"><input type="text" name="composition" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Composition")==1? "&#x2714;": "-" ;?>"/></td>
						</tr>
					<tr>
						<td>Composition Type</td>
						
						<td>
							<select name="compositionType"  class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "Composition Type") == 1) { echo "selected='selected'"; } ?> value="1">Retailer</option>
								<option <?php if(odbc_result($SchoolName, "Composition Type") == 2) { echo "selected='selected'"; } ?> value="2">Work Contract</option>
								<option <?php if(odbc_result($SchoolName, "Composition Type") == 3) { echo "selected='selected'"; } ?> value="3">Bakery</option>
								<option <?php if(odbc_result($SchoolName, "Composition Type") == 4) { echo "selected='selected'"; } ?> value="4">Resturant / Club</option>
								<option <?php if(odbc_result($SchoolName, "Composition Type") == 5) { echo "selected='selected'"; } ?> value="5">Second Hand Motor Vehicle</option>
							</select>
						</td>
						
						<!--td colspan="2"><input type="text" name="compositionType" class="form-control text-uppercase" value="<--?php 
							if(odbc_result($SchoolName, "Composition Type")==1) echo "Retailer";
							if(odbc_result($SchoolName, "Composition Type")==2) echo "Work Contract";
							if(odbc_result($SchoolName, "Composition Type")==3) echo "Bakery";
							if(odbc_result($SchoolName, "Composition Type")==4) echo "Resturant";
							if(odbc_result($SchoolName, "Composition Type")==5) echo "Second Hand Motor Vehicle";
						?>"/></td-->
						</tr>
						
					<tr>
						<td>L.S.T. No.</td>
						<td colspan="2"><input type="text" name="LST" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "L_S_T_ No_")?>"/></td>
						</tr>
					<tr>
						<td>C.S.T. No.</td>
						<td colspan="2"><input type="text" name="CST" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "C_S_T No_")?>"/></td>
						</tr>
					<tr>
						<td>VAT Registration No.</td>
						<td colspan="2"><input type="text" name="vatRegistration" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "VAT Registration No_")?>"/></td>
						</tr>
					<tr>
						<td>T.I.N. No.</td>
						<td colspan="2"><input type="text" name="TIN" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "T_I_N_ No_")?>"/></td>
						</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Income Tax</strong></td>
					</tr>
					<tr>
						<td>T.A.N. No.</td>
						<td colspan="2"><input type="text" name="TAN" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "T_A_N_ No_")?>"/></td>
						</tr>
					<tr>
						<td>T.C.A.N. No.</td>
						<td colspan="2"><input type="text" name="TCAN" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "T_C_A_N_ No_")?>"/></td>
						</tr>
					<tr>
						<td>Circle No.</td>
						<td colspan="2"><input type="text" name="circle" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Circle No_")?>"/></td>
						</tr>
					<tr>
						<td>Assessing Officer</td>
						<td colspan="2"><input type="text" name="assessing" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Assessing Officer")?>"/></td>
						</tr>
					<tr>
						<td>Ward No.</td>
						<td colspan="2"><input type="text" name="wardNo" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Ward No_")?>"/></td>
						</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Service Tax</strong></td>
					</tr>
					<tr>
						<td>Input Service Distribution</td>
						<td colspan="2"><input type="text" name="inputSD" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Input Service Distributor")==1? "&#x2714;": "-" ;?>"/></td>
						</tr>
					<tr>
						<td>Central STC Applicable</td>
						<td colspan="2"><input type="text" name="centralSA" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Central STC Applicable")==1? "&#x2714;": "-" ;?>"/></td>
						</tr>
						<tr>
						<td>ST Payment Period</td>
						<!--td colspan="2"><input type="text" name="STpayment" class="form-control text-uppercase" value="<--?php 
							if(odbc_result($SchoolName, "ST Payment Period") == 1) echo "Monthly";
							if(odbc_result($SchoolName, "ST Payment Period") == 2) echo "Quarterly";
							if(odbc_result($SchoolName, "ST Payment Period") == 3) echo "Half - Yearly";
							if(odbc_result($SchoolName, "ST Payment Period") == 4) echo "Annual";
						?>"/></td-->
						
						<td>
							<select name="STpayment" class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "ST Payment Period") == 1) { echo "selected='selected'"; } ?> value="1">Monthly</option>
								<option <?php if(odbc_result($SchoolName, "ST Payment Period") == 2) { echo "selected='selected'"; } ?> value="2">Quarterly</option>
								<option <?php if(odbc_result($SchoolName, "ST Payment Period") == 3) { echo "selected='selected'"; } ?> value="3">Half-Yearly</option>
								<option <?php if(odbc_result($SchoolName, "ST Payment Period") == 4) { echo "selected='selected'"; } ?> value="4">Annual</option>
							</select>
						</td>
						
						</tr>
						<tr>
						<td>ST Payment Due Day</td>
						<td colspan="2"><input type="text" name="duePayment" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "ST Payment Due Day")?>"/></td>
						</tr>
					<tr>
						<td>Service Tax Registration</td>
						<td colspan="2"><input type="text" name="serviceTR" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Service Tax Registration No_")?>"/></td>
						</tr>
						
						</table>
			
						</div>
					<div class="tab-pane fade" id="efil">
					<table class="table table-responsive">
						
						<tr>
						<td>P.A.N. Status</td>
						<!--td colspan="2"><input type="text" name="PANstatus" class="form-control text-uppercase" value="<--?php echo odbc_result($SchoolName, "P_A_N_ Status")==1?"Available": "Not Available"?>"/></td-->
						
						<td>
							<select name="PANstatus" class="form-control">
								<option value=""></option>
								<option <?php if(odbc_result($SchoolName, "P_A_N_ Status") == 1) { echo "selected='selected'"; } ?> value="1">Available</option>
								<option <?php if(odbc_result($SchoolName, "P_A_N_ Status") == 0) { echo "selected='selected'"; } ?> value="0">Not Available</option>
								</select>
						</td>
						
						</tr>
						
						
					<tr>
						<td>P.A.N. No.</td>
						<td colspan="2"><input type="text" name="PANNo" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "P_A_N_ No_")?>"/></td>
						</tr>
					<tr>
						<td>Deductor Category</td>
						<td colspan="2"><input type="text" name="deductor" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Deductor Category")?>"/></td>
						</tr>
					<tr>
						<td>PAO Code</td>
						<td colspan="2"><input type="text" name="PAOCode" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "PAO Code")?>"/></td>
						</tr>
					<tr>
						<td>PAO Registration No</td>
						<td colspan="2"><input type="text" name="PAOReg" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "PAO Registration No_")?>"/></td>
						</tr>
					<tr>
						<td>DDO Code</td>
						<td colspan="2"><input type="text" name="DDOCode" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "DDO Code")?>"/></td>
					</tr>
					<tr>
						<td>DDO Registration No</td>
						<td colspan="2"><input type="text" name="DDOReg" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "DDO Registration No_")?>"/></td>
					</tr>
					<tr>
						<td>Ministry Type</td>
						<td colspan="2"><input type="text" name="ministryType" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Ministry Type")?>"/></td>
					</tr>
					<tr>
						<td>Ministry Code</td>
						<td colspan="2"><input type="text" name="ministryCode" class="form-control text-uppercase" value="<?php echo odbc_result($SchoolName, "Ministry Code")?>"/></td>
					</tr>
				</table>			
			</div>			
		<br />
		<!-- <button type="submit" class="btn btn-success">Register</button> -->
		<input type="hidden" value="<?php echo odbc_result($SchoolName, "ID"); ?>" name="CompanyId">
	</div>
	<button type="submit" name="update" class="btn btn-success">Update</button>
	<!--input type="submit" value="Update" name="upd"/-->
	<!--a href="edit.php?CompanyId=<--?php echo odbc_result($SchoolName, "ID")?>">Edit</a-->
	
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
