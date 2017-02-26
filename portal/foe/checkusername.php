<?
	require_once("../db.txt");

	//Check form availability
	//get form n0
	$RegistrationFormNo = mysql_real_escape_string($_POST['RegistrationFormNo']);  
	$FormNo=mysql_query("SELECT `RegistrationFormNo` FROM `registration` WHERE `RegistrationFormNo`='$RegistrationFormNo' AND `SchoolERPCode`='".$UsrComp[1]."' ") or die(mysql_error());
	if(mysql_num_rows($FormNo)>0){
		echo 0;
	}
	else{
		echo 1;
	}

?>