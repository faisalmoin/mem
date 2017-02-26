<?php
$StuDOB = date("Y-m-d", strtotime(str_replace("-", "/", odbc_result($Student, "Date of Birth"))));
$today = date("Y-m-d");


$diff = abs(strtotime($today) - strtotime($StuDOB));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

?>

<!-- Modal HTML -->
<div id="myModal<?php echo $i?>" class="modal fade" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog" style="width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Student Card for <b class="text-primary"><?php  echo odbc_result($Student, "Name") ?></b></h4>
            </div>
            <div class="modal-body">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#myModal<?php echo $i?>tab1" data-toggle="tab">General</a></li>
                        <li><a href="#myModal<?php echo $i?>tab2" data-toggle="tab">Communication</a></li>
                        <li><a href="#myModal<?php echo $i?>tab3" data-toggle="tab">Parent Info</a></li>
                        <li><a href="#myModal<?php echo $i?>tab4" data-toggle="tab">Other Details</a></li>
                        <li><a href="#myModal<?php echo $i?>tab6" data-toggle="tab">Sibling/Discount</a></li>
                        <li><a href="#myModal<?php echo $i?>tab7" data-toggle="tab">Academics</a></li>
                        <li><a href="#myModal<?php echo $i?>tab8" data-toggle="tab">Hostel / Transport</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="myModal<?php echo $i?>tab1">
                            <div class="table-responsive">
                                <table border="0px" align="center" class="table">
                                <tr>
                                    <td colspan="6"><h4>Basic Information</h4></td>
                                </tr>
                                <td>Admission No</td>
                                <td style="font-weight: bold;"><?php  echo odbc_result($Student, "No_") ?></td>
                                <td>Admission Date</td>
                                <td style="font-weight: bold;"><?php  echo date('d/M/Y', strtotime(odbc_result($Student, "Date Joined"))) ?></td>
                                </tr>
                                <tr>
                                    <td height="50px">Student Name</td>
                                    <td height="50px" style="font-weight: bold;" colspan="5"><?php  echo odbc_result($Student, "Name") ?></td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td style="font-weight: bold;"><?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($Student, "Date of Birth")))) ?></td>
                                    <td>Age</td>
                                    <td style="font-weight: bold;"><?php  printf("%d years, %d months, %d days\n", $years, $months, $days); ?></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td style="font-weight: bold;"><?php
                                        if(odbc_result($Student, "Gender") == 1) echo "Boy";
                                        if(odbc_result($Student, "Gender") == 2) echo "Girl";
                                        ?></td>
                                    <td>Religion</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Religion") ?></td>
                                </tr>
                                <tr>
                                    <td>Caste</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Caste") ?></td>
                                    <td>Community</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Community") ?></td>
                                </tr>
                                <tr>
                                    <td>Mother Tongue</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Tongue") ?></td>
                                    <td>Citizenship</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Citizenship") ?></td>
                                </tr>
                                <tr>
                                    <td>Physically Challenged</td>
                                    <td colspan="5" style="font-weight: bold;"><?php if(odbc_result($Student, "Physically Challenged")== 1) {echo "&#x2713;";} else {echo "&#x2717;";}?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="myModal<?php echo $i?>tab2">
                            <div class="table-responsive">
                                <table border="0px" align="center"" class="table">
                                <tr>
                                    <td>Address of</td>
                                    <td colspan="5" style="font-weight: bold;"><?php echo odbc_result($Student, "Address To")?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>Addressee</td>
                                    <td colspan="5" style="font-weight: bold;"><?php echo odbc_result($Student, "Addressee")?></td>
                                </tr>
                                <tr>
                                    <td>Address 1</td>
                                    <td colspan="5" style="font-weight: bold;"><?php echo odbc_result($Student, "Address 1")?></td>
                                </tr>
                                <tr>
                                    <td>Address2</td>
                                    <td colspan="5" style="font-weight: bold;"><?php echo odbc_result($Student, "Address 2")?></td>
                                </tr>
                                <tr>
                                    <td>City</td><td style="font-weight: bold;"><?php echo odbc_result($Student, "City")?></td>
                                    <td colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($Student, "State")?> </strong></td>
                                </tr>
                                <tr>
                                    <td>Country</td><td style="font-weight: bold;"><?php echo odbc_result($Student, "Country Code")?></td>
                                    <td colspan="2">Post Code &nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($Student, "Post Code")?></strong></td>
                                </tr>
                                <tr>
                                    <td>Phone No. (Landline)</td><td style="font-weight: bold;"><?php echo odbc_result($Student, "Phone Number")?></td>
                                    <td colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<strong><?php echo odbc_result($Student, "Mobile Number")?></strong></td>
                                </tr>
                                <tr>
                                    <td>Email</td><td colspan="5" style="font-weight: bold;"><?php echo odbc_result($Student, "E-Mail Address")?></td>
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
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father_s Qualification")?></td>
                                    <td>Office Address 1</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father Office Address 1")?></td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father_s Occupation")?></td>
                                    <td>Office Address 2</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father Office Address 2")?></td>
                                </tr>
                                <tr>
                                    <td>Annual Income</td>
                                    <td style="font-weight: bold;"><?php echo number_format((float)odbc_result($Student, "Father_s Annual Income"),2, '.', '')?></td>
                                    <td>Office Post Code</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father Office Post Code")?></td>
                                </tr>
                                <tr>
                                    <td>Office City</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father Office City")?></td>
                                    <td>Office Country</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Father Office Country Code")?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><h4>Mother's Detail</h4></td>
                                </tr>
                                <tr>
                                    <td>Qualification</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother_s Qualification")?></td>
                                    <td>Office Address 1</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Office Address 1")?></td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother_s Occupation")?></td>
                                    <td>Office Address 2</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Office Address 2")?></td>
                                </tr>
                                <tr>
                                    <td>Annual Income</td>
                                    <td style="font-weight: bold;"><?php echo number_format((float)odbc_result($Student, "Mother_s Annual Income"),2, '.', '')?></td>
                                    <td>Office Post Code</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Office Post Code")?></td>
                                </tr>
                                <tr>
                                    <td>Office City</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Office City")?></td>
                                    <td>Office Country</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Mother Office Country Code")?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><h4>Guardian's Detail</h4></td>
                                </tr>
                                <tr>
                                    <td colspan="2">If Guardian then please specify the relationship</td>
                                    <td colspan="2" style="font-weight: bold;"><?php echo odbc_result($Student, "Relationship with Applicant")?></td>
                                </tr>
                                <tr>
                                    <td>Qualification</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Qualification")?></td>
                                    <td>Office Address 1</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Office Address 1")?></td>
                                </tr>
                                <tr>
                                    <td>Occupation</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Occupation")?></td>
                                    <td>Office Address 2</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Office Address 2")?></td>
                                </tr>
                                <tr>
                                    <td>Annual Income</td>
                                    <td style="font-weight: bold;"><?php echo number_format((float)odbc_result($Student, "Gaurdian Annual Income"),2, '.', '') ?></td>
                                    <td>Office Post Code</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Office Post Code")?></td>
                                </tr>
                                <tr>
                                    <td>Office City</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Office City")?></td>
                                    <td>Office Country</td>
                                    <td style="font-weight: bold;"><?php echo odbc_result($Student, "Gaurdian Office Country Code")?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="myModal<?php echo $i?>tab4">
                            <div class="table-responsive">
                                <table border="0px" align="center"" class="table">
                                <tr>
                                    <td>Type of Enquiry</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "Type Of Enquiry")?></td>
                                </tr>
                                <tr>
                                    <td>Enquiry Source</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "Enquiry Source")?></td>
                                </tr>
                                <tr>
                                    <td>Enquiry Status</td>
                                    <td colspan="3" style="font-weight: bold;"><?php
                                        if(odbc_result($Student, "Enquiry Status")==0) echo "Hot";
                                        if(odbc_result($Student, "Enquiry Status")==1) echo "Cold";
                                        if(odbc_result($Student, "Enquiry Status")==2) echo "Warm";
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Distance (in KM)</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "Distance")?></td>
                                </tr>
                                <tr>
                                    <td>Enquiry Remarks</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "Remarks")?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="myModal<?php echo $i?>tab5">
                            <div class="table-responsive">
                                <table border="0px" align="center"" class="table">
                                <tr>
                                    <td>Follow-up Date</td>
                                    <td colspan="3" style="font-weight: bold;"><?php  echo date("d/M/Y", strtotime(str_replace("-", "/", odbc_result($Student, "Next FollowUp Date")))) ?></td>
                                </tr>
                                <tr>
                                    <td>Follow-up 1</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "FollowUP1")?></td>
                                </tr>
                                <tr>
                                    <td>Follow-up 2</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "FollowUP2")?></td>
                                </tr>
                                <tr>
                                    <td>Follow-up 3</td>
                                    <td colspan="3" style="font-weight: bold;"><?php echo odbc_result($Student, "FollowUP3")?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="myModal<?php echo $i?>tab7">
                            <div class="table-responsive">
                                <table border="0px" align="center"" class="table">
                                <tr>
                                    <td>Academic Year</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Academic Year") ?></td>
                                    <td>Curriculum</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Curriculum") ?></td>
                                </tr>
                                <tr>
                                    <td>Class</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Class") ?></td>
                                    <td>Section</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Section") ?></td>
                                </tr>
                                <tr>
                                    <td>Medium of Instruction</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Medium of Instruction") ?></td>
                                    <td></td>
                                    <td style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <td>Language 2</td>
                                    <td style="font-weight: bold;"><?php
                                        if(odbc_result($Student, "Langauge 1")==0) echo "";
                                        if(odbc_result($Student, "Langauge 1")==1) echo "Hindi";
                                        if(odbc_result($Student, "Langauge 1")==2) echo "Tamil";
                                        if(odbc_result($Student, "Langauge 1")==3) echo "Sanskrit";
                                        if(odbc_result($Student, "Langauge 1")==4) echo "Kannada";
                                        if(odbc_result($Student, "Langauge 1")==5) echo "French";
                                        ?></td>
                                    <td>Language 3</td>
                                    <td style="font-weight: bold;"><?php
                                        if(odbc_result($Student, "Language 2")==0) echo "";
                                        if(odbc_result($Student, "Language 2")==1) echo "Hindi";
                                        if(odbc_result($Student, "Language 2")==2) echo "Tamil";
                                        if(odbc_result($Student, "Language 2")==3) echo "Sanskrit";
                                        if(odbc_result($Student, "Language 2")==4) echo "Kannada";
                                        if(odbc_result($Student, "Language 2")==5) echo "French";
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>Previous Class</td>
                                    <td style="font-weight: bold;">
                                        <?php  echo odbc_result($Student, "Previous Class"); ?>
                                    </td>
                                    <td>Previous Curriculum</td>
                                    <td style="font-weight: bold;">
                                        <?php  echo odbc_result($Student, "Previous Curriculum"); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Latest Rank</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Latest Rank"); ?></td>
                                    <td>Latest GPA</td>
                                    <td style="font-weight: bold;"><?php  echo number_format((float)odbc_result($Student, "Latest GPA"),2,'.',''); ?></td>
                                </tr>
                                <tr>
                                    <td>Latest Grade</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Latest Grade"); ?></td>
                                    <td>CGPA</td>
                                    <td style="font-weight: bold;"><?php  echo odbc_result($Student, "CGPA Grade"); ?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="myModal<?php echo $i?>tab8">
                            <div class="table-responsive">
                                <table border="0px" align="center"" class="table">
                                    <tr>
                                        <td colspan="4"><h4>Hostel Details</h4></td>
                                    </tr>
                                    <tr>
                                        <td>Hostel Accomodation</td>
                                        <td style="font-weight: bold;"><?php  if(odbc_result($Student, "Hostel Alloted")==0) {echo '&#x2717';} else {echo '&#x2713';} ?></td>
                                        <td>Hostel Code</td>
                                        <td style="font-weight: bold;"><?php echo odbc_result($Student, "Hostel Code"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Room No.</td>
                                        <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Room No_") ?></td>
                                        <td>Room Type</td>
                                        <td style="font-weight: bold;"><?php echo odbc_result($Student, "Room Type"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mess</td>
                                        <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Mess") ?></td>
                                        <td>House</td>
                                        <td style="font-weight: bold;"><?php echo odbc_result($Student, "House"); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><h4>Transport Details</h4></td>
                                    </tr>
                                    <tr>
                                        <td>Transport Required</td>
                                        <td style="font-weight: bold;"><?php  if(odbc_result($Student, "Transport Required")==1) echo "&#x2713"; ?></td>
                                        <td>Distance (in KM)</td>
                                        <td style="font-weight: bold;"><?php  echo number_format((float)odbc_result($Student, "Distance Covered in KM"),2,'.',''); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Route No</td>
                                        <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Route No_"); ?></td>
                                        <td>Route Details</td>
                                        <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Route Details"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transport Slab</td>
                                        <td style="font-weight: bold;"><?php  echo odbc_result($Student, "Transport Clab Code New"); ?></td>
                                        <td>Transport Fee</td>
                                        <td style="font-weight: bold;"><?php  echo "&#x20b9 ".number_format((float)odbc_result($Student, "Transport Fee"),2,'.',''); ?></td>
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