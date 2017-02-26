
<?php
 require_once 'Header1.php';
  require_once("../db.txt");
   $SQL = "SELECT * from [VMS Item Requisition] WHERE Status='0' OR Status='3'";
   $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>

<form action="Principal_Approval_Add.php" enctype="multipart/form-data" method="POST">
  
   <div class="container">
     <div class="row">
        <div class="col-md-1"></div>
	      <div class="col-sm-10 col-md-10">
            <div class="row"> 
               <h1 class="text-primary">Approval Details</h1>
            </div>
            <div class="row">
               <input type="button" class="btn btn-primary" value="Take Head Approval" onClick="document.location.href='TakeHeadApproval.php'" />
            </div>
		         <div class="row">
                    
                    <table>
                        <tr>
                            <th class="col-sm-4 col-md-1">Sr</th>
                            <th class="col-sm-4 col-md-2">Item Name</th>
                            <th class="col-sm-4 col-md-2">Specifications</th>
                            <th class="col-sm-4 col-md-2">Quantity</th>
                             <th class="col-sm-4 col-md-2">Requested By</th>
                             <th class="col-sm-4 col-md-1">View</th>
                            <th class="col-sm-1 col-md-1">Approve</th>
                            <th class="col-sm-1 col-md-1">Reject</th>
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tr>
                            <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Requested By") ?></td> 
                            <td class="col-sm-4 col-md-1">
                             <a href="#myModal<?php echo $i?>" class="text-primary" data-toggle="modal"  data-target="#myModal<?php echo $i?>">View</a>
                            <div id="myModal<?php echo $i?>" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Sr No.<?php echo $i?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <table>
                                            <tr>
                                                
                                                <th class="col-sm-4 col-md-2">Item Name</th>
                                                <th class="col-sm-4 col-md-2">Specifications</th>
                                                <th class="col-sm-4 col-md-2">Quantity</th>
                                                <th class="col-sm-4 col-md-2">Requested By</th>
                                                <th class="col-sm-4 col-md-2">Purpose</th>
                                            </tr>
                                           
                                            <tr>
                                              
                                                <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                                                <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                                                <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                                                <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Requested By") ?></td> 
                                                <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Purpose") ?></td> 
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>

                                </div>
                              
                            </td> 
                           
                            <td> <input type="radio" name="approve<?php echo $i; ?>" value="approve" />
                            </td>
		             <td class="col-sm-1 col-md-1">  <input type="radio" name="approve<?php echo $i; ?>" value="reject" />
                           </td>
		              <input type="hidden" name="approval<?php echo $i?>" value="<?php echo odbc_result($result,"ID")?>"/>                 
                        
                        </tr>
                       <?php $i++;} $count=$i;?>
                         <input type="hidden" value="<?php echo $i?>" name="count" />
                    </table>
                                                
			</div>
      <div class="row">
            <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div> 
        </div>
</div>
<div class="col-md-1"></div>
</div>
</div>
</form>
<?php require_once("../footer.php");?>