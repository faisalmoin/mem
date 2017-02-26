<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="table table-responsive">
                <tr>
                    <td>Date Joined</td>
                    <td><input type="text" value="<?php echo date('d/M/Y', strtotime(odbc_result($row, "Date Joined")))?>" class="form-control" readonly="true"></td>
                    <td>Fee Classification</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Fee Classification")?>" class="form-control" readonly="true"></td>
                    <td>Discount Code</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Discount Code")?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>Height</td>
                    <td><input type="text" value="<?php echo number_format(odbc_result($row, "Height"),'2','.','')?>" class="form-control" readonly="true"></td>
                    <td>Student Status</td>
                    <td><input type="text" value="<?php if(odbc_result($row, "Student Status")==1) echo "Student"; if(odbc_result($row, "Student Status")==2) echo "In-active"; if(odbc_result($row, "Student Status")==3) echo "Alumni"; ?>" class="form-control" readonly="true"></td>
                    <td>Discount Classification</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Discount Classification")?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td><input type="text" value="<?php echo number_format(odbc_result($row, "Weight"),'2','.','')?>" class="form-control" readonly="true"></td>
                    <td>Block</td>
                    <td><input type="checkbox" <?php if(odbc_result($row, "Block")==1) echo " checked"?> disabled="true"></td>
                    <td>Discount Code 1</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Discount Code 1")?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>Quota</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Quota")?>" class="form-control" readonly="true"></td>
                    <td>Admission For Year</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Admission For Year") ?>" class="form-control" readonly="true"></td>
                    <td>Discount Classification 1</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Discount Classification1")?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>Staff Child</td>
                    <td><input type="checkbox" value="<?php if(odbc_result($row, "Staff Child")==1) echo " checked"?>" disabled="true"></td>
                    <td>Physically Challenged</td>
                    <td colspan="3"><input type="checkbox" disabled="true" <?php if(odbc_result($row, "Physically Challenged")==1) echo " checked"; ?>></td>
                </tr>
                <tr>
                    <td>Staff Code</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Staff Code")?>" class="form-control" readonly="true"></td>
                    <td></td>
                    <td colspan="2" align="center" style="border-left: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;"><b>TC Details</b></td>                    
                </tr>
                <tr>
                    <td>Application No</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Application No_")?>" class="form-control" readonly="true"></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 1px solid #d3d3d3;">TC Number</td>
                    <td style="border-right: 1px solid #d3d3d3;"><input type="text" value="<?php echo odbc_result($row, "Staff Code")?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>Registration No</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Registration No_")?>" class="form-control" readonly="true"></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 1px solid #d3d3d3;">TC Date</td>
                    <td style="border-right: 1px solid #d3d3d3;"><input type="text" value="<?php if(odbc_result($row, "TC Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TC Date")))?>" class="form-control" readonly="true"></td>
                </tr>
                <tr>
                    <td>User ID</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "User ID")?>" class="form-control" readonly="true"></td>
                    <td style="border-top: 0px solid #d3d3d3;"></td>
                    <td style="border-left: 0px solid #d3d3d3;">Withdrawal Applied Date</td>
                    <td style="border-right: 0px solid #d3d3d3;"><input type="text" value="<?php if(odbc_result($row, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TC Date")))?>" class="form-control" readonly="true"></td>
                    
                </tr>
                <tr>
                    <td>Approver ID</td>
                    <td><input type="text" value="<?php echo odbc_result($row, "Approver ID")?>" class="form-control" readonly="true"></td>
                </tr>            
                <tr>
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
                            <option value="2" <?php if(odbc_result($row, "Student Status 1")== "2") echo " selected";?>>In-active</option>
                        </select>
                    </td>
                    <td><input type="text" value="<?php if(odbc_result($row, "Student Status")==1) echo "Student"; if(odbc_result($row, "Student Status")==2) echo "In-active"; if(odbc_result($row, "Student Status")==3) echo "Alumni"; ?>" class="form-control" readonly="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "Student Status 1")!= "0") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Class Code</td>
                    <td>
                        <select name="ClassCodeNew" class="form-control">
                            <option value=""></option>
                            <?php
                                $clcdNew = odbc_exec($conn, "SELECT [Class Code] FROM [Class Section] WHERE [Academic Year]='".odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($clcdNew)){
                                    echo "<option value='".odbc_result($clcdNew, "Class Code")."'";
                                    if(odbc_result($row, "Class code 1") == odbc_result($clcdNew, "Class Code")) echo " selected";
                                    echo ">".odbc_result($clcdNew, "Class Code")."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" value="<?php echo(odbc_result($row, "Class Code")); ?>" class="form-control" readonly="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "Class code 1")!= "") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>EWS</td>
                    <td><input type="checkbox" value="1" name="EWSNew" <?php if(odbc_result($row, "EWS 1")==1) echo " checked"; ?> ></td>
                    <td><input type="checkbox" value="<?php if(odbc_result($row, "EWS")==1) echo " checked"; ?>" disabled="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "EWS 1") !="0") echo "Approval pending";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount Code</td>
                    <td>
                        <select name="DiscCdNew" class="form-control" <?php if(odbc_result($row, 'Bool1')==1) echo " checked"?>>
                            <option value=""></option>
                            <?php 
                                $discCd1 = odbc_exec($conn, "SELECT [No_], [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Academic Year]='".odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($discCd1)){
                                    echo "<option value='".odbc_result($discCd1, "No_")."'";
                                    if(odbc_result($discCd1, "No_")==odbc_result($row, "Discount Code New")) echo " selected";
                                    echo ">".odbc_result($discCd1, "No_")." ( ".odbc_result($discCd1, "Fee Clasification Code").")</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" value="<?php echo(odbc_result($row, "Discount Code")); ?>" class="form-control" readonly="true" ></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscCd1" <?php if(odbc_result($row, 'Bool2')==1) echo " checked"?>></td>
                    <td><?php if(odbc_result($row, "Discount Code New")!= "" || odbc_result($row, 'Bool2')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount Code 1</td>
                    <td>
                        <select name="DiscCdNew1" class="form-control" <?php if(odbc_result($row, 'Bool3')==1) echo " disabled"?>>
                            <option value=""></option>
                            <?php 
                                $discCd2 = odbc_exec($conn, "SELECT [No_], [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Academic Year]='".odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($discCd2)){
                                    echo "<option value='".odbc_result($discCd2, "No_")."'";
                                    if(odbc_result($discCd2, "No_")==odbc_result($row, "Discount Code1 New")) echo " selected";
                                    echo ">".odbc_result($discCd2, "No_")." ( ".odbc_result($discCd2, "Fee Clasification Code").")</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" value="<?php echo(odbc_result($row, "Discount Code 1")); ?>" class="form-control" readonly="true" ></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscCd2" <?php if(odbc_result($row, 'Bool3')==1) echo " checked"?> ></td>
                    <td><?php if(odbc_result($row, "Discount Code1 New")!= "" || odbc_result($row, 'Bool3')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Transport Slab</td>
                    <td>
                        <select name="TransportSlab" class="form-control" id="TransportSlab" <?php if(odbc_result($row, 'Bool1')==1) echo " disabled";?>>
                            <option value=""></option>
                            <?php 
                                $tpslab = odbc_exec($conn, "SELECT [Slab Code] FROM [Transport Slab] WHERE [Company Name]='$ms'") or die(lodbc_errormsg($conn));
                                while(odbc_fetch_array($tpslab)){
                                    echo "<option value='".odbc_result($tpslab, "Slab Code")."'";
                                    if(odbc_result($tpslab, "Slab Code") == odbc_result($row, "Transport Slab Code New")) echo " selected";
                                    echo ">".odbc_result($tpslab, "Slab Code")."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <script type='text/javascript'>//<![CDATA[
                    $(window).on('load', function() {
                    $('#RmvDiscTrans').change( function() {
                        $(this).parents("tr:eq(0)").find("#TransportSlab").prop("disabled", this.checked); 
                    });
                    });//]]>
                    </script>
                    <td><input type="text" value="<?php echo(odbc_result($row, "Slab Code")); ?>" class="form-control" readonly="true"></td>
                    <td align="center"><input type="checkbox" value="1" name="RmvDiscTrans" id="RmvDiscTrans" onclick="myFunction(this)" <?php if(odbc_result($row, 'Bool1')==1) echo " checked" ?>></td>
                    <td><?php if(odbc_result($row, "Transport Slab Code New")!= "" || odbc_result($row, 'Bool1')==1) echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TPT Availing Date</td>
                    <td>
                        <input type="text" class="form-control" name="TPTAvailingDate" id="datepicker1" value="<?php if(odbc_result($row, "TPT Availing Date-T")!="1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($row, "TPT Availing Date-T")))?>"  onclick="this.value=''">
                    </td>
                    <td><input type="text" value="<?php if(odbc_result($row, "TPT Availing Date")!="1753-01-01 00:00:00.000") echo(date('d/M/Y', strtotime(odbc_result($row, "TPT Availing Date")))); ?>" class="form-control" readonly="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "TPT Availing Date-T")!="1753-01-01 00:00:00.000") echo "Pending Approval";?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TPT Withdrawal Date</td>
                    <td>
                        <input type="text" class="form-control" name="TPTWithdrawalDate" id="datepicker2" 
                               value="<?php if(odbc_result($row, 'TPT Withdrawal Date-T') != '1753-01-01 00:00:00.000' ) echo date('d/M/Y', strtotime(odbc_result($row, "TPT Withdrawal Date-T")))?>" onclick="this.value=''"
                               >
                    </td>
                    <td><input type="text" value="<?php if(odbc_result($row, "TPT Withdrawal Date-T") != "1753-01-01 00:00:00.000") echo(date('d/M/Y', strtotime(odbc_result($row, "TPT Withdrawal Date")))); ?>" class="form-control" readonly="true"></td>
                    <td></td>
                    <td><?php if(odbc_result($row, "TPT Withdrawal Date-T") != "1753-01-01 00:00:00.000") echo "Pending Approval";?></td>
                </tr>
            </table>
