<?php 
	require_once("header.php");
?>
		<div class="container-fluid" >
			<div class="table-responsive">          
				<table id="myTable" class="table table-striped table-bordered" >  
					<thead>
					<tr>
						<td colspan="15"><h1 class="text-primary">Director's Dashboard <small>YTD</small></h1></td>
					<tr>
					<tr>
					      <td rowspan="3">Sr No.</td>
					      <td rowspan="3">School Name</td>
					      <td rowspan="3">Current Student Strength</td>
					      <td colspan="6" align="center">Academic Year</td>
					      <td rowspan="3" align="center">Total Fee Outstanding</td>     
					      <!-- <td colspan="4"  align="center">Fee O/S trend</td>	-->
					</tr>
					<tr>
						<?php
							//Academic Year
							$AcadStartDate = (date(Y)-2)."-".date('m-d');
							$AcadEndDate = (date(Y)+1)."-".date('m-d');
							$a=0;
							$AcadYr = odbc_exec($conn, "SELECT DISTINCT TOP 3 [Code] FROM [Academic Year] WHERE ([Start Date] BETWEEN '$AcadStartDate' AND '$AcadEndDate') ORDER BY [Code] ASC") or exit(odbc_errormsg($conn));
							while(odbc_fetch_array($AcadYr)){
								echo "<td align='center' ";
									if($a==0) {
										echo "colspan='2'";
										$ac0= odbc_result($AcadYr, "Code");
									}
									if($a==1) {
										echo "colspan='2'";
										$ac1= odbc_result($AcadYr, "Code");
									}
									if($a==2) {
										echo "colspan='2'";
										$ac2= odbc_result($AcadYr, "Code");
									}
								echo ">".substr(date('Y'),0,2).odbc_result($AcadYr, "Code")."</td>";								
								$a++;
							}
						?>
						<!--<td rowspan="2">As on 31<sup>st</sup> Mar'<?php echo date('y')?></td>
						<td rowspan="2">As on 30<sup>th</sup> Jun'<?php echo date('y')?></td>
						<td rowspan="2">As on 30<sup>th</sup> Sep'<?php echo date('y')?></td>
						<td rowspan="2">As on 31<sup>st</sup> Dec'<?php echo date('y')?></td>-->
					</tr>
					<tr>
						<td>Admission</td>
						<td>Total Withdrawal</td>
						
						<td>Admission</td>
						<td>Total Withdrawal</td>						
						
						<td>Admission</td>
						<td>Total Withdrawal</td>
						
					</tr>
					</thead>
					<tbody>
					<?php
						$i=1;
						//Distinct Company
						//$Comp = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [Temp Student] WHERE [Company Name] NOT LIKE 'Training%'  ORDER BY [Company Name] ASC") or exit(odbc_errormsg($conn));
						$Comp = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [Temp Student] WHERE [Company Name] IN $CompName AND [Company Name] NOT LIKE 'Training%'  ORDER BY [Company Name] ASC") or exit(odbc_errormsg($conn));
						while(odbc_fetch_array($Comp)){
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo odbc_result($Comp, "Company Name"); ?></td>
						<td align="right"><?php 
							$Stu = odbc_exec($conn, "SELECT COUNT(No_) FROM [Temp Student] WHERE [Student Status]=1 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
							echo odbc_result($Stu, "");
							$TotStu += odbc_result($Stu, "");
						?></td>
						<td align="right"><?php 
							$prevAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Admission For Year]='$ac0' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($prevAdm, "");
							$TotPrevAdm += odbc_result($prevAdm, "");
						?></td>
						<td align="right"><?php 
							$prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit(odbc_errormsg($conn));
							$prevTC = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($prevAcad, "Start Date")."' AND '".odbc_result($prevAcad, "End Date")."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($prevTC, "");
							$TotPrevTC += odbc_result($prevTC, "");
						?></td>
						<td align="right"><?php 
							$CurrAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Admission For Year]='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($CurrAdm, "");
							$TotCurrAdm += odbc_result($CurrAdm, "");
						?></td>
						<td align="right"><?php 
							$CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit(odbc_errormsg($conn));
							$CurrTC = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($CurrAcad, "Start Date")."' AND '".odbc_result($CurrAcad, "End Date")."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($CurrTC, "");
							$TotCurrTC += odbc_result($CurrTC, "");
						?></td>
						<td align="right"><?php 
							$NxtAdm = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Admission For Year]='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($NxtAdm, "");
							$TotNxtAdm += odbc_result($NxtAdm, "");
						?></td>
						<td align="right"><?php 
							$NxtAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."' ") or exit(odbc_errormsg($conn));
							$NxtTC = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($NxtAcad, "Start Date")."' AND '".odbc_result($NxtAcad, "End Date")."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));							
							echo odbc_result($NxtTC, "");
							$TotNxtTC += odbc_result($NxtTC, "");
						?></td>
						<td align="right">
							<?php
								// Total O/S Calculation
								$FeeSum = 0;
								$FeeNeg = 0;
								$FeePos = 0;
								/*$sql = "SELECT [Customer No_], SUM([Amount]) FROM schoolerp.dbo.[$ms\$Detailed Cust_ Ledg_ Entry] WHERE 
									[Customer No_] IN (SELECT [No_] FROM schoolerp.dbo.[$ms\$Student] WHERE [Student Status]=1)
									GROUP BY [Customer No_] ";*/
								/*
								$sql = "SELECT [Customer No_], SUM([Amount]) FROM schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Detailed Cust_ Ledg_ Entry] WHERE 
									[Customer No_] IN (SELECT [No_] FROM schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Student] WHERE [Student Status]=1)
									GROUP BY [Customer No_] "; 
								*/
								
								$sql = "SELECT [Customer No_], SUM([Amount]) FROM schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Detailed Cust_ Ledg_ Entry] GROUP BY [Customer No_] ";
								$FeeSum = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
								
								while(odbc_fetch_array($FeeSum)){		
									if(odbc_result($FeeSum, "")< 0){
										$FeeNeg += odbc_result($FeeSum, '');
									}
									else{
										$FeePos += odbc_result($FeeSum, '');
									}
								}
								echo number_format($FeePos,2,".",",");
								$TotOS += $FeePos;
							?>
						</td>
					</tr>
					<?php
							$i++;
						}
					?>
					<tr>
						<td colspan="2">TOTAL</td>
						<td align="right"><?php echo $TotStu; ?></td>
						<td align="right"><?php echo $TotPrevAdm; ?></td>
						<td align="right"><?php echo $TotPrevTC; ?></td>
						<td align="right"><?php echo $TotCurrAdm; ?></td>
						<td align="right"><?php echo $TotCurrTC; ?></td>
						<td align="right"><?php echo $TotNxtAdm; ?></td>
						<td align="right"><?php echo $TotNxtTC; ?></td>
						<td align="right"><?php echo number_format($TotOS,2,".",","); ?></td>
					</tr>
					</tbody>
				</table>
			</div>
			<script type="text/javascript">
			function pageload()
			{
			    var after = (new Date()).getTime();
			    var sec = (after-before)/1000;
			    var p = document.getElementById("loadingtime");
			    p.innerHTML = "Page load: " + sec + " seconds.";
				
			}
			</script>
			<p id = "loadingtime"></p>
			
		</div>
 </body>
</html>
<script type="text/javascript">
    window.onload = function () 
    { 
        pageload();
    }
</script>

<?php include('../footer.php');?>