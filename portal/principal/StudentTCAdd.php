
<?php
	require_once("header.php");
	
?>
<div class="container">
<br /><br /><br />
<?php
	$btn = $_REQUEST['btn'];
	$TCNo = $_REQUEST['TCNo'];
	
	$DOB = $_REQUEST['DOB'];
	$DateJoined = $_REQUEST['DateJoined'];
	$DateFeeCutoff=$_REQUEST['DateFeeCutoff'];
	$DateIssue=$_REQUEST['DateIssue'];
	$DateInactive=$_REQUEST['DateInactive'];
	
	if($btn == "Approve"){
		if($DateFeeCutoff !="" || $DateIssue !="" || $DateInactive != ""){
			//Update Transfer Certificate
			$SQL = "UPDATE [Temp Transfer Certificate] SET 
				[TC Issued]=1,
				[Approver ID]='$LoginID',
				[UpdateStatus]=1,
				[Student Status]=3,
				[Approval Status]=2,
				[Withdrawl date]='$DateInactive'
				WHERE [Student No_]='".$_REQUEST['StudentNo']."' AND [Company Name]='$ms'";
			//}
			//Update Student Table
			$SQL1 = "UPDATE [Temp Student] SET 
				[Date of Leaving]='$DateInactive',
				[Approver ID]='$LoginID',
				[UpdateStatus]=1,
				[Student Status]=3,
				[TC Date] = '$DateIssue',
				[TC No_] = '$TCNo',
				[Withdrwal Applied Date]='$DateInactive'
				WHERE [No_]='".$_REQUEST['StudentNo']."' AND [Company Name]='$ms'";
			
			
			//exit("$SQL <br /> $SQL1");
			$result = odbc_exec($conn, $SQL);
			
			if(!$result){			
			exit("<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						$SQL <br />
						<strong>Error!</strong> Unable to insert data. Kindly check...<br />".odbc_errormsg($conn)."
					</div>
				</div>");
			}
			else{
				
				$result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
				if(!$result1){
				exit("<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						$SQL <br />
						<strong>Error!</strong> Unable to update Student Table. Kindly check...<br />".odbc_errormsg($conn)."
					</div>
				</div>");
				}
				else{
					echo "<div class='container'><div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> Transfer Certificate of <strong>".$_REQUEST['StudentName']."</strong> has been issued.
					</div>
					</div></div>";
				}
			}
		}
		else{
			exit("<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						$SQL <br />
						<strong>Error!</strong> Unable to issue TC. Mandate fields are not set ...<br />
					</div>
				</div>");
		}
	}
		
	?>
</div>

<?php require_once("../footer.php"); ?>