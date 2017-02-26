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
                                    
 
                if(!$result){
                  echo  '<META http-equiv="refresh" content="0;URL=TakeHeadApproval.php?success=1"> ';
                }
		else{
			
			//Success Message
			 echo  '<META http-equiv="refresh" content="0;URL=TakeHeadApproval.php?success=0"> ';
		}
		
 }
		
?>

