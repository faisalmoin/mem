
<?php
require_once 'Header1.php';

  $SQL = "SELECT * from [VMS Item Master]";
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
<form action="Principal_Approval_Add.php" enctype="multipart/form-data" method="POST">
    
   <div class="container">
     <div class="row">
               
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                          <h3 class="text-primary">Item List</h3>
                        </div>
                        <div class="col-md-4">
                          <input class="form-control" type="text" id="search" placeholder="Type to search">
                        </div>
                     </div>
     
                  <div class="row"> 
                    <div class="col-md-12">          
                    <table style="border: 1px solid #d3d3d3; border-style: dashed;" class="table table-hover">
                        <tr>
                                <th>Sr</th>
                                <th>Item Name</th>
                                <th>Item No</th>
                                <th>SKU No</th>
                                <th>Condition</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Sr No</th>
                                <th>Warranty</th>
                                <th>Description</th>
                                <th>Specification</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Edit</th>
                            </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tbody id='table'>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo odbc_result($result,"Item Name") ?></td>
                            <td><?php echo odbc_result($result,"Item No") ?></td>
                            <td><?php echo odbc_result($result,"SKU No") ?></td>
                            <td><?php echo odbc_result($result,"Condition") ?></td>
                            <td><?php echo odbc_result($result,"Make") ?></td>
                            <td><?php echo odbc_result($result,"Model") ?></td>
                            <td><?php echo odbc_result($result,"Sr No") ?></td>
                            <td><?php echo odbc_result($result,"warranty") ?></td>
                            <td><?php echo odbc_result($result,"Description") ?></td>
                            <td><?php echo odbc_result($result,"Specifications") ?></td>
                            <td><?php echo odbc_result($result,"Category") ?></td>
                            <td><?php echo odbc_result($result,"Sub Category") ?></td>
                            <td><a href="Item_List_Edit.php?ID=<?php echo odbc_result($result, "ID")?>">Edit</a></td>    
                                  
                        </tr>
                       <?php $i++;}?>
                        </tbody>
                    </table>
                    </div>                    
	           </div>
                </div>   
          
          </div>
   </div>
</form>
</div>
<?php require_once("../footer.php");?>