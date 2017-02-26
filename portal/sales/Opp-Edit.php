<?php
	require_once("header.php");
	$sql = odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [ID]='".$_REQUEST['id']."'") or die(odbc_errormsg($conn));

?>

<script type="text/javascript" src="../bs/js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../bs/css/jquery.timepicker.css" />

<script>
	$(window).load(function(){
		$("input#LeadDT").datepicker({
			//minDate: <?php echo date('d/m/Y', odbc_result($sql, "Opp Date")); ?>,
			//maxDate: 0
		});
	});	
</script>
<div class="container">
	<table class="table table-responsive table-bordered">
		<tr>
			<td style="background-color: #f2f2f2;">
				<h3 class="text-primary">Oppurtunity ID: <strong><?php echo odbc_result($sql, "Opp No"); ?><strong></h3>
				<table class="table table-responsive" style="background-color: #f2f2f2;">
					<tr>
						<td style="border:none;">Date</td>
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo date('d/M/Y', odbc_result($sql, "Opp Date")); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Name</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Name"); ?></span></td>
					</tr>
					<!-- tr>
						<td style="border:none;">Job Title</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Job Title"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Company Name</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Company Name"); ?></span></td>
					</tr -->
					<tr>
						<td style="border:none;">Address</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 1"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 2"); ?></span> 
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "City"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "State"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Country"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Post Code"); ?></span></td>
					</tr>
					<!--tr>
						<td style="border:none;">Office Phone</td>			
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Office Phone"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Office Fax</td>			
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Office Fax"); ?></span></td>			
					</tr-->
					<tr>
						<td style="border:none;">Mobile</td>			
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Mobile"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Email</td>
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Email"); ?></span></td>
					</tr>
					<!--tr>
						<td style="border:none;">Website</td>
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Website"); ?></span></td>
					</tr-->
					<tr>
						<td style="border:none;">Lead Source</td>			
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Source"); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Status</td>
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Status"); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Brand:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Likely Brand"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Own Land:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "land"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Investment Potential:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "investment"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Created By:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "User ID"); ?></span></td>
					</tr>
				</table>
                                            <p style="text-align: right">
                                                <a href="Lead-Edit.php?id=<?php echo odbc_result($sql, "Lead No"); ?>" style="font-size: 10px;" data-toggle="modal">Edit</a> <br />
                                            </p>
			</td>
			<script>
				
				$(document).ready(function () {
					$("#Stage").change(function () {
						var val = $(this).val();
						if (val == "Discussions") {
							$("#Level").html('<option value="Introductory meeting - understanding each other\'s entities">Introductory meeting - understanding each other\'s entities</option><option value="Financial negotiations ">Financial negotiations </option><option value="Legal /CA experts advise sought">Legal /CA experts advise sought</option><option value="Franchisee stuck on certain clauses">Franchisee stuck on certain clauses</option><option value="Wants financial changes ">Wants financial changes </option><option value=" Waiting for family go ahead"> Waiting for family go ahead</option><option value="Looking for other brands and will revert">Looking for other brands and will revert</option><option value="Wants brand but seeking time to sign LOI">Wants brand but seeking time to sign LOI</option>');
						} else if (val == "Letter of Intent (LOI)") {
							$("#Level").html('<option value="LOI sent for signing">LOI sent for signing</option><option value="Wants changes in LOI">Wants changes in LOI</option><option value="Has signed LOI">Has signed LOI</option>');
						} else if (val == "Agreement") {
							$("#Level").html('<option value="Mailed /given Agreement for reading">Mailed /given Agreement for reading</option><option value="Negotiations are on for change in clauses ">Negotiations are on for change in clauses </option><option value="Franchisee\'s lawyer has reverted with changes">Franchisee\'s lawyer has reverted with changes</option><option value="MEM Legal team has to revert with changes">MEM Legal team has to revert with changes</option><option value="Agreement with final changes with Franchisee">Agreement with final changes with Franchisee</option><option value="Agreement signed">Agreement signed </option>');
						}
					});
				
					
					$('#Status').change(function () {
						var val = $(this).val();
						
						if (val == "Qualified") {
							$('#Stage').prop('disabled', false);							
							$('#Level').prop('disabled', false);
							$('#Stage').prop('required', true);							
							$('#Level').prop('required', true);
							$('#ContactPerson').prop('disabled', false);	
							$('#ContactNo').prop('disabled', false);	
							//$('#scrollDefaultExample1').prop('disabled', false);	
							//$('#scrollDefaultExample2').prop('disabled', false);	
							$('#LeadStat').prop('disabled', false);	
							$('#LeadDT').prop('disabled', false);	
							$('#LeadRem').prop('required', false);	
						} else if(val == "Dis-Qualified" ) {
							$('#Stage').prop('disabled', true);							
							$('#Level').prop('disabled', true);	
							$('#ContactPerson').prop('disabled', true);	
							$('#ContactNo').prop('disabled', true);	
							//$('#scrollDefaultExample1').prop('disabled', true);	
							//$('#scrollDefaultExample2').prop('disabled', true);	
							$('#LeadStat').prop('disabled', true);	
							$('#LeadDT').prop('disabled', true);	
							$('#LeadRem').prop('required', true);	
						}
					});
					
					//Download script
					$(".Download td").hide();
					$(".Upload td").hide();

					$('#Stage').change(function () {
					var rval = $(this).val();
					//For LOI
						if (rval == "Letter of Intent (LOI)") {
							$('.Download td').show();
							$('#agg_dwn').hide();
							$('#loi_dwn').show();
							$('.Upload td').hide();
						} 
						else if (rval == "Agreement") {
							$('.Download td').show();
							$('#agg_dwn').show();
							$('#loi_dwn').hide();
							$('.Upload td').hide();
						}
						else if (rval != "Letter of Intent (LOI)") {
							$('.Download td').hide();
							$('#agg_dwn').hide();
							$('#loi_dwn').hide();
							$('.Upload td').hide();
						}
					
					});
					
					$('#Level').change(function () {
						var lval = $(this).val();
						if (lval == "Has signed LOI") {
							$('.Upload td').show();
							$('.Download td').hide();
							$('#loi_upd').show();
							$('.loi_s').prop('required', true);
							$('#agg_upd').hide();
							$('.agg_s').prop('required', false);
						}
						else if (lval == "Agreement signed") {
							$('.Upload td').show();
							$('.Download td').hide();
							$('#loi_upd').hide();
							$('.loi_s').prop('required', false);
							$('#agg_upd').show();
							$('.agg_s').prop('required', true);
						}
						else if (lval != "Has signed LOI") {
							$('.Upload td').hide();
							$('.Download td').show();
							$('#loi_upd').hide();
							$('#agg_upd').show();
						}
						else if (lval != "Agreement signed") {
							$('.Upload td').hide();
							$('.Download td').show();
							$('#loi_upd').hide();
							$('#agg_upd').show();
						}
						else {
							$('.Upload td').hide();
							$('.Download td').hide();
							$('#loi_upd').hide();
							$('#loi_dwn').hide();
							$('#agg_upd').hide();
							$('#agg_dwn').hide();
						}
					
					});
					
				});
				
				function myfunction() { 
					var dt = document.getElementById("LeadDT").value;
					var e_time = document.getElementById("scrollDefaultExample2").value;
					var time = dt + " " + e_time;
					
					var first = new Date(time);
					first = first.getTime();
					
					var d = new Date();
					var second = d.getTime();
					
					if(first >= second ){
						document.getElementById("LeadStat").value = "Open";
						//document.getElementById("Outcome").disabled = true;
					}
					else if(first <= second ){
						document.getElementById("LeadStat").value = "Completed";
						//document.getElementById("Outcome").disabled = false;	
					}
				}
				
				function toggleDisability(){
					var sTime = document.getElementById("scrollDefaultExample1").value;
					var eTime = document.getElementById("scrollDefaultExample2").value;
					
					
					if(eTime <= sTime){
						document.getElementById("scrollDefaultExample2").value = "";
						alert("End Time should be greater than Start Time ...");
						document.getElementById("scrollDefaultExample2").focus();
					}
				}
								
				function getState(val) {
					$.ajax({
						type: "POST",
						url: "get_activity_outcome.php",
						data: "id=" + val + "&type=Lead",
						success: function(data){
							$("#Outcome").html(data);
						}
					});
				}
			</script>
			<td style="border: none; width: 60%" >
				<form action="Opp-Update.php" method="POST" enctype="multipart/form-data">
					<h3 class="text-primary">Activity</h3>
					<table class="table table-responsive" style="background-color: #ffffff;">
						<tr>
			<td style="border: none;">Date</td>
			<td style="border: none;">
				<div class="inner-addon right-addon">
					<i class="glyphicon glyphicon-calendar"></i>
					<input type="text" name="LeadDT" id="LeadDT" onchange=""  class="form-control" readonly required></td>
				</div>
			</td>
			<td style="border: none;">New Status</td>
							<td style="border: none;">
								<select name="Status" id="Status" required class="form-control">                                                                        
									<option value="Qualified" <?php if(odbc_result($sql, "Status") === "Qualified") echo " selected"; ?>>Qualified</option>
									<option value="Dis-Qualified" <?php if(odbc_result($sql, "Status") === "Dis-Qualified") echo " selected"; ?>>Dis-Qualified</option>
                                                                        <option value="Reopen" <?php echo (odbc_result($sql, "Status")==="Reopen")? " selected":"";?>>Reopen</option>
                                                                        <option value="Lost" <?php echo (odbc_result($sql, "Status")==="Lost")? " selected":"";?>>Lost</option>
                                                                        <option value="Open" <?php echo (odbc_result($sql, "Status")==="Open")? " selected":"";?>>Open</option>
								</select>
							</td>
		</tr>
		<tr>
			<td style="border: none;">Start Time</td>
			<td style="border: none;">
				<input type="text" name="StartTime" id="scrollDefaultExample1" class="form-control mySelect">
				<script>
					$(function() {
						$('#scrollDefaultExample1').timepicker({
							timeFormat: "H:i ",
							minTime: '07:00:00',
							maxTime: '22:00:00', 
							interval: 15,
							step: 15
						});
					});
				</script>
			</td>
			<td style="border: none;">End Time</td>
			<td style="border: none;"><input type="text" id="scrollDefaultExample2" onchange="toggleDisability(); myfunction();" name="EndTime" class="form-control mySelect" >
				<script>
					$(function() {
						$('#scrollDefaultExample2').timepicker({
							timeFormat: "H:i ",
							minTime: '07:00:00',
							maxTime: '22:00:00', 
							interval: 15,
							step: 15
						});
					});
				</script>
			</td>
		</tr>
		<tr>
			<td style="border: none;">Contact Person</td>
			<td style="border: none;"><input type="text" name="ContactPerson" id="ContactPerson" class="form-control" value="<?php echo odbc_result($sql, "Name"); ?>" required></td>
			<td style="border: none;">Contact No</td>
			<td style="border: none;"><input type="text" name="ContactNo" id="ContactNo" class="form-control" value="<?php echo odbc_result($sql, "Mobile"); ?>" required></td>
		</tr>
						<tr>
							<td style="border: none;">Stage</td>
							<td style="border: none;">
								<select name="Stage" id="Stage" class="form-control" required>
									<option value=""></option>
									<option value="Discussions">Discussions</option>
									<option value="Letter of Intent (LOI)">Letter of Intent (LOI)</option>
									<option value="Agreement">Agreement</option>									
								</select>
							</td>
							<td style="border: none;" class="Agreement">Level</td>
							<td style="border: none;">
								<select name="Level" id="Level" class="form-control">
									<option value=""></option>
									
								</select>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Activity</td>
							<td style="border: none;">
								<select name="Activity" id="Activity" class="form-control"  required>
									<option value=""></option>
									<?php
										$acti = odbc_exec($conn, "SELECT * FROM [CRM Activity Master] WHERE [Type]='Lead' ORDER BY [ID]") or die(odbc_errormsg($conn));
										while(odbc_fetch_array($acti)){
											echo "<option id='".odbc_result($acti, "ID")."' value='".odbc_result($acti, "ID")."'>".odbc_result($acti, "Text")."</option>";
										}
									?>
								</select>
							</td>
							<!--td style="border: none;">Outcome</td>
							<td style="border: none;">
								<select name="Outcome" id="Outcome" class="form-control">
									<option value=""></option>
									
								</select>
							</td-->
						</tr>
						<tr class="Download">
							<td style="border: none;"></td>
							<td style="border: none;" colspan="2">
								<a href="sample/LOI-sample.doc" class="btn btn-default" id="loi_dwn"><span class="glyphicon glyphicon-download-alt text-danger"></span> Download LOI Sample </a>
								<a href="sample/Agreement-sample.doc" class="btn btn-default" id="agg_dwn"><span class="glyphicon glyphicon-download-alt text-danger"></span> Download Agreement Sample</a>
							</td>
						</tr>
						<tr class="Upload">
							<td style="border: none;"></td>
							<td style="border: none;" colspan="2">
								
								<div id="loi_upd">
									<span class="glyphicon glyphicon-upload text-success"></span> Upload signed LOI
										<input name="LOI_signed" class="btn btn-warning loi_s"  type="file" id="" /><br />
								</div>
								<div  id="agg_upd">
									<span class="glyphicon glyphicon-upload text-success"></span> Upload signed Agreement
										<input name="MOU_signed" class="btn btn-warning agg_s" type="file" /><br />
								</div>
								
								<span class="text-danger">Max File Size 5 MB only</span>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Remarks</td>
							<td style="border: none;" colspan="3"><textarea name="LeadRem" id="LeadRem" class="form-control" style="resize: none;" maxlength="200" ></textarea></td>
						</tr>
						<tr>
							<td style="border: none;">Activity Status</td>
							<td style="border: none;">
                                                            <select name="LeadStat" id="LeadStat" class="form-control" required>
                                                                <option value="Open">Open</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                            <!--input type="text" name="LeadStat" id="LeadStat" class="form-control" readonly required-->
                                                        </td>
						</tr>
						<tr>
							<td style="border: none;" colspan="4" align="center">
							<input type="hidden" value="<?php echo odbc_result($sql, "Opp No"); ?>" name="OppID">
							<input type="hidden" value="<?php echo odbc_result($sql, "ID"); ?>" name="id">
							<input type="submit" value="Update" class="btn btn-primary"></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table class="table table-responsive" style="font-size: 12px;" >
					<tr>
						<td colspan="6" style="background-color: #ffffff">
							<h3 class="text-danger" >Oppurtunity Activities</h3>
						</td>
					</tr>
					<tr>
						<th>Date</th>
						<th>Contact Person</th>
						<th>Contact No</th>
						<th>Stage</th>
						<th>Level</th>
						<th>Remarks</th>
						<th>Activity</th>
						<!--th>Outcome</th-->
						<th>Activity Status</th>
					</tr>
					<?php
						$act = odbc_exec($conn, "SELECT [Date], [Stage], [Level], [Remarks], [Contact Person], [Contact No], [Activity Status], [Activities], [Outcome] FROM [CRM Opp Activity] WHERE 
							[Opp ID]='".odbc_result($sql, "Opp No")."' ORDER BY [Date] DESC") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($act)){
					?>
					<tr>
						<td style="font-weight: normal;"><?php echo date('d/M/Y', odbc_result($act, "Date")); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact Person"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact No"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Stage"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Level"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Remarks"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Activities"); ?></td>
						<!--td style="font-weight: normal;"><?php //echo odbc_result($act, "Outcome"); ?></td-->
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Activity Status"); ?></td>
					</tr>
					<?php
						}	
					?>
				</table>
			</td>
		</tr>
	</table>		
</div>

<?php
	require_once("../footer.php");
?>