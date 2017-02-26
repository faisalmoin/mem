<?php
	require_once("header.php");
	echo "<br /><br /><br /><br />";
	echo "<div class='container'>";
	$Ldt = $_REQUEST['LeadDT'];
	
	$dt = explode("/", $_REQUEST['LeadDT']);
	$LeadDate = strtotime($dt[0]." ".$dt[1]." ".$dt[2]." ".date('H:s:i'));
		
	//Lead_ID
	$ld = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [CRM Lead]") or die($odbc_errormsg($conn));	
	$LeadNo = "LD".str_pad(odbc_result($ld, "") , 6, 0, STR_PAD_LEFT);
	$sql = "INSERT INTO [CRM Lead]
           ([Lead Date]
           ,[Name]
           ,[Status]
           ,[Job Title]
           ,[Company Name]
           ,[Office Phone]
           ,[Source]
           ,[Mobile]
           ,[Office Fax]
           ,[Email]
           ,[Address 1]
           ,[Address 2]
           ,[City]
           ,[State]
           ,[Post Code]
           ,[Country]
           ,[Industry]
           ,[Website]
           ,[Description]
           ,[Likely Brand]
           ,[Location of School]
           ,[User ID]
           ,[Lead No]
           ,[Assign To])
     VALUES
           ('".$LeadDate."'
           ,'".ucwords(strtolower($_REQUEST['Name']))."'
           ,'".$_REQUEST['Status']."'
           ,'".ucwords(strtolower($_REQUEST['JobTitle']))."'
           ,'".ucwords(strtolower($_REQUEST['CompanyName']))."'
           ,'".$_REQUEST['OfficePhone']."'
           ,'".$_REQUEST['LeadSource']."'
           ,'".$_REQUEST['Mobile']."'
           ,'".$_REQUEST['OfficeFax']."'
           ,'".$_REQUEST['Email']."'
           ,'".$_REQUEST['Address1']."'
           ,'".$_REQUEST['Address2']."'
           ,'".$_REQUEST['City']."'
           ,'".$_REQUEST['State']."'
           ,'".$_REQUEST['PostCode']."'
           ,'".$_REQUEST['Country']."'
           ,''
           ,'".strtolower($_REQUEST['Website'])."'
           ,''
           ,'".$_REQUEST['Brand']."'
           ,'".ucwords(strtolower($_REQUEST['City']))."'
           ,'".strtoupper($_REQUEST['UserID'])."'
           ,'$LeadNo'
           ,'".(($_REQUEST['AssignTo']!=="")?strtoupper($_REQUEST['AssignTo']):strtoupper($_REQUEST['UserID']))."')";
	
	echo $sql."<br />";
	
	$result=odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
	
	if($result){
                $get_id = odbc_exec($conn, "SELECT [ID] FROM [CRM Lead] WHERE [Lead No]='$LeadNo' ") or die(odbc_errormsg($conn));
		//redirect to CRM Lead list ....
                require_once "lead_status_upd.php";
		echo '<script>alert("Lead has been successfully created ..."); window.location = "Opp-List.php";</script>';
	}
	if(!$result){
		//display error ...
		echo '<script>alert("Error encountered while creating lead ..."); window.location = "Lead-New.php";</script>';
	}
?>
</div>

<?php require_once("../footer.php")?>