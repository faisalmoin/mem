 <?php 
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
      $count=$_REQUEST['count'];
      for ($i = 0; $i < $count; $i++) 
                                    {
            if(!empty($_REQUEST['approve'.$i])){

                                          if($_REQUEST['approve'.$i]=='approve')
                                          {
                                            echo  $SQL="UPDATE [VMS Item Requisition]
                                                SET
                                                        [Status]='1'
                                                        
                                                 WHERE  ID='".$_REQUEST['approval'.$i]."'";
                                                 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                          }
                                          else{
                                           echo  $SQL="UPDATE [VMS Item Requisition]
                                                SET
                                                        [Status]='2'
                                                        
                                                 WHERE  ID='".$_REQUEST['approval'.$i]."'";
                                                 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                          }
                                            
                                          
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
?>

