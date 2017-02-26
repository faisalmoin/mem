<?php
    
    //$row = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));
    //$cust = odbc_exec($conn, "SELECT * FROM [Temp Customer] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));
    
    $StuDOB = date("Y-m-d", strtotime(str_replace("-", "/", odbc_result($row, "Date Of Birth"))));
    $today = date("Y-m-d");


    $diff = abs(strtotime($today) - strtotime($StuDOB));

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    
?>
<!-- Modal HTML -->
<div id="myModal<?php echo $i?>" class="modal fade">
    <div class="modal-dialog" style="width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Student Card for <?php  echo odbc_result($result, "Name") ?></h4>
            </div>
            <div class="modal-body">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#myModal<?php echo $i?>tab1" data-toggle="tab">General</a></li>
                        <li><a href="#myModal<?php echo $i?>tab2" data-toggle="tab">Communication</a></li>
                        <li><a href="#myModal<?php echo $i?>tab3" data-toggle="tab">Personal</a></li>
                        <li><a href="#myModal<?php echo $i?>tab4" data-toggle="tab">Other Details</a></li>
                        <li><a href="#myModal<?php echo $i?>tab5" data-toggle="tab">Parent Info</a></li>
		    <li><a href="#myModal<?php echo $i?>tab6" data-toggle="tab">Sibling & Discount Info</a></li>
                    </ul>
                   
                                 <?php

                            $Bal = odbc_exec($conn, "SELECT SUM([Amount]) FROM schoolerp.dbo.[".$ms."\$Detailed Cust_ Ledg_ Entry] WHERE [Customer No_]='$id'");	
                   ?>
