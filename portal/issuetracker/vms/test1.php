
<?php
require_once 'Header.php';
require_once 'Left.php';
require_once("../db.txt");

$fid1=1;
$fid=str_pad($fid1,4,"0",STR_PAD_LEFT);
$qryitm="select max(ID) AS ID from [VMS Item Master]";
 $resultitm = odbc_exec($conn, $qryitm) or die(odbc_errormsg($conn));
 $ltid=odbc_fetch_array($resultitm);
 $resgtid1=$ltid['ID'];
 $resgtid=$resgtid1+1;
 $itmid=str_pad($resgtid,4,"0",STR_PAD_LEFT);
 if($itmid>=1)
 {
     $newitmid="ITM/".$itmid;
 }
 else 
     
 {
    $newitmid="ITM/".$fid;
 }

?>
<head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
 
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>
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
<script>
$(document).ready(function() {
    $('#createitem').bootstrapValidator({
         container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            itemname: {
                validators: {
                    notEmpty: {
                        message: 'Item Name is required and cannot be empty'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    },
                    email: {
                        message: 'The email address is not valid'
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
                        message: 'The title is required and cannot be empty'
                    },
                    stringLength: {
                        max: 100,
                        message: 'The title must be less than 100 characters long'
                    }
                }
            },
            content: {
                validators: {
                    notEmpty: {
                        message: 'The content is required and cannot be empty'
                    },
                    stringLength: {
                        max: 500,
                        message: 'The content must be less than 500 characters long'
                    }
                }
            }
        }
    });
});
</script>
</head>
<form action="Create_Item_Add.php" method="post" id="createitem">
    <div class="container">	
    <div class="col-sm-4 col-md-3" >
        <?php require_once 'Left.php';?>
    </div>
	<div class='col-sm-8 col-md-9'>
            

                    <div class="row">
                        <div class="col-sm-6 col-md-6"><h1 class="text-primary">Item Details</h1></div>
                        <?php if(isset($_REQUEST['message'])){
                            $msg=$_REQUEST['message'];
                            if($msg==success)
                            {?>
                                <div class="col-sm-6 col-md-6 text-success" >
                                    <h4> <strong>Success!</strong>New Item  has been added successfully.</h4>
                                </div>
                          <?php }
                        }?>
                        </div>
                    
                   
                    <div class="row">
                        <div class="row">
                            <input type="hidden" name="itemno" value="<?php echo $newitmid;?>"/>
                            <div class="col-sm-3 col-md-3">Item Name</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="itemname" class="form-control"/></div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">SKU No</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="sku" class="form-control" required=""/></div>
                            <div class="col-sm-3 col-md-3">Item Condition</div>
                            <div class="col-sm-3 col-md-3"> <select name="condition" class="form-control">
                                                                    <option value="NEW">NEW</option>
                                                                    <option value="OLD">OLD</option>
                                                             </select> </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3">Make</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="make" class="form-control" required=""/></div>
                            <div class="col-sm-3 col-md-3">Model</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="model" class="form-control" required=""/></div>
                           </div>
                           <div class="row">
                            <div class="col-sm-3 col-md-3">Sr No</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="srno" class="form-control" required=""/></div>
                            <div class="col-sm-3 col-md-3">Warranty</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="warranty" class="form-control"/></div>
                           </div>
                                             
                           <div class="row">
                             <div class="col-sm-3 col-md-3">Category</div>
                             <div class="col-sm-3 col-md-3"><input type="text" name="category" id="category"  class="form-control" required=""/>  </div>
                             <div class="col-sm-3 col-md-3">Sub Category</div>
                             <div class="col-sm-3 col-md-3"><input type="text" name="subcategory" id="subcategory" class="form-control" required=""/></div>
                           </div>
                           <div class="row">
                            <div class="col-sm-3 col-md-3">Item Description</div>
                            <div class="col-sm-3 col-md-3"><textarea class="form-control" rows="2" name="itemdescription" required=""></textarea></div>
                            <div class="col-sm-3 col-md-3">Item Specifications</div>
                            <div class="col-sm-3 col-md-3"><input type="text" class="form-control" rows="2" name="specifications" required=""></textarea></div>
                          
                           </div>
                          
                           <div class="row">
                            <div class="col-sm-3 col-md-3">Unit Of Measurement</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="uom" id="uom" class="form-control" required=""/></div>
                           
                           </div>
                        
                            <div class="row">

                            <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div> 
                            </div>
                        
	     			
	</div>
        </div>
    </div>
</form>
   

