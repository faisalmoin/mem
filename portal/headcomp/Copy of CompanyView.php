<?php
	require_once("SetupLeft.php");
?>

<h1 class="text-primary"><?php echo $SchName?></h1>
<form action="CompanyAdd.php" enctype="multipart/form-data" method="POST">
    
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
						<td colspan="2"><?php echo odbc_result($SchoolName, "Name")?></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><?php echo odbc_result($SchoolName, "Address")?></td>
						<td rowspan="4" align="center" style="border: 1px solid #d3d3d3;">
							<img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 150px; height: 150px">
						</td>
					</tr>
					<tr>
						<td>Address 2</td>
						<td ><?php echo odbc_result($SchoolName, "Address 2")?></td>
					</tr>
					<tr>
						<td>Address 3</td>
						<td ><?php echo odbc_result($SchoolName, "Address 3")?></td>
					</tr>
					<tr>
						<td>Post Code / City</td>
						<td><?php echo odbc_result($SchoolName, "Post Code")?> / 
						<?php echo odbc_result($SchoolName, "City")?></td>
					</tr>
					<tr>
						<td>Country/Region Code</td>
						<td><?php echo odbc_result($SchoolName, "Country")?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?php echo odbc_result($SchoolName, "State")?></td>
					</tr>
					<tr>
						<td>Phone No.</td>
						<td><?php echo odbc_result($SchoolName, "Phone No_")?></td>
					</tr>
					<tr>
						<td>Trust</td>
						<td><?php echo odbc_result($SchoolName, "Trust")?></td>
					</tr>
					<tr>
						<td>School Type</td>
						<td><?php 
							if(odbc_result($SchoolName, "School Type") == 1) echo "Primary School";
							if(odbc_result($SchoolName, "School Type") == 2) echo "Middle School";
							if(odbc_result($SchoolName, "School Type") == 3) echo "Senior School";
						?></td>
					</tr>
					<tr>
						<td>School Name</td>
						<td colspan="2"><?php echo odbc_result($SchoolName, "School Name")?></td>
					</tr>
					<tr>
						<td>Name 2</td>
						<td colspan="2"><?php echo odbc_result($SchoolName, "Name 2")?></td>
					</tr>
					<tr>
						<td>Brand</td>
						<td><?php 
							if(odbc_result($SchoolName, "Brand") == 1) echo "TKS";
							if(odbc_result($SchoolName, "Brand") == 2) echo "TMS";
							if(odbc_result($SchoolName, "Brand") == 3) echo "UA";
							if(odbc_result($SchoolName, "Brand") == 4) echo "PSBB";
							if(odbc_result($SchoolName, "Brand") == 5) echo "TSMS";						
						?></td>						
					</tr>
					<tr>
						<td>Company Status</td>
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
						<td>Phone No.</td>
						<td><?php echo odbc_result($SchoolName, "Pnone No_ 2")?></td>
					</tr>
					<tr>
						<td>Fax No.</td>
						<td><?php echo odbc_result($SchoolName, "Fax No_")?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo odbc_result($SchoolName, "E-mail")?></td>
					</tr>
					<tr>
						<td>Home Page</td>
						<td><a href="http://<?php echo odbc_result($SchoolName, "Home Page")?>" target="_BLANK" ><?php echo odbc_result($SchoolName, "Home Page")?></a></td>
					</tr>
					<tr>
						<td>IC Partner Code</td>
						<td><?php echo odbc_result($SchoolName, "IC Partner Code")?></td>
					</tr>
					<tr>
						<td>IC Inbox Type</td>
						<td><?php 
							if(odbc_result($SchoolName, "IC Inbox Type") == 1) echo "File Location";
							if(odbc_result($SchoolName, "IC Inbox Type") == 2) echo "Database";
						?></td>		
					</tr>
					<tr>
						<td>IC Inbox Details</td>
						<td><?php echo odbc_result($SchoolName, "IC Inbox Details")?></td>
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
						<td><?php echo (odbc_result($SchoolName, "Export or Deemed Export")==1)? "&#x2714;": "-" ;?></td>
					</tr>
					<tr>
						<td>Composition</td>
						<td><?php echo odbc_result($SchoolName, "Composition")==1? "&#x2714;": "-" ;?></td>
					</tr>
					<tr>
						<td>Composition Type</td>
						<td><?php 
							if(odbc_result($SchoolName, "Composition Type")==1) echo "Retailer";
							if(odbc_result($SchoolName, "Composition Type")==2) echo "Work Contract";
							if(odbc_result($SchoolName, "Composition Type")==3) echo "Bakery";
							if(odbc_result($SchoolName, "Composition Type")==4) echo "Resturant";
							if(odbc_result($SchoolName, "Composition Type")==5) echo "Second Hand Motor Vehicle";
						?></td>
					</tr>
					<tr>
						<td>L.S.T. No.</td>
						<td><?php echo odbc_result($SchoolName, "L_S_T_ No_")?></td>
					</tr>
					<tr>
						<td>C.S.T. No.</td>
						<td><?php echo odbc_result($SchoolName, "C_S_T_ No_")?></td>
					</tr>
					<tr>
						<td>VAT Registration No.</td>
						<td><?php echo odbc_result($SchoolName, "VAT Registration No_")?></td>
					</tr>
					<tr>
						<td>T.I.N. No.</td>
						<td><?php echo odbc_result($SchoolName, "T_I_N_ No_")?></td>
					</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Income Tax</strong></td>
					</tr>
					<tr>
						<td>T.A.N. No.</td>
						<td><?php echo odbc_result($SchoolName, "T_A_N_ No_")?></td>
					</tr>
					<tr>
						<td>T.C.A.N. No.</td>
						<td><?php echo odbc_result($SchoolName, "T_C_A_N_ No_")?></td>
					</tr>
					<tr>
						<td>Circle No.</td>
						<td><?php echo odbc_result($SchoolName, "Circle No_")?></td>
					</tr>
					<tr>
						<td>Assessing Officer</td>
						<td><?php echo odbc_result($SchoolName, "Assessing Officer")?></td>
					</tr>
					<tr>
						<td>Ward No.</td>
						<td><?php echo odbc_result($SchoolName, "Ward No_")?></td>
					</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Service Tax</strong></td>
					</tr>
					<tr>
						<td>Input Service Distribution</td>
						<td><?php echo odbc_result($SchoolName, "Input Service Distributor")==1? "&#x2714;": "-" ;?></td>
					</tr>
					<tr>
						<td>Central STC Applicable</td>
						<td><?php echo odbc_result($SchoolName, "Central STC Applicable")==1? "&#x2714;": "-" ;?></td>
					</tr>
					<tr>
						<td>ST Payment Period</td>
						<td><?php 
							if(odbc_result($SchoolName, "ST Payment Period") == 1) echo "Monthly";
							if(odbc_result($SchoolName, "ST Payment Period") == 2) echo "Quarterly";
							if(odbc_result($SchoolName, "ST Payment Period") == 3) echo "Half - Yearly";
							if(odbc_result($SchoolName, "ST Payment Period") == 4) echo "Annual";
						?></td>
					</tr>
					<tr>
						<td>ST Payment Due Day</td>
						<td><?php echo odbc_result($SchoolName, "ST Payment Due Day")?></td>
					</tr>
					<tr>
						<td>Service Tax Registration</td>
						<td><?php echo odbc_result($SchoolName, "Service Tax Registration No_")?></td>
					</tr>
				</table>
			
		</div>
		<div class="tab-pane fade" id="efil">
				<table class="table table-responsive">
					<tr>
						<td>P.A.N. Status</td>
						<td><?php echo odbc_result($SchoolName, "P_A_N_ Status")==1?"Available": "Not Available"?></td>
					</tr>
					<tr>
						<td>P.A.N. No.</td>
						<td><?php echo odbc_result($SchoolName, "P_A_N_ No_")?></td>
					</tr>
					<tr>
						<td>Deductor Category</td>
						<td><?php echo odbc_result($SchoolName, "Deductor Category")?></td>
					</tr>
					<tr>
						<td>PAO Code</td>
						<td><?php echo odbc_result($SchoolName, "PAO Code")?></td>
					</tr>
					<tr>
						<td>PAO Registration No</td>
						<td><?php echo odbc_result($SchoolName, "PAO Registration No_")?></td>
					</tr>
					<tr>
						<td>DDO Code</td>
						<td><?php echo odbc_result($SchoolName, "DDO Code")?></td>
					</tr>
					<tr>
						<td>DDO Registration No</td>
						<td><?php echo odbc_result($SchoolName, "DDO Registration No_")?></td>
					</tr>
					<tr>
						<td>Ministry Type</td>
						<td><?php echo odbc_result($SchoolName, "Ministry Type")?></td>
					</tr>
					<tr>
						<td>Ministry Code</td>
						<td><?php echo odbc_result($SchoolName, "Ministry Code")?></td>
					</tr>
				</table>			
			</div>			
		<br />
		<!-- <button type="submit" class="btn btn-success">Register</button> -->
	</div>
	
</form>






<?php require_once("SetupRight.php"); ?>