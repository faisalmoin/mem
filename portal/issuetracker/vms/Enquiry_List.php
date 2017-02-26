
<?php
require_once 'Header1.php';
 
  $SQL = "SELECT * from [VMS Item Master]";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		
?>

<div class="container">
<form action="Principal_Approval_Add.php" enctype="multipart/form-data" method="POST">
    <div class="container">
        
        <div class="row">
            <div class="col-xs-10 col-md-10">             
                        <div class="col-sm-12 col-md-12"><h1 class="text-primary">Requisition</h1></div>
                        <?php if(isset($_REQUEST['message'])){
                            $msg=$_REQUEST['message'];
                            if($msg==success)
                            {?>
                                <div class="col-sm-6 col-md-6 text-success" >
                                    <h4> <strong>Success!</strong>New Requisition  has been added.</h4>
                                </div>
                          <?php }
                           if($msg==failure)
                            {?>
                                <div class="col-sm-6 col-md-6 text-danger" >
                                    <h4> <strong>Error!</strong> No Data has been added.</h4>
                                </div>
                          <?php }
                        }?>
            </div>
            <div class="col-xs-2 col-md-2">
                <a href="Item_Enquiry.php" class="btn btn-warning">New Requisition</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                        <ul class="nav nav-tabs" id="Enq">
                           <li class="active"><a href="#EnqTab1" data-toggle="tab">Approved</a></li>
                           <li><a href="#EnqTab2" data-toggle="tab">Pending</a></li>
                           <li><a href="#EnqTab3" data-toggle="tab">Rejected</a></li>
                          
                           
                       </ul>

                       <div class="tab-content" id="EnqContent">
                           <div class="tab-pane face in active" id="EnqTab1">
                                   <?php require_once("Enquiry_Approved.php") ?>
                           </div>
                           <div class="tab-pane face in" id="EnqTab2">
                                   <?php require_once("Enquiry_Pending.php") ?>
                           </div>
                           <div class="tab-pane face in " id="EnqTab3">
                                   <?php require_once("Enquiry_Rejected.php"); ?>
                           </div>
                              <div class="tab-pane face in " id="EnqTab4">
                                   <?php require_once("Enquiry_New.php"); ?>
                           </div>                      
                       </div>

            </div>
        </div>
	
    </div>
	
</form>
</div>

<?php require_once "../footer.php"?>
