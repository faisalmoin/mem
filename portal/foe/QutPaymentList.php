<?php require_once("header.php");

	echo "<div class='container'>";

	$Class="PRENUR";
	$AcadYr = "16-17";
	//$CompName = "6";

	$d=1;
		
	$inv_dt = time();
	$inv_last_dt = date('t');
	
	$today = $inv_dt;
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	}

	
		$rs = odbc_exec($conn, "SELECT [No_],[Registration No_] FROM [Temp Student] where [Class]='$Class' AND [Academic Year]='$AcadYr' AND [Student Status]=1 AND [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
			
			$Reg=odbc_result($rs, 'Registration No_'); //Customer No
			
			//Invoice No
			$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$CompName'") or die(odbc_errormsg($conn));
			$inv = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
			$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
	
			//Monthly 			           		
			MonthNo(1,$cust_no);		
			
					/*
			//Q1 Calculation
			if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
				$Qtr = "Q1";
				MonthNo(2,$cust_no);
			}
					//Q2 Calculation
					if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
					     $Qtr = "Q2";
						 MonthNo(2,$cust_no);
					}
					//Q3 Calculation
					if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
					     $Qtr = "Q3";
						 MonthNo(2,$cust_no);
					}
					//Q1 Calculation
					if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
					     $Qtr = "Q4";
						 MonthNo(2,$cust_no);
					}		
					//echo $Qtr."<br />";		
			
					//Half Yearly Calculation
					if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-09-30")){
						 $Hfl = "H1";
						 MonthNo(3,$cust_no);
					}
					//H2 Calculation
					if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-03-31")){
						 $Hfl = "H2";
						 MonthNo(3,$cust_no);
					}
					//Annual fee
					
					if($today > strtotime(date("Y", $today)."-03-20") && $today < strtotime((date("Y", $today))."-03-31"))
					 {
						$ANN = "A1";
						MonthNo(4,$cust_no);
					 }

			include("QutPayment.php");
			
			$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
					[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr])
					VALUES
					('$inv_dt', '$inv_no', '$cust_no', 'Admission & Other Fees', $gTotal, '$CompName', '$LoginID',
					'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
			        odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));
			*/
			$d++;
        }
	 
	function MonthNo($Mnth,$cust_no1){
		global $CompName, $Class, $conn, $cust_no1,$AdmissionYear,$gTotal,$inv_dt,$inv_no,$LoginID,$new_amt,$FinYr,$Qtr,$today;
		$f=1;
		$cust_no = $cust_no1;
		$mnth = $Mnth;
		echo "$cust_no ";
		$sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";
		$rs22 = odbc_exec($conn, $sql) or die("Error ");
		while(odbc_fetch_array($rs22)){
			$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($rs)){
				$checkMonth = odbc_exec($conn, "select COUNT([ID]) from [ledger invoice] where 
					[Fee Description]='".odbc_result($rs, "Description")."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' ") or die("Check ...") ;
				if(odbc_result($checkMonth, "")==0){
					$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
							[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
							VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '".odbc_result($rs, "Total Amount")."', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					
					$new_amt = odbc_result($rs, "Total Amount");
					
					//Discount Calculation
					$e=0;
					$disc_fee_hdr = odbc_exec($conn, "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
					$disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='".odbc_result($disc_fee_hdr, "DocumentNo_")."' ") or die(odbc_errormsg($conn));
					if(odbc_result($disc_fee_line, "Description") != "")
					{
						$e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
						$new_amt = $new_amt - $e;
						
						$Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
						[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
						VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
						odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
						
						// Net payable INSERT
						$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
									[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
									VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
						odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn));
						
						$gTotal+= $new_amt;
						$f++;
				  	}
				}
				return $gTotal;
			    
			} 
		}
		
						
	}
	
	echo "</div>";
	require_once("../footer.php")
      ?>
      
      
	
  

