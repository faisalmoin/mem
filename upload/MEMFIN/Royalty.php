
<?php
	//require_once("../db.txt");
	require_once("header.php");
        $CompName = $_REQUEST['CompName'];
	
	$today = strtotime(date('d M Y'));
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	}
	
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
		$Qtr = "Q1";
	}
	//Q2 Calculation
	if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
		$Qtr = "Q2";
	}
	//Q3 Calculation
	if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
		$Qtr = "Q3";
	}
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
		$Qtr = "Q4";
	}
	
	$AgrID = odbc_exec($conn, "SELECT * FROM [Company Information] Where [ID]='$CompName' ") or die(odbc_errormsg($conn));
	$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] where [ID]='".odbc_result($AgrID, "Trust")."' ") or die(odbc_errormsg($conn));
	
?>

 <script type="text/javascript" charset="utf-8">
   $(function(){
	     $("#initialDate").datepicker({
			changeYear: true, 
			changeMonth: true,  
			dateFormat: 'dd/M/yy',
			minDate: '0',
			numberofMonths: '12'
			//yearRange: '<!--?php echo (date('Y')-3).":".(date('Y')-2)?>',  
			//defaultDate: '01/Dec/<--?php echo date('Y')-3;?>' ,
			//minDate: '01/Dec/<--?php echo (date('Y')-3); ?>',
			//maxDate: '30/Nov/<--?php echo (date('Y')-2); ?>'
		});
	});
 </script>
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
			<?php 
				$headcmp = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
			
				
				?>
			
			<div class="container">
			<?php 
			$Check = odbc_exec($conn, "SELECT [Company Name] FROM [Royalty Setup] where [Company Name]='".$_REQUEST['CompName']."' ") or die(odbc_errormsg($conn));
			if(odbc_fetch_row($Check)){
			?>
			<form method="post" action="RoyaltyAdd.php" enctype="multipart/form-data">
			<table width='100%'>
			        <h4>School Information</h4>
		<table class="table table-responsive" style="border: 1px solid #d3d3d3;">
                    <tr>
                    <td style="border: none">School Name</td>
                    <td style="border: none; font-weight: normal;font-size: 18px;" colspan="5"><?php echo strtoupper(odbc_result($AgrID, "Name"))?></td>
                    </tr>
                    <tr>
                    <td style="border: none">Trust Name</td>
                    <td style="border: none; font-weight: normal;" colspan="3"><?php 
                        $Trust = odbc_exec($conn, "SELECT [Trust Name] FROM [CRM Agreement] WHERE [ID]= '".odbc_result($AgrID, "Trust")."'");
                        echo strtoupper(odbc_result($Trust, "Trust Name"))
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">City</td>
                    <td style="border: none"><?php echo strtoupper(odbc_result($AgrID, "City"))?></td>
                    <td style="border: none">State</td>
                    <td style="border: none"><?php echo strtoupper(odbc_result($AgrID, "State"))?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">Brand</td>
                    <td style="border: none"><?php 
                        echo odbc_result($AgrID, "Brand")==1?"TKS":""; 
                        echo odbc_result($AgrID, "Brand")==2?"TMS":""; 
                        echo odbc_result($AgrID, "Brand")==3?"UA":""; 
                        echo odbc_result($AgrID, "Brand")==4?"PSBB MS":""; 
                        echo odbc_result($AgrID, "Brand")==5?"TSMS":""; 
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                </table>
		
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                   <li class="nav-item active">
                     <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Fee Head</a>
                   </li>
                   <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Generated Fee</a>
                   </li>
                   <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages">Collected Fee</a>
                   </li>
                </ul>
                <div class="tab-content">
               <!-------------------------------------------------Fee Head Start--------------------------------------------------------->
                <div class="tab-pane active" id="home" role="tabpanel">
                <tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
                 <?php
                    $c=0;
                    $rs = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($rs)){

                        $td ="";
                        $FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                        $colspan = odbc_num_rows($FeeHead);
                        while(odbc_fetch_array($FeeHead)){
                                $td .= "<th>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
				$c++;
                        }
                        //if(!$FeeHead){die();}
                    ?>
               <table class="table table-responsive " border="1" width="100%" id="abc" class="table table-fixed">
                        <thead>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                                <th rowspan="2" style="text-align: center;">Class</th>
                                <th colspan="<?php echo $colspan; ?>" style="text-align: center;">Student</th>
                                <th colspan="<?php echo $colspan; ?>" style="text-align: center;">Fee Head</th>
                                <th colspan="2" style="text-align: center;" >Total</th>
                        </tr>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                            <th rowspan="2" style="text-align: center;" >NON EWS Student</th>
                                <th rowspan="2" style="text-align: center;" >EWS Student</th>
                                <th rowspan="2" style="text-align: center;" >Total Student</th>
                                <?php echo $td; ?>
                                <th style="text-align: center;">Fee Head Total</th>
                                 <th style="text-align: center;">Yearly Total</th>                                  
                        </tr>
                        </thead>
                        <tbody>

                        <?php 
                                $i=0;
                                $rs1 = odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($rs1)){
                        ?>
                        <tr>
                                <td><?php echo odbc_result($rs1, "Code")?>
                                        <input type="hidden" name="Class<?php echo $i?>" value="<?php echo odbc_result($rs1, "Code")?>" />
                                </td>
                        <?php
                                $j = 0;
                                $rs2 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' ") or die(odbc_errormsg($conn));							
                              							

                                while(odbc_fetch_array($rs2)){
                                    $rs24 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' AND EWS = '0' ") or die(odbc_errormsg($conn));
                        ?>
                                <td><?php echo odbc_result($rs2, "")?>							
                                        <input type="hidden" name="NESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs2, "")?>" />
                                </td>
                                <td><?php echo odbc_result($rs24, "")?>							
                                        <input type="hidden" name="ESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs24, "")?>" />
                                </td>
                                <td><?php echo odbc_result($rs2, "") + odbc_result($rs24, "")?>							
                                        <input type="hidden" name="StuCount<?php echo $i?>" value="<?php echo odbc_result($rs2, "") + odbc_result($rs24, "")?>" />
                                </td>
                        <?php
                                $FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                                $gTotal = 0;
                                $new_amt = 0;
                              
                                while(odbc_fetch_array($FeeHead)){
                                        echo "<td style='text-align: right;'>";
                                        echo '<input type="hidden" name="FeeDesc'.$i.$j.'" value="'.odbc_result($FeeHead, "Fee Description").'" >';

                                        $Check_Fee = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");

                                        if(odbc_num_rows($Check_Fee) != 0){							
                                                $Inv = odbc_exec($conn, "SELECT [Amount] FROM [Class Fee Line] 
                                                        WHERE [Description] = '".ucwords(strtolower(odbc_result($Check_Fee, "Fee Description")))."' 
                                                        AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Academic Year]='$FinYr' ");						
                                          
                                                echo number_format(odbc_result($Inv, "Amount"), "2", ".", "");

                                                $new_amt = odbc_result($Inv, "Amount");
                                                $gTotal += $new_amt;								

                                                echo '<input type="hidden" name="FeeAmt'.$i.$j.'" value="'.odbc_result($Inv, "Amount").'" />';
                                        }
                                        else if(odbc_num_rows($Check_Fee) == 0 || odbc_num_rows($Check_Fee) == ""){
                                                echo "0.00";
                                                echo '<input type="hidden" name="FeeAmt'.$i.$j.'" value="0" />';
                                        }														

                                $j++;
                                echo "</td>";
                                } // Fee Head

                        ?>	
                           <td style='text-align: right;'>
                                        <?php echo number_format($gTotal,2,'.',''); ?>
                                        <input type="hidden" name="TotFee<?php echo $i ?>" value="<?php echo $gTotal; ?>" />
                                </td>
                                  <td  style='text-align: right;'><?php 
                                        echo (odbc_result($rs2, "") + odbc_result($rs24, ""))*$gTotal;
                                        $G_Total += (odbc_result($rs2, "") + odbc_result($rs24, ""))*$gTotal;
                               
                                     //   $NOnEWS += odbc_result($rs2, "");
                                     //   $EWS += odbc_result($rs24, "");
                                     //   $TotalStudent += odbc_result($rs2, "") + odbc_result($rs24, "");
                                     //   $feeAmt +=odbc_result($Inv, "Amount");
                                     //   $gtlt +=$gTotal;
                                        
                                                ?>
                                        <input type="hidden" name="gTotal<?php echo $i ?>" value="<?php echo (odbc_result($rs2, "") + odbc_result($rs24, ""))*$gTotal; ?>" />
                                </td>
                        </tr>
                        <?php
                                                }
                                                $i++;
                                        }
                                        $c++;

                                } // Quarter							
                        ?>
                        <tr style="font-weight: bold;">
				<td>Total</td>
				<td colspan="<?php echo 4+$colspan?>">
				<td style="text-align: right;"><?php echo number_format($G_Total,2,'.',''); ?></td>                                
                        </tr>
                        </tbody>
                </table>
                       
                    
        </td>
        </tr>
           </div>
        
        <!----------------------------------------------Genrated fee start-------------------------------------------------------------->
                <div class="tab-pane" id="profile" role="tabpanel">
                <tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
                <?php
                    $c=0;
                    $rs = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($rs)){

                        $td ="";
                        $FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                        $colspan = odbc_num_rows($FeeHead);
                        while(odbc_fetch_array($FeeHead)){
                                $td .= "<th>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
				$c++;
                        } ?>
               <table class="table table-responsive " border="1" width="100%" id="abc" class="table table-fixed">
                        <thead>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                                <th rowspan="2" style="text-align: center;">Class</th>
                                <th colspan="3" style="text-align: center;">Student</th>
                                <th colspan="<?php echo $c; ?>" style="text-align: center;">Billed</th>
                                 <th rowspan="2" style="text-align: center;">Total Generated Amount</th>
                        </tr>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                            <th  style="text-align: center;" >NON EWS Student</th>
                                <th  style="text-align: center;" >EWS Student</th>
                                <th  style="text-align: center;" >Total Student</th>
                                 <?php echo $td; ?>                                 
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                                $i=0;
                                $rs1 = odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                               
                                while(odbc_fetch_array($rs1)){
                        ?>
                        <tr>
                                <td><?php echo odbc_result($rs1, "Code")?>
                                        <input type="hidden" name="Class1<?php echo $i?>" value="<?php echo odbc_result($rs1, "Code")?>" />
                                </td>
                        <?php
                                $j = 0;
                                $rs2 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' ") or die(odbc_errormsg($conn));							
                                $CheckStu = odbc_exec($conn, "select sum([Student Count]) from [MemFin Royalty Fee] where [Class]='".odbc_result($rs1, "Code")."' AND [Financial Year]='$FinYr' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Invoice Type]='Generated' ") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($rs2)){
                                $rs24 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' AND EWS = '0' ") or die(odbc_errormsg($conn));
                        ?>
                                <td><?php echo odbc_result($rs2, "")?>							
                                        <input type="hidden" name="NESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs2, "")?>" />
                                </td>
                                <td><?php echo odbc_result($rs24, "")?>							
                                        <input type="hidden" name="ESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs24, "")?>" />
                                </td>
                                <td><?php echo (odbc_result($rs2, "") + odbc_result($rs24, ""))-odbc_result($CheckStu, "")?>							
                                        <input type="hidden" name="StuCount1<?php echo $i?>" value="<?php echo (odbc_result($rs2, "") + odbc_result($rs24, ""))-odbc_result($CheckStu, "")?>" />
                                </td>
                     <?php
                                $FeeHead1 = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                                $gTotal1 = 0;
                                $new_amt1 = 0;
                                while(odbc_fetch_array($FeeHead1)){
                                        echo "<td style='text-align: right;'>";
                                        echo '<input type="hidden" name="FeeDescgen'.$i.$j.'" value="'.odbc_result($FeeHead1, "Fee Description").'" >';

                                        $Check_Fee1 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead1, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");

                                        if(odbc_num_rows($Check_Fee1) != 0){
                                          
                                        $Pay = odbc_exec($conn, "select sum([Net Amount]) from [Ledger Invoice] WHERE [FinYr]='$FinYr' AND [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee1, "Fee Description")))." payable' AND [Customer No] IN (SELECT [System Genrated No_] FROM [Temp Application] WHERE [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."') ");
                                        $CheckPay = odbc_exec($conn, "select sum([fee Amount]) from [MemFin Royalty Fee] WHERE [Financial Year]='$FinYr' AND [Fee Description] = '".ucwords(strtolower(odbc_result($Check_Fee1, "Fee Description")))."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Invoice Type]='Generated' ");
                                      // echo "select sum([fee Amount]) from [MemFin Royalty Fee] WHERE [Financial Year]='$FinYr' AND [Fee Description] = '".ucwords(strtolower(odbc_result($Check_Fee1, "Fee Description")))."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Invoice Type]='Generated' ";
                                      echo (number_format(odbc_result($Pay, ""), "2", ".", ""))-(number_format(odbc_result($CheckPay, ""), "2", ".", ""));
                                    // echo odbc_result($CheckPay, "");
                                        $new_amt1 =odbc_result($Pay, "")-odbc_result($CheckPay, "");
                                        $gTotal1 += $new_amt1;
                                                
                                        echo '<input type="hidden" name="FeeAmtgen'.$i.$j.'" value="'.$new_amt1.'" />';
                                        }
                                        else if(odbc_num_rows($Check_Fee1) == 0 || odbc_num_rows($Check_Fee1) == ""){
                                        echo "0.00";
                                        echo '<input type="hidden" name="FeeAmtgen'.$i.$j.'" value="0" />';
                                        }														

                                $j++;
                                echo "</td>";
                                } // Fee Head

                               ?>
                               <td colspan="4" style='text-align: right;'>
                                        <?php echo number_format($gTotal1,2,'.',''); 
                                         $G_Total1 += $gTotal1;
                                        
                               
                                        $NOnEWS1 += odbc_result($rs2, "");
                                        $EWS1 += odbc_result($rs24, "");
                                        $TotalStudent1 += odbc_result($rs2, "") + odbc_result($rs24, "");
                                        $feeAmt1 +=odbc_result($Pay, "");
                                         
                                        ?>
                                        <input type="hidden" name="TotFee1<?php echo $i ?>" value="<?php echo $gTotal1; ?>" />
                                </td>
                        </tr>
                        <?php
                        }
                        $i++;
                        }
                        $c++;
                        } // Quarter							
                        ?>
                        <tr style="font-weight: bold;"><td>Total</td>
			<td colspan="<?php echo (2+$c)?>"></td>
                               <td style="text-align: right;"><?php echo number_format($G_Total1,2,'.',''); ?></td>
                               </tr>
                        </tbody>
                </table>
        </td>
        </tr>
       </div>
        <!---------------------------------------------------Collected fee start--------------------------------------------------------->
                <div class="tab-pane" id="messages" role="tabpanel">
                <tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
               <?php
                    $c=0;
                    $rs = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1 AND [ID]='$CompName'") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($rs)){

                        $td ="";
                        $FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                        $colspan = odbc_num_rows($FeeHead);
                        while(odbc_fetch_array($FeeHead)){
                                $td .= "<th>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
                        }
                   ?>
                <table class="table table-responsive " border="1" width="100%" id="abc" class="table table-fixed">
                        <thead>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                                <th rowspan="2" style="text-align: center;">Class</th>
                                <th colspan="<?php echo $colspan; ?>" style="text-align: center;">Student</th>
                                <th colspan="<?php echo $colspan; ?>" style="text-align: center;">Collected</th>
                                <th colspan="4" style="text-align: center;">Total</th>
                                
                        </tr>
                        <tr style="background-color: #FFC088;" class="statetablerow">
                                <th rowspan="2" style="text-align: center;" >NON EWS Student</th>
                                <th rowspan="2" style="text-align: center;" >EWS Student</th>
                                <th rowspan="2" style="text-align: center;" >Total Student</th>
                                <?php echo $td; ?>
                                <th colspan="4" style="text-align: center;">Collected Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php 
                                $i=0;
                                $rs1 = odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($rs1)){
                        ?>
                        <tr>
                                <td><?php echo odbc_result($rs1, "Code")?>
                                        <input type="hidden" name="Class2<?php echo $i?>" value="<?php echo odbc_result($rs1, "Code")?>" />
                                </td>
                        <?php
                                $j = 0;
                                $rs2 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' ") or die(odbc_errormsg($conn));							
                                $CheckStu1 = odbc_exec($conn, "select sum([Student Count]) from [MemFin Royalty Fee] where [Class]='".odbc_result($rs1, "Code")."' AND [Financial Year]='$FinYr' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Invoice Type]='Collected' ") or die(odbc_errormsg($conn));
                                while(odbc_fetch_array($rs2)){
                                    $rs24 = odbc_exec($conn, "SELECT count([ID]) FROM [Temp Student] WHERE [Class]='".odbc_result($rs1, "Code")."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Admission For Year]='$FinYr' AND [Student Status]='1' AND EWS = '0' ") or die(odbc_errormsg($conn));
                        ?>
                                <td><?php echo odbc_result($rs2, "")?>							
                                        <input type="hidden" name="NESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs2, "")?>" />
                                </td>
                                <td><?php echo odbc_result($rs24, "")?>							
                                        <input type="hidden" name="ESWStuCount<?php echo $i?>" value="<?php echo odbc_result($rs24, "")?>" />
                                </td>
                                <td><?php echo (odbc_result($rs2, "") + odbc_result($rs24, ""))-odbc_result($CheckStu1, "")?>							
                                        <input type="hidden" name="StuCount2<?php echo $i?>" value="<?php echo odbc_result($rs2, "") + odbc_result($rs24, "")?>" />
                                </td>
                        
                     
                     <!---------Collected fee end----------->     

                         <?php
                                $FeeHead2 = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] where [Company Name]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn));
                                $gTotal2 = 0;
                                $new_amt2 = 0;
                                while(odbc_fetch_array($FeeHead2)){
                                        echo "<td style='text-align: right;'>";
                                        echo '<input type="hidden" name="FeeDesccol'.$i.$j.'" value="'.odbc_result($FeeHead2, "Fee Description").'" >';

                                        $Check_Fee2 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead2, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");

                                        if(odbc_num_rows($Check_Fee2) != 0){                                         
                                           $Pay1 = odbc_exec($conn, "select sum([Amount Paid]) from [Ledger Payment] WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee2, "Fee Description")))." payable' AND [Customer No] IN (SELECT [System Genrated No_] FROM [Temp Application] WHERE [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."') AND [Company Name]='$CompName'");
					  $CheckPay1 = odbc_exec($conn, "select sum([fee Amount]) from [MemFin Royalty Fee] WHERE [Financial Year]='$FinYr' AND [Fee Description] = '".ucwords(strtolower(odbc_result($Check_Fee2, "Fee Description")))."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Invoice Type]='Collected' ");
                                         // echo "select sum([fee Amount]) from [MemFin Royalty Fee] WHERE [Financial Year]='$FinYr' AND [Fee Description] = '".ucwords(strtolower(odbc_result($Check_Fee2, "Fee Description")))."' AND [Company Name]='".odbc_result($rs, "ID")."' AND [Class]='".odbc_result($rs1, "Code")."' AND [Invoice Type]='Collected' ";
                                         echo number_format(odbc_result($Pay1, ""), "2", ".", "")-number_format(odbc_result($CheckPay1, ""), "2", ".", "");

                                        $new_amt2 = odbc_result($Pay1, "")-odbc_result($CheckPay1, "");
                                                $gTotal2 += $new_amt2;
                                                
                                                echo '<input type="hidden" name="FeeAmtcol'.$i.$j.'" value="'.$new_amt2.'" />';
                                        }
                                        else if(odbc_num_rows($Check_Fee2) == 0 || odbc_num_rows($Check_Fee2) == ""){
                                                echo "0.00";
                                                echo '<input type="hidden" name="FeeAmtcol'.$i.$j.'" value="0" />';
                                        }														

                                $j++;
                                echo "</td>";
                                } // Fee Head

                        ?>
                         <td colspan="4" style='text-align: right;'>
                           <?php echo number_format($gTotal2,2,'.',''); 
                                 $G_Total2 += $gTotal2;
                                 ?>
                                 <input type="hidden" name="TotFee2<?php echo $i ?>" value="<?php echo $gTotal2; ?>" />
                                </td>
                        </tr>
                        <?php
                          }
                          $i++;
                           }
                          $c++;
                          } // Quarter							
                        ?>
                        <tr style="font-weight: bold;"><td>Total</td>
                                <td colspan="9"><input type="hidden" name="rCount" value="<?php echo ($i-1); ?>" />
                                <input type="hidden" name="cCount" value="<?php echo ($j-1); ?>" /></td>
                                <td colspan="3" style="text-align: right;"><?php echo number_format($G_Total2,2,'.',''); ?></td>
                        </tr>
                        </tbody>
                </table>
        </td>
        </tr
        </div>
        <!--------------------------Collected fee end------------------------->
         </div>
   
       <tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
       <table class="table table-responsive " border="1" width="100%">
                <?php
                $t11 = odbc_exec($conn, "select sum([Net Payble]) from [MemFin Royalty Credit] WHERE [Academic Year]='$FinYr' AND [select Invoice]='Fee Head'");
               $val= $G_Total-odbc_result($t11, "");
               // $t2 = odbc_exec($conn, "select sum([Net Payble]) from [MemFin Royalty Credit] WHERE [Academic Year]='$FinYr' AND [select Invoice]='Generated'");
               //$val1= $G_Total1-odbc_result($t2, "");
                //$t3 = odbc_exec($conn, "select sum([Net Payble]) from [MemFin Royalty Credit] WHERE [Academic Year]='$FinYr' AND [select Invoice]='Collected'");
               //$val2= $G_Total2-odbc_result($t3, "");
                  ?>
               
                 <tr>
              <td><strong>Invoice</strong></td>
              <td>

                <select name="FeeAmonut" id="FeeAmonut" class="form-control" style="width: 180px;padding: 8px;" >                  
                  <option value="">Select</option>
                  <option value="<?php echo number_format($val, "2", ".", ""); ?>">Fee Head</option>
                  <option value="<?php echo number_format($G_Total1, "2", ".", ""); ?>">Generated</option>
                  <option value="<?php echo number_format($G_Total2, "2", ".", ""); ?>">Collected</option>
                  
                </select>
                </td>
            </tr>
            <input type="hidden" class="form-control" name="fee" value="" id="fee" required />
		 <tr>
              <td><strong>Frequency</strong></td>
              <td>

                <select name="Generate" id="Generate" class="form-control" style="width: 180px;padding: 8px;" >                  
                  <!--option value="">Select</option>
                  <option value="1">Yearly</option>
                  <option value="2">Half yearly</option>
                  <option value="4">Quarterly</option>
                  <option value="6">BiMonthly</option>
                  <option value="12">Monthly</option-->
                  <option value="1">Quarterly</option>
                </select>
                </td>
            </tr>

		<tr><td><strong>Invoice Number</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="Invoiceno" value="" required /></td></tr>
		<tr><td><strong>Date</strong></td><td><input style="width: 180px;padding: 8px;" id="initialDate" type="text" class="form-control" name="Date" value="" required /></td></tr>
		<tr><td><strong>Total Amount</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="totalamount" id="totalamount" value="<?php echo $G_Total;?>" /></td></tr>
		<tr><td><strong>Royalty Percentage</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="perRoyalty" id="perRoyalty" value="<?php echo odbc_result($Agreement, "Royaly %");?>"/></td></tr>
		<tr><td><strong>Total Royalty</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="totalRoyalty" id="totalRoyalty" value="<?php echo $G_Total*odbc_result($Agreement, "Royaly %")/100;?>" /><!--p style="color: red;">(<--?php echo odbc_result($Agreement, "Royaly %");?>% Royalty Amount)</p--></td></tr>
		<tr><td><strong>Invoice Amount</td></strong><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="feeamount" id="invAmount" value="" required/></td></tr>
		<tr><td><strong>Discount %</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="discount" id="discount" value="" /></td></tr>
                <tr><td><strong>Discount Description</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="discountdiscription" id="discountdiscription" value=""/></td></tr>
                <tr><td><strong>Discounted Invoice Amount</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="number-only form-control" name="invoicediscount" id="invoicediscount" value=""/></td></tr>
                <tr><td><strong>Service Tax 
		     <?php if(odbc_result($Agreement, "R_Tax") == "1" ) echo " (Exclusive)";
			  if(odbc_result($Agreement, "R_Tax") == "-1" ) echo " (Inclusive)";
			  ?> 
		</strong></td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="netpayble" id="netpayble" value="15%"/></td></tr>
		<tr><td><strong>Taxable Amount</strong> </td><td><input style="width: 180px;padding: 8px;" type="text" name="servisetax" id="servicetax" value="" class="number-only form-control" required/></td></tr>
		<tr><td><strong>Net Payble</strong></td><td><input style="width: 180px;padding: 8px;" type="text" name="payble" id="payble" value="" class="number-only form-control" required/></td></tr>
		 <tr><td><strong>Invoice SoftCopy</strong></td><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>
		<tr><td colspan="2"><strong><button class="btn btn-primary">Submit</button></strong></td></tr>
		</table>

          </td></tr>
			</tbody>
		</table>
		
		
		
		
		 <input type="hidden"  name="TrustName" value="<?php echo odbc_result($Agreement, "Trust Name") ?>" />
           <input type="hidden"  name="ID" value="<?php echo odbc_result($Agreement, "ID") ?>" />
		<input type="hidden" class="form-control" name="companyName" value="<?php echo odbc_result($rs, "ID")?>" /> 
		<input type="hidden" class="form-control" name="FinYr" value="<?php echo $FinYr; ?>" />
                <input type="hidden" class="form-control" name="Qtr" value="<?php echo $Qtr; ?>" />
		<!--input type="hidden" name="count" value="<--?php echo $c;?>"/--> 
							
		</form>
		<?php }
		else {
			?>
			<div class="alert alert-warning" style="text-align: center">
           <p><strong>Kindly Set Up Royalty Fee Components.</strong></p>
           <p><a href="RoyaltySetup02.php?CompName=<?php echo $CompName ?>"><b>Royalty SetUp Link</b></a></p>
            </div>
            
			
		<?php }?>
		</div>
