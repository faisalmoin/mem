<?php
	require_once("header.php");
	
	$EnqNo=$_REQUEST['EnqNo'];
        
?>
    <br /><br /><br /><br />
<div class="container">
<?php 
	//System Genrated No
	$SysNo = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [Temp Application] WHERE [Company Name]='$CompName'") or die(odbc_errormsg($conn));
	$SysGenNo = "APP".str_pad(odbc_result($SysNo, ""), 4, '0', STR_PAD_LEFT);
	

	if($_REQUEST['PaymentMode'] !="CASH" && $_REQUEST['BankName']=="") exit("<div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong>You need to enter Bank Name ...</div>");
	if($_REQUEST['PaymentMode'] !="CASH" && $_REQUEST['ChequeDDNo']=="") exit("<div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong>You need to enter Cheque / DD Number ...</div>");
	if($_REQUEST['PaymentMode'] !="CASH" && $_REQUEST['ChequeDDDate']=="") exit("<div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong>You need to enter Cheque / DD Date ...</div>");
	
        $CheckEnquiry = odbc_exec($conn, "SELECT [No_] FROM [Temp Application] WHERE [Enquiry No_]='".$_REQUEST['SystemGenratedNo']."' AND [Company Name]='$ms'") or exit(odbc_errormsg($conn));
        if(odbc_num_rows($CheckEnquiry)>0) exit("<div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong> This record is already available in database...
		                        </div>");
        
        $CheckRegFormNo = odbc_exec($conn, "SELECT [No_] FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration No_]='".$_REQUEST['RegistrationFormNo']."'") or die(odbc_errormsg($conn));
        if(odbc_num_rows($CheckRegFormNo)>0) exit("<div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong> Registration Form No. - ".$_REQUEST['RegistrationFormNo']." is already available in database...
		                        </div>");
        
        $CheckDt   =($_REQUEST['ChequeDDDate'] != ""?date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$_REQUEST['ChequeDDDate']))):'1753-01-01 00:00:00.000');
        $CheckNo   =str_replace("'", "''",($_REQUEST['ChequeDDNo']?$_REQUEST['ChequeDDNo']:''));
        $AcadYear = ($_REQUEST['FinYear']? $_REQUEST['FinYear'] : '');
        $ClassApplied = ($_REQUEST['ClassApplied']? $_REQUEST['ClassApplied'] : '');
                
        $AppNo= "WPR";

          //$qryApp1 = odbc_exec($conn, "SELECT COUNT([No_])+3 FROM [Temp Application] WHERE [Company Name]='$ms'") or die(odbc_errormsg());
          $qryApp1 = odbc_exec($conn, "SELECT COUNT([No_])+3 FROM [Temp Application]") or die(odbc_errormsg());
          $AppNo=$AppNo.  str_pad(odbc_result($qryApp1, ""), 7, '0', STR_PAD_LEFT);

          $ChkApp = odbc_exec($conn, "SELECT MAX([No_]) FROM [Temp Application] WHERE [No_]='$AppNo' AND [Company Name]='$ms'") or die(odbc_errormsg());
          $a = substr(odbc_result($ChkApp, "No_"),3 )+1;    
          if(odbc_result($ChkApp, "No_") == 0){
              if($AppNo == ""){
                  $AppNo = $AppNo.str_pad("1", 7, '0', STR_PAD_LEFT);
              }
              else{
                  $AppNo = $AppNo;
              }
          }
          else{
              $AppNo = $AppNo.str_pad($a, 7, '0', STR_PAD_LEFT);
          }

                //Check same Registration Form No //
                if($_REQUEST['RegistrationFormNo'] != "" && $_REQUEST['SaleDate'] != ""){
                    $sql1 = "UPDATE [Temp Enquiry] SET [Registration Status] = 1 WHERE [No_]='$EnqNo' AND [Company Name]='$ms'";
                    //$sql1 = "UPDATE [Temp Enquiry] SET [Registration Status] = 0 WHERE [No_]='$EnqNo' AND [Company Name]='$ms'";
			
                    $stmt1 = odbc_prepare($conn, $sql1);
                    if(!odbc_execute($stmt1)){
                        echo "Unable to set Registration Status...";
                    }
                    else{
                        $sql2 = "SELECT * FROM [Temp Enquiry] WHERE [No_]='$EnqNo' AND [Company Name]='$ms' ";
                        $stmt2 = odbc_exec($conn, $sql2);
			
                        $AcademicYear =str_replace("'", "''",($_REQUEST['FinYear']?$_REQUEST['FinYear']:''));
                        $Address3  =str_replace("'", "''",(odbc_result($stmt2, "Address 3")?odbc_result($stmt2, "Address 3"):''));
                        $AddressTo =strtoupper(str_replace("'", "''",($_REQUEST['CommunicationReference']?$_REQUEST['CommunicationReference']:'')));
                        $Address1  =str_replace("'", "''",($_REQUEST['Address1']?$_REQUEST['Address1']:''));
                        $Address2  =str_replace("'", "''",($_REQUEST['Address2']?$_REQUEST['Address2']:''));
                        $Addressee =str_replace("'", "''",($_REQUEST['Address']?$_REQUEST['Address']:''));
                        $AdmissionForYear  =str_replace("'", "''",($_REQUEST['FinYear']?$_REQUEST['FinYear']:''));
                        $Age   =str_replace("'", "''",(odbc_result($stmt2, "Age")?odbc_result($stmt2, "Age"):'0'));
                        $ApplicantRelationship =str_replace("'", "''",(($_REQUEST['GuardianRelationship']!='')?$_REQUEST['GuardianRelationship']:''));
                        $ApplicationCost   =str_replace("'", "''",($_REQUEST['RegistrationCost']?$_REQUEST['RegistrationCost']:'0.00'));
                        $BankName  =str_replace("'", "''",($_REQUEST['BankName']?$_REQUEST['BankName']:''));
                        $Category  =str_replace("'", "''",(odbc_result($stmt2, "Category")?odbc_result($stmt2, "Category"):'0'));

                        $Citizenship   =str_replace("'", "''",(odbc_result($stmt2, "Citizenship")?odbc_result($stmt2, "Citizenship"):''));
                        $City  =str_replace("'", "''",($_REQUEST['City']?$_REQUEST['City']:''));
                        $CityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$City'") or die(odbc_errormsg($conn));
			$CTC = odbc_result($CityCode, "StateCode");
			if($CTC != "") $City=$CTC;
			else $City = substr($City, 0, 9);

                        $Class =str_replace("'", "''",($_REQUEST['ClassApplied']?$_REQUEST['ClassApplied']:''));
                        $Country   =str_replace("'", "''",($_REQUEST['Country']?$_REQUEST['Country']:''));
                        $CuricullumInterested  =str_replace("'", "''",($_REQUEST['Curricullum']?$_REQUEST['Curricullum']:''));
                        //$DateOfBirth   =date('Y-m-d H:i:s', strtotime(str_replace("/", "-",($_REQUEST['DOB']?$_REQUEST['DOB']:''))));
                        $DateOfBirth   =$_REQUEST['DOB'];
                        //$SaleDate  =date('Y-m-d H:i:s',strtotime(str_replace('/', '-',($_REQUEST['SaleDate']?$_REQUEST['SaleDate']:''))));
                        $SaleDate  =$_REQUEST['SaleDate'];
                        $Distance  =str_replace("'", "''",(odbc_result($stmt2, "Distance")?odbc_result($stmt2, "Distance"):0));
                        $EmailAddress  =str_replace("'", "''",($_REQUEST['Email']?$_REQUEST['Email']:''));
                        //$EnqNo =str_replace("'", "''",($_REQUEST['EnquiryNo']?$_REQUEST['EnquiryNo']:''));
                        $EnqNo1 =odbc_result($stmt2, 'System Genrated No_');
                        $EnqStatus =str_replace("'", "''",(odbc_result($stmt2, "Enquiry Status")?odbc_result($stmt2, "Enquiry Status"):'0'));
                        $EWS   =str_replace("'", "''",($_REQUEST['EWSStatus']?$_REQUEST['EWSStatus']:'0'));
                        $FatherEmail   =str_replace("'", "''",(odbc_result($stmt2, "Father Email")?odbc_result($stmt2, "Father Email"):''));
			if(odbc_result($stmt2, "Father Mobile") != ""){
				$FatherMobile = odbc_result($stmt2, "Father Mobile");
			}
			else{
				$FatherMobile = "";
			}
                        $FatherOfficeAddress1  =str_replace("'", "''",($_REQUEST['FatherOfficeAddress1']?$_REQUEST['FatherOfficeAddress1']:''));
                        $FatherOfficeAddress2  =str_replace("'", "''",($_REQUEST['FatherOfficeAddress2']?$_REQUEST['FatherOfficeAddress2']:''));
                        $FatherOfficeCity  =str_replace("'", "''",($_REQUEST['FatherOfficeCity']?$_REQUEST['FatherOfficeCity']:''));
                        $FCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$FatherOfficeCity'") or die(odbc_errormsg($conn));
			$FCTC = odbc_result($FCityCode, "StateCode");
			if($FCTC != "") $FatherOfficeCity=$FCTC;
			else $FatherOfficeCity = substr($FatherOfficeCity, 0, 9);

                        $FatherOfficeCountryCode   =str_replace("'", "''",($_REQUEST['FatherOfficeCountry']?$_REQUEST['FatherOfficeCountry']:''));
                        $FatherOfficePostCode  =str_replace("'", "''",($_REQUEST['FatherOfficePostCode']?$_REQUEST['FatherOfficePostCode']:''));
                        $FatherAnnualIncome =str_replace("'", "''",($_REQUEST['FatherAnnualIncome']?$_REQUEST['FatherAnnualIncome']:'0'));
                        $FatherName    =str_replace("'", "''",($_REQUEST['FatherName']?$_REQUEST['FatherName']:''));
                        $FatherOccupation  =str_replace("'", "''",($_REQUEST['FatherOccupation']?$_REQUEST['FatherOccupation']:''));
                        $FatherQualification   =str_replace("'", "''",($_REQUEST['FatherQualification']?$_REQUEST['FatherQualification']:''));
                        $FeeClassification =str_replace("'", "''",(odbc_result($stmt2, "Category")?odbc_result($stmt2, "Category"):'GENERAL'));
                        $Gender    =str_replace("'", "''",($_REQUEST['Gender']?$_REQUEST['Gender']:'0'));
                        $GaurdianAnnualIncome  =str_replace("'", "''",(($_REQUEST['GuardianAnnualIncome']!=0)?$_REQUEST['GuardianAnnualIncome']:'0'));
                        $GaurdianName  =str_replace("'", "''",(($_REQUEST['GaurdianName']!='')?$_REQUEST['GaurdianName']:''));
			//echo "Gaudian".$_REQUEST['GaurdianName']."<br />";
			
                        $GaurdianOccupation    =str_replace("'", "''",(($_REQUEST['GuardianOccupation']!="")?$_REQUEST['GuardianOccupation']:''));
                        $GaurdianOfficeAddress1    =str_replace("'", "''",(($_REQUEST['GuardianOfficeAddress1']!="")?$_REQUEST['GuardianOfficeAddress1']:''));
                        $GaurdianOfficeAddress2    =str_replace("'", "''",(($_REQUEST['GuardianOfficeAddress2']!="")?$_REQUEST['GuardianOfficeAddress2']:''));
                        $GaurdianOfficeCity    =str_replace("'", "''",(($_REQUEST['GuardianOfficeCity']!="")?$_REQUEST['GuardianOfficeCity']:''));
                        $GCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$GuardianOfficeCity'") or die(odbc_errormsg($conn));
			$GCTC = odbc_result($GCityCode, "StateCode");
			if($GCTC != "") $GuardianOfficeCity=$GCTC;
			else $GuardianOfficeCity = substr($GuardianOfficeCity, 0, 9);
                        
                        $GaurdianOfficeCountryCode =str_replace("'", "''",(($_REQUEST['GuardianOfficeCountry']!="")?$_REQUEST['GuardianOfficeCountry']:''));
                        $GaurdianOfficePostCode    =str_replace("'", "''",(($_REQUEST['GuardianOfficePostCode']!="")?$_REQUEST['GuardianOfficePostCode']:''));
                        $GaurdianQualification =str_replace("'", "''",(($_REQUEST['GuardianQualification']!="")?$_REQUEST['GuardianQualification']:''));
                        $HostelAccomodation    =str_replace("'", "''",(odbc_result($stmt2, "Hostel Accomodation")?odbc_result($stmt2, "Hostel Accomodation"):'0'));
                        $Language1 =str_replace("'", "''",($_REQUEST['Language2']?$_REQUEST['Language2']:'0'));
                        $Language2 =str_replace("'", "''",($_REQUEST['Language3']?$_REQUEST['Language3']:'0'));
                        $MediumOfInstruction   =str_replace("'", "''",($_REQUEST['Language1']?$_REQUEST['Language1']:''));
                        $MobileNumber  =str_replace("'", "''",($_REQUEST['Mobile']?$_REQUEST['Mobile']:''));
                        $PaymentMode   =strtoupper(str_replace("'", "''",($_REQUEST['PaymentMode']?$_REQUEST['PaymentMode']:'')));
                        $Months    =str_replace("'", "''",(odbc_result($stmt2, "Months")?odbc_result($stmt2, "Months"):'0'));
                        $MotherEmail   =str_replace("'", "''",(odbc_result($stmt2, "Mother Email")?odbc_result($stmt2, "Mother Email"):''));
                        $MotherMobile  =str_replace("'", "''",(odbc_result($stmt2, "Mother Mobile")?odbc_result($stmt2, "Mother Mobile"):''));
                        $MotherOfficeAddress1  =str_replace("'", "''",($_REQUEST['MotherOfficeAddress1']?$_REQUEST['MotherOfficeAddress1']:''));
                        $MotherOfficeAddress2  =str_replace("'", "''",($_REQUEST['MotherOfficeAddress2']?$_REQUEST['MotherOfficeAddress2']:''));
                        $MotherOfficeCity  =str_replace("'", "''",($_REQUEST['MotherOfficeCity']?$_REQUEST['MotherOfficeCity']:''));
                        $MCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$MotherOfficeCity'") or die(odbc_errormsg($conn));
			$MCTC = odbc_result($MCityCode, "StateCode");
			if($MCTC != "") $MotherOfficeCity=$MCTC;
			else $MotherOfficeCity = substr($MotherOfficeCity, 0, 9);
                        
                        $MotherOfficeCountryCode   =str_replace("'", "''",($_REQUEST['MotherOfficeCountry']?$_REQUEST['MotherOfficeCountry']:''));
                        $MotherOfficePostCode  =str_replace("'", "''",($_REQUEST['MotherOfficePostCode']?$_REQUEST['MotherOfficePostCode']:''));
                        //$MotherAnualIncome =$_REQUEST['MotherAnnualIncome']?$_REQUEST['MotherAnnualIncome']:'0';
			if($_REQUEST['MotherAnnualIncome'] != ""){
				$MotherAnualIncome = $_REQUEST['MotherAnnualIncome'];
			}
			else{
				$MotherAnualIncome = '0';
			}
                        $MotherName    =str_replace("'", "''",($_REQUEST['MotherName']?$_REQUEST['MotherName']:''));
                        $MotherOccupation  =str_replace("'", "''",($_REQUEST['MotherOccupation']?$_REQUEST['MotherOccupation']:''));
                        $MotherQualification   =str_replace("'", "''",($_REQUEST['MotherQualification']?$_REQUEST['MotherQualification']:''));
                        $Name  =str_replace("'", "''",($_REQUEST['Student']?$_REQUEST['Student']:''));
                        $RegistrationNo    =strtoupper(str_replace("'", "''",($_REQUEST['RegistrationNo']?$_REQUEST['RegistrationNo']:'')));
                        $NoSeries  =str_replace("'", "''",(odbc_result($stmt2, "No Series")?odbc_result($stmt2, "No Series"):''));
                        $PhoneNumber   =str_replace("'", "''",($_REQUEST['Landline']?$_REQUEST['Landline']:''));
                        $PhysicallyChallenged  =str_replace("'", "''",(odbc_result($stmt2, "Physically Challenged")?odbc_result($stmt2, "Physically Challenged"):'0'));
                        $PhysicallyChallenged  =str_replace("'", "''",(odbc_result($stmt2, "Physically Challenged")?odbc_result($stmt2, "Physically Challenged"):'0'));
                        $PortalID  =str_replace("'", "''",(odbc_result($stmt2, "Portal ID")?odbc_result($stmt2, "Portal ID"):''));
                        $PostCode  =str_replace("'", "''",($_REQUEST['PostCode']?$_REQUEST['PostCode']:''));
                        $PresentlyResidingWith =strtoupper(str_replace("'", "''",($_REQUEST['CommunicationReference']?$_REQUEST['CommunicationReference']:'')));
                        $PreviousClass =str_replace("'", "''",(odbc_result($stmt2, "Class Last Attended")?odbc_result($stmt2, "Class Last Attended"):''));
                        $PreviousCurriculum    =str_replace("'", "''",(odbc_result($stmt2, "Curriculum Followed")?odbc_result($stmt2, "Curriculum Followed"):''));
                        $PreviousSchool    =str_replace("'", "''",(odbc_result($stmt2, "Name Of The Previous Institute")?odbc_result($stmt2, "Name Of The Previous Institute"):''));
                        $RegistratinCost   =str_replace("'", "''",($_REQUEST['RegistrationCost']?$_REQUEST['RegistrationCost']:'0'));
                        $RegistrationNo    =str_replace("'", "''",($_REQUEST['RegistrationFormNo']?strtoupper($_REQUEST['RegistrationFormNo']):'0'));
                        $RegistrationStatus    =1;
                        //$RegistrationStatus    =0;
                        $Religion  =str_replace("'", "''",(odbc_result($stmt2, "Religion")?odbc_result($stmt2, "Religion"):''));
                        $Remarks3  =str_replace("'", "''",(odbc_result($stmt2, "Remarks1")?odbc_result($stmt2, "Remarks1"):''));
                        $Remarks   =str_replace("'", "''",(odbc_result($stmt2, "Remarks")?odbc_result($stmt2, "Remarks"):''));
                        $State =str_replace("'", "''",($_REQUEST['State']?$_REQUEST['State']:''));
                        $TransportRequired =str_replace("'", "''",(odbc_result($stmt2, "Transport Required")?odbc_result($stmt2, "Transport Required"):''));
                        $TransportRequired = (($TransportRequired!="")?$TransportRequired:0);
                        $UserID    = strtoupper(str_replace("'", "''",(odbc_result($stmt2, "User ID")?odbc_result($stmt2, "User ID"):'')));
                        $Stream=str_replace("'", "''",$_REQUEST['Stream']);
			
			//Convert Date to  Epoch Time
			$EpochTime = strtotime(str_replace('/', ' ', $SaleDate.date('H:i:s')));
			//$EpochChqDT = strtotime(str_replace('/', ' ', $CheckDt));
                        $EpochChqDT = strtotime(str_replace('/', ' ', $CheckDt.date('H:i:s')));
			
                        $sql3 = "INSERT INTO [Temp Application] ([Academic Year],[Address 3],[Address To],
                    [Address1],[Address2],[Addressee],[Admission For Year],[Age],
                    [Applicant Relationship],[Application Cost],[Bank Name],[Category],
                    [Cheque _ DD Date],[Cheque _ DD No_],[Citizenship],[City],[Class],[Country],
                    [Curriculum Intrested],[Date of Birth],[Date of Sale],[Distance],
                    [E-Mail Address],[Enquiry No_],[Enquiry Status],[EWS],[Father Email],
                    [Father Mobile],[Father Office Address 1],[Father Office Address 2],
                    [Father Office City],[Father Office Country Code],[Father Office Post Code],
                    [Father_s Annual Income],[Father_s Name],[Father_s Occupation],
                    [Father_s Qualification],[Fee Classification],[Gender],[Guardian Annual Income],
                    [Guardian Name],[Guardian Occupation],[Guardian Office Address 1],
                    [Guardian Office Address 2],[Guardian Office City],[Guardian Office Country Code],
                    [Guardian Office Post Code],[Guardian Qualification],[Hostel Acommodation],
                    [Langauge 1],[Language 2],[Medium of Instruction],[Mobile Number],
                    [Mode of Payment],[Months],[Mother Email],[Mother Mobile],
                    [Mother Office Address 1],[Mother Office Address 2],[Mother Office City],
                    [Mother Office Country Code],[Mother Office Post Code],[Mother_s Annual Income],
                    [Mother_s Name],[Mother_s Occupation],[Mother_s Qualification],[Name],[No_],
                    [No_Series],[Phone Number],[Physically Challanged],[Physically Challenged],
                    [Portal ID],[Post Code],[Presently Residing with],[Previous Class],
                    [Previous Curriculum],[Previous School],[Registration Cost],[Registration No_],
                    [Registration Status],[Religion],[Remark3],[Remarks],[State],[Transport Required],
                    [User ID],
                    [Admission Date], [Mail Code], [Visa Exp Date],[Passport No_],
                    [Passport Exp Date],[Visa No_],[Food Habits],[Promotion Granted],[Date of Receive],
                    [Caste],[Mode of Sale],[Prospectus],[Prospectus No_],[Exam Code],[Community],
                    [Mother Tongue],[Spot],[Recommender Designation],[Recommended By],[Recommended List No],
                    [Check Age Limit],[Recommendation],[Section],[Discount Code],[Discount Code 1],
                    [Evaluation Total],[Height],[Maximum Age Limit],[Minimum Age Limit],
                    [Quota],[Rank],[Reg No_Series],[Selection Number],[Staff Child],[Staff Code],
                    [Student No_],[Weight],[Stream], [InsertStatus], [UpdateStatus], [Company Name], [System Genrated No_], [ERPUpdateStatus])
                    VALUES
                    ('$AcademicYear','$Address3','$AddressTo','$Address1','$Address2','$Addressee','$AdmissionForYear',$Age,'$ApplicantRelationship',
		    $ApplicationCost,'$BankName',$Category,'$CheckDt','$CheckNo','$Citizenship','$City','$Class','$Country','$CuricullumInterested',
		    '$DateOfBirth','$SaleDate','$Distance','$EmailAddress','$EnqNo1',$EnqStatus,$EWS,'$FatherEmail','$FatherMobile',
		    '$FatherOfficeAddress1','$FatherOfficeAddress2','$FatherOfficeCity','$FatherOfficeCountryCode','$FatherOfficePostCode',
		    $FatherAnnualIncome,'$FatherName','$FatherOccupation','$FatherQualification','$FeeClassification',$Gender,$GaurdianAnnualIncome,
		    '$GaurdianName','$GaurdianOccupation','$GaurdianOfficeAddress1','$GaurdianOfficeAddress2','$GaurdianOfficeCity',
		    '$GaurdianOfficeCountryCode','$GaurdianOfficePostCode','$GaurdianQualification',$HostelAccomodation,$Language1,$Language2,
		    '$MediumOfInstruction','$MobileNumber','$PaymentMode',$Months,'$MotherEmail','$MotherMobile','$MotherOfficeAddress1',
		    '$MotherOfficeAddress2','$MotherOfficeCity','$MotherOfficeCountryCode','$MotherOfficePostCode',$MotherAnualIncome,
		    '$MotherName','$MotherOccupation','$MotherQualification','$Name','$AppNo','$NoSeries','$PhoneNumber',$PhysicallyChallenged,
		    $PhysicallyChallenged,'$PortalID','$PostCode','$PresentlyResidingWith','$PreviousClass','$PreviousCurriculum','$PreviousSchool',
		    $RegistratinCost,'$RegistrationNo',$RegistrationStatus,'$Religion','$Remarks3','$Remarks','$State',$TransportRequired,'$UserID',
                    '',0,'','','','',0,0,'','','',0,'','','','',0,'','','',0,0,'','','',0,0,0,0,'',0,'','',0,'','',0,'$Stream', 1, 0, '$ms', '$SysGenNo', 0)";
		    
			$today = explode("/", $SaleDate);
			$today = $today[0]." ".$today[1]." ".$today[2];
			$today = strtotime($today);
			$this_yr = strtotime(date("Y", $today)."-04-01");
			$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
			
			$this_yr = strtotime(date("Y", $today)."-04-01");
			$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
			
			if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
			    $FinYr = date('y', $today)."-".(date('y', $today)+1);
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
			
			//End of Calculation
			
			$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$ms'");
			if(odbc_result($seq, "Posting") == 0){
				$inv =1;
			}
			else{
				$inv = odbc_result($seq, "Posting");
			}
			
			//exit($inv);
			//$inv = (odbcnum_rows($seq) != 0?odbc_result($seq, "Posting"): 1 );
			
			$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
			
			$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], Description,
				[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr]) 
				VALUES 
				('$EpochTime', '$inv_no', '$SysGenNo', 'Sale of Registration', '$ApplicationCost', '$ms', '$LoginID', '$LoginID', $inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				
			$InvDbt = "INSERT INTO [Ledger Debit]([Invoice Date], [Invoice No], [Customer No], Description,
				[Credit Amount], [Debit Amount], [Payment Date], [Payment Mode], [Bank Name], [Cheque No], [Cheque Date],
				[Payment Realization], [Company Name], [User ID], [Portal ID], Remarks, [Realization Date], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr]) 
				VALUES 
				('$EpochTime', '$inv_no', '$SysGenNo', 'Sale of Registration', '$ApplicationCost','$ApplicationCost', '$EpochTime',
				'$PaymentMode', '$BankName', '$CheckNo', '$CheckDt', 0, '$ms', '$LoginID', '$LoginID', 'Subject to realization', '', $inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
				
			//echo "$InvCrd // $InvDbt";
			//exit();

                        $EnqUpd = odbc_prepare($conn, "UPDATE [Temp Enquiry] SET [Address 1]='$Address1',
                                            [Address 2]='$Address2',
                                            [Address 3]='$Address3',
                                            [Address To]='$AddressTo',
                                            [Addressee]='$Addressee',
                                            [Admission For Year]='$AcademicYear',
                                            [Age]='$Age',
                                            [Category]='$Category',
                                            [Citizenship]='$Citizenship',
                                            [City]='$City',
                                            [Class Applied]='$Class',
                                            [Country Code]='$Country',
                                            [Curriculum Intrested]='$CuricullumInterested',
                                            [Date of Birth]='$DateOfBirth',
                                            [Distance]='$Distance',
                                            [E-Mail Address]='$EmailAddress',
                                            [EWS]='$EWS',
                                            [Father Email]='$FatherEmail',
                                            [Father Mobile]='$FatherMobile',
                                            [Father Office Address 1]='$FatherOfficeAddress1',
                                            [Father Office Address 2]='$FatherOfficeAddress2',
                                            [Father Office City]='$FatherOfficeCity',
                                            [Father Office Country Code]='$FatherOfficeCountryCode',
                                            [Father Office Post Code]='$FatherOfficePostCode',
                                            [Father_s Annual Income]='$FatherAnnualIncome',
                                            [Father_s Name]='$FatherName',
                                            [Father_s Occupation]='$FatherOccupation',
                                            [Father_s Qualification]='$FatherQualification',
                                            [Gender]='$Gender',
                                            [Guardian Annual Income]='$GaurdianAnnualIncome',
                                            [Guardian Name]='$GaurdianName',
                                            [Guardian Occupation]='$GaurdianOccupation',
                                            [Guardian Office Address 1]='$GaurdianOfficeAddress1',
                                            [Guardian Office Address 2]='$GaurdianOfficeAddress2',
                                            [Guardian Office City]='$GaurdianOfficeCity',
                                            [Guardian Office Country Code]='$GaurdianOfficeCountryCode',
                                            [Guardian Office Post Code]='$GaurdianOfficePostCode',
                                            [Guardian Qualification]='$GaurdianQualification',
                                            [Hostel Accomodation]='$HostelAccomodation',
                                            [Langauge 1]='$Language1',
                                            [Language 2]='$Language2',
                                            [Medium Of Instruction]='$MediumOfInstruction',
                                            [Mobile Number]='$MobileNumber',
                                            [Months]='$Months',
                                            [Mother Email]='$MotherEmail',
                                            [Mother Mobile]='$MotherMobile',
                                            [Mother Office Address 1]='$MotherOfficeAddress1',
                                            [Mother Office Address 2]='$MotherOfficeAddress2',
                                            [Mother Office City]='$MotherOfficeCity',
                                            [Mother Office Country Code]='$MotherOfficeCountryCode',
                                            [Mother Office Post Code]='$MotherOfficePostCode',
                                            [Mother_s Annual Income]='$MotherAnualIncome',
                                            [Mother_s Name]='$MotherName',
                                            [Mother_s Occupation]='$MotherOccupation',
                                            [Mother_s Qualification]='$MotherQualification',
                                            [Name]='$Name',
                                            [No Series]='$NoSeries',
                                            [Phone Number]='$PhoneNumber',
                                            [Physically Challenged]='$PhysicallyChallenged',
                                            [Portal ID]='$PortalID',
                                            [Post Code]='$PostCode',
                                            [Registration Status]='$RegistrationStatus',
                                            [Relationship with Applicant]='$ApplicantRelationship',
                                            [Religion]='$Religion',
                                            [State]='$State',
                                            [Stream]='$Stream',
                                            [Transport Required]='$TransportRequired',
                                            [User ID]='$UserID'
                                             WHERE [System Genrated No_]='".$_REQUEST['SystemGenratedNo']."' AND [Company Name]='$ms'");

                        if(!odbc_execute($EnqUpd)){
                            exit(" <div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong> Unable to update data in Enquiry table ...<br /><b>Error: </b>".odbc_errormsg($conn)."</div>");
                        }
			            $stmt3 = odbc_prepare($conn, $sql3);
                        //echo $sql3;
                        if(!odbc_execute($stmt3)){
                            
                            exit(" <div class='alert alert-danger alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Error!</strong> Unable to insert data in Application table.<br /><b>Error: </b>".odbc_errormsg($conn)."
		                        </div>");
                        }
                        else{
                            echo "<div class='alert alert-success alert-error'>
			                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
			                    <strong>Success!</strong> The child $Name has been sold. The registration no is - <b>$AppNo</b>.
		                        </div>";

				/* $stmt4 = odbc_prepare($conn, $GLPush);
				if(!odbc_execute($stmt4)){
				exit("Unable to push data into Table No. 81 ..."); 
				}*/
				
				//Ledger Entry
				odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn)); // Ledger Credit Table
				odbc_exec($conn, $InvDbt) or exit(odbc_errormsg($conn)); // Ledger Debit Table                            
                        }
                    }
                }

                // End of Activity.

   //         }
   //     }

	?>
		<script>
			window.open("ReceiptRegistration.php?id=<?php echo $_REQUEST['SystemGenratedNo']?>&ms=<?php echo $ms?>&LoginID=<?php echo $UserID?>","windowName", "width=900,height=500,scrollbars=no");
			//window.location="EnquiryDone.php";
		</script>
		

		
	<?php
		/*}
		else{*/
	?>	

</div>
<?php
		/*}
	}
	else{
		header("Location: NewRegistrationDetails.php?EnquiryNo=".$_REQUEST['EnquiryNo']."&Err=".addslashes($_REQUEST['RegistrationFormNo']));
	}*/
	require_once("../footer.php");
?>