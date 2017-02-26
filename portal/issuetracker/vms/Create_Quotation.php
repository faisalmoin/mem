
<?php
require_once 'Header.php';
require_once 'Left.php';
?>

<form action="Create_Quotation_Add.php" enctype="multipart/form-data" method="POST">
   <div class="container">	
    <div class="col-sm-4 col-md-3">
        <?php require_once 'Left.php';?>
    </div>
	<div class='col-sm-8 col-md-9'>
            <h1 class="text-primary">Quotation Details</h1>
		
                    <div class="row">
                        <div class="col-sm-6 col-md-3">Item No</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="itemno" class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">Item Name</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="itemname" class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">Quotation Price</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="sku" class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">Tax Code</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="taxcode" class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">Date</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="date" class="form-control"/></div>
                    <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div>   
                    </div>
	         </div>			
	</div>
	
	</form>
