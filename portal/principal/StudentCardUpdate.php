<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('header.php');

$id=$_REQUEST['id'];
$row = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));

// Update Student Table //

$StuStatNew=(($_REQUEST['StuStatNew']!="")?$_REQUEST['StuStatNew']:0);
$ClassCodeNew=$_REQUEST['ClassCodeNew'];
$EWSNew=(($_REQUEST['EWSNew'] != "")?$_REQUEST['EWSNew']:0);
$DiscCdNew=$_REQUEST['DiscCdNew'];
$RmvDiscCd1=(($_REQUEST['RmvDiscCd1'] != "")?$_REQUEST['RmvDiscCd1']:0);
$DiscCdNew1=$_REQUEST['DiscCdNew1'];
$RmvDiscCd2=(($_REQUEST['RmvDiscCd2']!="")?$_REQUEST['RmvDiscCd2']:0);
$TransportSlab=$_REQUEST['TransportSlab'];
$RmvDiscTrans=(($_REQUEST['RmvDiscTrans']!="")?$_REQUEST['RmvDiscTrans']:0);
$TPTAvailingDate=(($_REQUEST['TPTAvailingDate']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['TPTAvailingDate']))):"1753-01-01 00:00:00.000");
$TPTWithdrawalDate=(($_REQUEST['TPTWithdrawalDate']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['TPTWithdrawalDate']))):"1753-01-01 00:00:00.000");
?>
<div class="container">
<?php

