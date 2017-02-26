
<?php
require_once 'Header.php';
require_once 'Left.php';
?>

<form action="Item_Category_Master_Add.php" enctype="multipart/form-data" method="POST">
    
    <div class="container">
    <div class="col-sm-4 col-md-3" >
        <?php require_once 'Left.php';?>
    </div>
	<div class='col-sm-8 col-md-9'>
            <h1 class="text-primary">Create Category</h1>
            <div class="row">
                                                 <div class="col-sm-6 col-md-3">Category</div>
                                                 <div class="col-sm-6 col-md-3"><input type="text" name="category" class="form-control"/></div>
                                                 
						 <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div> 
						
						
			</div>			
        </div>
	</div>
	
	
	
</form>
