
<?php
require_once 'Header.php';
require_once 'Left.php';
require_once("../db.txt");
$SQL = "SELECT * from [VMS Item Master]";
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
<form action="Create_Vendor_Add.php" enctype="multipart/form-data" method="POST">
    
   
               
	        <div class='col-sm-8 col-md-9'>
                            <h1 class="text-primary">Vendor's Details</h1>
                                <ul class="nav nav-tabs" id="Vendor">
                                  <li class="active"><a href="#VendorTab1" data-toggle="tab">Vendor Details</a></li>
                                  <li><a href="#VendorTab2" data-toggle="tab">Item Details</a></li>
                                  <!--<li><a href="#VendorTab3" data-toggle="tab">Quotation</a></li>-->
                                </ul>
                            <div class="tab-content" id="VendorContent" style="padding-top: 10px;">
                                 <div class="tab-pane face in active" id="VendorTab1">
                   
						<div class="col-sm-6 col-md-3">Vendor Name</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="vendorname"/></div>
                                                <div class="col-sm-6 col-md-3">Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="address"/></div>
					
						<div class="col-sm-6 col-md-3">City</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="city"/></div>
                                                <div class="col-sm-6 col-md-3">State</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="state"/></div>
						
						<div class="col-sm-6 col-md-3">Post Code</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="postcode"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile"/></div>
						
						<div class="col-sm-6 col-md-3">Item Description</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="itemdescription"/></div>
                                                <div class="col-sm-6 col-md-3">Category Of Vendor</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="categoryofvendor"/></div>
						
						<div class="col-sm-6 col-md-3">Email</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="email"/></div>
                                                <div class="col-sm-6 col-md-3">TIN</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="tin"/></div>
					
						<div class="col-sm-6 col-md-3">CST Number</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="cstnumber"/></div>
                                                <div class="col-sm-6 col-md-3">PAN Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="pan"/></div>
						
						<div class="col-sm-6 col-md-3">TAN Number</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="tan"/></div>
                                                <div class="col-sm-6 col-md-3">Service Tax Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="strn"/></div>
					
						<div class="col-sm-6 col-md-3">SME  Number</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="sme"/></div>
                                                <div class="col-sm-6 col-md-3">Contact Person details</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="contactperson"/></div>
						
						<div class="col-sm-6 col-md-3">Contact Details</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="contactpersondetails"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Code</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="bankcode"/></div>
						
						<div class="col-sm-6 col-md-3">Bank Name</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="bankname"/></div>
                                                <div class="col-sm-6 col-md-3">Bank Account Number</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="accountnumber"/></div>
						
						<div class="col-sm-6 col-md-3">RTGS Code</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="rtgscode"/></div>
                                                <div class="col-sm-6 col-md-3">Remittance Address</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="remittanceaddress"/></div>
						
						<div class="col-sm-6 col-md-3">Requested By</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="requestedby"/></div>
                                                <div class="col-sm-6 col-md-3">Mobile</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="mobile"/></div>
						
						<div class="col-sm-6 col-md-3">Office Area</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="officearea"/></div>
                                                <div class="col-sm-6 col-md-3">Reason (New Vendor)</div>
                                                <div class="col-sm-6 col-md-3"><input type="text" name="newvendorcreation"/></div>
						
						<div class="col-sm-6 col-md-3">Approved By</div>
						<div class="col-sm-6 col-md-3"><input type="text" name="approvedby"/></div>
                                                <div class="col-sm-6 col-md-3">Date</div>
                                                <div class="col-sm-6 col-md-3"><input type="date" name="date" id="date1"/></div>
					
                                              
                                        </div>		
                                        <div class="tab-pane face in" id="VendorTab2" style="padding-top: 5px;">
                                            <div class="row"><div class='col-sm-6 col-md-6'><h4 class="text-primary">Item List</h4></b></div> <div class='col-sm-2 col-md-2'><b>Type To Search:</b></div><div class='col-sm-4 col-md-4'><input class="form-control" type="text" id="search" placeholder="Type to search"></div></div>
                                            <table >
                                                 <tr>
                                                     <th class="col-sm-4 col-md-1">Sr No</th>
                                                      <th class="col-sm-4 col-md-1">Select</th>
                                                     <th class="col-sm-4 col-md-1">Item Name</th>
                                                     <th class="col-sm-4 col-md-1">Specifications</th>
                                                     <th class="col-sm-4 col-md-2">Make</th>
                                                     <th class="col-sm-4 col-md-2">Model</th>
                                                     <th class="col-sm-4 col-md-1">Warranty</th>
                                                     <th class="col-sm-4 col-md-2">Price</th>
                                                     <th class="col-sm-4 col-md-1">Tax</th>
                                                 </tr>
                                                <?php $i=1;while(odbc_fetch_array($result)){?>
                                                 <tbody id='table'>
                                                     <tr id="<?php echo odbc_result($result,"ID")?>">
                                                         <td class="col-sm-4 col-md-1"><?php echo $i; ?></td>
                                                         <td class="col-sm-4 col-md-1"><input type="checkbox" name="selectitem<?php echo $i?>" value="<?php echo odbc_result($result,"ID")?>" id="inlineCheckbox1"></td>
                                                         <td class="col-sm-4 col-md-1"><?php echo odbc_result($result,"Item Name") ?></td>
                                                         <input type="hidden" name="itemname<?php echo $i?>" value="<?php echo odbc_result($result,"Item Name")?>"/>
                                                         <td class="col-sm-4 col-md-1">
                                                             <select name="specifications<?php echo $i?>" class="form-control" id="specifications<?php echo odbc_result($result,"ID")?>" onchange="specifications(<?php echo odbc_result($result,"ID")?>)" >
                                                             <?php echo $SQL1 = "SELECT [ID], [Specifications],[Item ID] from [VMS Specifications Master] WHERE [Item ID]='".odbc_result($result,"ID")."'";
                                                               $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn)) or die(odbc_errormsg($conn));
                                                              echo '<option value="">-select-</option>';
                                                               while(odbc_fetch_array($result1)){
                                                                   //echo "ID: ".odbc_result($result1, "ID"). " // Specification".odbc_result($result1, "Specifications")."<br />";
                                                                   
                                                                   echo '<option value="'.odbc_result($result1,"ID").'">'.odbc_result($result1,"Specifications").'</option>';
                                                               }
                                                             ?>
                                                             </select>
                                                             <input type="hidden" name="hiddenitemid" value="<?php echo odbc_result($result,"Item ID") ?>"/>
                                                        </td>
                        
                                                        <td class="col-sm-4 col-md-2"><input type="textbox" name="make<?php echo $i?>"  id="make<?php echo odbc_result($result,"ID") ?>"class="form-control" readonly=""/></td>
                                                        <td class="col-sm-4 col-md-2"><input type="textbox" name="model<?php echo $i?>" id="model<?php echo odbc_result($result,"ID") ?>" class="form-control" readonly=""/></td>
                                                        <td class="col-sm-4 col-md-1"><input type="textbox" name="warranty<?php echo $i?>" id="warranty<?php echo odbc_result($result,"ID") ?>" class="form-control" readonly=""/></td>
                                                         <td class="col-sm-4 col-md-2"><input type="textbox" name="price<?php echo $i?>" class="form-control"/></td>
                                                         <td class="col-sm-4 col-md-1"><input type="textbox" name="taxcode<?php echo $i?>" class="form-control"/></td>
                                                     </tr>
                                                    <?php $i++;} $count=$i;?>
                                                     <input type="hidden" value="<?php echo $i?>" name="count" />
                                                 </tbody>
                                             </table>
                            <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div>
                         </div>
                             <div class="tab-pane face in" id="VendorTab3" style="padding-top: 10px;">
                                 <div class="col-sm-12 col-md-12 "><input class="btn btn-primary" type="submit" name="submit" value="submit" align="center"/></div>
                             </div>
           </div>
      </div>
	
	
</form>
<?php require_once("../footer.php");?>