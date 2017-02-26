
<?php
$id=$_REQUEST['ID'];
require_once 'Header1.php';


$SQL = "SELECT * from [VMS Vendor Master] WHERE ID='".$id."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
?>

<head>
    
     <script type="text/javascript">
    function specifications(id)
    {
  // alert(id);
         
         var textinput = $('#specifications'+id).val();

            var datastring='textinput='+textinput+'&itemid='+id;
           //alert(datastring);
                $.ajax
                ({
                    type: "POST",
                    url: "SearchItemSpecifications.php",
                    data: datastring,
                    cache: false,
                    success: function(result)
                    {
                        //alert(result);
                      var str=result.split(",");
                      document.getElementById('make'+str[3]).value=str[0];
                      document.getElementById('model'+str[3]).value=str[1];
                      document.getElementById('warranty'+str[3]).value=str[2];
                      
                     
                    }
                });
     }
</script>



        <script>
            $(document).ready(function(){


            var $rows = $('#table tr');

            $('#search').keyup(function() {

                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

                $rows.show().filter(function() {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();

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

<form action="VendorItemListUpdate.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="POST">
    
   
       <div class="container">
         <div class="row">
           <div class="col-md-1"></div>
           <div class='col-md-10'>
               <div class="row">
                        <div class="col-md-12">
                          <h3 class="text-primary">Vendor Details</h3>
                        </div>
                       
                     </div>
               <div class="row">
                                             
					                                      <div class="col-sm-6 col-md-3">Vendor Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="vendorname" required="" value="<?php echo odbc_result($result, "Vendor Name") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="address" required="" value="<?php echo odbc_result($result, "Address") ?>"/></div>
					</div>
					<div class="row">                                
                                                <div class="col-sm-6 col-md-3">City</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="city" required="" value="<?php echo odbc_result($result, "City") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">State</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="state" required="" value="<?php echo odbc_result($result, "State") ?>"/></div>
                                                </div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">Country</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="country" required="" value="<?php echo odbc_result($result, "Country") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Date</div>
                                                <div class="col-sm-6 col-md-3"><input type="date" name="date" id="date1" required="" value="<?php echo date('d/M/Y', odbc_result($result, "Date")) ?>"/></div>
			</div>
          <div class="row"> 
                                                
					                                     <div class="col-sm-6 col-md-3">Post Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="postcode" required="" value="<?php echo odbc_result($result, "Post Code") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile" required="" value="<?php echo odbc_result($result, "Mobile") ?>"/></div>
						
						</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">Email</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="email" required="" value="<?php echo odbc_result($result, "Email") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">TIN</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tin" required="" value="<?php echo odbc_result($result, "TIN") ?>"/></div>
					</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">CST Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="cst" required="" value="<?php echo odbc_result($result, "CST") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">PAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="pan" required="" value="<?php echo odbc_result($result, "PAN") ?>"/></div>
						</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">TAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tan" required="" value="<?php echo odbc_result($result, "TAN") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Service Tax Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="stn" value="<?php echo odbc_result($result, "Service Tax Number") ?>"/></div>
					</div>
            
         
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">SME  Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="sme" required="" value="<?php echo odbc_result($result, "SME") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Contact Person Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactperson" required="" value="<?php echo odbc_result($result, "Contact Person Details") ?>"/></div>
						</div>
          <div class="row"> 
						                                     <div class="col-sm-6 col-md-3">Contact Person Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactpersondetails" required="" value="<?php echo odbc_result($result, "Contact details") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankcode" required="" value="<?php echo odbc_result($result, "Bank code") ?>"/></div>
						</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">Bank Name</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankname" required="" value="<?php echo odbc_result($result, "Bank Name") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Account Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankaccountnumber" required="" value="<?php echo odbc_result($result, "Bank Account Number") ?>"/></div>
						</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">RTGS Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="rtgscode" required="" value="<?php echo odbc_result($result, "RTGS Code")?>"/></div>
                                                <div class="col-sm-6 col-md-3">Remittance Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="remittanceaddress" required="" value="<?php echo odbc_result($result, "remittance Address") ?>"/></div>
						</div>
          <div class="row"> 
						                                    <div class="col-sm-6 col-md-3">Requested By</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="requestedby" required="" value="<?php echo odbc_result($result, "Requested By") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="remittancemobile" required="" value="<?php echo odbc_result($result, "Mobile") ?>"/></div>
						</div>
          <div class="row"> 
                                    						<div class="col-sm-6 col-md-3">Office Area</div>
                                    						<div class="col-sm-6 col-md-3"><input type="text" name="officearea" value="<?php echo odbc_result($result, "Office Area") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">Reason (New Vendor)</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="newvendor" value="<?php echo odbc_result($result, "Reason New Vendor")?>"/></div>
						</div>
          <div class="row"> 
                                  						<div class="col-sm-6 col-md-3">Approved By</div>
                                  						<div class="col-sm-6 col-md-3"><input type="text" name="approvedby" value="<?php echo odbc_result($result, "Approved By") ?>"/></div>
                                                <div class="col-sm-6 col-md-3">CIN Number</div>
                                              <div class="col-sm-6 col-md-3"><input type="text" name="cin" value="<?php echo odbc_result($result, "CIN") ?>"/></div>
          </div>
          <div class="row"> 
                                                <div class="col-sm-12 col-md-12">
                                                 <input class="btn btn-primary" type="submit" name="submit" value="Update" align="center" /></div>
                                                </div>
                                      
                     </div>
                      <div class="col-md-1"></div>	
           </div>
     
	
	</div>
</form>
<?php require_once("../footer.php");?>