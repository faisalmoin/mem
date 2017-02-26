<?php

	require_once("header.php");
?>

<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>School List </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

<?php
    //   print_r($_POST);
      // die();
	
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
	
	echo '<script>
		$(document).ready(function(){
			$(document).ajaxStart(function(){
				$("#wait").css("display", "block");
			});
			$(document).ajaxComplete(function(){
				$("#wait").css("display", "none");
			});
			$("button").click(function(){
				$("#txt").load("AddAdmission.php");
			});
		});
		</script>';

	
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
	
	   // $EWS = (($_REQUEST['EWS']=="")?0:1);
            $EWS = $_REQUEST['EWS'];
	   // $HostelAccomodation = (($_REQUEST['HostelAccomodation']=="")?0:1);
	    $HostelAccomodation = $_REQUEST['HostelAccomodation'];
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
	    $StaffChild=$_REQUEST['StaffChild'];
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
		//Check  Application Status
		$Check_App = odbc_exec($conn, "SELECT [Allot Student], [Entry Sequence] FROM [Temp Application] WHERE  [Enquiry No_]='".$id."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
		if(odbc_result($Check_App, "Allot Student") != 0 && odbc_result($Check_App, "Entry Sequence") != 0){
			exit('<div class="container">
					<div class="alert alert-danger">
						<strong>Alert !!! </strong> Please check status.
					</div>
				</div>');
		}
		
	    //UPDATE Application Status
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
	 
	    $EnqRegStat = "UPDATE [Temp Enquiry] SET [AdmissionStatus]=1, [UpdateStatus]=1 WHERE [System Genrated No_]='".$id."' AND [Company Name]='$ms' ";
	   
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
			   if(odbc_num_rows($CertChk) == "0"){
					$certResult = odbc_exec($conn, "INSERT INTO [Temp Application Certificate] ([Application No_], [Ceritificate], [Certificate Status], [Receipt Date _ Submission date],[User ID], [Portal ID], [InsertStatus], [UpdateStatus], [ERPUpdateStatus], [Company Name], [System Genrated No_], [Line No_]) 
					VALUES ('".$RegistrationNo."','".$_REQUEST["CertiCode".$cr]."','".$_REQUEST["CertiStatus".$cr]."','".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])))."', '$LoginID', '$PortalID', 1,0,'', '$ms', '', '')"); 
					
				}
				else{
				
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
		        	$SQL2 = "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('".$cust_no."','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')";
		        	// echo "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('".$cust_no."','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')";
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


            

	if($_REQUEST['EWS']==1 && $_REQUEST['EWS']!=0){
                    //Admission No
                    $App = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [System Genrated No_]='".$cust_no."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                    $cnt = odbc_exec($conn, "SELECT COUNT([ID])+1 AS [Count] FROM [Temp Student] WHERE [Company Name]='$ms' ") or die(odbc_errormsg($conn));
                    $AdmNo = "A".str_pad(odbc_result($cnt, "Count"), 4, '0', STR_PAD_LEFT);
                    $AllotStudent = 0;
                    $StuNo = $AdmNo;

                    //Class details
                    $cls = odbc_exec($conn, "select [Sequence], [Code] from [Class] WHERE [Company Name]='$ms' AND [Code]='".odbc_result($App, "Class")."'") or die(odbc_errormsg($conn));
                    $cl_sec = odbc_exec($conn, "select [Class Code] FROM [Class Section] WHERE [Company Name]='12' AND 
                                                    [Class]='".odbc_result($App, 'Class')."' AND 
                                                    [Academic Year]='".odbc_result($App, 'Academic Year')."' AND 
                                                    [Section]='".odbc_result($App, 'Section')."'") or die(odbc_errormsg($conn));

                    //Fee Clasiification
                    $fc1 = odbc_exec($conn, "select [fee clasification code] as [fc] from [discount fee header] where [company name]='$ms' AND [No_]='".odbc_result($App, 'Discount Code')."'");
                    $fc2 = odbc_exec($conn, "select [fee clasification code] as [fc] from [discount fee header] where [company name]='$ms' AND [No_]='".odbc_result($App, 'Discount Code 1')."'");


                    $sql4 = "INSERT INTO [Temp Student] ([No_], [Name],[Gender],[Date Of Birth],[Father_s Name],[Mother_s Name],[Citizenship],[Academic Year],[Class],[Hostel Acommodation],[Previous School],[Medium of Instruction],[Presently Residing with],[Curriculum],[Previous Class],[Previous Curriculum],[Address To],[Addressee],[Address1],[Address2],[City],[Post Code],[Country],[E-Mail Address],[Mobile Number],[Phone Number],[State],[Visa Exp Date],[Passport No_],[Passport Exp Date],[Visa No_],[Food Habits],[Applicant Image],[Father Image],[Mother Image],[Guardian Image],[Mother_s Qualification],[Mother_s Occupation],[Guardian Name],[Promotion Granted],[Father_s Occupation],[Mother_s Annual Income],[Guardian Qualification],[Guardian Occupation],[Guardian Annual Income],[Enquiry No_],[Religion],[Father_s Qualification],[Caste],[Age],[Months],[Father_s Annual Income],[Exam Code],[Community],[Mother Tongue],[New Student],[Section],[Student Status],[Class Code],[Address 3],[House],[Fee Classification],[Quota],[Physically Challanged],[Staff Child],[Staff Code],[Application No_],[Date Joined],[Room No_],[Hostel Code],[Hostel Alloted],[Hostel Vacated],[Room Type],[Mess],[CGPA Grade],[Latest Rank],[Latest GPA],[Latest Grade],[Student Image],[No_ Series],[Admission For Year],[Old Admission No_],[Pickup],[Drop],[Distance Covered in KM],[Transport Fee],[Approval Status],[Sibbling No_],[Sibbling Code],[Sibbling Name],[Route No_],[Height],[Weight],[Date of Leaving],[Father Office Address 1],[Father Office Address 2],[Father Office City],[Father Office Post Code],[Father Office Country Code],[Mother Office Address 1],[Mother Office Address 2],[Mother Office City],[Mother Office Post Code],[Mother Office Country Code],[Guardian Office Address 1],[Guardian Office Address 2],[Guardian Office City],[Guardian Office Post Code],[Guardian Office Country Code],[Registration No_],[Mother Email],[Mother Mobile],[Father Email],[Father Mobile],[Block],[User ID],[Portal ID],[Family Code],[Discount Code],[Discount Code 1],[EWS],[Enquiry Status],[Transport Required],[Category],[Physically Challenged],[Route Details],[Slab Code],[Withdrwal Applied Date],[TC No_],[TC Date],[Langauge 1],[Language 2],[Class Sequence],[Approver ID],[Student Status 1],[Class code 1],[EWS 1],[Discount Code New],[Discount Code1 New],[Transport Slab Code New],[Discount Classification],[Discount Classification1],[Company],[Sibling DOB],[Sibling Class],[Sibling Section],[Sibling],[Applicant Relationship],[Remarks],[Stream],[InsertStatus],[UpdateStatus],[Company Name],[System Genrated No_],[ERPUpdateStatus],[TPT Availing Date],[TPT Withdrawal Date],[TPT Availing Date-T],[TPT Withdrawal Date-T],[Bool2],[Bool3],[Bool4],[Bool1],[Allot Student],[Entry Sequence])

                                    VALUES('$AdmNo', '".odbc_result($App, 'Name')."',".odbc_result($App, 'Gender').",
                                    '".odbc_result($App, 'Date of Birth')."','".odbc_result($App, 'Father_s Name')."',
                                    '".odbc_result($App, 'Mother_s Name')."','".odbc_result($App, 'Citizenship')."',
                                    '".odbc_result($App, 'Academic Year')."','".odbc_result($App, 'Class')."',
                                    ".odbc_result($App, 'Hostel Acommodation').",'".odbc_result($App, 'Previous School')."',
                                    '".odbc_result($App, 'Medium of Instruction')."','".odbc_result($App, 'Presently Residing with')."',
                                    '".odbc_result($App, 'Curriculum Intrested')."','".odbc_result($App, 'Previous Class')."',
                                    '".odbc_result($App, 'Previous Curriculum')."','".odbc_result($App, 'Address To')."',
                                    '".odbc_result($App, 'Addressee')."','".odbc_result($App, 'Address1')."','".odbc_result($App, 'Address2')."',
                                    '".odbc_result($App, 'City')."','".odbc_result($App, 'Post Code')."','".odbc_result($App, 'Country')."',
                                    '".odbc_result($App, 'E-Mail Address')."','".odbc_result($App, 'Mobile Number')."',
                                    '".odbc_result($App, 'Phone Number')."','".odbc_result($App, 'State')."','".odbc_result($App, 'Visa Exp Date')."',
                                    '".odbc_result($App, 'Passport No_')."','".odbc_result($App, 'Passport Exp Date')."',
                                    '".odbc_result($App, 'Visa No_')."',".odbc_result($App, 'Food Habits').",'".odbc_result($App, 'Applicant Image')."',
                                    '".odbc_result($App, 'Father Image')."','".odbc_result($App, 'Mother Image')."',
                                    '".odbc_result($App, 'Guardian Image')."','".odbc_result($App, 'Mother_s Qualification')."',
                                    '".odbc_result($App, 'Mother_s Occupation')."','".odbc_result($App, 'Guardian Name')."',
                                    ".odbc_result($App, 'Promotion Granted').",'".odbc_result($App, 'Father_s Occupation')."',
                                    ".odbc_result($App, 'Mother_s Annual Income').",'".odbc_result($App, 'Guardian Qualification')."',
                                    '".odbc_result($App, 'Guardian Occupation')."',".odbc_result($App, 'Guardian Annual Income').",
                                    '".odbc_result($App, 'Enquiry No_')."','".odbc_result($App, 'Religion')."',
                                    '".odbc_result($App, 'Father_s Qualification')."','".odbc_result($App, 'Caste')."',".odbc_result($App, 'Age').",
                                    ".odbc_result($App, 'Months').",".odbc_result($App, 'Father_s Annual Income').",
                                    '".odbc_result($App, 'Exam Code')."','".odbc_result($App, 'Community')."','".odbc_result($App, 'Mother Tongue')."',1,
                                    '".odbc_result($App, 'Section')."',1,'".odbc_result($cl_sec, 'Class Code')."','".odbc_result($App, 'Address 3')."','',
                                    '".odbc_result($App, 'Fee Classification')."','".odbc_result($App, 'Quota')."',
                                    ".odbc_result($App, 'Physically Challanged').",".odbc_result($App, 'Staff Child').",
                                    '".odbc_result($App, 'Staff Code')."','".odbc_result($App, 'Registration No_')."',
                                    '".date('Y-m-d',odbc_result($chk_dr, 'Invoice Date'))."','','',0,0,'','','',0,0,'','','ADM',
                                    '".odbc_result($App, 'Admission For Year')."','".''."','".''."','".''."',".odbc_result($App, 'Distance Covered in KM').",
                                    ".odbc_result($App, 'Transport Fee').",1,".odbc_result($App, 'Sibling').",'".odbc_result($App, 'Sibling Code')."',
                                    '".odbc_result($App, 'Sibling Name')."','".odbc_result($App, 'Slab Code')."',".odbc_result($App, 'Height').",
                                    ".odbc_result($App, 'Weight').",'1753-01-01 00:00:00','".odbc_result($App, 'Father Office Address 1')."',
                                    '".odbc_result($App, 'Father Office Address 2')."','".odbc_result($App, 'Father Office City')."',
                                    '".odbc_result($App, 'Father Office Post Code')."','".odbc_result($App, 'Father Office Country Code')."',
                                    '".odbc_result($App, 'Mother Office Address 1')."','".odbc_result($App, 'Mother Office Address 2')."',
                                    '".odbc_result($App, 'Mother Office City')."','".odbc_result($App, 'Mother Office Post Code')."',
                                    '".odbc_result($App, 'Mother Office Country Code')."','".odbc_result($App, 'Guardian Office Address 1')."',
                                    '".odbc_result($App, 'Guardian Office Address 2')."','".odbc_result($App, 'Guardian Office City')."',
                                    '".odbc_result($App, 'Guardian Office Post Code')."','".odbc_result($App, 'Guardian Office Country Code')."',
                                    '".odbc_result($App, 'System Genrated No_')."','".odbc_result($App, 'Mother Email')."',
                                    '".odbc_result($App, 'Mother Mobile')."','".odbc_result($App, 'Father Email')."',
                                    '".odbc_result($App, 'Father Mobile')."',0,'".odbc_result($App, 'User ID')."','".odbc_result($App, 'Portal ID')."',
                                    '','".odbc_result($App, 'Discount Code')."','".odbc_result($App, 'Discount Code 1')."',".odbc_result($App, 'EWS').",
                                    ".odbc_result($App, 'Enquiry Status').",".odbc_result($App, 'Transport Required').",".odbc_result($App, 'Category').",
                                    ".odbc_result($App, 'Physically Challenged').",'".odbc_result($App, 'Slab Code')."',
                                    '".odbc_result($App, 'Slab Code')."','1753-01-01 00:00:00','','1753-01-01 00:00:00',
                                    ".odbc_result($App, 'Langauge 1').",".odbc_result($App, 'Language 2').",".odbc_result($cls, 'Sequence').",
                                    '$LoginID',0,'',0,'','','','".odbc_result($fc1, "fc")."','".odbc_result($fc2, "fc")."','$ms','".odbc_result($App, 'Sibling DOB')."','".odbc_result($App, 'Sibling Class')."',
                                    '".odbc_result($App, 'Sibling Section')."',".odbc_result($App, 'Sibling').",
                                    '".odbc_result($App, 'Applicant Relationship')."','".odbc_result($App, 'Remarks')."',
                                    ".odbc_result($App, 'Stream').",1,0,'$ms','$AdmNo',0,'1753-01-01 00:00:00',
                                    '1753-01-01 00:00:00','1753-01-01 00:00:00','1753-01-01 00:00:00',0,0,0,0,1,
                                    ".odbc_result($App, 'Entry Sequence').")";
                    //echo "$sql4 <br />";		
                    odbc_exec($conn, $sql4) or exit("Create Student // ".odbc_errormsg($conn));

                    //Create Customer
                    $sql5 = "INSERT INTO [Temp Customer]([No_], [Name], [Search Name], [Name 2], [Address], [Address 2], [City], [Contact], [Phone No_], [Telex No_], [Our Account No_], [Territory Code], [Global Dimension 1 Code], [Global Dimension 2 Code], [Chain Name], [Budgeted Amount], [Credit Limit (LCY)], [Customer Posting Group], [Currency Code], [Customer Price Group], [Language Code], [Statistics Group], [Payment Terms Code], [Fin_ Charge Terms Code], [Salesperson Code], [Shipment Method Code], [Shipping Agent Code], [Place of Export], [Invoice Disc_ Code], [Customer Disc_ Group], [Country_Region Code], [Collection Method], [Amount], [Blocked], [Invoice Copies], [Last Statement No_], [Print Statements], [Bill-to Customer No_], [Priority], [Payment Method Code], [Last Date Modified], [Application Method], [Prices Including VAT], [Location Code], [Fax No_], [Telex Answer Back], [VAT Registration No_], [Combine Shipments], [Gen_ Bus_ Posting Group], [Picture], [Post Code], [County], [E-Mail], [Home Page], [Reminder Terms Code], [No_ Series], [Tax Area Code], [Tax Liable], [VAT Bus_ Posting Group], [Reserve], [Block Payment Tolerance], [IC Partner Code], [Prepayment %], [Primary Contact No_], [Responsibility Center], [Shipping Advice], [Shipping Time], [Shipping Agent Service Code], [Service Zone Code], [Allow Line Disc_], [Base Calendar Code], [Copy Sell-to Addr_ to Qte From], [T_I_N_ No_], [Tax Exemption No_], [L_S_T_ No_], [C_S_T_ No_], [P_A_N_ No_], [E_C_C_ No_], [Range], [Collectorate], [Excise Bus_ Posting Group], [State Code], [Structure], [P_A_N_ Reference No_], [P_A_N_ Status], [Export or Deemed Export], [VAT Exempted], [Nature of Services], [Status], [Old Admission No_], [Student Status], [Class], [Section], [Gender], [InsertStatus], [UpdateStatus], [Company Name], [System Genrated No_], [ERPUpdateStatus], [User ID], [Portal ID])
                                    VALUES ('$AdmNo','".odbc_result($App, 'Name')."','','','".odbc_result($App, 'Address1')."','".odbc_result($App, 'Address2')."','".odbc_result($App, 'City')."','".odbc_result($App, 'Addressee')."','".odbc_result($App, 'Phone Number')."','','$AdmNo','','','','',0,0,'','','','',0,'','','','','','','".odbc_result($App, 'Discount Code')."','".odbc_result($fc1, "fc")."','".odbc_result($App, 'Country')."','',0,0,0,0,0,'$AdmNo',0,'','1753-01-01 00:00:00',0,0,'','','','',0,'','','".odbc_result($App, 'Post Code')."','','".odbc_result($App, 'E-Mail Address')."','','','ADM','',0,'',0,0,'',0,'".odbc_result($App, 'Mobile Number')."','',0,'','','',0,'',0,'','','','','','','','','','".odbc_result($App, 'State')."','','',0,0,0,0,1,'',1,'".odbc_result($App, 'Class')."','".odbc_result($App, 'Section')."',".odbc_result($App, 'Gender').",1,0,'$ms','".odbc_result($App, 'System Genrated No_')."',0,'$LoginID','$LoginID')";

                    //echo "<br /><br /><br /><br /><br />".$sql5;
                    odbc_exec($conn, $sql5) or exit("Create Customer // ".odbc_errormsg($conn));		

                    $sql6 = "UPDATE [Temp Application] SET [Allot Student]=0, [Student No_]='$AdmNo' WHERE [System Genrated No_]='$id' AND [Company Name]='$ms' ";
                    odbc_exec($conn, $sql6) or exit("Update Application // ".odbc_errormsg($conn));

                    $sql7 = "UPDATE [Temp Enquiry] SET [AdmissionStatus]=1 WHERE [No_]='".odbc_result($App, "Enquiry No_")."' AND [Company Name]='$ms'";
                    odbc_exec($conn, $sql7) or exit("Update Enquiry // ".odbc_errormsg($conn));

                }
		require_once("InvoceCalc.php");
                	
		//echo "<META http-equiv='refresh' content='0;URL=ListSelection.php?eid=$ApplicationNo&Stu=$StudentName'>";//header("Location: NewEnquiry.php?eid=$EnquiryNo");
	}
	
	echo '<div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src="../img/demo_wait.gif" width="64" height="64" /><br>Loading..</div>';
?>

<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->

<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php	
	require_once("../footer.php");
?>
