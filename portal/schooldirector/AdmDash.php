<?php

	require_once("header.php");
			
	//Academic Year
        $AcadStartDate = (date(Y)-2)."-".date('m-d');
        $AcadEndDate = (date(Y)+1)."-".date('m-d');
        $a=0;
	
	$today = strtotime(date('Y-m-d'));
        $this_yr = strtotime(date("Y")."-04-01");
        $nxt_yr = strtotime((date("Y")+1)."-03-31");
	
	if($today > strtotime(date("Y")."-04-01") && $today < strtotime((date("Y")+1)."-03-31")){
		$ac0 = (date('y')-1) ."-".date('y');
		$ac1 = date('y')."-".(date('y')+1);
		$ac2 = (date('y')+1)."-".(date('y')+2);
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
	     $d = new DateTime( date('Y-m-d') ); 
		$todate = $d->format( 'Y-m-t' );
	     //$todate = date("Y-m-t", strtotime($day_date));	    
	} 
	
	//Date of Leaving, get Year
	$dl0 = (date("Y")-2);
	$dl1 = (date("Y")-1);
	$dl2 = (date("Y")-0);
	
	$body = "
	
			<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 13px;
					padding: 0px;
				}
				table td {
					width: 160px;
					height: 40px;
					border: 1px solid #d3d3d3;
					font-size: 13px;
				}
				
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
			
			<table width='100%'>
				<tr style='background-color: #0080cc'>
					<td style='padding: 15px;  border: none;'>
						<h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						Admission Dashboard
						</h2>
					</td>
					<td style='padding: 15px; border: none;' valign='top'>
	
						<div class = 'dropdown' align='right'>

							<span type = 'button' class = 'btn dropdown-toggle' id = 'dropdownMenu1' data-toggle = 'dropdown''>
								<span style='font-size: 24px; font-weight: bold; color: #ffffff'>&#8226; &#8226; &#8226; </span>
							</span>

							<ul class = 'dropdown-menu pull-right' role = 'menu' aria-labelledby = 'dropdownMenu1' >
								<li role = 'presentation'>
									<a role = 'menuitem' tabindex = '-1' href = 'Home.php'>Home</a>
								</li>
								<li role = 'presentation'>
									<a role = 'menuitem' tabindex = '-1' href = 'AdmDash.php'>Admission Report</a>
								</li>
								<li role = 'presentation'>
									<a role = 'menuitem' tabindex = '-1' href = 'Royalty.php'>Royalty</a>
								</li>
								<li role = 'presentation' class = 'divider'></li>
								<li role = 'presentation'>
									<a role = 'menuitem' tabindex = '-1' href = '#'>
										Change Password
									</a>
								</li>
								<li role = 'presentation'>
									<a role = 'menuitem' tabindex = '-1' href = '../logout.php?id=<?php echo $LoginID?>' >Logout</a>
								</li>
							</ul>

						</div>
				</td></tr>
				<tr><td colspan='2' style='padding: 25px; border: none;'>";
		//Start of Admission Dashboard
		$body .="<table width='100%'>
				<thead>
				<tr>
					<td colspan='15' style='height:40px; border: none;'>
						Report Date: ".date('d/M/Y', strtotime($frmdate))." - ".date('d/M/Y', strtotime($todate))."
					</td>		
					<td colspan='6' style='height:40px; border: none; text-align: right' >
						Dated: ".date('d/M/Y')."
					</td>		
				</tr>
				<tr style='font-weight: bold;'>
					<td rowspan='3' style='height:40px;'>S/N</td>
					<td rowspan='3' style='height:40px;' width='250px'>Company Name</td>
					<td colspan='8' align='center' style='background: #D8F6CE; height: 40px;'>".substr(date('Y'),0,2).$ac1."</td>
					<td colspan='8' align='center' style='background:  #F5D0A9; height: 40px;'>".substr(date('Y'),0,2).$ac2."</td>					          
				</tr>  
				<tr style='font-weight: bold;'>
					<td style='background: #D8F6CE; height: 40px;' align='center'  rowspan='2'>Enquiry</td>
					<td style='background: #D8F6CE; height: 40px;' align='center' rowspan='2'>Registration</td>
					<td style='background: #D8F6CE; height: 40px;' colspan='6' align='center'>Admission</td>
				       
					<td style='background: #F5D0A9' align='center' rowspan='2'>Enquiry</td>
					<td style='background: #F5D0A9' align='center' rowspan='2'>Registration</td>
					<td style='background: #F5D0A9' colspan='6' align='center'>Admission</td>					          
				</tr>
				
				<tr style='font-weight: bold;'>";
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
                                        
					
				$body .=	"<td style='background: #D8F6CE' align='center'>Total Admission</td>
					<td style='background: #D8F6CE' align='center'>Total Inactive</td>
					<td style='background: #D8F6CE' align='center'>Total TC</td>
					<td style='background: #D8F6CE' align='center'>Total Withdrawal</td>
					<td style='background: #D8F6CE' align='center'>Net Admission</td>
					<td style='background: #D8F6CE' align='center'>Total Student Strength</td>
                                               
					
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
					        $Comp = odbc_exec($conn, "SELECT [ID] AS [Company Name] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName' ORDER BY [ID] ASC") or exit("Line 139");
						
					    	$tot=0; $tot1=0; $tot2=0; $tot3=0;$tot4=0;$tot5=0; $tot6=0; $tot7=0;
                                                $tot8=0;$tot9=0; $tot10=0;$tot11=0;$tot12=0;$tot13=0; $tot14=0; $tot15=0;
                                                $tot16=0; $tot17=0; $tot18=0; $tot19=0; $tot20=0; $tot21=0; $tot22=0; $tot23=0;
						
                                                while(odbc_fetch_array($Comp)){
							$AdmVar = 0;
							$WDVar = 0;
							$AdmVar1 =0;
							$WDVar1 = 0;
                                                  
							$prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit("Line 151");
                                                        $CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit("Line 152");
                                                        $NextAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."'") or exit("Line 153");

                                                         
					
				$body .= "<tr style='height:10px;' style='overflow-y:scroll;'>
					<td height='40px'>".$i."</td>
					<td>";
						$comp_name = odbc_exec($conn, "SELECT [Name] FROM [Company Information] WHERE [ID]='".odbc_result($Comp, "Company Name")."'") or die("Line 159");						
				$body .=odbc_result($comp_name, "Name")."</td>";					
				$body .= "<!-- Current Academic Year -->
					<td align='center' style='background: #D8F6CE'>";
						$totalEnquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit("Line 162");
						$body .= odbc_result($totalEnquiry, "");						
				$body .= "</td>
						
					<td align='center' style='background: #D8F6CE'>";
						$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit("Line 167");
						$body .=  odbc_result($TotReg, "");
				$body .= "<td align='center' style='background: #D8F6CE'>";
						$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 170");
						$body .=  round(odbc_result($TotAdm, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotInactive_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit("Line 174");
						$TotInactive_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 175");
						$TotInactive = round(odbc_result($TotInactive_2, ""),0)-round(odbc_result($TotInactive_1, ""),0);
						$body .= $TotInactive;
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotTC_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 180");
						$TotTC_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 181");
						$TotTC = (round(odbc_result($TotTC_2, ""),0) - round(odbc_result($TotTC_1, ""),0));
						$body .= $TotTC;
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotWD = $TotInactive+$TotTC;
						$body .= round($TotWD,0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$body .= (round(odbc_result($TotAdm, ""),0)-(round($TotWD,0)));
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
								
					//Get Ednd Date
					$End_date = odbc_exec($conn, "SELECT [End Date] FROM [Academic Year] WHERE [Code]='".$ac1."'") or die("Line 195");
					if(strtotime(date('Y-m-d')) > strtotime(odbc_result($End_date, "End Date"))){
						$TotStu1 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Admission For Year] <> '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or die("Line 197");
						$TotStu2 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] <> '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date of Leaving] BETWEEN '01/Jan/".date('Y')."' AND '31/Dec/".date('Y')."' ") or die("Line 198");
						$TotStu3 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date of Leaving] BETWEEN '01/Jan/". (date('Y')-1)."' AND '31/Dec/".(date('Y')-1)."' ") or die("Line 199");
						$TotStu = (odbc_result($TotStu1, "")+odbc_result($TotStu2, "")-odbc_result($TotStu3, ""));
						
						$body .= round($TotStu,0);
					}
					else{
						$TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Academic Year]='$ac1' AND [Student Status]=1  ") or exit("Line 205");
						$body .= round(odbc_result($TotStu, ""),0);
					  }
				$body .= "</td>";
				
				// Next Academic Year 
				$body .= "<td style='background: #F5D0A9' align='center'>";
						$totalEnquiry1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac2' ") or exit("Line 212");
						$body .= odbc_result($totalEnquiry1, "");						
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotReg1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 216");
						$body .= odbc_result($TotReg1, "");
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotAdm1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 220");
						$body .= round(odbc_result($TotAdm1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";						
						$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 224");
						$body .= round(odbc_result($TotInactive1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotTC1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 228");
						$body .= round(odbc_result($TotTC1, ""),0);
				$body .= "</td>
					<td align='center' style='background: #F5D0A9'>";
						$TotWD1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 232");
						$body .= round(odbc_result($TotWD1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$body .= (round(odbc_result($TotAdm1, ""),0)-(round(odbc_result($TotTC1, ""),0) + round(odbc_result($TotInactive1, ""),0)));
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status]=1  ") or exit("Line 239");
						$body .= round(odbc_result($TotStu1, ""),0);
				$body .= "</td></tr>";
				
						$i++;
					}
				$body .= "
				
						
				<tr style='font-weight: bold;'>
					<td colspan='2'>TOTAL</td>
					<!-- Total Current Academic Year -->						
					<td align='center' style='background: #D8F6CE'>";
						$totalEnquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Admission For Year]='$ac1' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')  ") or exit("Line 253");
						$body .= odbc_result($totalEnquiry, "");						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac1' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName') ") or exit("Line 257");
						$body .= odbc_result($TotReg, "");
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac1' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')    ") or exit("Line 261");
						$body .= round(odbc_result($TotAdm, ""),0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotInactive_1a = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Admission For Year] = '$ac2' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')   ") or exit("Line 265");
						$TotInactive_2a = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')   ") or exit("Line 262");
						$TotInactive_T=  round(odbc_result($TotInactive_2a, ""),0)-round(odbc_result($TotInactive_1a, ""),0);
						
						$body .= $TotInactive_T;
						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotTC_1a = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Admission For Year] = '$ac2' AND [Company Name] IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$COmpName') ") or exit("Line 273");
						$TotTC_2a = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Company Name] IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName') ") or exit("Line 274");
						$TotTC_T=  round(odbc_result($TotTC_2a, ""),0)-round(odbc_result($TotTC_1a, ""),0);
						$body .= round($TotTC_T,0);
						
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$TotWD = $TotInactive_T + $TotTC_T;
						$body .= round($TotWD,0);
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						$body .= (round(odbc_result($TotAdm, ""),0) - round($TotWD,0));
				$body .= "</td>
					<td align='center' style='background: #D8F6CE'>";
						//Get Ednd Date
					$End_date = odbc_exec($conn, "SELECT [End Date] FROM [Academic Year] WHERE [Code]='".$ac1."'") or die("Line 288");
					if(strtotime(date('Y-m-d')) > strtotime(odbc_result($End_date, "End Date"))){
						$TotStu1 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Admission For Year] <> '$ac2' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName') ") or die("Line 290");
						$TotStu2 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] <> '$ac2' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')  AND [Date of Leaving] BETWEEN '01/Jan/".date('Y')."' AND '31/Dec/".date('Y')."' ") or die("Line 291");
						$TotStu3 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] = '$ac2' AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')  AND [Date of Leaving] BETWEEN '01/Jan/". (date('Y')-1)."' AND '31/Dec/".(date('Y')-1)."' ") or die("Line 292");
						$TotStu = (odbc_result($TotStu1, "")+odbc_result($TotStu2, "")-odbc_result($TotStu3, ""));
						
						$body .= round($TotStu,0);
					}
					else{
						$TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1  AND [ID]='$CompName')  AND [Academic Year]='$ac1' AND [Student Status]=1  ") or exit("Line 298");
						$body .= round(odbc_result($TotStu, ""),0);
					  }		
				$body .= "</td>
					
					<!-- Total Next Academic Year -->
					<td style='background: #F5D0A9' align='center'>";
						$totalEnquiry1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE  [Admission For Year]='$ac2' AND [Company Name] IN (SELECT [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName' ) ") or exit("Line 305");
						$body .= odbc_result($totalEnquiry1, "");						
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotReg1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac2' AND [Company Name] IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1  AND [ID]='$CompName')  ") or exit("Line 309");
						$body .= odbc_result($TotReg1, "");
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotAdm1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac2' AND [Company Name] IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName' )    ") or exit("Line 313");
						$body .= round(odbc_result($TotAdm1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotInactive1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2  AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName' )   ") or exit("Line 317");
						$body .= round(odbc_result($TotInactive1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotTC1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND [Student Status]=3 AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')    ") or exit("Line 321");
						$body .= round(odbc_result($TotTC1, ""),0);
				$body .= "</td>
					<td align='center' style='background: #F5D0A9'>";
						$TotWD1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl2."-01-01' AND '".$dl2."-12-31') AND ([Student Status]=2 OR [Student Status]=3) AND [Company Name]  IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')  ") or exit("Line 325");
						$body .= round(odbc_result($TotWD1, ""),0);
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$body .= (round(odbc_result($TotAdm1, ""),0)- ((round(odbc_result($TotTC1, ""),0) + round(odbc_result($TotInactive1, ""),0))));
				$body .= "</td>
					<td style='background: #F5D0A9' align='center'>";
						$TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE  [Student Status]=1 AND [Company Name] IN (SELECT [ID]  FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName')  ") or exit("Line 332");
						$body .= round(odbc_result($TotStu1, ""),0);
				$body .= "</td>
				</tr>
			</table> </td></tr></table>
		";
		
	echo($body);
	
	require_once("footer.php");
?>