//Check section with Class Section Code
$ChkSec = odbc_exec($conn, "SELECT [Class Code], [Class], [Section], [Curriculum], [Academic Year] FROM [Class Section] WHERE [Class]='".  odbc_result($row, "Class")."' AND [Section]='".odbc_result($row, "Section")."' AND [Academic Year]='".  odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'");
$NewClass = odbc_exec($conn, "SELECT [Class Code], [Class], [Section], [Curriculum], [Academic Year] FROM [Class Section] WHERE [Class Code]='".$ClassCodeNew."' AND [Company Name]='$ms'");
	
if(odbc_num_rows($ChkSec)!= 0){
    $ClassSectionCode = odbc_result($ChkSec, "Class Code");
    
    // Update Temp Student Table //
    $SQL = "UPDATE [Temp Student] SET ";
	if($StuStatNew !=0) $SQL .= "[Student Status] = $StuStatNew, [Date of Leaving]='".date('d/M/y')."', [Student Status 1] =0,";
        if ($ClassCodeNew != "") {
		$SQL .= "[Class Code] = '$ClassCodeNew', [Class Code 1] = '',";
		//Change  Class Code		
		$SQL .= "[Class] = '".odbc_result($NewClass,'Class')."', [Section] = '".odbc_result($NewClass,'Section')."', [Curriculum] = '".odbc_result($NewClass,'Curriculum')."', [Academic Year] = '".odbc_result($NewClass,'Academic Year')."', ";
		//Update Customer Card...
		$SelCust=odbc_exec($conn, "UPDATE [Temp Customer] SET [UpdateStatus]=1, 
			[Class]='".odbc_result($NewClass,'Class')."', 
			[Section]='".odbc_result($NewClass,'Section')."', [Student Status]='$StuStatNew', [User ID]='$LoginID', [Portal ID]='$LoginID' WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg());
	}
	if($EWSNew ==1 ) $SQL .= "[EWS]=$EWSNew, [EWS 1]=0,";
	//Discount Code 1 Classification
	if($DiscCdNew != ""){ 
		$SQL .= "[Discount Code]= '$DiscCdNew',[Discount Code New] = '',";	
		$DiscCdClass1 = odbc_exec($conn, "SELECT [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Company Name]='$ms' AND [No_]='$DiscCdNew'") or die(odbc_errormsg($conn));
		$SQL .= "[Discount Classification]='".odbc_result($DiscCdClass1, 'Fee Clasification Code')."', ";
	}
	//Discount Code 2 Classification
	if($DiscCdNew1 != "") {
		$SQL .= "[Discount Code 1]= '$DiscCdNew1', [Discount Code1 New] = '',";
		$DiscCdClass2 = odbc_exec($conn, "SELECT [Fee Clasification Code] FROM [Discount Fee Header] WHERE [Company Name]='$ms' AND [No_]='$DiscCdNew1'") or die(odbc_errormsg($conn));
		$SQL .= "[Discount Classification1]='".odbc_result($DiscCdClass2, 'Fee Clasification Code')."', ";
	}
	if($TransportSlab != "") $SQL .= "[Slab Code]='$TransportSlab', [Transport Slab Code New]='', ";
	if($TPTAvailingDate != "" ) $SQL .= "[TPT Availing Date] = '$TPTAvailingDate', [TPT Availing Date-T] = '1753-01-01 00:00:00.000', ";
	if($TPTWithdrawalDate != "" ) $SQL .= "[TPT Withdrawal Date] = '$TPTWithdrawalDate', [TPT Withdrawal Date-T] = '1753-01-01 00:00:00.000', ";
	if($TransportSlab != ""){
		//Update Trans Slab....
		$TransFee=odbc_exec($conn, "SELECT [Distance covered], [Amount] FROM [Transport Slab] WHERE [Company Name]='$ms' AND [Slab Code]='$TransportSlab' ") or die(odbc_errormsg($conn));
		$SQL .= "[Distance Covered in KM]='".odbc_result($TransFee, 'Distance covered')."', [Transport Fee]='".odbc_result($TransFee, 'Amount')."', ";	//student slab update
	}
	$SQL .= "[UpdateStatus]=1 WHERE [Company Name]='$ms' AND [No_]='$id'";

	$result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
	
	if($RmvDiscCd1 == 1){
		$SQL1 = "UPDATE [Temp Student] SET [Discount Code]= '',[Discount Classification]='', [Bool2]=0, [UpdateStatus]=1 WHERE [Company Name]='$ms' AND [No_]='$id'";
		$result = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
	}
	if($RmvDiscCd2 == 1){
		$SQL2 = "UPDATE [Temp Student] SET [Discount Code 1]= '', [Discount Classification1]='', [Bool3]=0, [UpdateStatus]=1 WHERE [Company Name]='$ms' AND [No_]='$id'";
		$result = odbc_exec($conn, $SQL2) or die(odbc_errormsg($conn));
	}
	if($RmvDiscTrans == 1){
		$SQL3 = "UPDATE [Temp Student] SET [Slab Code]='', [Distance Covered in KM]=0,[Transport Fee]='0.00',  [Transport Slab Code New]= '', [Bool1]=0, [TPT Withdrawal Date] = '', [TPT Availing Date] = '', [UpdateStatus]=1 WHERE [Company Name]='$ms' AND [No_]='$id'";
		$result = odbc_exec($conn, $SQL3) or die(odbc_errormsg($conn));
	}
	
   //Update Customer Card...
	if($StuStatNew !=0){
		$SelCust=odbc_exec($conn, "UPDATE [Temp Customer] SET [UpdateStatus]=1, 
			[Class]='".odbc_result($NewClass,'Class')."', 
			[Section]='".odbc_result($NewClass,'Section')."', [Student Status]='$StuStatNew', [User ID]='$LoginID', [Portal ID]='$LoginID' WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg());
	}    
	
    //Approval Request;
    if($StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !="" || $StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !=""){
        $Approver = odbc_exec($conn, "SELECT [ApproverID], [ApproverEmail] FROM [approvalmaster] WHERE [CompanyName]='$ms'") or die(odbc_errormsg($conn));
        
        if(odbc_num_rows($Approver) > 0){            
            $apvr = mysql_fetch_array($Approver); 
            
            $ApvrSQL = "UPDATE [approvalrequest] SET 
                [ApproverDateTime]='".date('d/M/Y')."',
                [Status]='Approved',
                [CompanyName]='$ms'
		WHERE [AdmissionNo]='$id' ";
            
            odbc_exec($conn, $ApvrSQL) or die(odbc_errormsg($conn));
        }
        else{
            echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=3'>";
        }
    }
    
    if($result){
        echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=0'>";
    }
    else{
        echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=1'>";
    }
}
else{
    echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=2'>";
}

?>
</div>
<?php require_once '../footer.php';?>