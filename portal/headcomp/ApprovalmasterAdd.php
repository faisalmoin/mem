<?php
require_once("SetupLeft.php");
echo "<br/><br/><br/><br/>";

       
			for($i=0; $i<=$_REQUEST['count']; $i++){
			    $ApprovalMaster = odbc_exec($conn, "SELECT [Email] FROM [User] WHERE [ID]='".$_REQUEST['ApprovalMaster'][$i]."' ");
                            $ApprovalMasterEmail = strtolower(odbc_result($ApprovalMaster, "Email"));
                            if($ApprovalMasterEmail!=""){
                            $check = odbc_exec($conn, "SELECT * FROM [approvalmaster] WHERE [UserID]='".$_REQUEST['UserID'][$i]."' AND [CompanyName]='$CompName' ");
                            if(odbc_num_rows($check)==1){ 
                                
                             $sql_update = "UPDATE [approvalmaster] SET 
                                    [ApproverID]='".$_REQUEST['ApprovalMaster'][$i]."',
                                    [ApproverEmail]='$ApprovalMasterEmail'
                                    WHERE [CompanyName]='$CompName' AND [UserID]= '".$_REQUEST['UserID'][$i]."' ";
                             odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn)); 
                          
                            }
                            else
                            {
                              $rs1 = "INSERT INTO [approvalmaster] ([UserID], [UserEmail], [ApproverID], [ApproverEmail], [Table], [CompanyName]) 
                            VALUES ('".$_REQUEST['UserID'][$i]."', '".$_REQUEST['UserEmail'][$i]."', '".$_REQUEST['ApprovalMaster'][$i]."', '$ApprovalMasterEmail', '$CompName','$CompName')";
		            odbc_exec($conn, $rs1) or die(odbc_errormsg($conn)); 
                            }
                        
                            }
                        }
		
	
          
?>
<meta http-equiv='refresh' content="0;URL='ApprovalMaster.php'">
<?php require_once("SetupRight.php"); ?>