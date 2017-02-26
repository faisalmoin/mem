<?php
	require_once("SetupLeft.php");
?>

<h1 class="text-primary">New Company Registration</h1>
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
						<td colspan="2"><input type="text" name="Name" required class="form-control text-uppercase" placeholder="Company Name" /></td>
					</tr>
					<tr>
						<td>Address</td>
						<td colspan="2"><input type="text" name="Address1" required class="form-control" placeholder="Address Line 1" /></td>
					</tr>
					<tr>
						<td>Address 2</td>
						<td colspan="2"><input type="text" name="Address2" class="form-control" placeholder="Address Line 2" /></td>
					</tr>
					<tr>
						<td>Address 3</td>
						<td colspan="2"><input type="text" name="Address3" class="form-control" placeholder="Address Line 3" /></td>
					</tr>
					<tr>
						<td>Post Code / City</td>
						<td><input type="text" name="PostCode" required class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  placeholder="Postal Code" /></td>
						<td><input type="text" name="City" required class="form-control text-uppercase" placeholder="City Name" /></td>
					</tr>
					<tr>
						<td>Country/Region Code</td>
						<td><input type="text" name="CountryCode" required class="form-control text-uppercase" placeholder="Country/Region Code" /></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="State" required class="form-control text-uppercase" placeholder="State" /></td>
					</tr>
					<tr>
						<td>Phone No.</td>
						<td><input type="text" name="PhoneNo" required class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Primary Phone No" /></td>
					</tr>
					<tr>
						<td>Trust</td>
						<td><select name="Trust" class="form-control" >
							<option value=""></option>
							<?php
								$Bal = odbc_exec($conn, "SELECT Distinct [ID],[Trust Name] FROM [CRM Agreement]");
								while(odbc_fetch_array($Bal)){
									echo "<option value='".odbc_result($Bal, "ID")."'>".odbc_result($Bal, "Trust Name")."</option>";
								}
							?>
						</select></td>
						<!--td><input type="text" name="Trust" class="form-control text-uppercase" placeholder="Trust Name" /></td-->
					</tr>
					<tr>
						<td>School Type</td>
						<td>
							<select name="SchoolType" class="form-control" required>
								<option value=""></option>
								<option value="1">Primary</option>
								<option value="2">Middle School</option>
								<option value="3">Senior Secondary</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>School Name</td>
						<td colspan="2"><input type="text" name="SchoolName" required class="form-control text-uppercase" placeholder="School Name" /></td>
					</tr>
					<tr>
						<td>Name 2</td>
						<td colspan="2"><input type="text" name="SchoolName2" class="form-control text-uppercase" /></td>
					</tr>
					<tr>
						<td>Brand</td>
						<td>
							<select name="Brand" class="form-control" required>
								<option value=""></option>
								<option value="1">TKS</option>
								<option value="2">TMS</option>
								<option value="3">UA</option>
								<option value="4">PSBB MS</option>
								<option value="5">TSMS</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Company Status</td>
						<td>
							<select name="CompanyStatus" class="form-control" required>
								<option value=""></option>
								<option value="1" selected>Active</option>
								<option value="0">In-Active</option>
								<option value="3">Other</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Logo</td>
						<td>
							<input type="file" name="fileToUpload" id="fileToUpload">
							<small>File Size <= 300KB</small>
						</td>
					</tr>
				</table>
			
		</div>
		<div class="tab-pane fade" id="com">
				<table class="table table-responsive">
					<tr>
						<td>Phone No.</td>
						<td><input type="text" name="PhoneNo2" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Other Contact No" /></td>
					</tr>
					<tr>
						<td>Fax No.</td>
						<td><input type="text" name="FaxNo" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Fax No" /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" name="Email" class="form-control" required placeholder="Email address" /></td>
					</tr>
					<tr>
						<td>Home Page</td>
						<td><input type="text" name="HomePage" class="form-control" placeholder="Home Page: http://www.example.com/" /></td>
					</tr>
					<tr>
						<td>IC Partner Code</td>
						<td><input type="text" name="ICPartnerCode" class="form-control" placeholder="IC Partner Code" /></td>
					</tr>
					<tr>
						<td>IC Inbox Type</td>
						<td>
							<select name="ICInboxType" class="form-control">
								<option value=""></option>
								<option value="1">File Location</option>
								<option value="2">Database</option>
							</select>
						</td>		
					</tr>
					<tr>
						<td>IC Inbox Details</td>
						<td><input type="text" name="ICInboxDetails" class="form-control" placeholder="IC Inbox Details" /></td>
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
						<td><input type="checkbox" name="ExportorDeemed" value="1" style="background:transparent;border:0"  /></td>
					</tr>
					<tr>
						<td>Composition</td>
						<td><input type="checkbox" name="Composition" value="1"  /></td>
					</tr>
					<tr>
						<td>Composition Type</td>
						<td>
							<select name="CompositionType"  class="form-control">
								<option value=""></option>
								<option value="1">Retailer</option>
								<option value="2">Work Contract</option>
								<option value="3">Bakery</option>
								<option value="4">Resturant / Club</option>
								<option value="5">Second Hand Motor Vehicle</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>L.S.T. No.</td>
						<td><input type="text" name="LSTNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td>C.S.T. No.</td>
						<td><input type="text" name="CSTNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td>VAT Registration No.</td>
						<td><input type="text" name="VATRegistration"  class="form-control" /></td>
					</tr>
					<tr>
						<td>T.I.N. No.</td>
						<td><input type="text" name="TINNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Income Tax</strong></td>
					</tr>
					<tr>
						<td>T.A.N. No.</td>
						<td><input type="text" name="TANNo" class="form-control" /></td>
					</tr>
					<tr>
						<td>T.C.A.N. No.</td>
						<td><input type="text" name="TCANNo" class="form-control" /></td>
					</tr>
					<tr>
						<td>Circle No.</td>
						<td><input type="text" name="CircleNo" class="form-control" /></td>
					</tr>
					<tr>
						<td>Assessing Officer</td>
						<td><input type="text" name="AssessingOfficer" class="form-control" /></td>
					</tr>
					<tr>
						<td>Ward No.</td>
						<td><input type="text" name="WardNo" class="form-control" /></td>
					</tr>
					<tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Service Tax</strong></td>
					</tr>
					<tr>
						<td>Input Service Distribution</td>
						<td><input type="checkbox" name="InputService" value="1" /></td>
					</tr>
					<tr>
						<td>Central STC Applicable</td>
						<td><input type="checkbox" name="CentralSTC" value="1"  /></td>
					</tr>
					<tr>
						<td>ST Payment Period</td>
						<td>
							<select name="STPaymentPeriod" class="form-control">
								<option value=""></option>
								<option value="1">Monthly</option>
								<option value="2">Quarterly</option>
								<option value="3">Half-Yearly</option>
								<option value="4">Annual</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>ST Payment Due Day</td>
						<td><input type="text" name="STPaymentDueDate"  class="form-control" /></td>
					</tr>
					<tr>
						<td>Service Tax Registration</td>
						<td><input type="text" name="ServiceTaxRegistration"  class="form-control" /></td>
					</tr>
				</table>
			
		</div>
		<div class="tab-pane fade" id="efil">
				<table class="table table-responsive">
					<tr>
						<td>P.A.N. Status</td>
						<td>
							<select name="PANStatus" required class="form-control">
								<option value=""></option>
								<option value="1">Available</option>
								<option value="0">Not Available</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>P.A.N. No.</td>
						<td><input type="text" name="PANNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td>Deductor Category</td>
						<td><input type="text" name="DeductorCategory"  class="form-control" /></td>
					</tr>
					<tr>
						<td>PAO Code</td>
						<td><input type="text" name="PAOCode"  class="form-control" /></td>
					</tr>
					<tr>
						<td>PAO Registration No</td>
						<td><input type="text" name="PAORegistrationNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td>DDO Code</td>
						<td><input type="text" name="DDOCode"  class="form-control" /></td>
					</tr>
					<tr>
						<td>DDO Registration No</td>
						<td><input type="text" name="DDORegistrationNo"  class="form-control" /></td>
					</tr>
					<tr>
						<td>Ministry Type</td>
						<td><input type="text" name="MinistryType" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" /></td>
					</tr>
					<tr>
						<td>Ministry Code</td>
						<td><input type="text" name="MinistryCode"  class="form-control" /></td>
					</tr>
				</table>			
			</div>			
		<br />
		<button type="submit" class="btn btn-success">Register</button>
	</div>
	
</form>
<?php
	require_once("SetupRight.php");
?>