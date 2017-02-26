<?php
	$id=$_REQUEST['id'];

	$Modal=odbc_exec($conn, "SELECT * FROM [".$ms."Application] WHERE [Enquiry No_]='".$id."'");
	odbc_fetch_array($Modal);
?>
<script>
	function popitup(url) {
		newwindow=window.open(url,'name','height=430,width=700');
		if (window.focus) {newwindow.focus()}
		return false;
	}
</script>

<!-- Modal HTML -->
<div id="myModal<?php echo $i?>" class="modal fade">
<div class="modal-dialog" style="width:900px;">
    <div class="modal-content">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Enquiry Details for <?php echo odbc_result($result, "Enquiry No_")?></h4>
	</div>
		<div class="modal-body">								
			<div class="tabbable"> <!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#myModal<?php echo $i?>tab1" data-toggle="tab">General</a></li>
					<li><a href="#myModal<?php echo $i?>tab2" data-toggle="tab">Communication</a></li>
					<li><a href="#myModal<?php echo $i?>tab3" data-toggle="tab">Parent Information</a></li>
					<li><a href="#myModal<?php echo $i?>tab4" data-toggle="tab">Registration Details</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="myModal<?php echo $i?>tab1">
						<div class="table-responsive">
							<table border="0px" align="center"" class="table">
								<tr>
									<td colspan="6"><h4>Basic Information</h4></td>
								</tr>
									<td height="50px">Enquiry No</td>
									<td height="50px" colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Enquiry No_");?></font></td>
								</tr>
								<tr>
									<td height="50px">Enquiry Date</td>
									<td height="50px"><font color="#8800ff"><?=$ModEnq[5]?></font></td>
									<td height="50px">Addmission for Year</td>
									<td height="50px"><font color="#8800ff"><?php echo odbc_result($result, "Academic Year");?></font></td>
								</tr>
								<tr>
									<td height="50px">Student Name</td>
									<td height="50px" colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Name");?></font></td>
								</tr>		
								<tr>
									<td height="50px">Gender</td>
									<td height="50px"><font color="#8800ff"><?php if(odbc_result($result, "Gender") == 1) echo "Boy";
                                            if(odbc_result($result, "Gender") == 2) echo "Girl";?></font></td>
									<td height="50px">Date of Birth</td>
									<td height="50px"><font color="#8800ff"><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Birth")));?></font></td>
								</tr>
								<tr>
									<td height="50px">Class Applied</td>
									<td height="50px"><font color="#8800ff"><?php echo odbc_result($result, "Class");?></font></td>
									<td height="50px">Curricullum Interested</td>
									<td height="50px"><font color="#8800ff"><?php echo odbc_result($result, "Curriculum Intrested");?></font></td>
								</tr>
								<tr>
									<td>Mother's Name</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother_s Name");?></font></td>
									<td>Father's Name</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father_s Name");?></font></td>
								</tr>
								<tr>
									<td>Gurdian Name</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Guardian Name");?></font></td>
								</tr>
								<tr>
									<td>Transport Required</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Transport Required");?></font></td>
								</tr>
								<tr>
									<td>Physically Challenged</td>
									<td colspan="5"><font color="#8800ff"><?
										if(odbc_result($result, "Physically Challenged")==1) echo "&#x2713;";
										else echo "&#x2717;";
										?></font>
									</td>
								</tr>
								<tr>
									<td>Concession Category</td>
									<td colspan="5"><font color="#8800ff"><?php
                                            if(odbc_result($result, "Category")== 0) echo "GENERAL";
                                            if(odbc_result($result, "Category")== 1) echo "DEFENCE";
                                            if(odbc_result($result, "Category")== 2) echo "STAFF";
                                            if(odbc_result($result, "Category")== 3) echo "SIBLING";
                                            if(odbc_result($result, "Category")== 4) echo "OTHER";
                                            if(odbc_result($result, "Category")== 5) echo "RTE/EWS";
                                    ?></font></td>
								</tr>
								<tr>
									<td>Language 2</td>
									<td colspan="5"><font color="#8800ff"><?php
                                            if(odbc_result($result, "Langauge 1")==1) echo "Hindi";
                                            if(odbc_result($result, "Langauge 1")==2) echo "Tamil";
                                            if(odbc_result($result, "Langauge 1")==3) echo "Sanskrit";
                                            if(odbc_result($result, "Langauge 1")==4) echo "Kannada";
                                            if(odbc_result($result, "Langauge 1")==5) echo "French";
                                        ?></font></td>
								</tr>
								<tr>
									<td>Language 3</td>
									<td colspan="5"><font color="#8800ff"><?php
                                            if(odbc_result($result, "Language")==1) echo "Hindi";
                                            if(odbc_result($result, "Language")==2) echo "Tamil";
                                            if(odbc_result($result, "Language")==3) echo "Sanskrit";
                                            if(odbc_result($result, "Language")==4) echo "Kannada";
                                        ?></font></td>
								</tr>
								<tr>
									<td colspan="6"><h4>Details of the Institution last attended</h4></td>
								</tr>
								<tr>
									<td>Name of the Previous School</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Previous School");?></font></td>
								</tr>
								<tr>
									<td>Last class attended</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Previous Class");?></font></td>
								</tr>
								<tr>
									<td>Curricullum Followed</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Previous Curriculum");?></font></td>
								</tr>
								<tr>
									<td>Medium of Instruction</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Medium of Instruction");?></font></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="myModal<?php echo $i?>tab2">
						<div class="table-responsive">
							<table border="0px" align="center"" class="table">
								<tr>
									<td>Address to</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Address To");?></font></td>
								</tr>
								<tr>
									<td>Addressee</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Addressee");?></font></td>
								</tr>
								<tr>
									<td>Address 1</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Address1");?></font></td>
								</tr>
								<tr>
									<td>Address2</td>
									<td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "Address2");?></font></td>
								</tr>
								<tr>
									<td>City</td><td><font color="#8800ff"><?php echo odbc_result($result, "City");?></font></td>
									<td colspan="2">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<font color="#8800ff"><?php echo odbc_result($result, "State");?></font></td>
								</tr>
								<tr>
									<td>Country</td><td><font color="#8800ff"><?php echo odbc_result($result, "Country");?></font></td>
									<td colspan="2">Post Code &nbsp;&nbsp;&nbsp;<font color="#8800ff"><?php echo odbc_result($result, "Post Code");?></font></td>
								</tr>
								<tr>
									<td>Phone No. (Landline)</td><td><font color="#8800ff"><?php echo odbc_result($result, "Phone Number");?></font></td>
									<td colspan="2">Mobile No. &nbsp;&nbsp;&nbsp;<font color="#8800ff"><?php echo odbc_result($result, "Mobile Number");?></font></td>
								</tr>
								<tr>
									<td>Email</td><td colspan="5"><font color="#8800ff"><?php echo odbc_result($result, "E-Mail Address");?></font></td>
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
                                <td>Father's Name</td>
                                <td colspan="5"><?php echo odbc_result($result, "Father_s Name");?></td>
                            </tr>
								<tr>
									<td>Qualification</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father_s Qualification");?></font></td>
									<td>Office Address 1</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father Office Address 1");?></font></td>
								</tr>
								<tr>
									<td>Occupation</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father_s Occupation");?></font></td>
									<td>Office Address 2</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father Office Address 2");?></font></td>
								</tr>
								<tr>
									<td>Annual Income</td>
									<td><font color="#8800ff"><?php echo number_format((Float)odbc_result($result, "Father_s Annual Income"),'2','.','');?></font></td>
									<td>Office Post Code</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father Office Post Code");?></font></td>
								</tr>
								<tr>
									<td>Office City</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father Office City");?></font></td>
									<td>Office Country</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Father Office Country Code");?></font></td>
								</tr>
								<tr>
									<td colspan="6"><h4>Mother's Detail</h4></td>
								</tr>
                                <tr>
                                    <td>Mother's Name</td>
                                    <td colspan="5"><?php echo odbc_result($result, "Mother_s Name");?></td>
                                </tr>
								<tr>
									<td>Qualification</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother_s Qualification");?></font></td>
									<td>Office Address 1</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother Office Address 1");?></font></td>
								</tr>
								<tr>
									<td>Occupation</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother_s Occupation");?></font></td>
									<td>Office Address 2</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother Office Address 2");?></font></td>
								</tr>
								<tr>
									<td>Annual Income</td>
									<td><font color="#8800ff"><?php echo number_format((float)odbc_result($result, "Mother_s Annual Income"),'2','.','');?></font></td>
									<td>Office Post Code</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother Office Post Code");?></font></td>
								</tr>
								<tr>
									<td>Office City</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother Office City");?></font></td>
									<td>Office Country</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mother Office Country Code");?></font></td>
								</tr>
								<tr>
									<td colspan="6"><h4>Guardian's Detail</h4></td>
								</tr>
								<tr>
									<td colspan="2">If Guardian then please specify the relationship</td>
									<td colspan="2"><font color="#8800ff"><?php echo odbc_result($result, "Applicant Relationship");?></font></td>
								</tr>
                                <tr>
                                    <td>Guardian Name</td>
                                    <td colspan="5"><?php echo odbc_result($result, "Guardian Name");?></td>
                                </tr>
								<tr>
									<td>Qualification</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Qualification");?></font></td>
									<td>Office Address 1</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Office Address 1");?></font></td>
								</tr>
								<tr>
									<td>Occupation</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Occupation");?></font></td>
									<td>Office Address 2</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Office Address 2");?></font></td>
								</tr>
								<tr>
									<td>Annual Income</td>
									<td><font color="#8800ff"><?php echo number_format((float)odbc_result($result, "Guardian Annual Income"),'2','.','');?></font></td>
									<td>Office Post Code</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Office Post Code");?></font></td>
								</tr>
								<tr>
									<td>Office City</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Office City");?></font></td>
									<td>Office Country</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Guardian Office Country Code");?></font></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="myModal<?php echo $i?>tab4">
						<div class="table-responsive">
							<table border="0px" align="center"" class="table">
								<tr>
									<td>Registration Form No</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Registration No_");?></font></td>
									<td>Application Status</td>
									<td><font color="#8800ff"><?php
                                            if(odbc_result($result, "Registration Status")==1) echo "SOLD";
                                            if(odbc_result($result, "Registration Status")==2) echo "RECEIVED";
                                            if(odbc_result($result, "Registration Status")==3) echo "SELECTED";
                                            if(odbc_result($result, "Registration Status")==4) echo "PENDING APPROVAL";
                                            if(odbc_result($result, "Registration Status")==5) echo "APPROVED";
                                            if(odbc_result($result, "Registration Status")==6) echo "ADMITTED";
                                        ?></font></td>
								</tr>
								<tr>
									<td>Payment Mode</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Mode of Payment");?></font></td>
									<td>Sale Date</td>
									<td><font color="#8800ff"><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Sale")));?></font></td>
								</tr>
								<tr>
									<td>Cheque / DD No</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "Cheque _ DD No_");?></font></td>
									<td>Registration Cost</td>
									<td><font color="#8800ff">&#x20b9; <?php echo number_format((float)odbc_result($result, "Registration Cost"),'2','.','');?></font></td>
								</tr>
								<tr>
									<td>Cheque / DD Date</td>
									<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Cheque _ DD Date")));?></font></td>
									<td>Registration No</td>
									<td><font color="#8800ff"><?php echo odbc_result($result, "No_");?></font></td>
								</tr>
								<tr>
									<td>EWS</td>
									<td>
										<font color="#8800ff"><?php if(odbc_result($result, "EWS")==1) echo "&#x2713;"; else echo "&#x2717;"; ?></font>
									</td>
									<td>Form Recieved Date</td>
									<td><font color="#8800ff"><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Receive")));?></font></td>
								</tr>
								<tr>
									<td>Remarks</td>
									<td colspan="3"><font color="#8800ff"><?php echo odbc_result($result, "Remarks");?></font></td>
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