<script src="../bs/js/Chart.js" language="JavaScript"></script>
<?php
	
	$CurrDate = date('Y-m-d')." 00:00:000";		
	$AcadSQL = odbc_exec($conn, "SELECT MAX([Code]) FROM [Academic Year] WHERE  [Start Date] <= '".$CurrDate."' AND [Company Name]='$ms'");
	$AcadYr = odbc_result($AcadSQL, '');
	
	if($AcadYr == NULL || $AcadYr==0){
		$AcadSQL = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE  [Start Date] LIKE '%".date('Y')."%' AND [Company Name]='$ms'");
		$AcadYr = odbc_result($AcadSQL, 'Code');		
	}
	
	
	//Academic Years
	$CurrAcadYr = $AcadYr;
	$tmpAcadYr = explode("-", $AcadYr);
	$NextAcadYr = $tmpAcadYr[1]."-".($tmpAcadYr[1]+1);
	
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
<h2 class="text-primary">Principal Dashboard</h2> 
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<!-- <div style="border: 1px solid #d3d3d3; background-color: #EEEFFB;border-radius: 5px;"> -->
<div style="border: 0px solid #d3d3d3; background-color: #FFFFFF;border-radius: 5px;">
	
	<div class="table-responsive">
		<table class="table table-border" >
			<tr>
				<td valign="top" width="30%" style="border: none;">
					<?php
                                                //echo "SELECT COUNT([Enquiry Status]) FROM [Temp Enquiry] WHERE [Enquiry Status] = 0 AND [Admission For Year] = '$AcadYr'";
						$hot = odbc_exec($conn, "SELECT COUNT([Enquiry Status]) FROM [Temp Enquiry] WHERE [Enquiry Status] = 0 AND [Admission For Year] = '$AcadYr' AND [Company Name]='$ms'");
						$warm= odbc_exec($conn, "SELECT COUNT([Enquiry Status]) FROM [Temp Enquiry] WHERE [Enquiry Status] = 1 AND [Admission For Year] = '$AcadYr' AND [Company Name]='$ms'");
						$cold = odbc_exec($conn, "SELECT COUNT([Enquiry Status]) FROM [Temp Enquiry] WHERE [Enquiry Status] = 2 AND [Admission For Year] = '$AcadYr' AND [Company Name]='$ms'");
						$CurrReg = odbc_exec($conn,"SELECT COUNT([Registration Status]) from [Temp Enquiry] WHERE [Registration Status] = 1 AND [Admission For Year] = '$CurrAcadYr' AND [Company Name]='$ms' ");
						$NxtReg = odbc_exec($conn,"SELECT COUNT([Registration Status]) from [Temp Enquiry] WHERE [Registration Status] = 1 AND [Admission For Year] = '$NextAcadYr' AND [Company Name]='$ms' ");
						$CurrAdm = odbc_exec($conn,"SELECT COUNT([No_]) from [Temp Student] WHERE [Admission for Year] = '$CurrAcadYr'  AND [Company Name]='$ms'");
						$NxtAdm = odbc_exec($conn,"SELECT COUNT([No_]) from [Temp Student] WHERE [Admission for Year] = '$NextAcadYr'  AND [Company Name]='$ms'");
						$CurrWithcard = odbc_exec($conn,"select COUNT([Academic Year]) from [Temp Student] WHERE [Academic Year] = '$CurrAcadYr'  AND [Student Status] <> 1 AND [Company Name]='$ms'");
						$NxtWithcard = odbc_exec($conn,"select COUNT([Academic Year]) from [Temp Student] WHERE [Academic Year] = '$NextAcadYr'  AND [Student Status] <> 1 AND [Company Name]='$ms'");
						$curr = odbc_exec($conn,"select count([Student Status]) from [Temp Student] WHERE [Student Status]=1 AND [Academic Year]  = '$AcadYr'  AND [Company Name]='$ms'");
						
						$Conv = number_format(((odbc_result($adm, '')/odbc_result($reg, ''))*100),2,'.','');
						$EnqTot = (odbc_result($hot, '') + odbc_result($warm, '') + odbc_result($cold, ''));
						
					?>
					<table class="table" style="border: 1px solid #d3d3d3; color: #736f6e;">
						<tr style="background-color: #d3d3d3;">
							<td colspan="3" height="40px" align="center"><h4>Overview</h4></td>
						</tr>
						<tr>
							<td colspan="3" height="40px" align="center">
								<a href="#" data-toggle="modal" 
								data-target="#StrengthModal" style="color: #000;"><span style="font-size: 54px; color: #000;"><?php echo odbc_result($curr,''); ?></span></a><br />
								<small>Current Student Strength</small>
								<!-- Modal -->
								<div class="modal fade" id="StrengthModal">
								   <div class="modal-dialog" style="width: 750px;">
								      <div class="modal-content" style="width: 750px;">
									 <div class="modal-header">
									    <button type="button" class="close" 
									       data-dismiss="modal" aria-hidden="true">
										  &times;
									    </button>
									    <h4 class="modal-title" id="myModalLabel">
									       Student Status <?php echo $AcadYr; ?>
									    </h4>
									 </div>
									 <div class="modal-body">
										<?php //require_once("StudentStrength.php"); ?>
									 </div>
									 <div class="modal-footer">
									    <button type="button" class="btn btn-default" 
									       data-dismiss="modal">Close
									    </button>
									 </div>
								      </div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
							</td>
						</tr>
						<tr>
							<td style="border: none;">Session</td>
							<td style="border: none;" align="right"><?php echo $CurrAcadYr;?></td>
							<td style="border: none;" align="right"><?php echo $NextAcadYr;?></td>
						</tr>
						<tr>
							<td style="border: none;">Total Enquiry</td>
							<td style="border: none;color: #000;text-align: right;">
								<?php
									$CurrEnq = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND [Admission for Year]='$CurrAcadYr'") or exit(odbc_errormsg($conn));
									echo odbc_result($CurrEnq, "");
								?>
							</td>
							<td style="border: none;color: #000;text-align: right;">
								<?php
									$NxtEnq = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND [Admission for Year]='$NextAcadYr'") or exit(odbc_errormsg($conn));
									echo odbc_result($NxtEnq, "");
								?>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Registrations</td>
							<td style="border: none;color: #000;text-align: right;"><?php echo odbc_result($CurrReg, ''); ?></td>
							<td style="border: none;color: #000;text-align: right;"><?php echo odbc_result($NxtReg, ''); ?></td>
						</tr>
						<tr>
							<td style="border: none;">Admissions</td><td style="border: none;color: #000;text-align: right;">
								<span style="background-color: #ffa500;border-radius: 5px;padding: 3px"><?php echo odbc_result($CurrAdm, ''); ?></span>								
							</td>
							<td style="border: none;color: #000;text-align: right;">
								<span style="background-color: #ffa500;border-radius: 5px;padding: 3px"><?php echo odbc_result($NxtAdm, ''); ?></span>								
							</td>							
						</tr>
						<tr>
							<td style="border: none;">Withdrawals</td>
							<td style="border: none;color: #000;text-align: right;"><?php echo odbc_result($CurrWithcard,'');?></td>
							<td style="border: none;color: #000;text-align: right;"><?php echo odbc_result($NxtWithcard,'');?></td>
						</tr>
					</table>
				</td>
				<td colspan="2" valign="top" width="70%" style="border: 0px;">
					<table style="border: 1px solid #d3d3d3; color: #736f6e;" width="100%" height="100%" class="table">
						<tr style="background-color: #d3d3d3;">
							<td height="40px"><h4>Chart View</h4>
								<?php 
										$inStart = 1;
										$AcadList = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Code] <= '".$NextAcadYr."' AND [Company Name]='$ms'");
										$AcadNumRows = odbc_num_rows($AcadList);
										$StartAcad = $AcadNumRows-5;
										
											while(odbc_fetch_array($AcadList)){
												if($inStart > $StartAcad){
													$lbs .=  '"'.odbc_result($AcadList, 'Code').'",';
													/*
													$StuAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '".odbc_result($AcadList, 'Code')."'  AND [Company Name]='$ms'");
													$AdmStu .= '"'.odbc_result($StuAdm, '').'", ';
													
													$StuStr = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '".odbc_result($AcadList, 'Code')."' AND [Student Status]=1 AND [Company Name]='$ms'");
													$StrStu .= '"'.odbc_result($StuStr, '').'", ';
													*/
													
													$gEnq = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year]='".odbc_result($AcadList, 'Code')."'  AND [Company Name]='$ms' ") or exit(odbc_errormsg($conn));
													$StrStu .= '"'.odbc_result($gEnq, '').'", ';
													
													$gReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year]='".odbc_result($AcadList, 'Code')."' AND [Registration Status]=1 AND [Company Name]='$ms' ") or exit(odbc_errormsg($conn));
													$StrReg .= '"'.odbc_result($gReg, '').'", ';
													
													$gAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year]='".odbc_result($AcadList, 'Code')."' AND [Registration Status]=1 AND [AdmissionStatus]=1 AND [Company Name]='$ms' ") or exit(odbc_errormsg($conn));
													$AdmStu .= '"'.odbc_result($gAdm, '').'", ';
												}
												$inStart += 1;
											}
											//echo $AdmStu; 
									?>
							</td>
						</tr>
						<tr>
							<td>
								<div style="width:100%">
									<div>
										<canvas id="canvas" height="30px" width="100%"></canvas>
									</div>
								</div>
								Legend : <span style="padding: 4px; background-color: rgba(220,220,220,1); border: 1px slid #d3d3d3;">&nbsp;&nbsp;&nbsp;</span> Enquiry
									<span style="padding: 4px; background-color: rgba(151,187,205,1); border: 1px slid #d3d3d3;">&nbsp;&nbsp;&nbsp;</span> Registration
									<span style="padding: 4px; background-color: rgba(0,255,0,1); border: 1px slid #d3d3d3;">&nbsp;&nbsp;&nbsp;</span> Admission
								<script>									
									var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
									var lineChartData = {
										labels : [<?php echo $lbs;?>],
										datasets : [
											{
												label: "Enquiry",
												fillColor : "rgba(220,220,220,0.2)",
												strokeColor : "rgba(220,220,220,1)",
												pointColor : "rgba(220,220,220,1)",
												pointStrokeColor : "#fff",
												pointHighlightFill : "#fff",
												pointHighlightStroke : "rgba(220,220,220,1)",
												data : [<?php echo $StrStu;?>]
											},
											{
												label: "Registration",
												fillColor : "rgba(151,187,205,0.2)",
												strokeColor : "rgba(151,187,205,1)",
												pointColor : "rgba(151,187,205,1)",
												pointStrokeColor : "#fff",
												pointHighlightFill : "#fff",
												pointHighlightStroke : "rgba(151,187,205,1)",
												data : [<?php echo $StrReg; ?>]
											},
											{
												label: "Admission",
												fillColor : "rgba(0,255,0,0.3)",
												strokeColor : "rgba(0,255,0,1)",
												pointColor : "rgba(0,255,0,1)",
												pointStrokeColor : "#fff",
												pointHighlightFill : "#fff",
												pointHighlightStroke : "rgba(151,187,205,1)",
												data : [<?php echo $AdmStu; ?>]
											}
										]}

									window.onload = function(){
										var ctx = document.getElementById("canvas").getContext("2d");
										window.myLine = new Chart(ctx).Line(lineChartData, {
											responsive: true
										});
									}
								</script>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="border: none;" rowspan="2">
					<?php
						$FeeNeg = 0;
						$FeePos = 0;
						/*
						$sql = "SELECT [Customer No_], SUM([Amount]) FROM schoolerp.dbo.[$ms\$Detailed Cust_ Ledg_ Entry] WHERE 
							[Customer No_] IN (SELECT [No_] FROM schoolerp.dbo.[$ms\$Student] WHERE [Student Status]=1)
							GROUP BY [Customer No_] ";
						$FeeSum = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
						
						while(odbc_fetch_array($FeeSum)){		
							if(odbc_result($FeeSum, "")< 0){
								$FeeNeg += odbc_result($FeeSum, '');
							}
							else{
								$FeePos += odbc_result($FeeSum, '');
							}
						}
						*/
						
						$sql = "select SUM([Credit Amount]) FROM [Ledger Credit] WHERE 
							[Company name]='$ms' AND
							[Invoice No] NOT IN (SELECT [Invoice No] FROM [Ledger Debit] WHERE 
							[Company name]='$ms')";
						$FeeSum = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
						$FeePos = odbc_result($FeeSum, '');
					?>
					<table class="table" style="border: 1px solid #d3d3d3; color: #736f6e;">
						<tr style="background-color: #d3d3d3;">
							<td colspan="2"><h4><a href="#" data-toggle="modal" data-target="#financial" style="color: #736f6e">Financials</a></h4></td>
						</tr>
						<!--<tr data-toggle="modal" data-target="#financial" class="text-danger">-->
						<tr >
							<td style="color:#990000" valign="center">
							<!--<a href="#" class="text-danger"></a>-->
								<h4>Fee Outstanding</h4></td>
							<td align="right" style="color:#990000"><h4>&#8377; <?php echo number_format($FeePos,2,".",","); ?></h4></td>
						</tr>
					</table>
					<!-- Financial Modal Start -->
					<div class="modal fade" id="financial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="80%">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">
										Financials
									</h4>
								</div>
								<div class="modal-body">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" href="#menu1">Fee Summary</a></li>
										<li><a data-toggle="tab" href="#home">Financials</a></li>
									</ul>
									<div class="tab-content">
										<div id="menu1" class="tab-pane fade in active">
											<div class="table-responsive">
												<table class="table table-border" style="border: 1px solid #d3d3d3;">
													<tr style="background-color: #D1D0CE;">
														<td colspan="2"><h3>Fee Summary</h3></td>
													</tr>
													<tr>
														<td>Previous Year Outstanding</td><td align="right">&#8377; 10</td>
													</tr>
													<tr>
														<td>Fee Raised For Current Year</td><td align="right">&#8377; <?php echo number_format($FeeNeg,2,".",","); ?></td>
													</tr>
													<tr><td>Fee Collected / Discounts</td><td align="right">&#8377; 10</td></tr>
													<tr><td>Fee Outstanding</td><td align="right">&#8377; <?php echo number_format($FeePos,2,".",","); ?></td></tr>
												</table>
											</div>
										</div>
										<div id="home" class="tab-pane fade in">
											<div class="table-responsive">
												<table class="table table-border" style="border: 1px solid #d3d3d3;">
													<tr style="background-color: #D1D0CE;"><td colspan="2"><h3>Financials &#8377;</h3></td></tr>
													<tr>
														<td>Bank A/c Operations</td><td align="right">&#8377; <?php echo number_format(odbc_result($BankOps,''),2,'.',','); ?></td>
													</tr>
													<tr>
														<td>Bank Revenue</td><td align="right">&#8377; <?php echo number_format(odbc_result($BankRev,''),2,'.',','); ?></td>
													</tr>
													<tr>
														<td>Bank Imprest</td><td align="right">&#8377; <?php echo number_format(odbc_result($BankImp,''),2,'.',','); ?></td>
													</tr>
													<tr>
														<td>Cash in Hand</td><td align="right">&#8377; <?php echo number_format(odbc_result($CashOps,''),2,'.',','); ?></td>
													</tr>
												</table>
											</div>
										</div>										
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div>					
					<!-- End of Financial Modal-->					
				</td>
				<td width="50%" style="border: none; color: #736f6e;">
					<table class="table" style="border: 1px solid #d3d3d3;">
						<tr style="background-color: #d3d3d3;">
							<td colspan="2" >
								<h4>Approvals
								<span class="glyphicon glyphicon-ok"></span></h4>
							</td>
						</tr>
						<tr>
							<td>Student Card Changes</td>
							<td style=" color: #000000;text-align: right;"><?php 
								//$card=odbc_exec($conn,"select count([Sender ID]) from [".$ms."\$Approval Entry-Master12] where [Approval Code]='STUDENT' ");
								//echo odbc_result($card,'');
								
								$card = odbc_exec($conn, "SELECT COUNT(DISTINCT([AdmissionNo])) FROM [approvalrequest] WHERE [Table]='STUDENT' AND [ApproverID]='$LoginID' AND [CompanyName]='$ms' AND [Status]='Open'") or die(odbc_errormsg());								
								echo odbc_result($card, "");
							?></td>
						</tr>
						<tr>
							<td style="border: none;">TC Approvals</td>
							<td style="border: none; color: #000000;text-align: right;"><?php 
								$transfer=odbc_exec($conn,"select count([Student No_]) from [Temp Transfer Certificate] where [Company Name]='$ms' AND [TC Issued]=0");
								echo odbc_result($transfer,'');								
							?></td>
						</tr>
						<!--
						<tr>
							<td style="border: none;">Vendor Approvals</td>
							<td style="border: none; color: #000000;"><?php 
								//$vendor=odbc_exec($conn,"select count([Sender ID]) from [".$ms."\$Approval Entry-Master12] where [Approval Code]='VENDOR' ");
								//echo odbc_result($vendor,'');
							?></td>
						</tr>
						-->
					</table>
				</td>
				<!--
				<td width="35px" style="border: none;">
					<table class="table" style="border:1px solid #d3d3d3; color: #736f6e;">
						<tr style="background-color: #d3d3d3;">
							<td colspan="2">
								<h4>Attendance <span class="glyphicon glyphicon-list-alt"></span></h4>
							</td>
						</tr>
						<tr>
							<td>Staffs : Present</td>
							<td style=" color: #000000;"><?php 
								//$present=odbc_exec($conn,"select count([User ID]) from [".$ms."\$Employee Attendance] WHERE [Attendance]=1 and [Attendance Date]='".date('Y-m-d')."'");
								//echo odbc_result($present, '');
							?>
							</td>
						</tr>
						<tr>
							<td style="border: none;">Staffs : Absent</td>
							<td style="border: none; color: #000000;"><?php 
								//$leave = odbc_exec($conn,"select count([User ID]) from [".$ms."\$Employee Attendance] WHERE [Absent]=1 and [Attendance Date]='".date('Y-m-d')."'");
								//echo odbc_result($leave, '');
							?></td>
						</tr>
						<tr>
							<td style="border: none;">Staffs : On Leave</td>
							<td style="border: none; color: #000000;"><?php 
								//$leave = odbc_exec($conn,"select count([User ID]) from [".$ms."\$Employee Attendance] WHERE [Leave]=1 and [Attendance Date]='".date('Y-m-d')."'");
								//echo odbc_result($leave, '');
							?></td>
						</tr>
					</table>
				</td>
				-->
				<td width="50%" style="border: 0px;">
					<table class="table" style="border:1px solid #d3d3d3; color: #736f6e;">
						<tr style="background-color: #d3d3d3;">
							<td style="text-shadow: 1px 1px 2px black, 0 0 26px #FACC2E, 0 0 6px #FACC2E;" colspan="3"  ><h4><b>Birthdays!!!</b> <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star"></span></h4></td>
						</tr>
						<tr>								
							<td style="border: none;">Students</td>
							<td style="border: none; color: #000000;"><a href="#" data-toggle="modal" 
									data-target="#StuDOB" style="color: #000;">
								<?php 
									$StuDOB = odbc_exec($conn, "SELECT COUNT([Name]) FROM [Temp Student] WHERE DATEPART(month, [Date Of Birth]) = '".date('m')."' AND DATEPART(day, [Date Of Birth]) = '".date('d')."' AND [Student Status]=1 AND [Company Name]='$ms'");
									while(odbc_fetch_array($StuDOB)){
										echo odbc_result($StuDOB, '');
									}
								?></a>
								<!-- Modal -->
								<div class="modal fade" id="StuDOB" tabindex="-1" role="dialog" 
								   aria-labelledby="myModalLabel" aria-hidden="true">
								   <div class="modal-dialog">
								      <div class="modal-content">
									 <div class="modal-header">
									    <button type="button" class="close" 
									       data-dismiss="modal" aria-hidden="true">
										  &times;
									    </button>
									    <h4 class="modal-title" id="myModalLabel">
									       Student's Birthday <?php date('d/M/Y'); ?>
									    </h4>
									 </div>
									 <div class="modal-body">
										<table class="table">
											<tr><td style="border: none;">SN</td>
												<td style="border: none;">Name</td>
												<td style="border: none;">Class</td>
												<td style="border: none;">Section</td>
											</tr>
											<?php
												$stu_dob = 1;
												$StuBirth = odbc_exec($conn, "SELECT [Name], [Class], [Section] FROM [Temp Student] WHERE DATEPART(month, [Date Of Birth])='".date('m')."' AND DATEPART(day, [Date Of Birth])='".date('d')."' AND [Student Status] = 1 AND [Company Name]='$ms'");
												while(odbc_fetch_array($StuBirth)){
											?>
											<tr>
												<td><?php echo $stu_dob?></td>
												<td><?php echo odbc_result($StuBirth, "Name"); ?></td>
												<td><?php echo odbc_result($StuBirth, "Class"); ?></td>
												<td><?php echo odbc_result($StuBirth, "Section"); ?></td>
												
											</tr>
											<?php
													$stu_dob += 1;
												}
											?>
											
										</table>
									 </div>
									 <div class="modal-footer">
									    <button type="button" class="btn btn-default" 
									       data-dismiss="modal">Close
									    </button>
									 </div>
								      </div><!-- /.modal-content -->	
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
								
							</td>
						</tr>
						<tr>
							<td style="border: none;">Staffs </td>
							<td style="border: none; color: #000000;" ><a href="#" data-toggle="modal" 
									data-target="#StaffDOB" style="color: #000;">
								<?php 
								$StaffDOB = odbc_exec($conn, "SELECT count([First Name]) FROM [Employee] WHERE DATEPART(month, [Birth Date]) = '".date('m')."' AND DATEPART(day, [Birth Date]) = '".date('d')."' AND [Status] = 0 AND [Company Name]='$ms'");
								while(odbc_fetch_array($StaffDOB)){
									echo odbc_result($StaffDOB, '');
								}?></a>
								<!-- Modal -->
								<div class="modal fade" id="StaffDOB" tabindex="-1" role="dialog" 
								   aria-labelledby="myModalLabel" aria-hidden="true">
								   <div class="modal-dialog">
								      <div class="modal-content">
									 <div class="modal-header">
									    <button type="button" class="close" 
									       data-dismiss="modal" aria-hidden="true">
										  &times;
									    </button>
									    <h4 class="modal-title" id="myModalLabel">
									       Staff Birthday <?php date('d/M/Y'); ?>
									    </h4>
									 </div>
									 <div class="modal-body">
										<table class="table">
											<tr><td style="border: none;">SN</td>
												<td style="border: none;">Name</td>
												<td style="border: none;">Job Title</td>
											</tr>
											<?php
												$emp_dob = 1;
												$EmpBirth = odbc_exec($conn, "SELECT [First Name], [Middle Name], [Last Name], [Job Title] FROM [Employee] WHERE DATEPART(month, [Date Of Birth])='".date('m')."' AND DATEPART(day, [Date Of Birth])='".date('d')."' AND [Student Status] = 1 AND [Company Name]='$ms'");
												while(odbc_fetch_array($EmpBirth)){
											?>
											<tr>
												<td><?php echo $stu_dob?></td>
												<td><?php echo odbc_result($EmpBirth, "First Name"); ?> <?php echo odbc_result($EmpBirth, "Middle Name"); ?> <?php echo odbc_result($EmpBirth, "Last Name"); ?></td>
												<td><?php echo odbc_result($EmpBirth, "Job Title"); ?></td>
												
											</tr>
											<?php
													$emp_dob = 1;
												}
											?>
											
										</table>
									 </div>
									 <div class="modal-footer">
									    <button type="button" class="btn btn-default" 
									       data-dismiss="modal">Close
									    </button>
									 </div>
								      </div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>	
</div>

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