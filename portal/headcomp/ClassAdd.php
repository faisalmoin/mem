<?php
	require_once("SetupLeft.php");
	
	$Curriculum = $_REQUEST['Curriculum'];
	$AcadYear = $_REQUEST['AcadYear'];
	$Class = $_REQUEST['Class'];
	$Sec = $_REQUEST['Sec'];
	$Capacity = $_REQUEST['Capacity'];
	$CapSNA = ($Capacity*$Class);
		
	echo "<br /><br /><br /><br /><br />";
	//echo "Curriculum: $Curriculum // Acad: $AcadYear // Class : $Class // Section: $Sec // Capacity: $Capacity <br /><br />";
			
	$sql = "<br /><b>I</b>NSERT INTO [Class Section] ([Curriculum], [Academic Year], [Capacity], [Class Code], [Class], [Section])  VALUES 
		('$Curriculum', '$AcadYear', '$Capacity', ";
	/*		
	if($Class == 1) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1"; 
	}
	if($Class == 2) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery"; $cl_seq[1] = "2";
	}
	if($Class == 3) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery"; $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG";
	}
	if($Class == 4) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery"; $cl_seq[0] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[3] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[4] = "4";
	}
	if($Class == 5) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
	}
	if($Class == 6) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
	}
	if($Class == 7) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
	}
	if($Class == 8) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
	}
	if($Class == 9) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
	}
	if($Class == 10) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
	}
	if($Class == 11) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
		$cl[10] = "VIII"; $cl_d[10] = "Class VIII"; $cl_seq[10] = "11";
	}
	if($Class == 12) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
		$cl[10] = "VIII"; $cl_d[10] = "Class VIII"; $cl_seq[10] = "11";
		$cl[11] = "IX"; $cl_d[11] = "Class IX"; $cl_seq[11] = "12";
	}
	if($Class == 13) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
		$cl[10] = "VIII"; $cl_d[10] = "Class VIII"; $cl_seq[10] = "11";
		$cl[11] = "IX"; $cl_d[11] = "Class IX"; $cl_seq[11] = "12";
		$cl[12] = "X"; $cl_d[12] = "Class X"; $cl_seq[12] = "13";
	}
	if($Class == 14) {
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
		$cl[10] = "VIII"; $cl_d[10] = "Class VIII"; $cl_seq[10] = "11";
		$cl[11] = "IX"; $cl_d[11] = "Class IX"; $cl_seq[11] = "12";
		$cl[12] = "X"; $cl_d[12] = "Class X"; $cl_seq[12] = "13";
		$cl[13] = "XI"; $cl_d[13] = "Class XI"; $cl_seq[13] = "14";
	}
	if($Class == 15) {*/
		$cl[0] = "PRENUR"; $cl_d[0] = "Pre-Nursery"; $cl_seq[0] = "1";
		$cl[1] = "NURSERY"; $cl_d[1] = "Nursery";  $cl_seq[1] = "2";
		$cl[2] = "KG"; $cl_d[2] = "KG"; $cl_seq[2] = "3";
		$cl[3] = "I"; $cl_d[3] = "Class I"; $cl_seq[3] = "4";
		$cl[4] = "II"; $cl_d[4] = "Class II"; $cl_seq[4] = "5";
		$cl[5] = "III"; $cl_d[5] = "Class III"; $cl_seq[5] = "6";
		$cl[6] = "IV"; $cl_d[6] = "Class IV"; $cl_seq[6] = "7";
		$cl[7] = "V"; $cl_d[7] = "Class V"; $cl_seq[7] = "8";
		$cl[8] = "VI"; $cl_d[8] = "Class VI"; $cl_seq[8] = "9";
		$cl[9] = "VII"; $cl_d[9] = "Class VII"; $cl_seq[9] = "10";
		$cl[10] = "VIII"; $cl_d[10] = "Class VIII"; $cl_seq[10] = "11";
		$cl[11] = "IX"; $cl_d[11] = "Class IX"; $cl_seq[11] = "12";
		$cl[12] = "X"; $cl_d[12] = "Class X"; $cl_seq[12] = "13";
		$cl[13] = "XI"; $cl_d[13] = "Class XI"; $cl_seq[13] = "14";
		$cl[14] = "XII"; $cl_d[14] = "Class XII"; $cl_seq[14] = "15";
	//}
	
	$cl_sec[0] = "SNA";
	$cl_sec[1] = "A";
	$cl_sec[2] = "B";
	$cl_sec[3] = "C";
	$cl_sec[4] = "D";
	$cl_sec[5] = "E";
	$cl_sec[6] = "F";
	$cl_sec[7] = "G";
	$cl_sec[8] = "H";
	$cl_sec[9] = "1";
	$cl_sec[10] = "J";
	$cl_sec[11] = "K";
	$cl_sec[12] = "L";
	$cl_sec[13] = "M";
	$cl_sec[14] = "N";
	$cl_sec[15] = "O";
	$cl_sec[16] = "P";
	$cl_sec[17] = "Q";
	$cl_sec[18] = "R";
	$cl_sec[19] = "S";
	$cl_sec[20] = "T";
	$cl_sec[21] = "U";
	$cl_sec[22] = "V";
	$cl_sec[23] = "W";
	$cl_sec[24] = "X";
	$cl_sec[25] = "Y";
	$cl_sec[26] = "Z";
	
	
	
	for($i = 0; $i<$Class; $i++){
		//Insert Class Section
		for($j=0; $j<=$Sec; $j++){
			if($j==0) $Cap = $CapSNA;
			else $Cap = $Capacity;
				
			$sql = "INSERT INTO [Class Section] ([Curriculum], [Academic Year], [Capacity], [Class Code], [Class], [Section], [User ID], [Portal ID], [Company Name])  VALUES 
			('$Curriculum', '$AcadYear', $Cap, '".$cl[$i]."-".$cl_sec[$j]."-".$Curriculum."-".$AcadYear."', '".$cl[$i]."',  '".$cl_sec[$j]."', '$LoginID', '$LoginID', $CompName )";
			
			$ChkClSec = odbc_exec($conn, "SELECT [ID] FROM [Class Section] WHERE [Class Code]='".$cl[$i]."-".$cl_sec[$j]."-".$Curriculum."-".$AcadYear."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
			if(odbc_num_rows($ChkClSec) == 0 || odbc_num_rows($ChkClSec) == ""){
				odbc_exec($conn, $sql) or exit(odbc_errormsg($conn));
			}
			
		}
		$sql1 = "INSERT INTO [Class]([Code], [Description], [Sequence], [Portal ID], [User ID], [Company Name]) VALUES
			('".$cl[$i]."', '".$cl_d[$i]."', '".$cl_seq[$i]."', '$LoginID', '$LoginID', '$CompName')";
		
		$ChkClassCode = odbc_exec($conn, "SELECT [ID] FROM [Class] WHERE [Code]='".$cl[$i]."' AND [Company Name]='$CompName' ") or die("Error: SELECT * FROM [Class] WHERE [Code]='".$cl[$i]."' AND [Company Name]='$CompName' <br />");
		if(odbc_num_rows($ChkClassCode) == 0 || odbc_num_rows($ChkClassCode) == ""){
			odbc_exec($conn, $sql1) or exit(odbc_errormsg($conn));
		}
	}
	
	//echo "<br /><br /><br />$sql";
?>
<meta http-equiv='refresh' content="0;URL='ClassList.php'" />
<?php require_once("SetupRight.php");?>