<!-- Modal HTML -->
<div id="myModal<?php echo $i?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enquiry Details for <?php  echo odbc_result($result, "Name") ?></h4>
            </div>
            <div class="modal-body">
<div class="tabbable"> <!-- Only required for left/right tabs -->
<ul class="nav nav-tabs">
<li class="active"><a href="#myModal<?php echo $i?>tab1" data-toggle="tab">General</a></li>
<li><a href="#myModal<?php echo $i?>tab2" data-toggle="tab">Communication</a></li>
<li><a href="#myModal<?php echo $i?>tab3" data-toggle="tab">Parent Information</a></li>
<li><a href="#myModal<?php echo $i?>tab4" data-toggle="tab">Enquiry Details</a></li>
<li><a href="#myModal<?php echo $i?>tab5" data-toggle="tab">Follow-up</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="myModal<?php echo $i?>tab1">
<div class="table-responsive">
<table border="0px" align="center"" class="table">
<tr>
<td colspan="6"><h4>Basic Information</h4></td>
</tr>
<td height="50px">Enquiry No</td>
<td height="50px" colspan="5" style="font-weight: bold;"><?php  echo odbc_result($result, "No_") ?></td>
</tr>
<tr>
<td height="50px">Enquiry Date</td>
<td height="50px" style="font-weight: bold;"><?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($result, "Enquiry Date")))) ?></td>
<td height="50px">Addmission for Year</td>
<td height="50px" style="font-weight: bold;"><?php  echo odbc_result($result, "Admission For Year") ?></td>
</tr>
<tr>
<td height="50px">Student Name</td>
<td height="50px" colspan="5" style="font-weight: bold;"><?php  echo odbc_result($result, "Name") ?></td>
</tr>
<tr>
<td height="50px">Gender</td>
<td height="50px" style="font-weight: bold;"><?php
if(odbc_result($result, "Gender") == 1) echo "Boy";
if(odbc_result($result, "Gender") == 2) echo "Girl";
?></td>
<td height="50px">Date of Birth</td>
<td height="50px" style="font-weight: bold;"><?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($result, "Date of Birth")))) ?></td>
</tr>
<tr>
<td height="50px">Class Applied</td>
<td height="50px" style="font-weight: bold;"><?php  echo odbc_result($result, "Class Applied") ?></td>
<td height="50px">Curriculum Interested</td>
<td height="50px" style="font-weight: bold;"><?php  echo odbc_result($result, "Curriculum Intrested") ?></td>
</tr>
<tr>
<td>Mother's Name</td>
<td style="font-weight: bold;"><?php  echo odbc_result($result, "Mother_s Name") ?></td>
<td>Father's Name</td>
<td style="font-weight: bold;"><?php  echo odbc_result($result, "Father_s Name") ?></td>
</tr>
<tr>
<td>Gurdian Name</td>
<td colspan="5" style="font-weight: bold;"><?php  echo odbc_result($result, "Guardian Name") ?></td>
</tr>
<tr>
<td>Transport Required</td>
<td colspan="5" style="font-weight: bold;">
<?php  if(odbc_result($result, "Transport Required")== 1) echo "&#x2713;"?>
<?php if(odbc_result($result, "Transport Required")== 0) echo "&#x2717;"?>
</td>
</tr>
<tr>
<td>Physically Challenged</td>
<td colspan="5" style="font-weight: bold;"><?php if(odbc_result($result, "Physically Challenged")== 1) echo "&#x2713;"?></td>
</tr>
<tr>
<td>Concession Category</td>
<td colspan="5" style="font-weight: bold;"><?php
//if(odbc_result($result, "Category")==0) echo "";
if(odbc_result($result, "Category")==0) echo "General";
if(odbc_result($result, "Category")==1) echo "Defence";
if(odbc_result($result, "Category")==2) echo "Staff";
if(odbc_result($result, "Category")==3) echo "Sibling";
if(odbc_result($result, "Category")==4) echo "Other";
//if(odbc_result($result, "Category")==6) echo "RTE/EWS";
if(odbc_result($result, "EWS")==1) echo "RTE/EWS";
?></td>
</tr>
<tr>
<td>Language 2</td>
<td colspan="5" style="font-weight: bold;"><?php
if(odbc_result($result, "Langauge 1")==0) echo "";
if(odbc_result($result, "Langauge 1")==1) echo "Hindi";
if(odbc_result($result, "Langauge 1")==2) echo "Tamil";
if(odbc_result($result, "Langauge 1")==3) echo "Sanskrit";
if(odbc_result($result, "Langauge 1")==4) echo "Kannada";
if(odbc_result($result, "Langauge 1")==5) echo "French";
?></td>
</tr>
<tr>
<td>Language 3</td>
<td colspan="5" style="font-weight: bold;"><?php                    
if(odbc_result($result, "Language 2")==0) echo "";
if(odbc_result($result, "Language 2")==1) echo "Hindi";
if(odbc_result($result, "Language 2")==2) echo "Tamil";
if(odbc_result($result, "Language 2")==4) echo "Sanskrit";
if(odbc_result($result, "Language 2")==3) echo "Kannada";
?></td>
</tr>
<tr>
<td colspan="6"><h4>Details of the Institution last attended</h4></td>
</tr>
<tr>
<td>Name of the Previous School</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Name Of The Previous Institute")?></td>
</tr>
<tr>
<td>Last class attended</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Class Last Attended")?></td>
</tr>
<tr>
<td>Curricullum Followed</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Curriculum Followed")?></td>
</tr>
<tr>
<td>Medium of Instruction</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Medium Of Instruction")?></td>
</tr>
</table>
</div>
</div>
<div class="tab-pane" id="myModal<?php echo $i?>tab2">
<div class="table-responsive">
<table border="0px" align="center"" class="table">
<tr>
<td>Address of</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Address To")?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<td>Addressee</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Addressee")?></td>
</tr>
<tr>
<td>Address 1</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Address 1")?></td>
</tr>
<tr>
<td>Address2</td>
<td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "Address 2")?></td>
</tr>
<tr>
<td>City</td><td style="font-weight: bold;"><?php echo odbc_result($result, "City")?></td>
<td colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($result, "State")?> </strong></td>
</tr>
<tr>
<td>Country</td><td style="font-weight: bold;"><?php echo odbc_result($result, "Country Code")?></td>
<td colspan="2">Post Code &nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($result, "Post Code")?></strong></td>
</tr>
<tr>
<td>Phone No. (Landline)</td><td style="font-weight: bold;"><?php echo odbc_result($result, "Phone Number")?></td>
<td colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($result, "Mobile Number")?></strong></td>
</tr>
<tr>
<td>Email</td><td colspan="5" style="font-weight: bold;"><?php echo odbc_result($result, "E-Mail Address")?></td>
</tr>
</table>
</div>
</div>
<div class="tab-pane" id="myModal<?php echo $i?>tab3">
<div class="table-responsive">
<table border="0px" align="center"" class="table">
<tr>
<td colspan="6"><h4>Father's Detail</h4></td>
</tr>
<tr>
<td>Qualification</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father_s Qualification")?></td>
<td>Office Address 1</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father Office Address 1")?></td>
</tr>
<tr>
<td>Occupation</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father_s Occupation")?></td>
<td>Office Address 2</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father Office Address 2")?></td>
</tr>
<tr>
<td>Annual Income</td>
<td style="font-weight: bold;"><?php echo number_format((float)odbc_result($result, "Father_s Annual Income"),2, '.', '')?></td>
<td>Office Post Code</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father Office Post Code")?></td>
</tr>
<tr>
<td>Office City</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father Office City")?></td>
<td>Office Country</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Father Office Country Code")?></td>
</tr>
<tr>
<td colspan="6"><h4>Mother's Detail</h4></td>
</tr>
<tr>
<td>Qualification</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother_s Qualification")?></td>
<td>Office Address 1</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother Office Address 1")?></td>
</tr>
<tr>
<td>Occupation</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother_s Occupation")?></td>
<td>Office Address 2</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother Office Address 2")?></td>
</tr>
<tr>
<td>Annual Income</td>
<td style="font-weight: bold;"><?php echo number_format((float)odbc_result($result, "Mother_s Annual Income"),2, '.', '')?></td>
<td>Office Post Code</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother Office Post Code")?></td>
</tr>
<tr>
<td>Office City</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother Office City")?></td>
<td>Office Country</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Mother Office Country Code")?></td>
</tr>
<tr>
<td colspan="6"><h4>Guardian's Detail</h4></td>
</tr>
<tr>
<td colspan="2">If Guardian then please specify the relationship</td>
<td colspan="2" style="font-weight: bold;"><?php echo odbc_result($result, "Relationship with Applicant")?></td>
</tr>
<tr>
<td>Qualification</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Qualification")?></td>
<td>Office Address 1</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Office Address 1")?></td>
</tr>
<tr>
<td>Occupation</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Occupation")?></td>
<td>Office Address 2</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Office Address 2")?></td>
</tr>
<tr>
<td>Annual Income</td>
<td style="font-weight: bold;"><?php echo number_format((float)odbc_result($result, "Guardian Annual Income"),2, '.', '') ?></td>
<td>Office Post Code</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Office Post Code")?></td>
</tr>
<tr>
<td>Office City</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Office City")?></td>
<td>Office Country</td>
<td style="font-weight: bold;"><?php echo odbc_result($result, "Guardian Office Country Code")?></td>
</tr>
</table>
</div>
</div>
<div class="tab-pane" id="myModal<?php echo $i?>tab4">
<div class="table-responsive">
<table border="0px" align="center"" class="table">
<tr>
<td>Type of Enquiry</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "Type Of Enquiry")?></td>
</tr>
<tr>
<td>Enquiry Source</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "Enquiry Source")?></td>
</tr>
<tr>
<td>Enquiry Status</td>
<td colspan="3" style="font-weight: bold;"><?php
if(odbc_result($result, "Enquiry Status")==0) echo "Hot";
if(odbc_result($result, "Enquiry Status")==1) echo "Cold";
if(odbc_result($result, "Enquiry Status")==2) echo "Warm";
?></td>
</tr>
<tr>
<td>Distance (in KM)</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "Distance")?></td>
</tr>
<tr>
<td>Enquiry Remarks</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "Remarks1")?></td>
</tr>
</table>
</div>
</div>
<div class="tab-pane" id="myModal<?php echo $i?>tab5">
<div class="table-responsive">
<table border="0px" align="center"" class="table">
<tr>
<td>Follow-up Date</td>
<td colspan="3" style="font-weight: bold;"><?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($result, "Next FollowUp Date")))) ?></td>
</tr>
<tr>
<td>Follow-up 1</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "FollowUP1")?></td>
</tr>
<tr>
<td>Follow-up 2</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "FollowUP2")?></td>
</tr>
<tr>
<td>Follow-up 3</td>
<td colspan="3" style="font-weight: bold;"><?php echo odbc_result($result, "FollowUP3")?></td>
</tr>
</table>
</div>
</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>