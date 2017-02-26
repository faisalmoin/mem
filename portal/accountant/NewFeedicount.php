<?php
   
	require_once("header.php");
        
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
	?>
	<!---------------------------------- step process-------------------- -->
	<style>
	body {
		//margin-top:40px;
	}
	.stepwizard-step p {
		margin-top: 10px;
	}
	.stepwizard-row {
		display: table-row;
	}
	.stepwizard {
		display: table;
		width: 50%;
		position: relative;
	}
	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}
	.stepwizard-row:before {
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
	}
	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}
	</style>
	<?php
	//echo "<br /><br /><br />";
	//print_r($_POST);
	
	$id=$_REQUEST['id']; //Enquiry No
	$Pre_AdmNo=$_REQUEST['Pre_AdmNo'];
	$NewLine=$_REQUEST['NewLine'];
		//Generate No Line
	//Get MAX Admission No from Student Table
	$AdmLine=odbc_exec($conn, "SELECT MAX([No_]) FROM [Temp Student] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$NewLine = substr(odbc_result($AdmLine, ""),1)+1;
	
	//Check in Local No_Line Table
	/*$NoLine = mysql_query("SELECT `Admission` FROM  `no_line` WHERE `Company`='$ms'") or die(mysql_error());
	
	if(mysql_num_rows($NoLine)==0){
		$StuAdmNo = "A$NewLine";
	}
	else{		
		$nLine = mysql_fetch_array($NoLine);
		$NewLine = $nLine[0]+1;
		$StuAdmNo = "A$NewLine";		
	}
	*/
	$id=$_REQUEST['id'];
	$rs=odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Enquiry No_]='$id' AND [Company Name]='$ms'") or die(mysql_error());                    
	$cust_no = odbc_result($rs, "System Genrated No_");
	//echo $cust_no;
	//die;
	//print_r("SELECT * FROM [Temp Application] WHERE [Enquiry No_]='$id' AND [Company Name]='$ms'");
	//die;

	$id=$_REQUEST['id'];
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
	$MotherMobile=$_REQUEST['MotherMobile'];
	$FatherMobile=$_REQUEST['FatherMobile'];
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
	$CertiDate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST["CertiDate".$cr])));
	//$fee_Id = $_REQUEST["fee_Id".$f];
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
<h2>Admission<small> - Fees &#38; Discount</small> </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

	<form role="form" method="post" action="AddAdmission.php" name="AdmForm1" onkeypress="return event.keyCode != 13;">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
	
	<input type="hidden" name="id" value="<?php echo $id?>">
	<input type="hidden" name="Pre_AdmNo" value="<?php echo $StuAdmNo?>">
	<input type="hidden" name="NewLine" value="<?php echo $NewLine?>">
	<input type="hidden" name="cust_no" value="<?php echo $cust_no?>">
	
	<input type="hidden" name="EWS" value="<?php echo $EWS?>">
	<input type="hidden" name="HostelAccomodation" value="<?php echo $HostelAccomodation?>">
	<input type="hidden" name="ApplicantRelationship" value="<?php echo $ApplicantRelationship?>">
	<input type="hidden" name="AcadYear" value="<?php echo $AcadYear?>">
	<input type="hidden" name="CommunicationReference" value="<?php echo $CommunicationReference?>">
	<input type="hidden" name="Address1" value="<?php echo $Address1?>">
	<input type="hidden" name="Address2" value="<?php echo $Address2?>">
	<input type="hidden" name="ContactName" value="<?php echo $ContactName?>">
	<input type="hidden" name="AdmissionYear" value="<?php echo $AdmissionYear?>">
	<input type="hidden" name="ApplicationNo" value="<?php echo $ApplicationNo?>">
	<input type="hidden" name="Caste" value="<?php echo $Caste?>">
	<input type="hidden" name="Citizenship" value="<?php echo $Citizenship?>">
	<input type="hidden" name="City" value="<?php echo $City?>">
	<input type="hidden" name="CityCode" value="<?php echo $CityCode?>">
	<input type="hidden" name="CTC" value="<?php echo $CTC?>">
	<input type="hidden" name="Class" value="<?php echo $Class?>">
	<input type="hidden" name="Community" value="<?php echo $Community?>">
	<input type="hidden" name="Country" value="<?php echo $Country?>">
	<input type="hidden" name="CurriculumInterested" value="<?php echo $CurriculumInterested?>">
	<input type="hidden" name="AdmissionDate" value="<?php echo $AdmissionDate?>">
	<input type="hidden" name="DOB" value="<?php echo $DOB?>">
	<input type="hidden" name="Email" value="<?php echo $Email?>">
	<input type="hidden" name="EnquiryNo" value="<?php echo $EnquiryNo?>">
	<input type="hidden" name="RegistrationStatus" value="<?php echo $RegistrationStatus?>">
	<input type="hidden" name="FatherEmail" value="<?php echo $FatherEmail?>">
	<input type="hidden" name="FatherOfficeAddress1" value="<?php echo $FatherOfficeAddress1?>">
	<input type="hidden" name="FatherOfficeAddress2" value="<?php echo $FatherOfficeAddress2?>">
	<input type="hidden" name="FatherOfficeCity" value="<?php echo $FatherOfficeCity?>">
	<input type="hidden" name="FCityCode" value="<?php echo $FCityCode?>">
	<input type="hidden" name="FCTC" value="<?php echo $FCTC?>">
	<input type="hidden" name="FatherOfficeCountry" value="<?php echo $FatherOfficeCountry?>">
	<input type="hidden" name="FatherOfficePostCode" value="<?php echo $FatherOfficePostCode?>">
	<input type="hidden" name="FatherAnnualIncome" value="<?php echo $FatherAnnualIncome?>">
	<input type="hidden" name="FatherName" value="<?php echo $FatherName?>">
	<input type="hidden" name="FatherOccupation" value="<?php echo $FatherOccupation?>">
	<input type="hidden" name="FatherQualification" value="<?php echo $FatherQualification?>">
	<input type="hidden" name="FeeClassification" value="<?php echo $FeeClassification?>">
	<input type="hidden" name="FoodHabits" value="<?php echo $FoodHabits?>">
	<input type="hidden" name="Gender" value="<?php echo $Gender?>">
	<input type="hidden" name="GaurdianAnnualIncome" value="<?php echo $GaurdianAnnualIncome?>">
	<input type="hidden" name="GaurdianName" value="<?php echo $GaurdianName?>">
	<input type="hidden" name="GaurdianOccupation" value="<?php echo $GaurdianOccupation?>">
	<input type="hidden" name="GaurdianOfficeAddress1" value="<?php echo $GaurdianOfficeAddress1?>">
	<input type="hidden" name="GaurdianOfficeAddress2" value="<?php echo $GaurdianOfficeAddress2?>">
	<input type="hidden" name="GaurdianOfficeCity" value="<?php echo $GaurdianOfficeCity?>">
	<input type="hidden" name="GCityCode" value="<?php echo $GCityCode?>">
	<input type="hidden" name="GCTC" value="<?php echo $GCTC?>">
	<input type="hidden" name="GaurdianOfficeCountry" value="<?php echo $GaurdianOfficeCountry?>">
	<input type="hidden" name="GaurdianOfficePostCode" value="<?php echo $GaurdianOfficePostCode?>">
	<input type="hidden" name="GaurdianQualification" value="<?php echo $GaurdianQualification?>">
	<input type="hidden" name="Height" value="<?php echo $Height?>">
	<input type="hidden" name="Language2" value="<?php echo $Language2?>">
	<input type="hidden" name="Language3" value="<?php echo $Language3?>">
	<input type="hidden" name="MediumInstruction" value="<?php echo $MediumInstruction?>">
	<input type="hidden" name="MobileNo" value="<?php echo $MobileNo?>">
	<input type="hidden" name="MotherEmail" value="<?php echo $MotherEmail?>">
	<input type="hidden" name="MotherOfficeAddress1" value="<?php echo $MotherOfficeAddress1?>">
	<input type="hidden" name="MotherOfficeAddress2" value="<?php echo $MotherOfficeAddress2?>">
	<input type="hidden" name="MotherOfficeCity" value="<?php echo $MotherOfficeCity?>">
	<input type="hidden" name="MCityCode" value="<?php echo $MCityCode?>">
	<input type="hidden" name="MCTC" value="<?php echo $MCTC?>">
	<input type="hidden" name="MotherOfficeCountry" value="<?php echo $MotherOfficeCountry?>">
	<input type="hidden" name="MotherOfficePostCode" value="<?php echo $MotherOfficePostCode?>">
	<input type="hidden" name="MotherTongue" value="<?php echo $MotherTongue?>">
	<input type="hidden" name="MotherAnnualIncome" value="<?php echo $MotherAnnualIncome?>">
	<input type="hidden" name="MotherName" value="<?php echo $MotherName?>">
	<input type="hidden" name="MotherOccupation" value="<?php echo $MotherOccupation?>">
	<input type="hidden" name="MotherQualification" value="<?php echo $MotherQualification?>">
	<input type="hidden" name="StudentName" value="<?php echo $StudentName?>">
	<input type="hidden" name="PhoneNo" value="<?php echo $PhoneNo?>">
	<input type="hidden" name="PhysicallyChallenged" value="<?php echo $PhysicallyChallenged?>">
	<input type="hidden" name="PostCode" value="<?php echo $PostCode?>">
	<input type="hidden" name="Quota" value="<?php echo $Quota?>">
	<input type="hidden" name="RegistrationNo" value="<?php echo $RegistrationNo?>">
	<input type="hidden" name="Religion" value="<?php echo $Religion?>">
	<input type="hidden" name="Remarks" value="<?php echo $id?>">
	<input type="hidden" name="Remarks" value="<?php echo $Remarks?>">
	<input type="hidden" name="Section" value="<?php echo $Section?>">
	<input type="hidden" name="StaffChild" value="<?php echo $StaffChild?>">
	<input type="hidden" name="StaffCode" value="<?php echo $StaffCode?>">
	<input type="hidden" name="State" value="<?php echo $State?>">
	<input type="hidden" name="StudentStatus" value="<?php echo $StudentStatus?>">
	<input type="hidden" name="Weight" value="<?php echo $Weight?>">
	<input type="hidden" name="UserLoginID" value="<?php echo $UserLoginID?>">
	<input type="hidden" name="PortalID" value="<?php echo $PortalID?>">
	<input type="hidden" name="Stream" value="<?php echo $Stream?>">
	<input type="hidden" name="TransportRequired" value="<?php echo $TransportRequired?>">
	<input type="hidden" name="TransFee" value="<?php echo $TransFee?>">
	<input type="hidden" name="SlabCode" value="<?php echo $SlabCode?>">
	<input type="hidden" name="TransDist" value="<?php echo $TransDist?>">
	<input type="hidden" name="MotherMobile" value="<?php echo $MotherMobile?>">
	<input type="hidden" name="FatherMobile" value="<?php echo $FatherMobile?>">
	
	<?php for($cr=1; $cr <= $_REQUEST['count']; $cr++){
		if($_REQUEST["CertiCode".$cr] != ""){
	?>
	<input type="hidden" name="CertiCode<?php echo $cr; ?>" value="<?php echo $_REQUEST["CertiCode".$cr]?>">
	<input type="hidden" name="CertiStatus<?php echo $cr; ?>" value="<?php echo $_REQUEST["CertiStatus".$cr]?>">
	<input type="hidden" name="CertiDate<?php echo $cr; ?>" value="<?php echo $_REQUEST["CertiDate".$cr] ?>">
		
	<?php
		$p++;
		}
	} ?>
	<input type="hidden" name="Certi_count" value="<?php echo $p;?>" />
	
 <!---------------------------------- step process-------------------- -->
  <div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        
        <a href="#step-1" type="button" class="btn btn-default btn-circle" disabled="disabled">1</a>
        <p style="font-weight: bold; color:red;">Information</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-primary btn-circle">2</a>
        <p style="font-weight: bold; color:red;">Fee & Discount</p>
      </div>
      
     <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
        <p style="font-weight: bold; color:red;">Confirm</p>
      </div>
      
      </div>
  </div>
  
  
   <!---------------------------------- step process-------------------- -->
  
	
	<ul class="nav nav-tabs" id="StuTab">		
		<li class="active"><a href="#StuTab2" data-toggle="tab"> Fees </a></li>
		<li><a href="#StuTab3" data-toggle="tab"> Discounts </a></li>		       
	</ul>
	
	<div class="tab-content" id="StuTabContent">
				
		<div class="tab-pane face in active" id="StuTab2" >
			<?php require_once("AdmFees.php"); ?>
		</div>
		<div class="tab-pane face in" id="StuTab3">
			<?php require_once("AdmDisc.php"); ?>
		</div>
	</div>
	<?php
		//$formQry = mysql_query("SELECT `SubDate` FROM `tempadmission` WHERE `Company`='$ms' AND `LoginID`='$LoginID' AND `ENQNo`='$id' AND `APPNo`='".odbc_result($rs, 'No_')."'") or die(mysql_error());
		//if(mysql_num_rows($formQry) == 0){	
	?>
	<div>
	<button class="btn btn-primary">Submit</button>
		<!--button class="btn btn-success">Next >> </button-->
		<!--h5><b style="color: red"> Note:</b> Select Fee And Discount and Finaly Click the <B>NEXT</B> Button and Genrate the Invoce</h5-->
	</div>
	
	<!--div style="margin-top:50px;margin-bottom: 1px;"><h5><b style="color: red"> Note:</b> Select Fee And Discount and Finaly Click the <B>NEXT</B> Button and Genrate the Invoce</h5></div-->
	
	<?php
		/*}
		else{
			$fQry = mysql_fetch_array($formQry);
			echo "<strong style='color: #990000'>This application has already registered on ".$fQry[0]."</strong>";
		}*/
	?>
	</form>

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

<?php require_once("../footer.php"); ?>
