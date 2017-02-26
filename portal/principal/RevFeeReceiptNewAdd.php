<?php require_once("header.php");?>
	
	<!---------------------------------- step process-------------------- -->
	<style>
	
	.stepwizard-step p {
		margin-top: 10px;
	}
	.stepwizard-row {
		display: table-row;
	}
	.stepwizard {
		display: table;
		width: 50%;
		position: relative;
	}
	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}
	.stepwizard-row:before {
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
	}
	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}
	</style>
	
	<?php
	require_once("../ConvertNum2Words.php");
        echo "<br/><br/><br/>";
      //  print_r($_POST);
       // die();
	//Invoice Date
	$inv_dt = time();
	
	//Quarter calculation
	$qDate = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='$AcadYear' AND [Company Name]='$ms'");
	$q1Sdt = strtotime(odbc_result($qDate, "Start Date"));
	$q1Edt = strtotime("+3 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q2Sdt = strtotime("+3 months", strtotime(odbc_result($qDate, "Start Date")));
	$q2Edt = strtotime("+6 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q3Sdt = strtotime("+6 months", strtotime(odbc_result($qDate, "Start Date")));
	$q3Edt = strtotime("+9 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q4Sdt = strtotime("+9 months", strtotime(odbc_result($qDate, "Start Date")));
	$q4Edt = strtotime(odbc_result($qDate, "Start Date"));
	//echo $q1Edt;
	//Get Quarter as per current date
	
	if($inv_dt >= $q1Sdt && $inv_dt <= $q1Edt ) {$Qtr = 2;}
	elseif($inv_dt >= $q2Sdt && $inv_dt <= $q2Edt ) {$Qtr = 3;}
	elseif($inv_dt >= $q3Sdt && $inv_dt <= $q3Edt ) {$Qtr = 4;}
	elseif($inv_dt >= $q4Sdt && $inv_dt <= $q4Edt ) {$Qtr = 5;}
	else{
		$Qtr = 2;
	}
	

?>
<!------------------------------------------------------------------------------>
<div class="container">	
	<h1 class="text-primary">Admission<small> - Fees &#38; Discount</small></h1>
 	
 	 <!---------------------------------- step process-------------------- -->
  <div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        <a href="#step-1" type="button" class="btn btn-default btn-circle" disabled="disabled">1</a>
        <p style="font-weight: bold; color:red;">Information</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
        <p style="font-weight: bold; color:red;">Fee & Discount</p>
      </div>
      <div class="stepwizard-step">
        
        <a href="#step-3" type="button" class="btn btn-primary btn-circle">3</a>
        <p style="font-weight: bold; color:red;">Confirm</p>
      </div>
      
      </div>
  </div>
  
  
   <!---------------------------------- step process-------------------- -->
 	
 	<div class="tab-content" id="StuTabContent">
				
		<div class="tab-pane face in active" id="StuTab2" >
			<table id="results2" class="table table-responsive" hidden="true">
	<tr style="font-weight: bold;">
		<td style="text-align: center;">SN</td>
		<td>Description</td>
		<td>Amount</td>
		<td style="text-align:center">Discounted Amount</td>
		<td style="text-align:center">Net Payable Amount</td>
	</tr>
	
	<?php
	        $cust_no=$_REQUEST['ID'];
                $InvoiceNo=$_REQUEST['invoice'];
                $InvDate= $_REQUEST['InvDate'];
              //  $inv=$_REQUEST['PostingNo'];
               // $inv=512;
                $seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
                $inv1 = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
                $inv_no = str_pad($inv1, 10, "0", STR_PAD_LEFT );
                
		$today = $inv_dt;
		$this_yr = strtotime(date("Y", $today)."-04-01");
		$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
		
		$this_yr = strtotime(date("Y", $today)."-04-01");
		$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
		
		//Financial Year Calculation
		  if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
            $FinYr = date('y', $today)."-".(date('y', $today)+1);
        } else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
            $FinYr = (date('y', $today)-1)."-".date('y', $today);
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
		
		//Half Yearly Calculation
		
		//H1 Calculation
		if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-09-30")){
		    $Hfl = "H1";
		}
		//H2 Calculation
		if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-03-31")){
		    $Qtr = "H2";
		}
                //------------------------------Invocie Delete Start---------------------------------------------------------
                
                for($m=0; $m<=$_REQUEST['InvoiceID'.$m]; $m++){
               if($InvoiceNo!="" && $cust_no!="" && $_REQUEST['InvoiceID'.$m]!=""){
                $LedInvUpdate= "UPDATE [Ledger Invoice] SET [Reverse]=1 WHERE [Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Invoice No] ='$InvoiceNo' AND [ID] =".$_REQUEST['InvoiceID'.$m]." ";
               odbc_exec($conn, $LedInvUpdate) or exit(odbc_errormsg($conn));
                }
                }
                if($InvoiceNo!="" && $cust_no!=""){
                $LedCreUpdate= "UPDATE [Ledger Credit] SET [Reverse]=1 WHERE [Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Invoice No] ='$InvoiceNo' ";
               odbc_exec($conn, $LedCreUpdate) or exit(odbc_errormsg($conn));
                }
                
        //-------------------------------------------------------------------------------------------------------  
        $chk_debit = odbc_exec($conn, "SELECT * FROM [Ledger Debit] WHERE 
						[Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Invoice No] ='$InvoiceNo' ");
          
	$chk_dr = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE 
						[Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Invoice No] ='$InvoiceNo' ");
       
	$Description =  "Reverse" . odbc_result($chk_dr, "Description");
	$credit_amt = odbc_result($chk_dr, "Credit Amount");
	
	$post1 = odbc_result($chk_dr, 'Posting No') + 1;
	$post2 = odbc_result($chk_dr, 'Posting No') + 2;
	//$a=odbc_num_rows($chk_dr);	
	//echo $a;
	//Check Payment Amount with Invoice Amount
        if(odbc_num_rows($chk_debit)==0)
	{
		
		//Adjusting with invoice
		$sqlDebit = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr], [Reverse])
				VALUES(
				'".odbc_result($chk_dr, 'Invoice Date')."', '".odbc_result($chk_dr, 'Invoice No')."', '".$cust_no."',
				'$Description',  ".$credit_amt.", ".$credit_amt.",
				'$inv_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 1, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '$inv_dt', $post1, 0 ,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',1 )";
		       odbc_exec($conn, $sqlDebit) or exit(odbc_errormsg($conn));
		
                }
                else{
                $adv_amt=odbc_result($chk_debit, "Credit Amount");  
                $sqlAdvance = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'', '', '".$cust_no."',
				'Advance Fee',  0, 0,
				'$inv_dt', 'Reverce', '$bank_name', '$chk_no', '$chk_dt', 0, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '', $post2, $adv_amt,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";   
               
                odbc_exec($conn, $sqlAdvance) or exit(odbc_errormsg($conn));  
                
                $sqlDebit1= "UPDATE [Ledger Debit] SET [Reverse]=1, [Remarks]='Reverse', [Realization Date]='$inv_dt', [Payment Realization]=1, [Description]='$Description' WHERE [Customer No] = '$cust_no'
                                                   AND [Company Name]='$ms' AND 
                                                   [Invoice No] ='$InvoiceNo' ";
                                                   odbc_exec($conn, $sqlDebit1) or exit(odbc_errormsg($conn));
                }
                //---------------------payment ledger
                 for($n=1; $n<=$_REQUEST['feecount']; $n++){
                $chk_Payment = odbc_exec($conn, "SELECT * FROM [Ledger Payment] WHERE 
						[Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Fee Description] ='".$_REQUEST['OldDescription'.$n]."' AND [Invoice No]='$InvoiceNo' ");
                
               
                 if(odbc_num_rows($chk_Payment)==0){
		//if($_REQUEST['OldAmount'.$n] !=0 || $_REQUEST['OldAmount'.$n] != ""){
			$sqlPayment = "INSERT INTO [Ledger Payment]([Customer No], [Fee Description], [Fee Amount], [Payment Date], [Amount Paid],[Company Name] ,[FinYr], [Month], [Year], [Qtr],[Reverse],[Invoice No])
				VALUES
				('".$cust_no."','".$_REQUEST['OldDescription'.$n]."',".$_REQUEST['OldAmount'.$n].",'$inv_dt', ".$_REQUEST['OldAmount'.$n].", '$ms', '$FinYr', '". date("m", $today)."', 
				'". date("Y", $today)."', '". $Qtr ."','1','$InvoiceNo' )";
                       odbc_exec($conn, $sqlPayment) or exit(odbc_errormsg($conn));
			
		}
               // }
                else{
                     $sqlPayment1= "UPDATE [Ledger Payment] SET [Reverse]=1 WHERE [Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND 
						[Fee Description] ='".$_REQUEST['OldDescription'.$n]."' AND [Invoice No]='$InvoiceNo' ";
                   odbc_exec($conn, $sqlPayment1) or exit(odbc_errormsg($conn));
                }
	        }
                //------------------------------Invocie Delete End ---------------------------------------------------------
                
              // die();
	
		$f=1;
		$gTotal = 0;
		//for($f=0; $f<=$_REQUEST['fee_count']; $f++){
               
		$Fee = odbc_exec($conn, "Select * FROM [StudentFee] where [ApplicationNo]='$cust_no' AND [CompanyName]='$CompName'");
		while(odbc_fetch_array($Fee)){
			if(odbc_result($Fee, "FeeNo") != ""){
                          $rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [id]='".odbc_result($Fee, "FeeNo")."' ") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
		
                $one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
                [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
                VALUES('$inv_dt', '$inv_no', '$cust_no', '". $_REQUEST['DescriptionA'.$f]."', '".$_REQUEST['amt_paidA'.$f]."', '-', 0, 0, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
               odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
                         

		?>
		<tr style="font-weight: bold;">
		<td style="text-align: center;"><?php echo $f;?></td>
		<td><?php echo $_REQUEST['DescriptionA'.$f];?></td>
		<td><?php echo number_format($_REQUEST['amt_paidA'.$f],2,'.',','); ?></td>
		<td></td>
		<td></td>	
		</tr>
		<?php			
			
		$new_amt = $_REQUEST['amt_paidA'.$f];
		$d=1;
                $Discount = odbc_exec($conn, "Select * FROM [StudentDiscountDetails] where [ApplicationNo]='$cust_no' AND [CompanyName]='$CompName'");
		while(odbc_fetch_array($Discount)){ 
				$e=0;
					if(odbc_result($Discount, "DiscountNo") != ""){
					$disc_fee_hdr = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [id]='".odbc_result($Discount, "DiscountNo")."' AND [Company Name]='$CompName'") or die(odbc_errormsg($conn));
					$disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$FinYr' AND [Document No_]='".odbc_result($disc_fee_hdr, "No_")."' ") or die(odbc_errormsg($conn));
					if(odbc_result($disc_fee_line, "Description") != ""){
						$e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
						$new_amt = $new_amt - $e;
						
						
						$Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
						[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
						VALUES('$inv_dt', '$inv_no', '$cust_no', '".$_REQUEST['DescriptionB'.$f]."', 0, '".odbc_result($disc_fee_line, "Document No_")."', ".$_REQUEST['amt_paidB'.$f].", 0, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
						odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
						
						
						echo "<tr style='text-decoration: italics; '><td></td>";
						echo "<td>".$_REQUEST['DescriptionB'.$f]." // ". odbc_result($disc_fee_line, "Document No_") ."</td>";
						echo "<td></td>";
						echo "<td style='text-align:right;'>".number_format($_REQUEST['amt_paidB'.$f],0,'.',',')."</td>";
						echo "<td>";
						
						echo "</td></tr>";
						}
					}
                                        $d++;
			}
		echo "<tr style='font-weight: bold;'><td></td><td>".$_REQUEST['DescriptionC'.$f]."</td><td></td><td></td>";
		echo "<td style='text-align:right;'>".number_format($_REQUEST['amt_paidC'.$f],0,'.',',')."</td>";
		echo "</tr>";
		
		
		
		$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
		[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
		VALUES('$inv_dt', '$inv_no', '$cust_no', '".$_REQUEST['DescriptionC'.$f]."', 0, '', 0, ".$_REQUEST['amt_paidC'.$f].", '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
		odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
		
                 //-----------------Net fee ledger payment table
		 $sqlPayment22 = "INSERT INTO [Ledger Payment]([Customer No], [Fee Description], [Fee Amount], [Payment Date], [Amount Paid],[Company Name] ,[FinYr], [Month], [Year], [Qtr],[Reverse],[Invoice No])
				VALUES
				('".$cust_no."','".$_REQUEST['DescriptionC'.$f]."',".$_REQUEST['amt_paidC'.$f].",'$inv_dt', ".$_REQUEST['amt_paidC'.$f].", '$ms', '$FinYr', '". date("m", $today)."', 
				'". date("Y", $today)."', '". $Qtr ."','0','$inv_no' )";
                odbc_exec($conn, $sqlPayment22) or exit(odbc_errormsg($conn));
		 //-----------------Net fee ledger payment table
                $gTotal = $gTotal + $new_amt;
			}
			}
		 $f++;	
		}
		
		?>
            <!---- Transport Fee start------------------------------------------------------------------------------------------->
                <?php
               $Transport = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [Registration No_]= '".$cust_no."' ") or die(odbc_errormsg($conn));
                $a=odbc_result($Transport, "Slab Code");
                $b=odbc_result($Transport, "Transport Fee");
                $c=odbc_result($Transport, "Distance Covered in KM");
                if(!empty($a) && ($b) && ($c)) {
                if($a != "" && $b != "" && $c != ""){
                $new_amt = $b;
		echo "<tr style='font-weight: bold;'><td></td><td>Net Transport Fee payable </td><td></td><td></td>";
		echo "<td style='text-align:right;'>".number_format($b,0,'.',',')."</td>";
		echo "</tr>";
		$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Transport Fee', '$b', '-', 0, 0, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
					odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
                
		
		$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
		[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
		VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net Transport Fee payable', 0, '', 0, $b, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
		odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
		
		
		$gTotal = $gTotal + $new_amt;
		}
                }
		
		$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
		[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
		VALUES
		('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', $gTotal, '$ms', '$LoginID',
		'$LoginID',$inv1, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
		odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));
                
               
        //-----------------Net transport fee ledger payment table
          $sqlPayment24 = "INSERT INTO [Ledger Payment]([Customer No], [Fee Description], [Fee Amount], [Payment Date], [Amount Paid],[Company Name] ,[FinYr], [Month], [Year], [Qtr],[Reverse],[Invoice No])
		VALUES
		('".$cust_no."','Net Transport Fee payable',".$b.",'$inv_dt', ".$b.", '$ms', '$FinYr', '". date("m", $today)."', 
		'". date("Y", $today)."', '". $Qtr ."','0','$inv_no' )";
         odbc_exec($conn, $sqlPayment24) or exit(odbc_errormsg($conn));
//***************************************************approval Table Start *********************************

$StudentNo = odbc_exec($conn, "Select [No_] FROM [Temp Student] where [Registration No_]='$cust_no' AND [Company Name]='$ms'");

 $sqlE = "UPDATE [Student Card Changes] SET [Status]= 1 WHERE [ID]='".$_REQUEST['tb_id']."' AND [Student No_]='".odbc_result($StudentNo,"No_")."' AND [Company Name]='$ms'";
odbc_exec($conn, $sqlE) or exit(odbc_errormsg($conn)); // OneTime

 


     //***************************************approval Table End*********************************            
            ?>
      
            <tr style="font-weight: bold;">
                    <td colspan="2">TOTAL</td>
                    <td></td>
                    <td></td>
                    <td  style='text-align:right;'><?php echo number_format($gTotal,0,'.',','); ?></td>
            </tr>
            <tr>
                    <td style="border-top: 1px solid #000000;" colspan="5">				
                            Amount : <b>Rupees <?php echo strtoupper(convert_number_to_words(round($gTotal)));?> Only</b>
                    </td>
            </tr>
</table>
</div>
</div>
</div>
<?php  echo "<META http-equiv='refresh' content='0;URL=StudentCardApp.php'>"; ?>
<!--script>
	var childWindows = [];
	
	var win = window.open("RevReceiptAdmission.php?id=<?php echo $cust_no?>&ms=<?php echo $ms?>&inv=<?php echo $inv_no ?>&loop=1","windowName", "width=900,height=500,scrollbars=no");
	win.focus();
	childWindows.push(win);	
	
</script-->



 
