
<?php
require_once 'Header1.php';

 
  $SQL = "SELECT * from [VMS Vendor Master]";
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
    <div class="row">
	  <div class="col-md-1"></div>
      <div class="col-md-10"> 
             <div class="row">
                <div class="col-sm-6 col-md-8">
                    <h3 class="text-primary">Vendor's Item Details</h3>
                </div>
                <div class="col-sm-6 col-md-4"><input class="form-control" type="text" id="search" placeholder="Type to search">
                </div>
             </div>
		    <div class="row">
                 <table class="table table-hover">
                        <tr>
                            <th>Sr</th>
                            <th>Vendor Name</th>
                            <th>Address</th>   
                            <th>TIN</th>
                            <th>CST</th>
                            <th>PAN</th>
                            <th>TAN</th>
                            <th>Service Tax</th>
                            <th>Contact Person</th>
                            <th>Edit</th>
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result)){?>
                        <tbody id='table'>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo odbc_result($result,"Vendor Name") ?></td>
                            <td><?php echo odbc_result($result,"Address") ?></td>
                            <td><?php echo odbc_result($result,"TIN") ?></td>
                            <td><?php echo odbc_result($result,"CST") ?></td>
                            <td><?php echo odbc_result($result,"PAN") ?></td>
                            <td><?php echo odbc_result($result,"TAN") ?></td>
                            <td><?php echo odbc_result($result,"Service Tax Number") ?></td>
                            <td><?php echo odbc_result($result,"Contact Person Details") ?></td>
                            <td><a href="VendorItemListEdit.php?ID=<?php echo odbc_result($result, "ID")?>">Edit</a></td>                                              
                        </tr>
                       <?php $i++;}?>
                        </tbody>
                    </table>
                                              
			  </div>
            
            </div>
            <div class="col-md-1"></div>
        </div>
	</div>
	
</form>
</div>
<?php require_once("../footer.php");?>