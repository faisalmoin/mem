<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 //$Bal = odbc_exec($conn, "SELECT SUM([Amount]) FROM schoolerp.dbo.[".$ms."\$Detailed Cust_ Ledg_ Entry] WHERE [Customer No_]='$id'");	
 
 $crd_amt = odbc_exec($conn, "SELECT SUM([Credit Amount]) AS [Credit] FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND ([Customer No]='".odbc_result($row, "No_")."' OR [Customer No]='".odbc_result($row, "Registration No_")."')  " ) or die(odbc_errormsg($conn));
 $deb_amt = odbc_exec($conn, "SELECT SUM([Credit Amount]) AS [Debit] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND ([Customer No]='".odbc_result($row, "No_")."' OR [Customer No]='".odbc_result($row, "Registration No_")."')  " ) or die(odbc_errormsg($conn));
 $Bal = odbc_result($crd_amt, "Credit") - odbc_result($deb_amt, "Debit");

?>
    <table class='table table-responsive'>
        <tr>
            <td>System Admission No.</td>
            <td><input type='text' name='SysAdmNo' value='<?php echo odbc_result($row, "No_")?>' class="form-control" readonly="true"></td>
            <td>Mother Tongue</td>
            <td><input type='text' name='MotherTongue' value='<?php echo odbc_result($row, "Mother Tongue")?>' class="form-control" ></td>
            <td>EWS</td>
            <td><input type='checkbox' name='EWS' value="1" <?php 
	if(odbc_result($row, "EWS")==1)
	{
		echo " checked";
	}
	?>></td>
        </tr>
        <tr>
            <td>Student Name</td>
            <td><input type='text' name='StudentName' value='<?php echo odbc_result($row, "Name")?>' class="form-control"></td>
            <td>Caste</td>
            <td><input type='text' name='Caste' value='<?php echo odbc_result($row, "Caste")?>' class="form-control"></td>
            <td>Transport Required</td>
            <td><input type="text" name='TransportRequired' class="form-control" readonly="true" value="<?php if (odbc_result($row, "Transport Required")==1) echo "Yes"; 
                        if (odbc_result($row, "Transport Required")==2) echo "No"?>" />
            </td>
        </tr>
        <tr>
            <td>Gender</td>
           
            <td>
                <select name='Gender' class="form-control">
                <option value='1' <?php if(odbc_result($row, "Gender")==1) echo " selected"?>>Boy</option>
                <option value='2' <?php if(odbc_result($row, "Gender")==2) echo " selected"?>>Girl</option>
                    
                </select>
            </td>



            <td>Community</td>
            <td><input type='text' name='Community' value='<?php echo odbc_result($row, "Community")?>' class="form-control"></td>
            <td>Category</td>
            <td><input type='text' readonly="true" name='Category' value='<?php 
                                                                if(odbc_result($row, "Category")==0) echo "";
                                                                if(odbc_result($row, "Category")==1) echo "GENERAL";
                                                                if(odbc_result($row, "Category")==2) echo "EX-SERVICEMAN";
                                                                if(odbc_result($row, "Category")==3) echo "STAFF CHILD";
                                                                if(odbc_result($row, "Category")==4) echo "SIBLING";
                                                                if(odbc_result($row, "Category")==5) echo "OTHER DISCOUNTS";
                                                            ?>' class="form-control" ></td>
        </tr>
        <tr>
            <td>Date of Birth</td>
            <td><input type='text' name='DOB' value='<?php echo date("d/M/Y", strtotime(odbc_result($row, "Date Of Birth")));?>' class="form-control" id="datepicker1"></td>
            <td>Religion</td>
            <td><input type='text' name='Religion' value='<?php echo odbc_result($row, "Religion")?>' class="form-control" ></td>
            <td>Physically Challenged</td>
             <td><input type='checkbox' name='PhysicallyChallenged' value="1" <?php 
	if(odbc_result($row, "Physically Challanged")==1)
	{
		echo " checked";
	}
	?>></td>
            
            <!--td><input type="checkbox" name='PhysicallyChallenged' value='1' <?php if(odbc_result($row, "Physically Challanged")==1) echo " checked";?> ></td-->
        </tr>
        <tr>
            <td>Age</td>
            <td><input type='text' style="text-align: right;" readonly="true" name='Age' value='<?php echo $years;?>' class="form-control"></td>
            <td>Latest Rank</td>
            <td><input type='text' style="text-align: right;" name='LatestRank' value='<?php echo odbc_result($row, "Latest Rank")?>' class="form-control"></td>
            <td>Language 2</td>
            <td>
                <select name='Language1' class="form-control">
                    <option value='0' <?php if(odbc_result($row, "Langauge 1")==0) echo " selected"?>></option>
                    <option value='1' <?php if(odbc_result($row, "Langauge 1")==1) echo " selected"?>>Hindi</option>
                    <option value='2' <?php if(odbc_result($row, "Langauge 1")==2) echo " selected"?>>Tamil</option>
                    <option value='3' <?php if(odbc_result($row, "Langauge 1")==3) echo " selected"?>>Sanskrit</option>
                    <option value='4' <?php if(odbc_result($row, "Langauge 1")==4) echo " selected"?>>Kannada</option>
                    <option value='5' <?php if(odbc_result($row, "Langauge 1")==5) echo " selected"?>>French</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Month</td>
            <td><input type='text' style="text-align: right;" name='Month' readonly="true" value='<?php echo $months;?>' class="form-control" ></td>
            <td>Latest GPA</td>
            <td><input type='text' style="text-align: right;" name='LatestGPA' value='<?php echo number_format(odbc_result($row, "Latest GPA"),2,'.','')?>' class="form-control"></td>
            <td>Language 3</td>
            <td>
                <select name='Language2' class="form-control">
                    <option value='0' <?php if(odbc_result($row, "Langauge 2")==0) echo " selected"?>></option>
                    <option value='1' <?php if(odbc_result($row, "Langauge 2")==1) echo " selected"?>>Hindi</option>
                    <option value='2' <?php if(odbc_result($row, "Langauge 2")==2) echo " selected"?>>Tamil</option>
                    <option value='3' <?php if(odbc_result($row, "Langauge 2")==3) echo " selected"?>>Kannada</option>
                    <option value='4' <?php if(odbc_result($row, "Langauge 2")==4) echo " selected"?>>Sanskrit</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Class Code</td>
            <td><input type='text' readonly="true" name='ClassCode' value='<?php echo odbc_result($row, "Class Code");?>' class="form-control" ></td>
            <td>Latest Grade</td>
            <td><input type='text' style="text-align: right;" name='LatestGrade' value='<?php echo number_format(odbc_result($row, "Latest Grade"),2, '.','')?>' class="form-control"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Class</td>
            <td><select name="Classa" class="form-control">
                    <option value=''></option>
                    <?php
                   $Class = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Class] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($Class)){
                            echo "<option value='".odbc_result($Class, 'Code')."'";
                            if(odbc_result($Class, 'Code') == odbc_result($row, "Class")) echo " selected";
                            echo ">".odbc_result($Class, 'Code')."</option>";
                        }
                    ?>
                </select></td> 

           <td>CGPA</td>
            <td><input type='text' style="text-align: right;" name='LatestGPA' value='<?php echo number_format(odbc_result($row, "CGPA"),2, '.', '')?>' class="form-control"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Section</td>
            <td>
                <select name="Section" class="form-control">
                    <option value=''></option>
                    <?php
                        $ClassSec = odbc_exec($conn, "SELECT DISTINCT([SECTION]) FROM [Class Section] WHERE [Company Name]='$ms' AND [Class]='".odbc_result($row, "Class")."' AND [Academic Year]='".odbc_result($row, "Academic Year")."'") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($ClassSec)){
                            echo "<option value='".odbc_result($ClassSec, 'Section')."'";
                            if(odbc_result($ClassSec, 'Section') == odbc_result($row, "Section")) echo " selected";
                            echo ">".odbc_result($ClassSec, 'Section')."</option>";
                        }
                    ?>
                </select>
            </td>
            <td>Pickup</td>
            <td><input type='text' style="text-align: right;" name='Pickup' value='<?php echo number_format(odbc_result($row, "Pickup"),2,'.','')?>' class="form-control"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Curriculum</td>
            <td><select name="Curriculum" class="form-control">
                    <option value=''></option>
                    <?php
                   $Curriculum = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Curriculum] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($Curriculum)){
                            echo "<option value='".odbc_result($Curriculum, 'Code')."'";
                            if(odbc_result($Curriculum, 'Code') == odbc_result($row, "Curriculum")) echo " selected";
                            echo ">".odbc_result($Curriculum, 'Code')."</option>";
                        }
                    ?>
                </select></td>
            <td>Drop</td>
            <td><input type='text' name='Drop' value="<?php echo odbc_result($row, "Drop")?>" class="form-control"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Academic Year</td>
            <td><select name="AcadYear" class="form-control">
                    <option value=''></option>
                    <?php
                   $Academic = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Academic Year] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($Academic)){
                            echo "<option value='".odbc_result($Academic, 'Code')."'";
                            if(odbc_result($Academic, 'Code') == odbc_result($row, "Academic Year")) echo " selected";
                            echo ">".odbc_result($Academic, 'Code')."</option>";
                        }
                    ?>
                </select></td>

            <td>Distance Covered in KM</td>
            <td><input type="text" name='Distance' readonly="true" value="<?php echo number_format(odbc_result($row, "Distance Covered in KM"),2, '.', '')?>" class="form-control" style="text-align: right;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Previous Class</td>
            <td><select name="PreviousClass" class="form-control">
                    <option value=''></option>
                    <?php
                   $PreviousClass = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Class] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($PreviousClass)){
                            echo "<option value='".odbc_result($PreviousClass, 'Code')."'";
                            if(odbc_result($PreviousClass, 'Code') == odbc_result($row, "Previous Class")) echo " selected";
                            echo ">".odbc_result($PreviousClass, 'Code')."</option>";
                        }
                    ?>
                </select></td>
            <td>Transport Slab Code</td>
            <td><input type="text" name='SlabCode' readonly="true" value="<?php echo odbc_result($row, "Slab Code")?>" class="form-control" style="text-align: right;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Previous Curriculum</td>
            
             <td><select name="PreviousCurriculum" class="form-control">
                    <option value=''></option>
                    <?php
                   $PreviousCurriculum = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Curriculum] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($PreviousCurriculum)){
                            echo "<option value='".odbc_result($PreviousCurriculum, 'Code')."'";
                            if(odbc_result($PreviousCurriculum, 'Code') == odbc_result($row, "Previous Curriculum")) echo " selected";
                            echo ">".odbc_result($PreviousCurriculum, 'Code')."</option>";
                        }
                    ?>
                </select></td>
            <td>Transport Fee</td>
            <td><input type="text" name='TransportFee' readonly="true" value="<?php echo number_format(odbc_result($row, "Transport Fee"), '2','.','')?>" class="form-control" style="text-align: right;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Medium of Instruction</td>
            <td><input type='text' name='MediumofInstruction' value="<?php echo odbc_result($row, "Medium of Instruction")?>" class="form-control" ></td>
            <td>Route No</td>
            <td><input type="text" name='TransportFee' readonly="true" value="<?php echo odbc_result($row, "Route No_")?>" class="form-control" style="text-align: right;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Citizenship</td>
            <td><input type='text' name='Citizenship' value="<?php echo odbc_result($row, "Citizenship")?>" class="form-control" ></td>
            <td>Route Details</td>
            <td><input type="text" name='RouteDetails' readonly="true" value="<?php echo odbc_result($row, "Route Details")?>"  class="form-control" style="text-align: right;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Hostel Accommodation</td>
              <td><input type='checkbox' name='HostelAccommodation' value="1" <?php 
	if(odbc_result($row, "Hostel Acommodation")==1)
	{
		echo " checked";
	}
	?>></td>
            <!--td><input type='checkbox' name='HostelAccommodation' value="<?php if(odbc_result($row, "Hostel Acommodation")==1) echo " checked"?>" ></td-->
            <td>Approval Status</td>
            <td><input type="text" name='ApprovalStatus' value="<?php if(odbc_result($row, "Approval Status")==0) echo "Open"; if(odbc_result($row, "Approval Status")==1) echo "Approved"; if(odbc_result($row, "Approval Status")==2) echo "Pending Approval"; ?>" readonly="true" class="form-control" ></td>
            <td></td>
            <td></td>
        </tr>
        <!--tr>
            <td>Student Admission No</td>
            <td><input type='text' name='HostelCode' value="<?php echo odbc_result($row, "Hostel Code"); ?>" style="text-transform: uppercase;" class="form-control" ></td>
            <td>Old Admission No</td>
            <td><input type="text" name='OldAdmNo' value="<?php echo odbc_result($row, "Old Admission No_"); ?>" class="form-control" ></td>
            <td></td>
            <td></td>
        </tr-->
        <tr>
            <td>Room No</td>
            <td><input type='text' name='RoomNo' value="<?php echo odbc_result($row, "Room No_"); ?>" class="form-control" ></td>
            <td>Date Joined</td>
            <td><input type="text" name='DateJoined' readonly="true" value="<?php echo date("d/M/Y", strtotime(odbc_result($row, "Date Joined"))); ?>" class="form-control" ></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Room Type</td>
            <td><input type='text' name='RoomType' value="<?php echo odbc_result($row, "Room Type"); ?>" class="form-control" ></td>
            <td>Date of Leaving</td>
            <td><input type="text" name='DateLeave' value="<?php echo ((odbc_result($row, "Date of Leaving") != "1753-01-01 00:00:00.000")?date("d/M/Y", strtotime(odbc_result($row, "Date of Leaving"))):""); ?>" readonly="true" class="form-control" ></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Mess</td>
            <td><input type='text' name='Message' value="<?php echo odbc_result($row, "Mess"); ?>" class="form-control" ></td>
            <td>Balance LCY</td>
            <td><input type="text" readonly="true" name='BalanceLCY' style="text-align: right;" value="<?php echo number_format($Bal,'2','.',''); ?>" class="form-control" ></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>House</td>
            <td><input type='text' name='House' value="<?php echo odbc_result($row, "House"); ?>" style="text-transform: uppercase;" class="form-control" ></td>
            <!--td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Points</td>
            <td><input type='text' name='Mess' value="<?php echo number_format(odbc_result($row, "Mess"),2,'.',''); ?>" class="form-control" ></td-->
            <td>Stream</td>
            <td>
                <script>
                     function changetextbox()
                        {
                            if (document.getElementById("class").value == "XI" || document.getElementById("class").value == "XII") {
                                document.getElementById("Stream").disabled=false;
                            } 
                            else {
                                document.getElementById("Stream").disabled=true;
                            }
                        }
                </script>
                <select name="Stream" class="form-control unknown" id="Stream" disabled="true">
                    <option value="0" <?php if(odbc_result($row, 'Stream') == 0) echo " selected" ?>></option>
                    <option value="1" <?php if(odbc_result($row, 'Stream') == 1) echo " selected" ?>>Science</option>
                    <option value="2" <?php if(odbc_result($row, 'Stream') == 2) echo " selected" ?>>Science Non-Medical</option>
                    <option value="3" <?php if(odbc_result($row, 'Stream') == 3) echo " selected" ?>>Science Medical</option>
                    <option value="4" <?php if(odbc_result($row, 'Stream') == 4) echo " selected" ?>>Commerce</option>
                    <option value="5" <?php if(odbc_result($row, 'Stream') == 5) echo " selected" ?>>Arts</option>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
