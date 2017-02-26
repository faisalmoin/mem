<?php
	require_once("SetupLeft.php");
	
	$count = $_REQUEST['count'];
	$DiscCode = $_REQUEST['DiscCode'];
	$AcadYr = $_REQUEST['acad'];
	$Class = $_REQUEST['class'];
	
	for($i=0; $i<=$count; $i++){
		$j==1;
		$FeeCode = $_REQUEST['FeeCode'.$i];
		$Discount = $_REQUEST['Discount'.$i];
		$Description = $_REQUEST['Description'.$i];
		
		if($FeeCode != "" && ($Discount != "" || $Description != "")){
			$LineNo += 10000;
		
			//Get Occurence
			$occur = odbc_exec($conn, "SELECT [No_ of months] FROM [Class Fee Line] WHERE [Class]='$Class' AND [Academic Year]='$AcadYr' AND [Fee Code]='$FeeCode' AND [Company Name]='$CompName' ");
			
			$sql = "INSERT INTO [Discount Fee Line]([Document No_], [Fee Code], [Line No_], [Fee Type Code], [Discount%], 
				Description, [G_L Account], [Academic Year], Synchronization, [Company Name], InsertStatus, UpdateStatus)
				VALUES('$DiscCode', '$FeeCode', $LineNo, '".odbc_result($occur, "No_ of months")."', $Discount, '$Description', '',
				'$AcadYr', 0, '$CompName', 1,0)";
				
			//echo $sql."<br />";
			
			//Check Fee Code
			$ChkFee=odbc_exec($conn, "SELECT [id] FROM [Discount Fee Line] WHERE [Document No_]='$DiscCode' AND [Academic Year]='$AcadYr' AND [Fee Code]='$FeeCode'  AND [Company Name]='$CompName' ");
			if(odbc_num_rows($ChkFee) == 0){
				$ins = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
				if(!$ins) echo "Unable to insert $FeeCode... <br />";
			}
			
		}
	}
         if(odbc_num_rows($ChkFee)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Already Exist')
        window.history.go(-2);
        </SCRIPT>");
            }
?>
<meta http-equiv='refresh' content="0;URL='FeeDiscLineList.php'" />
<?php
	
	require_once("SetupRight.php");
?>