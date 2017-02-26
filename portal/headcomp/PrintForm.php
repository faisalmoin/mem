  <?php
  // echo urlencode ($cid);
  //echo crypt(str,$cid) ;
  
   date_default_timezone_set('Asia/Calcutta');    
  //  $count = isset($_REQUEST['count']);
	$cid = $_REQUEST['cid'];
	$RegNo = $_REQUEST['RegNo'];
	$sec=$_REQUEST['No'];
	//exit("CID: $cid // Reg No. - $RegNo");
    //if($cid){ header("Location: index.php");}
    require_once("../db.txt");
	
	//Company details ....
	$Company = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$cid' ") or exit(odbc_errormsg($conn));
	$Comp = odbc_fetch_array($Company);
	//while(odbc_fetch_array($Comp))

   // $regForm = odbc_exec($conn, "SELECT * FROM [Temp Enquiry] WHERE [No_]='".$RegNo."' AND [Company Name]='$cid' ") or exit(odbc_errormsg($conn));
   $regForm = odbc_exec($conn, "SELECT * FROM [Temp Enquiry] WHERE [No_]='".$RegNo."' AND [Company Name]='$cid' AND [SessionId]= '".$sec."' ") or exit(odbc_errormsg($conn));
   // md5(62724RN6160602915/Jun/2016 12:49:34)
    if(odbc_num_rows($regForm)==0) header ("Location: Company.php?cid=$cid");
    $rf = odbc_fetch_array($regForm);
  
    ?>
    <html lang="en">
    <head>
    <title>Print Registration Form</title>
    <link href='http://fonts.googleapis.com/css?family=Poiret+One|Oxygen|Josefin+Sans:400,400italic,300italic,300,600' rel='stylesheet' type='text/css'>
    <link href="../bs/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.min.js"></script>
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="../bs/js/jquery-ui.js"></script>
  	<link rel="stylesheet" href="/resources/demos/style.css">
	<script>
  	 $(function() {
    	$( "#datepicker" ).datepicker();
  		});
  	</script>
    </head>
    <body>
    <script type="text/javascript">
    <!--
    window.print();
    //-->
    </script>

    <div class="container">
    <form action="CompanyAdd.php" enctype="multipart/form-data" method="POST">
    <table width="100%" align="center" border="0" cellspacing="0px" cellpadding="5px"  class="table table-responsive"  style="font-family: 'Oxygen', Arial; font-size: 12px;">
    <tr>
	   <td colspan="6" align='center' style="border-top: 0px;">
	   <p style="font-family: 'Poiret One', 'arial'; color:#990000; font-size: 30px; text-transform: uppercase;"><?php echo $Comp['Company Name']?></p><input type="hidden" name="cid" value="<?php echo $cid; ?>"><br />
		 <?php echo $Comp['Address1']?><?php echo $Comp['Address2']?><?php echo $Comp['Address3']?>
	   <p style="font-family: 'Poiret One', 'arial'; font-size: 22px; text-transform: uppercase;">Application Form</p>
	   <p style="font-family: 'Josefin Sans', 'arial'; font-size: 18px; text-transform: uppercase;">Academic Session 
	     <?php  echo $rf['AcadYear'];?>
	   </p>
	   </td>
    </tr>
    <tr>
	   <td colspan='3' style="border-top: 0px;">
	   <div style="border: 1px solid #000000; padding: 5px">Registration No. : <span style="font-size: 14px"><b><?php echo $rf['No_']?></b></span></div>
	   </td>
	   <td style="border-top: 0px;"></td>
	   <td style="border-top: 0px;">
	     <?php if($rf['Sibling'] == 1) 
	      echo "&#x2713; <span style='font-weight: bold'>Sibling</span>";
	      else 
	      echo "&nbsp;&nbsp;&nbsp;&nbsp;Sibling"; ?><br />
	      <?php if($rf['Staff'] == 1) echo "&#x2713; <span style='font-weight: bold'>Staff</span>"; else echo "&nbsp;&nbsp;&nbsp;&nbsp;Staff";  ?>
	    </td>
    </tr>
    <tr>
	    <td colspan="4" style="border-top: 0px;">
		<p style="color: #990000; font-size:17px;">
	     Parents are requested to note:
	     <ul style='color: #990000;'>
	       <li align="justify">This is not an Admission Form, nor does the submission of this form entitle any child automatic admission to the school.</li>
	       <li align="justify">Any pressure or recommendation that is brought to bear on the school authorities will automatically disqualify this application.</li>
	     </ul>
	    </p>
		</td>
	    <td align="center" style="border-top: 0px;">
	    <div style="width: 150px; height: 150px; border: 1px solid #000;vertical-align: middle;display: table-cell;"><img src="<?php echo $rf['Picture']?>" style="width: 150px; height: 150px"></div>
	    </td>
    </tr>
    <tr>
	    <td style="border-top: 0px;"></td>
	    <td style="border-top: 0px;"></td>
	    <td style="border-top: 0px;"></td>
	    <td style="border-top: 0px;"></td>
	    <td style="border-top: 0px;" align="center">
	      Gender :   <?php if($rf['Gender'] == 1) echo "<b>&#x2713;&nbsp;&nbsp;Male</b> <span style='text-decoration: line-through;'>Female</span>";?>
	       <?php if($rf['Gender'] == 2) echo "<span style='text-decoration: line-through;'>Male</span> <b>&#x2713;&nbsp;&nbsp;Female</b>";?>
	    </td>
    </tr>
    <tr>
	    <td>1</td>
	    <td>Name of the Child</td>
	    <td colspan="3"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Name']?></span></td>
    </tr>
    <tr>
	    <td>2</td>
	    <td>Nationality</td>
	    <td colspan="3"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Citizenship']; ?></span></td>
    </tr>
    <tr>
	    <td>3</td>
	    <td>a. Date of Birth </td>
	    
	    <td><span style="color: #001C7E; font-weight: bold;"><?php echo date('d/M/Y', strtotime($rf['Date of Birth']))?></span></td>
	    <td>b. Age as of June 01, <?php echo date('Y')+1?></td>
	    <td><span style="font-weight: bold; color: #001C7E;"><?php echo $rf['Age'];?></span></td>        
    </tr>
	    <tr>
		<td>4</td>
		<td>Mother Tongue</td>
		<td colspan="3" style="color: #001C7E;"><b><?php echo $rf['MotherTongue'];?></b></td>
	</tr>
	<tr>
		<td>5</td>
		<td>Religion</td>
		<td style="font-weight: bold;color: #001C7E;"><?php echo $rf['Religion'];?></td>
		<td>Caste</td>
		<td style="font-weight: bold;color: #001C7E;"><?php echo $rf['Caste'];?></td>
	</tr>
    <tr>
	    <td>4</td>
	    <td colspan="2">a. Class to which admission is sought:</td>
	    <td colspan="2"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Class Applied'];?></span></td>
    </tr>
    <tr>
	    <td></td>
	    <td colspan="2">b. School last attended (if any) :</td>
	    <td colspan="2"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Name Of The Previous Institute'];?></span></td>
    </tr>
    <tr>
    <td>5</td>
	    <td colspan="2" style="font-weight: bold;">Parent Information: </td>
	    <td style="font-weight: bold;background-color: #f3f3f3;text-align: center;">Mother</td>
	    <td style="font-weight: bold;text-align: center;">Father</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Name</td>
        <td style="background-color: #f3f3f3;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Mother_s Name'];?></span></td>
        <td><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Father_s Name'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Date of Birth</td>
        <td style="background-color: #f3f3f3;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['MotherDOB'];?></span></td>
        <td><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['FatherDOB'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Education</td>
        <td style="background-color: #f3f3f3;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Mother_s Qualification'];?></span></td>
        <td><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Father_s Qualification'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Mobile No.</td>
        <td style="background-color: #f3f3f3;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Mother Mobile'];?></span></td>
        <td><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Father Mobile'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Email</td>
        <td style="background-color: #f3f3f3; font-weight: bold;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Mother Email'];?></span></td>
        <td style="font-weight: bold;"><span style="font-weight: bold;color: #001C7E;"><?php echo $rf['Father Email'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4"><b>Please specify the following (if applicable): </b></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Occupation</td>
        <td style="background-color: #f3f3f3;"><span style="color: #001C7E;"><?php echo $rf['Mother_s Occupation'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['Father_s Occupation'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Designation</td>
        <td style="background-color: #f3f3f3;"><span style="color: #001C7E;"><?php echo $rf['MotherDesignation'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['FatherDesignation'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Name of the Organization</td>
        <td style="background-color: #f3f3f3;"><span style="color: #001C7E;"><?php echo $rf['MotherOrganization'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['FatherOrganization'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Office Address</td>
        <td style="background-color: #f3f3f3;"><span style="color: #001C7E;"><?php echo $rf['Mother Office Address 1'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['Father Office Address 1'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">Annual Income</td>
        <td style="background-color: #f3f3f3;"><span style="color: #001C7E;"><?php echo number_format($rf['Mother_s Annual Income'],0,'.',',')."Lac";?></span></td>
        <td><span style="color: #001C7E;"><?php echo number_format($rf['Father_s Annual Income'],0,'.',',')."Lac";?></span></td>
    </tr>
    <tr>
        <td>6</td>
        <td>Residential Address</td>
        <td colspan="3"><span style="color: #001C7E;"><?php echo $rf['ResidentialAddress'];?></span></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td><span style="color: #001C7E;"><?php echo $rf['City'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['State'];?></span></td>
        <td><span style="color: #001C7E;"><?php echo $rf['Post Code'];?></span></td>
    </tr>
    <tr>
        <td>7</td>
        <td>Residential Phone No. (s)</td>
        <td colspan="3"><span style="color: #001C7E;"><?php echo $rf['Mobile Number'];?></span></td>
    </tr>
    <tr>
        <td>8</td>
        <td>a. Emergency Phone No. (s)</td>
        <td colspan="3"><span style="color: #001C7E;"><?php echo $rf['Phone Number'];?></span></td>
    </tr>
    <tr>
        <td></td>
        <td>b. Email</td>
        <td colspan="3"><span style="color: #001C7E;"><?php echo $rf['E-Mail Address'];?></span></td>
    </tr>
    <tr>
        <td>9</td>
        <td>Marital Status</td>
        <td colspan="3"><span style="color: #001C7E;">
            <?php
                if($rf['MaritalStatus'] == 0) echo "Married";
                if($rf['MaritalStatus'] == 1) echo "Divorced";
                if($rf['MaritalStatus'] == 2) echo "Separated";
                if($rf['MaritalStatus'] == 3) echo "Widowed";
            ?></span>
        </td>
    </tr>
    <tr>
        <td>12</td>
        <td>
            Distance to School from Residence (in KM) 
        </td>
	<td ><span style="color: #001C7E;"><?php echo $rf['Distance'];?></span></td>
	<td>
            Mode of Transport <sup style="color: #990000; font-weight: bold">*</sup>
        </td>
	<td colspan="2"><span style="color: #001C7E;"><?php echo $rf['TransportMode'];?></span></td>
    </tr>
	<tr>
		<td>13</td>
		<td>
			Does your child have major ailment/allergy?
		</td>    
		<td><span style="color: #001C7E;">
			<?php if($rf['Physically Challenged'] == 1) echo "Yes";?>
			<?php if($rf['Physically Challenged'] == 0) echo "No";?>
		</span></td>
		<td>If "YES", please specify</td>
		<td>
			<span style="color: #001C7E;"><?php echo $rf['Physically Remarks'];?></span>
		</td>
	</tr>
    <tr>
        <td>10</td>
        <td colspan="4">
            Details of sisters and brothers in chronological order including the applicant (oldest to youngest)
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4">
            <table width="100%" align="center" border="0" cellspacing="0px" cellpadding="5px"  class="table table-responsive"  style="font-family: 'Oxygen', Arial; font-size: 14px;">
                <tr style="text-align: center; font-weight: bold;">
                    <td></td>
                    <td>Name</td>
                    <td style="background-color: #f3f3f3;">Age</td>
                    <td>Gender</td>
                    <td style="background-color: #f3f3f3;">School</td>
                    <td>Class/Sec</td>
                    <td style="background-color: #f3f3f3;">USN</td>
                </tr>
                <tr>
                    <td>a</td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildName1'];?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildAge1'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php if($rf['ChildGender1']=='2') echo 'Female'; if($rf['ChildGender1']=='1') echo 'Male';?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildSchool1'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildClass1'];?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['USN1'];?></span></td>
                </tr>
                <tr>
                    <td>b</td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildName2'];?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildAge2'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php if($rf['ChildGender2']=='2') echo 'Female'; if($rf['ChildGender2']=='1') echo 'Male';?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildSchool2'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildClass2'];?></span></td>
		            <td style="text-align: center;background-color: #f3f3f3;"><span style=" bold;color: #001C7E;"><?php echo $rf['USN2'];?></span></td>
                </tr>
                <tr>
                    <td>c</td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildName3'];?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildAge3'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php if($rf['ChildGender3']=='2') echo 'Female'; if($rf['ChildGender3']=='1') echo 'Male';?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildSchool3'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildClass3'];?></span></td>
		            <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['USN3'];?></span></td>
                </tr>
                <tr>
                    <td>d</td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildName4'];?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildAge4'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php if($rf['ChildGender4']=='2') echo 'Female'; if($rf['ChildGender4']=='1') echo 'Male';?></span></td>
                    <td style="background-color: #f3f3f3;text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildSchool4'];?></span></td>
                    <td style="text-align: center;"><span style=" bold;color: #001C7E;"><?php echo $rf['ChildClass4'];?></span></td>
		            <td style="text-align: center;background-color: #f3f3f3;"><span style=" bold;color: #001C7E;"><?php echo $rf['USN4'];?></span></td>
                </tr>
            </table>
         </td>
         </tr>
         <tr>
	         <td colspan="5" height="80px" style="border-top: 0px;">
	            <p align="justify">I, the parent (father/mother) /guardian of <b><?php echo $rf['Candidate']?></b> seeking his / her admission to <?php echo $rf['ClassApplied']?> hereby solemnly declare that the information furnished above is absolutely true and that if found factually incorrect at any time after the admission or during his / her stay in school, I shall abide by the orders of the school for withdrawal of my son/daughter/ward without any plea or protest. I also understand and accept that submission of online registration form and track sheet does not guarantee admission.
	          </p>
	          </td>
         </tr>
         <tr>
	         <td colspan="3" height="50px" style="border-bottom: 1px solid #000;border-top: 0px;">
	            Date: <span style="color: #054185;font-weight: bold;"><?php echo $rf['Enquiry Date']?></span> <input type="hidden" value="<?php echo date('d/M/Y H:i:s')?>" name="AppDate" />
	         </td>
	         <td colspan="2" height="50px" align="center" style="border-bottom: 1px solid #000;border-top: 0px;">
		     <br /><br />
	            <p style="border-top: 1px solid #000;" align="center">Signature of Mother/Father/Guardian</p>
	         </td>
         </tr>
         <tr>
	         <td colspan="5" height="220px">
	         <br />
	         <p>Please note the following: </p>
	         <ol>
	         <li>This form must be accompanied by:</li>
	         <ol>
	            <li>One photocopy of the Birth Certificate and original Birth Certificate for verification.</li>
	            <li>One recent passport size photograph of the child pasted in the space provided.</li>
	            <li><b>Proof of Residence</b> - A Photocopy of the Electoral Card / Passport / Aadhar Card / Ration Card / Telephone Bill / Lease Agreement.</li>
			    <li>Community Certificate, if applicable</li>
			    <li>An amount of <b>Rs. 300/-</b> must be paid towards processing fee at the time of submission of filled in forms.
			    This must be presented as DD favouring <b><?php echo $Comp['Company Name']?></b>.</li>
	         </ol>
	             <li>Please do not attach any other annexures.</li>
	             <li>Parents must accompany the child for the meeting with the Principal and Staff.</li>
	             <li>Forms with False/Incomplete/Vague information will not be considered.</li>
	         </ol>
	         <br /><br /><br />
	         </td>
         </tr>
         </table>
         <!--span style="page-break-after: always;"></span>
         <--?php
        
         $questionsCheck = mysql_query("SELECT COUNT(`id`) FROM `SchRegQues` WHERE `SchoolID`='$cid' AND `Status`=1");
         $qc = mysql_fetch_array($questionsCheck);
        
         if($qc[0] > 0){
         ?>

         <!--table class="table table-responsive" style="font-family: 'Oxygen', Arial; font-size: 12px;">
            <tr>
                <td colspan='2' style="border-top: 0px;">R.No.: <span><--?php echo $RegNo?></span>
            </tr>
            <tr>
                <td colspan="3" align="center" style="border-top: 0px;"><p style="font-family: 'Poiret One', 'arial'; font-size: 30px; text-transform: uppercase;"><!--?php echo $Comp['Name']?></p></td>
            </tr>
            <tr>
                <td style="border-top: 0px;"></td>
                <td style="border-top: 0px;">Name of the Child / Ward</td>
                <td width="70%" style="border-bottom: 1px solid #000;border-top: 0px;"><span><--?php echo $Candidate;?></span></td>
            </tr>
            <tr>
                <td></td>
                <td>Address</td>
                <td width="70%" style="border-bottom: 1px solid #000;"><span><--?php echo "$ResidentialAddress <br />$City $State $PIN"; ?></span></td>
            </tr>
            <tr>
                <td></td>
                <td>Class to which admission is being sought</td>
                <td width="70%" style="border-bottom: 1px solid #000;"><span><--?php echo $ClassApplied?></span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3 style="font-size: 14px">We would appreciate it, if you answer these questions in your own words. </h3>
                </td>
            </tr>
            <--?php                
                $question = mysql_query("SELECT `Question`, `id` FROM `SchRegQues` WHERE `Status`=1 AND `SchoolID`='$cid' ORDER BY `id`") or die(mysql_error());
                $i=1;
                while($ques = mysql_fetch_array($question)){
            ?>
            <tr>
                <td><--?php echo $i; ?></td>
                <td colspan="2"><--?php echo $ques[0];?> <input type="hidden" name="QuesID<--?php echo $i;?>" value="<?php echo $ques[1]; ?>">
            </tr>
            <tr>
                <td></td>
                <td colspan="2" height="50px">
                    <--?php
                        $reply = mysql_query("SELECT `Reply` FROM `SchRegReply` WHERE `RegNo`='$RegNo' AND `SchoolID`='$cid' AND `QuesID`='".$ques[1]."'") or die(mysql_errno());
                        $rpl = mysql_fetch_array($reply);
                        echo "<span>".$rpl[0]."</span>";
                    ?>
                </td>
            </tr>
            <--?php
                    $i += 1;
                }
                
                $count = $i;
            ?>
            <input type="hidden" value="<--?php echo $count?>" name="count">
        </table>        
        <!?php
        }
        ?-->  
        <div media="noPrint" class="noprint">
        <input type="button" class='btn btn-primary noPrint' value='Print' onclick="window.print();">
        </div>
        </form>
        </div>
   <?php require 'footer.php';?>
