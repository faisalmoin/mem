<?php
	require_once("header.php");
	//SELECT Approver;
	$Approver = mysql_query("SELECT `ApproverID` FROM `approvalmaster` WHERE `UserID`='LoginID'") or die(mysql_error());
	$ApvID = strtoupper(mysql_fetch_array($Approver));	
	
	$NoSeries = "WTC";
	
	$qryEnq1 = odbc_exec($conn, "SELECT COUNT([TC No_])+1 FROM [Temp Transfer Certificate]") or die(odbc_errormsg());
	$TCNo=$NoSeries.  str_pad(odbc_result($qryEnq1, ""), 7, '0', STR_PAD_LEFT);
	
	$DOB = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DOB'])));
	$DateJoined = $_REQUEST['DateJoined'];
	$DateFeeCutoff=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DateFeeCutoff'])));
	$DateIssue=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DateIssue'])));
	$DateInactive=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['DateInactive'])));
	
	$interval =  date_diff(date_create($DOB), date_create($DateIssue));
	$Age = $interval->format('%y');
	$Mnth = $interval->format('%m');
	
	
	$SQL = "INSERT INTO [Temp Transfer Certificate]([Academic Year],[Approval Status],[Approver ID],[Class],[Class Code],[Company Name],[Conduct],[Curriculum],[Date of Birth],[Date of Inactive],[Date of Issue],[Date of Joining],[ERPUpdateStatus],[Father Name],[Fee Cut off date],[Gender],[InsertStatus],[Last Attented Date],[Mother Name],[No_ Series],[Portal ID],[Reason],[Section],[Student Name],[Student No_],[Student Status],[System Genrated No_],[TC Issued],[TC No_],[UpdateStatus],[User ID],[Withdrawl date],[Withdrawl No_], 
	[Age], [Reason for Leaving], [Months], [Mail Code])
			VALUES
			('".$_REQUEST['AcadYear']."',0,'$ApvID[0]','".strtoupper($_REQUEST['Class'])."','".$_REQUEST['ClassCode']."','$ms','".$_REQUEST['Conduct']."','".$_REQUEST['Curriculum']."','$DOB','$DateInactive','$DateIssue','$DateJoined','','".$_REQUEST['FatherName']."','$DateFeeCutoff','".$_REQUEST['Gender']."',1,'".$_REQUEST['DateLastClassAtnd']."','".$_REQUEST['MotherName']."','WTC','$LoginID','".$_REQUEST['Reason']."','".$_REQUEST['Section']."','".$_REQUEST['StudentName']."','".$_REQUEST['StudentNo']."','".$_REQUEST['StudentStatus']."','',0,'$TCNo',0, '$LoginID', '1753-01-01 00:00:00.000','$TCNo', 
			$Age, '', $Mnth, 0)";
	$result = odbc_exec($conn, $SQL);
?>
<div class="container">
	<?php 
		
		echo $Age;
		if(!$result){
			echo "<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					$SQL <br />
					<strong>Error!</strong> Unable to insert data. Kindly check...<br />".odbc_errormsg($conn)."
				</div>
			</div>";
		}
		else{
			echo "<div class='container'><div class='bs-example'>
                        <div class='alert alert-success alert-error'>
                                <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                <strong>Success!</strong> Transfer Certificate of <strong>".$_REQUEST['StudentName']."</strong> has been registered.
                        </div>
			</div></div>";
		}
		
	?>
</div>

<?php require_once("../footer.php"); ?>