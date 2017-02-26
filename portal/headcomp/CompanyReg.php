<?php
   
	date_default_timezone_set('Asia/Calcutta');    
	//$count = isset($_REQUEST['count']);
	$cid = $_REQUEST['cid'];
	//if(!$cid){ header("Location: index.php");}
    require_once 'header.php';
    //echo "<br /><br /><br /><br />";

    //Company details ....
	
    $Company = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]= '$cid' ") or exit(odbc_errormsg($conn));
    $Comp = odbc_fetch_array($Company);

    //Registration No ....
    $rn = "RN".$cid.date('ym');//echo $rn;    
   // echo "SELECT (COUNT([ID])+1) AS [C] FROM [SchoolRegistrationForm] WHERE [RegNo] LIKE '$rn%' AND [SchoolID]='$cid' <br />";
    $RegistrationNo = odbc_exec($conn, "SELECT (COUNT([ID])+1) AS [C] FROM [SchoolRegistrationForm] WHERE [RegNo] LIKE '$rn%' AND [SchoolID]='$cid' ") or die(odbc_errormsg($conn));
    $rn .= str_pad(odbc_result($RegistrationNo, "C"), 4, "0", STR_PAD_LEFT); //Registration No. 
    
    $RegNo = strtoupper($rn);
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
    $LastSchool = addslashes(strtoupper($_REQUEST['LastSchool']));
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
    $FatherOfficeAddress = addslashes(strtoupper($_REQUEST['FatherOfficeAddress']));
    $MotherIncome = addslashes(strtoupper($_REQUEST['MotherIncome']));
    $FatherIncome = addslashes(strtoupper($_REQUEST['FatherIncome']));
    $ResidentialAddress = addslashes(strtoupper($_REQUEST['ResidentialAddress']));
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

		    if(basename($_FILES["fileToUpload"]["name"])){
		    	require_once("FileToUpload.php");
		    }
		  
		    $result = "INSERT INTO [SchoolRegistrationForm]([Picture],[SchoolID],[RegNo],[AcadYear],[Sibling],[Staff],[Sex],[Religion],[Caste],[MotherTongue],[Candidate],[Nationality]
		    ,[DOB],[Age],[ClassApplied],[LastSchool],[MotherName],[FatherName],[MotherDOB],[FatherDOB],[MotherEducation],
		    [FatherEducation],[MotherMobile],[FatherMobile],[MotherEmail],[FatherEmail],[MotherOccupation],[FatherOccupation],
		    [MotherDesignation],[FatherDesignation],[MotherOrganization],[FatherOrganization],[MotherOfficeAddress],
		    [FatherOfficeAddress],[MotherIncome],[FatherIncome],[ResidentialAddress],[PIN],[State],[City],
		    [ResidentialPhone],[EmergencyNo],[Email],[MaritalStatus],[ChildName1],[ChildName2],[ChildName3],
		    [ChildName4],[ChildAge1],[ChildAge2],[ChildAge3],[ChildAge4],[ChildGender1],[ChildGender2],[ChildGender3],
		    [ChildGender4],[ChildSchool1],[ChildSchool2],[ChildSchool3],[ChildSchool4],[ChildClass1],[ChildClass2],
		    [ChildClass3],[ChildClass4],[USN1],[USN2],[USN3],[USN4],[Distance],[TransportMode],[PhysicallyChallenged],
		    [PhysicallyRemarks],[AppDate])
		    VALUES('$target_file','$cid','$RegNo','$AcadYear','$Sibling','$Staff','$Sex','$Religion','$Caste','$MotherTongue','$Candidate',
		    '$Nationality','$DOB','$Age','$ClassApplied','$LastSchool','$MotherName','$FatherName','$MotherDOB','$FatherDOB',
		    '$MotherEducation','$FatherEducation','$MotherMobile','$FatherMobile','$MotherEmail','$FatherEmail',
		    '$MotherOccupation','$FatherOccupation','$MotherDesignation','$FatherDesignation','$MotherOrganization',
		    '$FatherOrganization','$MotherOfficeAddress','$FatherOfficeAddress','$MotherIncome','$FatherIncome',
		    '$ResidentialAddress','$PIN','$State','$City','$ResidentialPhone','$EmergencyNo','$Email','$MaritalStatus',
		    '$ChildName1','$ChildName2','$ChildName3','$ChildName4','$ChildAge1','$ChildAge2','$ChildAge3','$ChildAge4',
		    '$ChildGender1','$ChildGender2','$ChildGender3','$ChildGender4','$ChildSchool1','$ChildSchool2',
		    '$ChildSchool3','$ChildSchool4','$ChildClass1','$ChildClass2','$ChildClass3','$ChildClass4',
		    '$USN1','$USN2','$USN3','$USN4','$Distance','$ModeOfTransport','$PhysicallyChallenged','$PhysicallyRemarks','$AppDate')";
		    $result1 = odbc_exec($conn, $result) or exit(odbc_errormsg($conn));
		    
      		if($result1){    
      		/*  if($count > 1){    
            for($q=1; $q < $count; $q++){
                
                odbc_exec("INSERT INTO `SchRegReply` SET 
                        `RegNo` = '$RegNo',
                        `QuesID` = '".$_REQUEST["QuesID".$q]."',
                        `Reply` = '".addslashes($_REQUEST["Reply".$q])."',
                        `SchoolID`= '".$cid."'") or die(odbc_error());
            		}
        		}
			*/
			//send email.
	
	$from = "Admission <".$Comp['Email'].">";
	if($Email != "") $to = "$Email, ";
	if($MotherEmail != "") $to .= "$MotherEmail, ";
	if($FatherEmail != "") $to .= "$FatherEmail, ";
	
	$to = substr($to, 0, -2);
	$subject = "Application Form - $RegNo // Receipt Acknowledgment.";
	
	$body = "<html><head></head><body style='font-family: arial, sans-serif; font-size: 13px'><p align='justify'>Dear Parent,</p>";
	$body .= "<p align='justify'>Thanks for contacting ".$Comp['SchoolName'].". </p>";
	$body .= "<p align='justify'>We acknowledge that we have received application for your child <b>$Candidate</b></p>
	<p align='justify'>The application no is <b>$RegNo</b>. Please produce the mentioned application no. whenever asked by the school authorities at the time of verification & registration.</p>
	<p align='justify'>You are requested to please print the form as given in the link below and bring the physical copy of the form to school along with the documents mentioned in the form for verification.</p>";
	$body .= "<p align='justify'><a href='http://202.54.232.182/registration/PrintForm.php?cid=$cid&RegNo=$RegNo' style='padding: 10px; border: 1px solid #8800ff;background-color: #4961e1; color: #ffffff;'>Print Form</a>";
	$body .= "<p align='justify'>Selected candidate will be informed by mail / phone (provided by you for communication with school)
	of the date of visit to school for physical submission of form shortly.</p>
	<p align='justify'>Warm regards. <br /><br />".$Comp['SchoolName']."</p>
	<p align='justify'>This is a system generated mail. Please do not respond to it.</p>
	</body></html>";
	
	require_once "../smtp.php";
	//echo "<br /><br /><br />-------- <br /><br /><br />$from // $to // $subject // $body <br /><br /><br />-------- <br /><br /><br />";
?>
	<div class='container'>
		<center><p style="font-family: 'Poiret One', 'arial'; font-size: 30px; text-transform: uppercase;" ><?php echo $Comp['SchoolName']; ?></p>
		<?php echo $Comp['Address1']; ?> <?php echo $Comp['Address2']?> <?php echo $Comp['Address3']; ?><br /><br />
		<p style="font-family: 'Poiret One', 'arial'; font-size: 22px; text-transform: uppercase;">Application Form Receipt Acknowledgement</p></center>
		<?php 
			echo "<html><head></head><body style='font-family: arial, sans-serif; font-size: 13px'><p align='justify'>Dear Parent,</p>";
			echo  "<p align='justify'>Thanks for contacting ".$Comp['SchoolName'].". </p>";
			echo  "<p align='justify'>We acknowledge that we have received application for your child <b>$Candidate</b></p>";
			echo  "<p align='justify'>The application no is <b>$RegNo</b>. Please produce the mentioned application no. whenever asked by the school authorities at the time of verification & registration.</p>";
			echo  "<p align='justify'>You are requested to please print the form as given in the link below and bring the physical copy of the form to school along with the documents mentioned in the form for verification.</p>";
			echo  "<p align='justify'>Selected candidate will be informed by mail / phone  (provided by you for communication with school)
of the date of visit to school for physical submission of form shortly.</p>";
			echo  "<p align='justify'>Best wishes & warm regards. <br /><br />".$Comp['SchoolName']."</p>";			
		?>
		<br /><a href='PrintForm.php?cid=<?php echo $cid?>&RegNo=<?php echo $RegNo?>' style="padding: 10px; border: 1px solid #8800ff;background-color: #4961e1; color: #ffffff;">Print Form</a>
		</div>
<?php
    }
    else{
        echo "<div class='container'>Theer is some error. Please try again ...</div>";
    }
   
    require 'footer.php';
?>
