<?php
	require_once("SetupLeft.php");
	
	$AcadYr = $_REQUEST['AcadYr'];
	$StartDt = $_REQUEST['StartDt'];
	$EndDt = $_REQUEST['EndDt'];
	$Fee = $_REQUEST['Fee'];
	
	//Primary Key
	$pk = odbc_exec($conn, "SELECT MAX([Primary Key]) FROM [Admission Setup] WHERE [Company Name]='$Compname'");
	$pky = odbc_num_rows($pk);
	if($pky==0 || $pky == NULL){
		$pKey="10000";
	}
	else{
		$pKey=10000*($pky+1);
	}
	
	$FCode = odbc_exec($conn, "SELECT [Fee Code], [Amount], [No_ of months] FROM [Class Fee Line] WHERE [Fee Code]='$Fee' AND [Academic Year]='$AcadYr' AND [Company Name]='$CompName'");
	$FeeCode = odbc_result($FCode, 'Fee Code');
	$FeeAmt = odbc_result($FCode, 'Amount');
	$FeeOcc = odbc_result($FCode, 'No_ of months');
	
	$sql = "INSERT INTO [Admission Setup]([Primary Key], [Enquiry No_], [Application No_], [Academic Year], 
		[Appl Cost Method],[Application Cost], [Registration Cost], [Journal Template Name], [Application Sales Batch Name],
		[Application Cost Account No_], [Registration Cost Account No_], [Application Cost Needed], [Registration Cost Needed],
		[Admission Year], [Gen_ Bus_ Posting Group], [Customer Posting Group], [Student No_], [Registration Batch Name], 
		[Application Sales Posting No_], [Registration Posting No_], [Evaluation No_], [Selection No_], [Application Sale Method], 
		[Application Sales From], [Application Sales To], [User ID], [Portal ID], [Reg No_], [Reg No_ Option], [ItemDB No_], 
		[Component No_], [Job Code], [Task No_], [UnScheduled Task No_], [Create Task No_], Synchronization, [Company Name],
		InsertStatus, UpdateStatus, [Appln No_], [Stud No_], [Enq No_], [App_ Sales Batch Name], [App_ Sales Posting No_])
		VALUES 
		('$pKey', 'ENQ', 'APP', '$AcadYr', $FeeOcc, $FeeAmt, 0, 'GENERAL', 'APP-WP', '', '', $FeeOcc, 0, '$AcadYr', 'CAPEXSUP', 'DOMESTIC', 
		'STUD NO', 'REG', 'APP RCPT', 'REG RCPT', 'EVAL', 'SEL', $FeeOcc, '$StartDt', '$EndDt', '$LoginID', '$LoginID', 'REGISTRA', 0, 
		'TM ITEM', 'COMP DB', 'JOB DB', 'TASK NO', 'UNSCHTASK', '', 0, '$CompName', 1, 0, '', '', '', '', '')";
	//exit($sql);
	$rs = odbc_exec($conn, $sql);
	
	if(!$rs){ exit ("Error encountered ... <br /><br /> $sql");}
	
	
?>
<meta http-equiv='refresh' content="0;URL='RegistrationList.php'" />
<?php
	require_once("SetupRight.php");
?>