<div class="tab-content">
   <div class="tab-pane active" id="myModal<?php echo $i?>tab1">
          <table class='table table-responsive'>
        <tr>
            <td>System Admission No.</td>
            <td class="text-success"><?php echo odbc_result($result, "No_")?></td>
            <td>Mother Tongue</td>
            <td class="text-success"><?php echo odbc_result($result, "Mother Tongue")?></td>
            <td>EWS</td>
            <td class="text-success"><?php if(odbc_result($result, "EWS")==1) echo " checked"?></td>
        </tr>
        <tr>
            <td>Student Name</td>
            <td class="text-success"><?php echo odbc_result($result, "Name")?></td>
            <td >Caste</td>
            <td class="text-success"><?php echo odbc_result($result, "Caste")?></td>
            <td>Transport Required</td>
            <td class="text-success"><?php if (odbc_result($result, "Transport Required")==1) echo "Yes"; 
                        if (odbc_result($result, "Transport Required")==2) echo "No"?>
            </td>
        </tr>
        <tr>
            <td>Gender</td>
            <td class="text-success"><?php if(odbc_result($result, "Gender")==1) echo "Boy"; if(odbc_result($result, "Gender")==2) echo "Girl"; ?></td>
            <td>Community</td>
            <td class="text-success"><?php echo odbc_result($result, "Community")?></td>
            <td>Category</td>
            <td class="text-success"><?php 
                                                                if(odbc_result($result, "Category")==0) echo "";
                                                                if(odbc_result($result, "Category")==1) echo "GENERAL";
                                                                if(odbc_result($result, "Category")==2) echo "EX-SERVICEMAN";
                                                                if(odbc_result($result, "Category")==3) echo "STAFF CHILD";
                                                                if(odbc_result($result, "Category")==4) echo "SIBLING";
                                                                if(odbc_result($result, "Category")==5) echo "OTHER DISCOUNTS";
                                                            ?></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td class="text-success"><?php echo date("d/M/Y", strtotime(odbc_result($result, "Date Of Birth")));?></td>
            <td>Religion</td>
            <td class="text-success"><?php echo odbc_result($result, "Religion")?></td>
            <td>Physically Challenged</td>
            <td class="text-success"><?php if(odbc_result($result, "Physically Challanged")==1) echo " checked";?> </td>
        </tr>
        <tr>
            <td>Age</td>
            <td class="text-success"><?php echo $years;?></td>
            <td>Latest Rank</td>
            <td class="text-success"><?php echo odbc_result($result, "Latest Rank")?></td>
            <td>Language 2</td>
            <td>
              <!---  <select name='Language1' class="form-control">
                    <option value='0' <?php if(odbc_result($result, "Langauge 1")==0) echo " selected"?>></option>
                    <option value='1' <?php if(odbc_result($result, "Langauge 1")==1) echo " selected"?>>Hindi</option>
                    <option value='2' <?php if(odbc_result($result, "Langauge 1")==2) echo " selected"?>>Tamil</option>
                    <option value='3' <?php if(odbc_result($result, "Langauge 1")==3) echo " selected"?>>Sanskrit</option>
                    <option value='4' <?php if(odbc_result($result, "Langauge 1")==4) echo " selected"?>>Kannada</option>
                    <option value='5' <?php if(odbc_result($result, "Langauge 1")==5) echo " selected"?>>French</option>
                </select>--->
            </td>
        </tr>
        <tr>
            <td>Month</td>
            <td class="text-success"><?php echo $months;?></td>
            <td>Latest GPA</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "Latest GPA"),2,'.','')?></td>
            <td>Language 3</td>
            <td>
              <!--  <select name='Language2' class="form-control">
                    <option value='0' <?php if(odbc_result($result, "Langauge 1")==0) echo " selected"?>></option>
                    <option value='1' <?php if(odbc_result($result, "Langauge 1")==1) echo " selected"?>>Hindi</option>
                    <option value='2' <?php if(odbc_result($result, "Langauge 1")==2) echo " selected"?>>Tamil</option>
                    <option value='3' <?php if(odbc_result($result, "Langauge 1")==3) echo " selected"?>>Kannada</option>
                    <option value='4' <?php if(odbc_result($result, "Langauge 1")==4) echo " selected"?>>Sanskrit</option>
                </select>--->
            </td>
        </tr>
        <tr>
            <td>Class Code</td>
            <td class="text-success"><?php echo odbc_result($row, "Class Code");?></td>
            <td>Latest Grade</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "Latest Grade"),2, '.','')?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Class</td>
            <td class="text-success"><?php echo odbc_result($result, "Class");?></td>
            <td>CGPA</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "CGPA"),2, '.', '')?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Section</td>
            <td>
               
            </td>
            <td>Pickup</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "Pickup"),2,'.','')?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Curriculum</td>
            <td class="text-success"><?php echo odbc_result($result, "Curriculum")?></td>
            <td>Drop</td>
            <td class="text-success"><?php echo odbc_result($result, "Drop")?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Academic Year</td>
            <td class="text-success"><?php echo odbc_result($result, "Academic Year")?></td>
            <td>Distance Covered in KM</td>
            <td class="text-success"><?php echo number_format(odbc_result($row, "Distance Covered in KM"),2, '.', '')?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Previous Class</td>
            <td class="text-success"><?php echo odbc_result($result, "Previous Class")?></td>
            <td>Transport Slab Code</td>
            <td class="text-success"><?php echo odbc_result($result, "Slab Code")?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Previous Curriculum</td>
            <td class="text-success"><?php echo odbc_result($result, "Previous Curriculum")?></td>
            <td>Transport Fee</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "Transport Fee"), '2','.','')?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Medium of Instruction</td>
            <td class="text-success"><?php echo odbc_result($result, "Medium of Instruction")?></td>
            <td>Route No</td>
            <td class="text-success"><?php echo odbc_result($result, "Route No_")?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Citizenship</td>
            <td class="text-success"><?php echo odbc_result($result, "Citizenship")?></td>
            <td>Route Details</td>
            <td class="text-success"><?php echo odbc_result($result, "Route Details")?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Hostel Accommodation</td>
            <td class="text-success"><?php if(odbc_result($result, "Citizenship")==1) echo " checked"?></td>
            <td>Approval Status</td>
            <td class="text-success"><?php if(odbc_result($result, "Approval Status")==0) echo "Open"; if(odbc_result($row, "Approval Status")==1) echo "Approved"; if(odbc_result($row, "Approval Status")==2) echo "Pending Approval"; ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Student Admission No</td>
            <td class="text-success"><?php echo odbc_result($result, "Hostel Code"); ?></td>
            <td>Old Admission No</td>
            <td class="text-success"><?php echo odbc_result($result, "Old Admission No_"); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Room No</td>
            <td class="text-success"><?php echo odbc_result($result, "Room No_"); ?></td>
            <td>Date Joined</td>
            <td class="text-success"><?php echo date("d/M/Y", strtotime(odbc_result($result, "Date Joined"))); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Room Type</td>
            <td class="text-success"><?php echo odbc_result($result, "Room Type"); ?></td>
            <td>Date of Leaving</td>
            <td class="text-success"><?php echo ((odbc_result($result, "Date of Leaving") != "1753-01-01 00:00:00.000")?date("d/M/Y", strtotime(odbc_result($row, "Date of Leaving"))):""); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Mess</td>
            <td class="text-success"><?php echo odbc_result($result, "Mess"); ?></td>
            <td>Balance LCY</td>
            <td class="text-success"><?php echo number_format(odbc_result($Bal, ""),'2','.',''); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>House</td>
            <td class="text-success"><?php echo odbc_result($result, "House"); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Points</td>
            <td class="text-success"><?php echo number_format(odbc_result($result, "Mess"),2,'.',''); ?></td>
            <td>Stream</td>
            <td>
        
