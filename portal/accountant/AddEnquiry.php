<?php
	error_reporting(E_ALL);
	require_once("header.php");
	//require_once("../mssql.php");
	echo "<br /><br /><br /><br /><br />";
	
	if (isset($_SESSION['token'])){
		if (isset($_POST['token'])){
			if ($_POST['token'] != $_SESSION['token']){
				exit('<div class="container">
					<div class="alert alert-danger">
						<strong>Alert !!! </strong> You have tried to forge the process by refreshing the page or url. Exiting the process initiation.
					</div>
				</div>');
			}
		}
	}
	
		//System Genrated No
		$SysNo = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [Temp Enquiry] WHERE [Company Name]='$CompName'") or die(odbc_errormsg($conn));
		$SysGenNo = "ENQ".str_pad(odbc_result($SysNo, ""), 4, '0', STR_PAD_LEFT);
		
		//Enquiry No.....
		$EnquiryNo = "WPE";

		$qryEnq1 = odbc_exec($conn, "SELECT COUNT([No_])+1 FROM [Temp Enquiry] where [Company Name]='$ms'") or die(odbc_errormsg());
		$EnquiryNo=$EnquiryNo.  str_pad(odbc_result($qryEnq1, ""), 7, '0', STR_PAD_LEFT);

		$ChkEnq = odbc_exec($conn, "SELECT MAX([No_]) FROM [Temp Enquiry] WHERE [No_]='$EnquiryNo' AND [Company Name]='$ms'") or die(odbc_errormsg());
		$a = substr(odbc_result($ChkEnq, "No_"),3 )+1;    
		if(odbc_result($ChkEnq, "No_") == 0){
		if($EnquiryNo == ""){
		    $EnquiryNo = $EnquiryNo.str_pad("1", 7, '0', STR_PAD_LEFT);
		}
		else{
		    $EnquiryNo = $EnquiryNo;
		}
		}
		else{
		$EnquiryNo = $EnquiryNo.str_pad($a, 7, '0', STR_PAD_LEFT);
		}
                                    
                                    //exit();
		$UserLoginID=strtoupper(str_replace("'", "''",$LoginID));
		//$EnquiryNo=$EnquiryNo;
		$EnquiryDate=(($_REQUEST['EnquiryDate'] != "")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['EnquiryDate']))):'1753-01-01 00:00:00.000');
		$AcadYear=str_replace("'", "''",$_REQUEST['AcadYear']);
		$StudentName=str_replace("'", "''",$_REQUEST['StudentName']);
		
		if($_REQUEST['Gender'] == ""){
			$Gender=0;
		}
		else{
			$Gender=str_replace("'", "''",$_REQUEST['Gender']);
		}
		
		$DOB=$_REQUEST['DOB'];
		$ClassApplied=str_replace("'", "''",$_REQUEST['ClassApplied']);
		$Curricullum=str_replace("'", "''",$_REQUEST['Curricullum']);
		
		if($_REQUEST['MotherPreffix']== ""){
			$MotherPreffix = 0;
		}
		else{
			$MotherPreffix=str_replace("'", "''",$_REQUEST['MotherPreffix']);
		}
		
		$MotherName=str_replace("'", "''",$_REQUEST['MotherName']);
		if($_REQUEST['FatherPreffix']== ""){
			$FatherPreffix = 0;
		}
		else{
			$FatherPreffix=str_replace("'", "''",$_REQUEST['FatherPreffix']);
		}
		
		$FatherName=str_replace("'", "''",$_REQUEST['FatherName']);
		if($_REQUEST['GuardianPreffix']== ""){
			$GuardianPreffix = 0;
		}
		else{
			$GuardianPreffix=str_replace("'", "''",$_REQUEST['GuardianPreffix']);
		}
		
		$GuardianName=str_replace("'", "''",$_REQUEST['GuardianName']);
		
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
				
		$PreviousSchool=str_replace("'", "''",$_REQUEST['PreviousSchool']);
		$PrevSchLastClass=str_replace("'", "''",$_REQUEST['PrevSchLastClass']);
		$PrevSchCurricullum=str_replace("'", "''",$_REQUEST['PrevSchCurricullum']);
		$PrevSchMedium=strtoupper(str_replace("'", "''",$_REQUEST['PrevSchMedium']));
		$CommunicationReference=strtoupper(str_replace("'", "''",$_REQUEST['CommunicationReference']));
		$Address=strtoupper(str_replace("'", "''",$_REQUEST['Address']));
		$Address1=str_replace("'", "''",$_REQUEST['Address1']); 
		$Address2=str_replace("'", "''",$_REQUEST['Address2']);
		
                $City=str_replace("'", "''",$_REQUEST['City']);
                $CityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$City'") or die(odbc_errormsg($conn));
                $CTC = odbc_result($CityCode, "StateCode");
                if($CTC != "") $City=$CTC;
                else $City = substr($City, 0, 9);
                
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
		$FatherAnnualIncome=($_REQUEST['FatherAnnualIncome']?str_replace("'", "''",$_REQUEST['FatherAnnualIncome']):0);
		$FatherOfficePostCode=str_replace("'", "''",$_REQUEST['FatherOfficePostCode']);
		$FatherOfficeCity=str_replace("'", "''",$_REQUEST['FatherOfficeCity']);
                $FCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$FatherOfficeCity'") or die(odbc_errormsg($conn));
                $FCTC = odbc_result($FCityCode, "StateCode");
                if($FCTC != "") $FatherOfficeCity=$FCTC;
                else $FatherOfficeCity = substr($FatherOfficeCity, 0, 9);
                
		$FatherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeCountry']));
		$MotherQualification=str_replace("'", "''",$_REQUEST['MotherQualification']);
		$MotherOfficeAddress1=str_replace("'", "''",$_REQUEST['MotherOfficeAddress1']);
		$MotherOccupation=str_replace("'", "''",$_REQUEST['MotherOccupation']);
		$MotherOfficeAddress2=str_replace("'", "''",$_REQUEST['MotherOfficeAddress2']);
		$MotherAnnualIncome=($_REQUEST['MotherAnnualIncome']?str_replace("'", "''",$_REQUEST['MotherAnnualIncome']):0);
		$MotherOfficePostCode=str_replace("'", "''",$_REQUEST['MotherOfficePostCode']);
		$MotherOfficeCity=str_replace("'", "''",$_REQUEST['MotherOfficeCity']);
                $MCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$MotherOfficeCity'") or die(odbc_errormsg($conn));
                $MCTC = odbc_result($MCityCode, "StateCode");
                if($MCTC != "") $MotherOfficeCity=$MCTC;
                else $MotherOfficeCity = substr($MotherOfficeCity, 0, 9);
                
		$MotherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeCountry']));
		$GuardianRelationship=str_replace("'", "''",$_REQUEST['GuardianRelationship']); 
		$GuardianQualification=str_replace("'", "''",$_REQUEST['GuardianQualification']);
		$GuardianOfficeAddress1=str_replace("'", "''",$_REQUEST['GuardianOfficeAddress1']);
		$GuardianOccupation=str_replace("'", "''",$_REQUEST['GuardianOccupation']);
		$GuardianOfficeAddress2=str_replace("'", "''",$_REQUEST['GuardianOfficeAddress2']);
		if($_REQUEST['GuardianAnnualIncome'] == ""){
			$GuardianAnnualIncome=0;
		}
		else{
			$GuardianAnnualIncome=str_replace("'", "''",$_REQUEST['GuardianAnnualIncome']);
		}
		$GuardianOfficePostCode=str_replace("'", "''",$_REQUEST['GuardianOfficePostCode']);
		$GuardianOfficeCity=str_replace("'", "''",$_REQUEST['GuardianOfficeCity']);
                $GCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$GuardianOfficeCity'") or die(odbc_errormsg($conn));
                $GCTC = odbc_result($GCityCode, "StateCode");
                if($GCTC != "") $GuardianOfficeCity=$GCTC;
                else $GuardianOfficeCity = substr($GuardianOfficeCity, 0, 9);
                
		$GuardianOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['GuardianOfficeCountry']));
		$EnquiryType=strtoupper(str_replace("'", "''",$_REQUEST['EnquiryType']));
		$EnquirySource=strtoupper(str_replace("'", "''",$_REQUEST['EnquirySource']));
		if($_REQUEST['EnquiryStatus'] == ""){
			$EnquiryStatus=0;
		}
		else{
		    $EnquiryStatus=str_replace("'", "''",$_REQUEST['EnquiryStatus']);
		}
		
		$Distance=str_replace("'", "''",$_REQUEST['Distance']);
		$Citizenship=str_replace("'", "''",$_REQUEST['Citizenship']);
		$Stream=(($_REQUEST['Stream']=="")?0:$_REQUEST['Stream']);
		$EnquiryRemarks=str_replace("'", "''",$_REQUEST['EnquiryRemarks']);
		$Followup=str_replace("'", "''",$_REQUEST['Followup']);
		//$NextFollowupDate=date('Y-m-d H:i:s', strtotime(str_replace('/', '-',($_REQUEST['NextFollowupDate']?$_REQUEST['NextFollowupDate']:'1753-01-01'))));

        if($_REQUEST['NextFollowupDate'] == ""){
            $NextFollowupDate = "1753-01-01 00:00:00";
        }
        else{
            $NextFollowupDate = $_REQUEST['NextFollowupDate'];
        }

	echo "<br /><br /> <br />";
	
	$query = "INSERT INTO [Temp Enquiry] 
				( [No_], [Name], [Gender], [Type Of Enquiry], [Enquiry Source], [Relationship with Applicant], 
				[Date of Birth], [Father_s Name], [Mother_s Name], [Citizenship], [Admission For Year], [Enquiry Date], 
				[Class Applied], [Name Of The Previous Institute], [Medium Of Instruction], [Curriculum Intrested], 
				[Class Last Attended], [Curriculum Followed], [Address To], [Addressee], [Address 1], [Address 2], 
				[City], [Post Code], [Country Code], [E-Mail Address], [Mobile Number], [Phone Number], [State], 
				[Mother_s Qualification], [Mother_s Occupation], [Guardian Name], [Father_s Occupation], 
				[Mother_s Annual Income], [Guardian Qualification], [Guardian Occupation], [Guardian Annual Income], 
				[Father_s Qualification], [Father_s Annual Income], [Father Office Address 1], [Father Office Address 2], 
				[Father Office City], [Father Office Post Code], [Father Office Country Code], [Mother Office Address 1], 
				[Mother Office Address 2], [Mother Office City], [Mother Office Post Code], [Mother Office Country Code], 
				[Guardian Office Address 1], [Guardian Office Address 2], [Guardian Office City], 
				[Guardian Office Post Code], [Guardian Office Country Code], [Remarks], [User ID], [Enquiry Status], 
				[Distance], [Intials], [Intials1], [Intials2], [Transport Required], [Category], [Physically Challenged], 
				[Langauge 1], [Language 2], [FollowUP1], [Next FollowUp Date], [AdmissionStatus], [FollowUP2], [FollowUP3],
				[Enquirer Name], [Religion], [Media Vehicle], [No Series], [Campaign], [Address 3], 
				[Reason For Leaving Pre_ School], [Expectations From School], [Mother Email], [Mother Mobile], 
				[Father Email], [Father Mobile], [Portal ID], [Follow-ups], [Remarks1], [Hostel Accomodation], [Age], 
				[Months], [Registration Status], [Total No_ Of Siblings], [No_ Of Siblings In Our School], 
				[No_ Of Sibling In Other School], [How Do You Knw About School], [MON], [D_O_B], [YEAR], [Reasons], 
				[Inactive], [EWS], [Distance From School(km)], [Stream], [UpdateStatus], [InsertStatus], [Company Name], [ERPUpdateStatus], [System Genrated No_])
				VALUES 
				( '$EnquiryNo', '$StudentName', $Gender, '$EnquiryType', '$EnquirySource', '$GuardianRelationship', 
				'$DOB', '$FatherName', '$MotherName', '$Citizenship', '$AcadYear', '$EnquiryDate', 
				'$ClassApplied', '$PreviousSchool', '$PrevSchMedium', '$Curricullum', 
				'$PrevSchLastClass', '$PrevSchCurricullum', '$CommunicationReference', '$Address', '$Address1', '$Address2', 
				'$City', '$PostCode', '$Country', '$Email', '$Mobile', '$Landline', '$State', 
				'$MotherQualification', '$MotherOccupation', '$GuardianName', '$FatherOccupation', 
				$MotherAnnualIncome, '$GuardianQualification', '$GuardianOccupation', $GuardianAnnualIncome, 
				'$FatherQualification', $FatherAnnualIncome, '$FatherOfficeAddress1', '$FatherOfficeAddress2', 
				'$FatherOfficeCity', '$FatherOfficePostCode', '$FatherOfficeCountry', '$MotherOfficeAddress1', 
				'$MotherOfficeAddress2', '$MotherOfficeCity', '$MotherOfficePostCode', '$MotherOfficeCountry', 
				'$GuardianOfficeAddress1', '$GuardianOfficeAddress2', '$GuardianOfficeCity', '$GuardianOfficePostCode', 
				'$GuardianOfficeCountry', '', '$UserLoginID', $EnquiryStatus, '$Distance', $MotherPreffix, 
				$FatherPreffix, $GuardianPreffix, $Transport, $ConcessionCategory, $PhysicallyChallanged, $Language2, 
				$Language3, '$Followup', '$NextFollowupDate', 0, '', '', '', '', '', '', '', '', '', '', '', '', 
				'', '', '$UserLoginID', '', '$EnquiryRemarks', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $EWS, '$Distance', $Stream, 0, 1, '$ms',0, '$SysGenNo' )";
	
	
	if($StudentName != "" || $EnquiryDate != "" || $DOB !="" || $EnquiryType !="" || $EnquirySource !=""){
		$stmt = odbc_prepare($conn, $query) or die("<br />Unable to execute.");
		echo "<div class='container'>";
		//echo $query;
		if(!odbc_execute($stmt)){
			exit("<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> There is some error, kindly check.<br />".odbc_errormsg($conn)." <br> $query
				</div>
			</div>");
		}
		else{
                        echo "<META http-equiv='refresh' content='0;URL=NewEnquiry.php?eid=$EnquiryNo'>";//header("Location: NewEnquiry.php?eid=$EnquiryNo");
		}
	echo "</div>";
	}
	else{
			echo "<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> Following fields might be empty - Date of Enquiry, Candidate Name, Candidate's Date of Birth, Enquiry Source, Enquiry Type. Kindly check.<br />".odbc_errormsg($conn)."
				</div>
			</div>";
	}
	require_once("../footer.php");
?>