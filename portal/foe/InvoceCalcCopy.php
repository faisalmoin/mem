<?php
		// *********** START Invoice Generation ***************//
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
		echo $q1Edt;
		//Get Quarter as per current date
		
		if($inv_dt >= $q1Sdt && $inv_dt <= $q1Edt ) {$Qtr = 2;}
		elseif($inv_dt >= $q2Sdt && $inv_dt <= $q2Edt ) {$Qtr = 3;}
		elseif($inv_dt >= $q3Sdt && $inv_dt <= $q3Edt ) {$Qtr = 4;}
		elseif($inv_dt >= $q4Sdt && $inv_dt <= $q4Edt ) {$Qtr = 5;}
		else{
			$Qtr = 2;
		}
		
		//Get Sequence No
		$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn)); 
		$inv = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
		
		$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
		
		
		//System Genrated No.
		$sys_no = odbc_exec($conn, "SELECT [System Genrated No_] FROM [Temp Application] WHERE [Enquiry No_]='".$id."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		$cust_no = odbc_result($sys_no, "System Genrated No_");
		
		$NetAmt = 0;
		
		//Get all Onetime Fee Code	
		$AdmFee = odbc_exec($conn, "SELECT [Fee Code], [Description], [Amount] FROM [Class Fee Line] 
								WHERE 
								[Academic year]='$AcadYear' AND 
								[Class]='$Class' AND 
								[No_ of months]='0' AND 
								[Company Name]='$ms' AND [Group Code] <> 'REG' ");
		while(odbc_fetch_array($AdmFee)){
			$ini_fee1 = odbc_result($AdmFee, "Amount") or die(odbc_errormsg($conn));
			//Discount Code 1 Calculation
			if($DiscountCodeNo1 != ""){				
				$disc1 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE 
				[Document No_]='$DiscountCodeNo1' 
				AND [Fee Code]='".odbc_result($AdmFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND 
				[Company Name]='$ms'");
								
				if(odbc_num_rows($disc1) !=0){
					$d1 = odbc_result($disc1, 'Discount%');
					$dc1 = odbc_result($disc1, 'Description');
					$DiscAdm1 = ($ini_fee1*$d1)/100;
				}
				else{
					$DiscAdm1 = 0;					
				}
			}
			
			//Discount Code 2 Calculation
			if($DiscountCodeNo2 != ""){
				$disc2 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE 
				[Document No_]='$DiscountCodeNo2' 
				AND [Fee Code]='".odbc_result($AdmFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND 
				[Company Name]='$ms'");
				
				if(odbc_num_rows($disc2) !=0){
					$d2 = odbc_result($disc2, 'Discount%') or die(odbc_errormsg($conn));
					$dc2 = odbc_result($disc2, 'Description');
					
					if($DiscAdm1 != 0 && $d2 != 0){					
						if($ini_fee1 != $DiscAdm1) $DiscAdm2 = (($ini_fee1 -  $DiscAdm1)*$d2)/100;
						else if($d2 == 100) $DiscAdm2 = ($ini_fee1 -  $DiscAdm1) * (-1);										
					}
					else if($DiscAdm1 == 0 && $d2 != 0) $DiscAdm2 = ($ini_fee1*$d2)/100;
					else if($DiscountCodeNo1 == "" && $d2 == 100) ($ini_fee1) * (-1);
					else $DiscAdm2 = 0;	
				}
				else{
					$DiscAdm2 = 0;					
				}
			}
			
			$DiscAdm1 = (($DiscAdm1 != "")?$DiscAdm1:0);
			$DiscAdm2 = (($DiscAdm2 != "")?$DiscAdm2:0);
			
			$NetAdm = $ini_fee1 - ($DiscAdm1 + $DiscAdm2);
			
			$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name], [Discount Code1 Description], [Discount Code2 Description]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', '".odbc_result($AdmFee, "Description")."', '$ini_fee1',
				'$DiscountCodeNo1', $DiscAdm1, '$DiscountCodeNo2', $DiscAdm2, $NetAdm, '$LoginID', '$LoginID', '$ms',
				'$dc1', '$dc2' )";
			//echo $one_ins;
			//echo "<br />Description: ".odbc_result($AdmFee, "Description")." // Amt: ".number_format($ini_fee1)." // Disc 1: $DiscAdm1 // Disc 2: $DiscAdm2 // Net Amount: $NetAdm <br /><br />";
			odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
			$NetAmt = $NetAmt + $NetAdm; 
			
		}
		
		//Get all Qtrly Fee Code
		$QtrFee = odbc_exec($conn, "SELECT [Fee Code], [Description], [Amount] FROM [Class Fee Line] WHERE 
						[Academic year]='$AcadYear' AND [Class]='$Class' AND [No_ of months]='$Qtr' 
						AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($QtrFee)){		
			$ini_fee2 = odbc_result($QtrFee, "Amount");
			//Discount Code 1 Calculation
			if($DiscountCodeNo1 != ""){
				$disc1 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo1' 
				AND [Fee Code]='".odbc_result($QtrFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'");
				
				
				if(odbc_num_rows($disc1) !=0){
					$d1 = odbc_result($disc1, 'Discount%') or die(odbc_errormsg($conn));	
					$DiscQtr1 = ($ini_fee2*$d1)/100;
				}
				else{
					$DiscQtr1 = 0;
				}
			}
			
			//Discount Code 2 Calculation
			if($DiscountCodeNo2 != ""){
				$disc2 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo2' 
				AND [Fee Code]='".odbc_result($QtrFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND 
				[Company Name]='$ms'");				
				
				if(odbc_num_rows($disc2) !=0){
					$d2 = odbc_result($disc2, 'Discount%') or die(odbc_errormsg($conn));
					$dc2 = odbc_result($disc2, 'Description');
					
					if($DiscQtr1 != 0 && $d2 != 0){					
						if($ini_fee2 != $DiscQtr1) $DiscQtr2 = (($ini_fee2-$DiscQtr1)*$d2)/100;
						else if($d2 == 100) $DiscQtr2 = ($ini_fee2 -  $DiscQtr1) * (-1);
						
					}
					else if($DiscQtr1 == 0 && $d2 != 0) $DiscQtr2 = ($ini_fee2*$d2)/100;
					else if($DiscountCodeNo1 == "" && $d2 == 100) ($ini_fee2) * (-1);
					else $DiscQtr2 = 0;
				}
				else if($DiscQtr2 == "" || $DiscQtr2 == 0) $DiscQtr2 = 0;
				else $DiscQtr2 = 0;
				
				
			}				
			
			$DiscQtr1 = (($DiscQtr1 != "")?$DiscQtr1:0);
			$DiscQtr2 = (($DiscQtr2 != "")?$DiscQtr2:0);
			
			$NetQtr = $ini_fee2 - ($DiscQtr1 + $DiscQtr2);
			
			$qtr_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name], [Discount Code1 Description], [Discount Code2 Description]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', '".odbc_result($QtrFee, "Description")."', '$ini_fee2',
				'$DiscountCodeNo1', $DiscQtr1, '$DiscountCodeNo2', $DiscQtr2, $NetQtr, '$LoginID', '$LoginID', '$ms',
				'".odbc_result($disc1, 'Description')."', '".odbc_result($disc2, 'Description')."')";
			echo "$qtr_ins <br />";
			//echo "Description: ".odbc_result($QtrFee, "Description")." // Amt: ".number_format($ini_fee2)." // Disc 1: ".number_format($DiscQtr1)." // 
			//	Disc 2: $DiscQtr2 // Net Amount: $NetQtr <br /><br />";
			odbc_exec($conn, $qtr_ins) or exit(odbc_errormsg($conn)); // OneTime
			$NetAmt = $NetAmt + $NetQtr; 
		}
				
		//Get all Halfly Fee Code
		$HalfFee = odbc_exec($conn, "SELECT [Fee Code], [Description], [Amount] FROM [Class Fee Line] WHERE [Academic year]='$AcadYear' AND [Class]='$Class' AND [No_ of months]='6' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($HalfFee)){
			$ini_fee3 = odbc_result($HalfFee, "Amount");
			//Discount Code 1 Calculation
			if($DiscountCodeNo1 != ""){
				$disc1 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo1' 
				AND [Fee Code]='".odbc_result($HalfFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'");
				
				if(odbc_num_rows($disc1) !=0){
					$d1 = odbc_result($disc1, 'Discount%') or die(odbc_errormsg($conn));		
					$DiscHly1 = ($ini_fee3*$d1)/100;
				}
				else{
					$DiscHly1 = 0;
				}
			}
			
			//Discount Code 2 Calculation
			if($DiscountCodeNo2 != ""){
				$disc2 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo2' 
				AND [Fee Code]='".odbc_result($HalfFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
				
				if(odbc_num_rows($disc2) !=0){
					$d2 = odbc_result($disc2, 'Discount%') or die(odbc_errormsg($conn));
					$dc2 = odbc_result($disc2, 'Description');
					
					if($DiscHly1 != 0 && $d2 != 0){					
						if($ini_fee3 != $DiscHly1) $DiscHly2 = (($ini_fee3-$DiscHly1)*$d2)/100;
						else if($d2 == 100) $DiscHly2 = ($ini_fee2 -  $DiscHly1) * (-1);										
					}
					else if($DiscQtr1 == 0 && $d2 != 0) $DiscQtr2 = ($ini_fee3*$d2)/100;
					else if($DiscountCodeNo1 == "" && $d2 == 100) ($ini_fee3) * (-1);
					else $DiscHly2 = 0;	
				}
				else{
					$DiscHly2 = 0;					
				}
				
			}
			
			$DiscHly1 = (($DiscHly1 != "")?$DiscHly1:0);
			$DiscHly2 = (($DiscHly2 != "")?$DiscHly2:0);
			
			$NetHly = $ini_fee3 - ($DiscHly1 - $DiscHly2);
			
			$hlf_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name], [Discount Code1 Description], [Discount Code2 Description]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', '".odbc_result($HalfFee, "Description")."', '$ini_fee3',
				'$DiscountCodeNo1', $DiscHly1, '$DiscountCodeNo2', $DiscHly2, $NetHly, '$LoginID', '$LoginID', '$ms',
				'".odbc_result($disc1, 'Description')."', '".odbc_result($disc2, 'Description')."')";
			//echo "$hlf_ins <br />";
			//echo "Description: ".odbc_result($HalfFee, "Description")." // Amt: $ini_fee3 // Disc 1: $DiscHly1 // 
			//	Disc 2: $DiscHly2 // Net Amount: $NetHly <br /><br />";
			odbc_exec($conn, $hlf_ins) or exit(odbc_errormsg($conn)); // OneTime
			$NetAmt = $NetAmt + $NetHly; 
		}
		
		//Get Annual Fee
		$AnlFee = odbc_exec($conn, "SELECT [Fee Code], [Description], [Amount] FROM [Class Fee Line] WHERE [Academic year]='$AcadYear' 
					AND [Class]='$Class' AND [No_ of months]='7' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($AnlFee)){
			
			$ini_fee4 = odbc_result($AnlFee, "Amount");
			//Discount Code 1 Calculation
			if($DiscountCodeNo1 != ""){
				$disc1 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo1' 
				AND [Fee Code]='".odbc_result($AnlFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
				
				
				if(odbc_num_rows($disc1) !=0){
					$d1 = odbc_result($disc1, 'Discount%');			
					$DiscAnl1 = ($ini_fee4*$d1)/100;					
				}
				else{
					$DiscAnl1 = 0;
				}
			}
			//Discount Code 2 Calculation
			if($DiscountCodeNo2 != ""){
				$disc2 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo2' 
				AND [Fee Code]='".odbc_result($AnlFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
								
				if(odbc_num_rows($disc2) !=0){
					$d2 = odbc_result($disc2, 'Discount%') or die(odbc_errormsg($conn));
					$dc2 = odbc_result($disc2, 'Description');
					
					if($DiscAnl1 != 0 && $d2 != 0){					
						if($ini_fee4 != $DiscAnl1) $DiscAnl2 = (($ini_fee4-$DiscAnl1)*$d2)/100;
						else if($d2 == 100) $DiscAnl2 = ($ini_fee4 -  $DiscAnl1) * (-1);										
					}
					else if($DiscAnl1 == 0 && $d2 != 0) $DiscAnl2 = ($ini_fee4*$d2)/100;
					else if($DiscountCodeNo1 == "" && $d2 == 100) ($ini_fee4) * (-1);
					else $DiscAnl2 = 0;	
				}
				else{
					$DiscAnl2 = 0;					
				}
			}
			
			$DiscAnl1 = (($DiscAnl1 != "")?$DiscAnl1:0);
			$DiscAnl2 = (($DiscAnl2 != "")?$DiscAnl2:0);
			
			$NetAnl = $ini_fee4 - ($DiscAnl1 + $DiscAnl2);
			
			$anl_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name], [Discount Code1 Description], [Discount Code2 Description]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', '".odbc_result($AnlFee, "Description")."', '$ini_fee4',
				'$DiscountCodeNo1', $DiscAnl1, '$DiscountCodeNo2', $DiscAnl2, $NetAnl, '$LoginID', '$LoginID', '$ms',
				'".odbc_result($disc1, 'Description')."', '".odbc_result($disc2, 'Description')."')";
			//echo "$anl_ins <br />";
			//echo "Description: ".odbc_result($AnlFee, "Description")." // Amt: ".number_format($ini_fee4)." // Disc 1: $DiscAnl1 // 
			//	Disc 2: $DiscAnl2 // Net Amount: $NetAnl <br /><br />";
			odbc_exec($conn, $anl_ins) or exit(odbc_errormsg($conn)); // OneTime
			$NetAmt = $NetAmt + $NetAnl; 
		}
		
		
		//Get Monthly Fee
		$MnFee = odbc_exec($conn, "SELECT [Fee Code], [Description], [Amount] FROM [Class Fee Line] WHERE [Academic year]='$AcadYear' AND 
			[Class]='$Class' AND [No_ of months]='1' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($MnFee)){
			$ini_fee5 = odbc_result($MnFee, "Amount");
			//Discount Code 1 Calculation
			if($DiscountCodeNo1 != ""){
				$disc1 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo1' 
				AND [Fee Code]='".odbc_result($MnFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
				
				if(odbc_num_rows($disc1) !=0){
					$d1 = odbc_result($disc1, 'Discount%');	
					$DiscMn1 = ($ini_fee5*$d1)/100;					
				}
				else{
					$DiscMn1 = 0;
				}
			}
			//Discount Code 2 Calculation
			if($DiscountCodeNo2 != ""){
				$disc2 = odbc_exec($conn, "SELECT [Discount%], [Description] FROM [Discount Fee Line] WHERE [Document No_]='$DiscountCodeNo2' 
				AND [Fee Code]='".odbc_result($MnFee,'Fee Code')."'  AND [Academic Year]='$AcadYear' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
								
				if(odbc_num_rows($disc2) !=0){
					$d2 = odbc_result($disc2, 'Discount%') or die(odbc_errormsg($conn));
					$dc2 = odbc_result($disc2, 'Description');
					
					if($DiscMn1 != 0 && $d2 != 0){					
						if($ini_fee5 != $DiscMn1) $DiscMn2 = (($ini_fee5-$DiscMn1)*$d2)/100;
						else if($d2 == 100) $DiscMn2 = ($ini_fee5 -  $DiscMn1) * (-1);										
					}
					else if($DiscMn1 == 0 && $d2 != 0) $DiscMn2 = ($ini_fee5*$d2)/100;
					else if($DiscountCodeNo1 == "" && $d2 == 100) ($ini_fee5) * (-1);
					else $DiscMn2 = 0;	
				}
				else{
					$DiscMn2 = 0;					
				}
				
			}
			
			$DiscMn1 = (($DiscMn1 != "")?$DiscMn1:0);
			$DiscMn2 = (($DiscMn2 != "")?$DiscMn2:0);
			
			$NetMn = $ini_fee5 - ($DiscMn1 + $DiscMn2);
			
			$mon_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name], [Discount Code1 Description], [Discount Code2 Description]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', '".odbc_result($MnFee, "Description")."', '$ini_fee5',
				'$DiscountCodeNo1', $DiscMn1, '$DiscountCodeNo2', $DiscMn2, $NetMn, '$LoginID', '$LoginID', '$ms',
				'".odbc_result($disc1, 'Description')."', '".odbc_result($disc2, 'Description')."')";
			//echo "$mon_ins <br />";
			//echo "Description: ".odbc_result($MnFee, "Description")." // Amt: $ini_fee5 // Disc 1: $DiscMn1 // 
			//	Disc 2: $DiscMn2 // Net Amount: $NetMn <br /><br />";
			odbc_exec($conn, $mon_ins) or exit(odbc_errormsg($conn)); // OneTime
			$NetAmt = $NetAmt + $NetMn; 
		}
				
		if($TransFee != ""){
			$trans_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount], 
				[Discount Code1],[Discount Code1 Amount],[Discount Code2],[Discount Code2 Amount], [Net Amount],
				[User ID], [Portal ID], [Company Name]) 
				VALUES(
				'$inv_dt', '$inv_no', '$cust_no', 'Transport Fee', $TransFee,
				'', 0, '', 0, $TransFee, '$LoginID', '$LoginID', '$ms'
				)";
			//echo "$trans_ins <br />";
			odbc_exec($conn, $trans_ins) or exit(odbc_errormsg($conn)); // OneTime
			//echo "Description: Transport Fee // Slab Code: $SlabCode // Distance : $TransDist // 
			//	Amount: $TransFee <br /><br />";
			$NetAmt = $NetAmt + $TransFee; 
		}
				
		$AdvFee = odbc_exec($conn, "SELECT [ID], [Adv Fee] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$cust_no' AND [ID] IN (SELECT MAX([ID]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$cust_no') ") or die(odbc_errormsg($conn));
		$adj = ((odbc_num_rows($AdvFee) != 0)? odbc_result($AdvFee, "Adv Fee") : 0);
		echo "Total Invoice Amt: $NetAmt<br />";
		echo "Less Advance: $adj<br />";
		echo "Net Invoice Amount: ".($NetAmt - $adj);
		
		$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], Description,
				[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee]) 
				VALUES 
				('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', '$NetAmt', '$ms', '$LoginID', 
				'$LoginID',$inv, $adj)";
		//exit();
		//********** Invoice Post*************//
		
		odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn)); // Ledger Credit Table
		
		
	        //********** Invoice *************//
		
		
		//echo $inv_ins ."<br /><br />".$InvCrd."<br /><br />$adj";		
		//exit();
		
		// *********** END Invoice Generation ***************//
?>

<script>
	var childWindows = [];
	
	var win = window.open("ReceiptAdmission.php?id=<?php echo $cust_no?>&ms=<?php echo $ms?>&inv=<?php echo $inv_no?>","windowName", "width=900,height=500,scrollbars=no");
	win.focus();
	childWindows.push(win);	
	
</script>