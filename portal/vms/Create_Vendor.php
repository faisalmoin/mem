
<?php
require_once 'Header1.php';

//$SQL = "SELECT * from [VMS Item Master]";
 //$result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
   //             if(!result){
     //               exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
          //      }
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
                                                <div class="col-sm-6 col-md-3"><input type="text" name="vendor" id="vendor" class="form-control"/></div>

                                                <div class="col-sm-6 col-md-3">Vendor Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="vendorname" id="vendorname" class="form-control" id="contactperson" /></div>
                        
                                                <div class="col-sm-6 col-md-3">Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="address" id="address" class="form-control"/></div>
                                      
                        <div class="col-sm-6 col-md-3">Post Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="postcode" onkeyup="getcitystate();" class="form-control" id="postcode" onkeyup="getctystate();" /></div>
                        <div class="col-sm-6 col-md-3">City</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="city" id="city" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">State</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="state" id="state" class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">Country</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="country" id="country" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Date</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="date" id="date1"  class="form-control"/></div>
            
                              
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile" id="mobile"  onblur="checkLength(this);" class="form-control"/></div>
                        
                        
                        
                        <div class="col-sm-6 col-md-3">Email</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" id="Email"  name="email"   class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">TIN</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tin"  class="form-control"/></div>
                    
                        <div class="col-sm-6 col-md-3">CST Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="cstnumber"  class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">PAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="pan" id="pan" class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">TAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tan"  class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Service Tax Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="strn" class="form-control"/></div>
                     <div class="col-sm-6 col-md-3">CIN  Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="cin"  class="form-control"/></div>
                        <div class="col-sm-6 col-md-3">SME  Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="sme"  class="form-control"/></div>
                                                
                        <div class="col-sm-6 col-md-3">Contact Person Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactpersonmobile" id="mobile1" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Bank IFSC Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankcode" id="bankcode" class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">Bank Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankname" id="bankname" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Account Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="accountnumber" id="accountnumber" class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">RTGS Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="rtgscode"  class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Remittance Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="remittanceaddress"  class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">Requested By</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="requestedby"  class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactmobile"  id="mobile2" class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">Office Area</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="officearea" class="form-control"/></div>
                                                <div class="col-sm-6 col-md-3">Reason (New Vendor)</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="newvendorcreation" class="form-control" class="form-control"/></div>
                        
                        <div class="col-sm-6 col-md-3">Approved By</div>
                        <div class="col-sm-6 col-md-3"><input type="text" name="approvedby" class="form-control"/></div>
                                                
                                                <div class="col-sm-12 col-md-12">
                                                 <input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"  onclick="return myFunction()"/></div>
                                                </div>
                                      
                     </div> 
           </div>
     
    </div>
    <div class="col-md-1"></div>
    </div>
    </div>
</form>
<?php require_once("../footer.php");?>
<script>
                                   
function myFunction() {
   
   var textinput1 = $('#vendor').val();
   var textinput13 = $('#vendorname').val();
   var textinput2 = $('#address').val();
    var textinput3 = $('#city').val();
    var textinput4 = $('#state').val();
    var textinput5 = $('#country').val();
    var textinput6 = $('#postcode').val();
    var textinput7 = $('#mobile').val();
    var textinput8 = $('#Email').val();
    var textinput9 = $('#date1').val();
    var textinput10 = $('#bankcode').val();
    var textinput11 = $('#bankname').val();
    var textinput12 = $('#accountnumber').val();
     var textinput14 = $('#pan').val();
   
    if(textinput1=="" )
      {
      alert('pls fill vendor ');
      return false;
    }
    else if(textinput2=="")
      {
      alert('pls fill address');
      return false;
    }
    else if(textinput3=="")
      {
      alert('pls fill city');
      return false;
    }
    else if(textinput4=="")
      {
      alert('pls fill state');
      return false;
    }
    else if(textinput5=="")
      {
      alert('pls fill country');
      return false;
    }
    else if(textinput6=="")
      {
      alert('pls fill postcode');
      return false;
    }
    else if(textinput7=="")
      {
      alert('please fill mobile no');
      return false;
    }
    else if(textinput8=="")
      {
      alert('pls fill email');
      return false;
    }
    else if(textinput9=="" )
      {
      alert('pls fill date');
      return false;
    }
      else if(textinput10=="")
      {
      alert('pls fill bank IFSC code');
      return false;
    }
    else if(textinput11=="")
      {
      alert('pls fill bank name');
      return false;
    }
    else if(textinput12=="")
      {
      alert('pls fill account number');
      return false;
    }
     
     else if(textinput13=="")
      {
      alert('pls fill vendor name');
      return false;
    }
     else if(textinput14=="")
      {
      alert('pls fill PAN o');
      return false;
    }
    
}

 function getcitystate(){
            
          var postcode = $('#postcode').val();
          var datastring='textinput='+postcode;
          
                $.ajax
                ({
                    type: "POST",
                    url: "city_state_country.php",
                    data: datastring,
                    cache: false,
                    success: function(result)
                    {
                    
                      var str=result.split(",");
                      document.getElementById('city').value=str[0];
                      document.getElementById('state').value=str[1];
                      document.getElementById('country').value=str[2];
                      
                    }
                });
             }

</script>



