
<?php
require_once 'Header1.php';
 require_once("../db.txt");
  $SQL = "SELECT * from [VMS Item Requisition] WHERE Status='4'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>
<head>
    <script>

		</script>
</head>

<form action="Head_Approval_Add.php" enctype="multipart/form-data" method="POST">
    
    <div class="container">
     <div class="row">
       <div class="col-md-1"></div>
	     <div class="col-sm-10 col-md-10" style="margin-top: 5px;">
          <div class="row">
            <h2 class="text-primary">Head Approval</h2>             
		       </div>
           <div class="row">        
                    <table>
                        <tr>
                            <th class="col-sm-4 col-md-1">Sr No</th>
                           <th class="col-sm-4 col-md-2">Item Name</th>
                            <th class="col-sm-4 col-md-2">Specifications</th>
                            <th class="col-sm-4 col-md-2">Qty</th>
                            <th class="col-sm-4 col-md-2">Purpose</th>
                            <th class="col-sm-4 col-md-1">Approve</th>
                            <th class="col-sm-4 col-md-1">Reject</th>
                           
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tbody id='table'>
                        <tr>
                            <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Purpose") ?></td>
                                <td class="col-sm-1 col-md-1"> <input type="radio" name="approve<?php echo $i; ?>" value="approve" />
                            </td>
		             <td class="col-sm-1 col-md-1">  <input type="radio" name="approve<?php echo $i; ?>" value="reject" />
                           </td>
		               <input type="hidden" name="approval<?php echo $i?>" value="<?php echo odbc_result($result,"ID")?>"/>                 
                                                  
                        </tr>
                       <?php $i++;} $count=$i;?>
                  <input type="hidden" value="<?php echo $i?>" name="count" />
                        </tbody>
                    </table>
                    </div>
                    <div class="row">
                      <input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/>
                    </div>                   
			       </div>
          <div class="col-md-1"></div>
       </div>
    </div>
    
<form>
<?php require_once("../footer.php");?>