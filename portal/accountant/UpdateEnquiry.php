<?php
	error_reporting(E_ALL);
	require_once("header.php");
	
	echo "<br /><br /> <br />";
    $id = $_REQUEST['EnquiryNo'];
    $UserLoginID=strtoupper(str_replace("'", "''",$LoginID));
    $EnquiryNo=str_replace("'", "''", $_REQUEST['EnquiryNo']);
    $EnquiryDate=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['EnquiryDate'])));
    $AcadYear=str_replace("'", "''",$_REQUEST['AcadYear']);
    $StudentName=str_replace("'", "''",$_REQUEST['StudentName']);
    $DOB=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DOB'])));
    $ClassApplied=str_replace("'", "''",$_REQUEST['ClassApplied']);
    $Curricullum=str_replace("'", "''",$_REQUEST['Curricullum']);
    $MotherName=str_replace("'", "''",$_REQUEST['MotherName']);
    $FatherName=str_replace("'", "''",$_REQUEST['FatherName']);
    $GuardianName=str_replace("'", "''",$_REQUEST['GuardianName']);
    $PreviousSchool=str_replace("'", "''",$_REQUEST['PreviousSchool']);
    $PrevSchLastClass=str_replace("'", "''",$_REQUEST['PrevSchLastClass']);
    $PrevSchCurricullum=str_replace("'", "''",$_REQUEST['PrevSchCurricullum']);
    $PrevSchMedium=strtoupper(str_replace("'", "''",$_REQUEST['PrevSchMedium']));
    $CommunicationReference=strtoupper(str_replace("'", "''",$_REQUEST['CommunicationReference']));
    $Address=strtoupper(str_replace("'", "''",$_REQUEST['Address']));
    $Address1=str_replace("'", "''",$_REQUEST['Address1']);
    $Address2=str_replace("'", "''",$_REQUEST['Address2']);
    $City=str_replace("'", "''",$_REQUEST['City']);
    $State=strtoupper(str_replace("'", "''",$_REQUEST['State']));
    $PostCode=str_replace("'", "''",$_REQUEST['PostCode']);
    $Landline=str_replace("'", "''",$_REQUEST['Landline']);
    $Mobile=str_replace("'", "''",$_REQUEST['Mobile']);
    $Country=strtoupper(str_replace("'", "''",$_REQUEST['Country']));
    $Email=str_replace("'", "''",$_REQUEST['Email']);
    $FatherQualification=str_replace("'", "''",$_REQUEST['FatherQualification']);
    $FatherOfficeAddress1=str_replace("'", "''",$_REQUEST['FatherOfficeAddress1']);
    $FatherOccupation=str_replace("'", "''",$_REQUEST['FatherOccupation']);
    $FatherOfficeAddress2=str_replace("'", "''",$_REQUEST['FatherOfficeAddress2']);
    $FatherAnnualIncome=str_replace("'", "''",$_REQUEST['FatherAnnualIncome']);
    $FatherOfficePostCode=str_replace("'", "''",$_REQUEST['FatherOfficePostCode']);
    $FatherOfficeCity=str_replace("'", "''",$_REQUEST['FatherOfficeCity']);
    $FatherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeCountry']));
    $MotherQualification=str_replace("'", "''",$_REQUEST['MotherQualification']);
    $MotherOfficeAddress1=str_replace("'", "''",$_REQUEST['MotherOfficeAddress1']);
    $MotherOccupation=str_replace("'", "''",$_REQUEST['MotherOccupation']);
    $MotherOfficeAddress2=str_replace("'", "''",$_REQUEST['MotherOfficeAddress2']);
    $MotherAnnualIncome=str_replace("'", "''",$_REQUEST['MotherAnnualIncome']);
    $MotherOfficePostCode=str_replace("'", "''",$_REQUEST['MotherOfficePostCode']);
    $MotherOfficeCity=str_replace("'", "''",$_REQUEST['MotherOfficeCity']);
    $MotherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeCountry']));
    $GuardianRelationship=str_replace("'", "''",$_REQUEST['GuardianRelationship']);
    $GuardianQualification=str_replace("'", "''",$_REQUEST['GuardianQualification']);
    $GuardianOfficeAddress1=str_replace("'", "''",$_REQUEST['GuardianOfficeAddress1']);
    $GuardianOccupation=str_replace("'", "''",$_REQUEST['GuardianOccupation']);
    $GuardianOfficeAddress2=str_replace("'", "''",$_REQUEST['GuardianOfficeAddress2']);
    $GuardianOfficePostCode=str_replace("'", "''",$_REQUEST['GuardianOfficePostCode']);
    $GuardianOfficeCity=str_replace("'", "''",$_REQUEST['GuardianOfficeCity']);
    $GuardianOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['GuardianOfficeCountry']));
    $EnquiryType=strtoupper(str_replace("'", "''",$_REQUEST['EnquiryType']));
    $EnquirySource=strtoupper(str_replace("'", "''",$_REQUEST['EnquirySource']));
    $Distance=str_replace("'", "''",$_REQUEST['Distance']);
    $Citizenship=str_replace("'", "''",$_REQUEST['Citizenship']);
    $EnquiryRemarks=str_replace("'", "''",$_REQUEST['EnquiryRemarks']);
    $Followup=str_replace("'", "''",$_REQUEST['Followup']);

    if($_REQUEST['Gender'] == ""){
        $Gender=0;
    }
    else{
        $Gender=str_replace("'", "''",$_REQUEST['Gender']);
    }
    if($_REQUEST['MotherPreffix']== ""){
        $MotherPreffix = 0;
    }
    else{
        $MotherPreffix=str_replace("'", "''",$_REQUEST['MotherPreffix']);
    }
    if($_REQUEST['FatherPreffix']== ""){
        $FatherPreffix = 0;
    }
    else{
        $FatherPreffix=str_replace("'", "''",$_REQUEST['FatherPreffix']);
    }
    if($_REQUEST['GuardianPreffix']== ""){
        $GuardianPreffix = 0;
    }
    else{
        $GuardianPreffix=str_replace("'", "''",$_REQUEST['GuardianPreffix']);
    }
    if($_REQUEST['Transport'] == ""){
        $Transport = 0;
    }
    else{
        $Transport=str_replace("'", "''",$_REQUEST['Transport']);
    }

    if($_REQUEST['PhysicallyChallanged'] == ""){
        $PhysicallyChallanged = 0;
    }
    else{
        $PhysicallyChallanged=str_replace("'", "''",$_REQUEST['PhysicallyChallanged']);
    }
    if($_REQUEST['ConcessionCategory'] == ""){
        $ConcessionCategory = 0;
    }
    else{
        if($_REQUEST['ConcessionCategory'] < "5"){
            $ConcessionCategory=str_replace("'", "''",$_REQUEST['ConcessionCategory']);
            $EWS = 0;
        }
        else{
            $EWS = 1;
        }
    }
    if($_REQUEST['Language2'] == ""){
        $Language2 = 0;
    }
    else{
        $Language2=str_replace("'", "''",$_REQUEST['Language2']);
    }
    if($_REQUEST['Language3'] == ""){
        $Language3 = 0;
    }
    else{
        $Language3=str_replace("'", "''",$_REQUEST['Language3']);
    }
    if($_REQUEST['GuardianAnnualIncome'] == ""){
        $GuardianAnnualIncome=0;
    }
    else{
        $GuardianAnnualIncome=str_replace("'", "''",$_REQUEST['GuardianAnnualIncome']);
    }
    if($_REQUEST['EnquiryStatus'] == ""){
        $EnquiryStatus=0;
    }
    else{
        $EnquiryStatus=str_replace("'", "''",$_REQUEST['EnquiryStatus']);
    }
    if($_REQUEST['In-active'] == ""){
        $Inactive=0;
    }
    else{
        $Inactive=str_replace("'", "''",$_REQUEST['In-active']);
    }
    if($_REQUEST['NextFollowupDate']!=""){
        $NextFollowupDate=$_REQUEST['NextFollowupDate'];
    }/*
    else{
       $NextFollowupDate="";
    }*/

	
	if($StudentName != "" || $EnquiryDate != "" || $DOB !="" || $EnquiryType !="" || $EnquirySource !=""){
	

    //Check for Follow-up
    if($Followup != "") {

        $flQuery = odbc_exec($conn, "SELECT [FollowUP1], [FollowUP2], [FollowUP3] FROM [Temp Enquiry] WHERE [No_]='$id' AND [Company Name]='$ms' ");
        if (!odbc_fetch_array($flQuery)) {
            exit("Unable to execute Followup Query...");
        }
        else {
            if (odbc_result($flQuery, "FollowUP1") == "") {
                $rem = odbc_result($conn, 0);
                $FL = "UPDATE [Temp Enquiry] SET [FollowUP1] = '$Followup' WHERE [No_]='$id' AND [Company Name]='$ms'";
            }
            if (odbc_result($flQuery, "FollowUP1") != "" && odbc_result($flQuery, "FollowUP2") == "") {
                $FL = "UPDATE [Temp Enquiry] SET [FollowUP2] = '$Followup' WHERE [No_]='$id' AND [Company Name]='$ms'";
            }
            if (odbc_result($flQuery, "FollowUP1") != "" && odbc_result($flQuery, "FollowUP2") != "" && odbc_result($flQuery, "FollowUP3") == "") {
                $FL = "UPDATE [Temp Enquiry] SET [FollowUP3] = '$Followup' WHERE [No_]='$id' AND [Company Name]='$ms'";
            }
		
            $FLUP = odbc_prepare($conn, $FL);
            if (!odbc_execute($FLUP)) {
                exit("Unable to update Follow-up");
            }           
        }
    }
    
$result = "UPDATE [Temp Enquiry] SET
                [No_] ='$EnquiryNo',
                [Name] ='$StudentName',
                [Gender] =$Gender,
                [Type Of Enquiry] ='$EnquiryType',
                [Enquiry Source] ='$EnquirySource',
                [Relationship with Applicant] ='$GuardianRelationship',
                [Date of Birth] ='$DOB',
                [Father_s Name] ='$FatherName',
                [Mother_s Name] ='$MotherName',
                [Citizenship] ='$Citizenship',
                [Admission For Year] ='$AcadYear',
                [Enquiry Date]='$EnquiryDate',
                [Class Applied] ='$ClassApplied',
                [Name Of The Previous Institute] ='$PreviousSchool',
                [Medium Of Instruction] ='$PrevSchMedium',
                [Curriculum Intrested] ='$Curricullum',
                [Class Last Attended] ='$PrevSchLastClass',
                [Curriculum Followed] ='$PrevSchCurricullum',
                [Address To] ='$CommunicationReference',
                [Addressee] ='$Address',
                [Address 1] ='$Address1',
                [Address 2] ='$Address2',
                [City] ='$City',
                [Post Code] ='$PostCode',
                [Country Code] ='$Country',
                [E-Mail Address] ='$Email',
                [Mobile Number] ='$Mobile',
                [Phone Number] ='$Landline',
                [State] ='$State',
                [Mother_s Qualification] ='$MotherQualification',
                [Mother_s Occupation] ='$MotherOccupation',
                [Guardian Name] ='$GuardianName',
                [Father_s Occupation] ='$FatherOccupation',
                [Mother_s Annual Income] =$MotherAnnualIncome,
                [Guardian Qualification] ='$GuardianQualification',
                [Guardian Occupation] ='$GuardianOccupation',
                [Guardian Annual Income] =$GuardianAnnualIncome,
                [Father_s Qualification] ='$FatherQualification',
                [Father_s Annual Income] =$FatherAnnualIncome,
                [Father Office Address 1] ='$FatherOfficeAddress1',
                [Father Office Address 2] ='$FatherOfficeAddress2',
                [Father Office City] ='$FatherOfficeCity',
                [Father Office Post Code] ='$FatherOfficePostCode',
                [Father Office Country Code] ='$FatherOfficeCountry',
                [Mother Office Address 1] ='$MotherOfficeAddress1',
                [Mother Office Address 2] ='$MotherOfficeAddress2',
                [Mother Office City] ='$MotherOfficeCity',
                [Mother Office Post Code] ='$MotherOfficePostCode',
                [Mother Office Country Code] ='$MotherOfficeCountry',
                [Guardian Office Address 1] ='$GuardianOfficeAddress1',
                [Guardian Office Address 2] ='$GuardianOfficeAddress2',
                [Guardian Office City] ='$GuardianOfficeCity',
                [Guardian Office Post Code] ='$GuardianOfficePostCode',
                [Guardian Office Country Code] ='$GuardianOfficeCountry',
                [Remarks] ='$EnquiryRemarks',
                [User ID] ='$UserLoginID',
                [Enquiry Status] =$EnquiryStatus,
                [Distance] ='$Distance',
                [Intials] =$MotherPreffix,
                [Intials1] =$FatherPreffix,
                [Intials2] =$GuardianPreffix,
                [Transport Required] =$Transport,
                [Category] =$ConcessionCategory,
                [Physically Challenged]=$PhysicallyChallanged,
                [Langauge 1] =$Language2,
                [Language 2] =$Language3,
                [Enquirer Name] ='',
                [Religion] ='',
                [Media Vehicle] ='',
                [No Series] ='',
                [Campaign] ='',
                [Address 3] ='',
                [Reason For Leaving Pre_ School] ='',
                [Expectations From School] ='',
                [Mother Email] ='',
                [Mother Mobile] ='',
                [Father Email] ='',
                [Father Mobile] ='',
                [Portal ID] ='$UserLoginID',
                [Follow-ups] ='',
                [Hostel Accomodation] =0,
                [Age] =0,
                [Months] =0,
                [Total No_ Of Siblings] =0,
                [No_ Of Siblings In Our School] =0,
                [No_ Of Sibling In Other School] =0,
                [How Do You Knw About School] =0,
                [MON] =0,
                [D_O_B] =0,
                [YEAR] =0,
                [Reasons] =0,
                [Inactive] ='$Inactive',
                [EWS] =$EWS, ";
	if($_REQUEST['NextFollowupDate']!=""){
                $result .= "[Next FollowUp Date] ='$NextFollowupDate', ";
	}
                $result .= "[Distance From School(km)]='$Distance',
                [Stream] = '".$_REQUEST['Stream']."',
                [Remarks1] = '".$_REQUEST['Remarks1']."',
		[UpdateStatus]=1
              WHERE [No_] = '$id' AND [Company Name]='$ms'";	   
	
    //echo "<br /><br /> $result";
		$stmt = odbc_prepare($conn, $result);

		if(!odbc_execute($stmt)){
			echo "<META http-equiv='refresh' content='0;URL=ListEnquiry.php?e=1&enq=".$_REQUEST['EnquiryNo']."'>";
		}
		else{
			echo "<META http-equiv='refresh' content='0;URL=ListEnquiry.php?e=1&enq=".$_REQUEST['EnquiryNo']."'>";
		}
	}
	else{
			echo "<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> Following fields might be entry - Date of Enquiry, Candidate Name, Candidate's Date of Birth, Enquiry Source, Enquiry Type. Kindly check.<br />".odbc_errormsg($conn)."
				</div>
			</div>";
	}

	require_once("../footer.php");
?>