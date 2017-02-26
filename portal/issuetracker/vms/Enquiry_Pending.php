
<?php

  $SQL = "SELECT * from [VMS Item Requisition] WHERE Status='0' OR Status='4' OR Status='3'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>
<head>
    <script>

		</script>
</head>

<form action="Principal_Approval_Add.php" enctype="multipart/form-data" method="POST">
    
    <div class="container">
	<div class="col-sm-12 col-md-12" style="margin-top: 5px;">
                             
		<div>
                   
                    <table class="table table-hover">
                        <tr>
                            <th class="col-sm-4 col-md-1">Sr No</th>
                            <th class="col-sm-4 col-md-2">Item Name</th>
                            <th class="col-sm-4 col-md-2">Specifications</th>
                            <th class="col-sm-4 col-md-2">Qty</th>
                            <th class="col-sm-4 col-md-2">Purpose</th>
                           
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tbody id='table'>
                        <tr>
                            <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Item Name") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Specifications") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Qty") ?></td>
                            <td class="col-sm-4 col-md-2"><?php echo odbc_result($result,"Purpose") ?></td>
                                        
                        </tr>
                       <?php $i++;}?>
                        </tbody>
                    </table>
                                                
			</div>
             </div>
    </div>
<form>
