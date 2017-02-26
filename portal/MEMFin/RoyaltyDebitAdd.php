
<?php
    require_once("../db.txt");
    odbc_exec($conn, "INSERT INTO [MemFin Royalty Debit]([Debit Amount], [Deduction Amount], [Total Amount], [Date], [Mode Of Payment],
			[Bank Name], [Cheque DD No], [Cheque DD Date],[Trust ID],[Trust Name],[Company Name],[Voucher Number]) 
			VALUES ('".$_REQUEST['Amount']."', '".$_REQUEST['DeductionAmt']."', '".$_REQUEST['TotalAmt']."',
    		'".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
			 '".$_REQUEST['PaymentMode']."','".$_REQUEST['BankName']."', '".$_REQUEST['ChequeDDNo']."', 
    		'".strtotime(str_replace("/", " ",$_REQUEST["ChequeDDt"].date('H:i:s')))."', 
			 '".$_REQUEST['ID']."', '".$_REQUEST['TrustName']."', '".$_REQUEST['companyName']."', '".$_REQUEST['VoucherNo']."')") or die(odbc_errormsg($conn));
	echo '<META http-equiv="refresh" content="0;URL=RoyaltyList.php"> ';
 ?>	
 
     