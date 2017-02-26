<?php
	require_once("SetupLeft.php");
     
	for($i=0; $i<=$_REQUEST['fee_count']; $i++){
                    if(basename($_FILES["fileUpload".$i]["name"])){
    	              require_once("fileUpload.php");
                       }
                   
	          //if($_REQUEST['fee'.$f] != 0){
                    echo "INSERT INTO [Class section] ([Class Code], [Image]) VALUES ('".$_REQUEST['Code'.$i]."','".$_FILES["fileUpload".$i]["name"]."')";
                    echo "</br></br>";
	            $SQL1 = "INSERT INTO [Class section] ([Class Code], [Image]) VALUES ('".$_REQUEST['Code'.$i]."','$target_file')";
	            //$result1 = odbc_exec($conn, $SQL1) or exit(odbc_errormsg($conn));
	            //var_dump($result1);
	            /*if(!$result1){
	            exit ("Unable to insert record : ".$_REQUEST["fee_Id".$f]." ...");
	            }*/
	            // unset($SQL1);
	            //}
	            //unset($result1);
	}
?>
<!--meta http-equiv='refresh' content="0;URL='AClassFile.php'" /--> 
<?php require_once("SetupRight.php")?>