<!---<select name="Stream" class="form-control unknown" id="Stream" disabled="true">
                    <option value="0" <?php if(odbc_result($result, 'Stream') == 0) echo " selected" ?>></option>
                    <option value="1" <?php if(odbc_result($result, 'Stream') == 1) echo " selected" ?>>Science</option>
                    <option value="2" <?php if(odbc_result($result, 'Stream') == 2) echo " selected" ?>>Science Non-Medical</option>
                    <option value="3" <?php if(odbc_result($result, 'Stream') == 3) echo " selected" ?>>Science Medical</option>
                    <option value="4" <?php if(odbc_result($result, 'Stream') == 4) echo " selected" ?>>Commerce</option>
                    <option value="5" <?php if(odbc_result($result, 'Stream') == 5) echo " selected" ?>>Arts</option>
                </select>---->
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
                  
  <div class="tab-pane" id="myModal<?php echo $i?>tab2">
	<table class="table">
		<tr>
			<td>Address To</td>
			<td>
                       <!--     <select name="CommunicationReference" class="form-control" style="background-color: #ffff00;" id="CommunicationReference" onchange="copy();">
									<option value=""></option>
									<option value="FATHER"  <?php if (odbc_result($result,  "Address To") == "FATHER") echo " selected";?>>Father</option>
									<option value="MOTHER"  <?php if (odbc_result($result,  "Address To") == "MOTHER") echo " selected";?>>Mother</option>
									<option value="GUARDIAN"  <?php if (odbc_result($result,  "Address To") == "GUARDIAN") echo " selected";?>>Guardian</option>
								</select>--->
			</td>
		</tr>
		<tr>
			<td>Contact Name</td>
			<td class="text-success"><?php echo odbc_result($result,  'Addressee'); ?>
			</td>
		</tr>
		<tr>
			<td>Address 1</td>
			<td class="text-success"><?php echo odbc_result($result,  'Address1')?></td>
		</tr>
		<tr>
			<td>Address 2</td>
			<td class="text-success"><?php echo odbc_result($result, 'Address2')?></td>
		</tr>
		<tr>
			<td>City</td>
			<td class="text-success"><?php echo odbc_result($result, 'City')?></td>
		</tr>
		<tr>
			<td>Post Code</td>
			<td class="text-success"><?php echo odbc_result($result,  'Post Code')?></td>
		</tr>
		<tr>
			<td>State</td>
			<td class="text-success"><?php echo odbc_result($result,  'State')?></td>
		</tr>
		<tr>
			<td>Country</td>
			<td class="text-success"><?php echo odbc_result($result,  'Country')?></td>
		</tr>
		<tr>
			<td>Phone No</td>
			<td class="text-success"><?php echo odbc_result($result,  'phone number')?></td>
		</tr>
		<tr>
			<td>Mobile</td>
			<td class="text-success"><?php echo odbc_result($result,  'mobile number')?></td>
		</tr>
		<tr>
			<td>E-Mail Address</td>
			<td class="text-success"><?php echo odbc_result($result,  'e-mail address')?></td>
		</tr>
		<tr>
			<td>Father Email</td>
			<td class="text-success"><?php echo odbc_result($result,  'father email')?></td>
		</tr>
		<tr>
			<td>Mother Email</td>
			<td class="text-success"><?php echo odbc_result($result,  'mother email')?></td>
		</tr>
	</table>
	</div>
                        
