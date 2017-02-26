<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('header.php');
echo "<br/><br/><br/><br/><br/><br/><br/><br/>";
//print_r($_GET);

$id=$_REQUEST['id'];
$row = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]='$id'") or die(odbc_errormsg($conn));
echo "<br/><br/>Changes : $id <br />";
/*if(odbc_result($row, "Name") != $_REQUEST['StudentName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Name', '".$_REQUEST['StudentName']."', '".odbc_result($row, "Name")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Mother Tongue") != $_REQUEST['MotherTongue']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mother Tongue', '".$_REQUEST['MotherTongue']."', '".odbc_result($row, "Mother Tongue")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
$EWS2 = $_REQUEST['EWS'];
         if($_REQUEST['EWS'] == ""){
			$EWS2 = 0;
		}
		else{
			$EWS2 = 1;
		}
if(odbc_result($row, "EWS") != $EWS2){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','EWS', '$EWS2', '".odbc_result($row, "EWS")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

}
        
if(odbc_result($row, "Caste") != $_REQUEST['Caste']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Caste', '".$_REQUEST['Caste']."', '".odbc_result($row, "Caste")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Community") != $_REQUEST['Community']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Community', '".$_REQUEST['Community']."', '".odbc_result($row, "Community")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(date("d/M/Y", strtotime(odbc_result($row, "Date Of Birth"))) != $_REQUEST['DOB']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Date Of Birth', '".$_REQUEST['DOB']."', '".date("d/M/Y",strtotime(odbc_result($row, "Date Of Birth")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Religion") != $_REQUEST['Religion']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Religion', '".$_REQUEST['Religion']."', '".odbc_result($row, "Religion")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

$PhysicallyChallanged = $_REQUEST['PhysicallyChallenged'];
         if($_REQUEST['PhysicallyChallenged'] == ""){
			$PhysicallyChallanged = 0;
		}
		else{
			$PhysicallyChallanged = 1;
		}
if(odbc_result($row, "Physically Challanged") != $PhysicallyChallanged){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Physically Challanged', '$PhysicallyChallanged', '".odbc_result($row, "Physically Challanged")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Langauge 1") != $_REQUEST['Language1']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Language 1', '".$_REQUEST['Language1']."', '".odbc_result($row, "Langauge 1")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Latest Rank") != $_REQUEST['LatestRank']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Latest Rank', '".$_REQUEST['LatestRank']."', '".odbc_result($row, "Latest Rank")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Latest GPA") != $_REQUEST['LatestGPA']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Latest GPA', '".$_REQUEST['LatestGPA']."', '".number_format(odbc_result($row, "Latest GPA"),2,'.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Langauge 2") != $_REQUEST['Language2']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Langauge 2', '".$_REQUEST['Language2']."', '".odbc_result($row, "Langauge 2")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Class Code") != $_REQUEST['ClassCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Class Code', '".$_REQUEST['ClassCode']."', '".odbc_result($row, "Class Code")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Latest Grade") != $_REQUEST['LatestGrade']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Latest Grade', '".$_REQUEST['LatestGrade']."', '".number_format(odbc_result($row, "Latest Grade"),2,'.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Class") != $_REQUEST['Classa']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name]'[Login]) "
        . "VALUES ('".time()."', '$id','Class', '".$_REQUEST['Classa']."', '".odbc_result($row, "Class")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

}

if(number_format(odbc_result($row, "CGPA"),2, '.', '') != $_REQUEST['LatestGPA']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','CGPA', '".$_REQUEST['LatestGPA']."', '".number_format(odbc_result($row, "CGPA"),2, '.', '')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, 'Section') != $_REQUEST['Section']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Section', '".$_REQUEST['Section']."', '".odbc_result($ClassSec, 'Section')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(number_format(odbc_result($row, "Pickup"),2,'.','') != $_REQUEST['Pickup']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Pickup', '".$_REQUEST['Pickup']."', '".number_format(odbc_result($row, "Pickup"),2,'.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Curriculum") != $_REQUEST['Curriculum']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Curriculum', '".$_REQUEST['Curriculum']."', '".odbc_result($row, "Curriculum")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Drop") != $_REQUEST['Drop']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Drop', '".$_REQUEST['Drop']."', '".odbc_result($row, "Drop")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Academic Year") != $_REQUEST['AcadYear']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Academic Year', '".$_REQUEST['AcadYear']."', '".odbc_result($row, "Academic Year")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(number_format(odbc_result($row, "Distance Covered in KM"),2, '.', '') != $_REQUEST['Distance']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Distance Covered in KM', '".$_REQUEST['Distance']."', '".number_format(odbc_result($row, "Distance Covered in KM"),2, '.', '')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Previous Class") != $_REQUEST['PreviousClass']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Previous Class', '".$_REQUEST['PreviousClass']."', '".odbc_result($row, "Previous Class")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Slab Code") != $_REQUEST['SlabCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Slab Code', '".$_REQUEST['SlabCode']."', '".odbc_result($row, "Slab Code")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Previous Curriculum") != $_REQUEST['PreviousCurriculum']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Previous Curriculum', '".$_REQUEST['PreviousCurriculum']."', '".odbc_result($row, "Previous Curriculum")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row, "Medium of Instruction") != $_REQUEST['MediumofInstruction']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Medium of Instruction', '".$_REQUEST['MediumofInstruction']."', '".odbc_result($row, "Medium of Instruction")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
 if(odbc_result($row, "Citizenship") != $_REQUEST['Citizenship']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Citizenship', '".$_REQUEST['Citizenship']."', '".odbc_result($row, "Citizenship")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }

$HostelAccommodation = $_REQUEST['HostelAccommodation'];
         if($_REQUEST['HostelAccommodation'] == ""){
			$HostelAccommodation = 0;
		}
		else{
			$HostelAccommodation = 1;
		}
if(odbc_result($row, "Hostel Acommodation") != $HostelAccommodation){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Hostel Acommodation', '$HostelAccommodation', '".odbc_result($row, "Hostel Acommodation")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

   }

 if(odbc_result($row, "Room No_") != $_REQUEST['RoomNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Room No', '".$_REQUEST['RoomNo']."', '".odbc_result($row, "Room No_")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
  
 }
  if(odbc_result($row, "Room Type") != $_REQUEST['RoomType']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Room Type', '".$_REQUEST['RoomType']."', '".odbc_result($row, "Room Type")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
  
 }
   if(odbc_result($row, "Mess") != $_REQUEST['Message']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mess', '".$_REQUEST['Message']."', '".odbc_result($row, "Mess")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
 
       }
 if(odbc_result($row, "House") != $_REQUEST['House']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','House', '".$_REQUEST['House']."', '".odbc_result($row, "House")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
 }
 if(odbc_result($row,  "Address To") != $_REQUEST['CommunicationReference']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Address To', '".$_REQUEST['CommunicationReference']."', '".odbc_result($row,  "Address To")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
 if(odbc_result($row,  "Addressee") != $_REQUEST['ContactName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Addressee', '".$_REQUEST['ContactName']."', '".odbc_result($row,  "Addressee")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
if(odbc_result($row,  "Address1") != $_REQUEST['Address1']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Address1', '".$_REQUEST['Address1']."', '".odbc_result($row,  "Address1")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
 if(odbc_result($row,  "Address2") != $_REQUEST['Address2']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Address2', '".$_REQUEST['Address2']."', '".odbc_result($row,  "Address2")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
  if(odbc_result($row,  "City") != $_REQUEST['City']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','City', '".$_REQUEST['City']."', '".odbc_result($row,  "City")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

 }
  if(odbc_result($row,  "Post Code") != $_REQUEST['PostCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Post Code', '".$_REQUEST['PostCode']."', '".odbc_result($row,  "Post Code")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
  if(odbc_result($row,  "State") != $_REQUEST['State']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','State', '".$_REQUEST['State']."', '".odbc_result($row,  "State")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 
  if(odbc_result($row,  "Country") != $_REQUEST['Country']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Country', '".$_REQUEST['Country']."', '".odbc_result($row,  "Country")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
  if(odbc_result($row,  "phone number") != $_REQUEST['PhoneNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','phone number', '".$_REQUEST['PhoneNo']."', '".odbc_result($row,  "phone number")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 
if(odbc_result($row,  "mobile number") != $_REQUEST['MobileNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','mobile number', '".$_REQUEST['MobileNo']."', '".odbc_result($row,  "mobile number")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 
if(odbc_result($row,  "e-mail address") != $_REQUEST['Email']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Email', '".$_REQUEST['Email']."', '".odbc_result($row,  "e-mail address")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 
if(odbc_result($row,  "father email") != $_REQUEST['FatherEmail']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','father email', '".$_REQUEST['FatherEmail']."', '".odbc_result($row,  "father email")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 

if(odbc_result($row,  "mother email") != $_REQUEST['MotherEmail']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','mother email', '".$_REQUEST['MotherEmail']."', '".odbc_result($row,  "mother email")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
} 
if(odbc_result($row,  'Father_s Name') != $_REQUEST['FatherName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Father_s Name', '".$_REQUEST['FatherName']."', '".odbc_result($row,  'Father_s Name')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Passport No_') != $_REQUEST['PassportNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Passport No_', '".$_REQUEST['PassportNo']."', '".odbc_result($row,  'Passport No_')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Father_s Qualification') != $_REQUEST['FatherQualification']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Father_s Qualification', '".$_REQUEST['FatherQualification']."', '".odbc_result($row,  'Father_s Qualification')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(date("d/M/Y", strtotime(odbc_result($row, "Passport Exp Date"))) != $_REQUEST['PassportExpDt']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Passport Exp Date', '".$_REQUEST['PassportExpDt']."', '".date("d/M/Y", strtotime(odbc_result($row, "Passport Exp Date")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Father_s Occupation") != $_REQUEST['FatherOccupation']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Father_s Occupation', '".$_REQUEST['FatherOccupation']."', '".odbc_result($row, "Father_s Occupation")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Visa No_") != $_REQUEST['VisaNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Visa No_', '".$_REQUEST['VisaNo']."', '".odbc_result($row, "Visa No_")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(number_format((float)odbc_result($row,  'Father_s Annual Income'),'2','.','') != $_REQUEST['FatherAnnualIncome']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Father_s Annual Income', '".$_REQUEST['FatherAnnualIncome']."', '".number_format((float)odbc_result($row,  'Father_s Annual Income'),'2','.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(date("d/M/Y", strtotime(odbc_result($row, "Visa Exp Date"))) != $_REQUEST['VisaExpDt']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Visa Exp Date', '".$_REQUEST['VisaExpDt']."', '".date("d/M/Y", strtotime(odbc_result($row, "Visa Exp Date")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Mother_s Name') != $_REQUEST['MotherName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mother Name', '".$_REQUEST['MotherName']."', '".odbc_result($row,  'Mother_s Name')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Mother_s Qualification') != $_REQUEST['MotherQualification']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mother_s Qualification', '".$_REQUEST['MotherQualification']."', '".odbc_result($row,  'Mother_s Qualification')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row,  'Mother_s Occupation') != $_REQUEST['MotherOccupation']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mother_s Occupation', '".$_REQUEST['MotherOccupation']."', '".odbc_result($row,  'Mother_s Occupation')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(number_format((float)odbc_result($row,  'Mother_s Annual Income'),'2','.','') != $_REQUEST['MotherAnnualIncome']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Mother_s Annual Income', '".$_REQUEST['MotherAnnualIncome']."', '".number_format((float)odbc_result($row,  'Mother_s Annual Income'),'2','.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Guardian Name') != $_REQUEST['GaurdianName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Gaurdian Name', '".$_REQUEST['GaurdianName']."', '".odbc_result($row,  'Guardian Name')."', '$ms', '0','Update','Temp tudent','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Guardian Qualification') != $_REQUEST['GaurdianQualification']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Gaurdian Qualification', '".$_REQUEST['GaurdianQualification']."', '".odbc_result($row, 'Guardian Qualification')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row,  'Guardian Occupation') != $_REQUEST['GaurdianOccupation']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Gaurdian Occupation', '".$_REQUEST['GaurdianOccupation']."', '".odbc_result($row, 'Guardian Occupation')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(number_format((float)odbc_result($row,  'Guardian Annual Income'),'2','.','') != $_REQUEST['GaurdianAnnualIncome']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Gaurdian Annual Income', '".$_REQUEST['GaurdianAnnualIncome']."', '".number_format((float)odbc_result($row,  'Guardian Annual Income'),'2','.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(date('d/M/Y', strtotime(odbc_result($row, "Date Joined"))) != $_REQUEST['DateJoined']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Date Joined', '".$_REQUEST['DateJoined']."', '".date('d/M/Y', strtotime(odbc_result($row, "Date Joined")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(number_format(odbc_result($row, "Height"),'2','.','') != $_REQUEST['Height']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Height', '".$_REQUEST['Height']."', '".number_format(odbc_result($row, "Height"),'2','.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Student Status") != $_REQUEST['StudentStatus']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Student Status', '".$_REQUEST['StudentStatus']."', '".odbc_result($row, "Student Status")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(number_format(odbc_result($row, "Weight"),'2','.','') != $_REQUEST['Weight']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Weight', '".$_REQUEST['Weight']."', '".number_format(odbc_result($row, "Weight"),'2','.','')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

$Block= $_REQUEST['Block'];
         if($_REQUEST['Block'] == ""){
			$Block = 0;
		}
		else{
			$Block = 1;
		}
if(odbc_result($row, "Block") != $Block){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Block', '$Block', '".odbc_result($row, "Block")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

   }

if(odbc_result($row, "Quota") != $_REQUEST['Quota']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Quota', '".$_REQUEST['Quota']."', '".odbc_result($row, "Quota")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Admission For Year") != $_REQUEST['AdmissionYear']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Admission For Year', '".$_REQUEST['AdmissionYear']."', '".odbc_result($row, "Admission For Year")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
$StaffChild= $_REQUEST['StaffChild'];
         if($_REQUEST['StaffChild'] == ""){
			$StaffChild = 0;
		}
		else{
			$StaffChild = 1;
		}
if(odbc_result($row, "Staff Child") != $StaffChild){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Staff Child', '$StaffChild', '".odbc_result($row, "Staff Child")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Staff Code") != $_REQUEST['StaffCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Staff Code', '".$_REQUEST['StaffCode']."', '".odbc_result($row, "Staff Code")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, "Application No_") != $_REQUEST['ApplicationNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Application No_', '".$_REQUEST['ApplicationNo']."', '".odbc_result($row, "Application No_")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

echo odbc_result($row, "TC No_");
echo $_REQUEST['TC'];
if(odbc_result($row, "TC No_") != $_REQUEST['TC']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','TC No_', '".$_REQUEST['TC']."', '".odbc_result($row, "TC No_")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
        
}

if(odbc_result($row, "Registration No_") != $_REQUEST['RegistrationNo']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Registration No_', '".$_REQUEST['RegistrationNo']."', '".odbc_result($row, "Registration No_")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(date('d/M/Y', strtotime(odbc_result($row, "TC Date"))) != $_REQUEST['TCDate']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','TC Date', '".$_REQUEST['TCDate']."', '".date('d/M/Y', strtotime(odbc_result($row, "TC Date")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(date('d/M/Y', strtotime(odbc_result($row, "Withdrwal Applied Date"))) != $_REQUEST['withdrawaldate']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Withdrwal Applied Date', '".$_REQUEST['withdrawaldate']."', '".date('d/M/Y', strtotime(odbc_result($row, "Withdrwal Applied Date")))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
$Sibling= $_REQUEST['Sibling'];
         if($_REQUEST['Sibling'] == ""){
			$Sibling = 0;
		}
		else{
			$Sibling = 1;
		}
if(odbc_result($row, "Sibling") != $Sibling){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibling', '$Sibling', '".odbc_result($row, "Sibling")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, "Sibbling Code") != $_REQUEST['SiblingCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibbling Code', '".$_REQUEST['SiblingCode']."', '".odbc_result($row, "Sibbling Code")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));

}
if(odbc_result($row, "Sibbling Name") != $_REQUEST['SiblingName']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibbling Name', '".$_REQUEST['SiblingName']."', '".odbc_result($row, "Sibbling Name")."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(date('d/M/Y', strtotime(odbc_result($row, 'Sibling DOB'))) != $_REQUEST['SiblingDOB']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibling DOB', '".$_REQUEST['SiblingDOB']."', '".date('d/M/Y', strtotime(odbc_result($row, 'Sibling DOB')))."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
if(odbc_result($row, 'Sibling Class') != $_REQUEST['SiblingClass']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibling Class', '".$_REQUEST['SiblingClass']."', '".odbc_result($row, 'Sibling Class')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}

if(odbc_result($row, 'Sibling Section') != $_REQUEST['SiblingSection']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Sibling Section', '".$_REQUEST['SiblingSection']."', '".odbc_result($row, 'Sibling Section')."', '$ms', '0','Update','Temp Student','$LoginID')") or die(odbc_errormsg($conn));
}
    $a = odbc_exec($conn, "SELECT * FROM [StudentDiscountDetails] WHERE  [CompanyName]='$ms' AND [ApplicationNo]='".odbc_result($row, "Registration No_")."' ") or die(odbc_errormsg($conn));
    while(odbc_fetch_array($a)){
      $oldValue.="'".odbc_result($a,"DiscountNo")."', ";
    }
    
    $oldValue = substr($oldValue, 0,-2);
   // echo "<br>Old Value : ".$oldValue;
  for($d =0; $d<=$_REQUEST['Dis_count']; $d++){
          if($_REQUEST['discount'.$d]==1){
            
               $newValue .= "'".$_REQUEST['discount_Id'.$d]."', ";
           }
       }
       
       $newValue = substr($newValue, 0, -2);
      // echo "<br />New VALUE : ".$newValue;

        $nv=  explode(", ", $newValue);        
        for($i=0;$i<count($nv);$i++){
           $insert=strpos($oldValue,$nv[$i]);
           if($nv[$i] != $insert){
            $var .= $nv[$i].", ";
               odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."','$id','DiscountNo',$nv[$i],'','$ms','0','Insert','StudentDiscountDetails','$LoginID')") or die(odbc_errormsg($conn));

           }
        }
       // echo "<br />INSERT : ".$var;
        
        $ov=  explode(", ", $oldValue);
        for($j=0;$j<count($ov);$j++){
            $delete = strpos($newValue, $ov[$j]);
           if($ov[$j] != $delete){
                $del .= $ov[$j].", ";
                  odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."','$id','DiscountNo',$ov[$j],'','$ms','0','Delete','StudentDiscountDetails','$LoginID')") or die(odbc_errormsg($conn));

           }
        }
       // echo "<br />DELETE : ".$del;


$transport=odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($row, "Registration No_")."' ") or die(odbc_errormsg($conn));

if(odbc_result($transport, 'Slab Code') != $_REQUEST['SlabCode']){
odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Slab Code', '".$_REQUEST['SlabCode']."', '".odbc_result($transport, 'Slab Code')."', '$ms', '0','Update','Temp Application','$LoginID') ") or die(odbc_errormsg($conn));

odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Transport Fee', '".$_REQUEST['TransFee']."', '".number_format(odbc_result($transport, "Transport Fee"),'2','.','')."', '$ms', '0','Update','Temp Application','$LoginID') ") or die(odbc_errormsg($conn));

odbc_exec($conn, "INSERT INTO [Student Card Changes]"
        . "([Changes Date], [Student No_], [Field Name], [New Value], [Old Value],[Company Name],[Status],[Action],[Table Name],[Login]) "
        . "VALUES ('".time()."', '$id','Distance Covered in KM', '".$_REQUEST['TransDist']."', '".odbc_result($transport, 'Distance Covered in KM')."', '$ms', '0','Update','Temp Application','$LoginID')") or die(odbc_errormsg($conn));

}

*/







