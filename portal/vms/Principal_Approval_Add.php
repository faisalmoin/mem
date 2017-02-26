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
                                           
                                              $SQL="UPDATE [VMS Item Requisition]
                                                SET
                                                        [Status]='1'
                                                        
                                                 WHERE  ID='".$_REQUEST['approval'.$i]."'";
                                                 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                          }
                                        }
              if(!empty($_REQUEST['reject'.$i])){
                                         if($_REQUEST['reject'.$i]=='reject')
                                          {
                                              $SQL="UPDATE [VMS Item Requisition]
                                                SET
                                                        [Status]='2'
                                                        
                                                 WHERE  ID='".$_REQUEST['approval'.$i]."'"; 
                                                 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                          }
                                            
                                          
                                        }
                                    }

 
                if(!$result){
                    echo  '<META http-equiv="refresh" content="0;URL=Principal_Approval.php?success=1"> ';
                }
		else{
			
			//Success Message
			 echo  '<META http-equiv="refresh" content="0;URL=Principal_Approval.php?success=0"> ';
		}
		
 }	
?>

