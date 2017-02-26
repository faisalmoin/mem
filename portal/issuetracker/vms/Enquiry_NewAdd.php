 <?php 
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
     if($_REQUEST['itemname']!="" && $_REQUEST['qty']!="")
     {
        $SQL = "INSERT INTO [VMS Item Requisition] (
                                [Company Name],
                                [Item Name],
                                [Specifications],
				[Qty],
                                [Purpose],
                                [Requested By],
                                [Status]
                               
                               
                                
				
			) VALUES ('".$SchName."',
                                   '".($_REQUEST['itemname'])."',
                                  '".($_REQUEST['specifications'])."',
				  '".($_REQUEST['qty'])."',
                                  '".($_REQUEST['purpose'])."',
                                  '".($_REQUEST['requestby'])."',
                                   '3')";
                //exit($SQL);
                $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
     }
                 if(!$result){
                   
                    $msg="failure";
                }
		else{
			 $msg="success";
                         
                }
		 header('Location: Enquiry_List.php?message='.$msg.'');
 }	
		/*
		
		if($result){
			echo "<div class='container'><div class='alert alert-success alert-error'><strong>Success!</strong> Company has been registered.</div></div>";
		}
		else{
			echo "<div class='container'><div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div></div>";
		}
	}
	else{
		echo "<div class='container'><div class='alert alert-danger alert-error'><strong>Error!</strong> This company is already registered.</div></div>";
	}
                 
                 */
	
?>

