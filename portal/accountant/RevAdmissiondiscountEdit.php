<?php

	require_once("header.php");
	
	echo "<br/><br/><br/><br/><br/>";
              $Class= $_REQUEST['Class'];
              $AdmissionYear= $_REQUEST['AdmissionYear'];
              $a= $_REQUEST['SlabCode'];
              $b= $_REQUEST['TransFee'];
              $c= $_REQUEST['TransDist'];
	      $Customerno=$_REQUEST['Customerno'];
              if(!empty($a) && ($b) && ($c)) {
              if($a != "" && $b != "" && $c != ""){
              $sql_update = "UPDATE [Temp Application] SET 
					[Slab Code]='".ucwords(strtoupper($a))."',
					[Transport Fee]='$b',
					[Distance Covered in KM]='$c'
					WHERE [Company Name]='$ms' AND [System Genrated No_]= '".$Customerno."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn)); 
                  
                 }
                 
                }
	       
                //------------------------------------------------------>
                for($f =0; $f<=$_REQUEST['fee_count']; $f++){
			
                        $check = odbc_exec($conn, "SELECT [FeeNo] FROM [StudentFee] WHERE [CompanyName]='$ms' AND [FeeNo]='".$_REQUEST['fee_Id'.$f]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                      if(odbc_num_rows($check) == 0 && $_REQUEST['fee'.$f]==1){
                            odbc_exec($conn, "INSERT INTO [StudentFee] ([ApplicationNo], [CompanyName], [FeeNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".$_REQUEST["fee_Id".$f]."','".$_REQUEST["Description".$f]."','".$_REQUEST["DocumentNo_".$f]."')") or die(odbc_errormsg($conn));

                        }
                        else if(odbc_num_rows($check) == 1 && ($_REQUEST['fee'.$f]=="" || $_REQUEST['fee'.$f]==0)){
                            odbc_exec($conn, "DELETE FROM [StudentFee] WHERE [CompanyName]='$ms' AND [FeeNo]='".$_REQUEST['fee_Id'.$f]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                        }

                }

                //----------------------------------------------------------------------------------------------------------------------->
               

                 for($d =0; $d<=$_REQUEST['Dis_count']; $d++){
                        $check1 = odbc_exec($conn, "SELECT [DiscountNo] FROM [StudentDiscountDetails] WHERE [CompanyName]='$ms' AND [DiscountNo]='".$_REQUEST['discount_Id'.$d]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                      if(odbc_num_rows($check1) == 0 && $_REQUEST['discount'.$d]==1){
                           odbc_exec($conn, "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description".$d]."','".$_REQUEST["No_".$d]."')") or die(odbc_errormsg($conn));

                        }
                        else if(odbc_num_rows($check1) == 1 && ( empty($_REQUEST['discount'.$d]) || $_REQUEST['discount'.$d]==0)){
                            odbc_exec($conn, "DELETE FROM [StudentDiscountDetails] WHERE [CompanyName]='$ms' AND [DocumentNo_]='".$_REQUEST["No_".$d]."' AND [DiscountNo]='".$_REQUEST['discount_Id'.$d]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                        }

                }

                
		//echo "<META http-equiv='refresh' content='0;URL=RevFeedicountEdit.php?invoice=$Customerno&Class=$Class&AdmissionYear=$AdmissionYear'>";//header("Location: NewEnquiry.php?eid=$EnquiryNo");
                echo "<META http-equiv='refresh' content='0;URL=Reverse.php?invoice=$Customerno'>";

	
 require_once("../footer.php");
?>
