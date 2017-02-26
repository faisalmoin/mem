<?php
	require_once("header.php");
	$sql =odbc_exec($conn, "SELECT * FROM [CRM Lead] WHERE [Assign To]='$LoginID' AND [Status] <> 'Qualified' ORDER BY [Lead Date] DESC") or die(odbc_errormsg($conn));
?>

<div class="container">
	
	<div class="row">
		<div class="col-sm-8">
			<h3 class="text-primary" >Lead List</h3>
		</div>
		<div class="col-sm-2" align="right">
			<div class="inner-addon right-addon">
				<i class="glyphicon glyphicon-search"></i>
				<input type="text" 
				class="form-control"
				id="search"
				style="border: 1px solid #d3d3d3; width: 180px;" 
				placeholder="Type to search ..." />
			</div>		
		</div>
		<div class="col-sm-2">
			<a href="Lead-New.php" class="btn btn-success">Create Lead</a>
		</div>
	</div>
	<table class="table table-responsive table-hover table-striped" id="tblData">
		<tr style="background-color: #0404B4; color: #ffffff;">
			<th>SN</th>
			<th>Lead ID</th>
			<th>Date</th>
			<th>Name</th>
			<th>City</th>
			<th>State</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Brand</th>
			<th>Status</th>
			<th></th>
		</tr>
		<?php
			$i = 1;
			while(odbc_fetch_array($sql)){
		?>
		<tr>
			<td><?php echo $i?></td>
			<td>
				<a href="#myModal<?php echo $i?>" data-toggle="modal"><?php echo odbc_result($sql, "Lead No"); ?></a>
				
				<!-- Modal -->
				<div class="modal fade" id="myModal<?php echo $i?>" role="dialog">
					<div class="modal-dialog"   
						style="width: 100%;
							  height: 100%;
							  margin: 0;
							  padding: 0;">

						<!-- Modal content-->
						<div class="modal-content" 
							style=" height: auto;
								  min-height: 100%;
								  border-radius: 0;">
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
								
								<table class="table table-responsive" style="font-size: 12px;">
									<tr>
										<td colspan="6"><h3 class="text-danger" style="font-weight: bold;">Activity List</h3></td>
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
										$act = odbc_exec($conn, "SELECT [Date], [Activities], [Outcome], [Remarks], [Contact Person], [Contact No] 
											FROM [CRM Daily Activity] WHERE [Assign To]='$LoginID' AND 
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
							</div>
							<div class="modal-footer">
								<button type="button" onclick="window.location.href='Lead-Edit.php?id=<?php echo odbc_result($sql, "ID"); ?>';" class="btn btn-info " 
									data-dismiss="modal" style="width: 100px !important;">Edit</button>
								<a href="#" onclick="window.location.href='Activity-New.php?id=<?php echo odbc_result($sql, "ID"); ?>';"  class="btn btn-warning " data-dismiss="modal" style="width: 100px !important;">Activity</a>
								<button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px !important;">Close</button>
							</div>
						</div>

					</div>
				</div>
			</td>
			<td><?php echo date('d/M/Y', odbc_result($sql, "Lead Date")); ?></td>
			<td><?php echo odbc_result($sql, "Name"); ?></td>
			<td><?php echo odbc_result($sql, "City"); ?></td>
			<td><?php echo odbc_result($sql, "State"); ?></td>
			<td><?php echo odbc_result($sql, "Mobile"); ?></td>
			<td><?php echo odbc_result($sql, "Email"); ?></td>
			<td><?php echo odbc_result($sql, "Likely Brand"); ?></td>
			<td><?php echo odbc_result($sql, "Status"); ?></td>			
			<td>
				<a href="#myModal<?php echo $i?>" style="font-size: 10px;" data-toggle="modal">View</a> <br />
				<a href="Lead-Edit.php?id=<?php echo odbc_result($sql, "ID"); ?>" style="font-size: 10px;" data-toggle="modal">Edit</a> <br />
				<a href="Activity-New.php?id=<?php echo odbc_result($sql, "ID"); ?>" style="font-size: 10px;" data-toggle="modal">Activity</a> <br />
				<a href="#convert<?php echo $i?>"  style="font-size: 10px;" data-toggle="modal">Convert</a>
				
				<!-- Modal -->
				<div class="modal fade" id="convert<?php echo $i?>" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h3 class="modal-title text-danger" style="font-weight: bold;">Lead convert</h3>
							</div>
							<div class="modal-body">
								<form class="convert">
									<table class="table table-responsive">
										<tr>
											<td style="border: none">Current Status</td>
											<td style="border: none"><?php echo odbc_result($sql, "Status"); ?></td>
										</tr>
										<tr>
											<td style="border: none">New Status <sup style="color: #990000; font-weight: bold; font-size: 14px;">*</sup></td>
											<td style="border: none">
												<select name="Status" id="Status<?php echo $i; ?>" class="form-control" onchange="myfunction<?php echo $i; ?>()"  required >
													<option value=""></option>
													<option value="Qualified">Qualified</option>
													<option value="Dis-qualified">Dis-qualified</option>
													<?php if(odbc_result($sql, "Status") === "Lost" || odbc_result($sql, "Status") === "Dis-qualified") 
														echo '<option value="Reopen">Reopen</option>';
													?>
													<option value="Lost">Lost</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="border: none">Land status</td>
											<td style="border: none">
												<select name="land" id="land<?php echo $i; ?>" class="form-control" disabled="true">
													<option value=""></option>
													<option value="3-4 acres">3-4 acres</option>
													<option value="4-5 acres">4-5 acres</option>
													<option value="5 acres+">5 acres+</option>
												</select>
											</td>
										</tr>
										<input type="hidden" value="<?php echo odbc_result($sql, "ID"); ?>" name="id<?php echo $i; ?>" id="id<?php echo $i; ?>" />
										<tr>
											<td style="border: none">Investment Potential</td>
											<td style="border: none">
												<select name="invest" id="invest<?php echo $i; ?>" class="form-control" disabled="true">
													<option value=""></option>
													<option value="4-5 crores">4-5 crores</option>
													<option value="5 crores+">5 crores+</option>
												</select>
											</td>
										</tr>
									</table>
								</form>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-info " id="submit<?php echo $i?>"
									style="width: 100px !important;">Convert</button>
								<button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px !important;">Close</button>
							</div>
						</div>
					</div>
				<script>
				$(function() {
						//twitter bootstrap script
						$("button#submit<?php echo $i?>").click(function(){
						
							var id = document.getElementById("id<?php echo $i?>").value;
							var Status = document.getElementById("Status<?php echo $i?>").value;
							var land = document.getElementById("land<?php echo $i?>").value;
							var invest = document.getElementById("invest<?php echo $i?>").value;
							
							//alert(id);
							
							$.ajax({
								type: "POST",
								url: "lead_status_upd.php",
								//data: $('form.convert').serialize(),
								data:  "id=" + id + "&Status=" + Status + "&land=" + land + "&invest=" + invest ,
								success: function(msg){
									$("#thanks").html(msg)
									//$("#form-content").modal('hide'); 
									window.location.reload();
								},
								error: function(){
									alert("failure");
								}								
							});
							
						});
					});
					
					function myfunction<?php echo $i; ?>(){
						var first = document.getElementById("Status<?php echo $i; ?>").value;
						if(first === "Qualified"){
							document.getElementById("land<?php echo $i; ?>").disabled = false;
							document.getElementById("invest<?php echo $i; ?>").disabled = false;
							document.getElementById("land<?php echo $i; ?>").required = true;
							document.getElementById("invest<?php echo $i; ?>").required = true;							
						}
						else{
							document.getElementById("land<?php echo $i; ?>").disabled = true;
							document.getElementById("invest<?php echo $i; ?>").disabled = true;
						}
					}
				</script>
				</div>
				
				<script>
					
					
				</script>

			</td>
		</tr>
		<?php
				$i++;
			}
		?>
	</table>
</div>
<?php require_once("../footer.php"); ?>