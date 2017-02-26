<?php
	require_once("header.php");
	$_SESSION['token'] = md5(session_id() . time());
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
<!---------------------------------- step process-------------------- -->
<?php	
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
	
?>

<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
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
<h2>Admission </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

<div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
            <p style="font-weight: bold; color:red;">Information</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p style="font-weight: bold; color:red;">Fee & Discount</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
            <p style="font-weight: bold; color:red;">Confirm</p>
        </div>
    </div>
</div>
  
  
   <!---------------------------------- step process-------------------- -->
  

	
    <form role="form" method="post" action="NewFeedicount.php" name="AdmForm" onsubmit="return(validate());" onkeypress="return event.keyCode != 13;">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
        <input type="hidden" name="id" value="<?php echo $id?>">
	<input type="hidden" name="Pre_AdmNo" value="<?php echo $StuAdmNo?>">
	<input type="hidden" name="NewLine" value="<?php echo $NewLine?>">
	<ul class="nav nav-tabs" id="StuTab">
		<li class="active"><a href="#StuTab1" data-toggle="tab">General</a></li>
		<li><a href="#StuTab2" data-toggle="tab">Communication</a></li>
		<li><a href="#StuTab3" data-toggle="tab">Personal</a></li>
		<li><a href="#StuTab4" data-toggle="tab">Other Details</a></li>
		<li><a href="#StuTab5" data-toggle="tab">Parent Info</a></li>
		<li><a href="#StuTab6" data-toggle="tab">Gaurdian Info</a></li>
		<li><a href="#StuTab7" data-toggle="tab">Certificate</a></li>
		       
	</ul>
	
	<div class="tab-content" id="StuTabContent">
		<div class="tab-pane face in active" id="StuTab1">
			<?php require_once("AdmissionGeneral.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab2">
			<?php require_once("AdmissionCommunication.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab3">
			<?php require_once("AdmissionPersonal.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab4">
			<?php require_once("AdmissionOther.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab5">
			<?php require_once("AdmissionParent.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab6">
			<?php require_once("AdmissionGaurdian.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab7">
			<?php require_once("AdmissionDocuments.php"); ?>
		</div>		
		
	</div>
	
	<div>
	   
		<button class="btn btn-primary">Next >> </button>
		<P></P>
		</div>
		
	</div>
	
	</form>



<!-- /Content -->

</div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
<!-- /Body -->

<script type="text/javascript">
function validate()
      {
      
         if( document.AdmForm.RegistrationNo.value == "" )
         {
            alert( "Please provide Application No.!" );
            document.AdmForm.RegistrationNo.focus() ;
            return false;
         }
         
         if( document.AdmForm.AdmissionDate.value == "" )
         {
            alert( "Please provide Admission Date!" );
            document.AdmForm.AdmissionDate.focus() ;
            return false;
         }
         
         if( document.AdmForm.StudentName.value == "" )
         {
            alert( "Please provide Candidate Name!" );
            document.AdmForm.StudentName.focus() ;
            return false;
         }
         
         if( document.AdmForm.Gender.value == "" )
         {
            alert( "Please provide Candidate Gender!" );
            document.AdmForm.Gender.focus() ;
            return false;
         }
         
         if( document.AdmForm.RegistrationStatus.value == "" )
         {
            alert( "Registration Status cannot be blank!" );
            document.AdmForm.RegistrationStatus.focus() ;
            return false;
         }
         
         if( document.AdmForm.DOB.value == "" )
         {
            alert( "Candidate Date of Birth cannot be blank!" );
            document.AdmForm.DOB.focus() ;
            return false;
         }
         
         if( document.AdmForm.RegistrationFormNo.value == "" )
         {
            alert( "Please provide Registration Form No. !" );
            document.AdmForm.RegistrationFormNo.focus() ;
            return false;
         }
         
         if( document.AdmForm.MediumInstruction.value == "" )
         {
            alert( "Please provide Medium of Instruction !" );
            document.AdmForm.MediumInstruction.focus() ;
            return false;
         }
         
         if( document.AdmForm.AdmissionYear.value == "" )
         {
            alert( "Please provide Academic Year !" );
            document.AdmForm.AdmissionYear.focus() ;
            return false;
         }
         
         if( document.AdmForm.Class.value == "" )
         {
            alert( "Please Select Class !" );
            document.AdmForm.Class.focus() ;
            return false;
         }
         
         if( document.AdmForm.Section.value == "" )
         {
            alert( "Please Select Section !" );
            document.AdmForm.Section.focus() ;
            return false;
         }
         
         if( document.AdmForm.CurriculumInterested.value == "" )
         {
            alert( "Please select Curriculum Interested !" );
            document.AdmForm.CurriculumInterested.focus() ;
            return false;
         }
         
         if( document.AdmForm.FeeClassification.value == "" )
         {
            alert( "Please provide Fee Classification !" );
            document.AdmForm.FeeClassification.focus() ;
            return false;
         }
         
         if( document.AdmForm.CommunicationReference.value == "" )
         {
            alert( "Please provide Communication Reference/Address To: !" );
            document.AdmForm.CommunicationReference.focus() ;
            return false;
         }
         
         if( document.AdmForm.ContactName.value == "" )
         {
            alert( "Please provide Adressee's Name !" );
            document.AdmForm.ContactName.focus() ;
            return false;
         }
         
         if( document.AdmForm.Address1.value == "" )
         {
            alert( "Please provide Adressee's Address1 !" );
            document.AdmForm.Address1.focus() ;
            return false;
         }
         
         if( document.AdmForm.City.value == "" )
         {
            alert( "Please provide Adressee's City !" );
            document.AdmForm.City.focus() ;
            return false;
         }
         
         if( document.AdmForm.PostCode.value == "" )
         {
            alert( "Please provide Adressee's Post Code !" );
            document.AdmForm.PostCode.focus() ;
            return false;
         }
         
         if( document.AdmForm.State.value == "" )
         {
            alert( "Please provide Adressee's State !" );
            document.AdmForm.State.focus() ;
            return false;
         }
         
         if( document.AdmForm.Country.value == "" )
         {
            alert( "Please provide Adressee's Country !" );
            document.AdmForm.Country.focus() ;
            return false;
         }
         
         if( document.AdmForm.MobileNo.value == "" )
         {
            alert( "Please provide Adressee's Mobile/Contact No. !" );
            document.AdmForm.MobileNo.focus() ;
            return false;
         }
         
         if( document.AdmForm.FatherName.value == "" )
         {
            alert( "Please provide Candidate's Father Name !" );
            document.AdmForm.FatherName.focus() ;
            return false;
         }
         
         if( document.AdmForm.FatherOccupation.value == "" )
         {
            alert( "Please provide Candidate's Father Occupation !" );
            document.AdmForm.FatherOccupation.focus() ;
            return false;
         }
         
         if( document.AdmForm.MotherName.value == "" )
         {
            alert( "Please provide Candidate's Mother Name !" );
            document.AdmForm.MotherName.focus() ;
            return false;
         }
         
         if( document.AdmForm.MotherOccupation.value == "" )
         {
            alert( "Please provide Candidate's Mother Occupation !" );
            document.AdmForm.MotherOccupation.focus() ;
            return false;
         }
         
         return( true );
      }

</script>



<?php require_once("../footer.php"); ?>
