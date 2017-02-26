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
$Language1=$_REQUEST['Language1'];
$Language2=$_REQUEST['Language2'];
$Section=$_REQUEST['Section'];
$HostelCode=$_REQUEST['HostelCode'];
$House=$_REQUEST['House'];
$Stream=$_REQUEST['Stream'];

$CommunicationReference=$_REQUEST['CommunicationReference'];
$ContactName=$_REQUEST['ContactName'];
$Address1=$_REQUEST['Address1'];
$Address2=$_REQUEST['Address2'];
$City=$_REQUEST['City'];
$PostCode=$_REQUEST['PostCode'];
$State=$_REQUEST['State'];
$Country=$_REQUEST['Country'];
$PhoneNo=$_REQUEST['PhoneNo'];
$MobileNo=$_REQUEST['MobileNo'];
$Email=$_REQUEST['Email'];
$FatherEmail=$_REQUEST['FatherEmail'];
$MotherEmail=$_REQUEST['MotherEmail'];

$FatherName=$_REQUEST['FatherName'];
$PassportNo=$_REQUEST['PassportNo'];
$FatherQualification=$_REQUEST['FatherQualification'];
$PassportExpDt=(($_REQUEST['PassportExpDt']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['PassportExpDt']))):"1753-01-01 00:00:00.000");
$FatherOccupation=$_REQUEST['FatherOccupation'];
$VisaNo=$_REQUEST['VisaNo'];
$FatherAnnualIncome=$_REQUEST['FatherAnnualIncome'];
$VisaExpDt=(($_REQUEST['VisaExpDt']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['VisaExpDt']))):"1753-01-01 00:00:00.000");
$MotherName=$_REQUEST['MotherName'];
$MotherQualification=$_REQUEST['MotherQualification'];
$MotherOccupation=$_REQUEST['MotherOccupation'];
$MotherAnnualIncome=$_REQUEST['MotherAnnualIncome'];
$GaurdianName=$_REQUEST['GaurdianName'];
$GaurdianQualification=$_REQUEST['GaurdianQualification'];
$GaurdianOccupation=$_REQUEST['GaurdianOccupation'];
$GaurdianAnnualIncome=$_REQUEST['GaurdianAnnualIncome'];

$FatherOfficeAddress1=$_REQUEST['FatherOfficeAddress1'];
$FatherOfficeAddress2=$_REQUEST['FatherOfficeAddress2'];
$FatherOfficeCity=$_REQUEST['FatherOfficeCity'];
$FatherOfficePostCode=$_REQUEST['FatherOfficePostCode'];
$FatherOfficeCountry=$_REQUEST['FatherOfficeCountry'];
$MotherOfficeAddress1=$_REQUEST['MotherOfficeAddress1'];
$MotherOfficeAddress2=$_REQUEST['MotherOfficeAddress2'];
$MotherOfficeCity=$_REQUEST['MotherOfficeCity'];
$MotherOfficePostCode=$_REQUEST['MotherOfficePostCode'];
$MotherOfficeCountry=$_REQUEST['MotherOfficeCountry'];
$GuardianRelationship=$_REQUEST['GuardianRelationship'];
$GaurdianOfficeAddress1=$_REQUEST['GaurdianOfficeAddress1'];
$GaurdianOfficeAddress2=$_REQUEST['GaurdianOfficeAddress2'];
$GaurdianOfficeCity=$_REQUEST['GaurdianOfficeCity'];
$GaurdianOfficePostCode=$_REQUEST['GaurdianOfficePostCode'];
$GaurdianOfficeCountry=$_REQUEST['GaurdianOfficeCountry'];

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

$Sibling = (($_REQUEST['Sibling'] =="1")?$_REQUEST['Sibling']:0);
$SiblingCode = $_REQUEST['SiblingCode'];
$SiblingName = $_REQUEST['SiblingName'];
$SiblingClass = $_REQUEST['SiblingClass'];
$SiblingSection = $_REQUEST['SiblingSection'];
$SiblingDOB = $_REQUEST['SiblingDOB'];
$SiblingNo = $_REQUEST['SiblingNo'];
?>
<div class="container">
<?php

