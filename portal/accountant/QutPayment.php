      <?php require("../ConvertNum2Words.php");
		        $AdmissionYear=$AcadYr;
		        //$cust_no=$Reg;
echo "AcadYr: $AdmissionYear // CustNo: $cust_no <br />";
		      ?>
				<div class="container">
				<h1 class="text-primary">Term<small> - Fee</small></h1>
				<div class="tab-content" id="StuTabContent">
				<div class="tab-pane face in active" id="StuTab2" >
				<table id="results2" class="table table-responsive">
				<tr style="font-weight: bold;">
				<td style="text-align: center;"></td>
				<td>Description</td>
				<td>Amount</td>
				<td style="text-align:center">Discounted Amount</td>
				<td style="text-align:center">Net Payable Amount</td>
				</tr>
				<?php 
		
				
		      function MonthNo($Mnth,$cust_no1){
				global $CompName, $Class, $conn, $cust_no,$AdmissionYear,$gTotal,$inv_dt,$inv_no,$LoginID,$new_amt,$FinYr,$Qtr,$today;
				$f=1;
				$Cust_no = $cust_no1;
				$mnth = $Mnth;
				$sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";	
	            /* echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";
	            echo "<br /><br />";*/
	            $rs22 = odbc_exec($conn, $sql) or die("Error ");
			    while(odbc_fetch_array($rs22)){
	            $echo .= odbc_result($rs22, "ID").", ";
				
				$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ") or die(odbc_errormsg($conn));
				/* echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ";
				echo "<br /><br />";*/
				while(odbc_fetch_array($rs)){
				$checkMonth = "select * from [ledger invoice] where [Fee Description]='".odbc_result($rs, "Description")."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' ";
				/* echo "select * from [ledger invoice] where [Fee Description]='".odbc_result($rs, "Description")."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' ";
				echo "<br /><br />";*/
				if($checkMonth==0){
				$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
				[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
				VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '".odbc_result($rs, "Total Amount")."', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				//odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
				/* echo "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
				[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
				VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '".odbc_result($rs, "Total Amount")."', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				echo "<br /><br />"; */
						
				 ?>
							<tr style="font-weight: bold;">
							<td style="text-align: center;"><!--?php echo $f;?--></td>
							<td><?php echo odbc_result($rs, "Description");?></td>
							<td><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
							<td></td>
							<td></td>	
							</tr>
				<?php			
						$new_amt = odbc_result($rs, "Total Amount");
						$e=0;
						$disc_fee_hdr = odbc_exec($conn, "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
						/* echo "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'";
						echo "<br /><br />";*/
						$disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='".odbc_result($disc_fee_hdr, "DocumentNo_")."' ") or die(odbc_errormsg($conn));
						/* echo "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='".odbc_result($disc_fee_hdr, "DocumentNo_")."' ";
						echo "<br /><br />";*/
						if(odbc_result($disc_fee_line, "Description") != "")
								{
									$e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
									$new_amt = $new_amt - $e;
									
									$Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
									[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
									VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
									//odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
									/*
									echo "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
									[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
									VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
									*/
									echo "<tr style='text-decoration: italics; '><td></td>";
									echo "<td>".odbc_result($disc_fee_line, "Description")." // ". odbc_result($disc_fee_line, "Document No_") ."</td>";
									echo "<td></td>";
									//echo "<td style='text-align:center;'>".number_format(odbc_result($disc_fee_line, "Discount%"),0,'.',',')."%</td>";
									echo "<td style='text-align:right;'>".number_format($e,0,'.',',')."</td>";
									echo "<td>";
									echo "</td></tr>";
								  }
							
					echo "<tr style='font-weight: bold;'><td></td><td>Net ".odbc_result($rs, "Description")." payable </td><td></td><td></td>";
					echo "<td style='text-align:right;'>".number_format($new_amt,0,'.',',')."</td>";
					echo "</tr>";
					
					// Net payable INSERT
				
					$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					//odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
					/* echo "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					echo "<br /><br />"; */
					$gTotal+= $new_amt;
                    
					$f++;
				  	}
				    }
				    return $gTotal;
				    
				    } 
					}   //function end
				
				
					
				    $InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
					[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr])
					VALUES
					('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', $gTotal, '$CompName', '$LoginID',
					'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					//odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));
				    
				    /*
				    echo "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
					[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', $gTotal, '$CompName', '$LoginID',
					'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				    echo "<br /><br />";*/
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
		 <?php require_once("../footer.php");?>


