<?php
	require_once("header.php");
	$id=$_REQUEST['id'];
	$sql =odbc_exec($conn, "SELECT * FROM [CRM Lead] WHERE [ID]='$id'") or die(odbc_errormsg($conn));
?>

<script type="text/javascript" src="../bs/js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../bs/css/jquery.timepicker.css" />

<script>
	$(window).load(function(){
		$("input#LeadDT").datepicker({});
	});	
</script>
<div class="container">
	<table class="table table-responsive table-bordered">
		<tr>
			<td style="background-color: #f2f2f2;">
				<h3 class="text-primary">Lead ID: <strong><?php echo odbc_result($sql, "Lead No"); ?><strong></h3>
				<table class="table table-responsive" style="background-color: #f2f2f2;">
					<tr>
						<td style="border:none;">Date</td>
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo date('d/M/Y', odbc_result($sql, "Lead Date")); ?></span>
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
						<td style="border:none;">Created By:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "User ID"); ?></span></td>
					</tr>
					<tr>
						<!--td style="border:none;">Assigned To:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Assign To"); ?></span></td-->
						<td  style="border:none;" colspan="2">
							<div align="right">
							<a href="Lead-Edit.php?id=<?php echo odbc_result($sql, "ID"); ?>" style="font-weight: normal;">Edit</a>						
							<a href="#myModal" data-toggle="modal" style="font-weight: normal;">View</a>
							</div>
							<!-- Modal -->
							<div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog"   style="width: 100%;height: 100%;margin: 0;padding: 0;">

									<!-- Modal content-->
									<div class="modal-content" style=" height: auto;min-height: 100%;border-radius: 0;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h3 class="modal-title text-danger" style="font-weight: bold;">Lead Details</h3>
										</div>
										<div class="modal-body">
											<h4 class="text-primary">Lead ID: <strong><?php echo odbc_result($sql, "Lead No"); ?><strong></h4>
											<table class="table table-responsive" >
												<tr>
													<td style="border:none;">Date</td>
													<td style="border:none;">
														<span class="text-primary" style="font-weight: bold;"><?php echo date('d/M/Y', odbc_result($sql, "Lead Date")); ?></span>
													</td>
													<td style="border:none;">Status</td>
													<td style="border:none;">
														<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Status"); ?></span>
													</td>
													<td colspan="2" rowspan="5" style="background-color: #d3d3d3;">
														Likely Brand:
														<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Likely Brand"); ?></span>
														<br />
														Created By:
														<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "User ID"); ?></span>
														<br />
														Assigned To:
														<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Assign To"); ?></span>
													</td>
												</tr>

												<tr>
													<td style="border:none;">Name</td>			
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Name"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Job Title</td>			
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Job Title"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Company Name</td>			
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Company Name"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Address</td>			
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 1"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;"></td>			
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 2"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">City / District</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "City"); ?></span></td>
													<td style="border:none;">State</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "State"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Country</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Country"); ?></span></td>
													<td style="border:none;">PIN</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Post Code"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Office Phone</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Office Phone"); ?></span></td>
													<td style="border:none;">Office Fax</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Office Fax"); ?></span></td>			
												</tr>
												<tr>
													<td style="border:none;">Mobile</td>			
													<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Mobile"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Email</td>
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Email"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Website</td>
													<td colspan="3" style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Website"); ?></span></td>
												</tr>
												<tr>
													<td style="border:none;">Lead Source</td>			
													<td colspan="3" style="border:none;">
														<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Source"); ?></span>
													</td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px !important;">Close</button>
										</div>
									</div>

								</div>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<script>
				function myfunction() { 
					var first = new Date(document.getElementById("LeadDT").value);
					first = first.getTime();
					//alert(first);
					var d = new Date();
					var second = d.getTime();
					
					if(first >= second ){
						document.getElementById("LeadStat").value = "Open";
						document.getElementById("Outcome").disabled = true;
					}
					else if(first <= second ){
						document.getElementById("LeadStat").value = "Completed";
						document.getElementById("Outcome").disabled = false;	
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
				$(window).load(function(){
					$("input#LeadDT").datepicker({});
				});	
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
				<form action="Activity-Add.php" method="post">
					<h3 class="text-primary">New Activity</h3>
					<table class="table table-responsive" style="background-color: #ffffff;">
						<tr>
							<td style="border: none;">Date</td>
							<td style="border: none;">
								<div class="inner-addon right-addon">
									<i class="glyphicon glyphicon-calendar"></i>
									<input type="text" name="LeadDT" id="LeadDT" onchange="myfunction()"  class="form-control" readonly required></td>
								</div>
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
							<td style="border: none;"><input type="text" id="scrollDefaultExample2" onchange="toggleDisability()" name="EndTime" class="form-control mySelect" >
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
							<td style="border: none;"><input type="text" name="ContactPerson" class="form-control" value="<?php echo odbc_result($sql, "Name"); ?>" required></td>
							<td style="border: none;">Contact No</td>
							<td style="border: none;"><input type="text" name="ContactNo" class="form-control" value="<?php echo odbc_result($sql, "Mobile"); ?>" required></td>
						</tr>
						<tr>
							<td style="border: none;">Activity</td>
							<td style="border: none;">
								<select name="Activity" id="Activity" class="form-control" required>
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
							</td -->
						</tr>
						<tr>
							<td style="border: none;">Remarks</td>
							<td style="border: none;" colspan="3"><textarea name="LeadRem" class="form-control" style="resize: none;" maxlength="200" required></textarea></td>
						</tr>
						<tr>
							<td style="border: none;">Status</td>
							<td style="border: none;"><input type="text" name="LeadStat" id="LeadStat" class="form-control" readonly required></td>
						</tr>
						<tr>
							<td style="border: none;" colspan="4" align="center">
							<input type="hidden" value="<?php echo odbc_result($sql, "Lead No"); ?>" name="LeadID">
							<input type="submit" value="Add" class="btn btn-primary"></td>
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
											<h3 class="text-danger" >Activity List</h3>
										</td>
									</tr>
									<tr>
										<th>Date</th>
										<th>Activity</th>
										<th>Outcome</th>
										<th>Remarks</th>
										<th>Contact Person</th>
										<th>Contact No</th>
									</tr>
									<?php
										$act = odbc_exec($conn, "SELECT [Date], [Activities], [Outcome], [Remarks], [Contact Person], [Contact No] FROM [CRM Daily Activity] WHERE [Assign To]='$LoginID' AND 
											[Lead ID]='".odbc_result($sql, "Lead No")."' ORDER BY [Date] DESC") or die(odbc_errormsg($conn));
										while(odbc_fetch_array($act)){
									?>
									<tr>
										<td style="font-weight: normal;"><?php echo date('d/M/Y', odbc_result($act, "Date")); ?></td>
										<td style="font-weight: normal;"><?php echo odbc_result($act, "Activities"); ?></td>
										<td style="font-weight: normal;"><?php echo odbc_result($act, "Outcome"); ?></td>
										<td style="font-weight: normal;"><?php echo odbc_result($act, "Remarks"); ?></td>
										<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact Person"); ?></td>
										<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact No"); ?></td>
									</tr>
									<?php
										}	
									?>
								</table>
			</td>
		</tr>
	</table>		
</div>
<?php require_once("../footer.php"); ?>