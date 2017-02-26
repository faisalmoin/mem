
<?php
    require_once("../db.txt");
    $rcount = $_REQUEST['rCount'];
    $cCount = $_REQUEST['cCount'];
    $FinYr = $_REQUEST['FinYr'];
    $fee = $_REQUEST['fee'];
   // print_r($_POST);
   // die();
    if($fee == 'Fee Head'){
    for($i=0; $i<=($rcount-1); $i++ ){
    	for($j=0; $j <= $cCount; $j++){
    		$sql = "INSERT INTO [MemFin Royalty Fee]([Financial Year],[Qtr], [Trust Name], [Trust ID], [Company Name], [Invoice No],[Invoice Type],
    									[Date], [Class], [Student Count], [Fee Description], [Fee Amount])
    
                        VALUES ('".$_REQUEST['FinYr']."', '".$_REQUEST['Qtr']."', '".$_REQUEST['TrustName']."',
                                        '".$_REQUEST['ID']."', '".$_REQUEST['companyName']."',
                                        '".$_REQUEST['Invoiceno']."' , '".$_REQUEST['fee']."' , '".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
                                        '".$_REQUEST['Class'.$i]."', '".$_REQUEST['StuCount'.$i]."',";

    		$sql .= " '".$_REQUEST['FeeDesc'.$i.$j]."', ";
    		if($_REQUEST['FeeAmt'.$i.$j] == ""){
    			$sql .= "'0' ";
    		}
    		else{
    			$sql .= "'".$_REQUEST['FeeAmt'.$i.$j]."' ";
    		}
    		$sql .= " )";
    		//echo "<br />$sql<br />";
    		odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
    	}
    	
    }
}

if($fee == 'Generated'){
    for($i=0; $i<=($rcount-1); $i++ ){
    	for($j=0; $j <= $cCount; $j++){
    		$sql = "INSERT INTO [MemFin Royalty Fee]([Financial Year],[Qtr], [Trust Name], [Trust ID], [Company Name], [Invoice No],[Invoice Type],
    									[Date], [Class], [Student Count], [Fee Description], [Fee Amount])
    
                        VALUES ('".$_REQUEST['FinYr']."', '".$_REQUEST['Qtr']."', '".$_REQUEST['TrustName']."',
                                        '".$_REQUEST['ID']."', '".$_REQUEST['companyName']."',
                                        '".$_REQUEST['Invoiceno']."' , '".$_REQUEST['fee']."' , '".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
                                        '".$_REQUEST['Class1'.$i]."', '".$_REQUEST['StuCount1'.$i]."',";

    		$sql .= " '".$_REQUEST['FeeDescgen'.$i.$j]."', ";
    		if($_REQUEST['FeeAmtgen'.$i.$j] == ""){
    			$sql .= "'0' ";
    		}
    		else{
    			$sql .= "'".$_REQUEST['FeeAmtgen'.$i.$j]."' ";
    		}
    		$sql .= " )";
    		//echo "<br />$sql<br />";
    		odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
    	}
    	
    }
}
       
    if($fee == 'Collected'){
    for($i=0; $i<=($rcount-1); $i++ ){
    	for($j=0; $j <= $cCount; $j++){
    		$sql = "INSERT INTO [MemFin Royalty Fee]([Financial Year],[Qtr], [Trust Name], [Trust ID], [Company Name], [Invoice No],[Invoice Type],
    									[Date], [Class], [Student Count], [Fee Description], [Fee Amount])
    
                        VALUES ('".$_REQUEST['FinYr']."', '".$_REQUEST['Qtr']."', '".$_REQUEST['TrustName']."',
                                        '".$_REQUEST['ID']."', '".$_REQUEST['companyName']."',
                                        '".$_REQUEST['Invoiceno']."' , '".$_REQUEST['fee']."' , '".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
                                        '".$_REQUEST['Class2'.$i]."', '".$_REQUEST['StuCount2'.$i]."',";

    		$sql .= " '".$_REQUEST['FeeDesccol'.$i.$j]."', ";
    		if($_REQUEST['FeeAmtcol'.$i.$j] == ""){
    			$sql .= "'0' ";
    		}
    		else{
    			$sql .= "'".$_REQUEST['FeeAmtcol'.$i.$j]."' ";
    		}
    		$sql .= " )";
    		//echo "<br />$sql<br />";
    		odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
    	}
    	
    }
}
    
    
    
    if(basename($_FILES["fileToUpload"]["name"])){
    	require_once("FileToUpload.php");
    }

    
	odbc_exec($conn, "INSERT INTO [MemFin Royalty Credit]([Invoice SoftCopy],[Generate], [Invoice No], [Date], [Total Amount], [Royalty %],
			[Total Royalty], [Royalty Amount], [Net Payble], [Service Tax], [Academic Year], [Company Name],[Trust Name],[Trust ID],[Discount],[Discount Description],[Invoice Discount],[select Invoice]) 
			VALUES ('$target_file','".$_REQUEST['Generate']."', '".$_REQUEST['Invoiceno']."', '".strtotime(str_replace("/", " ",$_REQUEST["Date"].date('H:i:s')))."',
			".$_REQUEST['totalamount'].", '".$_REQUEST['perRoyalty']."', '".$_REQUEST['totalRoyalty']."',
			'".$_REQUEST['feeamount']."', '".$_REQUEST['payble']."', '".$_REQUEST['servisetax']."', 
			'".$_REQUEST['FinYr']."', '".$_REQUEST['companyName']."', '".$_REQUEST['TrustName']."', '".$_REQUEST['ID']."', '".$_REQUEST['discount']."', '".$_REQUEST['discountdiscription']."', '".$_REQUEST['invoicediscount']."', '".$_REQUEST['fee']."' )") or die(odbc_errormsg($conn));
	
         echo '<META http-equiv="refresh" content="0;URL=RoyaltyList.php"> ';
        
	
?>	
 <!--script>
	var childWindows = [];
	
	var win = window.open("FeeReceiptRcd.php?id=<--?php echo $cust_no?>&ms=<--?php echo $ms?>&inv=<--?php echo odbc_result($chk_dr, 'Invoice No')?>&amount=<?php echo $amount ?>&paymode=<?php echo $pay_mode?>&bank=<?php echo $bank_name?>&chkno=<?php echo $chk_no?>&chkdt=<?php echo $chk_dt ?>&dtd=<?php echo $pay_dt ?>","windowName", "width=900,height=500,scrollbars=no");
	win.focus();
	childWindows.push(win);	
	
</script-->
     	