</div>
 <script type="text/javascript">
       
     jQuery(document).ready(function($) {

        var serviceTaxAdjustment = <?php echo json_encode(odbc_result($Agreement, "R_Tax"));?>;

        var netpayble = parseFloat($("#netpayble").val());

        $("form").submit(function(event) {

            
            if(parseFloat($("#invAmount").val())+parseFloat($("#servicetax").val()) != parseFloat($("#payble").val())){
               var choice = confirm("Not correct, still want to do it ?");

               if(!choice){
                 return false;
               }
            }

            /*
            not complete
            if(parseFloat($("#totalamount").val()) == parseFloat($("#totalRoyalty").val())){
                var choice1 = confirm("Amount All Ready Paid");

                if(!choice1){
                  return false;
                }
             }
            */
            
         });


        function updateNetPayable(payble) {
          var invoiceAmount = payble / (1 + netpayble / 100);

          updateInvoiceAmount(invoiceAmount);
        }

        function updatePayble(invoiceAmount, servicetaxValue) {
            invoiceAmount = invoiceAmount || 0;
            servicetaxValue = servicetaxValue || 0;
            var sum = (parseFloat(invoiceAmount) + parseFloat(servicetaxValue)).toFixed(2)
            $("#payble").val(sum);
        }

        function updateServiceTax(invoiceAmount) {
          invoiceAmount = invoiceAmount || 0;
          var servicetaxValue = parseFloat(invoiceAmount * netpayble/100).toFixed(2);
          $("#servicetax").val(servicetaxValue);

          updatePayble(invoiceAmount, servicetaxValue);
        }

        function updateInvoiceAmount(invoiceAmount) {
            invoiceAmount = invoiceAmount || 0;
            var invoiceAmount = parseFloat(invoiceAmount).toFixed(2) ;
            $("#invAmount").val(invoiceAmount);
            updateServiceTax(invoiceAmount);
        }
        
        $("#FeeAmonut").change(function() {
            var value = $(this).val();
            var value1 = $("#FeeAmonut option:selected").text();
             $("#fee").val(value1);
            // $("#FeeAmonut option:selected").text()
            var royalty = value*$("#perRoyalty").val()/100;
           $("#totalRoyalty").val(royalty);

        //  alert(value);

            if(value){
              $("#totalamount").val(value);
              calculate();
            }

            
        });

        function calculate() {

          var value = $("#Generate").val();
           var discount = $("#discount").val();
          var invoiceAmount = 0;
           var invAmount = 0;

            if(value){
                var totalRoyalty = parseFloat($("#totalRoyalty").val());
                invAmount = totalRoyalty / parseFloat(value);
                // invoiceAmount = totalRoyalty / parseFloat(value);
            }
            
              
            if(discount != ""){
               var invoiceAmnt = parseFloat((invAmount* discount)/ 100).toFixed(2)
                 $("#invoicediscount").val(invoiceAmnt);
              invoiceAmount = parseFloat(invAmount-invoiceAmnt).toFixed(2);
            }else{
              invoiceAmount = totalRoyalty / parseFloat(value);
            }

            if(serviceTaxAdjustment == -1){
              updateNetPayable(invoiceAmount);
            }else{
              updateInvoiceAmount(invoiceAmount);
            }
         
        }


        $("#Generate").change(function() {
            calculate();
        });
      
     $("#discount").focusout(function(event) {
           var value = $("#Generate").val();
           
           var discount = $("#discount").val();
          var invoiceAmount = 0;
           var invAmount = 0;

            if(value){
                var totalRoyalty = parseFloat($("#totalRoyalty").val());
                invAmount = totalRoyalty / parseFloat(value);
                // invoiceAmount = totalRoyalty / parseFloat(value);
            }
            
            if(discount != ""){
              var invoiceAmnt = parseFloat((invAmount* discount)/ 100).toFixed(2)
              $("#invoicediscount").val(invoiceAmnt);   
            invoiceAmount = parseFloat(invAmount-invoiceAmnt).toFixed(2);
            }else{
              invoiceAmount = totalRoyalty / parseFloat(value);
            }
         
           if(serviceTaxAdjustment == -1){
              updateNetPayable(invoiceAmount);
            }else{
              updateInvoiceAmount(invoiceAmount);
            }
            //  updateInvoiceAmount(invoiceAmount);

        });
 
        
/*
        $("#Generate").change(function() {
            var value = $(this).val();

            var invoiceAmount = 0;

            if(value){
                var totalRoyalty = parseFloat($("#totalRoyalty").val());
                invoiceAmount = totalRoyalty / parseFloat(value);
            }

            if(serviceTaxAdjustment == -1){
              updateNetPayable(invoiceAmount);
            }else{
              updateInvoiceAmount(invoiceAmount);
            }
            
        });*/

        /*       
         $("#invAmount").focusout(function(event) {
              var invoiceAmount = parseFloat($(this).val()).toFixed(2) || 0;

              updateInvoiceAmount(invoiceAmount);
        });

        $("#servicetax").focusout(function(event) {
              var servicetaxValue = parseFloat($(this).val()).toFixed(2);

              var invoiceAmount = parseFloat((servicetaxValue * 100) / netpayble).toFixed(2);
              
              updateInvoiceAmount(invoiceAmount);

        });

        $("#payble").focusout(function() {
            var payble = parseFloat($(this).val()).toFixed(2);

            updateNetPayable(payble);
            
        });
        */

        $('.number-only').keypress(function(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
              return false;
            }

            return true;
        });

     });

     </script>
<?php require_once("../footer.php"); ?>
	