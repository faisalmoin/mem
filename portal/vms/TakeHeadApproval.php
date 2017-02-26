
<?php
 require_once 'Header1.php';

 require_once("../db.txt");
   $SQL = "SELECT * from [VMS Item Requisition] WHERE Status='0' OR Status='3'";
   $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>

<form action="Take_Head_Approval_Add.php" enctype="multipart/form-data" method="POST">
    
    <div class="container">
   
	<div class="col-sm-8 col-md-9">
            <h1 class="text-primary">Director's Approval</h1>
		<div >
              <?php 
             if(isset($_REQUEST['success'])){
              $msg=$_REQUEST['success'];{ ?>

                
               <div class="row text-danger">
                 <?php if($msg==0){?>Data has been updated!!<?php }?>
                 <?php if($msg==1){?>Data has not been updated!!<?php }?>
               </div>
            <?php }}?>      
                    <table>
                        <tr>
                            <th class="col-sm-4 col-md-1">Sr</th>
                            <th class="col-sm-4 col-md-1">Select</th>
                            <th class="col-sm-4 col-md-2">Item Name</th>
                            <th class="col-sm-4 col-md-2">Specifications</th>
                            <th class="col-sm-4 col-md-2">Quantity</th>
                             <th class="col-sm-4 col-md-2">Requested By</th>
                            
                           
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tr>
                            <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
                            <td class="col-sm-4 col-md-1"><input type="checkbox" name="selectitem<?php echo $i?>" value="<?php echo odbc_result($result,"ID")?>" id="inlineCheckbox1"></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Requested By") ?></td> 
                          
                           
                           
                        </tr>
                       <?php $i++;} $count=$i;?>
                         <input type="hidden" value="<?php echo $i?>" name="count" />
                    </table>
                                                
			</div>
            <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div> 
        </div>
</div>
	
	
	
</form>
