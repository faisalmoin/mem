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
	 <style>
      
        td {
            margin:0;
            border-top-width:0px; 
            white-space:nowrap;
        }
        div { 
            
            margin-left:12em; 
            padding-bottom:1px;
           }
        .headcol {
            position:absolute; 
            width:5em; 
            left:0;
            top:auto;
            border-right: 0px none black; 
            border-top-width:3px; /*only relevant for first row*/
            margin-top:-3px; /*compensate for top border*/
        }
        .headcol:before {content: '';}
        .long { background:yellow; letter-spacing:1em; }
        </style>
      
        <script>
        function myFunction() {
            alert("The form was submitted");
        }
</script>
	
	<style id="jsbin-css">		
		table.floatThead-table {
			border-top: none;
			border-bottom: none;
			background-color: #fff;
		}
		</style>
                        <style>
            .wrap {
            width: 852px;
        }

        .wrap table {
            width: 800px;
            table-layout: fixed;
        }

        .inner_table {
            height: 100px;
            overflow-y: auto;
        }
    </style>
	</head>
        <form action="" method="post">
	<body oncontextmenu="return true">
		<div class="container" >
                    <div>
                        <table>
                            <tr><td colspan="3" class="headcol">&nbsp;From Date:<?php echo $frmdate= date('d/M/y', strtotime(str_replace('-', '/', $frmdate)));  ?></td></tr>
                            <tr><td style="width:10%" class="headcol"><br/>&nbsp;To Date&emsp;&nbsp;:<?php echo $todate= date('d/M/y', strtotime(str_replace('-', '/', $todate))); ?></td>
                                <td style="width:20%"><h2><u>Admission Dashboard</u></h2></td>
                                <td style="width:40%" align="right">Date:<?php echo  date('d/M/y');  ?></td>
                            </tr>
                        </table>
                    </div>
			<div class="table-responsive">          
                            <table  class="table" style="font-size: 10px;" >  

                                <tr style="font-size: 12px;" style="height:10px;">
                                            <td rowspan="" style="width:50px;" class="headcol"><b>Sr No.</b>
                                               &nbsp;&nbsp;&nbsp;&nbsp;<b>Location</b>
                                            </td>
                                            <td colspan=2 align="center" style="background: #dca7a7"></td>
                                            <td colspan=2 align="center" style="background: #dca7a7"></td>
                                            <td colspan=8 align="left" style="background: #dca7a7"><b><?php echo substr(date('Y'),0,2).$ac1; ?></b></td>
                                            <td colspan=12 align="center" style="background:  #7cbcd6"><b><?php echo substr(date('Y'),0,2).$ac2; ?></b></td>
					          
					</tr>  
                                           <tr>
                                            
                                             <td rowspan="" style="width:50px;" class="headcol">
                                                      &nbsp;
                                             </td>
                                    
                                              
                                             <td style="background: #dca7a7"  align="center"><b>Enquiry</b></td>
                                             <td style="background: #dca7a7"  align="center">Registration</td>
                                             <td style="background: #dca7a7" colspan="8" align="center">Admission</td>
                                               
                                             <td style="background: #7cbcd6" colspan="2" align="center"><b>Enquiry</b></td>
                                             <td style="background: #7cbcd6" colspan="2" align="center">Registration</td>
                                             <td style="background: #7cbcd6" colspan="8" align="center">Admission</td>
					          
					</tr>
                                        <tr>
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
                                             $todate = date("Y-m-t", strtotime($day_date));
                                            
                                        }
                                        
                                        ?>
                                          
                                             <td rowspan="" style="width:50px;" class="headcol">
                                                      &nbsp;
                                             </td>
                                    
                                              
					      
					      <td style="background: #dca7a7">Total in session</td>
                                              
                                              <td style="background: #dca7a7">Total in session</td>
                                               
                                              <td style="background: #dca7a7">Total Target</td>
                                               <td style="background: #dca7a7">Target in date range</td>
                                               <td style="background: #dca7a7">Admission in date range</td>
                                               <td style="background: #dca7a7">Total Admission</td>
                                               <td style="background: #dca7a7">Total Withdrawal</td>
                                               <td style="background: #dca7a7">YTD Target</td>
                                               <td style="background: #dca7a7">Net Admission</td>
                                               <td style="background: #dca7a7">Total Student Strength</td>
                                               
                                               <td style="background: #7cbcd6">Total in date range</td>
					      <td style="background: #7cbcd6">Total in session</td>
                                              <td style="background: #7cbcd6">Total in date</td>
                                              <td style="background: #7cbcd6">Total in session</td>
                                               <td style="background: #7cbcd6">Total Target</td>
                                               <td style="background: #7cbcd6">Target in date range</td>
                                               <td style="background: #7cbcd6">Admission in date range</td>
                                               <td style="background: #7cbcd6">Total Admission</td>
                                               <td style="background: #7cbcd6">Total Withdrawal</td>
                                               <td style="background: #7cbcd6">YTD Target</td>
                                               <td style="background: #7cbcd6">Net Admission</td>
                                               <td style="background: #7cbcd6">Total Student Strength</td>
					          
					</tr>
					<tr>
					<?php
                                     
						$i=1;
						//Distinct Company
					        $Comp = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [Temp Student] WHERE [Company Name] NOT LIKE 'Training%'  ORDER BY [Company Name] ASC") or exit(odbc_errormsg($conn));
					    	$tot=0; $tot1=0; $tot2=0; $tot3=0;$tot4=0;$tot5=0; $tot6=0; $tot7=0;
                                                $tot8=0;$tot9=0; $tot10=0;$tot11=0;$tot12=0;$tot13=0; $tot14=0; $tot15=0;
                                                $tot16=0;
                                                $tot17=0;
                                                $tot18=0;
                                                $tot19=0;
                                                $tot20=0;
                                                $tot21=0;
                                                $tot22=0;
                                                $tot23=0;
                                                while(odbc_fetch_array($Comp)){
							$AdmVar = 0;
							$WDVar = 0;
							$AdmVar1 = 0;
							$WDVar1 = 0;
                                                  
							 
					?>
                                        <tr style="height:10px;" style="overflow-y:scroll;">
                                                <td rowspan="" style="width:50px;" class="headcol"><b><?php echo $i; ?></b>
                                                   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo odbc_result($Comp, "Company Name"); ?></b>
                                                </td>
                                    
						
                                                
                                                <td align="center" style="background: #dca7a7"><?php 
                                                        $prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit(odbc_errormsg($conn));
                                                        $CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit(odbc_errormsg($conn));
                                                        $NextAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."'") or exit(odbc_errormsg($conn));
                                                        //echo "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'";
                                                        //$totalInRange = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'") or exit(odbc_errormsg($conn));
                                                        $totalInRange = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($totalInRange, "");
                                                        $count1 = odbc_result($totalInRange, "");
                                                        $tot1 = $tot1+$count1;
						?></td>
                                               
                                                <td align="center" style="background: #dca7a7"><?php                                                         
                                                        $regsTotalInSession = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($regsTotalInSession, "");
                                                             $count3 = odbc_result($regsTotalInSession, "");
                                                             $tot3 = $tot3+$count3;
						?></td>
						
                                                <td align="center" style="background:#dca7a7"><?php
                                               // echo "SELECT SUM([Total Addmissions]) From school_test.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry]WHERE [Academic Year]='$ac1'";
							$CurrTarget = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From school_test.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo round(odbc_result($CurrTarget, ""),0);
                                                        $count4= round(odbc_result($CurrTarget, ""),0);
                                                        $tot4 = $tot4+$count4;
						     ?>
                                                </td>
                                                <td align="center" style="background: #dca7a7"><?php                                                         
							$CurrTargetDate = odbc_exec($conn, "SELECT [Total Addmissions] From school_test.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac1' AND [From Date]='$frmdate' AND [To Date]='$todate' ") or exit(odbc_errormsg($conn));
							echo round(odbc_result($CurrTargetDate, ""),0);
							 $count5 = round(odbc_result($CurrTargetDate, ""),0);
                                                        $tot5 = $tot5+$count5;
                                                        ?>
						</td>
                                                <td align="center" style="background: #dca7a7"> <?php                                                         
                                                        $admsnInDate = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInDate, "");
                                                         $count6 = odbc_result($admsnInDate, "");
                                                             $tot6 = $tot6+$count6;
						?></td>                                                       
                                                <td align="center" style="background: #dca7a7"> <?php                            							
                                                        $admsnInSession = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'  AND [Admission For Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInSession, "");
							$AdmVar += odbc_result($admsnInSession, "");
                                                         $count7 = odbc_result($admsnInSession, "");
                                                             $tot7 = $tot7+$count7;
						?></td>     
						<td align="center" style="background: #dca7a7"> <?php                            
							$StuWD = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status] <> 1 AND [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($StuWD, "");
							$WDVar += odbc_result($StuWD, "");
                                                         $count8 = odbc_result($StuWD, "");
                                                             $tot8 = $tot8+$count8;
						?></td>     
						<td style="background: #dca7a7" align="center">
						<?php
							$CurrYTD = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."'  AND '".date('Y-m-d')."' AND [Academic Year]='$ac1' ") or exit(odbc_errormsg($conn));
							echo odbc_result($CurrYTD, '');
                                                         $count9 = odbc_result($CurrYTD, "");
                                                             $tot9 = $tot9+$count9;
						?>
						</td>
						<td align="center" style="background: #dca7a7"> <?php                            
							echo ($AdmVar-$WDVar);
                                                        $tot10=($AdmVar-$WDVar);
                                                        $tot10=$tot10+$tot10;
                                                        // $count10 = odbc_result($StuWD, "");
                                                          //   $tot10 = $tot9+$count10;
						?></td>    
						<td align="center" style="background: #dca7a7"> <?php                            							
                                                        $TotStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Academic Year]='".$ac1."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
							echo odbc_result($TotStu, "");
                                                         $count11 = odbc_result($TotStu, "");
                                                             $tot11 = $tot11+$count11;
						?></td> 
                                                
                                                
                                                
                                                
                                                
                                                 <td align="center" style="background: #7cbcd6"><?php 
                                                        $totalInDate = odbc_exec($conn, "SELECT COUNT([Type Of Enquiry]) FROM [Temp Enquiry] WHERE  [Enquiry Date]>='$frmdate' and [Enquiry Date]<='$todate'  AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($totalInDate, "");
                                                         $count12 = odbc_result($totalInDate, "");
                                                        $tot12 = $tot12+$count12;
						?></td>
                                                <td align="center" style="background: #7cbcd6"><?php 
                                                        $prevAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac0."' ") or exit(odbc_errormsg($conn));
                                                        $CurrAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac1."' ") or exit(odbc_errormsg($conn));
                                                        $NextAcad = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Code]='".$ac2."'") or exit(odbc_errormsg($conn));
                                                        //echo "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'";
                                                        //$totalInRange = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."'AND [Enquiry Date] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."'") or exit(odbc_errormsg($conn));
                                                        $totalInRange = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($totalInRange, "");
                                                        $count13 = odbc_result($totalInRange, "");
                                                        $tot13 = $tot13+$count13;
						?></td>
                                                <td align="center" style="background: #7cbcd6"><?php 
                                                        $regsTotalInDATE = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($regsTotalInDATE, "");
                                                        $count14 = odbc_result($regsTotalInDATE, "");
                                                        $tot14= $tot14+$count14;
						?></td>
                                                <td align="center" style="background: #7cbcd6"><?php                                                         
                                                        $regsTotalInSession = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Application] WHERE [Date of Sale] BETWEEN '".odbc_result($NextAcad, 'Start Date')."' AND '".odbc_result($NextAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'") or exit(odbc_errormsg($conn));
							echo odbc_result($regsTotalInSession, "");
                                                             $count15 = odbc_result($regsTotalInSession, "");
                                                             $tot15 = $tot15+$count15;
						?></td>
						
                                                
                                                
						
						<td align="center" style="background:#7cbcd6"><?php
							$NxtTarget = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From school_test.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo round(odbc_result($NxtTarget, ""),0);
                                                            $count16 = round(odbc_result($NxtTarget, ""),0);
                                                             $tot16= $tot16+$count16;
						     ?>
                                                </td>
                                                <td align="center" style="background: #7cbcd6"><?php                                                         
							$NxtTargetDate = odbc_exec($conn, "SELECT [Total Addmissions] From school_test.dbo.[".odbc_result($Comp, "Company Name")."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' AND [From Date]='$frmdate' AND [To Date]='$todate' ") or exit(odbc_errormsg($conn));
							echo round(odbc_result($NxtTargetDate, ""),0);
                                                             $count17 = round(odbc_result($NxtTargetDate, ""),0);
                                                             $tot17= $tot17+$count17;
							?>
						</td>
                                                <td align="center" style="background: #7cbcd6"> <?php                                                         
                                                      $admsnInDate1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '$frmdate' AND '$todate' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInDate1, "");
                                                         $count18 = odbc_result($admsnInDate1, "");
                                                             $tot18 = $tot18+$count18;
						?></td>                                                       
                                                <td align="center" style="background: #7cbcd6"> <?php                            							
                                                      $admsnInSession1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."'  AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($admsnInSession1, "");
							$AdmVar1 += odbc_result($admsnInSession1, "");
                                                         $count19 = odbc_result($admsnInSession1, "");
                                                             $tot19 = $tot19+$count19;
						?></td>     
						<td align="center" style="background: #7cbcd6"> <?php                            
							$StuWD1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Date of Leaving] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."' AND '".odbc_result($CurrAcad, 'End Date')."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Student Status] <> 1 AND [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($StuWD1, "");
							$WDVar1 += odbc_result($StuWD1, "");
                                                         $count20 = odbc_result($StuWD1, "");
                                                             $tot20 = $tot20+$count20;
						?></td>     
						<td style="background: #7cbcd6" align="center">
						<?php
							$NxtYTD = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".odbc_result($Comp, "Company Name")."' AND [Date Joined] BETWEEN '".odbc_result($CurrAcad, 'Start Date')."'  AND '".date('Y-m-d')."' AND [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
							echo odbc_result($NxtYTD, '');
                                                        $count21 = odbc_result($NxtYTD, "");
                                                             $tot21= $tot21+$count21;
						?>
						</td>
						<td align="center" style="background: #7cbcd6"> <?php                            
							echo ($AdmVar1-$WDVar1);
                                                        $tots=($AdmVar1-$WDVar1);
                                                        $tot22=$tot22+$tots;
						?></td>    
						<td align="center" style="background: #7cbcd6"> <?php                            							
                                                        $TotStu1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status]=1 AND [Academic Year]='".$ac2."' AND [Company Name]='".odbc_result($Comp, "Company Name")."' ") or exit(odbc_errormsg($conn));
							echo odbc_result($TotStu1, "");
                                                         $count23 = odbc_result($TotStu1, "");
                                                             $tot23 = $tot23+$count23;
						?></td>  
					</tr>
					<?php
							$i++;
						}
					?>
                                        <tr>
                                            
                                            <td align="center" class="headcol">Total</td> 
                                            <td align="center"> <?php echo $tot1?></td>
                                            <td align="center"> <?php echo $tot3 ?></td>
                                            <td align="center"> <?php echo $tot4 ?></td>
                                            <td align="center"> <?php echo $tot5 ?></td>
                                            <td align="center"><?php echo $tot6; ?></td>
                                            <td align="center"> <?php echo $tot7 ?></td>
                                            <td align="center"> <?php echo $tot8;  ?></td>
                                            <td align="center"><?php  echo $tot9; ?></td>
                                            <td align="center"> <?php echo $tot10; ?></td>
                                            <td align="center"> <?php echo $tot11; ?></td>
                                            <td align="center"><?php echo $tot12; ?></td>
                                            <td align="center"> <?php echo $tot13;  ?></td>
                                            <td align="center"> <?php echo $tot14; ?></td>
                                            <td align="center"><?php  echo $tot15;?></td>
                                            <td align="center"> <?php echo $tot16;?></td>
                                            <td align="center"> <?php  echo $tot17;?></td>
                                            <td align="center"><?php echo $tot18; ?></td>
                                            <td align="center"> <?php echo $tot19; ?></td>
                                            <td align="center"> <?php echo $tot20;?></td>
                                            <td align="center"><?php echo $tot21;?></td>
                                            <td align="center"> <?php echo $tot22;?></td>
                                            <td align="center"> <?php echo $tot23; ?></td>
                                            
                                        </tr>
					</tbody>
                            </table>  
			</div>
		</div>
 </body>
        </form>
</html>