//Check section with Class Section Code
//$ChkSec = odbc_exec($conn, "SELECT [Class Code] FROM [Class Section] WHERE [Class]='". odbc_result($row, "Class")."' AND [Section]='".odbc_result($row, "Section")."' AND [Academic Year]='".  odbc_result($row, "Academic Year")."' AND [Company Name]='$ms'");
$NewClass = odbc_exec($conn, "SELECT [Class Code], [Section] FROM [Class Section] WHERE [Class]='".odbc_result($row, 'Class')."' AND [Section]='$Section' AND [Curriculum]='".odbc_result($row, 'Curriculum')."' AND [Academic Year]='".odbc_result($row, 'Academic Year')."' AND [Company Name]='$ms'");		
if(odbc_num_rows($NewClass)!= 0){
	//$ClassSectionCode = odbc_result($ChkSec, "Class Code");
    
    // Update Temp Student Table //
	$SQL = "UPDATE [Temp Student] SET 
            [Address To]='$CommunicationReference',
            [Address1]='".str_replace("'", "''",$Address1)."',
            [Address2]='".str_replace("'", "''",$Address2)."',
            [Addressee]='$ContactName',
            [Applicant Relationship]='$GuardianRelationship',
            [City]='$City',
            [Class Code] = '".odbc_result($NewClass, 'Class Code')."',
            [Country]='$Country',
            [E-Mail Address]='$Email',
            [Father Email]='$FatherEmail',
            [Father Office Address 1]='$FatherOfficeAddress1',
            [Father Office Address 2]='$FatherOfficeAddress2',
            [Father Office City]='$FatherOfficeCity',
            [Father Office Country Code]='$FatherOfficeCountry',
            [Father Office Post Code]='$FatherOfficePostCode',
            [Father_s Annual Income]='$FatherAnnualIncome',
            [Father_s Name]='$FatherName',
            [Father_s Occupation]='$FatherOccupation',
            [Father_s Qualification]='$FatherQualification',
            [Guardian Annual Income]='$GaurdianAnnualIncome',
            [Guardian Name]='$GaurdianName',
            [Guardian Occupation]='$GaurdianOccupation',
            [Guardian Office Address 1]='$GaurdianOfficeAddress1',
            [Guardian Office Address 2]='$GaurdianOfficeAddress2',
            [Guardian Office City]='$GaurdianOfficeCity',
            [Guardian Office Country Code]='$GaurdianOfficeCountry',
            [Guardian Office Post Code]='$GaurdianOfficePostCode',
            [Guardian Qualification]='$GaurdianQualification',
            [Hostel Code]='$HostelCode',
            [House]='$House',
            [Langauge 1]='$Language1',
            [Language 2]='$Language2',
            [Mobile Number]='$MobileNo',
            [Mother Email]='$MotherEmail',
            [Mother Office Address 1]='$MotherOfficeAddress1',
            [Mother Office Address 2]='$MotherOfficeAddress2',
            [Mother Office City]='$MotherOfficeCity',
            [Mother Office Country Code]='$MotherOfficeCountry',
            [Mother Office Post Code]='$MotherOfficePostCode',
            [Mother_s Annual Income]='$MotherAnnualIncome',
            [Mother_s Name]='$MotherName',
            [Mother_s Occupation]='$MotherOccupation',
            [Mother_s Qualification]='$MotherQualification',
            [Passport Exp Date]='$PassportExpDt',
            [Passport No_]='$PassportNo',
            [Phone Number]='$PhoneNo',
            [Post Code]='$PostCode',
            [Section]='$Section',
            [State]='$State',
            [Stream]='$Stream',
            [Visa Exp Date]='$VisaExpDt',
            [Visa No_]='$VisaNo',
            [Student Status 1] = $StuStatNew,
            [Class code 1] = '$ClassCodeNew',
            [EWS 1] = $EWSNew,
            [Discount Code New] = '$DiscCdNew',
            [Discount Code1 New] = '$DiscCdNew1',
            [Transport Slab Code New] = '$TransportSlab',
            [TPT Availing Date-T] = '$TPTAvailingDate',
            [TPT Withdrawal Date-T] = '$TPTWithdrawalDate',
            [Bool1] = $RmvDiscTrans,
            [Bool2] = $RmvDiscCd1,
            [Bool3] = $RmvDiscCd2,
	    [Sibling] = $Sibling,
	    [Sibbling Name] = '$SiblingName',
	    [Sibling Class] = '$SiblingClass',
	    [Sibling Section] = '$SiblingSection',
	    [Sibling DOB] = '$SiblingDOB',
	    [Sibbling Code] = '$SiblingCode',
	    [Sibbling No_] = '$SiblingNo',
            [UpdateStatus]=1";
	    
	$SQL .= "WHERE [Company Name]='$ms' AND [No_]='$id'";
	//exit($SQL);
	$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
	$SelCust=odbc_exec($conn, "UPDATE [Temp Customer] SET [UpdateStatus]=1, [Section]='".odbc_result($NewClass,'Section')."' WHERE [No_]='' AND [Company Name]='$ms'") or die(odbc_errormsg());
	//Approval Request;
	if($StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !="" || $StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !=""){
		$Approver = odbc_exec($conn, "SELECT [ApproverID], [ApproverEmail] FROM [approvalmaster] WHERE [CompanyName]='$ms'") or die(mysql_error());
        
		if(odbc_num_rows($Approver) > 0){            
			//$apvr = mysql_fetch_array($Approver); 
            
			$ApvrSQL = "INSERT INTO [approvalrequest] SET 
				[Table] = 'STUDENT',
				[AdmissionNo]='$id',
				[Name]='".odbc_result($row, "Name")."',
				[UserID]='$LoginID',
				[ApproverID]='".odbc_result($apvr, "ApproverID")."',
				[RequestDateTime]='".date('d/M/Y')."',
				[Status]='Open',
				[CompanyName]='$ms'";
            
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