
<form action="Enquiry_NewAdd.php" enctype="multipart/form-data" method="POST">

	<div class='col-sm-8 col-md-9'>
             
            
            <div class="row" style="margin-top: 5px;">
                                                 <div class="col-sm-6 col-md-3">Item Name</div>
                                                 <div class="col-sm-6 col-md-3"><input type="text" name="itemname" class="form-control"/></div>
                                                 <div class="col-sm-6 col-md-3">Specifications</div>
                                                 <div class="col-sm-6 col-md-3"><input type="text" name="specifications" class="form-control"/></div>
						 <div class="col-sm-6 col-md-3">Qty</div>
						 <div class="col-sm-6 col-md-3"><input type="text" name="qty" class="form-control"/></div>
                                                 <div class="col-sm-6 col-md-3">Request By</div>
                                                 <div class="col-sm-6 col-md-3">
                                                    <select class="form-control" id="requestby" name="requestby" class="input-small" >
                                                            <option value="Teacher">Teacher</option>
                                                            <option value="principal">Principal</option>
                                                            <option value="accountant">Accountant</option>
                                                    </select>
                                                </div>
                                                 <div class="col-sm-6 col-md-3">Purpose/description</div>
						 <div class="col-sm-6 col-md-3"> <textarea class="form-control" rows="2" name="purpose"></textarea></div>
                                                 
						 <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div> 
						
						
			</div>			
        </div>
    
    
    
    
    
    
    
    
    
    
</div>
</form>