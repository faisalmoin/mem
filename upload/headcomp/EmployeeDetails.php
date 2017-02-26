<?php
	require_once("SetupLeft.php");
        $id = $_REQUEST['Id'];
       
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Employee] WHERE [ID]='$id' AND [Company Name]='$CompName'");
		
	?>


<h3 class="text-primary">Employee ID : <?php echo odbc_result($rs, "No_")?></h3>
<form action="CompanyAdd.php" enctype="multipart/form-data" method="POST">
    
	<ul id="myTab" class="nav nav-tabs">
		<li class="active"><a href="#gen" data-toggle="tab">General</a></li>
		<li><a href="#com" data-toggle="tab">Communication</a></li>
		<li><a href="#tax" data-toggle="tab">Qualification</a></li>
		<li><a href="#efil" data-toggle="tab">Legal Details</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="gen">
				<table class="table table-responsive">
                                    <tr>
                                            <td colspan="3" style="background-color: #CEECF5; font-size: 20px; height: 50px">General Information</td>
					</tr>
					<tr>
						<td>First Name</td>
						<td colspan="2"><?php echo odbc_result($rs, "First Name")?></td>
						
					</tr>
					<tr>
						<td>Middle Name</td>
						<td><?php echo odbc_result($rs, "Middle Name")?></td>
						<td rowspan="4" align="center" style="border: 0px solid #d3d3d3;">
							<img src="<?php echo odbc_result($rs, "Image")?>" style="width: 150px; height: 150px">
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td ><?php echo odbc_result($rs, "Last Name")?></td>
					</tr>
					<tr>
						<td>Date Of Birth</td>
						<td ><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Birth Date")))?></td>
					</tr>
					<tr>
						<td>Gender</td>
                                                <td><?php if(odbc_result($rs, "Gender") == 1) { echo "Male"; }
                                                 if(odbc_result($rs, "Gender") == 2) { echo "Female"; }?></td>
						
					</tr>
					<tr>
						<td>Country/Region Code</td>
						<td><?php if(odbc_result($rs, "Country_Region Code") == 1) { echo "AMERICAN"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 2) { echo "BANGLADESHI"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 3) { echo "CANADIAN"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 4) { echo "GERMAN"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 5) { echo "INDIAN"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 6) { echo "NEPALESE"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 7) { echo "PHILLIPINE"; }
                                                 if(odbc_result($rs, "Country_Region Code") == 8) { echo "THAI"; }?>
                                                    </td>
					</tr>
					<tr>
						<td>Employment Date</td>
						<td><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Employment Date")))?></td>
					</tr>
					<tr>
						<td>Employee Type</td>
						<td><?php 
							if(odbc_result($rs, "Employee Type") == 1) echo "Full Time";
							if(odbc_result($rs, "Employee Type") == 2) echo "Part Time";
							if(odbc_result($rs, "Employee Type") == 3) echo "Contractual";
                                                        if(odbc_result($rs, "Employee Type") == 4) echo "Trainees";
                                                        if(odbc_result($rs, "Employee Type") == 5) echo "Contract to Hire";
						?></td>
					</tr>
					<tr>
						<td>Department</td>
						<td><?php echo odbc_result($rs, "Department")?></td>
					</tr>
					<tr>
						<td>Job Title</td>
						<td><?php 
							echo odbc_result($rs,"Job Title");
						?></td>
					</tr>
					<tr>
						<td>CTC</td>
						<td><?php echo number_format(odbc_result($rs, "CTC"),2,'.',',')?></td>
					</tr>
					<tr>
						<td>Blood Group</td>
						<td><?php if(odbc_result($rs, "Blood Group") == 1) echo "O+";
							if(odbc_result($rs, "Blood Group") == 2) echo "O-";
							if(odbc_result($rs, "Blood Group") == 3) echo "A+";
							if(odbc_result($rs, "Blood Group") == 4) echo "A-";
							if(odbc_result($rs, "Blood Group") == 5) echo "B+";
                                                        if(odbc_result($rs, "Blood Group") == 6) echo "B-";
                                                        if(odbc_result($rs, "Blood Group") == 7) echo "AB+";
                                                        if(odbc_result($rs, "Blood Group") == 8) echo "AB-";
                                                    ?></td>
					</tr>
					<tr>
						<td>Brand</td>
						<td><?php 
							if(odbc_result($rs, "Teaching Type") == 1) echo "Teaching";
							if(odbc_result($rs, "Teaching Type") == 0) echo "Non Teaching";
											
						?></td>						
					</tr>
					

                                                <tr>
						<td>Company E-Mail</td>
						<td><?php echo odbc_result($rs, "Company E-Mail")?></td>
					</tr>
                                        
                                        <tr>
						<td>Employee Status</td>
						<td><?php
							if(odbc_result($rs, "Status") == 1) echo "Active";
							if(odbc_result($rs, "Status") == 0) echo "In-Active";
							
						
						?></td>
                                       </tr>
                                                
					
				</table>
			
		</div>
		<div class="tab-pane fade" id="com">
				<table class="table table-responsive">
                                    <tr>
						<td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Communication Details</td>
					</tr>
					<tr>
						<td>Address</td>
						<td><?php echo odbc_result($rs, "Address")?></td>
					</tr>
					<tr>
						<td>Address 2</td>
						<td><?php echo odbc_result($rs, "Address 2")?></td>
					</tr>
					<tr>
						<td>Post Code</td>
						<td><?php echo odbc_result($rs, "Post Code")?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?php echo odbc_result($rs, "State1")?></td>
					</tr>
					<tr>
						<td>County</td>
						<td><?php echo odbc_result($rs, "County")?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?php 
							echo odbc_result($rs, "City");
						?></td>		
					</tr>
					<tr>
						<td>Phone No. (Landline)</td>
						<td><?php echo odbc_result($rs, "Phone No_")?></td>
					</tr>
                                        <tr>
						<td>Phone No. (Landline)</td>
						<td><?php echo odbc_result($rs, "Mobile Phone No_")?></td>
					</tr>
                                        <tr>
						<td>Phone No. (Landline)</td>
						<td><?php echo odbc_result($rs, "E-Mail")?></td>
					</tr>
				</table>
			
		</div>
		<div class="tab-pane fade" id="tax">
				<table class="table table-responsive">
					<tr>
						<td colspan="2" style="background-color: #CEECF5; height: 50px; font-size: 20px;">Qualification Details</td>
					</tr>
                                        <tr>
						<td>Qualification</td>
						<td><?php 
							if(odbc_result($rs, "Qualification")==1) echo "Diploma";
							if(odbc_result($rs, "Qualification")==2) echo "Graduate";
							if(odbc_result($rs, "Qualification")==3) echo "Ph.D";
							if(odbc_result($rs, "Qualification")==4) echo "Professional Degree";
							if(odbc_result($rs, "Qualification")==5) echo "Post Graduate";
                                                        if(odbc_result($rs, "Qualification")==6) echo "Under Graduate";
                                                        if(odbc_result($rs, "Qualification")==7) echo "Post Graduate Diploma";
                                                        if(odbc_result($rs, "Qualification")==8) echo "Non Graduate";
                                                        if(odbc_result($rs, "Qualification")==9) echo "Other";
                                                        
                                                        
						?></td>
					</tr>
                                        
					<tr>
						<td>Degree</td>
						<td><?php echo odbc_result($rs, "Degree");?></td>
					</tr>
					<tr>
						<td>University</td>
						<td><?php echo odbc_result($rs, "University");?></td>
					</tr>
					
					<tr>
						<td>City</td>
						<td><?php echo odbc_result($rs, "Qual City")?></td>
					</tr>
					<tr>
						<td>Country</td>
						<td><?php echo odbc_result($rs, "Qual Country")?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?php echo odbc_result($rs, "Qual State")?></td>
					</tr>
					<tr>
						<td>Passing Year</td>
						<td><?php echo odbc_result($rs, "Qual Passing Year")?></td>
					</tr>
                                        <tr>
						<td>B_ED</td>
						<td><?php
                                                        if(odbc_result($rs, "B_ED")==1) echo "Yes";
                                                         if(odbc_result($rs, "B_ED")==0) echo "No";?></td>
					</tr>
                                       
				</table>
			
		</div>
		<div class="tab-pane fade" id="efil">
				<table class="table table-responsive">
                                    <tr>
						<td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Legal Documents</td>
					</tr>
					<tr>
						<td>Passport Size Photo</td>
						<td><?php   if(odbc_result($rs, "Image")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Image")!=""){
                                                             echo "<a href='".odbc_result($rs, "Image")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?></td>
					</tr>
					<tr>
						<td>PAN No.</td>
						<td><?php   if(odbc_result($rs, "PanCard")=="") echo "Not Received";
                                                         if(odbc_result($rs, "PanCard")!=""){
                                                             echo "<a href='".odbc_result($rs, "PanCard")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Aadhar No</td>
						<td><?php   if(odbc_result($rs, "Aadhar")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Aadhar")!=""){
                                                             echo "<a href='".odbc_result($rs, "Aadhar")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Apointment Letter</td>
						<td><?php   if(odbc_result($rs, "Apointment Letter")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Apointment Letter")!=""){
                                                             echo "<a href='".odbc_result($rs, "Apointment Letter")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Highest Qualification Certificate</td>
						<td><?php   if(odbc_result($rs, "H Qualification")=="") echo "Not Received";
                                                         if(odbc_result($rs, "H Qualification")!=""){
                                                             echo "<a href='".odbc_result($rs, "H Qualification")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Previous Employment Certificate</td>
						<td><?php   if(odbc_result($rs, "Prev Employment")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Prev Employment")!=""){
                                                             echo "<a href='".odbc_result($rs, "Prev Employment")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>DOB Certificate</td>
						<td><?php   if(odbc_result($rs, "Dob")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Dob")!="") {
                                                             echo "<a href='".odbc_result($rs, "Dob")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Voter Id Card</td>
						<td><?php   if(odbc_result($rs, "Voter Id")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Voter Id")!=""){
                                                             echo "<a href='".odbc_result($rs, "Voter Id")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                                 
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td>Passport</td>
						<td><?php   if(odbc_result($rs, "Passport")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Passport")!="") {
                                                            echo "<a href='".odbc_result($rs, "Passport")."' >"
                                                                 . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
				</table>			
			</div>			
		<br />
		<!-- <button type="submit" class="btn btn-success">Register</button> -->
	</div>
	
	
	<a href="EmployeeEdit.php?Id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
	
</form>
<?php require_once("SetupRight.php"); ?>