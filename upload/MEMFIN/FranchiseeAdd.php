
<?php
    require_once("../db.txt");
    if(basename($_FILES["fileToUpload"]["name"])){
    	require_once("FileToUpload.php");
    }
	odbc_exec($conn, "INSERT INTO [MemFin Franchisee Credit]([Invoice SoftCopy],[Generate], [Invoice No], [Date], [Total Amount],
			[Total Franchisee], [Franchisee Amount], [Net Payble], [Service Tax], [Academic Year], [Company Name],[Trust Name],[Trust ID]) 
			VALUES ('$target_file','".$_REQUEST['Generate']."', '".$_REQUEST['Invoiceno']."', '".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
			'".$_REQUEST['totalamount']."', '".$_REQUEST['totalRoyalty']."',
			'".$_REQUEST['feeamount']."', '".$_REQUEST['payble']."', '".$_REQUEST['servisetax']."', 
			'".$_REQUEST['FinYr']."', '".$_REQUEST['companyName']."', '".$_REQUEST['TrustName']."', '".$_REQUEST['ID']."')") or die(odbc_errormsg($conn));
	echo '<META http-equiv="refresh" content="0;URL=FranchiseeList.php"> ';
 ?>	
 
     	