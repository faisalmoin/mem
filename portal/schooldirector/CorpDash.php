<?php
	require_once("../db.txt");
	
	//Today
	$today = date('Y-m-d');
	
	//Academic Year
        $AcadStartDate = (date(Y)-2)."-".date('m-d');
        $AcadEndDate = (date(Y)+1)."-".date('m-d');
        $a=0;
        $AcadYr = odbc_exec($conn, "SELECT DISTINCT TOP 3 [Code] FROM [Academic Year] WHERE ([Start Date] BETWEEN '$AcadStartDate' AND '$AcadEndDate') ORDER BY [Code] ASC") or exit(odbc_errormsg($conn));
        while(odbc_fetch_array($AcadYr)){
                echo "";
                        if($a==0) {
                                $ac0= odbc_result($AcadYr, "Code");
				//Get Start Date & End Date
				$dt0 = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='".$ac0."'" ) or exit(odbc_errormsg($conn));
                        }
                        if($a==1) {
                                $ac1= odbc_result($AcadYr, "Code");
				$dt1 = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='".$ac1."'" ) or exit(odbc_errormsg($conn));
                        }
                        if($a==2) {
                                $ac2= odbc_result($AcadYr, "Code");
				$dt2 = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='".$ac2."'" ) or exit(odbc_errormsg($conn));
                        }
                //echo "".odbc_result($AcadYr, "Code")."</td>";								
                $a++;
        }
?>
<!DOCTYPE html>
<html>
<head>
	<!-- bootstrap code -->
	<script src="../bs/js/Chart.js" language="JavaScript"></script>
</head>
<body>
	<div class="container">
		<h1 class='text-primary'>Dashboard</h1>
		<table border="1px" width="100%" cellspacing="15px" cellpadding="20px">
			<tr>
				<td width="40%" valign="top" align="center" rowspan="2">
					<table width="90%" cellpadding="10px" border=1>
						<tr>
							<td height="50px" style="background-color: #d3d3d3;" colspan="2">Session <?php echo substr(date('Y'),0,2).$ac1?></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<?php
									//Sum Total Active Schools
									$Company = mysql_query("SELECT COUNT(`id`) FROM `company` WHERE `CompanyStatus`=0 AND `Name` NOT LIKE '%Training%'") or exit(mysql_error());
									$Comp = mysql_fetch_array($Company);
									echo "<h1>".$Comp[0]."</h1>";
								?>
								Active Company
							</td>
						</tr>
						<tr>
							<td>Total Enquiry</td>
							<td align="right">
								<?php
									//Total Active Student
									//echo "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Enquiry Date] BETWEEN '".odbc_result($dt1, 'Start Date')."' AND '".odbc_result($dt1, 'End Date')."' ";
									$Enquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Enquiry Date] BETWEEN '".odbc_result($dt1, 'Start Date')."' AND '".odbc_result($dt1, 'End Date')."' ") or exit(odbc_errormsg($conn));
									echo odbc_result($Enquiry, "");
								?>
							</td>
						</tr>
						<tr>
							<td>Total Registration</td>
							<td align="right">
								<?php
									$Regisration = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '".odbc_result($dt1, 'Start Date')."' AND '".odbc_result($dt1, 'End Date')."' ") or exit(odbc_errormsg($conn));
									echo odbc_result($Regisration, "");
								?>
							</td>
						</tr>
						<tr>
							<td>Total Withdrwals/In-active</td>
							<td align="right">
								<?php
									//Total Active Student
									$Student = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]<>1") or exit(odbc_errormsg($conn));
									echo odbc_result($Student, "");
								?>
							</td>
						</tr>
						<tr>
							<td>Total Admissions</td>
							<td align="right">
								<?php
									//Total Active Student
									$Admission = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Date Joined ] BETWEEN '".odbc_result($dt1, 'Start Date')."' AND '".odbc_result($dt1, 'End Date')."' ") or exit(odbc_errormsg($conn));
									echo odbc_result($Admission, "");
								?>
							</td>
						</tr>
						<tr>
							<td>Total Active Student</td>
							<td align="right">
								<span style="background-color: orange; padding: 5px;font-weight: bold;border-radius: 5px;">
								<?php
									//Total Active Student
									$Student = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1") or exit(odbc_errormsg($conn));
									echo odbc_result($Student, "");
								?>
								</span>
							</td>
						</tr>
					</table>
				</td>
				<td width="60%" valign="top">
					<table width="100%" cellpadding="10px">
						<tr>
							<td height="50px" style="background-color: #d3d3d3;" colspan="2">Conversion <?php echo substr(date('Y'),0,2).$ac1?></td>
						</tr>
						<tr>
							<td width="80%">
							<!-- Chart -->
								
								
							</td>
							<td width="20%">
								<h1>
								<?php
									printf("%.2f",(odbc_result($Regisration, "")/odbc_result($Enquiry, ""))*100);
									echo "%";
								?>
								</h1>							
							</td>
						</tr>
						<tr>
							<td colspan="2">
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="1" width="100%">
						<tr><td height="50px" style="background-color: #d3d3d3;">Admission</td></tr>
						<tr>
							<td height="120px">
								<?php 
									$inStart = 1;
									//$AcadList = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Code] <= '".$a1."' AND [Company Name]='$ms'");
									$AcadList = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Code] <= '".$ac2."' ");
									$AcadNumRows = odbc_num_rows($AcadList);
									$StartAcad = $AcadNumRows-5;
									
										while(odbc_fetch_array($AcadList)){
											if($inStart > $StartAcad){
												$lbs .=  '"'.odbc_result($AcadList, 'Code').'",';
												
												//$StuAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '".odbc_result($AcadList, 'Code')."'  AND [Company Name]='$ms'");
												$StuAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '$ac2' ");
												$AdmStu .= '"'.odbc_result($StuAdm, '').'", ';
												
												//$StuStr = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '".odbc_result($AcadList, 'Code')."' AND [Student Status]=1 AND [Company Name]='$ms'");
												$StuStr = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Academic Year] = '$ac2' AND [Student Status]=1");
												$StrStu .= '"'.odbc_result($StuStr, '').'", ';
												
											}
											$inStart += 1;
										}
										//echo $AdmStu; 
								?>
								<div style="width:100%">
									<div>
										<canvas id="canvas" height="30px" width="100%"></canvas>
									</div>
								</div>
								<script>									
									var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
									var lineChartData = {
										labels : [<?php echo $lbs;?>],
										datasets : [
											{
												label: "My First dataset",
												fillColor : "rgba(220,220,220,0.2)",
												strokeColor : "rgba(220,220,220,1)",
												pointColor : "rgba(220,220,220,1)",
												pointStrokeColor : "#fff",
												pointHighlightFill : "#fff",
												pointHighlightStroke : "rgba(220,220,220,1)",
												data : [<?php echo $AdmStu;?>]
											},
											{
												label: "My Second dataset",
												fillColor : "rgba(151,187,205,0.2)",
												strokeColor : "rgba(151,187,205,1)",
												pointColor : "rgba(151,187,205,1)",
												pointStrokeColor : "#fff",
												pointHighlightFill : "#fff",
												pointHighlightStroke : "rgba(151,187,205,1)",
												data : [<?php echo $StrStu; ?>]
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
			
		</table>
	</div>
</body>
</html>