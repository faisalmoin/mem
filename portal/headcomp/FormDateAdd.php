<?php
	require_once("header.php");
	$security=$CompName.rand().$_REQUEST["startDate"].date('d/M/Y H:i:s');
	
	
	$check = odbc_exec($conn, "select * from [RegFormToDate] where [Company Name]='".$CompName."' AND [Status]='".$_REQUEST["active"]."' ") or die("Check ...") ;
	if(odbc_num_rows($check)==0){ //check company name and status
			 
				$SQL = "INSERT INTO [RegFormToDate] ([Start Date], [End Date], [Company Name], [Status], [Url], [Security]) VALUES  
					('".strtotime(str_replace("/", " ",$_REQUEST["startDate"].date('H:i:s')))."',  '".strtotime(str_replace("/", " ",$_REQUEST["endDate"].date('H:i:s')))."','".$CompName."','".$_REQUEST["active"]."','".$_REQUEST["Url"]."','".md5($security)."')"; 
			//echo $SQL;
				$result = odbc_exec($conn, $SQL) or exit(odbc_errormsg($conn));
	 }
	else{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('All Ready Exist')
	 </SCRIPT>");
	}
	
?>
<!--meta http-equiv='refresh' content="0;URL='Company.php?cid=<--?php echo $CompName?>&sec=<--?php echo md5($security)?>'" /-->
<meta http-equiv='refresh' content="0;URL='LinkDetails.php'" />
	
<?php require_once("SetupRight.php"); ?>
