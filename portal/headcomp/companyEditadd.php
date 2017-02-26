<?php
	require_once("SetupLeft.php");
	
	
	$SchoolNameEdit = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='{$_GET['CompanyId']}'") or exit(odbc_errormsg($conn));
	$SchId = odbc_result($SchoolNameEdit, "ID"); //SchoolName
	//$SchName = odbc_result($SchoolNameEdit, "Address");
	//print_r($SchName);die;
	
	//$sql=mysql_query("select * from users where ID='{$_GET['CompanyId']}'");
	//$row=mysql_fetch_array($sql);
	//extract($_POST);
	//Upload file
	$sql_update = "UPDATE [Company Information] SET ";
		
		if(basename($_FILES["fileToUpload"]["name"])){
			require_once("FileToUpload.php");
		
			$sql_update .= "[Picture]='".$target_file."', ";
			
		}
		
		//if($target_file!= null AND isset($_FILES['fileToUpload'])) {
		$sql_update .="[Address]='".ucwords(strtolower($_POST['address']))."',
				[Address 2]='".ucwords(strtolower($_POST['address2']))."',
				[Adress3]='".ucwords(strtolower($_POST['address3']))."',
				[Post Code]='".ucwords(strtolower($_POST['postCode']))."',
				[City]='".ucwords(strtolower($_POST['City']))."',
				[County]='".ucwords(strtolower($_POST['regionCode']))."',
				[State]='".ucwords(strtolower($_POST['state']))."',
				[Phone No_]='".$_POST['phoneNo1']."',
				[School Type]=".$_POST['SchoolType'].",
				[School Name]='".ucwords(strtolower($_POST['schoolName']))."',
				[Name 2]='".ucwords(strtolower($_POST['name2']))."',
				[Brand]=".$_POST['Brand'].",
				[Company Status]=".$_POST['CompanyStatus'].",
				[Phone No_ 2]='".$_POST['phoneNo2']."',
				[Fax No_]='".ucwords(strtolower($_POST['faxNo']))."',
				[E-mail]='".ucwords(strtolower($_POST['email']))."',
				[IC Partner Code]='".ucwords(strtolower($_POST['partnerCode']))."',
				[IC Inbox Type]='".$_POST['ICInboxType']."',		
				[IC Inbox Details]='".ucwords(strtolower($_POST['inboxDetail']))."',
				[Export or Deemed Export]=".intval($_POST['deemedExport']).",
				[Composition]=".intval($_POST['composition']).",
				[Composition Type]='".$_POST['compositionType']."',
				[L_S_T_ No_]='".ucwords(strtolower($_POST['LST']))."',
				[C_S_T No_]='".ucwords(strtolower($_POST['CST']))."',
				[VAT Registration No_]='".ucwords(strtolower($_POST['vatRegistration']))."',
				[T_I_N_ No_]='".ucwords(strtolower($_POST['TIN']))."',
				[T_A_N_ No_]='".ucwords(strtolower($_POST['TAN']))."',
				[T_C_A_N_ No_]='".ucwords(strtolower($_POST['TCAN']))."',
			        [Circle No_]='".ucwords(strtolower($_POST['circle']))."',
				[Assessing officer]='".ucwords(strtolower($_POST['assessing']))."',
				[Ward No_]='".ucwords(strtolower($_POST['wardNo']))."',
				[Input Service Distributor]=".intval($_POST['inputSD']).",
				[Central STC Applicable]=".intval($_POST['centralSA']).",
				[ST Payment Period]=".intval($_POST['STpayment']).",
				[ST Payment Due Day]=".intval($_POST['duePayment']).",
				[Service Tax Registration No_]='".ucwords(strtolower($_POST['serviceTR']))."',
				[P_A_N_ Status]=".$_POST['PANstatus'].",
				[P_A_N_ No_]='".ucwords(strtoupper($_POST['PANNo']))."',
				[Deductor Category]='".ucwords(strtolower($_POST['deductor']))."',
				[PAO Code]='".ucwords(strtolower($_POST['PAOCode']))."',
				[PAO Registration No_]='".ucwords(strtolower($_POST['PAOReg']))."',
				[DDO Code]='".ucwords(strtolower($_POST['DDOCode']))."',
				[DDO Registration No_]='".ucwords(strtolower($_POST['DDOReg']))."',
				[Ministry Type]=".intval($_POST['ministryType']).",
				[Ministry Code]='".ucwords(strtolower($_POST['ministryCode']))."'
				where [ID]=".intval($_POST['CompanyId'])." ";
                //echo $sql_update;
		//exit($sql_update);
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		
		echo '<META http-equiv="refresh" content="0;URL=CompanyView.php"> ';
	//}
	
	
	require_once("SetupRight.php");
	?>