// Update Student Table //
/*
$Language1=$_REQUEST['Language1'];
$Language2=$_REQUEST['Language2'];
$Section=$_REQUEST['Section'];
$HostelCode=$_REQUEST['HostelCode'];
$House=$_REQUEST['House'];
$Stream=$_REQUEST['Stream'];

$CommunicationReference=$_REQUEST['CommunicationReference'];
$ContactName=$_REQUEST['ContactName'];
$Address1=$_REQUEST['Address1'];
$Address2=$_REQUEST['Address2'];
$City=$_REQUEST['City'];
$PostCode=$_REQUEST['PostCode'];
$State=$_REQUEST['State'];
$Country=$_REQUEST['Country'];
$PhoneNo=$_REQUEST['PhoneNo'];
$MobileNo=$_REQUEST['MobileNo'];
$Email=$_REQUEST['Email'];
$FatherEmail=$_REQUEST['FatherEmail'];
$MotherEmail=$_REQUEST['MotherEmail'];

$FatherName=$_REQUEST['FatherName'];
$PassportNo=$_REQUEST['PassportNo'];
$FatherQualification=$_REQUEST['FatherQualification'];
$PassportExpDt=(($_REQUEST['PassportExpDt']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['PassportExpDt']))):"1753-01-01 00:00:00.000");
$FatherOccupation=$_REQUEST['FatherOccupation'];
$VisaNo=$_REQUEST['VisaNo'];
$FatherAnnualIncome=$_REQUEST['FatherAnnualIncome'];
$VisaExpDt=(($_REQUEST['VisaExpDt']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['VisaExpDt']))):"1753-01-01 00:00:00.000");
$MotherName=$_REQUEST['MotherName'];
$MotherQualification=$_REQUEST['MotherQualification'];
$MotherOccupation=$_REQUEST['MotherOccupation'];
$MotherAnnualIncome=$_REQUEST['MotherAnnualIncome'];
$GaurdianName=$_REQUEST['GaurdianName'];
$GaurdianQualification=$_REQUEST['GaurdianQualification'];
$GaurdianOccupation=$_REQUEST['GaurdianOccupation'];
$GaurdianAnnualIncome=$_REQUEST['GaurdianAnnualIncome'];

$FatherOfficeAddress1=$_REQUEST['FatherOfficeAddress1'];
$FatherOfficeAddress2=$_REQUEST['FatherOfficeAddress2'];
$FatherOfficeCity=$_REQUEST['FatherOfficeCity'];
$FatherOfficePostCode=$_REQUEST['FatherOfficePostCode'];
$FatherOfficeCountry=$_REQUEST['FatherOfficeCountry'];
$MotherOfficeAddress1=$_REQUEST['MotherOfficeAddress1'];
$MotherOfficeAddress2=$_REQUEST['MotherOfficeAddress2'];
$MotherOfficeCity=$_REQUEST['MotherOfficeCity'];
$MotherOfficePostCode=$_REQUEST['MotherOfficePostCode'];
$MotherOfficeCountry=$_REQUEST['MotherOfficeCountry'];
$GuardianRelationship=$_REQUEST['GuardianRelationship'];
$GaurdianOfficeAddress1=$_REQUEST['GaurdianOfficeAddress1'];
$GaurdianOfficeAddress2=$_REQUEST['GaurdianOfficeAddress2'];
$GaurdianOfficeCity=$_REQUEST['GaurdianOfficeCity'];
$GaurdianOfficePostCode=$_REQUEST['GaurdianOfficePostCode'];
$GaurdianOfficeCountry=$_REQUEST['GaurdianOfficeCountry'];

$StuStatNew=(($_REQUEST['StuStatNew']!="")?$_REQUEST['StuStatNew']:0);
$ClassCodeNew=$_REQUEST['ClassCodeNew'];
$EWSNew=(($_REQUEST['EWSNew'] != "")?$_REQUEST['EWSNew']:0);
$DiscCdNew=$_REQUEST['DiscCdNew'];
$RmvDiscCd1=(($_REQUEST['RmvDiscCd1'] != "")?$_REQUEST['RmvDiscCd1']:0);
$DiscCdNew1=$_REQUEST['DiscCdNew1'];
$RmvDiscCd2=(($_REQUEST['RmvDiscCd2']!="")?$_REQUEST['RmvDiscCd2']:0);
$TransportSlab=$_REQUEST['TransportSlab'];
$RmvDiscTrans=(($_REQUEST['RmvDiscTrans']!="")?$_REQUEST['RmvDiscTrans']:0);
$TPTAvailingDate=(($_REQUEST['TPTAvailingDate']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['TPTAvailingDate']))):"1753-01-01 00:00:00.000");
$TPTWithdrawalDate=(($_REQUEST['TPTWithdrawalDate']!="")?date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['TPTWithdrawalDate']))):"1753-01-01 00:00:00.000");

$Sibling = (($_REQUEST['Sibling'] =="1")?$_REQUEST['Sibling']:0);
$SiblingCode = $_REQUEST['SiblingCode'];
$SiblingName = $_REQUEST['SiblingName'];
$SiblingClass = $_REQUEST['SiblingClass'];
$SiblingSection = $_REQUEST['SiblingSection'];
$SiblingDOB = $_REQUEST['SiblingDOB'];
$SiblingNo = $_REQUEST['SiblingNo'];
?>
<div class="container">
<?php

$NewClass = odbc_exec($conn, "SELECT [Class Code], [Section] FROM [Class Section] WHERE [Class]='".odbc_result($row, 'Class')."' AND [Section]='$Section' AND [Curriculum]='".odbc_result($row, 'Curriculum')."' AND [Academic Year]='".odbc_result($row, 'Academic Year')."' AND [Company Name]='$ms'");		
if(odbc_num_rows($NewClass)!= 0){
	//$ClassSectionCode = odbc_result($ChkSec, "Class Code");
    
    // Update Temp Student Table //
	$SQL = "UPDATE [Temp Student] SET 
            [Address To]='$CommunicationReference',
            [Address1]='".str_replace("'", "''",$Address1)."',
            [Address2]='".str_replace("'", "''",$Address2)."',
            [Addressee]='$ContactName',
            [Applicant Relationship]='$GuardianRelationship',
            [City]='$City',
            [Class Code] = '".odbc_result($NewClass, 'Class Code')."',
            [Country]='$Country',
            [E-Mail Address]='$Email',
            [Father Email]='$FatherEmail',
            [Father Office Address 1]='$FatherOfficeAddress1',
            [Father Office Address 2]='$FatherOfficeAddress2',
            [Father Office City]='$FatherOfficeCity',
            [Father Office Country Code]='$FatherOfficeCountry',
            [Father Office Post Code]='$FatherOfficePostCode',
            [Father_s Annual Income]='$FatherAnnualIncome',
            [Father_s Name]='$FatherName',
            [Father_s Occupation]='$FatherOccupation',
            [Father_s Qualification]='$FatherQualification',
            [Guardian Annual Income]='$GaurdianAnnualIncome',
            [Guardian Name]='$GaurdianName',
            [Guardian Occupation]='$GaurdianOccupation',
            [Guardian Office Address 1]='$GaurdianOfficeAddress1',
            [Guardian Office Address 2]='$GaurdianOfficeAddress2',
            [Guardian Office City]='$GaurdianOfficeCity',
            [Guardian Office Country Code]='$GaurdianOfficeCountry',
            [Guardian Office Post Code]='$GaurdianOfficePostCode',
            [Guardian Qualification]='$GaurdianQualification',
            [Hostel Code]='$HostelCode',
            [House]='$House',
            [Langauge 1]='$Language1',
            [Language 2]='$Language2',
            [Mobile Number]='$MobileNo',
            [Mother Email]='$MotherEmail',
            [Mother Office Address 1]='$MotherOfficeAddress1',
            [Mother Office Address 2]='$MotherOfficeAddress2',
            [Mother Office City]='$MotherOfficeCity',
            [Mother Office Country Code]='$MotherOfficeCountry',
            [Mother Office Post Code]='$MotherOfficePostCode',
            [Mother_s Annual Income]='$MotherAnnualIncome',
            [Mother_s Name]='$MotherName',
            [Mother_s Occupation]='$MotherOccupation',
            [Mother_s Qualification]='$MotherQualification',
            [Passport Exp Date]='$PassportExpDt',
            [Passport No_]='$PassportNo',
            [Phone Number]='$PhoneNo',
            [Post Code]='$PostCode',
            [Section]='$Section',
            [State]='$State',
            [Stream]='$Stream',
            [Visa Exp Date]='$VisaExpDt',
            [Visa No_]='$VisaNo',
            [Student Status 1] = $StuStatNew,
            [Class code 1] = '$ClassCodeNew',
            [EWS 1] = $EWSNew,
            [Discount Code New] = '$DiscCdNew',
            [Discount Code1 New] = '$DiscCdNew1',
            [Transport Slab Code New] = '$TransportSlab',
            [TPT Availing Date-T] = '$TPTAvailingDate',
            [TPT Withdrawal Date-T] = '$TPTWithdrawalDate',
            [Bool1] = $RmvDiscTrans,
            [Bool2] = $RmvDiscCd1,
            [Bool3] = $RmvDiscCd2,
	    [Sibling] = $Sibling,
	    [Sibbling Name] = '$SiblingName',
	    [Sibling Class] = '$SiblingClass',
	    [Sibling Section] = '$SiblingSection',
	    [Sibling DOB] = '$SiblingDOB',
	    [Sibbling Code] = '$SiblingCode',
	    [Sibbling No_] = '$SiblingNo',
            [UpdateStatus]=1";
	    
	$SQL .= "WHERE [Company Name]='$ms' AND [No_]='$id'";
	//exit($SQL);
	$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
	$SelCust=odbc_exec($conn, "UPDATE [Temp Customer] SET [UpdateStatus]=1, [Section]='".odbc_result($NewClass,'Section')."' WHERE [No_]='' AND [Company Name]='$ms'") or die(odbc_errormsg());
	//Approval Request;
	if($StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !="" || $StuStatNew!="" || $ClassCodeNew !="" || $EWSNew !="" || $DiscCdNew !="" || $DiscCdNew1 !="" || $TransportSlab !="" || $TPTAvailingDate !="" || $TPTWithdrawalDate !=""){
		$Approver = odbc_exec($conn, "SELECT [ApproverID], [ApproverEmail] FROM [approvalmaster] WHERE [CompanyName]='$ms'") or die(mysql_error());
        
		if(odbc_num_rows($Approver) > 0){            
			//$apvr = mysql_fetch_array($Approver); 
            
			$ApvrSQL = "INSERT INTO [approvalrequest] SET 
				[Table] = 'STUDENT',
				[AdmissionNo]='$id',
				[Name]='".odbc_result($row, "Name")."',
				[UserID]='$LoginID',
				[ApproverID]='".odbc_result($apvr, "ApproverID")."',
				[RequestDateTime]='".date('d/M/Y')."',
				[Status]='Open',
				[CompanyName]='$ms'";
            
			odbc_exec($conn, $ApvrSQL) or die(odbc_errormsg($conn));
		}
		else{
			echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=3'>";
		}
	}
    
    if($result){
        echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=0'>";
    }
    else{
        echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=1'>";
    }
}
else{
    echo "<META http-equiv='refresh' content='0;URL=StudentCard.php?id=".$id."&msg=2'>";
}
*/
?>
</div>
<?php require_once '../footer.php';?>