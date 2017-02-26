<?php
	require_once("SetupLeft.php");
	
	//Check no. of  entries in Fee Header
	$FeeHeader = odbc_exec($conn, "SELECT MAX([ID]) FROM [Class Fee Header] WHERE [Company Name]='$CompName'");
	$CFH= (odbc_result($FeeHeader, "") + 1);
	$No = "FS-$CompName-$CFH";
	
	$AcadYear = $_REQUEST['AcadYear'];
	$Curriculum = $_REQUEST['Curriculum'];
	$Class = $_REQUEST['Class'];
	$FeeClassification = $_REQUEST['FeeClassification'];
	
	$count=$_REQUEST['count'];
        $msg=0;
	
	//Insert into Class Fee Header
	if($AcadYear != "" || $Curriculum!=""){
		
		//Insert into Class Fee Line
		//if($rs1){
			for($i=0; $i<=$count; $i++){
				$LineNo = 0;
				$TotAmt = 0;
				$LineNo = 10000*($i+1);
				if($_REQUEST['FeeCode'][$i] != "" ){
                                    
					
					$FeeDesc = odbc_exec($conn, "SELECT [Description] FROM [Fee Components] WHERE [Code]='".$_REQUEST['FeeCode'][$i]."'");
					$fDesc = ucwords(strtolower(odbc_result($FeeDesc, "Description")));				
					/*
					if($_REQUEST['Months'][$i] != 0){
						$TotAmt = $_REQUEST['Amount'][$i]*$_REQUEST['Months'][$i];
					}
					if($_REQUEST['Months'][$i] == 0){
						$TotAmt = $_REQUEST['Amount'][$i]*1;
					}
					*/
					//$TotAmt = $_REQUEST['Amount'];
                                $check = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Description]='$fDesc' AND [Company Name]='$CompName' AND ([Class]='$Class' OR [Class]='') AND [Academic Year]='$AcadYear' ");
                          // echo "SELECT * FROM [Class Fee Line] WHERE [Description]='$fDesc' AND [Company Name]='$CompName' AND [Class]='$Class' AND [Academic Year]='$AcadYear' AND [Curriculum]='$Curriculum' ";
                            if(odbc_num_rows($check)==0){
                                
                            if($_REQUEST['Class']== 'AllClass'){    
                            $rs1 = odbc_exec($conn, "INSERT INTO [Class Fee Header] ([No_], [Class], [Fee Classification Code], [Academic Year], [Curriculum],[Class Group], 
                            [No_ Series], [User ID], [Portal ID], [Boolean], [Approver ID],[Approved], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) 
                            VALUES ('$No', '', '$FeeClassification', '$AcadYear', '$Curriculum', '',
                            '', '$LoginID', '$LoginID', 0, '', 1, 0, '$CompName', 1,0)") or die(odbc_errormsg($conn));
		
                              
                            odbc_exec($conn, "INSERT INTO [Class Fee Line] ([Document No_], [Line No_], [Fee Code], [Group Code], [Amount], [Description], [Fee Type Code],
                            [Academic year], [Class], [Total Amount], [No_ of months], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus],[Monthly Amount])
                            VALUES('$No', $LineNo, '".$_REQUEST['FeeCode'][$i]."', '".$_REQUEST['FeeGroup'][$i]."', ".$_REQUEST['Amount'][$i].", '$fDesc', '', 
                            '$AcadYear', '', ".$_REQUEST['TotAmt'][$i].", ".$_REQUEST['Months'][$i].", 0, '$CompName', 1,0,".$_REQUEST['MnthtAmt'][$i].")") or die(odbc_errormsg($conn));
                            
                            
                            }else{
                                
                                  $rs1 = odbc_exec($conn, "INSERT INTO [Class Fee Header] ([No_], [Class], [Fee Classification Code], [Academic Year], [Curriculum],[Class Group], 
                            [No_ Series], [User ID], [Portal ID], [Boolean], [Approver ID],[Approved], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus]) 
                            VALUES ('$No', '$Class', '$FeeClassification', '$AcadYear', '$Curriculum', '',
                            '', '$LoginID', '$LoginID', 0, '', 1, 0, '$CompName', 1,0)") or die(odbc_errormsg($conn));
		
                              
                            odbc_exec($conn, "INSERT INTO [Class Fee Line] ([Document No_], [Line No_], [Fee Code], [Group Code], [Amount], [Description], [Fee Type Code],
                            [Academic year], [Class], [Total Amount], [No_ of months], [Synchronization], [Company Name], [InsertStatus], [UpdateStatus],[Monthly Amount])
                            VALUES('$No', $LineNo, '".$_REQUEST['FeeCode'][$i]."', '".$_REQUEST['FeeGroup'][$i]."', ".$_REQUEST['Amount'][$i].", '$fDesc', '', 
                            '$AcadYear', '$Class', ".$_REQUEST['TotAmt'][$i].", ".$_REQUEST['Months'][$i].", 0, '$CompName', 1,0,".$_REQUEST['MnthtAmt'][$i].")") or die(odbc_errormsg($conn));

                            }
                          
                            }

                            }
			}
		/*}
		else{
			exit("Error: Unable to insert Class Fee Header ...");
		}*/
	}
            if(odbc_num_rows($check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Fee Structure Already Exist')
        window.history.go(-2);
        </SCRIPT>");
            }
?>
<meta http-equiv='refresh' content="0;URL='FeeStructureList.php'" >
<?php require_once("SetupRight.php"); ?>