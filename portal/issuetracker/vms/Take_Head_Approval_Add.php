 <?php 
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
      $count=$_REQUEST['count'];
      for ($i = 0; $i < $count; $i++) 
                                    {

                                        if(!empty($_REQUEST['selectitem'.$i])){

                                          
                                             $SQL="UPDATE [VMS Item Requisition]
                                                SET
                                                        [Status]='4'
                                                        
                                                 WHERE  ID='".$_REQUEST['selectitem'.$i]."'";
                                                 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                          }
                                         
                                            
                                          
                                        }
                                    
 
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		else{
			
			//Success Message
			echo "<div class='alert alert-success alert-error'><strong>Success!</strong> Data has been Entered.</div>";
		}
		
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

