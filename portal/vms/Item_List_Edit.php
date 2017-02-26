<?php

 $id=$_REQUEST['ID'];
require_once 'Header1.php';
require_once 'permission.php';

$selectitem="select * from [VMS Item Master] WHERE ID='".$id."'";
$resultitem = odbc_exec($conn, $selectitem) or die(odbc_errormsg($conn));

?>
<head>
    <script type="text/javascript">
    $(document).ready( function ()
    {
  	$('#category').change(function()
	{
           var textinput = $('#category').val();
              
            var dataString = 'id='+ textinput;	
		 
                $.ajax
                ({
                    type: "POST",
                    url: "get_category.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                       
                        $("#subcategory").html(html);
                    }
                });
            });
       
             
});



 
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT[Item category] FROM [VMS Item Category Master] ");
                while(odbc_fetch_array($City_Tag1)){
                    echo "'". odbc_result($City_Tag1, "Item Category")."', ";
                }
               
                          
            ?> ];

       
        $( "#category").autocomplete({
            source: availableTags
        });
    });

 
    
   
</script>

</head>
<form action="Item_List_Update.php?id=<?php echo $id; ?>" method="post">
    <div class="container">	
           <div class="row">
	              <div class='col-md-1'></div>
                      <div class="col-md-10">
                          <div class="row">
                            <div class="col-sm-12 col-md-12"><h1 class="text-primary">Item Details</h1></div>
                          </div>
                          <div class="row">
                              <div class="col-sm-3 col-md-3">Item No</div>
                              <div class="col-sm-3 col-md-3"><input type="text"   name="itemno" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Item No") ?>"/></div>
                              <div class="col-sm-3 col-md-3">Item Name</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="itemname" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Item Name") ?>"/></div>
                          </div>
                          <div class="row">
                              <div class="col-sm-3 col-md-3">SKU No</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="sku" class="form-control" required="" value="<?php echo odbc_result($resultitem, "SKU No") ?>"/></div>
                              <div class="col-sm-3 col-md-3">Item Condition</div>
                              <div class="col-sm-3 col-md-3"> <select name="condition" class="form-control">
                                                                      <option <?php if(odbc_result($resultitem, "Condition")=="NEW") { echo 'selected ';} ?> value="NEW">NEW</option>
                                                                      <option <?php if(odbc_result($resultitem, "Condition")!="NEW") { echo 'selected ';} ?> value="OLD">OLD</option>
                                                              </select> </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-3 col-md-3">Make</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="make" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Make") ?>"/></div>
                              <div class="col-sm-3 col-md-3">Model</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="model" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Model") ?>"/></div>
                          </div>
                          <div class="row">
                              <div class="col-sm-3 col-md-3">Sr No</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="srno" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Sr No") ?>"/></div>
                              <div class="col-sm-3 col-md-3">Warranty</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="warranty" class="form-control" value="<?php echo odbc_result($resultitem, "Warranty") ?>"/></div>
                          </div>

                          <div class="row">
                               <div class="col-sm-3 col-md-3">Category</div>
                               <div class="col-sm-3 col-md-3"><input type="text" name="category" id="category"  class="form-control" required="" value="<?php echo odbc_result($resultitem, "Category") ?>"/>  </div>
                               <div class="col-sm-3 col-md-3">Sub Category</div>
                               <div class="col-sm-3 col-md-3"><input type="text" name="subcategory" id="subcategory" class="form-control" required="" value="<?php echo odbc_result($resultitem, "Sub Category") ?>"/></div>
                          </div>
                          <div class="row">
                              <div class="col-sm-3 col-md-3">Item Description</div>
                              <div class="col-sm-3 col-md-3"><textarea class="form-control" rows="2" name="itemdescription" required="" value="<?php echo odbc_result($resultitem, "Description") ?>"><?php echo odbc_result($resultitem, "Description") ?></textarea></div>
                              <div class="col-sm-3 col-md-3">Item Specifications</div>
                              <div class="col-sm-3 col-md-3"><input type="text" class="form-control" rows="2" name="specifications" required="" value="<?php echo odbc_result($resultitem, "Specifications") ?>"></textarea></div>

                           </div>

                           <div class="row">
                              <div class="col-sm-3 col-md-3">Unit Of Measurement</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="uom" id="uom" class="form-control" required="" value="<?php echo odbc_result($resultitem, "UOM") ?>"/></div>

                          </div>
                          <div class="row">

                              <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="Update" align="center"/></div> 
                          </div>

                      </div>
                      <div class='col-md-1'></div>
                 </div>
    </div>
               
</form>
   <?php require_once("../footer.php");?>

