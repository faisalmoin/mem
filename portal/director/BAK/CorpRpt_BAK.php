<?php 
	include('../db.txt');
        
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
        
        
  
        
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="../favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Educomp School Portal</title>
    
	<!-- Bootstrap core CSS -->
	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="../bs/js/jquery-1.10.2.js"></script>
	<script src="../bs/js/jquery-ui.js"></script>
	
	<script src="../bs/logout.js"></script>
	
	<script>
function myFunction() {
    alert("The form was submitted");
}
</script>
	<script>
		function BrowserDetection() {
			if (navigator.userAgent.search("Firefox") >= 0) {
			
			}
			else{
				window.location.assign("BrowserCheck.php");
			}
		}
	</script>
	
	<style id="jsbin-css">		
		table.floatThead-table {
			border-top: none;
			border-bottom: none;
			background-color: #fff;
		}
		</style>	
	</head>
        <form action="" method="post">
	<body oncontextmenu="return true" onload="BrowserDetection();" >
		<div class="container" >
			<div class="table-responsive">          
                            <table id="myTable" class="table table-striped table-bordered" style="font-size: 10px;">  

					<tr style="font-size: 12px;">
					      <td rowspan="2">Sr No.</td>
					      <td rowspan="2">Location</td>
					      <td colspan=6 align="center">Enquiries</td>
                                              <td colspan=2 align="center">Registrations</td>
                                              <td colspan=8 align="center"><?php echo substr(date('Y'),0,2).$ac1; ?></td>
                                              <td colspan=8 align="center"><?php echo substr(date('Y'),0,2).$ac2; ?></td>
					          
					</tr>                                        
                                        <tr>
                                            <?php 
                                     
                                            
                                        $today=date('d');
                                        if($today<=15)
                                        {
                                            $frmdate=date('Y-m-')."1";
                                            $todate=date('Y-m-')."15";
                                           
                                        }
                                        else{
                                             $frmdate=date('Y-m-')."16";
                                             $day_date=date('Y-m-d');
                                             $todate = date("Y-m-t", strtotime($day_date));
                                            
                                        }
                                        
                                        ?>
					      <td>E-Mail</td>
					      <td>Walk-In</td>
					      <td>Phone</td>
                                               <td>Com-conct</td>
					      <td>Total in date range</td>
					      <td>Total in session</td>
                                              <td>Total in date</td>
                                              <td>Total in session</td>
                                               
                                              <td>Total Target</td>
                                               <td>Target in date range</td>
                                               <td>Admission in date range</td>
                                               <td>Total Admission</td>
                                               <td>Total Withdrawal</td>
                                               <td>YTD Target</td>
                                               <td>Net Admission</td>
                                               <td>Total Student Strength</td>
                                               
                                               <td>Total Target</td>
                                               <td>Target in date range</td>
                                               <td>Admission in date range</td>
                                               <td>Total Admission</td>
                                               <td>Total Withdrawal</td>
                                               <td>YTD Target</td>
                                               <td>Net Admission</td>
                                               <td>Total Student Strength</td>					          
					</tr>
					<tr>
					<?php
                                     
						$i=1;
						//Distinct Company
					        $Comp = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [Temp Student] WHERE [Company Name] NOT LIKE 'Training%'  ORDER BY [Company Name] ASC") or exit(odbc_errormsg($conn));
					    						
                                                while(odbc_fetch_array($Comp)){
							$AdmVar = 0;
							$WDVar = 0;
							$AdmVar1 = 0;
							$WDVar1 = 0;
							
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo odbc_result($Comp, "Company Name"); ?></td>
						<td align="right"><?php 
                                                        $eMail = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE [Type Of Enquiry]='E-MAIL' AND [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate'  AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($eMail, "");
						?></td>
                                                <td align="right"><?php 
                                                        $walkIn = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE [Type Of Enquiry]='WALK-IN' AND [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($walkIn, "");
						?></td>
                                                <td align="right"><?php 
                                                        $phone = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE [Type Of Enquiry]='PHONE' AND [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($phone, "");
						?></td>
                                                <td align="right"><?php 
                                                        $comConct = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE [Type Of Enquiry]='COM_CONCT'AND [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate'  AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($comConct, "");
						?></td>
                                                <td align="right"><?php 
                                                        $totalInDate = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE  [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate'  AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($totalInDate, "");
						?></td>
                                                <td align="right"><?php 
                                                        $prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit(odbc_errormsg($conn));
                                                        $CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit(odbc_errormsg($conn));
                                                        $NextAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."'") or exit(odbc_errormsg($conn));
                                                        //echo "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'";
                                                        $totalInRange = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'") or exit(odbc_errormsg($conn));
							echo odbc_result($totalInRange, "");
						?></td>
                                                <td align="right"><?php 
                                                        $regsTotalInDATE = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($regsTotalInDATE, "");
						?></td>
                                                <td align="right"><?php                                                         
                                                        $regsTotalInSession = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($regsTotalInSession, "");
						?></td>
						
                                                <td align="right">                                                      
                                                       &nbsp;
						</td>
                                                <td align="right">                                                         
                                                       &nbsp;
						</td>
                                                <td align="right"> <?php                                                         
                                                        $admsnInDate = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInDate, "");
						?></td>                                                       
                                                <td align="right"> <?php                            							
                                                        $admsnInSession = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'  AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInSession, "");
							$AdmVar += odbc_result($admsnInSession, "");
						?></td>     
						<td align="right"> <?php                            
							$StuWD = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status] <> 1 AND [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($StuWD, "");
							$WDVar += odbc_result($StuWD, "");
						?></td>     
						<td>
						</td>
						<td align="right"> <?php                            
							echo ($AdmVar-$WDVar);
						?></td>    
						<td align="right"> <?php                            							
                                                        $TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Academic Year]='".$ac1."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
							echo odbc_result($TotStu, "");
						?></td>  
						
						<td align="right">                                                      
                                                       &nbsp;
						</td>
                                                <td align="right">                                                         
                                                       &nbsp;
						</td>
                                                <td align="right"> <?php                                                         
                                                        $admsnInDate1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInDate1, "");
						?></td>                                                       
                                                <td align="right"> <?php                            							
                                                        $admsnInSession1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'  AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInSession1, "");
							$AdmVar1 += odbc_result($admsnInSession1, "");
						?></td>     
						<td align="right"> <?php                            
							$StuWD1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status] <> 1 AND [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($StuWD1, "");
							$WDVar1 += odbc_result($StuWD1, "");
						?></td>     
						<td>
						</td>
						<td align="right"> <?php                            
							echo ($AdmVar1-$WDVar1);
						?></td>    
						<td align="right"> <?php                            							
							//echo "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Academic Year]='".$ac2."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ";
                                                        $TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) AS [Count] FROM [Temp Student] 
								WHERE [Student Status]=1 
								AND [Academic Year]='".$ac2."' 
								AND [Company Name]='". odbc_result($Comp, "Company Name") ."' ") or exit(odbc_errormsg($conn));
							echo odbc_result($TotStu1, 'Count');
						?></td>  
					</tr>
					<?php
							$i++;
						}
					?>
					</tbody>
			</div>
		</div>
 </body>
        </form>
</html>