<div class="tab-pane" id="myModal<?php echo $i?>tab3">
	<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Parents Details</h3></td></td></tr>
                <tr><td colspan="4"><h4 class="text-primary">Father's Details</h4></td></td></tr>
		<tr>
			<td>Father's Name</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father_s Name'); ?></td>
			<td>Passport No.</td>
                        <td class="text-success"></td>
		</tr>
		<tr>
			<td>Father's Qualification</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father_s Qualification'); ?></td>
			<td>Password Exp. Date</td>
			<td class="text-success"></td>
		</tr>
		<tr>
			<td>Father's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father_s Occupation'); ?></td>
			<td>Visa No.</td>
			<td class="text-success"></td>
		</tr>
		<tr>
			<td>Father's Annual Income</td>
			<td class="text-success"><?php echo number_format((float)odbc_result($result,  'Father_s Annual Income'),'2','.',''); ?></td>
			<td>Visa Exp. Date</td>
			<td class="text-success"></td>
		</tr>
                <tr><td colspan="4"><h4 class="text-primary">Mother's Details</h4></td></td></tr>
		<tr>
			<td>Mother's Name</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother_s Name'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Qualification</td>
                        <td class="text-success"><?php echo odbc_result($row,  'Mother_s Qualification'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother_s Occupation'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Mother's Annual Income</td>
			<td class="text-success"><?php echo number_format((float)odbc_result($result,  'Mother_s Annual Income'),'2','.',''); ?></td>
			<td></td>
			<td></td>
		</tr>
                <tr><td colspan="4"><h4 class="text-primary">Guardian's Details</h4></td></td></tr>
		<tr>
			<td>Guardian's Name</td>
			<td class="text-success"><?php echo odbc_result($result,  'Guardian Name'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td class="text-success"><?php echo odbc_result($result,  'Guardian Qualification'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  'Guardian Occupation'); ?></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td class="text-success"><?php echo number_format((float)odbc_result($result,  'Guardian Annual Income'),'2','.',''); ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
		</div>
		
<div class="tab-pane" id="myModal<?php echo $i?>tab4">
                       <table class="table table-responsive">
                <tr>
                    <td>Date Joined</td>
                    <td class="text-success"><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date Joined")))?></td>
                    <td>Fee Classification</td>
                    <td class="text-success"><?php echo odbc_result($result, "Fee Classification")?></td>
                    <td>Discount Code</td>
                    <td class="text-success"><?php echo odbc_result($result, "Discount Code")?></td>
                </tr>
                <tr>
                    <td>Height</td>
                    <td class="text-success"><?php echo number_format(odbc_result($result, "Height"),'2','.','')?></td>
                    <td>Student Status</td>
                    <td  class="text-success"><?php if(odbc_result($result, "Student Status")==1) echo "Student"; if(odbc_result($row, "Student Status")==2) echo "In-active"; if(odbc_result($row, "Student Status")==3) echo "Alumni"; ?></td>
                    <td>Discount Classification</td>
                    <td class="text-success"><?php echo odbc_result($result, "Discount Classification")?></td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td class="text-success"><?php echo number_format(odbc_result($row, "Weight"),'2','.','')?></td>
                    <td>Block</td>
                    <td class="text-success"><input type="checkbox" <?php if(odbc_result($result, "Block")==1) echo " checked"?> disabled="true"></td>
                    <td>Discount Code 1</td>
                    <td class="text-success"><?php echo odbc_result($result, "Discount Code 1")?></td>
                </tr>
                <tr>
                    <td>Quota</td>
                    <td class="text-success"><?php echo odbc_result($result, "Quota")?></td>
                    <td>Admission For Year</td>
                    <td class="text-success"><?php echo odbc_result($result, "Admission For Year") ?></td>
                    <td>Discount Classification 1</td>
                    <td class="text-success"><?php echo odbc_result($result, "Discount Classification1")?></td>
                </tr>
                <tr>
                    <td>Staff Child</td>
                    <td class="text-success"><input type="checkbox" value="<?php if(odbc_result($result, "Staff Child")==1) echo " checked"?>" disabled="true"></td>
                    <td>Physically Challenged</td>
                    <td colspan="3"><input type="checkbox" disabled="true" <?php if(odbc_result($row, "Physically Challenged")==1) echo " checked"; ?>></td>
                </tr>
                <tr>
                    <td>Staff Code</td>
                    <td class="text-success"><?php echo odbc_result($result, "Staff Code")?></td>
                    <td></td>
                    <td colspan="2" align="center" style="border-left: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;"><b>TC Details</b></td>                    
                </tr>
                <tr>
                    <td>Application No</td>
                    <td class="text-success"><?php echo odbc_result($row, "Application No_")?></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 1px solid #d3d3d3;">TC Number</td>
                    <td style="border-right: 1px solid #d3d3d3;"><?php echo odbc_result($result, "Staff Code")?></td>
                </tr>
                <tr>
                    <td>Registration No</td>
                    <td class="text-success"><?php echo odbc_result($result, "Registration No_")?></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 1px solid #d3d3d3;">TC Date</td>
                    <td style="border-right: 1px solid #d3d3d3;"><?php if(odbc_result($result, "TC Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TC Date")))?></td>
                </tr>
                <tr>
                    <td>User ID</td>
                    <td class="text-success"><?php echo odbc_result($result, "User ID")?></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 0px solid #d3d3d3;">Withdrawal Applied Date</td>
                    <td style="border-right: 0px solid #d3d3d3;"><?php if(odbc_result($result, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TC Date")))?></td>
                    
                </tr>
                <tr>
                    <td>Approver ID</td>
                    <td class="text-success"><?php echo odbc_result($result, "Approver ID")?></td>
                </tr>            
             <!---   <tr>
                    <td colspan="6" style="text-align: center"><b>Approval Request</b></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>New Changes</td>                    
                    <td>Previous Value</td>
                    <td>Remove Previous Value</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Student Status</td>
                    <td>
                        <select name="StuStatNew" class="form-control">                            
                            <option value=""></option>
                            <option value="2" <?php if(odbc_result($result, "Student Status 1")== "2") echo " selected";?>>In-active</option>
                        </select>
                    </td>
                    <td class="text-success"><?php if(odbc_result($result, "Student Status")==1) echo "Student"; if(odbc_result($row, "Student Status")==2) echo "In-active"; if(odbc_result($row, "Student Status")==3) echo "Alumni"; ?></td>
                    <td></td>
                    <td><?php if(odbc_result($result, "Student Status 1")!= "0") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Class Code</td>
                    <td>
                        <select name="ClassCodeNew" class="form-control">
                            <option value=""></option>
                            <?php
                                $clcdNew = odbc_exec($conn, "SELECT [Class Code] FROM [Class Section] WHERE [Academic Year]='".odbc_result($result, "Academic Year")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($clcdNew)){
                                    echo "<option value='".odbc_result($clcdNew, "Class Code")."'";
                                    if(odbc_result($result, "Class code 1") == odbc_result($clcdNew, "Class Code")) echo " selected";
                                    echo ">".odbc_result($clcdNew, "Class Code")."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td class="text-success"><?php echo(odbc_result($row, "Class Code")); ?></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "Class code 1")!= "") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>EWS</td>
                    <td><input type="checkbox" value="1" name="EWSNew" <?php if(odbc_result($result, "EWS 1")==1) echo " checked"; ?> ></td>
                    <td><input type="checkbox" value="<?php if(odbc_result($result, "EWS")==1) echo " checked"; ?>" disabled="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($result, "EWS 1") !="0") echo "Approval pending";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount Code</td>
                    <td>
                        <select name="DiscCdNew" class="form-control" <?php if(odbc_result($result, 'Bool1')==1) echo " checked"?>>
                            <option value=""></option>
                            <?php 
                                $discCd1 = odbc_exec($conn, "SELECT [No_], [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Academic Year]='".odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($discCd1)){
                                    echo "<option value='".odbc_result($discCd1, "No_")."'";
                                    if(odbc_result($discCd1, "No_")==odbc_result($result, "Discount Code New")) echo " selected";
                                    echo ">".odbc_result($discCd1, "No_")." ( ".odbc_result($discCd1, "Fee Clasification Code").")</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td class="text-success"><?php echo(odbc_result($result, "Discount Code")); ?></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscCd1" <?php if(odbc_result($result, 'Bool2')==1) echo " checked"?>></td>
                    <td><?php if(odbc_result($row, "Discount Code New")!= "" || odbc_result($result, 'Bool2')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount Code 1</td>
                    <td>
                        <select name="DiscCdNew1" class="form-control" <?php if(odbc_result($result, 'Bool3')==1) echo " disabled"?>>
                            <option value=""></option>
                            <?php 
                                $discCd2 = odbc_exec($conn, "SELECT [No_], [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Academic Year]='".odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($discCd2)){
                                    echo "<option value='".odbc_result($discCd2, "No_")."'";
                                    if(odbc_result($discCd2, "No_")==odbc_result($result, "Discount Code1 New")) echo " selected";
                                    echo ">".odbc_result($discCd2, "No_")." ( ".odbc_result($discCd2, "Fee Clasification Code").")</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td class="text-success"><?php echo(odbc_result($result, "Discount Code 1")); ?></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscCd2" <?php if(odbc_result($result, 'Bool3')==1) echo " checked"?> ></td>
                    <td><?php if(odbc_result($row, "Discount Code1 New")!= "" || odbc_result($result, 'Bool3')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Transport Slab</td>
                    <td>
                        <select name="TransportSlab" class="form-control" id="TransportSlab" <?php if(odbc_result($result, 'Bool1')==1) echo " disabled";?>>
                            <option value=""></option>
                            <?php 
                                $tpslab = odbc_exec($conn, "SELECT [Slab Code] FROM [Transport Slab] WHERE [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($tpslab)){
                                    echo "<option value='".odbc_result($tpslab, "Slab Code")."'";
                                    if(odbc_result($tpslab, "Slab Code") == odbc_result($result, "Transport Slab Code New")) echo " selected";
                                    echo ">".odbc_result($tpslab, "Slab Code")."</option>";
                                }
                            ?>
                        </select>
                    </td>
                 
                    <td class="text-success"><?php echo(odbc_result($row, "Slab Code")); ?></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscTrans" id="RmvDiscTrans" onclick="myFunction(this)" <?php if(odbc_result($result, 'Bool1')==1) echo " checked" ?>></td>
                    <td><?php if(odbc_result($result, "Transport Slab Code New")!= "" || odbc_result($result, 'Bool1')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TPT Availing Date</td>
                    <td class="text-success">
                        <?php if(odbc_result($row, "TPT Availing Date-T")!="1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TPT Availing Date-T")))?>  </td>
                    <td class="text-success"><?php if(odbc_result($result, "TPT Availing Date")!="1753-01-01 00:00:00.000") echo(date('d/M/Y', strtotime(odbc_result($row, "TPT Availing Date")))); ?></td>
                    <td></td>
                    <td><?php if(odbc_result($result, "TPT Availing Date-T")!="1753-01-01 00:00:00.000") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TPT Withdrawal Date</td>
                    <td class="text-success">
                      <?php if(odbc_result($result, 'TPT Withdrawal Date-T') != '1753-01-01 00:00:00.000' ) echo date('d/M/Y', strtotime(odbc_result($row, "TPT Withdrawal Date-T")))?>
                               
                    </td>
                    <td class="text-success"><?php if(odbc_result($result, "TPT Withdrawal Date-T") != "1753-01-01 00:00:00.000") echo(date('d/M/Y', strtotime(odbc_result($result, "TPT Withdrawal Date")))); ?></td>
                    <td></td>
                    <td><?php if(odbc_result($result, "TPT Withdrawal Date-T") != "1753-01-01 00:00:00.000") echo "Pending Approval";?></td>
                </tr>--->
            </table>


                    </div>
		     <div class="tab-pane" id="myModal<?php echo $i?>tab5">
			<table class="table">
		<tr><td colspan="4"><h3 class="text-primary">Father's Details</h3></td></tr>
		<tr>
			<td>Father's Name</td>
                        <td  class="text-success"><?php echo odbc_result($result,  'Father_s Name')?></td>
			<td>Father's Office Address 1</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father Office Address 1')?></td>
		</tr>
		<tr>
			<td>Father's Qualification</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father_s Qualification')?></td>
			<td>Father's Office Address 2</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father Office Address 2')?></td>
		</tr>
		<tr>
			<td>Father's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father_s Occupation')?></td>
			<td>Father's Office City</td>
			<td class="text-success"><?php echo odbc_result($row,  'Father Office City')?></td>
		</tr>
		<tr>
			<td>Father's Annual Income</td>
			<td class="text-success"><?php echo number_format((float)odbc_result($result,  'Father_s Annual Income'),'2','.','')?></td>
			<td>Father's Office Post Code</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father Post Code')?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Father's Office Country</td>
			<td class="text-success"><?php echo odbc_result($result,  'Father Office Country Code')?></td>
		</tr>
		<tr><td colspan="4"><h3 class="text-primary">Mother's Details</h3></td></tr>
		<tr>
			<td>Mother's Name</td>
			<td class="text-success"> <?php echo odbc_result($result,  'Mother_s Name')?></td>
			<td>Mother's Office Address 1</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother Office Address 1')?></td>
		</tr>
		<tr>
			<td>Mother's Qualification</td>
                        <td class="text-success"><?php echo odbc_result($result,  'Mother_s Qualification')?></td>
			<td>Mother's Office Address 2</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother Office Address 2')?></td>
		</tr>
		<tr>
			<td>Mother's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother_s Occupation')?></td>
			<td>Mother's Office City</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother Office City')?></td>
		</tr>
		<tr>
			<td>Mother's Annual Income</td>
			<td class="text-success"><?php echo number_format((float)odbc_result($result,  'Mother_s Annual Income'),'2','.','')?></td>
			<td>Mother's Office Post Code</td>
			<td class="text-success"><?php echo odbc_result($result,  'Mother Office Post Code')?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Mother's Office Country</td>
			<td><?php echo odbc_result($result,  'Mother Office Country Code')?></td>
		</tr>
                <tr><td colspan="4"><h3 class="text-primary">Gaurdian's Details</h3></td></tr>
		<!--<tr>
			<td>Relationship with Student</td>
			<td>
                                                                    <select name="GuardianRelationship" style="padding: 4px" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="BROTHER"  <?php if (odbc_result($result,  "Applicant Relationship") == "BROTHER") echo " selected";?>>Brother</option>
                                                                            <option value="BROTHER-IN-LAW"  <?php if (odbc_result($result,  "Applicant Relationship") == "BROTHER-IN-LAW") echo " selected";?>>Brother-in-Law</option>
                                                                            <option value="GRANDFATHER"  <?php if (odbc_result($result,  "Applicant Relationship") == "GRANDFATHER") echo " selected";?>>Grandfather</option>
                                                                            <option value="GRANDMOTHER"  <?php if (odbc_result($result,  "Applicant Relationship") == "GRANDMOTHER") echo " selected";?>>Grandmother</option>
                                                                            <option value="FATHER-IN-LAW"  <?php if (odbc_result($result,  "Applicant Relationship") == "FATHER-IN-LAW") echo " selected";?>>Father-in-Law</option>
                                                                            <option value="MOTHER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "MOTHER-IN-LAW") echo " selected";?>>Mother-in-Law</option>
                                                                            <option value="SISTER"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER") echo " selected";?>>Sister</option>
                                                                            <option value="SISTER-IN-LAW"  <?php if (odbc_result($result, "Relationship with Applicant") == "SISTER-IN-LAW") echo " selected";?>>Sister-in-Law</option>
                                                                    </select>
                        </td>
			<td colspan="2"></td>
		</tr>-->
		<tr>
			<td>Gaurdian's Name</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Name");?></td>
			<td>Gaurdian's Office Address 1</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Office Address1");?></td>
		</tr>
		<tr>
			<td>Gaurdian's Qualification</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Qualification");?></td>
			<td>Gaurdian's Office Address 2</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Office Address2");?></td>
		</tr>
		<tr>
			<td>Gaurdian's Occupation</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Occupation");?></td>
			<td>Gaurdian's Office City</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Office City");?></td>
		</tr>
		<tr>
			<td>Gaurdian's Annual Income</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Annual Income");?></td>
			<td>Gaurdian's Office Post Code</td>
			<td class="text-success"><?php echo odbc_result($result,  "Gaurdian Office Post Code");?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Gaurdian's Office Country</td>
                        <td><?php echo odbc_result($result,  "Gaurdian Office Country");?></td>
		</tr>
	</table>
			
			</div>
			
			 <div class="tab-pane" id="myModal<?php echo $i?>tab6">
			 
			    <table class="table">
                    <tr>
                        <td colspan="2"><h3 class="text-primary">Sibling Details</h3>
                        <td colspan="2"><h3 class="text-primary">Discount Details</h3>
                    </tr>
                    <tr>
                        <td>Sibling</td>
                        <td> <?php 
					if(odbc_result($result, 'Sibling') == 1) echo " checked";
				?>
				 
			</td>
                        <td>Discount Code</td>
                        <td><?php echo odbc_result($result, 'Discount Code')?></td>
                    </tr>
                    <tr>
                        <td>Sibling Code</td>
                        <td class="text-success"><?php echo odbc_result($result, 'Sibbling Code')?></td>
				<input type="hidden" name="SiblingNo" id="SiblingNo" value="<?php echo odbc_result($Student, "Sibling No_"); ?>">
                        <td>Discount Code Classification</td>
                        <td class="text-success"><?php echo odbc_result($result, 'Discount Classification')?></td>
                    </tr>
                    <tr>
                        <td>Sibling Name</td>
                        <td class="text-success"><?php echo odbc_result($result, 'Sibbling Name')?></td>
                        <td>Discount Code 1</td>
                        <td class="text-success"><?php echo odbc_result($result, 'Discount Code 1')?></td>
                    </tr>
                    <tr>
                        <td>Sibling DOB</td>
                        <td class="text-success"><?php 
				if(odbc_result($row, 'Sibling DOB') != "1900-01-01 00:00:00.000") 
					echo date('d/M/Y', strtotime(odbc_result($result, 'Sibling DOB'))); 
				else echo '' ?></td>
                        <td>Discount Code Classification 1</td>
                        <td class="text-success"><?php echo odbc_result($row, 'Discount Classification1')?></td>
                    </tr>
                    <tr>
                        <td>Sibling Class</td>
                        <td><?php echo odbc_result($result, 'Sibling Class')?></td>
                    </tr>
                    <tr>
                        <td>Sibling Section</td>
                        <td class="text-success"><?php echo odbc_result($result, 'Sibling Section')?></td>
                    </tr>
                </table>
			 </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
	  
	    
	    
	    
        </div>