<?php
	require_once("../db.txt");
	require_once "Mail.php";
	
	//Academic Year
        $AcadStartDate = (date(Y)-2)."-".date('m-d');
        $AcadEndDate = (date(Y)+1)."-".date('m-d');
        $a=0;
        $AcadYr = odbc_exec($conn, "SELECT DISTINCT TOP 3 [Code] FROM [Academic Year] WHERE ([Start Date] BETWEEN '$AcadStartDate' AND '$AcadEndDate') ORDER BY [Code] ASC") or exit(odbc_errormsg($conn));
        while(odbc_fetch_array($AcadYr)){
                echo "";
                        if($a==0) {
                                $ac0= odbc_result($AcadYr, "Code");
                        }
                        if($a==1) {
                                $ac1= odbc_result($AcadYr, "Code");
                        }
                        if($a==2) {
                                $ac2= odbc_result($AcadYr, "Code");
                        }
                //echo "".odbc_result($AcadYr, "Code")."</td>";								
                $a++;
        }
	
	$today=date('d');
	if($today<=15)
	{
	    $frmdate=date('Y-m-')."1";
	    $todate=date('Y-m-')."15";
	 
	}
	else{
	     $frmdate=date('Y-m-')."16";
	     $day_date=date('Y-m-d');
	     $todate = date("Y-m-d", strtotime($day_date));	    
	} 
	
	//Date of Leaving, get Year
	$dl0 = (date("Y")-2);
	$dl1 = (date("Y")-1);
	$dl2 = (date("Y")-0);
	
	$body = "
	
	<!DOCTYPE html>
	<html>
		<head>
			<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 10px;
				}
				table td {
					width: 160px;
					height: 40px;
					border: 1px solid #d3d3d3;
					font-size: 10px;
				}
				
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
		</head>
		<body>			
			<table width='100%'>
				<thead>
				<tr>
					<td style='width:20%;  border: none;' align='center' colspan='26'><h2>Admission Dashboard</h2></td>
					
				<tr>
					<td colspan='15' style='height:40px; border: none;'>
						Report Date: ".date('d/M/Y', strtotime($frmdate))." - ".date('d/M/Y', strtotime($todate))."
					</td>		
					<td colspan='6' style='height:40px; border: none; text-align: right' >
						Dated: ".date('d/M/Y')."
					</td>		
				</tr>
				<tr>
					<td rowspan='3' style='height:40px;'>S/N</td>
					<td rowspan='3' style='height:40px;'>Company Name</td>
					<td colspan='9' align='center' style='background: #D8F6CE; height: 40px;'>".substr(date('Y'),0,2).$ac1."</td>
					<td colspan='9' align='center' style='background:  #F5D0A9; height: 40px;'>".substr(date('Y'),0,2).$ac2."</td>					          
				</tr>  
				<tr>
					<td style='background: #D8F6CE; height: 40px;' align='center'>Enquiry</td>
					<td style='background: #D8F6CE; height: 40px;' align='center'>Registration</td>
					<td style='background: #D8F6CE; height: 40px;' colspan='7' align='center'>Admission</td>
				       
					<td style='background: #F5D0A9' align='center'>Enquiry</td>
					<td style='background: #F5D0A9' align='center'>Registration</td>
					<td style='background: #F5D0A9' colspan='7' align='center'>Admission</td>					          
				</tr>
				
				<tr>";
						$today=date('d');
						if($today<=15)
						{
							$frmdate=date('Y-m-')."01";
							$todate=date('Y-m-')."15";                                           
						}
						else{
							$frmdate=date('Y-m-')."16";
							$day_date=date('Y-m-d');
							$todate = date("Y-m-d", strtotime($day_date));                                            
						}                                        
                                        
					
				$body .=	"<td style='background: #D8F6CE' align='center'>Total in session</td>					
					<td style='background: #D8F6CE' align='center'>Total in session</td>                                               
					<td style='background: #D8F6CE' align='center'>Total Target</td>
					<td style='background: #D8F6CE' align='center'>Total Admission</td>
					<td style='background: #D8F6CE' align='center'>Total Inactive</td>
					<td style='background: #D8F6CE' align='center'>Total TC</td>
					<td style='background: #D8F6CE' align='center'>Total Withdrawal</td>
					<td style='background: #D8F6CE' align='center'>Net Admission</td>
					<td style='background: #D8F6CE' align='center'>Total Student Strength</td>
                                               
					
					<td style='background: #F5D0A9' align='center'>Total in session</td>					
					<td style='background: #F5D0A9' align='center'>Total in session</td>
					<td style='background: #F5D0A9' align='center'>Total Target</td>					
					<td style='background: #F5D0A9' align='center'>Total Admission</td>
					<td style='background: #F5D0A9' align='center'>Total Inactive</td>
					<td style='background: #F5D0A9' align='center'>Total TC</td>
					<td style='background: #F5D0A9' align='center'>Total Withdrawal</td>
					<td style='background: #F5D0A9' align='center'>Net Admission</td>
					<td style='background: #F5D0A9' align='center'>Total Student Strength</td>					          
				</tr>
				</thead>";
					
						$i=1;
						//Distinct Company
					        $Comp = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [Temp Student] WHERE [Company Name] NOT LIKE 'Training%'  ORDER BY [Company Name] ASC") or exit(odbc_errormsg($conn));
					    	$tot=0; $tot1=0; $tot2=0; $tot3=0;$tot4=0;$tot5=0; $tot6=0; $tot7=0;
                                                $tot8=0;$tot9=0; $tot10=0;$tot11=0;$tot12=0;$tot13=0; $tot14=0; $tot15=0;
                                                $tot16=0; $tot17=0; $tot18=0; $tot19=0; $tot20=0; $tot21=0; $tot22=0; $tot23=0;
						
                                                while(odbc_fetch_array($Comp)){
							$AdmVar = 0;
							$WDVar = 0;
							$AdmVar1 =0;
							$WDVar1 = 0;
                                                  
							$prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit(odbc_errormsg($conn));
                                                        $CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit(odbc_errormsg($conn));
                                                        $NextAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."'") or exit(odbc_errormsg($conn));

                                                         
					
				$body .= "<tr style='height:10px;' style='overflow-y:scroll;'>
					<td height='40px'>".$i."</td>
					<td>".odbc_result($Comp, "Company Name")."</td>";
					// Previous Academic Year 
						$totalEnquiry0 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac0' ") or exit(odbc_errormsg($conn));
						//$TotReg0 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac0' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
						$TotReg0 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year] ='$ac0' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Registration Status]=1") or exit(odbc_errormsg($conn));
						$TotTarget0 = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac0' ") or exit(odbc_errormsg($conn));
						$TotAdm0 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac0' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$TotInactive0 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl0."-01-01' AND '".$dl0."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$TotTC0 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl0."-01-01' AND '".$dl0."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$TotWD0 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl0."-01-01' AND '".$dl0."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$NetAdm0 = (round(odbc_result($TotAdm, ""),0)-(round(odbc_result($TotTC, ""),0) + round(odbc_result($TotInactive, ""),0)));
						$TotStu0 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Academic Year]='$ac0' AND [Student Status]=1  ") or exit(odbc_errormsg($conn));
						
						//INSERT INTO MySQL Table `director_rpt` Current Acad Yr.
						mysql_query("INSERT INTO `director_rpt` SET 
							`rpt_date`='".date('Y-m-d')."',
							`AcadYr`='".$ac0."',
							`CompanyName`='".odbc_result($Comp, "Company Name")."',
							`Enquiry`='".odbc_result($totalEnquiry0, "")."',
							`Registration`='".odbc_result($TotReg0, "")."',
							`Target`='".round(odbc_result($TotTarget0, ""),0)."',
							`TotAdm`='".round(odbc_result($TotAdm0, ""),0)."',
							`TotInactive`='".round(odbc_result($TotInactive0, ""),0)."',
							`TotTC`='".round(odbc_result($TotTC0, ""),0)."',
							`TotWithdrawal`='".round(odbc_result($TotWD0, ""),0)."',
							`NetAdm`='".(round(odbc_result($TotAdm0, ""),0)-(round(odbc_result($TotTC0, ""),0) + round(odbc_result($TotInactive0, ""),0)))."',
							`TotStudent`='".round(odbc_result($TotStu0, ""),0)."',
							`FeesOS`='0'					
						") or die(mysql_error());

						
				$body .= "<!-- Current Academic Year -->
					<td align='center' style='background: #D8F6CE'>";
						$totalEnquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($totalEnquiry, "");						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						//$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
						$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year] ='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Registration Status]=1") or exit(odbc_errormsg($conn));
						$body .=  odbc_result($TotReg, "");
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotTarget = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
						$body .=  round(odbc_result($TotTarget, ""),0);	
						$tot0 = $tot0 + round(odbc_result($TotTarget1, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .=  round(odbc_result($TotAdm, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						//$TotInactive = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Academic year]='$ac1' AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$TotInactive = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .=  round(odbc_result($TotInactive, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotTC = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotTC, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotWD = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotWD, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$body .= (round(odbc_result($TotAdm, ""),0)-(round(odbc_result($TotTC, ""),0) + round(odbc_result($TotInactive, ""),0)));
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Academic Year]='$ac1' AND [Student Status]=1  ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotStu, ""),0);
				$body .= "</td>";
				//Fees Oustanding 
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
				//echo number_format($FeePos,2,".",",");
				//$TotOS += $FeePos;
				
				
				//INSERT INTO MySQL Table `director_rpt` Current Acad Yr.
				mysql_query("INSERT INTO `director_rpt` SET 
					`rpt_date`='".date('Y-m-d')."',
					`AcadYr`='".$ac1."',
					`CompanyName`='".odbc_result($Comp, "Company Name")."',
					`Enquiry`='".odbc_result($totalEnquiry, "")."',
					`Registration`='".odbc_result($TotReg, "")."',
					`Target`='".round(odbc_result($TotTarget, ""),0)."',
					`TotAdm`='".round(odbc_result($TotAdm, ""),0)."',
					`TotInactive`='".round(odbc_result($TotInactive, ""),0)."',
					`TotTC`='".round(odbc_result($TotTC, ""),0)."',
					`TotWithdrawal`='".round(odbc_result($TotWD, ""),0)."',
					`NetAdm`='".(round(odbc_result($TotAdm, ""),0)-(round(odbc_result($TotTC, ""),0) + round(odbc_result($TotInactive, ""),0)))."',
					`TotStudent`='".round(odbc_result($TotStu, ""),0)."',
					`FeesOS`='".$FeePos."'					
				") or die(mysql_error());

				// Next Academic Year 
				$body .= "<td style='background: #F5D0A9' align='center'>";
						$totalEnquiry1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($totalEnquiry1, "");						
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						//$TotReg1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
						$TotReg1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year] ='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Registration Status]=1") or exit(odbc_errormsg($conn));
						$body .= odbc_result($TotReg1, "");
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotTarget1 = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotTarget1, ""),0);	
						$tot1 = $tot1 + round(odbc_result($TotTarget1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotAdm1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotAdm1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						//$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Academic Year]='$ac2' AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotInactive1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotTC1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotTC1, ""),0);
				$body .= "</td>
					<td align='center' style='background: #F5D0A9'>";
						$TotWD1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotWD1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$body .= (round(odbc_result($TotAdm1, ""),0)-(round(odbc_result($TotTC1, ""),0) + round(odbc_result($TotInactive1, ""),0)));
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						//$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Academic Year] IN ('$ac1','$ac2') AND [Student Status]=1  ") or exit(odbc_errormsg($conn));
						$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status]=1  ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotStu1, ""),0);
				$body .= "</td></tr>";
				
				//INSERT INTO MySQL Table `director_rpt` Next Acad Yr.
				mysql_query("INSERT INTO `director_rpt` SET 
					`rpt_date`='".date('Y-m-d')."',
					`AcadYr`='".$ac2."',
					`CompanyName`='".odbc_result($Comp, "Company Name")."',
					`Enquiry`='".odbc_result($totalEnquiry1, "")."',
					`Registration`='".odbc_result($TotReg1, "")."',
					`Target`='".round(odbc_result($TotTarget1, ""),0)."',
					`TotAdm`='".round(odbc_result($TotAdm1, ""),0)."',
					`TotInactive`='".round(odbc_result($TotInactive1, ""),0)."',
					`TotTC`='".round(odbc_result($TotTC1, ""),0)."',
					`TotWithdrawal`='".round(odbc_result($TotWD1, ""),0)."',
					`NetAdm`='".(round(odbc_result($TotAdm1, ""),0)-(round(odbc_result($TotTC1, ""),0) + round(odbc_result($TotInactive1, ""),0)))."',
					`TotStudent`='".round(odbc_result($TotStu1, ""),0)."',
					`FeesOS`='0'					
				") or die(mysql_error());
				
						$i++;
					}
				$body .= "
				<tr>
					<td colspan='2'>TOTAL</td>
					<!-- Total Current Academic Year -->
					<td align='center' style='background: #D8F6CE'>";
						$totalEnquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year]='$ac1' AND [Company Name] NOT LIKE 'Training%' ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($totalEnquiry, "");						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac1' AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($TotReg, "");
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						/*$TotTarget = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
						echo round(odbc_result($TotTarget, ""),0);						*/
						$body .= $tot0;
						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac1' AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotAdm, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						//$TotInactive = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Academic Year]='$ac1' AND [Student Status]=2 AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$TotInactive = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotInactive, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotTC = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotTC, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotWD = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name] NOT LIKE 'Training%' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotWD, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$body .= (round(odbc_result($TotAdm, ""),0)-(round(odbc_result($TotTC, ""),0) + round(odbc_result($TotInactive, ""),0)));
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE  [Academic Year]='$ac1' AND [Student Status]=1 AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotStu, ""),0);
				$body .= "</td>
					
					<!-- Total Next Academic Year -->
					<td style='background: #F5D0A9' align='center'>";
						$totalEnquiry1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE  [Admission For Year]='$ac2' AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($totalEnquiry1, "");						
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotReg1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac2' AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$body .= odbc_result($TotReg1, "");
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						/*$TotTarget1 = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
						echo round(odbc_result($TotTarget1, ""),0);						*/
						$body .= $tot1;
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotAdm1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac2' AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotAdm1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						//$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Academic Year]='$ac2' AND [Student Status]=2  AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2  AND [Company Name] NOT LIKE 'Training%'  ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotInactive1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotTC1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=3 AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotTC1, ""),0);
				$body .= "</td>
					<td align='center' style='background: #F5D0A9'>";
						$TotWD1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name] NOT LIKE 'Training%' ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotWD1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$body .= (round(odbc_result($TotAdm1, ""),0)-(round(odbc_result($TotTC1, ""),0) + round(odbc_result($TotInactive1, ""),0)));
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						//$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE  [Academic Year] IN ('$ac1','$ac2') AND [Student Status]=1 AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE  [Student Status]=1 AND [Company Name] NOT LIKE 'Training%'   ") or exit(odbc_errormsg($conn));
						$body .= round(odbc_result($TotStu1, ""),0);
				$body .= "</td>
				</tr>
			</table>
		</body>
	</html>";
	
	//Email Addresses
	//$to = "kulkirti.dewan@educomp.com, vikram.puri@educomp.com, anoop.bharti@educompschools.com, prabhakar.cs@educomp.com, pallab.db@educomp.com";
	$to = "kulkirti.dewan@educomp.com, anoop.bharti@educompschools.com, prabhakar.cs@educomp.com, pallab.db@educomp.com";
	$from = "SchoolERP <schoolerp@educompschools.com>";
	$subject = "SchoolERP // Admission Dashboard // Dated: ".date('d-M-Y');
	//exit($body);
	
	require_once("../smtp.php");

?>