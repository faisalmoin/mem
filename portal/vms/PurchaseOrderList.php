
<?php
require_once 'Header1.php';

  $SQL = "SELECT * from [VMS Create PO] WHERE [Company Name]='".$CompName."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>
<head>
   <script>
$(document).ready(function(){
	

var $rows = $('#table tr');

$('#search').keyup(function() {
		
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
	
	});

});

		</script>
</head>
<div class="container">
<form action="" enctype="multipart/form-data" method="POST">
    
   <div class="container">
	<div class="row" style="padding-top:50px;">
		<div class="col-sm-6 col-md-6 text-primary">
			<h4>Purchase Order List</h4>
		</div>
		<div class="col-sm-4 col-md-4">
			<input class="form-control" type="text" id="search" placeholder="Type to search">
		</div>
		<div class="col-sm-2 col-md-2">
			<a href="Create_PO_Order.php" class="btn btn-warning">New Purchase Order</a>
		</div>
	</div>
                    <table class="table table-hover">
                        <tr>
                             <th>Sr</th>
                             <th>PO No.</th>
                             <th>PO Date</th>
                             <th>Vendor</th>
                             <th>Total Amount</th>
                             <th style="text-align: right;">PO Status</th>
                             <th>View</th>                          
                             <th>Edit</th>
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tbody id='table'>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo odbc_result($result,"PO No") ?></td>
                           <td><?php  echo date('d/M/Y', odbc_result($result, "Purchase Date")) ?></td>
                            <td><?php echo odbc_result($result,"Vendor") ?></td>
                           
                            <?php  $finalq="select* from [VMS Final PO] where [PO ID]='".odbc_result($result, "ID")."'";
                              $resultfinal = odbc_exec($conn, $finalq) or die(odbc_errormsg($conn));
         ?>
                            <td><?php echo odbc_result($resultfinal,"Gtotal") ?></td>
                         

                            <td align="right"><?php echo odbc_result($result,"PO Status") ?></td>
                            
                                      
                          <td><a href="PurchaseOrderListView.php?ID=<?php echo odbc_result($result, "ID")?>">View</a></td>  
                           <td><a href="PurchaseOrderListEdit.php?ID=<?php echo odbc_result($result, "ID")?>">Edit</a></td>                                              
                        </tr>
                       <?php $i++;}?>
                        </tbody>
                    </table>
                  
    </div>	
</form>
</div>
<?php require_once("../footer.php");?>