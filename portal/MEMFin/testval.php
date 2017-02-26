<?php
require_once 'Header.php';
//require_once 'Left.php';
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

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>
<script>
$(document).ready(function() {
    $('#Form').bootstrapValidator({
        err: {
            container: function($field, validator) {
               
                return $field.parent().next('.messageContainer');
            }
        },
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            itemname: {
                       
                validators: {
                    notEmpty: {
                        message: 'Item Name is required'
                    }
                
            }
            },
          
            sku: {
                validators: {
                    notEmpty: {
                        message: 'SKU No is required'
                    }
                    
                }
            },
            srno: {
                validators: {
                    notEmpty: {
                        message: 'Sr No is required'
                    }
                    
                }
            },
             category: {
                validators: {
                    notEmpty: {
                        message: 'Category is required'
                    }
                }
            },
            subcategory: {
                validators: {
                    notEmpty: {
                       message: 'Sub Category is required'
                    }
                }
            },
            warranty: {
                validators: {
                    notEmpty: {
                        message: 'Warranty is required'
                    },
                    stringLength: {
                        max: 2,
                        message: 'Warranty  up to two digits'
                    }
                }
            },
              specifications: {
                validators: {
                    notEmpty: {
                        message: 'Specification is required'
                    }
                }
            },
            
        }
    });
/*
$("#warranty").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
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
       
         */    




/*
    $(function()
    {
        var availableTags = [ <--?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT[Item category] FROM [VMS Item Category Master] ");
                while(odbc_fetch_array($City_Tag1)){
                    echo "'". odbc_result($City_Tag1, "Item Category")."', ";
                }
               
                          
            ?> ];

       
        $( "#category").autocomplete({
            source: availableTags
        });
    });*/

  });
    
   
</script>
</head>
<form action="" id="Form" method="post" class="form-horizontal">
   <div class="container">	
    <div class="col-sm-4 col-md-3" >
      
    </div>
	<div class='col-sm-8 col-md-9'>
            
                    <div class="col-md-9">
                                <div id="messages"></div>
                     </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6"><h1 class="text-primary">Add Item</h1></div>
                        <?php if(isset($_REQUEST['message'])){
                            $msg=$_REQUEST['message'];
                            if($msg==success)
                            {?>
                                <div class="col-sm-6 col-md-6 text-success" >
                                    <h4> <strong>Success!</strong>New Item  has been added successfully.</h4>
                                </div>
                          <?php }
                        
                          if($msg==fail)
                            {?>
                                <div class="col-sm-6 col-md-6 text-danger" >
                                    <h4> <strong>Fail!  </strong>New Item  Not added.<br/> SKU No should be unique</h4>
                                </div>
                          <?php }
                            }?>
                        </div>
                    
                   
                    <div class="form-group">
                        
                            <input type="hidden" name="itemno" value="<?php echo $newitmid;?>"/>
                            <div class="col-sm-3 col-md-3">Item Name</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="itemname" class="form-control"/></div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-md-3">SKU No</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="sku" class="form-control" /></div>
                            <div class="col-sm-3 col-md-3">Item Condition</div>
                            <div class="col-sm-3 col-md-3"> <select name="condition" class="form-control">
                                                                    <option value="NEW">NEW</option>
                                                                    <option value="OLD">OLD</option>
                                                             </select> </div>
                            
                        </div>
                         <div class="form-group">
                            <div class="col-sm-3 col-md-3">Make</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="make" class="form-control" /></div>
                            <div class="col-sm-3 col-md-3">Model</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="model" class="form-control" /></div>
                           </div>
                           <div class="form-group">
                            <div class="col-sm-3 col-md-3">Sr No</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="srno" class="form-control" /></div>
                            <div class="col-sm-3 col-md-3">Warranty</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="warranty" id="warranty" class="form-control"/></div>
                           </div>
                                             
                           <div class="form-group">
                             <div class="col-sm-3 col-md-3">Category</div>
                             <div class="col-sm-3 col-md-3"><input type="text" name="category" id="category"  class="form-control" />  </div>
                             <div class="col-sm-3 col-md-3">Sub Category</div>
                             <div class="col-sm-3 col-md-3"><input type="text" name="subcategory" id="subcategory" class="form-control" /></div>
                           </div>
                           <div class="form-group">
                            <div class="col-sm-3 col-md-3">Item Description</div>
                            <div class="col-sm-3 col-md-3"><textarea class="form-control" rows="2" name="itemdescription" ></textarea></div>
                            <div class="col-sm-3 col-md-3">Item Specifications</div>
                            <div class="col-sm-3 col-md-3"><input type="text" class="form-control" rows="2" name="specifications" ></textarea></div>
                          
                           </div>
                          
                           <div class="form-group">
                            <div class="col-sm-3 col-md-3">Unit Of Measurement</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="uom" id="uom" class="form-control" /></div>
                           
                           </div>
           <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <input type="submit" name="item" id="item" value="Submit" class="btn btn-primary">
        </div>
    </div>
            
                   
                    </div>
        </div>
</form>