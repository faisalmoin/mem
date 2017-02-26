
	<!-- Bootstrap core CSS -->
	<link href="bs/css/bootstrap.min.css" rel="stylesheet" />
	<!-- Custom styles for this template -->
	<link href="bs/css/sticky-footer-navbar.css" rel="stylesheet" />
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="bs/js/ie-emulation-modes-warning.js"></script>
	<script src="bs/js/jquery.min.js"></script>
	<script src="bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="bs/css/jquery-ui.css">
    <script src="bs/js/jquery-1.10.2.js"></script>
    <script src="bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="bs/css/style.css">
	<title>Registration From</title>
    <style>
	.input{
		font-family: 'Josefin Sans', 'arial'; 
		font-size: 18px; 
		text-transform: uppercase;        
		color: #0072BC;
	 }
	.borderless tbody tr td, .borderless tbody tr th, .borderless thead tr th {
		border: none;
	 }
	 <!-- Bootstrap core CSS -->
	 <link href="bs/css/bootstrap.min.css" rel="stylesheet" />
	</style>

<?php

	date_default_timezone_set('Asia/Calcutta');    
	//$count = isset($_REQUEST['count']);
	$cid = $_REQUEST['cid'];
	//if(!$cid){ header("Location: index.php");}
    require_once("db.txt");
    //Company details ....
	$Company = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]= '$cid' ") or exit(odbc_errormsg($conn));
	$Comp = odbc_fetch_array($Company);
	/*
    Registration No ....
    $rn = "RN".$cid.date('ym');//echo $rn;    
    $RegistrationNo = odbc_exec($conn, "SELECT (COUNT([ID])+1) AS [C] FROM [Temp Enquiry] WHERE [No_] LIKE '$rn%' AND [Company Name]='$cid' ") or die(odbc_errormsg($conn));
    $rn .= str_pad(odbc_result($RegistrationNo, "C"), 3, "0", STR_PAD_LEFT); //Registration No. 
    */
    $SysNo = odbc_exec($conn, "SELECT (COUNT([ID])+1) AS [C] FROM [Temp Enquiry] WHERE [Company Name]='$cid'") or die(odbc_errormsg($conn));
    $SysGenNo = "ENQ".str_pad(odbc_result($SysNo, "C"), 3, '0', STR_PAD_LEFT);
  
    // $RegNo = strtoupper($rn);
	$id = $_REQUEST['id'];
    $AcadYear = strtoupper($_REQUEST['AcadYear']);
    $Sibling = addslashes(strtoupper($_REQUEST['Sibling']));
    $Staff = addslashes(strtoupper($_REQUEST['Staff']));
    $Sex = addslashes(strtoupper($_REQUEST['Sex']));
    $MotherTongue = addslashes(strtoupper($_REQUEST['MotherTongue']));
    $Caste = addslashes(strtoupper($_REQUEST['Caste']));
    $Religion = addslashes(strtoupper($_REQUEST['Religion']));
    $Candidate = addslashes(strtoupper($_REQUEST['Candidate']));
    $Nationality = addslashes(strtoupper($_REQUEST['Nationality']));
    $DOB = strtoupper($_REQUEST['DOB']);
    $Age = addslashes(strtoupper($_REQUEST['Age']));
    $ClassApplied = addslashes(strtoupper($_REQUEST['ClassApplied']));
    $LastSchool = str_replace("'", "''",addslashes(strtoupper($_REQUEST['LastSchool'])));
    $MotherName = addslashes(strtoupper($_REQUEST['MotherName']));
    $FatherName = addslashes(strtoupper($_REQUEST['FatherName']));
    $MotherDOB = addslashes(strtoupper($_REQUEST['MotherDOB']));
    $FatherDOB = addslashes(strtoupper($_REQUEST['FatherDOB']));
    $MotherEducation = addslashes(strtoupper($_REQUEST['MotherEducation']));
    $FatherEducation = addslashes(strtoupper($_REQUEST['FatherEducation']));
    $MotherMobile = addslashes(strtoupper($_REQUEST['MotherMobile']));
    $FatherMobile = addslashes(strtoupper($_REQUEST['FatherMobile']));
    $MotherEmail = addslashes(strtoupper($_REQUEST['MotherEmail']));
    $FatherEmail = addslashes(strtoupper($_REQUEST['FatherEmail']));
    $MotherOccupation = addslashes(strtoupper($_REQUEST['MotherOccupation']));
    $FatherOccupation = addslashes(strtoupper($_REQUEST['FatherOccupation']));
    $MotherDesignation = addslashes(strtoupper($_REQUEST['MotherDesignation']));
    $FatherDesignation = addslashes(strtoupper($_REQUEST['FatherDesignation']));
    $MotherOrganization = addslashes(strtoupper($_REQUEST['MotherOrganization']));
    $FatherOrganization = addslashes(strtoupper($_REQUEST['FatherOrganization']));
    
    $MotherOfficeAddress = addslashes(strtoupper($_REQUEST['MotherOfficeAddress']));
    if(strlen($MotherOfficeAddress) > 50){
	$MOAstrlen = strlen($MotherOfficeAddress)-50;
	$MAddress1 = substr($MotherOfficeAddress, 0, 50);	
	$MAddress2 = substr($MotherOfficeAddress, -$MOAstrlen);
    }
    else{
	$MAddress1 = substr($MotherOfficeAddress, 0, 50);	
	$MAddress2 = "";
    }
    $FatherOfficeAddress = str_replace("'", "''",strtoupper($_REQUEST['FatherOfficeAddress']));
    if(strlen($FatherOfficeAddress) > 50){
	$FOAstrlen = strlen($FatherOfficeAddress)-50;
	$FAddress1 = substr($FatherOfficeAddress, 0, 50);	
	$FAddress2 = substr($FatherOfficeAddress, -$FOAstrlen);
    }
    else{
	$FAddress1 = substr($FatherOfficeAddress, 0, 50);	
	$FAddress2 = "";
    }
    
    $MotherIncome = str_replace("'", "''",strtoupper($_REQUEST['MotherIncome']));
    $MotherIncome = ((is_numeric($MotherIncome)?$MotherIncome:0));
    
    $FatherIncome = addslashes(strtoupper($_REQUEST['FatherIncome']));
    $FatherIncome = ((is_numeric($FatherIncome)?$FatherIncome:0));
    
    $ResidentialAddress = str_replace("'", "''",strtoupper($_REQUEST['ResidentialAddress']));
    
    if(strlen($ResidentialAddress) > 50){
    
	$strlen = strlen($ResidentialAddress)-50;
	$Address1 = substr($ResidentialAddress, 0, 50);	
	$Address2 = substr($ResidentialAddress, -$strlen);
	}
	else{
		$Address1 = substr($ResidentialAddress, 0, 50);
		$Address2 = '';		
	}
    
    //echo "FOA1: Address:  $ResidentialAddress<br />Address1: $Address1 <br />Address2: $Address2";
    //exit();
    $PIN = addslashes(strtoupper($_REQUEST['PIN']));
    $State = addslashes(strtoupper($_REQUEST['State']));
    $City = addslashes(strtoupper($_REQUEST['City']));
    $ResidentialPhone = addslashes(strtoupper($_REQUEST['ResidentialPhone']));
    $EmergencyNo = addslashes(strtoupper($_REQUEST['EmergencyNo']));
    $Email = addslashes(strtolower($_REQUEST['Email']));
    $MaritalStatus = addslashes(strtoupper($_REQUEST['MaritalStatus']));
    $ChildName1 = addslashes(strtoupper($_REQUEST['ChildName1']));
    $ChildName2 = addslashes(strtoupper($_REQUEST['ChildName2']));
    $ChildName3 = addslashes(strtoupper($_REQUEST['ChildName3']));
    $ChildName4 = addslashes(strtoupper($_REQUEST['ChildName4']));
    $ChildAge1 = addslashes(strtoupper($_REQUEST['ChildAge1']));
    $ChildAge2 = addslashes(strtoupper($_REQUEST['ChildAge2']));
    $ChildAge3 = addslashes(strtoupper($_REQUEST['ChildAge3']));
    $ChildAge4 = addslashes(strtoupper($_REQUEST['ChildAge4']));
    $ChildGender1 = addslashes(strtoupper($_REQUEST['ChildGender1']));
    $ChildGender2 = addslashes(strtoupper($_REQUEST['ChildGender2']));
    $ChildGender3 = addslashes(strtoupper($_REQUEST['ChildGender3']));
    $ChildGender4 = addslashes(strtoupper($_REQUEST['ChildGender4']));
    $ChildSchool1 = addslashes(strtoupper($_REQUEST['ChildSchool1']));
    $ChildSchool2 = addslashes(strtoupper($_REQUEST['ChildSchool2']));
    $ChildSchool3 = addslashes(strtoupper($_REQUEST['ChildSchool3']));
    $ChildSchool4 = addslashes(strtoupper($_REQUEST['ChildSchool4']));    
    $ChildClass1 = addslashes(strtoupper($_REQUEST['ChildClass1']));
    $ChildClass2 = addslashes(strtoupper($_REQUEST['ChildClass2']));
    $ChildClass3 = addslashes(strtoupper($_REQUEST['ChildClass3']));
    $ChildClass4 = addslashes(strtoupper($_REQUEST['ChildClass4']));
    $USN1 = addslashes(strtoupper($_REQUEST['USN1']));
    $USN2 = addslashes(strtoupper($_REQUEST['USN2']));
    $USN3 = addslashes(strtoupper($_REQUEST['USN3']));
    $USN4 = addslashes(strtoupper($_REQUEST['USN4']));
    $AppDate = strtoupper(date('d/M/Y H:i:s'));
    $Distance = addslashes(strtoupper($_REQUEST['Distance']));
    $ModeOfTransport = addslashes(strtoupper($_REQUEST['ModeOfTransport']));
    $PhysicallyChallenged = addslashes(strtoupper($_REQUEST['PhysicallyChallenged']));
    $PhysicallyRemarks = addslashes(strtoupper($_REQUEST['PhysicallyRemarks']));
        
    //Insert the values in SchRegForm table
	
	if(!$conn){
		exit("<p style='color: #990000;'>Connection to DB via ODBC failed ...</p>");
	}
		
	//Get Curriculum
	/*$CurIntd = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Card] WHERE [Company name]='".$comp[0]."' AND [Class Code]='PRENUR'") or die(odbc_errormsg($conn));
	$CurriculumInterested = odbc_result($CurIntd, 'Curriculum');*/
	
	//Country Code
	$PostCountry = odbc_exec($conn, "SELECT [Country], [StateCode] FROM [PostCode] WHERE [State]='$State'") or die(mysql_error());
	$PC = odbc_fetch_array($PostCountry);
	$CountryCode = $PC[0];
	$StateCode = $PC[1];
	
	//No. of Sibling in the School
	if($ChildName1 != "" || $ChildName2 != "" || $ChildName3 != "" || $ChildName4 != "") $NoSibling = 4;
	if(($ChildName1 != "" || $ChildName2 != "" || $ChildName3 != "") && $ChildName4 == "") $NoSibling = 3;
	if(($ChildName1 != "" || $ChildName2 != "") && ($ChildName3 == "" || $ChildName4 != "")) $NoSibling = 2;
	if($ChildName1 != "" && ($ChildName2 == "" || $ChildName3 == "" || $ChildName4 != "")) $NoSibling = 1;
	if($ChildName1 == "" || $ChildName2 == "" || $ChildName3 == "" || $ChildName4 == "") $NoSibling = 0;
	
	
	$MotherIncome = (($MotherIncome != "")?$MotherIncome:0);
	$FatherIncome = (($FatherIncome != "")?$FatherIncome:0);
	
	//Address To & Adresse
	if($FatherName != ""){
		$AddressTo = "FATHER";
		$Addressee = $FatherName;
	}
	if($MotherName != ""){
		$AddressTo = "MOTHER";
		$Addressee = $MotherName;
	}
	if($FatherName != "" && $MotherName != ""){
		$AddressTo = "FATHER";
		$Addressee = $FatherName;
	}
		
	//Age
	$TempAge = explode(" ", $Age);
	$Age = $TempAge[0];
	if($Age == "NAN" || $Age == "" || $Age < 2) exit("Invalid Age of the child ...");
	
	//Academic Year;
	$AcadYear = substr($AcadYear, 2);
	
	//Mode of Transport
	$TransReqd=(($ModeOfTransport == "SCHOOL BUS/VAN")? 1: 0);
	
	//Enquiry Date
	$EnquiryDate = explode(" ",$AppDate);
	$AppDate = $EnquiryDate[0];
	//security code
	$security=$cid.rand().$SysGenNo.date('d/M/Y H:i:s');
	//$sec = md5($security);
	//-------insert code start --------
	if(basename($_FILES["fileToUpload"]["name"])){
		require_once("FileToUpload.php");
	}
	//Query 
	$MDBSQL ="INSERT INTO [Temp Enquiry] (
			[Picture],[Address 1],[Address 2],[Address 3],[Address To],[Addressee],[Admission For Year],[AdmissionStatus],
			[Age],[Campaign],[Category],[Citizenship],[City],[Class Applied],[Class Last Attended],[Company Name],
			[Country Code],[Curriculum Followed],[Curriculum Intrested],[D_O_B],[Date of Birth],[Distance],
			[Distance From School(km)],[E-Mail Address],[Enquirer Name],[Enquiry Date],[Enquiry Source],
			[Enquiry Status],[ERPUpdateStatus],[EWS],[Expectations From School],[Father Email],[Father Mobile],
			[Father Office Address 1],[Father Office Address 2],[Father Office City],[Father Office Country Code],
			[Father Office Post Code],[Father_s Annual Income],[Father_s Name],[Father_s Occupation],[Father_s Qualification],
			[FollowUP1],[FollowUP2],[FollowUP3],[Follow-ups],[Gender],[Guardian Annual Income],[Guardian Name],
			[Guardian Occupation],[Guardian Office Address 1],[Guardian Office Address 2],[Guardian Office City],
			[Guardian Office Country Code],[Guardian Office Post Code],[Guardian Qualification],[Hostel Accomodation],
			[How Do You Knw About School],[Inactive],[InsertStatus],[Intials],[Intials1],[Intials2],[Langauge 1],[Language 2],
			[Media Vehicle],[Medium Of Instruction],[Mobile Number],[MON],[Months],[Mother Email],[Mother Mobile],
			[Mother Office Address 1],[Mother Office Address 2],[Mother Office City],[Mother Office Country Code],
			[Mother Office Post Code],[Mother_s Annual Income],[Mother_s Name],[Mother_s Occupation],
			[Mother_s Qualification],[Name],[Name Of The Previous Institute],[Next FollowUp Date],[No Series],
			[No_],[No_ Of Sibling In Other School],[No_ Of Siblings In Our School],[Phone Number],[Physically Challenged],
			[Portal ID],[Post Code],[Reason For Leaving Pre_ School],[Reasons],[Registration Status],
			[Relationship with Applicant],[Religion],[Remarks],[Remarks1],[State],[Stream],
			[System Genrated No_],[Total No_ Of Siblings],[Transport Required],[Type Of Enquiry],
			[UpdateStatus],[User ID],[YEAR],
			[MaritalStatus],[ChildName1],[ChildName2],[ChildName3],[ChildName4],[ChildAge1],[ChildAge2],[ChildAge3],[ChildAge4],
			[ChildGender1],[ChildGender2],[ChildGender3],[ChildGender4],[ChildSchool1],[ChildSchool2],[ChildSchool3],[ChildSchool4],
			[ChildClass1],[ChildClass2],[ChildClass3],[ChildClass4],[USN1],[USN2],[USN3],[USN4],[TransportMode],[MotherDOB],[FatherDOB],
			[MotherDesignation],[FatherDesignation],[MotherOrganization],[FatherOrganization],[Sibling],[Staff],[Caste],[MotherTongue],[Physically Remarks],[SessionId])
		 VALUES
		 (  
			'$target_file','$Address1','$Address2','','$AddressTo','$Addressee','$AcadYear',0,$Age,'ONLINE',0,'$Nationality','$City','$ClassApplied','','$cid',
			'$Nationality','','$CurriculumInterested',0,'$DOB','$Distance','$Distance','$Email','','$AppDate','Email',0,0,0,'',
			'$FatherEmail','$FatherMobile','$FAddress1','$FAddress2','','','',$FatherIncome,'$FatherName','$FatherOccupation',
			'$FatherEducation','','','','',$Sex,0,'','','','','','','','',0,0,0,1,0,0,0,0,0,'$ModeOfTransport','ENGLISH','$ResidentialPhone',
			0,0,'$MotherEmail','$MotherMobile','$MAddress1','$MAddress1','','','',$MotherIncome,'$MotherName','$MotherOccupation',
			'$MotherEducation','$Candidate','$LastSchool','1753-01-01','WPE','$SysGenNo',0,$NoSibling,'$EmergencyNo',
			$PhysicallyChallenged,'$Login','$PIN','',0,0,'','$Religion','Online Registration','Online Registration','$State',
			0,'$SysGenNo',0,$TransReqd,'Email',0,'$Login',0,
	        '$MaritalStatus','$ChildName1','$ChildName2','$ChildName3','$ChildName4','$ChildAge1','$ChildAge2','$ChildAge3','$ChildAge4',
		    '$ChildGender1','$ChildGender2','$ChildGender3','$ChildGender4','$ChildSchool1','$ChildSchool2',
		    '$ChildSchool3','$ChildSchool4','$ChildClass1','$ChildClass2','$ChildClass3','$ChildClass4',
		    '$USN1','$USN2','$USN3','$USN4','$ModeOfTransport','$MotherDOB','$FatherDOB','$MotherDesignation','$FatherDesignation',
		    '$MotherOrganization','$FatherOrganization','$Sibling','$Staff','$Caste','$MotherTongue','$PhysicallyRemarks','".md5($security)."')";
			$result1 = odbc_exec($conn, $MDBSQL) or exit(odbc_errormsg($conn));
			//------------insert code
			//---------- mail code start------------
			if($result1){
			require_once "/bs/class.phpmailer.php";
			$mail = new PHPMailer();
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->Host = "125.16.64.67";  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = "erpadministrator@mempl.com";  // SMTP username
			$mail->Password = "access@1234"; // SMTP password
			$mail->SMTPDebug = 1;
			//Get user School Name and schoolEmail
			$mail->From = $Comp['E-Mail'];
			$mail->FromName = $Comp['Name'];
			//Get user Name and Email 
			if($Email != ""){
			$mail->AddAddress("$Email", "$Name");
			}
			//CC Email 
			if($FatherEmail != ""){
			$mail->addCC("$FatherEmail", "$FatherName");
			}
			if($MotherEmail != ""){
				$mail->addCC("$MotherEmail", "$MotherName");
			}
			//BCC Email
			$mail->addBCC("erpadministrator@mempl.com", "MEM ERP");
			
			$subject = "Application Form - $SysGenNo // Receipt Acknowledgment.";
			$body = "<html><head></head><body style='font-family: arial, sans-serif; font-size: 13px'><p align='justify'>Dear Parent,</p>";
			$body .= "<p align='justify'>Thanks for contacting ".$Comp['SchoolName'].". </p>";
			$body .= "<p align='justify'>We acknowledge that we have received application for your child <b>$Candidate</b></p>
			<p align='justify'>The application no is <b>$SysGenNo</b>. Please produce the mentioned application no. whenever asked by the school authorities at the time of verification & registration.</p>
			<p align='justify'>You are requested to please print the form as given in the link below and bring the physical copy of the form to school along with the documents mentioned in the form for verification.</p>";
			$body .= "<p align='justify'><a href='http://10.0.16.23/test/mef/portal/PrintForm.php?cid=$cid&RegNo=$SysGenNo&No=".md5($security)."' style='padding: 10px; border: 1px solid #8800ff;background-color: #4961e1; color: #ffffff;'>Print Form</a>";
			$body .= "<p align='justify'>Selected candidate will be informed by mail / phone (provided by you for communication with school)
			of the date of visit to school for physical submission of form shortly.</p>
			<p align='justify'>Warm regards. <br /><br />".$Comp['SchoolName']."</p>
			<p align='justify'>This is a system generated mail. Please do not respond to it.</p>
			</body></html>";
			//$mail->AddReplyTo("erpadministrator@mempl.com", "MEM ERP");
	        //$mail->AddAttachment($MOUFiile);                   // add attachments
			//$mail->AddAttachment($LOIFile);                    // optional name
			$mail->IsHTML(true);                                 // set email format to HTML
	
			$mail->WordWrap = 50;                                // set word wrap to 50 characters
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->AltBody = $body;
			$mail->Body;
				
			if(!$mail->Send())
			{
			   echo "<p>Message could not be sent.";
			   echo "Mailer Error: " . $mail->ErrorInfo."</p>";
			}
			else{
               ?>
				<div class="alert alert-info">
				<strong>Info!</strong> Message has been sent.
				</div>
				
				<?php 		
			}
				
				?>
				<!-------------mail code End------------->
				<meta http-equiv='refresh' content="0;URL='PrintForm.php?cid=<?php echo $cid?>&RegNo=<?php echo $SysGenNo?>&No=<?php echo md5($security)?>'" />
			<?php }		
			/*
			else{
				exit("<div class='bs-example'>
						<div class='alert alert-danger alert-error'>
							<a href='#' class='close' data-dismiss='alert'>&times;</a>
							<strong>Error!</strong> There is some error, kindly check.<br />".odbc_errormsg($conn)."<br /><br />
							$MDBSQL
						</div>
					</div>");
			}
		    
		*/
	
	
	    require 'footer.php';
	?>