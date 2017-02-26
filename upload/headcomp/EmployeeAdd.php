<?php
	require_once("SetupLeft.php");
                $ms= $_REQUEST['companyname'];
        	$EmpNo = $_REQUEST['companyname'];

		$qryEnq1 = odbc_exec($conn, "SELECT COUNT([No_])+1 FROM [Employee]") or die(odbc_errormsg());
		$EmpNo=$EmpNo.  str_pad(odbc_result($qryEnq1, ""), 8, '0', STR_PAD_LEFT);

		$ChkEnq = odbc_exec($conn, "SELECT MAX([No_]) FROM [Employee] WHERE [No_]='$EmpNo' AND [Company Name]='$ms'") or die(odbc_errormsg());
		
                $a = substr(odbc_result($ChkEnq, "No_"),3 )+1;    
		if(odbc_result($ChkEnq, "No_") == 0){
		if($EmpNo == ""){
		    $EmpNo = $EmpNo.str_pad("1", 7, '0', STR_PAD_LEFT);
		}
		else{
		    $EmpNo = $EmpNo;
		}
		}
		else{
		$EmpNo = $EmpNo.str_pad($a, 7, '0', STR_PAD_LEFT);
		}
              //  echo $EmpNo;
        
        if($_REQUEST['B_ED'] == ""){
			$B_ED = 0;
		}
		else{
			$B_ED = 1;
		}
//$total = count($_FILES['fileToUpload']['name']);
      /*for($i=0; $i < count($_FILES['fileToUpload']['name']); $i++) {
	//Upload file
	 if(basename($_FILES["fileToUpload"]["name"].[$i])){*/
    	require_once("file22upload.php");
       //}
      //}
	//Validate School Entry
	$string = substr($string, 0, -2);
	//echo "<br /><br />$string<br /><br />";
      
                            $SQL = "INSERT INTO [Employee] (
                                [UpdateStatus],
                                [InsertStatus],
                                [Synchronization],
                                [Absent],
                                [Leave],
                                [Attendance Date],
                                [Attendance],
                                [Employee Image File],
                                [No_ of Hours_Week],
                                [Hours_Day],
                                [ESI No_],
                                [End Date],
                                [Start Date],
                                [Remarks for Termination],
                                [Reason for Inactivity],
                                [B_ED],
                                [Passport No_],
                                [PAN Card No_],
                                [Job Status],
                                [Approval Status],
                                [Gross Salary],
                                [To],
                                [From],
                                [Promotion if Any],
                                [Joined as],
                                [Reason For Leaving],
                                [Previous Gross Salary],
                                [Previous School Till],
                                [Previous School From],
                                [Previous School Worked as],
                                [No_ Series],
                                [Salespers__Purch_ Code],
                                [Title],
                                [Company E-Mail],
                                [Fax No_],
                                [Pager],
                                [Extension],
                                [Last Date Modified],
                                [Resource No_],
                                [Global Dimension 2 Code],
                                [Global Dimension 1 Code],
                                [Grounds for Term_ Code],
                                [Termination Date],
                                [Cause of Inactivity Code],
                                [Inactive Date],
                                [Status],
                                [Statistics Group Code],
                                [Emplymt_ Contract Code],
                                [Manager No_],
                                [Union Membership No_],
                                [Union Code],
                                [Social Security No_],
                                [Alt_ Address End Date],
                                [Alt_ Address Start Date],
                                [Alt_ Address Code],
                                [Search Name],
                                [Initials],
                                [No_],
				[First Name],
                                [Middle Name],
                                [Last Name],
				[Birth Date],
                                [Gender],
				[Country_Region Code],
				[Employment Date],
				[Employee Type],
				[Department],
				[Job Title],
				[CTC],
				[Company Name],
				[Blood Group],
				[Teaching Type],
				[Address],
				[Address 2],
				[Post Code],
				[State1],
				[County],
				[City],
				[Phone No_],
				[Mobile Phone No_],
				[E-Mail],
				[Qualification],
                                [Degree],
				[University],
                                [Qual City],
                                [Qual Country],
                                [Qual State],
                                [Qual Passing Year],
                                [Image],
                                [PanCard],
                                [Aadhar],
                                [Apointment Letter],
                                [H Qualification],
                                [Prev Employment],
                                [Dob],
                                [Voter Id],
                                [Passport])
                                VALUES (
                                '0',
                                '0',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '0',
                                '0',
                                '0',
                                '1970-01-01 00:00:00',
                                '1970-01-01 00:00:00',
                                '0',
                                '0',
                                $B_ED,
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '1970-01-01 00:00:00',
                                '1970-01-01 00:00:00',
                                '0',
                                '0',
                                '0',
                                '0',
                                '1970-01-01 00:00:00',
                                '31/Aug/1870',
                                '0',
                                '0',
                                '0',
                                '".$_REQUEST['Title']."',
                                '".$_REQUEST['CompanyEmail']."',
                                '0',
                                '0',
                                '0',
                                '31/Aug/1870',
                                '0',
                                '0',
                                '0',
                                '0',
                                '31/Aug/1870',
                                '0',
                                '31/Aug/1870',
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '31/Aug/1870',
                                '31/Aug/1870',
                                '0',
                                '0',
                                '".$_REQUEST['Title']."',
                                '$EmpNo',
				'".$_REQUEST['Name']."',
				'".$_REQUEST['MidName']."',
				'".$_REQUEST['LName']."',
				'".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DOB'])))."',
                                ".$_REQUEST['Gender'].",
                                '".$_REQUEST['Citizenship']."',
                                '".$_REQUEST['empdate']."',
                                '".$_REQUEST['emptype']."',
				'".$_REQUEST['department']."',
                                '".$_REQUEST['jobtype']."',
                                ".$_REQUEST['ctc'].",
                                '".$_REQUEST['companyname']."',
                                ".$_REQUEST['Blood'].",
                                '".$_REQUEST['Teaching']."',
                                '".$_REQUEST['Address1']."',
                                '".$_REQUEST['Address2']."',
                                '".$_REQUEST['PostCode']."',
                                '".$_REQUEST['State']."',
                                '".$_REQUEST['Country']."',
                                '".$_REQUEST['City']."',
                                '".$_REQUEST['Landline']."',
                                '".$_REQUEST['Mobile']."',
                                '".$_REQUEST['Email']."',
                                '".$_REQUEST['Qualification']."',
                                '".$_REQUEST['Degree']."',
                                '".$_REQUEST['University']."',
                                 '".$_REQUEST['Country1']."',
                                '".$_REQUEST['State1']."',
                                '".$_REQUEST['City1']."',
                                '".$_REQUEST['Passingyear']."',";
			       $SQL .= $string.")";
                              // echo $SQL;
                             // exit($SQL);
		
                $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		else{
			
			//Success Message
			echo "<div class='alert alert-success alert-error'><strong>Success!</strong> Company has been registered.</div>";
		}
		
		
		
	require_once("SetupRight.php");
        

?>
