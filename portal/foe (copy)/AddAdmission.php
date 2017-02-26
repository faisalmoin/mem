<?php

	require_once("header.php");
	
	$id=$_REQUEST['id']; //Enquiry No
	$Pre_AdmNo=$_REQUEST['Pre_AdmNo'];
	$NewLine=$_REQUEST['NewLine'];
	/*
	$NoLine = mysql_query("SELECT `Admission` FROM  `no_line` WHERE `Company`='$ms'") or die(mysql_error());
	if(mysql_num_rows($NoLine)==0){
		$mysql_result = mysql_query("INSERT INTO `no_line` SET `Company`='$ms', `Admission`='$NewLine'") or die(mysql_error());
		if(!$mysql_result){		
			exit("A. Error!!! Unable to create No. Line Series. Contact Administrator ...");
		}
	}
	else{	
		$myQry = "UPDATE `no_line` SET `Admission`='$NewLine' WHERE `Company`='$ms'";
		$mysql_result = mysql_query($myQry) or die(mysql_error());
		if(!$mysql_result){
			exit("B. Error!!! Unable to create No. Line Series. Contact Administrator ...");
		}
	}
	*/
	// Max Entry Sequence ...
	$EntrySeq = odbc_exec($conn, "SELECT MAX([Entry Sequence])+1 AS EnqSeq FROM [Temp Application]") or die(odbc_errormsg());
	$eSeq = odbc_result($EntrySeq, "EnqSeq");
       // echo "<br /><br /><br />";
        //Check Class Section.
        $ChkClassSec = odbc_exec($conn,"SELECT [Class Code] FROM [Class Section] WHERE "
                . "[Academic Year]='".$_REQUEST['AdmissionYear']."' AND "
                . "[Class]='".$_REQUEST['Class']."' AND "
                . "[Section]='".$_REQUEST['Section']."' AND "
                . "[Curriculum]='".$_REQUEST['CurriculumInterested']."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                //exit($ChkClassSec);
        if (odbc_num_rows($ChkClassSec) == 0) exit("<div class='container'>
                 
        		<div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Error!</strong> Class Code is not defined in <b>[Class Section]</b> table for Academic Year: ".$_REQUEST['AdmissionYear'].", Class: ".$_REQUEST['Class'].", Section: ".$_REQUEST['Section']." and Curriculum: ".$_REQUEST['CurriculumInterested']." <br />
                                    Exiting Admission of <b>".$_REQUEST['StudentName']."</b> ...</div>
                    </div></div>");
        
      
        
        //Admission No.....
	$AdmNo = "WPA";
	
	$qryEnq1 = odbc_exec($conn, "SELECT COUNT([No_])+1 FROM [Temp Student]") or die(odbc_errormsg());
	$AdmNo=$AdmNo.  str_pad(odbc_result($qryEnq1, ""), 7, '0', STR_PAD_LEFT);
	
	$ChkEnq = odbc_exec($conn, "SELECT MAX([No_]) FROM [Temp Student] WHERE [No_]='$AdmNo' AND [Company Name]='$ms'") or die(odbc_errormsg());
	$a = substr(odbc_result($ChkEnq, "No_"),3 )+1;    
	if(odbc_result($ChkEnq, "No_") == 0){
	    if($AdmNo == ""){
	        $AdmNo = $AdmNo.str_pad("1", 7, '0', STR_PAD_LEFT);
	    }
	    else{
	        $AdmNo = $AdmNo;
	    }
	}
	else{
	    $AdmNo = $AdmNo.str_pad($a, 7, '0', STR_PAD_LEFT);
	}
	
	    $NoSeries = "WPA";
	
	    $ClassCode = $_REQUEST['Class']."-".$_REQUEST['Section']."-".$_REQUEST['CurriculumInterested']."-".$_REQUEST['AdmissionYear'];
	    $StudentStatus = 1;
	/*
	    $DiscountCodeNo1=$_REQUEST['DiscountCode1'];
	    $DiscountCodeNo2=$_REQUEST['DiscountCode2'];
	    
	    if($DiscountCodeNo1 != ""){
	    //Check Discount Code 1
            $CheckDiscCode1 = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [No_]='".addslashes($DiscountCodeNo1)."' AND [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
            if (odbc_num_rows($CheckDiscCode1) == 0) {
		exit("<div class='container'>
                    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Error!</strong> Discount Fee Code 1 is not mentioned in Table. Contact your administrator. <br />
                                    Exiting Admission of <b>".$_REQUEST['StudentName']."</b> ...</div>
                    </div></div>");
		}
	    }
            //Check Discount Code 2
	    if($DiscountCodeNo2 != ""){
            $CheckDiscCode2 = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [No_]='".$DiscountCodeNo2."' AND [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
            if (odbc_num_rows($CheckDiscCode2) == 0) {
		exit("<div class='container'>
                    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Error!</strong> Discount Fee Code 2 is not mentioned in Table. Contact your administrator. <br />
                                    Exiting Admission of <b>".$_REQUEST['StudentName']."</b> ...</div>
                    </div></div>");
		}
	}
	
	*/
	
	    $ClSeq = odbc_exec($conn, "SELECT [Code], [Sequence] FROM [Class] WHERE [Code]='".$_REQUEST['Class']."' AND [Company Name]='$ms'");
	    $ClassSequence = odbc_result($ClSeq, 'Sequence');
	
	    $EWS = (($_REQUEST['EWS']=="")?0:1);
	    $HostelAccomodation = (($_REQUEST['HostelAccomodation']=="")?0:1);
	    
	    $ApplicantRelationship=strtoupper($_REQUEST['GuardianRelationship']);
	    $AcadYear=strtoupper($_REQUEST['AdmissionYear']);
	    $CommunicationReference=strtoupper($_REQUEST['CommunicationReference']);
	    $Address1=strtoupper(str_replace("'", "''",$_REQUEST['Address1']));
	    $Address2=strtoupper(str_replace("'", "''",$_REQUEST['Address2']));
	    $ContactName=strtoupper(str_replace("'", "''",$_REQUEST['ContactName']));
	    $AdmissionYear=strtoupper($_REQUEST['AdmissionYear']);
	    $ApplicationNo=strtoupper(str_replace("'", "''",$_REQUEST['RegistrationFormNo']));
	    $Caste=strtoupper($_REQUEST['Caste']);
	    $Citizenship=strtoupper($_REQUEST['Citizenship']);
	    $City=strtoupper(strtoupper($_REQUEST['City']));
            $CityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$City'") or die(odbc_errormsg($conn));
                $CTC = odbc_result($CityCode, "StateCode");
                if($CTC != "") $City=$CTC;
                else $City = substr($City, 0, 9);

	    $Class=strtoupper($_REQUEST['Class']);
	    $Community=strtoupper($_REQUEST['Community']);
	    $Country=strtoupper($_REQUEST['Country']);
	    $CurriculumInterested=strtoupper(str_replace("'", "''",$_REQUEST['CurriculumInterested']));
	    $AdmissionDate=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['AdmissionDate'])));
	    $DOB=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DOB'])));
	    $Email=$_REQUEST['Email'];
	    $EnquiryNo=$_REQUEST['$id'];
	    $RegistrationStatus=3;
	    $FatherEmail=$_REQUEST['FatherEmail'];
	    $FatherOfficeAddress1=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeAddress1']));
	    $FatherOfficeAddress2=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeAddress2']));
	    $FatherOfficeCity=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeCity']));
	    $FCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$FatherOfficeCity'") or die(odbc_errormsg($conn));
                $FCTC = odbc_result($FCityCode, "StateCode");
                if($FCTC != "") $FatherOfficeCity=$FCTC;
                else $FatherOfficeCity = substr($FatherOfficeCity, 0, 9);
            
            $FatherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficeCountry']));
	    $FatherOfficePostCode=strtoupper(str_replace("'", "''",$_REQUEST['FatherOfficePostCode']));
	    $FatherAnnualIncome=(($_REQUEST['FatherAnnualIncome']!="")?$_REQUEST['FatherAnnualIncome']:0);
	    $FatherName=strtoupper($_REQUEST['FatherName']);
	    $FatherOccupation=strtoupper(str_replace("'", "''",$_REQUEST['FatherOccupation']));
	    $FatherQualification=strtoupper(str_replace("'", "''",$_REQUEST['FatherQualification']));
	    $FeeClassification=strtoupper(str_replace("'", "''",$_REQUEST['FeeClassification']));
	    $FoodHabits=$_REQUEST['FoodHabits'];
	    $Gender=$_REQUEST['Gender'];
	    $GaurdianAnnualIncome=(($_REQUEST['GaurdianAnnualIncome']!="")?$_REQUEST['GaurdianAnnualIncome']:0);
	    $GaurdianName=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianName']));
	    $GaurdianOccupation=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianOccupation']));
	    $GaurdianOfficeAddress1=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianOfficeAddress1']));
	    $GaurdianOfficeAddress2=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianOfficeAddress2']));
	    $GaurdianOfficeCity=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianOfficeCity']));
	    $GCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='".isset($GuardianOfficeCity)."'") or die(odbc_errormsg($conn));
                $GCTC = odbc_result($GCityCode, "StateCode");
                if($GCTC != "") $GuardianOfficeCity=$GCTC;
                else $GuardianOfficeCity = substr($GuardianOfficeCity, 0, 9);
            
            $GaurdianOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianOfficeCountry']));
	    $GaurdianOfficePostCode=$_REQUEST['GaurdianOfficePostCode'];
	    $GaurdianQualification=strtoupper(str_replace("'", "''",$_REQUEST['GaurdianQualification']));
	    $Height=(($_REQUEST['Height']!="")?$_REQUEST['Height']:0);	    
	    $Language2=(($_REQUEST['Language2']!="")?$_REQUEST['Language2']:0);
	    $Language3=(($_REQUEST['Language3']!="")?$_REQUEST['Language3']:0);
	    $MediumInstruction=strtoupper($_REQUEST['MediumInstruction']);
	    $MobileNo=$_REQUEST['MobileNo'];
	    $MotherEmail=$_REQUEST['MotherEmail'];
	    $MotherOfficeAddress1=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeAddress1']));
	    $MotherOfficeAddress2=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeAddress2']));
	    $MotherOfficeCity=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeCity']));
            $MCityCode = odbc_exec($conn, "SELECT [StateCode] FROM [postcode] WHERE [State]='$MotherOfficeCity'") or die(odbc_errormsg($conn));
                $MCTC = odbc_result($MCityCode, "StateCode");
                if($MCTC != "") $MotherOfficeCity=$MCTC;
                else $MotherOfficeCity = substr($MotherOfficeCity, 0, 9);
            
	    $MotherOfficeCountry=strtoupper(str_replace("'", "''",$_REQUEST['MotherOfficeCountry']));
	    $MotherOfficePostCode=$_REQUEST['MotherOfficePostCode'];	    
	    $MotherTongue=strtoupper($_REQUEST['MotherTongue']);
	    $MotherAnnualIncome=(($_REQUEST['MotherAnnualIncome']!="")?$_REQUEST['MotherAnnualIncome']:0);
	    $MotherName=strtoupper(str_replace("'", "''",$_REQUEST['MotherName']));
	    $MotherOccupation=strtoupper(str_replace("'", "''",$_REQUEST['MotherOccupation']));
	    $MotherQualification=strtoupper(str_replace("'", "''",$_REQUEST['MotherQualification']));
	    $StudentName=strtoupper($_REQUEST['StudentName']);
	    $PhoneNo=$_REQUEST['PhoneNo'];
	    $PhysicallyChallenged=((isset($_REQUEST['PhysicallyChallenged'])!="")?$_REQUEST['PhysicallyChallenged']:0);
	    $PostCode=$_REQUEST['PostCode'];
	    $Quota=strtoupper($_REQUEST['Quota']);
	    $RegistrationNo=strtoupper($_REQUEST['RegistrationNo']);
	    $Religion=strtoupper($_REQUEST['Religion']);
	    $Remarks=str_replace("'", "''",$_REQUEST['Remarks']);
	    $Section=$_REQUEST['Section'];
	    $StaffChild=((isset($_REQUEST['StaffChild'])=="Yes")?1:0);
	    $StaffCode=isset($_REQUEST['StaffCode']);
	    $State=strtoupper(strtoupper($_REQUEST['State']));
	    $StudentStatus=1;
	    $Weight=(($_REQUEST['Weight']!="")?$_REQUEST['Weight']:0);
	    $UserLoginID=$LoginID;
	    $PortalID=$LoginID;
	    $Stream = ((isset($_REQUEST['Stream'])!="")?$_REQUEST['Stream']:0);
	    $TransportRequired = (($_REQUEST['SlabCode']!="")?1:0);
	    $TransFee = (($_REQUEST['TransFee']!="")?$_REQUEST['TransFee']:0);
	    $SlabCode = (($_REQUEST['SlabCode']!="")?$_REQUEST['SlabCode']:0);
	    $TransDist = (($_REQUEST['TransDist']!="")?$_REQUEST['TransDist']:0);
	    $CertiCode = $_REQUEST["CertiCode".$cr];
	    $CertiStatus = $_REQUEST["CertiStatus".$cr];
	    $CertiDate== $_REQUEST["CertiDate"];
	    $fee_Id = $_REQUEST["fee_Id".$f];
	    $fee = $_REQUEST["fee".$f];
	    $fee_count = $_REQUEST["fee_count"];
	    $discount = $_REQUEST["discount".$d];
	    $discount_Id = $_REQUEST["discount_Id".$d];
	    $Dis_count = $_REQUEST["Dis_count"];
	    $MotherMobile=$_REQUEST['MotherMobile'];
	    $FatherMobile=$_REQUEST['FatherMobile'];
	    $cust_no=$_REQUEST['cust_no'];
	    
	   // $CertiDate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])));
	// print_r($_POST);
			//die();	
	    //UPDATE Application Status
	   // echo "<br /><br />";
	   $AppRegStat = "UPDATE [Temp Application] SET 
	            [Academic Year] = '$AcadYear',
	            [Address To] = '$CommunicationReference',
	            [Address1] = '$Address1',
	            [Address2] = '$Address2',
	            [Addressee] = '$ContactName',
	            [Admission Date] = '$AdmissionDate',
	            [Admission For Year] = '$AdmissionYear',
	            [Applicant Relationship] = '$ApplicantRelationship',
	            [Caste] = '$Caste',
	            [Citizenship] = '$Citizenship',
	            [City] = '$City',
	            [Class] = '$Class',
	            [Community] = '$Community',
	            [Country] = '$Country',
	            [Curriculum Intrested] = '$CurriculumInterested',
	            [Date of Birth] = '$DOB',
	            [Discount Code] = '$DiscountCodeNo1',
	            [Discount Code 1] = '$DiscountCodeNo2',
		        [Distance] = $TransDist,
	            [Distance Covered in KM] = $TransDist,
	            [E-Mail Address] = '$Email',
	            [EWS] = $EWS,
	            [Father Email] = '$FatherEmail',
	            [Father Office Address 1] = '$FatherOfficeAddress1',
	            [Father Office Address 2] = '$FatherOfficeAddress2',
	            [Father Office City] = '$FatherOfficeCity',
	            [Father Office Country Code] = '$FatherOfficeCountry',
	            [Father Office Post Code] = '$FatherOfficePostCode',
	            [Father_s Annual Income] = '$FatherAnnualIncome',
	            [Father_s Name] = '$FatherName',
	            [Father_s Occupation] = '$FatherOccupation',
	            [Father_s Qualification] = '$FatherQualification',
	            [Fee Classification] = '$FeeClassification',
	            [Food Habits] = $FoodHabits,
	            [Gender] = $Gender,
	            [Guardian Annual Income] = '$GaurdianAnnualIncome',
	            [Guardian Name] = '$GaurdianName',
	            [Guardian Occupation] = '$GaurdianOccupation',
	            [Guardian Office Address 1] = '$GaurdianOfficeAddress1',
	            [Guardian Office Address 2] = '$GaurdianOfficeAddress2',
	            [Guardian Office City] = '$GaurdianOfficeCity',
	            [Guardian Office Country Code] = '$GaurdianOfficeCountry',
	            [Guardian Office Post Code] = '$GaurdianOfficePostCode',
	            [Guardian Qualification] = '$GaurdianQualification',
	            [Height] = $Height,
	            [Hostel Acommodation] = $HostelAccomodation,
	            [InsertStatus] = 0,
	            [Langauge 1] = $Language2,
	            [Language 2] = $Language3,
	            [Medium of Instruction] = '$MediumInstruction',
	            [Mobile Number] = '$MobileNo',
	            [Mother Mobile] = '$MotherMobile',
	            [Father Mobile]='$FatherMobile',
	            [Mother Email] = '$MotherEmail',
	            [Mother Office Address 1] = '$MotherOfficeAddress1',
	            [Mother Office Address 2] = '$MotherOfficeAddress2',
	            [Mother Office City] = '$MotherOfficeCity',
	            [Mother Office Country Code] = '$MotherOfficeCountry',
	            [Mother Office Post Code] = '$MotherOfficePostCode',
	            [Mother Tongue] = '$MotherTongue',
	            [Mother_s Annual Income] = '$MotherAnnualIncome',
	            [Mother_s Name] = '$MotherName',
	            [Mother_s Occupation] = '$MotherOccupation',
	            [Mother_s Qualification] = '$MotherQualification',
	            [Name] = '$StudentName',
	            [No_] = '$RegistrationNo',
	            [No_Series] = 'WPA',
	            [Phone Number] = '$PhoneNo',
	            [Physically Challanged] = $PhysicallyChallenged,
	            [Physically Challenged] = $PhysicallyChallenged,
	            [Portal ID] = '$PortalID',
	            [Post Code] = '$PostCode',
	            [Quota] = '$Quota',
	            [Registration No_] = '$ApplicationNo',
	            [Religion] = '$Religion',
	            [Remarks] = '$Remarks',
	            [Section] = '$Section',
	            [Slab Code] = '$SlabCode',
	            [Staff Child] = $StaffChild,
	            [Staff Code] = '$StaffCode',
	            [State] = '$State',
	            [Stream] = $Stream,
	            [Transport Fee] = $TransFee,
	            [Transport Required] = $TransportRequired,
	            [User ID] = '$UserLoginID',
	            [Weight] = $Weight,
		        [Entry Sequence] = $eSeq,
	            [Registration Status]=3, [UpdateStatus]=1, [Allot Student]=1 WHERE [Enquiry No_]='".$id."' AND [Company Name]='$ms'";
	  // print_r($_POST);
	  // "<br /><br />";
		//echo "$AppRegStat <br /><br />";
		
	    $EnqRegStat = "UPDATE [Temp Enquiry] SET [AdmissionStatus]=1, [UpdateStatus]=1 WHERE [System Genrated No_]='".$id."' AND [Company Name]='$ms' ";
	   // echo "$EnqRegStat <br /><br />";
	    
	    $AppStat = odbc_prepare($conn, $AppRegStat);
	   
	    if(!odbc_execute($AppStat)){
		echo $AppRegStat;
	        exit("<div class='container'>
                    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Error!</strong> Unable to update Registration Status. Kindly check ...<br /><b>Description:</b> ".odbc_errormsg($conn)."</div>
                    </div></div>");
	   }
	    else{ 
	    	// Certificate details
	    	      
			$cert="";
			for($cr=1; $cr <= $_REQUEST['Certi_count']; $cr++){
			$cert .= "INSERT INTO [Temp Application Certificate] ([Application No_], [Ceritificate], [Certificate Status], [Receipt Date _ Submission date],[User ID], [Portal ID], [InsertStatus], [UpdateStatus], [ERPUpdateStatus], [Company Name], [System Genrated No_], [Line No_]) VALUES ('".$RegistrationNo."','".isset($_REQUEST["CertiCode".$cr])."','".isset($_REQUEST["CertiStatus".$cr])."','".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', isset($_REQUEST["CertiDate".$cr]))))."', '$LoginID', '$PortalID', 1,0,'', '$ms', '', '') <br />";
			
			if(isset($_REQUEST["CertiStatus".$cr]) != 0){
				//Check certificate
				$CertChk =odbc_exec($conn, "SELECT * FROM [Temp Application Certificate] WHERE [Application No_]='$RegistrationNo' AND [Ceritificate]='".$_REQUEST["CertiCode".$cr]."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
				//echo "$CertChk <br /><br />";
				//exit();
				/*echo "INSERT INTO [Temp Application Certificate] ([Application No_], [Ceritificate], [Certificate Status], [Receipt Date _ Submission date],[User ID], [Portal ID], [InsertStatus], [UpdateStatus], [ERPUpdateStatus], [Company Name], [System Genrated No_], [Line No_]) 
					VALUES ('".$RegistrationNo."','".$_REQUEST["CertiCode".$cr]."','".$_REQUEST["CertiStatus".$cr]."','".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])))."', '$LoginID', '$PortalID', 1,0,'', '$ms', '', '') <br /><br />" ;*/
				if(odbc_num_rows($CertChk) == "0"){
					$certResult = odbc_exec($conn, "INSERT INTO [Temp Application Certificate] ([Application No_], [Ceritificate], [Certificate Status], [Receipt Date _ Submission date],[User ID], [Portal ID], [InsertStatus], [UpdateStatus], [ERPUpdateStatus], [Company Name], [System Genrated No_], [Line No_]) 
					VALUES ('".$RegistrationNo."','".$_REQUEST["CertiCode".$cr]."','".$_REQUEST["CertiStatus".$cr]."','".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])))."', '$LoginID', '$PortalID', 1,0,'', '$ms', '', '')"); 
					
				}
				else{
				/*
					echo "UPDATE [Temp Application Certificate] SET
					[Certificate Status]='".$_REQUEST["CertiStatus".$cr]."',
					[Receipt Date _ Submission date]='".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])))."',
					[User ID]='$LoginID',
					[Portal ID]='$PortalID',
					[InsertStatus]=0,
					[UpdateStatus]=1,
					[ERPUpdateStatus]='',
					[System Genrated No_]='',
					[Line No_]='' WHERE  [Application No_]='".$RegistrationNo."' AND  [Ceritificate]='".$_REQUEST["CertiCode".$cr]."' AND [Company Name]='$ms' <br /><br />";
					*/
					$certResult = odbc_exec($conn, "UPDATE [Temp Application Certificate] SET
					[Certificate Status]='".$_REQUEST["CertiStatus".$cr]."', 
					[Receipt Date _ Submission date]='".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])))."',
					[User ID]='$LoginID', 
					[Portal ID]='$PortalID', 
					[InsertStatus]=0, 
					[UpdateStatus]=1, 
					[ERPUpdateStatus]='', 					 
					[System Genrated No_]='', 
					[Line No_]='' WHERE  [Application No_]='".$RegistrationNo."' AND  [Ceritificate]='".$_REQUEST["CertiCode".$cr]."' AND [Company Name]='$ms' "); 
					
				}
				
				// echo "$EnqRegStat <br /><br />";
				
				
			if(!$certResult){ echo exit("<div class='container'>
	                    <div class='bs-example'>
	                            <div class='alert alert-danger alert-error'>
	                                    <a href='#' class='close' data-dismiss='alert'>&times;</a>".odbc_errormsg($conn)."</div>
	                    </div></div>");
                        }
	            }
		   
	        }
	        /*----------------------------end----------------------------- */
	        // Fee details
	       
	        $ins = 0;
	        $count = $_REQUEST['fee_count'];
	        for($f=1; $f<=$_REQUEST['fee_count']; $f++){
	        	if($_REQUEST['fee'.$f] != 0){
	        	$SQL1 = "INSERT INTO [StudentFee] ([ApplicationNo], [CompanyName], [FeeNo], [Description_], [DocumentNo_]) VALUES ('".$cust_no."','".$ms."','".$_REQUEST["fee_Id".$f]."','".$_REQUEST["Description".$f]."','".$_REQUEST["DocumentNo_".$f]."')";
	        		$result1 = odbc_exec($conn, $SQL1) or exit(odbc_errormsg($conn));
	        			//var_dump($result1);
	        			if(!$result1){
	        				exit ("Unable to insert record : ".$_REQUEST["fee_Id".$f]." ...");
	        			 }
	        			 unset($SQL1);
	        	}
	        	
	        	unset($result1);
	        }
	        /*----------------------------end----------------------------- */
	        // Discount details
		        $in = 0;
		        $count = $_REQUEST['Dis_count'];
		        for($d=1; $d<=$_REQUEST['Dis_count']; $d++){
		        	if($_REQUEST['discount'.$d] != 0){
		        	//echo "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('".$_REQUEST['RegistrationNo']."','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')";
		        	//echo "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo]) VALUES ('".$_REQUEST['RegistrationNo']."','".$ms."','".$_REQUEST["discount_Id".$d]."')<br /><br />";
		        	// $SQL2 = "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo]) VALUES ('".$_REQUEST['RegistrationNo']."','".$ms."','".$_REQUEST["discount_Id".$d]."')";
		        	 $SQL2 = "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('".$cust_no."','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')";
		        	 echo "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('".$cust_no."','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')";
		        	 $result2 = odbc_exec($conn, $SQL2) or exit(odbc_errormsg($conn));
		        	 //var_dump($result2);
		        		if(!$result2){
		        			exit ("Unable to insert record : ".$_REQUEST["discount_Id".$d]." ...");
		        		} 
		        		
		        		unset($SQL2);
		        		unset($result2);
		        	}
		          }
		         
		          /*----------------------------end----------------------------- */
		          
                $EnqReg = odbc_prepare($conn, $EnqRegStat);
	        if(!odbc_execute($EnqReg)){
                    
	            exit("<div class='container'>
	                    <div class='bs-example'>
                            <div class='alert alert-danger alert-error'>
                                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                    <strong>Error!</strong> Unable to update Admission Status in Enquiry Table. Kindly check ...<br />
                                    <br /><b>Description:</b> ".odbc_errormsg($conn)."
                            </div>
	                    </div></div>");
	        }
		
		require_once("InvoceCalc.php");
				
		//echo "<META http-equiv='refresh' content='0;URL=ListSelection.php?eid=$ApplicationNo&Stu=$StudentName'>";//header("Location: NewEnquiry.php?eid=$EnquiryNo");
			
		
	 }
	
?>
	
<?php
    //require_once("NewFeediscount.php");
	    require_once("../footer.php");
?>
