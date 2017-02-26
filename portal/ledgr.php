		<?php 
		require_once("db.txt");
		$CompName='6';
		$ms='6';
		//$cust_no1='APP0043';
		$cust_no='WPR0000041';
		
		$Class='PRENUR';
		$AdmissionYear='16-17';
		//require_once("header.php");
		/*
		 $sys_no = odbc_exec($conn, "SELECT [Class][Academic Year] FROM [Temp Application] WHERE [System Genrated No_]='".$cust_no1."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		 //echo "SELECT [Class][Academic Year] FROM [Temp Application] WHERE [System Genrated No_]='".$cust_no1."' AND [Company Name]='$ms' ";
		 $Class = odbc_result($sys_no, "Class");
		 $AdmissionYear = odbc_result($sys_no, "Academic Year");
		 */
		require_once("ConvertNum2Words.php");?>
		<div class="container">
		<h1 class="text-primary">Term<small> - Fee</small></h1>
		
		
		<div class="tab-content" id="StuTabContent">
		
		<div class="tab-pane face in active" id="StuTab2" >
		<table id="results2" class="table table-responsive">
		<tr style="font-weight: bold;">
		<td style="text-align: center;">SN</td>
		<td>Description</td>
		<td>Amount</td>
		<td style="text-align:center">Discounted Amount</td>
		<td style="text-align:center">Net Payable Amount</td>
		</tr>
		<?php 
		
				
		function MonthNo($Mnth){
			global $CompName, $Class, $conn, $cust_no,$AdmissionYear,$gTotal;
			$mnth = $Mnth;
			$sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";	
            $rs22 = odbc_exec($conn, $sql) or die("Error ");
		    while(odbc_fetch_array($rs22)){
            $echo .= odbc_result($rs22, "ID").", ";
				
		   // add query
			$f=1;
			//$gTotal = 0;
			$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ") or die(odbc_errormsg($conn));
			//echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [id]='".odbc_result($rs22, "ID")."' <br/ > ";
			while(odbc_fetch_array($rs)){
				
				$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
				[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
				VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '".odbc_result($rs, "Total Amount")."', '-', 0, 0, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				//odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
						
				?>
							<tr style="font-weight: bold;">
							<td style="text-align: center;"><?php echo $f;?></td>
							<td><?php echo odbc_result($rs, "Description");?></td>
							<td><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
							<td></td>
							<td></td>	
							</tr>
							<?php			
						
						$new_amt = odbc_result($rs, "Total Amount");
						
					     //for($d=0; $d<=$_REQUEST['Dis_count']; $d++){
							$e=0;
								//if($_REQUEST['discount'.$d] != ""){
							$disc_fee_hdr = odbc_exec($conn, "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
							//echo "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'  <br/ >";	
							$disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='".odbc_result($disc_fee_hdr, "DocumentNo_")."' ") or die(odbc_errormsg($conn));
							//echo "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='".odbc_result($disc_fee_hdr, "DocumentNo_")."'  <br/ >";
								if(odbc_result($disc_fee_line, "Description") != ""){
									$e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
									$new_amt = $new_amt - $e;
									
									$Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
									[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
									VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
									//odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
									
									
									echo "<tr style='text-decoration: italics; '><td></td>";
									echo "<td>".odbc_result($disc_fee_line, "Description")." // ". odbc_result($disc_fee_line, "Document No_") ."</td>";
									echo "<td></td>";
									//echo "<td style='text-align:center;'>".number_format(odbc_result($disc_fee_line, "Discount%"),0,'.',',')."%</td>";
									echo "<td style='text-align:right;'>".number_format($e,0,'.',',')."</td>";
									echo "<td>";
									echo "</td></tr>";
									}
							
								//}
						//}
					echo "<tr style='font-weight: bold;'><td></td><td>Net ".odbc_result($rs, "Description")." payable </td><td></td><td></td>";
					echo "<td style='text-align:right;'>".number_format($new_amt,0,'.',',')."</td>";
					echo "</tr>";
					
					
					// Net payable INSERT
				
					$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$ms', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					//odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
					
					
					$gTotal+= $new_amt;

					$f++;
							}
							
				// add query end
							
				}
		        
				return $gTotal;
		
				}
				
				
				//echo $gTotal[2];		
				
				$inv_dt = time();
				$inv_last_dt = date('t');
				
				$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
				$inv = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
				
				$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
				
				$today = $inv_dt;
				$this_yr = strtotime(date("Y", $today)."-04-01");
				$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
				
				$this_yr = strtotime(date("Y", $today)."-04-01");
				$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
				
				if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
				    $FinYr = date('y', $today)."-".(date('y', $today)+1);
				}
		
				 "Monthly: ". MonthNo(1);		
		
				//Q1 Calculation
				if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
				    $Qtr = "Q1";
					 $Qtr." // ". MonthNo(2);
		
				}
				//echo $Qtr;
				//Q2 Calculation
				if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
				    $Qtr = "Q2";
					 $Qtr." // ". MonthNo(2);
				}
				//Q3 Calculation
				if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
				    $Qtr = "Q3";
					 $Qtr." // ". MonthNo(2);
				}
				//Q1 Calculation
				if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
				    $Qtr = "Q4";
					 $Qtr." // ". MonthNo(2);
				}		
				//echo $Qtr."<br />";		
		
				//Half Yearly Calculation
				//H1 Calculation
				if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-09-30")){
					$Hfl = "H1";
					 $Hfl." // ". MonthNo(3);
				}
				//H2 Calculation
				if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-03-31")){
					$Hfl = "H2";
					 $Hfl." // ". MonthNo(3);
				}
				//echo $Hfl."<br />";		
		
				//Annual fee
				
				if($today > strtotime(date("Y", $today)."-03-20") && $today < strtotime((date("Y", $today))."-03-31"))
				{
					$ANN = "A1";
					 $ANN." // ". MonthNo(4);
					
				}
				//echo $ANN."<br />";	
				
				
			
				
				$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
				[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr])
				VALUES
				('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', $gTotal, '$ms', '$LoginID',
				'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				//odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));
				
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

<script>
	var childWindows = [];
	
//	var win = window.open("ReceiptAdmission.php?id=<?php echo $cust_no?>&ms=<?php echo $ms?>&inv=<?php echo $inv_no ?>","windowName", "width=900,height=500,scrollbars=no");
//	win.focus();
//	childWindows.push(win);	
	
</script>
<!--?php 
if($InvCrd){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Generate invoce successfully Please go Fee menu And Collect Invoce Receipt')
    window.setTimeout('history.go(-3)', 5000);
  
    </SCRIPT>");
	}
	// window.history.go(-2);
	?-->
 
	
