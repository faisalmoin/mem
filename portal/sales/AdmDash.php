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
?>
<div class="container">
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
				<thead>
				<tr style='background-color: #0080cc'>
					<td style='padding: 15px;  border: none;' colspan="10">
						<h2 style='color: #ffffff;'>
						Admission Dashboard
						</h2>
					</td>					
				</tr>
				<tr style='font-weight: bold; background: #FFFFFF;'>
					<td rowspan='3' style='height:40px;text-align: center;'>S/N</td>
					<td rowspan='3' style='height:40px;' width='250px'>Company Name</td>
					<td colspan='8' align='center' style='background: #FFFFFF; height: 40px;'><?php echo substr(date('Y'),0,2).$ac1 ?></td>		          
				</tr>  
				<tr style='font-weight: bold; background: #FFFFFF;'>
					<td style='background: #FFFFFF; height: 40px;' align='center'  >Enquiry</td>
					<td style='background: #FFFFFF; height: 40px;' align='center' >Registration</td>
				
				<?php
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
				?>
					<td style='background: #FFFFFF' align='center'>Total Admission</td>
					<td style='background: #FFFFFF' align='center'>Total Inactive</td>
					<td style='background: #FFFFFF' align='center'>Total TC</td>
					<td style='background: #FFFFFF' align='center'>Total Withdrawal</td>
					<td style='background: #FFFFFF' align='center'>Net Admission</td>
					<td style='background: #FFFFFF' align='center'>Total Student Strength</td>                                               
				</tr>
				</thead>
				<?php
						$i=1;
						//Distinct Company
					        $Comp = odbc_exec($conn, "SELECT [ID] AS [Company Name] FROM [Company Information] WHERE [Company Status]=1 AND [ID] <> '2'   ORDER BY [ID] ASC") or exit("Line 139");
						
					    	$tot=0; $tot1=0; $tot2=0; $tot3=0;$tot4=0;$tot5=0; $tot6=0; $tot7=0;
                                                $tot8=0;$tot9=0; $tot10=0;$tot11=0;$tot12=0;$tot13=0; $tot14=0; $tot15=0;
                                                $tot16=0; $tot17=0; $tot18=0; $tot19=0; $tot20=0; $tot21=0; $tot22=0; $tot23=0;
						
                                                while(odbc_fetch_array($Comp)){
							$AdmVar = 0;
							$WDVar = 0;
							$AdmVar1 =0;
							$WDVar1 = 0;
                                                  
							$CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit("Line 152");
                                                         
				?>	
				<tr style='height:10px;' style='overflow-y:scroll;'>
					<td height='40px' style='background: #FFFFFF;text-align: center;'><?php echo $i?></td>
					<td  style='background: #FFFFFF;'>
					<?php
						$comp_name = odbc_exec($conn, "SELECT [Name] FROM [Company Information] WHERE [ID]='".odbc_result($Comp, "Company Name")."'") or die("Line 159");
						echo odbc_result($comp_name, "Name");					
					?>
					</td>
					
					<!-- Current Academic Year -->
					<td align='center' style='background: #FFFFFF'>
					<?php
						$totalEnquiry = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit("Line 162");
						echo odbc_result($totalEnquiry, "");
						$tot14 += odbc_result($totalEnquiry, "");
					?>
					</td>						
					<td align='center' style='background: #FFFFFF'>
					<?php
						$TotReg = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Admission For Year] ='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit("Line 167");
						echo  odbc_result($TotReg, "");
						$tot15 += odbc_result($TotReg, "");
					?>
					<td align='center' style='background: #FFFFFF'>
					<?php
						$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$ac1' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 170");
						echo  round(odbc_result($TotAdm, ""),0);
						$tot16 += round(odbc_result($TotAdm, ""),0);
					?>
					</td>
					<td align='center' style='background: #FFFFFF'>
					<?php
						$TotInactive_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit("Line 174");
						$TotInactive_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=2 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 175");
						$TotInactive = round(odbc_result($TotInactive_2, ""),0)-round(odbc_result($TotInactive_1, ""),0);
						echo $TotInactive;
						$tot17 += $TotInactive;
					?>
					</td>
					<td align='center' style='background: #FFFFFF'>
					<?php
						$TotTC_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 180");
						$TotTC_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".$dl1."-01-01' AND '".$dl1."-12-31') AND [Student Status]=3 AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit("Line 181");
						$TotTC = (round(odbc_result($TotTC_2, ""),0) - round(odbc_result($TotTC_1, ""),0));
						echo $TotTC;
						$tot18 += $TotTC;
					?>
					</td>
					<td align='center' style='background: #FFFFFF'>
					<?php
						$TotWD = $TotInactive+$TotTC;
						echo round($TotWD,0);
						$tot19 += round($TotWD,0);
					?>
					</td>
					<td align='center' style='background: #FFFFFF'>
					<?php
						echo (round(odbc_result($TotAdm, ""),0)-(round($TotWD,0)));
						$tot20 += (round(odbc_result($TotAdm, ""),0)-(round($TotWD,0)));
					?>
					</td>
					<td align='center' style='background: #FFFFFF'>
						<a href="StuStrength.php?c=<?php echo odbc_result($Comp, "Company Name")?>&y=<?php echo $ac1?>" style="color: #2874a6; ">
						<?php
						//Get Ednd Date
						$End_date = odbc_exec($conn, "SELECT [End Date] FROM [Academic Year] WHERE [Code]='".$ac1."'") or die("Line 195");
						if(strtotime(date('Y-m-d')) > strtotime(odbc_result($End_date, "End Date"))){
							$TotStu1 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Admission For Year] <> '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or die("Line 197");
							$TotStu2 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] <> '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date of Leaving] BETWEEN '01/Jan/".date('Y')."' AND '31/Dec/".date('Y')."' ") or die("Line 198");
							$TotStu3 = odbc_exec($conn, "SELECT count([No_]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Admission For Year] = '$ac2' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date of Leaving] BETWEEN '01/Jan/". (date('Y')-1)."' AND '31/Dec/".(date('Y')-1)."' ") or die("Line 199");
							$TotStu = (odbc_result($TotStu1, "")+odbc_result($TotStu2, "")-odbc_result($TotStu3, ""));
							
							echo round($TotStu,0);
							$tot21 += round($TotStu,0);
						}
						else{
							$TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Academic Year]='$ac1' AND [Student Status]=1  ") or exit("Line 205");
							echo round(odbc_result($TotStu, ""),0);
							$tot21 += round(odbc_result($TotStu, ""),0);
						  }
						  
						?>
						</a>
					</td>
				</tr>	
				<?php 
						$i++;
					} 
				?>
				<tr  style='font-weight: bold; background: #808b96;color: #ffffff;'>
					<td colspan='2'>TOTAL</td>
					<!-- Total Current Academic Year -->						
					<td align='center'>
					<?php
						echo $tot14;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot15;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot16;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot17;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot18;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot19;
					?>
					</td>
					<td align='center'>
					<?php
						echo $tot20;
					?>
					</td>
					<td align='center' style='font-size: 18px;'>
					<?php
						echo $tot21;
					?>
					</td>					
				</tr>
			</table>
	
</div>		
<?php
	require_once("footer.php");
?>
