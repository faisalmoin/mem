<?php
	require_once("header.php");
	echo "<br /><br /><br /><br />";
	$id = $_REQUEST['id'];
	echo "<div class='container'>";
	$Ldt = $_REQUEST['LeadDT'];
	
	$dt = explode("/", $_REQUEST['LeadDT']);
	$LeadDate = strtotime($dt[0]." ".$dt[1]." ".$dt[2]." ".date('H:s:i'));
		
	//Lead_ID
	$ld = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [CRM Lead]") or die($odbc_errormsg($conn));	
	
	$sql = "UPDATE [CRM Lead] SET 
            [Name]='".ucwords(strtolower($_REQUEST['Name']))."'
           ,[Status]='".$_REQUEST['Status']."'
           ,[Job Title]='".ucwords(strtolower($_REQUEST['JobTitle']))."'
           ,[Company Name]='".ucwords(strtolower($_REQUEST['CompanyName']))."'
           ,[Office Phone]='".$_REQUEST['OfficePhone']."'
           ,[Source]='".$_REQUEST['LeadSource']."'
           ,[Mobile]='".$_REQUEST['Mobile']."'
           ,[Office Fax]='".$_REQUEST['OfficeFax']."'
           ,[Email]='".$_REQUEST['Email']."'
           ,[Address 1]='".$_REQUEST['Address1']."'
           ,[Address 2]='".$_REQUEST['Address2']."'
           ,[City]='".$_REQUEST['City']."'
           ,[State]='".$_REQUEST['State']."'
           ,[Post Code]='".$_REQUEST['PostCode']."'
           ,[Country]='".$_REQUEST['Country']."'
           ,[Website]='".strtolower($_REQUEST['Website'])."'
           ,[Likely Brand]='".$_REQUEST['Brand']."'
           ,[Location of School]='".ucwords(strtolower($_REQUEST['City']))."'
           ,[Assign To]='".$_REQUEST['AssignTo']."'
	   WHERE [Lead No]='$id'";
        
        $OppSQL = "UPDATE [CRM Oppurtunity] SET 
            [Name]='".ucwords(strtolower($_REQUEST['Name']))."'
           ,[Status]='".$_REQUEST['Status']."'
           ,[Job Title]='".ucwords(strtolower($_REQUEST['JobTitle']))."'
           ,[Company Name]='".ucwords(strtolower($_REQUEST['CompanyName']))."'
           ,[Office Phone]='".$_REQUEST['OfficePhone']."'
           ,[Source]='".$_REQUEST['LeadSource']."'
           ,[Mobile]='".$_REQUEST['Mobile']."'
           ,[Office Fax]='".$_REQUEST['OfficeFax']."'
           ,[Email]='".$_REQUEST['Email']."'
           ,[Address 1]='".$_REQUEST['Address1']."'
           ,[Address 2]='".$_REQUEST['Address2']."'
           ,[City]='".$_REQUEST['City']."'
           ,[State]='".$_REQUEST['State']."'
           ,[Post Code]='".$_REQUEST['PostCode']."'
           ,[Country]='".$_REQUEST['Country']."'
           ,[Website]='".strtolower($_REQUEST['Website'])."'
           ,[Likely Brand]='".$_REQUEST['Brand']."'
           ,[Location of School]='".ucwords(strtolower($_REQUEST['City']))."'
           ,[Assign To]='".$_REQUEST['AssignTo']."'
	   WHERE [Lead No]='$id'";
	//exit($sql);   
	$result=odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
        
	
	if($result){
		//redirect to CRM Lead list ....
                odbc_exec($conn, $OppSQL) or die(odbc_errormsg($conn));
		echo '<script>alert("Lead has been updated successfully ..."); window.location = "Opp-List.php";</script>';
	}
	if(!$result){
		//display error ...
		echo '<script>alert("Error encountered while creating lead ..."); window.location = "Lead-New.php";</script>';
	}
	
?>
</div>

<?php require_once("../footer.php")?>