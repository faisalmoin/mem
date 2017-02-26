<?php
	require_once("SetupLeft.php");
	
	
	echo "<br /><br /><br /><br />";
        $id =  $_REQUEST['id'];
	$B_ED = $_REQUEST['B_ED'];
         if($_REQUEST['B_ED'] == ""){
			$B_ED = 0;
		}
		else{
			$B_ED = 1;
		}

	//Upload file
	$sql_update = "UPDATE [Employee] SET ";
		
		require_once("file2upload.php");
                    $string = substr($string, 0, -2);
                        
                    $str = explode(", ", $string);
                    
                    $img = "[Image]=".$str[0].",";
                    $pancard = "[PanCard]=".$str[1].",";
                    $aadhar = "[Aadhar]=".$str[2].",";
                    $letter = "[Apointment Letter]=".$str[3].",";
                    $quali = "[H Qualification]=".$str[4].",";
                    $prevemp = "[Prev Employment]=".$str[5].",";
                    $dob_certi = "[Dob]=".$str[6].",";
                    $voterid = "[Voter Id]=".$str[7].",";
                    $passport_certi = "[Passport]=".$str[8].", ";
		    
                    
                    if($str[0] != "''"){ $sql_update .= $img;}
                    if($str[1] != "''"){ $sql_update .= $pancard;}
                    if($str[2] != "''"){ $sql_update .= $aadhar;}
                    if($str[3] != "''"){ $sql_update .= $letter;}
                    if($str[4] != "''"){ $sql_update .= $quali;}
                    if($str[5] != "''"){ $sql_update .= $prevemp;}
                    if($str[6] != "''"){ $sql_update .= $dob_certi;}
                    if($str[7] != "''"){ $sql_update .= $voterid;}
                    if($str[8] != "''"){ $sql_update .= $passport_certi;}
		             
                $sql_update .="[B_ED]= $B_ED,
                                [Title]='".ucwords(strtolower($_REQUEST['Title']))."',
                                [Company E-Mail]='".ucwords(strtolower($_REQUEST['CompanyEmail']))."',
                                [Status]=1,
                                [First Name]='".ucwords(strtolower($_REQUEST['Name']))."',
                                [Middle Name]='".ucwords(strtolower($_REQUEST['MidName']))."',
                                [Last Name]='".ucwords(strtolower($_REQUEST['LName']))."',
                                [Birth Date]='".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DOB'])))."',
                                [Gender]= ".intval($_REQUEST['Gender']).",
                                [Country_Region Code]='".$_REQUEST['Citizenship']."',
                                [Employment Date]='".$_REQUEST['empdate']."',
                                [Employee Type]=".intval($_REQUEST['emptype']).",
                                [Department]='".$_REQUEST['department']."',
                                [Job Title]='".$_REQUEST['jobtype']."',
                                [CTC]='".$_REQUEST['ctc']."',
                                [Company Name]='".$_REQUEST['companyname']."',
                                [Blood Group]= ".intval($_REQUEST['Blood']).",
                                [Teaching Type]='".$_REQUEST['Teaching']."',
                                [Address]='".$_REQUEST['Address1']."',
                                [Address 2]='".$_REQUEST['Address2']."',
                                [Post Code]='".$_REQUEST['PostCode']."',
                                [State1]='".$_REQUEST['State']."',
                                [County]='".$_REQUEST['Country']."',
                                [City]='".$_REQUEST['City']."',
                                [Phone No_]='".$_REQUEST['Landline']."',
                                [Mobile Phone No_]='".$_REQUEST['Mobile']."',
                                [E-Mail]='".$_REQUEST['Email']."',
                                [Qualification]='".$_REQUEST['Qualification']."',
                                [Degree]='".$_REQUEST['Degree']."',
                                [University]='".$_REQUEST['University']."',
                                [Qual City]='".$_REQUEST['City1']."',
                                [Qual Country]='".$_REQUEST['Country1']."',
                                [Qual State]='".$_REQUEST['State1']."',
                                [Qual Passing Year]='".$_REQUEST['Passingyear']."'
                            where [ID]=$id";
               // echo $sql_update;
                odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		
		echo '<META http-equiv="refresh" content="0;URL=EmployeeDetails.php?Id='.$id.'"> ';
	
	
	require_once("SetupRight.php");
	?>