  <?php
   require_once("db.txt");
    date_default_timezone_set('Asia/Calcutta');
	$date = odbc_exec($conn, "SELECT * FROM [RegFormToDate] where  [Company Name]= '".$_REQUEST['cid']."' AND [Status]='1' AND [Security]= '".$_REQUEST['sec']."' ") or exit(odbc_errormsg($conn));
    $Today = strtotime(date('Y-m-d H:i:s'));
    $cid = $_REQUEST['cid'];
    // if(!$cid){ header("Location: index.php");}
    //Company details ....
   
    $Comp = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$cid' ") or exit(odbc_errormsg($conn));
    while(odbc_fetch_array($Comp))
    if(odbc_num_rows($Comp) == 0) header("Location: index.php");
   ?>
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
    <script type="text/javascript" charset="utf-8">
    $(function(){
	//$("#datepicker1").datepicker({ minDate: -5, maxDate: 0});
	//$("#initialDate").datepicker({changeYear: true, changeMonth: true,  maxDate: 0,  yearRange: "-2:-1"});
	//$("#initialDate").datepicker({changeYear: true, changeMonth: true,  yearRange: "-3:0"});
	$("#initialDate").datepicker({
		changeYear: true, 
		changeMonth: true,  
		yearRange: '<?php echo (date('Y')-3).":".(date('Y')-2)?>', 
		dateFormat: 'dd/M/yy', 
		defaultDate: '01/Dec/<?php echo date('Y')-3;?>' ,
		numberofMonths: '12',
		minDate: '01/Dec/<?php echo (date('Y')-3); ?>',
		maxDate: '30/Nov/<?php echo (date('Y')-2); ?>'
	});
	$("#datepicker2").datepicker({changeYear: true, changeMonth: true,  yearRange: "<?php echo (date('Y')-50).":".(date('Y')-10)?>", dateFormat: 'dd/M/yy', defaultDate: '01/Nov/1965' });
	$("#datepicker3").datepicker({changeYear: true, changeMonth: true,  yearRange: "<?php echo (date('Y')-50).":".(date('Y')-10)?>", dateFormat: 'dd/M/yy', defaultDate: '01/Nov/1965' });
    });
        // Numeric Validation
    $(document).ready(function() {
        $('.isNumeric').keypress(function (event) {
            return isNumber(event, this)
        });
    }); 
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode != 8 ) &&      // “.” CHECK BACKSPACE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function checkDiff (initialDate) {
            if (initialDate.length == 11){
                
                var mnth;
                var d= new Date();
                var n = d.getFullYear();
                date2 = new Date("06/01/" + (n+1));
                var t = initialDate.split("/");
                
                
                if(t[1] == "Jan" || t[1] == "jan" || t[1] == "JAN") mnth = "01";
                if(t[1] == "Feb" || t[1] == "feb" || t[1] == "FEB") mnth = "02";
                if(t[1] == "Mar" || t[1] == "mar" || t[1] == "MAR") mnth = "03";
                if(t[1] == "Apr" || t[1] == "apl" || t[1] == "APR") mnth = "04";
                if(t[1] == "May" || t[1] == "may" || t[1] == "MAY") mnth = "05";
                if(t[1] == "Jun" || t[1] == "jun" || t[1] == "JUN") mnth = "06";
                if(t[1] == "Jul" || t[1] == "jul" || t[1] == "JUL") mnth = "07";
                if(t[1] == "Aug" || t[1] == "aug" || t[1] == "AUG") mnth = "08";
                if(t[1] == "Sep" || t[1] == "sep" || t[1] == "SEP") mnth = "09";
                if(t[1] == "Oct" || t[1] == "oct" || t[1] == "OCT") mnth = "10";
                if(t[1] == "Nov" || t[1] == "nov" || t[1] == "NOV") mnth = "11";
                if(t[1] == "Dec" || t[1] == "dec" || t[1] == "DEC") mnth = "12";
                
		var custdt = mnth +"/"+t[0]+"/"+t[2];
			alert(custdt);
		var date1 = new Date(custdt); // Date of Birth
                
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));                 
                
                document.myForm.diff.value=Math.round(diffDays/365, 0, 2) +" Years";
                            
            }
        }
    
      // Ajax for City & Country on PIN Code
      var ajax = getHTTPObject();
      function getHTTPObject()
       {
            var xmlhttp;
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            } else if (window.ActiveXObject) {
              // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            } else {
              //alert("Your browser does not support XMLHTTP!");
            }
            return xmlhttp;
       }
      function updateCityState()
          {
            if (ajax)
            {
                    //var zipValue = document.getElementById("postcode").value;
                    var zipValue = document.myForm.PIN.value;

                    if(zipValue)
                    {
                            var url = "get_state.php";
                            var param = "?zip=" + escape(zipValue);

                            ajax.open("GET", url + param, true);
                            ajax.onreadystatechange = handleAjax;
                            ajax.send(null);
                    }
            }
      }
     function handleAjax()
        {
            if (ajax.readyState == 4)
                {
                    citystatearr = ajax.responseText.split(",");

                    var city = document.getElementById('city');
                    var state = document.getElementById('state');

                    city.value = citystatearr[0];
                    state.value = citystatearr[1];
                }
         }

    // End of Get City State

    //Form check
    function validateForm() {
	if( document.myForm.AcadYear.value == "" ){
		//alert( "Please select Academic Year !" );
		document.myForm.AcadYear.focus() ;
		return false;
	}
	if( document.myForm.Sex.value == "" ){
		//alert( "Please provide Gender !" );
		document.myForm.Sex.focus() ;
		return false;
	}
	if( document.myForm.Candidate.value == "" ){
		//alert( "Please provide Candidate's Name !" );
		document.myForm.Candidate.focus() ;
		return false;
	}
	if( document.myForm.Nationality.value == "" ){
		//alert( "Please provide Nationality !" );
		document.myForm.Nationality.focus() ;
		return false;
	}
	if( document.myForm.DOB.value == "" ){
		//alert( "Please provide Candidate's Date of Birth !" );
		document.myForm.DOB.focus() ;
		return false;
	}
	if( document.myForm.Religion.value == "" ){
		//alert( "Please provide Religion !" );
		document.myForm.Religion.focus() ;
		return false;
	}
	if( document.myForm.Caste.value == "" ){
		//alert( "Please provide Caste !" );
		document.myForm.Caste.focus() ;
		return false;
	}
	if( document.myForm.ClassApplied.value == "" ){
		//alert( "Please provide Class to which admission is sought !" );
		document.myForm.ClassApplied.focus() ;
		return false;
	}
	if( document.myForm.MotherName.value == "" && document.myForm.FatherName.value == ""){
		//alert( "Please provide Parent Name !" );
		document.myForm.MotherName.focus() ;
		return false;		
	}
	if( document.myForm.MotherDOB.value == "" && document.myForm.FatherDOB.value == ""){
		//alert( "Please provide Parent Date of Birth !" );
		document.myForm.MotherDOB.focus() ;
		return false;		
	}
	if( document.myForm.MotherEducation.value == "" && document.myForm.FatherEducation.value == ""){
		//alert( "Please provide Parent Educational Qualification !" );
		document.myForm.MotherEducation.focus() ;
		return false;		
	}
	if( document.myForm.MotherMobile.value == "" && document.myForm.FatherMobile.value == ""){
		//alert( "Please provide Parent Mobile No. !" );
		document.myForm.MotherMobile.focus() ;
		return false;		
	}
	if( document.myForm.MotherEmail.value == "" && document.myForm.FatherEmail.value == ""){
		//alert( "Please provide Parent Email address !" );
		document.myForm.MotherEmail.focus() ;
		return false;		
	}
	if(document.myForm.MotherName.value != "" && document.myForm.MotherOccupation.value == ""){
		//alert( "Please provide Mother's Occupation !" );
		document.myForm.MotherOccupation.focus() ;
		return false;
	}
	if(document.myForm.FatherName.value != "" && document.myForm.FatherOccupation.value == ""){
		//alert( "Please provide Father's Occupation !" );
		document.myForm.FatherOccupation.focus() ;
		return false;
	}		
	if( document.myForm.ResidentialAddress.value == ""){
		//alert( "Please provide Residential Address !" );
		document.myForm.ResidentialAddress.focus() ;
		return false;		
	}
	if( document.myForm.PIN.value == ""){
		//alert( "Please specify PIN Code " );
		document.myForm.PIN.focus() ;
		return false;		
	}
	if( document.myForm.City.value == ""){
		//alert( "Please specify City Name " );
		document.myForm.City.focus() ;
		return false;		
	}
	if( document.myForm.State.value == ""){
		//alert( "Please specify State Name " );
		document.myForm.State.focus() ;
		return false;		
	}
	if( document.myForm.ResidentialPhone.value == ""){
		//alert( "Please provide Residential Phone !" );
		document.myForm.ResidentialPhone.focus() ;
		return false;		
	}
	if( document.myForm.EmergencyNo.value == ""){
		//alert( "Please provide Emergency Contact No. !" );
		document.myForm.EmergencyNo.focus() ;
		return false;		
	}
	if( document.myForm.Email.value == ""){
		//alert( "Please provide Email Address !" );
		document.myForm.Email.focus() ;
		return false;		
	}
	if( document.myForm.MaritalStatus.value == ""){
		//alert( "Please provide Marital Status !" );
		document.myForm.MaritalStatus.focus() ;
		return false;		
	}
	if( document.myForm.Distance.value == ""){
		//alert( "Please provide Distance from School to Residence !" );
		document.myForm.Distance.focus() ;
		return false;		
	}
	if( document.myForm.ModeOfTransport.value == ""){
		//alert( "Please provide Mode of Transport !" );
		document.myForm.ModeOfTransport.focus() ;
		return false;		
	}
	if( document.myForm.PhysicallyChallenged.value == "" ){
		document.myForm.PhysicallyChallenged.focus() ;
		return false;		
	}
	if( document.myForm.PhysicallyChallenged.value == "1" &&  document.myForm.PhysicallyRemarks.value == ""){
		//alert( "Please specify child major ailment/allergy " );
		document.myForm.PhysicallyRemarks.focus() ;
		return false;		
	}
	if( document.myForm.Sibling.value == "1" &&  (document.myForm.ChildName1.value == "" || document.myForm.ChildAge1.value == ""  || document.myForm.USN1.value == "" || document.myForm.ChildGender1.value == ""  || document.myForm.ChildClass1.value == "" )){
		//alert( "Please specify Sibling Details " );
		document.myForm.ChildName1.focus() ;
		return false;		
	}
	
	if( document.myForm.MotherEmail.value != ""){
		var emailID = document.myForm.MotherEmail.value;
		atpos = emailID.indexOf("@");
		dotpos = emailID.lastIndexOf(".");

		if (atpos < 1 || ( dotpos - atpos < 2 )) 
		{
			//alert("Please enter correct Mother email ID");
			document.myForm.MotherEmail.focus() ;
			return false;
		}	
		
	}
	if( document.myForm.FatherEmail.value != ""){
		var emailID = document.myForm.FatherEmail.value;
		atpos = emailID.indexOf("@");
		dotpos = emailID.lastIndexOf(".");

		if (atpos < 1 || ( dotpos - atpos < 2 )) 
		{
			//alert("Please enter correct father email ID");
			document.myForm.FatherEmail.focus() ;
			return false;
		}
		
	}
		
	validateEmail();
	
	 return( true );
    }
    
    function validateMotherEmail()
      {
         
         //return( true );
      }
    
    function validateFatherEmail()
      {
         
         //return( true );
      }
    
    function validateEmail()
      {
         var emailID = document.myForm.Email.value;
         atpos = emailID.indexOf("@");
         dotpos = emailID.lastIndexOf(".");
         
         if (atpos < 1 || ( dotpos - atpos < 2 )) 
         {
            alert("Please enter correct email ID");
            document.myForm.Email.focus() ;
            return false;
         }
         return( true );
      }
    </script>

   <div class="container">
   <!-- check date validation -->
   <?php if ($Today >= odbc_result($date, "Start Date") && $Today < odbc_result($date, "End Date")){ ?> 
  
   <form name="myForm" method="POST" action="registration.php" onsubmit="return(validateForm());" onkeypress="return event.keyCode != 13;" enctype="multipart/form-data">
   <table width="100%" align="center" border="0px" cellspacing="0px" cellpadding="5px"  class="table table-responsive borderless"  style="font-family: 'Oxygen', Arial; font-size: 18px;">
    <tr>
        <td height="200px" colspan="6" align='center' style="border-top: 0px;">
            <p style="font-family: 'Poiret One', 'arial'; font-size: 42px; color:#990000; text-transform: uppercase;" class="text-primary" ><?php echo odbc_result($Comp, "Company Name"); ?> </p><input type="hidden" name="cid" value="<?php echo $cid; ?>"><input type="hidden" name="SchoolName" value="<?php echo $Comp['SchoolName']; ?>"><br />
		<?php echo odbc_result($Comp, "Company Name");?>//<?php echo odbc_result($Comp, "Address");?>//<?php echo odbc_result($Comp, "City");?>
		<input type="hidden" name="Address1" value="<?php echo odbc_result($Comp, "City");?>">
		<input type="hidden" name="Address2" value="<?php echo odbc_result($Comp, "City"); ?>">
		<input type="hidden" name="Address3" value="<?php echo odbc_result($Comp, "Company Name"); ?>">
	    </p>
                <p style="font-family: 'Poiret One', 'arial'; font-size: 24px; text-transform: uppercase;">Registration Form</p>
                <p style="font-family: 'Josefin Sans', 'arial'; font-size: 18px; text-transform: uppercase;">Academic Session 
		<?php
			$val = "".(date('Y')+1)."-".(date('y')+2);
		?>
                    <select name='AcadYear' style="padding: 5px;" id='input'> 
                        <?php
                            for($x=1; $x<=1; $x++) {
				$ts = (date('Y')+$x)."-".((date('y')+1)+$x);
                                echo "<option value='".(date('Y')+$x)."-".((date('y')+1)+$x)."'";                                
                                if($ts == $val) echo " selected ";
                                
                                echo ">".(date('Y')+$x)."-".((date('y')+1)+$x)."</option>";
                          }?>
                    </select>
                </p>
        </td>
        </tr> 
        <tr>
        <td colspan="6" style="border: 1px solid #d3d3d3;">
            <p style='color: #990000;'>
                Parents are requested to note:
                <ul>
                    <li align="justify">This is not an Admission Form, nor does the submission of this form entitle any child automatic admission to the school.</li>
                    <li align="justify">Any pressure or recommendation that is brought to bear on the school authorities will automatically disqualify this application.</li>
                </ul>
		<p align='justify' style="color: #990000;"><sup style="color: #990000; font-weight: bold">*</sup> Mandatory Fields</p>
            </p>
        </td>
        <td align="center" style="border-top: 0px; height: 50px">
            &nbsp;
        </td>
        </tr>
        <tr>
	        <td colspan="2"  style="border-top: 0px; height: 80px;" valign="bottom">Staff Child
			<select name="Staff" style="padding: 4px; width: 140px;" class="input">
				<option value=""></option>
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
		</td>
        <td></td> 
        <td style="border-top: 0px;" colspan="2" align="right">
            Gender <sup style="color: #990000; font-weight: bold">*</sup> :   
		<select name="Sex" style="padding: 4px" class="input">
			<option value=""></option>
			<option value="1"> Male</option>
			<option value="2"> Female</option>
		</select>
        </td>
        </tr>
 
        <tr>
        <td>1</td>
        <td>Name of the Child (as per Birth Certificate) <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Candidate" class="form-control input" onkeyup="document.getElementById('CanName').value = this.value();" placeholder="[First Name] [Middle Name] [Last Name]" /></td>
        </tr>
    
        <tr>
        <td>2</td>
        <td>Nationality <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Nationality" class="form-control input" /></td>
        </tr>
        <tr>
        <td>3</td>
        <td>a. Date of Birth <sup style="color: #990000; font-weight: bold">*</sup> <small>(between 1/12/<?php echo date('Y')-3?> to 30/11/<?php echo date('Y')-2?>)</small></td>
        <td>
		<input type="text" name="DOB" id="initialDate" onchange="checkDiff(this.value); if(this.value==''){document.myForm.Age.value='';}" maxlength="11" class="form-control input" style="width: 90%" />
	    </td>
        <td>b. Age as on June 01, <?php echo date('Y')+1?></td>
        <td><input type="text" name="Age" id="diff" readonly="true" class="form-control input" /></td>        
        </tr>
        <tr>
		<td>4</td>
		<td>Mother Tongue</td>
		<td><input type="text" name="MotherTongue" maxlength="11" class="form-control input" /></td>
	    </tr>
	    <tr>
		<td>5</td>
		<td>Religion <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td><input type="text"  name="Religion" maxlength="11" class="form-control input" /></td>
		<td>Caste <sup style="color: #990000; font-weight: bold">*</sup></td>
		<td>
			<select name="Caste" class="form-control input" style="padding: 4px; width: 140px;">
				<option value=""></option>
				<option value="GENERAL">GENERAL</option>
				<option value="ST">ST</option>
				<option value="SC">SC</option>
				<option value="OBC">OBC</option>
			</select>
		</td>
	    </tr>
	    <tr>
        <td>6</td>
        <td colspan="2">a. Class to which admission is sought: <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="2">
		<!--input type="text" name="ClassApplied" class="form-control input" id="input" value="PRE-NURSERY" readonly-->
		     <select style="background-color: #ffff;" class="form-control" name="ClassApplied" id="input" required >
              <option value=""></option>
               <?php
                 $StuClass=odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='$cid' ORDER BY [Sequence]");
                 while(odbc_fetch_array($StuClass)){
                 ?>
                 <option value="<?php echo odbc_result($StuClass, 'Code')?>"><?php echo odbc_result($StuClass, 'Code')?></option>
                 <?php
                 }
                 ?>
              </select>
       
	    </td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">b. School last attended (if any) :</td>
        <td colspan="2"><input type="text" name="LastSchool" class="form-control input" /></td>
        </tr>
        <tr>
        <td>7</td>
        <td colspan="2" style="font-weight: bold;">Parent Information: </td>
        <td style="font-weight: bold;background-color: #f3f3f3;text-align: center;">Mother</td>
        <td style="font-weight: bold;text-align: center;">Father</td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Name <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherName" class="form-control input" /></td>
        <td><input type="text" name="FatherName" class="form-control input" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Date of Birth <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="text" id="datepicker2" name="MotherDOB" class="form-control input" maxlength="11" /></td>
        <td><input type="text" name="FatherDOB" id="datepicker3" class="form-control input" maxlength="11" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Education <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherEducation" class="form-control input" maxlength="45" /></td>
        <td><input type="text" name="FatherEducation" class="form-control input" maxlength="45" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Mobile No. <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherMobile" class="form-control input isNumeric" maxlength="10" onblur="if(this.value.length < 10){alert('Mobile number must be 10 digits.'); this.focu();}" /></td>
        <td><input type="text" name="FatherMobile" class="form-control input isNumeric" maxlength="10" onblur="if(this.value.length < 10){alert('Mobile number must be 10 digits.'); this.focu();}" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Email <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="email" name="MotherEmail" class="form-control input" onblur="validateMotherEmail()" maxlength="80" style="text-transform: lowercase" /></td>
        <td><input type="text" name="FatherEmail" class="form-control input " maxlength="80" onblur="validateFatherEmail()" style="text-transform: lowercase" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="4"><b>Please specify the following (if applicable): </b></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Occupation <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherOccupation" class="form-control input" maxlength="30" /></td>
        <td><input type="text" name="FatherOccupation" class="form-control input" maxlength="30" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Designation</td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherDesignation" class="form-control input" maxlength="30" /></td>
        <td><input type="text" name="FatherDesignation" class="form-control input" maxlength="30" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Name of the Organization</td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherOrganization" class="form-control input" maxlength="45" /></td>
        <td><input type="text" name="FatherOrganization" class="form-control input" maxlength="45" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Office Address</td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherOfficeAddress" class="form-control input" maxlength="45" /></td>
        <td><input type="text" name="FatherOfficeAddress" class="form-control input" maxlength="45" /></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2">Annual Income (in Lacs)</td>
        <td style="background-color: #f3f3f3;"><input type="text" name="MotherIncome" class="form-control input isNumeric" maxlength="4" /></td>
        <td><input type="text" name="FatherIncome" class="form-control input isNumeric" maxlength="4" /></td>
        </tr>
        <tr>
        <td>8</td>
        <td>Residential Address <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="ResidentialAddress" class="form-control input" title="House No., Plot Not, Locality, Street ..." /></td>
        </tr>
        <tr>
        <td colspan="2"></td>
        <td><input type="text" Name="PIN" maxlength="6" class="form-control isNumeric input" placeholder="PIN Code" title="PIN Code" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" id="postcode" /></td>
        <td><input type="text" Name="City" class="form-control input" placeholder="City" title="City" id="city" /></td>
        <td><input type="text" Name="State" class="form-control input" placeholder="State" title="State" id="state" /></td>
        </tr>
        <tr>
        <td colspan="2"></td>
        <td align="center">PIN Code<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td align="center">City <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td align="center">State <sup style="color: #990000; font-weight: bold">*</sup></td>
        </tr>
        <tr>
        <td>9</td>
        <td>Residential Phone No. (s) <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="ResidentialPhone" class="form-control input isNumeric" onblur="if(this.value.length < 6){alert('Please provide correct number.'); this.focu();}" maxlength="10" /></td>
        </tr>
        <tr>
        <td>10</td>
        <td>a. Emergency Phone No. (s) <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="EmergencyNo" class="form-control input isNumeric" onblur="if(this.value.length < 6){alert('Please provide correct number.'); this.focu();}"  maxlength="10" /></td>
        </tr>
        <tr>
        <td></td>
        <td>b. Email for communication with school for admission <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="Email" name="Email" class="form-control input" onblur="validateEmail()" style="text-transform: lowercase" /></td>
        </tr>
        <tr>
        <td>11</td>
        <td>Marital Status <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3">
		<select name="MaritalStatus" style="padding: 4px; width: 140px;" class="input">
			<option value=""></option>
			<option value="0"> Married</option>
			<option value="1"> Divorced</option>
			<option value="2"> Separated</option>
			<option value="3"> Widowed</option>
		</select>
        </td>
        </tr>
        <tr>
        <td>12</td>
        <td>
            Distance to School from Residence (in KM) <sup style="color: #990000; font-weight: bold">*</sup>
        </td>
	    <td >
		<select name="Distance"  style="padding: 4px; width: 140px;" class="input">
			<option value=''></option>
			<option value='0'>0</option>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			<option value='5'>5</option>
			<option value='6'>6</option>
			<option value='7'>7</option>
		</select>
		<!-- <input type="text" name="Distance" class="form-control input" /> -->
	    </td>
	    <td>
            Mode of Transport <sup style="color: #990000; font-weight: bold">*</sup>
        </td>
	    <td colspan="2">
		<select name="ModeOfTransport" style="padding: 4px;" class="input">
			<option value=""></option>
			<option value="School Bus/Van">School Bus/Van</option>
			<option value="Private arrangement">Private arrangement</option>
		</select>
	    </td>
        </tr>
        <tr>
		<td>13</td>
		<td>
			Does your child have major ailment/allergy? <sup style="color: #990000; font-weight: bold">*</sup>
		</td>    
		<td>
			<select name="PhysicallyChallenged" id="PhysicallyChallenged" style="padding: 4px; width: 140px;" onchange="Physically()" class="input">
				<option value=""></option>
				<option value="1">Yes</option>
				<option value="0" selected>No</option>
			</select>
		</td>
		<td>If "YES", please specify</td>
		<td>
			<input type="text" name="PhysicallyRemarks" id="PhysicallyRemarks" disabled maxlength="45" class="form-control" class="input" />
		</td>
	    </tr>
        <tr>
        <td>14.</td>
        <td>
            a. Sibling in School
        </td>
	    <td>
		<select name="Sibling" id="Sibling" style="padding: 4px; width: 140px;" class="input" onChange="changetextbox();">
			<option value=""></option>
			<option value="1">Yes</option>
			<option value="0">No</option>
		</select>
	    </td>
        </tr>
    
        <tr>
        <td></td>
        <td colspan="4">
            b. If "Yes", then please specify the of sisters and brothers in chronological order (oldest to youngest)
        </td>
        </tr>
        <tr>
        <td></td>
        <td colspan="4">
        <table width="100%" align="center" border="0" cellspacing="0px" cellpadding="5px"  class="table table-responsive"  style="font-family: 'Oxygen', Arial; font-size: 18px;">
        <tr style="text-align: center; font-weight: bold;">
        <td></td>
        <td>Name</td>
        <td style="background-color: #f3f3f3;">Age</td>
        <td>Gender</td>
        <td style="background-color: #f3f3f3;">School</td>
        <td style="background-color: #f3f3f3;">Class/Sec</td>
        <td>USN</td>
        </tr>
        <tr>
        <td>a</td>
        <td><input type="text" name="ChildName1" id="ChildName1" class="form-control input" disabled /></td>
        <td style="background-color: #f3f3f3;"><input type="text" size="5" name="ChildAge1" id="ChildAge1" disabled class="form-control input isNumeric" onblur="if(this.value < 2 || this.value > 20) {alert('Please enter valid age for sibling in school...'); this.value=''; this.focus();}" /></td>
        <td>
        <select name="ChildGender1" disabled id="ChildGender1" class="form-control" >
         <option value=""></option>
         <option value="1">Male</option>
         <option value="2">Female</option>
        </select>
        </td>
        <td style="background-color: #f3f3f3;"><input type="text" name="ChildSchool1" id="ChildSchool1" disabled class="form-control input" maxlength="45" /></td> 
        <td><input type="text" disabled name="ChildClass1" id="ChildClass1" class="form-control input" /></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="USN1" id="USN1" disabled class="form-control input" /></td>
        </tr>
        <tr>
        <td>b</td>
        <td><input type="text" name="ChildName2" id="ChildName2" disabled class="form-control input" /></td>
        <td style="background-color: #f3f3f3;"><input type="text" size="5" name="ChildAge2" id="ChildAge2" disabled class="form-control input isNumeric" onblur="if(this.value < 2 || this.value > 20) {alert('Please enter valid age for sibling in school...'); this.value=''; this.focus();}" /></td>
        <td><select name="ChildGender2" id="ChildGender2" disabled class="form-control">
            <option value=""></option>
            <option value="1">Male</option>
            <option value="2">Female</option>
            </select></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="ChildSchool2" id="ChildSchool2" disabled class="form-control input" maxlength="45" /></td>
        <td><input type="text" name="ChildClass2" id="ChildClass2" disabled class="form-control input" /></td>
		<td style="background-color: #f3f3f3;"><input type="text" name="USN2" id="USN2" disabled class="form-control input" /></td>
        </tr>
        <tr>
		<td>c</td>
		<td><input type="text" name="ChildName3" id="ChildName3" disabled class="form-control input" /></td>
		<td style="background-color: #f3f3f3;"><input type="text" disabled size="5" name="ChildAge3" id="ChildAge3" class="form-control input isNumeric" onblur="if(this.value < 2 || this.value > 20) {alert('Please enter valid age for sibling in school...'); this.value=''; this.focus();}" /></td>
		<td><select name="ChildGender3" id="ChildGender3" disabled class="form-control">
		    <option value=""></option>
			<option value="1">Male</option>
			<option value="2">Female</option>
			</select></td>
		<td style="background-color: #f3f3f3;"><input type="text" name="ChildSchool3" id="ChildSchool3" disabled class="form-control input" maxlength="45" /></td>
		<td><input type="text" disabled name="ChildClass3" id="ChildClass3" class="form-control input" /></td>
		<td style="background-color: #f3f3f3;"><input type="text" name="USN3" id="USN3" disabled class="form-control input" /></td>
        </tr>
        <tr>
        <td>d</td>
        <td><input type="text" name="ChildName4" id="ChildName4" disabled class="form-control input" /></td>
        <td style="background-color: #f3f3f3;"><input type="text" size="5" name="ChildAge4" id="ChildAge4" disabled class="form-control input isNumeric" onblur="if(this.value < 2 || this.value > 20) {alert('Please enter valid age for sibling in school...'); this.value=''; this.focus();}" /></td>
        <td><select name="ChildGender4" id="ChildGender4" disabled class="form-control">
            <option value=""></option>
            <option value="1">Male</option>
            <option value="2">Female</option>
            </select></td>
        <td style="background-color: #f3f3f3;"><input type="text" name="ChildSchool4" id="ChildSchool4" disabled class="form-control input" maxlength="45" /></td>
        <td><input type="text" disabled name="ChildClass4" id="ChildClass4" class="form-control input" /></td>
		<td style="background-color: #f3f3f3;"><input type="text" name="USN4" id="USN4" disabled class="form-control input" /></td>
        </tr>
        </table>
        </td>
        </tr> 	
        <tr>
        <td>15.</td>
        <td>Photo Upload</td>
	    <td>
		<input type="file" name="fileToUpload" id="fileToUpload">
		</td>
        </tr>
        </table>

        <script type="text/javascript">
           function Physically(){
	       //Physically Challenged
	       if (document.getElementById("PhysicallyChallenged").value === "1") {	
		   document.getElementById("PhysicallyRemarks").removeAttribute("disabled");
	       }
	       else{
		   document.getElementById("PhysicallyRemarks").setAttribute("disabled", "disabled");
	       }
           }
           function changetextbox()
           {	
	       if (document.getElementById("Sibling").value === "0") {		
	       document.getElementById("ChildName1").setAttribute("disabled", "disabled");
	       document.getElementById("ChildName1").value='';
	       document.getElementById("ChildAge1").setAttribute("disabled", "disabled");
	       document.getElementById("ChildAge1").value='';
	       document.getElementById("ChildGender1").setAttribute("disabled", "disabled");
	       document.getElementById("ChildGender1").value='';
	       document.getElementById("ChildSchool1").setAttribute("disabled", "disabled");
	       document.getElementById("ChildSchool1").value='';
	       document.getElementById("ChildClass1").setAttribute("disabled", "disabled");
	       document.getElementById("ChildClass1").value='';
	       document.getElementById("USN1").setAttribute("disabled", "disabled");
	       document.getElementById("USN1").value='';
	
	       document.getElementById("ChildName2").setAttribute("disabled", "disabled");
	       document.getElementById("ChildName2").value='';
	       document.getElementById("ChildAge2").setAttribute("disabled", "disabled");
	       document.getElementById("ChildAge2").value='';
	       document.getElementById("ChildGender2").setAttribute("disabled", "disabled");
	       document.getElementById("ChildGender2").value='';
	       document.getElementById("ChildSchool2").setAttribute("disabled", "disabled");
	       document.getElementById("ChildSchool2").value='';
	       document.getElementById("ChildClass2").setAttribute("disabled", "disabled");
	       document.getElementById("ChildClass2").value='';
	       document.getElementById("USN2").setAttribute("disabled", "disabled");
	       document.getElementById("USN2").value='';
	
	       document.getElementById("ChildName3").setAttribute("disabled", "disabled");
	       document.getElementById("ChildName3").value='';
	       document.getElementById("ChildAge3").setAttribute("disabled", "disabled");
	       document.getElementById("ChildAge3").value='';
	       document.getElementById("ChildGender3").setAttribute("disabled", "disabled");
	       document.getElementById("ChildGender3").value='';
	       document.getElementById("ChildSchool3").setAttribute("disabled", "disabled");
	       document.getElementById("ChildSchool3").value='';
	       document.getElementById("ChildClass3").setAttribute("disabled", "disabled");
	       document.getElementById("ChildClass3").value='';
	       document.getElementById("USN3").setAttribute("disabled", "disabled");
	       document.getElementById("USN3").value='';
	
	       document.getElementById("ChildName4").setAttribute("disabled", "disabled");
	       document.getElementById("ChildName4").value='';
	       document.getElementById("ChildAge4").setAttribute("disabled", "disabled");
	       document.getElementById("ChildAge4").value='';
	       document.getElementById("ChildGender4").setAttribute("disabled", "disabled");
	       document.getElementById("ChildGender4").value='';
	       document.getElementById("ChildSchool4").setAttribute("disabled", "disabled");
	       document.getElementById("ChildSchool4").value='';
	       document.getElementById("ChildClass4").setAttribute("disabled", "disabled");
	       document.getElementById("ChildClass4").value='';
	       document.getElementById("USN4").setAttribute("disabled", "disabled");
	       document.getElementById("USN4").value='';
	
	       } else {
		
	       document.getElementById("ChildName1").removeAttribute("disabled");
	       document.getElementById("ChildAge1").removeAttribute("disabled");
	       document.getElementById("ChildGender1").removeAttribute("disabled");
	       document.getElementById("ChildSchool1").removeAttribute("disabled");
	       document.getElementById("ChildClass1").removeAttribute("disabled");
	       document.getElementById("USN1").removeAttribute("disabled");
	
	       document.getElementById("ChildName2").removeAttribute("disabled");
	       document.getElementById("ChildAge2").removeAttribute("disabled");
	       document.getElementById("ChildGender2").removeAttribute("disabled");
	       document.getElementById("ChildSchool2").removeAttribute("disabled");
	       document.getElementById("ChildClass2").removeAttribute("disabled");
	       document.getElementById("USN2").removeAttribute("disabled");
	
	       document.getElementById("ChildName3").removeAttribute("disabled");
	       document.getElementById("ChildAge3").removeAttribute("disabled");
	       document.getElementById("ChildGender3").removeAttribute("disabled");
	       document.getElementById("ChildSchool3").removeAttribute("disabled");
	       document.getElementById("ChildClass3").removeAttribute("disabled");
	       document.getElementById("USN3").removeAttribute("disabled");
	
	       document.getElementById("ChildName4").removeAttribute("disabled");
	       document.getElementById("ChildAge4").removeAttribute("disabled");
	       document.getElementById("ChildGender4").removeAttribute("disabled");
	       document.getElementById("ChildSchool4").removeAttribute("disabled");
	       document.getElementById("ChildClass4").removeAttribute("disabled");
	       document.getElementById("USN4").removeAttribute("disabled");
	       }
           }
         </script>
        <!--?php
        
        $questionsCheck = odbc_exec("SELECT COUNT(`id`) FROM `SchRegQues` WHERE `SchoolID`='$cid' AND `Status`=1");
        $qc = odbc_fetch_array($questionsCheck);
        
        if($qc[0] > 0){
        ?>
        <table class="table table-responsive" style="font-family: 'Oxygen', Arial; font-size: 18px;">
            <tr>
                <td colspan="3">
                    <h3 class="text-primary">We would appreciate it, if you answer these questions in your own words. </h3>
                </td>
            </tr>
            <--?php
                $question = odbc_exec("SELECT `Question`, `id` FROM `SchRegQues` WHERE `Status`=1 AND `SchoolID`='$cid' ORDER BY `id`") or die(odbc_error());
                $i=0;
                while($ques = odbc_fetch_array($question)){
            ?>
            <tr>
                <td><--?php echo ($i+1); ?></td>
                <td colspan="2"><--?php echo $ques[0];?> <input type="hidden" name="QuesID<--?php echo $i;?>" value="<?php echo $ques[1]; ?>">
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="Reply<--?php echo $i?>" style="resize: none;color: #000;font-family: 'Poiret One',arial; font-size: 18px;" id="input"></textarea>
                </td>
            </tr>
            <--?php
                    $i += 1;
                }
                
                $count = $i;
            ?>
            <input type="hidden" value="<--?php echo $count?>" name="count">
        </table>        
      <--?php
        }
      ?-->
	 <p align="justify">
	 <input type="checkbox" id="checkme" style="padding: 4px;" /> This is to certify that the facts given by me on the registration form are true. 
		I understand that if any part of it is found to be false, this registration will be cancelled.
	 <br />
	 <input type="submit" class='btn btn-primary' id='Review' value='Submit' disabled="true">
	 </p>
     </form>
   <?php }
       ?> <!-- else {
		    <div class="alert alert-danger">
		    <strong>Danger!</strong> form submission expired.</div> 
		    <--?php }?></div> -->
		    
    
    <script type='text/javascript'>//<![CDATA[
	window.onload=function(){
	var checker = document.getElementById('checkme');
	var sendbtn = document.getElementById('Review');
	checker.onclick = function() {
	  sendbtn.disabled = !this.checked;
	  //sendbtn.disabled = false;
	};
	}//]]> 
    </script>
  <?php require 'SetupRight.php'?>
