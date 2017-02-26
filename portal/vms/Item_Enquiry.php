
<?php
include 'Header1.php';

?>


<script>
    $(document).ready(function() {
    $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $("#qty").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});

</script>

<div class="container">
<form action="Item_Enquiry_Add.php" enctype="multipart/form-data" method="POST">
    
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="border: 1px solid #eee;">
                <div class="row">
                    <div class='col-sm-12 col-md-12'>
                        <div class="row">
                            <div class="col-sm-12 col-md-12"><h1 class="text-primary">New Requisition</h1></div>
                            <?php if(isset($_REQUEST['message'])){
                                $msg=$_REQUEST['message'];
                                if($msg==success)
                                {?>
                                    <div class="col-sm-12 col-md-12 text-success" >
                                        <h4> <strong>Success!</strong>New Requisition added.</h4>
                                    </div>
                              <?php }
                               if($msg==failure)
                                {?>
                                    <div class="col-sm-12 col-md-12 text-danger" >
                                        <h4> <strong>Error!</strong> No Data Added.</h4>
                                    </div>
                              <?php }
                            }?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">Item Name</div>
                    <div class="col-sm-8 col-md-8"><input type="text" name="itemname" class="form-control"/></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">Specifications</div>
                    <div class="col-sm-8 col-md-8"><input type="text" name="specifications" class="form-control"/></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">Qty</div>
                    <div class="col-sm-8 col-md-8"><input type="text" name="qty" id="qty" class="form-control"/></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">Request By</div>
                    <div class="col-sm-8 col-md-8">
                        <select class="form-control" id="requestby" name="requestby" class="input-small" >
                            <option value="Teacher">Teacher</option>
                            <option value="Principal">Principal</option>
                            <option value="Accountant">Accountant</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">Purpose / Description</div>
                    <div class="col-sm-8 col-md-8"> <textarea class="form-control" rows="2" name="purpose"></textarea></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-8 col-md-8 ">                
                        <input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/>
                    </div> 
                </div>			
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
	
</form>
</div> 
<?php require_once("../footer.php");?>