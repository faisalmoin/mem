
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

                 $('#Email').blur(function() {

                    var emailID = this.value;
                     atpos = emailID.indexOf("@");
                     dotpos = emailID.lastIndexOf(".");
                     
                     if (atpos < 1 || ( dotpos - atpos < 2 )) 
                     {
                        alert("Please enter correct email ID");
                        document.myForm.Email.focus() ;
                        return false;
                     }
                     return( true );
                        });
                 

                    $("#mobile").keypress(function (e) {

     
                         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            
                            $("#errmsg").html("Digits Only").show().fadeOut("slow");
                                   return false;
                        }
                       });
                  
                     $("#mobile1").keypress(function (e) {
                       
     
                         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            
                            $("#errmsg").html("Digits Only").show().fadeOut("slow");
                                   return false;
                        }
                       });
                           $("#mobile2").keypress(function (e) {
                       
     
                         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            
                            $("#errmsg").html("Digits Only").show().fadeOut("slow");
                                   return false;
                        }

                       });
                           
                  
                    $(function() {
                           
                    	  $("#date1").datepicker({ minDate: 0,});
                    		$("#dt1").datepicker({ 
                    			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
                    			minDate:0,
                    			//maxDate: 0, 
                    			changeMonth: true, 
                    			changeYear: true
                    		});
                      
                      });

                  
  
         });
  </script>

<script>
function myFunction() {
    var x = document.getElementById("mySelect").value;
    document.getElementById("demo").innerHTML = "You selected: " + x;
}
</script>
</head>
<br/><br/><br/>
<form action="Create_Vendor_Add.php" enctype="multipart/form-data" method="POST">
      
               <div class="container">
                 <div class="row">
                   <div class="col-md-1"></div>
                 <div class="row">
	                <div class='col-sm-10 col-md-10'>
                           <div class="row">
                        <div class="col-sm-6 col-md-6"><h3 class="text-primary">Vendor Details</h3></div>
                        <?php if(isset($_REQUEST['message'])){
                            $msg=$_REQUEST['message'];
                            if($msg==success)
                            {?>
                                <div class="col-sm-6 col-md-6 text-success" >
                                    <h4> <strong>Success!</strong>New Vendor  has been added successfully.</h4>
                                </div>
                          <?php }
                        }?>
                        </div>
                            <div class="tab-content" id="VendorContent" style="padding-top: 10px;">
                                 <div class="tab-pane face in active" id="VendorTab1">
                   
						<div class="col-sm-6 col-md-3">Vendor </div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="vendorname" required="" class="form-control"/></div>

                                                <div class="col-sm-6 col-md-3">Vendor Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactperson" required="" class="form-control"/></div>
						
                                                <div class="col-sm-6 col-md-3">Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="address" required="" class="form-control"/></div>
					                  
                        <div class="col-sm-6 col-md-3">Post Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="postcode" required="" class="form-control"  onkeyup="getctystate();" /></div>
						<div class="col-sm-6 col-md-3">City</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="city" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">State</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="state" required="" class="form-control"/></div>
						<div class="col-sm-6 col-md-3">Country</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="country" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Date</div>
                                                <div class="col-sm-6 col-md-3"><input type="date" name="date" id="date1"  class="form-control"/></div>
			
                              
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile" id="mobile" required="" onblur="checkLength(this);" class="form-control"/></div>
						
						
						
						<div class="col-sm-6 col-md-3">Email</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" id="Email"  name="email" required=""  class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">TIN</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tin" required="" class="form-control"/></div>
					
						<div class="col-sm-6 col-md-3">CST Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="cstnumber" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">PAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="pan" required="" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">TAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tan" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Service Tax Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="strn" class="form-control"/></div>
					 <div class="col-sm-6 col-md-3">CIN  Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="cin" required="" class="form-control"/></div>
						<div class="col-sm-6 col-md-3">SME  Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="sme" required="" class="form-control"/></div>
                                                
						<div class="col-sm-6 col-md-3">Contact Person Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactpersondetails" id="mobile1"required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Bank IFSC Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankcode" required="" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">Bank Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankname" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Account Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="accountnumber" required="" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">RTGS Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="rtgscode" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Remittance Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="remittanceaddress" required="" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">Requested By</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="requestedby" required="" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile" required="" id="mobile2" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">Office Area</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="officearea" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Reason (New Vendor)</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="newvendorcreation" class="form-control" class="form-control"/></div>
						
						<div class="col-sm-6 col-md-3">Approved By</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="approvedby" class="form-control"/></div>
                                                
                                                <div class="col-sm-12 col-md-12">
                                                 <input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div>
                                                </div>
                                      
                     </div>	
           </div>
     
	</div>
    <div class="col-md-1"></div>
	</div>
    </div>
</form>
<?php require_once("../footer.php");?>