<?php
	require_once("header.php");
	echo "<br/><br/>";
    //print_r($_POST);
    //die();

	$Fee_description =$_REQUEST['Fee_description'];
	$Amount_paid =$_REQUEST['amt_paid'];
	// ledger change
	$cust_no = $_REQUEST['cust_no'];
    $amount = $_REQUEST['total2'];
	//$amount = $_REQUEST['Amount'];
	$pay_dt = strtotime(str_replace("/", " ", $_REQUEST['PaymentDt'].date('H:i:s')));
	$pay_mode = $_REQUEST['PaymentMode'];
	$bank_name = $_REQUEST['BankName'];
	$chk_no = $_REQUEST['ChequeDDNo'];
	$chk_dt = $_REQUEST['ChequeDDt'];
	$fee_count = $_REQUEST['fee_count'];
		
	$today = $pay_dt;
		$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
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
	
	
	//Check Invoice NOT paid
	$sum_cr = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE 
						[Customer No] = '$cust_no'
                                                AND [Reverse]=0
						AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$sum_dr = odbc_exec($conn, "SELECT SUM([Debit Amount]) FROM [Ledger Debit] WHERE
			[Customer No] = '$cust_no'
			AND [Reverse]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	
	$diff_amt = odbc_result($sum_cr, "") - odbc_result($sum_dr, "");
	
	$chk_dr = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE 
						[Customer No] = '$cust_no'
                                                AND [Reverse]=0
						AND [Company Name]='$ms' AND 
						[Invoice No] NOT IN 
						(SELECT [Invoice No] FROM [Ledger DEBIT] WHERE 
						[Customer No] = '$cust_no'
						AND [Company Name]='$ms' AND [Reverse]=0) ");
        
	
	$Description = (odbc_result($chk_dr, "Description")!= "")? odbc_result($chk_dr, "Description") : "Balance Adjustment";
	$credit_amt = odbc_result($chk_dr, "Credit Amount")?odbc_result($chk_dr, "Credit Amount"):0;
	$debit_amt = (odbc_result($chk_dr, "Debit Amount")!=0)?odbc_result($chk_dr, "Debit Amount"):$diff_amt;
	//echo "Invoice Amount".odbc_result($chk_dr, "Credit Amount")."<br />";
	
	$post1 = odbc_result($chk_dr, 'Posting No') + 1;
	$post2 = odbc_result($chk_dr, 'Posting No') + 2;
		
	
	//Check Payment Amount with Invoice Amount
        
        
        //----------------------------------------------------------------------------------------------------------------------
	
     /*   if($pay_mode==CASH){
          	if($amount > $diff_amt) //Advance
	{
		$adv_amt = ($amount - $diff_amt);
		
		//Adjusting with invoice
		$sql1 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'".odbc_result($chk_dr, 'Invoice Date')."', '".odbc_result($chk_dr, 'Invoice No')."', '".$cust_no."',
				'$Description',  ".$credit_amt.", ".$debit_amt.",
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 1, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '$pay_dt', $post1, 0 ,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
		$sql2 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'', '', '".$cust_no."',
				'Advance Fee',  0, 0,
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 1, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '$pay_dt', $post2, $adv_amt,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
		
		odbc_exec($conn, $sql1) or exit("Invoice Amount // ".odbc_errormsg($conn));
		odbc_exec($conn, $sql2) or exit("Advance Amount // ".odbc_errormsg($conn));
		
	}
	else{
		$sql3 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'".odbc_result($chk_dr, 'Invoice Date')."', '".odbc_result($chk_dr, 'Invoice No')."', '$cust_no',
				'".$Description."',  ".$credit_amt.", $amount,
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 1, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '$pay_dt', $post1, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
				
		odbc_exec($conn, $sql3) or exit("Below Invoice Amount // ".odbc_errormsg($conn));
	}  
        }else{*/
        
        if($amount > $diff_amt) //Advance
	{
		$adv_amt = ($amount - $diff_amt);
		
		//Adjusting with invoice
		$sql1 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'".odbc_result($chk_dr, 'Invoice Date')."', '".odbc_result($chk_dr, 'Invoice No')."', '".$cust_no."',
				'$Description',  ".$credit_amt.", ".$debit_amt.",
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 0, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '', $post1, 0 ,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
				//echo $sql1;
                //echo "<br />";  
		$sql2 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'', '', '".$cust_no."',
				'Advance Fee',  0, 0,
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 0, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '', $post2, $adv_amt,'$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
				//echo $sql2;
		        //echo "<br />";  
		odbc_exec($conn, $sql1) or exit("Invoice Amount // ".odbc_errormsg($conn));
		odbc_exec($conn, $sql2) or exit("Advance Amount // ".odbc_errormsg($conn));
		
	}
	else{
		$sql3 = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description, [Credit Amount], [Debit Amount],
				[Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date], [Payment Realization], [Company Name],
				[User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
				VALUES(
				'".odbc_result($chk_dr, 'Invoice Date')."', '".odbc_result($chk_dr, 'Invoice No')."', '$cust_no',
				'".$Description."',  ".$credit_amt.", $amount,
				'$pay_dt', '$pay_mode', '$bank_name', '$chk_no', '$chk_dt', 0, '$ms', 
				'$LoginID', '$LoginID', 'Payment Receipt', '', $post1, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0 )";
				//echo $sql3;
	           // echo "<br />";  	
		odbc_exec($conn, $sql3) or exit("Below Invoice Amount // ".odbc_errormsg($conn));
	}
	//die();
       // }
        
        //--------------------------------------------------------------------------------------------------------------------------
	//exit();
	//Create Student
	$App = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [System Genrated No_]='".odbc_result($chk_dr, 'Customer No')."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
	if(odbc_result($App, "Allot Student")==1){
		//Admission No
		$cnt = odbc_exec($conn, "SELECT COUNT([ID])+1 AS [Count] FROM [Temp Student] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
		$AdmNo = "A".str_pad(odbc_result($cnt, "Count"), 4, '0', STR_PAD_LEFT);
		$AllotStudent = 0;
		$StuNo = $AdmNo;
		
		//Class details
		$cls = odbc_exec($conn, "select [Sequence], [Code] from [Class] WHERE [Company Name]='$ms' AND [Code]='".odbc_result($App, "Class")."'") or die(odbc_errormsg($conn));
		$cl_sec = odbc_exec($conn, "select [Class Code] FROM [Class Section] WHERE [Company Name]='12' AND 
						[Class]='".odbc_result($App, 'Class')."' AND 
						[Academic Year]='".odbc_result($App, 'Academic Year')."' AND 
						[Section]='".odbc_result($App, 'Section')."'") or die(odbc_errormsg($conn));
		
		//Fee Clasiification
		$fc1 = odbc_exec($conn, "select [fee clasification code] as [fc] from [discount fee header] where [company name]='$ms' AND [No_]='".odbc_result($App, 'Discount Code')."'");
		$fc2 = odbc_exec($conn, "select [fee clasification code] as [fc] from [discount fee header] where [company name]='$ms' AND [No_]='".odbc_result($App, 'Discount Code 1')."'");
		
		
		$get_seq=odbc_exec($conn, "SELECT [Entry Sequence] FROM [Temp Student] WHERE [Entry Sequence]='".odbc_result($App, 'Entry Sequence')."' ") or die(odbc_errormsg($conn));
		if( odbc_num_rows($get_seq) == 0 ){
		
			$sql4 = "INSERT INTO [Temp Student] ([No_], [Name],[Gender],[Date Of Birth],[Father_s Name],[Mother_s Name],[Citizenship],[Academic Year],[Class],[Hostel Acommodation],[Previous School],[Medium of Instruction],[Presently Residing with],[Curriculum],[Previous Class],[Previous Curriculum],[Address To],[Addressee],[Address1],[Address2],[City],[Post Code],[Country],[E-Mail Address],[Mobile Number],[Phone Number],[State],[Visa Exp Date],[Passport No_],[Passport Exp Date],[Visa No_],[Food Habits],[Applicant Image],[Father Image],[Mother Image],[Guardian Image],[Mother_s Qualification],[Mother_s Occupation],[Guardian Name],[Promotion Granted],[Father_s Occupation],[Mother_s Annual Income],[Guardian Qualification],[Guardian Occupation],[Guardian Annual Income],[Enquiry No_],[Religion],[Father_s Qualification],[Caste],[Age],[Months],[Father_s Annual Income],[Exam Code],[Community],[Mother Tongue],[New Student],[Section],[Student Status],[Class Code],[Address 3],[House],[Fee Classification],[Quota],[Physically Challanged],[Staff Child],[Staff Code],[Application No_],[Date Joined],[Room No_],[Hostel Code],[Hostel Alloted],[Hostel Vacated],[Room Type],[Mess],[CGPA Grade],[Latest Rank],[Latest GPA],[Latest Grade],[Student Image],[No_ Series],[Admission For Year],[Old Admission No_],[Pickup],[Drop],[Distance Covered in KM],[Transport Fee],[Approval Status],[Sibbling No_],[Sibbling Code],[Sibbling Name],[Route No_],[Height],[Weight],[Date of Leaving],[Father Office Address 1],[Father Office Address 2],[Father Office City],[Father Office Post Code],[Father Office Country Code],[Mother Office Address 1],[Mother Office Address 2],[Mother Office City],[Mother Office Post Code],[Mother Office Country Code],[Guardian Office Address 1],[Guardian Office Address 2],[Guardian Office City],[Guardian Office Post Code],[Guardian Office Country Code],[Registration No_],[Mother Email],[Mother Mobile],[Father Email],[Father Mobile],[Block],[User ID],[Portal ID],[Family Code],[Discount Code],[Discount Code 1],[EWS],[Enquiry Status],[Transport Required],[Category],[Physically Challenged],[Route Details],[Slab Code],[Withdrwal Applied Date],[TC No_],[TC Date],[Langauge 1],[Language 2],[Class Sequence],[Approver ID],[Student Status 1],[Class code 1],[EWS 1],[Discount Code New],[Discount Code1 New],[Transport Slab Code New],[Discount Classification],[Discount Classification1],[Company],[Sibling DOB],[Sibling Class],[Sibling Section],[Sibling],[Applicant Relationship],[Remarks],[Stream],[InsertStatus],[UpdateStatus],[Company Name],[System Genrated No_],[ERPUpdateStatus],[TPT Availing Date],[TPT Withdrawal Date],[TPT Availing Date-T],[TPT Withdrawal Date-T],[Bool2],[Bool3],[Bool4],[Bool1],[Allot Student],[Entry Sequence])
				VALUES('$AdmNo', '".odbc_result($App, 'Name')."',".odbc_result($App, 'Gender').",
				'".odbc_result($App, 'Date of Birth')."','".odbc_result($App, 'Father_s Name')."',
				'".odbc_result($App, 'Mother_s Name')."','".odbc_result($App, 'Citizenship')."',
				'".odbc_result($App, 'Academic Year')."','".odbc_result($App, 'Class')."',
				".odbc_result($App, 'Hostel Acommodation').",'".odbc_result($App, 'Previous School')."',
				'".odbc_result($App, 'Medium of Instruction')."','".odbc_result($App, 'Presently Residing with')."',
				'".odbc_result($App, 'Curriculum Intrested')."','".odbc_result($App, 'Previous Class')."',
				'".odbc_result($App, 'Previous Curriculum')."','".odbc_result($App, 'Address To')."',
				'".odbc_result($App, 'Addressee')."','".odbc_result($App, 'Address1')."','".odbc_result($App, 'Address2')."',
				'".odbc_result($App, 'City')."','".odbc_result($App, 'Post Code')."','".odbc_result($App, 'Country')."',
				'".odbc_result($App, 'E-Mail Address')."','".odbc_result($App, 'Mobile Number')."',
				'".odbc_result($App, 'Phone Number')."','".odbc_result($App, 'State')."','".odbc_result($App, 'Visa Exp Date')."',
				'".odbc_result($App, 'Passport No_')."','".odbc_result($App, 'Passport Exp Date')."',
				'".odbc_result($App, 'Visa No_')."',".odbc_result($App, 'Food Habits').",'".odbc_result($App, 'Applicant Image')."',
				'".odbc_result($App, 'Father Image')."','".odbc_result($App, 'Mother Image')."',
				'".odbc_result($App, 'Guardian Image')."','".odbc_result($App, 'Mother_s Qualification')."',
				'".odbc_result($App, 'Mother_s Occupation')."','".odbc_result($App, 'Guardian Name')."',
				".odbc_result($App, 'Promotion Granted').",'".odbc_result($App, 'Father_s Occupation')."',
				".odbc_result($App, 'Mother_s Annual Income').",'".odbc_result($App, 'Guardian Qualification')."',
				'".odbc_result($App, 'Guardian Occupation')."',".odbc_result($App, 'Guardian Annual Income').",
				'".odbc_result($App, 'Enquiry No_')."','".odbc_result($App, 'Religion')."',
				'".odbc_result($App, 'Father_s Qualification')."','".odbc_result($App, 'Caste')."',".odbc_result($App, 'Age').",
				".odbc_result($App, 'Months').",".odbc_result($App, 'Father_s Annual Income').",
				'".odbc_result($App, 'Exam Code')."','".odbc_result($App, 'Community')."','".odbc_result($App, 'Mother Tongue')."',1,
				'".odbc_result($App, 'Section')."',1,'".odbc_result($cl_sec, 'Class Code')."','".odbc_result($App, 'Address 3')."','',
				'".odbc_result($App, 'Fee Classification')."','".odbc_result($App, 'Quota')."',
				".odbc_result($App, 'Physically Challanged').",".odbc_result($App, 'Staff Child').",
				'".odbc_result($App, 'Staff Code')."','".odbc_result($App, 'Registration No_')."',
				'".date('Y-m-d',odbc_result($chk_dr, 'Invoice Date'))."','','',0,0,'','','',0,0,'','','ADM',
				'".odbc_result($App, 'Admission For Year')."','".''."','".''."','".''."',".odbc_result($App, 'Distance Covered in KM').",
				".odbc_result($App, 'Transport Fee').",1,".odbc_result($App, 'Sibling').",'".odbc_result($App, 'Sibling Code')."',
				'".odbc_result($App, 'Sibling Name')."','".odbc_result($App, 'Slab Code')."',".odbc_result($App, 'Height').",
				".odbc_result($App, 'Weight').",'1753-01-01 00:00:00','".odbc_result($App, 'Father Office Address 1')."',
				'".odbc_result($App, 'Father Office Address 2')."','".odbc_result($App, 'Father Office City')."',
				'".odbc_result($App, 'Father Office Post Code')."','".odbc_result($App, 'Father Office Country Code')."',
				'".odbc_result($App, 'Mother Office Address 1')."','".odbc_result($App, 'Mother Office Address 2')."',
				'".odbc_result($App, 'Mother Office City')."','".odbc_result($App, 'Mother Office Post Code')."',
				'".odbc_result($App, 'Mother Office Country Code')."','".odbc_result($App, 'Guardian Office Address 1')."',
				'".odbc_result($App, 'Guardian Office Address 2')."','".odbc_result($App, 'Guardian Office City')."',
				'".odbc_result($App, 'Guardian Office Post Code')."','".odbc_result($App, 'Guardian Office Country Code')."',
				'".odbc_result($App, 'System Genrated No_')."','".odbc_result($App, 'Mother Email')."',
				'".odbc_result($App, 'Mother Mobile')."','".odbc_result($App, 'Father Email')."',
				'".odbc_result($App, 'Father Mobile')."',0,'".odbc_result($App, 'User ID')."','".odbc_result($App, 'Portal ID')."',
				'','".odbc_result($App, 'Discount Code')."','".odbc_result($App, 'Discount Code 1')."',".odbc_result($App, 'EWS').",
				".odbc_result($App, 'Enquiry Status').",".odbc_result($App, 'Transport Required').",".odbc_result($App, 'Category').",
				".odbc_result($App, 'Physically Challenged').",'".odbc_result($App, 'Slab Code')."',
				'".odbc_result($App, 'Slab Code')."','1753-01-01 00:00:00','','1753-01-01 00:00:00',
				".odbc_result($App, 'Langauge 1').",".odbc_result($App, 'Language 2').",".odbc_result($cls, 'Sequence').",
				'$LoginID',0,'',0,'','','','".odbc_result($fc1, "fc")."','".odbc_result($fc2, "fc")."','$ms','".odbc_result($App, 'Sibling DOB')."','".odbc_result($App, 'Sibling Class')."',
				'".odbc_result($App, 'Sibling Section')."',".odbc_result($App, 'Sibling').",
				'".odbc_result($App, 'Applicant Relationship')."','".odbc_result($App, 'Remarks')."',
				".odbc_result($App, 'Stream').",1,0,'$ms','$AdmNo',0,'1753-01-01 00:00:00',
				'1753-01-01 00:00:00','1753-01-01 00:00:00','1753-01-01 00:00:00',0,0,0,0,1,
				".odbc_result($App, 'Entry Sequence').")";
		
			//Create Student
			odbc_exec($conn, $sql4) or exit("Create Student // ".odbc_errormsg($conn));
			
			//Create Customer
			$sql5 = "INSERT INTO [Temp Customer]([No_], [Name], [Search Name], [Name 2], [Address], [Address 2], [City], [Contact], [Phone No_], [Telex No_], [Our Account No_], [Territory Code], [Global Dimension 1 Code], [Global Dimension 2 Code], [Chain Name], [Budgeted Amount], [Credit Limit (LCY)], [Customer Posting Group], [Currency Code], [Customer Price Group], [Language Code], [Statistics Group], [Payment Terms Code], [Fin_ Charge Terms Code], [Salesperson Code], [Shipment Method Code], [Shipping Agent Code], [Place of Export], [Invoice Disc_ Code], [Customer Disc_ Group], [Country_Region Code], [Collection Method], [Amount], [Blocked], [Invoice Copies], [Last Statement No_], [Print Statements], [Bill-to Customer No_], [Priority], [Payment Method Code], [Last Date Modified], [Application Method], [Prices Including VAT], [Location Code], [Fax No_], [Telex Answer Back], [VAT Registration No_], [Combine Shipments], [Gen_ Bus_ Posting Group], [Picture], [Post Code], [County], [E-Mail], [Home Page], [Reminder Terms Code], [No_ Series], [Tax Area Code], [Tax Liable], [VAT Bus_ Posting Group], [Reserve], [Block Payment Tolerance], [IC Partner Code], [Prepayment %], [Primary Contact No_], [Responsibility Center], [Shipping Advice], [Shipping Time], [Shipping Agent Service Code], [Service Zone Code], [Allow Line Disc_], [Base Calendar Code], [Copy Sell-to Addr_ to Qte From], [T_I_N_ No_], [Tax Exemption No_], [L_S_T_ No_], [C_S_T_ No_], [P_A_N_ No_], [E_C_C_ No_], [Range], [Collectorate], [Excise Bus_ Posting Group], [State Code], [Structure], [P_A_N_ Reference No_], [P_A_N_ Status], [Export or Deemed Export], [VAT Exempted], [Nature of Services], [Status], [Old Admission No_], [Student Status], [Class], [Section], [Gender], [InsertStatus], [UpdateStatus], [Company Name], [System Genrated No_], [ERPUpdateStatus], [User ID], [Portal ID])
					VALUES ('$AdmNo','".odbc_result($App, 'Name')."','','','".odbc_result($App, 'Address1')."','".odbc_result($App, 'Address2')."','".odbc_result($App, 'City')."','".odbc_result($App, 'Addressee')."','".odbc_result($App, 'Phone Number')."','','$AdmNo','','','','',0,0,'','','','',0,'','','','','','','".odbc_result($App, 'Discount Code')."','".odbc_result($fc1, "fc")."','".odbc_result($App, 'Country')."','',0,0,0,0,0,'$AdmNo',0,'','1753-01-01 00:00:00',0,0,'','','','',0,'','','".odbc_result($App, 'Post Code')."','','".odbc_result($App, 'E-Mail Address')."','','','ADM','',0,'',0,0,'',0,'".odbc_result($App, 'Mobile Number')."','',0,'','','',0,'',0,'','','','','','','','','','".odbc_result($App, 'State')."','','',0,0,0,0,1,'',1,'".odbc_result($App, 'Class')."','".odbc_result($App, 'Section')."',".odbc_result($App, 'Gender').",1,0,'$ms','".odbc_result($App, 'System Genrated No_')."',0,'$LoginID','$LoginID')";
					
			//echo "<br /><br /><br /><br /><br />".$sql5;
			odbc_exec($conn, $sql5) or exit("Create Customer // ".odbc_errormsg($conn));		
			
			$sql6 = "UPDATE [Temp Application] SET [Allot Student]=0, [Student No_]='$AdmNo' WHERE [System Genrated No_]='$id' AND [Company Name]='$ms' ";
			odbc_exec($conn, $sql6) or exit("Update Application // ".odbc_errormsg($conn));
			
			$sql7 = "UPDATE [Temp Enquiry] SET [AdmissionStatus]=1 WHERE [No_]='".odbc_result($App, "Enquiry No_")."' AND [Company Name]='$ms'";
			odbc_exec($conn, $sql7) or exit("Update Enquiry // ".odbc_errormsg($conn));
			
		}
	}
	for($f=0; $f<=$_REQUEST['fee_count']; $f++){
		if($_REQUEST['amt_paid'.$f] !=0 || $_REQUEST['amt_paid'.$f] != ""){
			$sql8 = "INSERT INTO [Ledger Payment]([Customer No], [Fee Description], [Fee Amount], [Payment Date], [Amount Paid],[Company Name] ,[FinYr], [Month], [Year], [Qtr],[Invoice No],[Reverse])
				VALUES
				('".$cust_no."','".$_REQUEST['Fee_description'.$f]."',".$_REQUEST['net_amt'.$f].",'$pay_dt', ".$_REQUEST['amt_paid'.$f].", '$ms', '$FinYr', '". date("m", $today)."', 
				'". date("Y", $today)."', '". $Qtr ."','".odbc_result($chk_dr, 'Invoice No')."',0 )";
			odbc_exec($conn, $sql8) or exit(odbc_errormsg($conn));
			
		}
	}
   	
	//exit();
?>

<script>
	var childWindows = [];
	
	var win = window.open("FeeReceiptRcd.php?id=<?php echo $cust_no?>&ms=<?php echo $ms?>&inv=<?php echo odbc_result($chk_dr, 'Invoice No')?>&amount=<?php echo $amount ?>&paymode=<?php echo $pay_mode?>&bank=<?php echo $bank_name?>&chkno=<?php echo $chk_no?>&chkdt=<?php echo $chk_dt ?>&dtd=<?php echo $pay_dt ?>","windowName", "width=900,height=500,scrollbars=no");
	win.focus();
	childWindows.push(win);	
	
</script>
<?php require_once("../footer.php"); ?>