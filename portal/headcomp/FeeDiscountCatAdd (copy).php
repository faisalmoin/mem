<?php
	require_once("SetupLeft.php");
	$AcadYr = $_REQUEST['AcadYear'];
	$Curriculum = $_REQUEST['Curriculum'];
	$Class  = $_REQUEST['Class'];
	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$count; $i++){
		$ChkFeeClasi = odbc_exec($conn, "SELECT [ID] FROM [Fee Classification] WHERE [Code]='".strtoupper($_REQUEST['Code'][$i])."' AND [Company Name]='$CompName'");
		if(odbc_result($ChkFeeClasi, "ID") == ""){
			if($_REQUEST['Code'][$i] !=""){
				$sql1 = "INSERT INTO [Fee Classification]([Code], [Description], [User ID], [Portal ID], [Synchronization], 
				[Company Name], [InsertStatus], [UpdateStatus])
				VALUES('".strtoupper($_REQUEST['Code'][$i])."', '".$_REQUEST['Description'][$i]."', '$LoginID', '$LoginID', 0, '$CompName', 1,0)";
				odbc_exec($conn, $sql1);			
				//echo "<br /><br />$sql1";
			}
		}
		
		$CheckDiscHd = odbc_exec($conn, "SELECT [ID] FROM [Discount Fee Header] WHERE [Academic Year]='$AcadYr' AND [Fee Clasification Code]='".strtoupper($_REQUEST['Code'][$i])."' AND [Curriculum]='$Curriculum' AND [Company Name]='$CompName' ");
		if(odbc_result($CheckDiscHd, "ID") == ""){
			if($_REQUEST['Code'][$i] !=""){
				//Count Record
				$rec = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Discount Fee Header] WHERE [Company Name]='$CompName' AND [Academic Year]='$AcadYr'");
				$No="DISC/".$AcadYr."/".str_pad((odbc_result($rec, "")+1), 5, '0', STR_PAD_LEFT);
				
				echo "INSERT INTO [Discount Fee Header]([No_], [Fee Clasification Code], [Academic Year], [Fee Discount Code],
				[No_ Series], [Class], [Curriculum], [User ID], [Portal ID], [Synchronization], [Company Name], InsertStatus, UpdateStatus)
				VALUES('$No', '".strtoupper($_REQUEST['Code'][$i])."', '$AcadYr', '', 'DISCOUNT', '$Class', '$Curriculum', '$LoginID', '$LoginID', 0, '$CompName', 1, 0)";
				
				$sql2 = "INSERT INTO [Discount Fee Header]([No_], [Fee Clasification Code], [Academic Year], [Fee Discount Code],
				[No_ Series], [Class], [Curriculum], [User ID], [Portal ID], [Synchronization], [Company Name], InsertStatus, UpdateStatus)
				VALUES('$No', '".strtoupper($_REQUEST['Code'][$i])."', '$AcadYr', '".ucwords(strtoupper($_REQUEST['Description'][$i]))."', 'DISCOUNT', '$Class', '$Curriculum', '$LoginID', '$LoginID', 0, '$CompName', 1, 0)";
				odbc_exec($conn, $sql2);
				
				echo "<br /><br />$sql2<br /><b>$No</b>";
			}
		}
	}
?>
<meta http-equiv='refresh' content="0;URL='FeeDiscountCatList.php'" /> 
<?php require_once("SetupRight.php")?>