<?php
	require_once("header.php");
    $id = $_REQUEST['Id'];
   
	$i=1;
	$rs = odbc_exec($conn, "SELECT * FROM [Employee] WHERE [ID]='$id' AND [Company Name]='$CompName'");
		
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
<h2>Employee ID : <?php echo odbc_result($rs, "No_")?> </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
<li><a href="EmployeeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>                               
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

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
						<td style="color: #3B0B2E"><b>First Name</b></td>
						<td colspan="2"><?php echo odbc_result($rs, "First Name")?></td>
						
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Middle Name</b></td>
						<td><?php echo odbc_result($rs, "Middle Name")?></td>
						<td rowspan="4" align="center">
							<img src="<?php echo odbc_result($rs, "Image")?>" style="width: 150px; height: 150px">
						</td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Last Name</b></td>
						<td ><?php echo odbc_result($rs, "Last Name")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Date Of Birth</b></td>
						<td><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Birth Date")))?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Gender</b></td>
                                                <td><?php if(odbc_result($rs, "Gender") == 1) { echo "Male"; }
                                                 if(odbc_result($rs, "Gender") == 2) { echo "Female"; }?></td>
						
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Country/Region Code</b></td>
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
						<td style="color: #3B0B2E"><b>Employment Date</b></td>
						<td><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Employment Date")))?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Employee Type</b></td>
						<td><?php 
							if(odbc_result($rs, "Employee Type") == 1) echo "Full Time";
							if(odbc_result($rs, "Employee Type") == 2) echo "Part Time";
							if(odbc_result($rs, "Employee Type") == 3) echo "Contractual";
                                                        if(odbc_result($rs, "Employee Type") == 4) echo "Trainees";
                                                        if(odbc_result($rs, "Employee Type") == 5) echo "Contract to Hire";
						?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Department</b></td>
						<td><?php echo odbc_result($rs, "Department")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Job Title</b></td>
						<td><?php 
							echo odbc_result($rs,"Job Title");
						?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>CTC</b></td>
						<td><?php echo number_format(odbc_result($rs, "CTC"),2,'.',',')?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Blood Group</b></td>
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
						<td style="color: #3B0B2E"><b>Teaching / Non Teaching</b></td>
						<td><?php 
							if(odbc_result($rs, "Teaching Type") == 1) echo "Teaching";
							if(odbc_result($rs, "Teaching Type") == 0) echo "Non Teaching";
											
						?></td>						
					</tr>
					

                                                <tr>
						<td style="color: #3B0B2E"><b>Company E-Mail</b></td>
						<td><?php echo odbc_result($rs, "Company E-Mail")?></td>
					</tr>
                                        
                                        <tr>
						<td style="color: #3B0B2E"><b>Employee Status</b></td>
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
						<td style="color: #3B0B2E"><b>Address</b></td>
						<td><?php echo odbc_result($rs, "Address")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Address 2</b></td>
						<td><?php echo odbc_result($rs, "Address 2")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Post Code</b></td>
						<td><?php echo odbc_result($rs, "Post Code")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>State</b></td>
						<td><?php echo odbc_result($rs, "State1")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>County</b></td>
						<td><?php echo odbc_result($rs, "County")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>City</b></td>
						<td><?php 
							echo odbc_result($rs, "City");
						?></td>		
					</tr>
					<tr>
						<td  style="color: #3B0B2E"><b>Phone No. (Landline)</b></td>
						<td><?php echo odbc_result($rs, "Phone No_")?></td>
					</tr>
                                        <tr>
						<td style="color: #3B0B2E"><b>Phone No. (Landline)</b></td>
						<td><?php echo odbc_result($rs, "Mobile Phone No_")?></td>
					</tr>
                                        <tr>
						<td style="color: #3B0B2E"><b>Phone No. (Landline)</b></td>
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
						<td style="color: #3B0B2E"><b>Qualification</b></td>
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
						<td style="color: #3B0B2E"><b>Degree</b></td>
						<td><?php echo odbc_result($rs, "Degree");?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>University</b></td>
						<td><?php echo odbc_result($rs, "University");?></td>
					</tr>
					
					<tr>
						<td style="color: #3B0B2E"><b>City</b></td>
						<td><?php echo odbc_result($rs, "Qual City")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Country</b></td>
						<td><?php echo odbc_result($rs, "Qual Country")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>State</b></td>
						<td><?php echo odbc_result($rs, "Qual State")?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Passing Year</b></td>
						<td><?php echo odbc_result($rs, "Qual Passing Year")?></td>
					</tr>
                                        <tr>
						<td style="color: #3B0B2E"><b>B_ED</b></td>
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
						<td  style="color: #3B0B2E"><b>Passport Size Photo</b></td>
						<td><?php   if(odbc_result($rs, "Image")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Image")!=""){
                                                             echo "<a href='".odbc_result($rs, "Image")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?></td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>PAN No.</b></td>
						<td><?php   if(odbc_result($rs, "PanCard")=="") echo "Not Received";
                                                         if(odbc_result($rs, "PanCard")!=""){
                                                             echo "<a href='".odbc_result($rs, "PanCard")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Aadhar No</b></td>
						<td><?php   if(odbc_result($rs, "Aadhar")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Aadhar")!=""){
                                                             echo "<a href='".odbc_result($rs, "Aadhar")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Apointment Letter</b></td>
						<td><?php   if(odbc_result($rs, "Apointment Letter")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Apointment Letter")!=""){
                                                             echo "<a href='".odbc_result($rs, "Apointment Letter")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Highest Qualification Certificate</b></td>
						<td><?php   if(odbc_result($rs, "H Qualification")=="") echo "Not Received";
                                                         if(odbc_result($rs, "H Qualification")!=""){
                                                             echo "<a href='".odbc_result($rs, "H Qualification")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Previous Employment Certificate</b></td>
						<td><?php   if(odbc_result($rs, "Prev Employment")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Prev Employment")!=""){
                                                             echo "<a href='".odbc_result($rs, "Prev Employment")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>DOB Certificate</b></td>
						<td><?php   if(odbc_result($rs, "Dob")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Dob")!="") {
                                                             echo "<a href='".odbc_result($rs, "Dob")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Voter Id Card</b></td>
						<td><?php   if(odbc_result($rs, "Voter Id")=="") echo "Not Received";
                                                         if(odbc_result($rs, "Voter Id")!=""){
                                                             echo "<a href='".odbc_result($rs, "Voter Id")."' >"
                                                                     . "<span class='glyphicon glyphicon-download-alt'></span></a>";
                                                         }
                                                                 
                                                         ?>
                                                   </td>
					</tr>
					<tr>
						<td style="color: #3B0B2E"><b>Passport</b></td>
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
	
	
	<a href="#" onclick="history.go(-1)" class="btn btn-default">Back</a>
	
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


<?php require_once("../footer.php"); ?>