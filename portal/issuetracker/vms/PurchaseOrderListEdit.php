<?php
require_once 'Header1.php';
//require_once("../db.txt");

$getid=$_REQUEST['ID'];

$qry1="select * from [VMS Create PO] WHERE [ID]='".$getid."'";
 $result1 = odbc_exec($conn, $qry1) or die(odbc_errormsg($conn));
 $postatus=odbc_result($result1, "PO Status");
 $qry="select * from [VMS Final PO] WHERE [PO ID]='".$getid."'";
 $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
 
  
 $qryterm="select * from [VMS Term Condition] WHERE [PO ID]='".$getid."'";
 $resultterm = odbc_exec($conn, $qryterm) or die(odbc_errormsg($conn));
 
 $SQLTAX = "SELECT * FROM [VMS Tax Master]";
 $resulttax = odbc_exec($conn, $SQLTAX) or die(odbc_errormsg($conn));
  
  $SQLServiceTAX = "SELECT * FROM [VMS Service Tax Master]";
  $resultservicetax = odbc_exec($conn, $SQLServiceTAX) or die(odbc_errormsg($conn));

 $ledgeritemstatus="SELECT SUM([Qtyreceived]) AS [Qtyreceived], SUM([Outstandingqty]) AS [outstandingqty], SUM([qty]) AS [Qty] FROM [VMS Final PO]  WHERE [PO ID]='".$getid."' ";
  $resultstatus = odbc_exec($conn, $ledgeritemstatus) or die(odbc_errormsg($conn));
  $qtyreceived=odbc_result($resultstatus, "Qtyreceived");
  $outstandingqty=odbc_result($resultstatus, "Outstandingqty");
  $qty=odbc_result($resultstatus, "Qty");
 
?>
<head>
      
     <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script type="text/javascript">
        
      function ShowHideDiv(id) {
         //alert(id);
      if(document.getElementById('chk'+id).checked) {
            $("#warranty"+id).show();
             $("#site"+id).show();
        } 
        else {
            $("#warranty"+id).hide();
            $("#site"+id).hide();
        }
    }
      function vat(id){
           
            var  varqty = $('#qty'+id).val();
            var  varprice = $('#price'+id).val();
            var  varvat = $('#vatcst'+id).val();
            var  varservice = $('#vatservice'+id).val();
                        
            var varqtyprice=(parseInt(varqty) * parseFloat(varprice)).toFixed(2);
            var varvattax=((varqtyprice * varvat) / 100).toFixed(2);
            var servicetax=((varqtyprice * varservice) / 100).toFixed(2);
            var total2=(parseFloat(servicetax) + parseFloat(varvattax)+parseFloat(varqtyprice)).toFixed(2);
            
            $('#subtotal'+id).val(total2);
             var sum = 0.00;
            $('.subtotal').each(function() {
                
                sum += parseFloat($(this).val());
                           
               
            });
            $('#gtotal').val(sum.toFixed(2));
}  
                
        function getaddress(){
            var vendorinput = $('#vendorname').val();
            var datastring='vendorinput='+vendorinput;
           
                $.ajax
                ({
                    type: "POST",
                    url: "SearchVendorAddress.php",
                    data: datastring,
                    cache: false,
                    success: function(result)
                    {
                       
                      var str=result.split(",");

                      document.getElementById('mobile').value=str[0];
                      document.getElementById('email').value=str[1];
                      document.getElementById('address').value=str[2];
                      document.getElementById('postcode').value=str[3];
                      document.getElementById('state').value=str[4];
                      document.getElementById('city').value=str[5];
                      document.getElementById('country').value=str[6];
                      document.getElementById('vendorcontactname').value=str[7];
                  
                    }
                });
           
                }
           

           function addrow(id)
           {
            var id=id;
            var rowCount = $('#customFields tr').length; 
                
            $("#customFields").append('<tr id="'+rowCount+'" valign="top"> <td><select name="itemtype[]" id="itemtype'+rowCount+'"><option value="GL">GL</option><option value="Master">Master</option></select></td><td><input type="text" id="itemname'+rowCount+'"  name="itemname[]" onkeypress="check('+rowCount+');" onchange="check_s('+rowCount+');" size="10";/></td><td><input type="text" id="specifications'+rowCount+'" readonly name="specifications[]" onkeypress="check('+rowCount+');" onchange="check_s('+rowCount+'); " /></td><td><input type="text" class="uom" id="uom'+rowCount+'" readonly name="uom[]" size="10"/></td><td><input type="text" class="qty" id="qty'+rowCount+'"  name="qty[]" size="10" value="0" onkeyup="vat('+rowCount+');" required=""/></td><td><input type="text" class="price" id="price'+rowCount+'" name="price[]" value="0.00" onkeyup="vat('+rowCount+');" size="10" required=""/></td><td><select  id="vatcst'+rowCount+'" name="vatcst[]"  onchange="vat('+rowCount+');"><option value="0.00">--select--</option><?php   while(odbc_fetch_array($resulttax)) {?><option value="<?php echo odbc_result($resulttax,"Value") ?>"><?php echo odbc_result($resulttax,"Code") ?></option> <?php } ?></select></td><td><select  id="vatservice'+rowCount+'" name="vatservice[]"  onchange="vat('+rowCount+');"><option value="0.00">--select--</option><?php   while(odbc_fetch_array($resultservicetax)) {?><option value="<?php echo odbc_result($resultservicetax,"Total Service Tax") ?>"><?php echo odbc_result($resultservicetax,"Total Service Tax") ?></option> <?php } ?></select></td><td><input type="text" class="subtotal" id="subtotal'+rowCount+'" class="subtotal" name="subtotal[]" size="10" value="0.00" readonly=""/></td><td><input type="checkbox" id="chk'+rowCount+'" onclick="ShowHideDiv('+rowCount+')" /></td><td><select name="site[]" id="site'+rowCount+'" style="display: none"> <option value="">-select-</option><option value="On-Site">On-Site</option><option value="Off-Site">Off-Site</option></select></td><td><select name="warranty[]" id="warranty'+rowCount+'" style="display: none"><option value="">-select-</option><option value="1">1 Yr</option><option value="2">2 Yr</option><option value="3">3 Yr</option><option value="4">4 Yr</option><option value="5">5 Yr</option></select></td><td> <a href="javascript:void(0);" class="remCF" onclick="remove(0,'+id+');">Remove</a></td></tr>');
           $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
         var sum = 0.00;
            $('.subtotal').each(function() {
                
                sum += parseFloat($(this).val());
                           
               
            });
            $('#gtotal').val(sum.toFixed(2));
      });
              
          }
function removes(id,getid){

   $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
         var sum = 0.00;
            $('.subtotal').each(function() {
                
                sum += parseFloat($(this).val());
                         
               
            });
          
           
             window.location.href='deletemainitem.php?poid='+getid+'&id='+id+'&sum='+sum;
      });
}
         
   /*  function  removes(id,getid){
      alert(id,getid);
                      
      $(this).parent().parent().remove();
                          
           var sum = 0.00;
            $('.subtotal').each(function() {
                
                sum += parseFloat($(this).val());
                  alert(sum);         
               
            });
            $('#gtotal').val(sum.toFixed(2));
           // alert(sum);

          //  window.location.href='deletemainitem.php?poid='+getid+'&id='+id;
             }*/
      
     
   
        function check(id){
            $(function()
            {        
                //alert(id);

                var availableTags = [ <?php
                    $Itemname=odbc_exec($conn, "SELECT DISTINCT([Item Name]) FROM [VMS Item Master] ") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($Itemname)){
                        echo "'". odbc_result($Itemname, "Item Name")."', ";
                }
               
            ?> ];
        
                $('#itemname'+id).autocomplete({
                    source: availableTags
                });

            });

 
        }
     function shipping(){
        
             $(function()
    {        
       
        var availableTags = [ <?php
                $shippingname=odbc_exec($conn, "SELECT DISTINCT([StoreCode]) FROM [VMS Shipping Master] ") or die(odbc_errormsg($conn));
                while(odbc_fetch_array($shippingname)){
                    echo "'". odbc_result($shippingname, "StoreCode")."', ";
                }
               
            ?> ];
        
        $('#shippingname').autocomplete({
            source: availableTags
        });
        
    });
         
        }
        function vendor(){
        
             $(function()
    {        
       
        var availableTags = [ <?php
                $Vendorname=odbc_exec($conn, "SELECT DISTINCT([VendorCode]),[ID] FROM [VMS Vendor Master] ") or die(odbc_errormsg($conn));
                while(odbc_fetch_array($Vendorname)){
                    echo "'". odbc_result($Vendorname, "ID")."','". odbc_result($Vendorname, "VendorCode")."', ";
                }
               
            ?> ];
        
        $('#vendorname').autocomplete({
            source: availableTags
        });
        
    });
         
        }
    
   
      </script>
       <script>
     $(document).ready(function(){
              
            
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
         $(function() {

	  $("#date2").datepicker({ minDate: 0,});
		$("#dt1").datepicker({ 
			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
			minDate:0,
			//maxDate: 0, 
			changeMonth: true, 
			changeYear: true
		});
  
           });
           $(function() {

	  $("#date3").datepicker({ minDate: 0,});
		$("#dt1").datepicker({ 
			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
			minDate:0,
			//maxDate: 0, 
			changeMonth: true, 
			changeYear: true
		});
  
           });
           
    });

       function check_s(id){
           

          var textinput = $('#itemname'+id).val();
          var datastring='textinput='+textinput+'&id='+id;
           
                $.ajax
                ({
                    type: "POST",
                    url: "SearchItem.php",
                    data: datastring,
                    cache: false,
                    success: function(result)
                    {
                      var str=result.split(",");
                      document.getElementById('specifications'+str[2]).value=str[0];
                      document.getElementById('uom'+str[2]).value=str[1];
                      
                       $('#specifications'+id).html(html);
                       $('#uom'+id).html(html);
                    }
                });
           

}
function comp(id){
   $('#qtytoreceived'+id).keypress(function (e) {
    
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       //display error message
      $("#errmsg").html("Digits Only").show().fadeOut("slow");
           return false;
   }
   });
  var qtytoreceived=$('#qtytoreceived'+id).val();
  var qty=$('#qty'+id).val();
  var outstanding=$('#outstanding'+id).val();

   
if(outstanding === "")
{
     $('#outstanding'+id).val(qty);
     $('#qtyreceived'+id).val(0);
    if(+qtytoreceived > +qty)
  {
    alert('max value than qty');
    //return false;
     $('#submit').prop('disabled', true);
  }
   else{
     $('#submit').prop('disabled', false);
  }
}
if(outstanding != "")
{
    
    if(+qtytoreceived > +qty || +qtytoreceived > +outstanding)
  {
    alert('max value than qty or outstanding');
    //return false;
     $('#submit').prop('disabled', true);
  }
  else{
     $('#submit').prop('disabled', false);
  }
}
}

function getaddress1(){
    var textinput = $('#shippingname').val();
          var datastring='textinput='+textinput;
                    
                $.ajax
                ({
                    type: "POST",
                    url: "ShippingAddress.php",
                    data: datastring,
                    cache: false,
                    success: function(result)
                    {
                      // alert(result);
                      var str=result.split(",");
                      document.getElementById('shippingmobile').value=str[0];
                      document.getElementById('shippingemail').value=str[1];
                      document.getElementById('shippingtoaddress').value=str[2];
                      document.getElementById('shippingstate').value=str[3];
                      document.getElementById('shippingcity').value=str[4];
                      document.getElementById('shippingcountry').value=str[5];
                      document.getElementById('shippingpostcode').value=str[6];
                      
                    }
                });
           
}

  </script>
       
</head>
	
<form action="PurchaseOrderListUpdate.php?ID=<?php echo $_REQUEST['ID']?>" enctype="multipart/form-data" method="POST">
    
    <div class="container">
     <div class="row">
	      <div class="col-md-12">
           
            
                    <h3 class="text-primary">Update Purchase Order</h3>
              
            </div>
            
                   
                        <ul class="nav nav-tabs" id="Enq">
                           <li class="active"><a href="#EnqTab1" data-toggle="tab">Update PO</a></li>
                           <li><a href="#EnqTab2" data-toggle="tab">Edit Terms & Conditions</a></li>
                       </ul>

                       <div class="tab-content" id="EnqContent">
                           <div class="tab-pane face in active" id="EnqTab1">
                                  <table style="margin-top: 5px;">
                             
                                  
                                   <tr>
                                          <td  class="col-md-2">PO No</td>
                                          <td  class="col-md-2"><input type="text" id="pono" name="pono" class="form-control" readonly="" size="10" value="<?php echo odbc_result($result1, "PO No") ?>"/></td>
                                          <td  class="col-md-2">PO Status</td>
                                          <td  class="col-md-2"> 
                                             
                                              <select name="postatus" class="form-control">
                                             
                                              <?php if($qtyreceived=='0') { ?>
                                                                        <option  value="Open">Open</option>
                                                                        <option value="Released">Released</option>
                                                                        <option value="Cancel">Cancel</option>
                                              <?php }?>
                                              <?php if($qtyreceived<$qty) { ?>

                                                                        <option   value="Short Closed">Short Closed</option>
                                                                        
                                              <?php }?>
                                             <?php if($qtyreceived==$qty) { ?>
                                                                    $read="readonly='true'";          
                                                                        <option value="Closed">Closed</option>
                                                                         
                                              <?php }?>
                                                         </select> 
                                          </td>
                                           <td class="col-md-2">Vendor Code</td>
                                           <td class="col-md-2"><input type="text" name="supplier" id="vendorname" class="form-control" onkeypress="vendor();" onchange="getaddress();" placeholder="search vendor Code" required="" value="<?php echo odbc_result($result1, "Vendor") ?>" /></td>
                                   </tr>
                                    
 
                                    <tr>
                                          <td class="col-md-2">Purchase Date</td>
                                          <td class="col-md-2"><input type="text" id="date1" name="purchasedate" class="form-control" readonly="" value="<?php  echo date('d/M/Y', odbc_result($result1, "Purchase Date")) ?>"/></td>
                                           <td class="col-md-2">Requested Received Date</td>
                                          <td class="col-md-2"><input type="text" id="date2" name="needdate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Received Date")) ?>"/></td>
                                          <td class="col-md-2">Expected Date</td>
                                          <td class="col-md-2"><input type="text" id="date3" name="expecteddate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Expected Date")) ?>"/></td>
                                           
                                    </tr>
                                    
                                    <tr>
                                          <td class="col-md-2">Vendor </td>
                                          <td class="col-md-2"><input type="text" id="vendorcontactname" name="vendorcontactname" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Vendor") ?>"/></td>
                                           <td class="col-md-2">Vendor Quote No</td>
                                           <td class="col-md-2"><input type="text" id="vendorquoteno" name="vendorquoteno" class="form-control" value="<?php echo odbc_result($result1, "Vendor Quote No") ?>" readonly=""/></td>
                                          <td class="col-md-2">Mobile</td>
                                          <td class="col-md-2"><input type="text" id="mobile" name="mobile" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Mobile") ?>"/></td>
                                          
                                    </tr>
                                 
                                 
                                    <tr>
                                          <td class="col-md-2">Email</td>
                                          <td class="col-md-2"><input type="text" name="email" id="email" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Email") ?>"/></td>
                                          <td class="col-md-2">Address</td>
                                          <td class="col-md-2"><input type="text" name="address" id="address"class="form-control" readonly="" value="<?php echo odbc_result($result1, "Address") ?>"/></td>
                                          <td class="col-md-2">Postal Code</td>
                                          <td class="col-md-2"><input type="text" id="postcode" name="postcode" class="form-control"  readonly="" value="<?php echo odbc_result($result1, "Postal Code") ?>"/></td>
                                             
                                    </tr>
                                   
                                    <tr>
                                            
                                            <td class="col-md-2">State</td>
                                           <td class="col-md-2"><input type="text" name="state" id="state" class="form-control" readonly="" value="<?php echo odbc_result($result1, "State") ?>"/></td>
                                            <td class="col-md-2">City</td>
                                            <td class="col-md-2"><input type="text" name="city" id="city" class="form-control" readonly="" value="<?php echo odbc_result($result1, "City") ?>"/></td>
                                            <td class="col-md-2">Country</td>
                                            <td class="col-md-2"><input type="text" name="country" id="country" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Country") ?>"/></td>
                                            
                                    </tr>
                                    <tr>
                                          <td class="col-md-2">Shipping Code</td>
                                          <td class="col-md-2"><input type="text" id="shippingname" name="storecode" class="form-control" onkeypress="shipping();" onchange="getaddress1();" required="" value="<?php echo odbc_result($result1, "StoreCode") ?>" /></td>
                                          <td class="col-md-2">Mobile</td>
                                          <td class="col-md-2"><input type="text" id="shippingmobile" name="shippingmobile" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping Mobile") ?>"/></td>
                                          <td class="col-md-2">Email</td>
                                          <td class="col-md-2"><input type="text" name="shippingemail" id="shippingemail" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping Email") ?>"/></td>
                                          
                                    </tr>
                                 
                                 
                                    <tr>
                                          <td class="col-md-2">Address</td>
                                          <td class="col-md-2"><input type="text" name="shippingaddress" id="shippingtoaddress" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping Address") ?>"/></td>
                                          <td class="col-md-2">Postal Code</td>
                                          <td class="col-md-2"><input type="text" id="shippingpostcode" name="shippingpostcode" class="form-control"  readonly="" value="<?php echo odbc_result($result1, "Shipping Post Code") ?>"/></td>
                                         <td class="col-md-2">State</td>
                                         <td class="col-md-2"><input type="text" name="shippingstate" id="shippingstate" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping State") ?>"/></td>
                                              
                                    </tr>
                                   
                                    <tr>
                                            
                                            <td class="col-md-2">City</td>
                                            <td class="col-md-2"><input type="text" name="shippingcity" id="shippingcity" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping City") ?>"/></td>
                                            <td class="col-md-2">Country</td>
                                            <td class="col-md-2"><input type="text" name="shippingcountry" id="shippingcountry" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping Country") ?>"/></td>
                                            <td class="col-md-2">Shipping Contact Name</td>
                                            <td class="col-md-2"><input type="text" name="shippingname" id="shippingcontactname" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Shipping Contact Name") ?>"/></td>
                                    </tr>
                                       <tr>
                                            
                                            <td class="col-md-2">Vendor Invoice Date</td>
                                            <td class="col-md-2"><input type="text" name="vinvoicedate" id="vinvoicedate" class="form-control"  value="<?php echo date('d/M/Y',odbc_result($result1, "VendorInvoiceDate")) ?>"/></td>
                                            <td class="col-md-2">Vendor Invoice No for GRN</td>
                                            <td class="col-md-2"><input type="text" name="vinvoicegrn" id="vinvoicegrn" class="form-control"   value="<?php echo odbc_result($result1, "VendorInvoiceNo") ?>"/></td>
                                            <td class="col-md-2">Posting GRN Date</td>
                                            <td class="col-md-2"><input type="text" name="grndate" id="grndate" class="form-control" readonly=""  value="<?php echo date('d/M/Y',odbc_result($result1, "PostingGRNDate"))  ?>"/></td>
                                           
                                    </tr>

                                </table>
                                
                                 <div style="overflow-x: auto"> 
                               <table class="form-table"  id="customFields" style="margin-top:10px;">
                                     <tr><td> <a href="javascript:void(0);"  onclick="addrow(<?php echo odbc_result($result1, "ID")?>);"><?php if($qtyreceived==0){ ?>Add Item <?php }?></a></td></tr>
                                    <tr>
                                                        <th>Item Type</th>
                                                        <th>Item Code</th>
                                                        <th>Item Description</th>
                                                        <th style="text-align: center">UOM</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>VAT/CST</th>
                                                        <th>&nbsp;Service Tax</th>
                                                        <th style="text-align: center">Line Amount</th>
                                                       <th>Warranty</th>
                                                       <th></th>
                                                       <th></th>
                                                       <th>Qty to Received</th>
                                                        <th>Qty Received</th>
                                                         <th>Outstanding Qty</th>
                                    </tr>

                                    <?php $i=1; while(odbc_fetch_array($result)){?>
                                    <tr id="<?php echo $i; ?>">
                                                           <td><select name="itemtype[]" id="itemtype1">
                                                                        <option value="GL">GL</option>
                                                                        <option value="Master">Master</option>
                                                            </select>
                                                           </td>
                                                           <td><input type="text"  id="itemname<?php echo $i?>"  name="itemname[]" onkeypress="check(<?php echo $i?>);" value="<?php echo odbc_result($result,"Item Name")?> " onchange="check_s(<?php echo $i?>);" size="10" required="" /></td>
                                                            <td><input type="text" name="specifications[]" readonly id="specifications<?php echo $i?>" onchange="specifications(<?php echo odbc_result($result,"ID")?> )"  value="<?php  echo odbc_result($result,"Specifications") ?>"/>
                                                                <input type="hidden" name="hiddenfinalpoid[]" value="<?php echo odbc_result($result,"ID") ?>"/>
                                                            </td>
                                                            <td><input type="text"  id="uom<?php echo $i?>"   name="uom[]" readonly size="10" value="<?php  echo odbc_result($result,"UOM") ?>"/> </td>
                                                            <td><input type="text"  id="qty<?php echo $i?>"   name="qty[]"  size="10"  onkeyup="vat(<?php echo $i?>);" required="" value="<?php  echo odbc_result($result,"Qty") ?>"/> </td>
                                                            <td><input type="text"  id="price<?php echo $i?>" name="price[]"  onkeyup="vat(<?php echo $i?>);" size="10" required="" value="<?php  if(odbc_result($result,"Unit Price")=='0'){
                                                            echo '0.00';} else { echo odbc_result($result,"Unit Price");}?>"/> </td>
                                                            
                                                            <td><?php 
                                                              $SQLTAX1 = "SELECT * FROM [VMS Tax Master]";
                                                              $resulttax1 = odbc_exec($conn, $SQLTAX1) or die(odbc_errormsg($conn));?>
                                                                <select  id="vatcst<?php echo $i; ?>" name="vatcst[]"  onchange="vat(<?php echo $i ?>);">
                                                                    <option value="0">--select--</option>
                                                                      <?php   while(odbc_fetch_array($resulttax1)) {?>
                                                               
                                                                        <option <?php if(odbc_result($result,"VAT CST")==odbc_result($resulttax1,"Value")) { echo 'selected ';} ?> value="<?php echo odbc_result($resulttax1,"Value") ?>"><?php echo odbc_result($resulttax1,"Code") ?></option>
                                                              <?php } ?>
                                                                      </select>
                                                            </td>
                                                            
                                                            <td><?php 
                                                              $SQLServiceTAX1 = "SELECT * FROM [VMS Service Tax Master]";
                                                              $resultservicetax1 = odbc_exec($conn, $SQLServiceTAX1) or die(odbc_errormsg($conn));?>
                                                                <select id="vatservice<?php echo $i; ?>" name="vatservice[]"    onchange="vat(<?php echo $i; ?>);">
                                                                <option value="0">--select--</option>                                                           
                                                                 <?php   while(odbc_fetch_array($resultservicetax1)) {?>

                                                                        <option <?php if(odbc_result($result,"Service Tax")==odbc_result($resultservicetax1,"Total Service Tax")) { echo 'selected ';} ?> value="<?php echo odbc_result($resultservicetax1,"Total Service Tax"); ?>"> <?php echo odbc_result($resultservicetax1,"Total Service Tax") ?></option>
                                                              <?php } ?>
                                                                      </select></td>
                                                                      
                                                                 <td align="right"><input type="text"  id="subtotal<?php echo $i?>" name="subtotal[]" class="subtotal" size="10"  value="<?php if(odbc_result($result,"Sub Total")=='0'){ 
                                                                     echo '0.00';} else { echo odbc_result($result,"Sub Total");}?>" readonly=""/> </td>      
                                                           <td>
                                                               
                                                                <input type="checkbox" id="chk<?php echo $i?>" onclick="ShowHideDiv(<?php echo $i?>)" value="0" <?php if(odbc_result($result,"Warranty")!="") { echo "checked"; }?> name="chktk[]"/>
                                                          </td>
                                                       
                                                          <td>
                                                           
                                                            <select id="site<?php echo $i?>"  <?php  if(odbc_result($result,"Warranty")==""){?>style="display: none" <?php }?> name="site[]">
                                                                    <option <?php if(odbc_result($result,"Site")==""){echo 'selected';}?> value="">-select-</option>
                                                                    <option <?php if(odbc_result($result,"Site")=="On-Site"){echo 'selected';}?> value="On-Site">On-Site</option>
                                                                    <option <?php if(odbc_result($result,"Site")=="Off-Site"){echo 'selected';}?> value="Off-Site">Off-Site</option>
                                                                    
                                                             </select>
                                                               
                                                          </td>
                                                          <td>
                                                              <select id="warranty<?php echo $i?>"  <?php  if(odbc_result($result,"Warranty")==""){?>style="display: none" <?php }?> name="warranty[]">
                                                                    <option <?php if(odbc_result($result,"Warranty")==""){echo 'selected';}?>  value="">-select-</option>
                                                                    <option <?php if(odbc_result($result,"Warranty")=="1"){echo 'selected';}?> value="1">1 Yr</option>
                                                                    <option <?php if(odbc_result($result,"Warranty")=="2"){echo 'selected';}?> value="2">2 Yr</option>
                                                                    <option <?php if(odbc_result($result,"Warranty")=="3"){echo 'selected';}?> value="3">3 Yr</option>
                                                                    <option <?php if(odbc_result($result,"Warranty")=="4"){echo 'selected';}?> value="4">4 Yr</option>
                                                                    <option <?php if(odbc_result($result,"Warranty")=="5"){echo 'selected';}?> value="5">5 Yr</option>
                                                             </select>
                                                               
                                                          </td>
                                                          <?php 
                                                         $qryledger="SELECT SUM(QtytoReceive) AS [Qtyto] FROM [VMS Item Ledger] where [ItemCode]='".odbc_result($result,"Item Name")."' AND [PO ID]='".$getid."'";
                                                            $resultledger = odbc_exec($conn, $qryledger) or die(odbc_errormsg($conn));
                                                                     ?>
                                                            <td><input type="textbox" name="qtytoreceived[]" id="qtytoreceived<?php echo $i; ?>" size="10" onkeypress="qty(1);" onkeyup="comp(<?php echo $i ?>);"/></td>
                                                          <td><input type="textbox" onkeyup="qty(1);" name="qtyreceived[]" id="qtyreceived<?php echo $i; ?>" size="10" value="<?php echo odbc_result($resultledger,"Qtyto");?>";/></td>
                                                          <?php
                                                                 $qryout="SELECT Distinct [PO Qty] FROM [VMS Item Ledger] where [ItemCode]='".odbc_result($result,"Item Name")."' AND [PO ID]='".$getid."'";
                                                            $resultout = odbc_exec($conn, $qryout) or die(odbc_errormsg($conn));
                                                              $poqty=odbc_result($resultout,"PO Qty");
                                                          ?>
                                                                 <td><input type="textbox" name="outstandingqty[]" size="10" id="outstanding<?php echo $i; ?>" value="<?php if(!empty($poqty)){ echo $poqty-odbc_result($resultledger,"Qtyto");}?>"/></td>
                                                          <td ><?php if($i!=1){?> <a href="javascript:void(0);" class="remCF" onclick="removes(<?php echo odbc_result($resultout,"PO Qty")?>,<?php echo $getid ?>);"><?php if($qtyreceived==0){ ?>Remove<?php }?></a><?php }?></td>  
                                  </tr>
                                    <?php   $i++; }?>
                                     
                             </table>
                                 </div>
                            <table style="width: 95%;">
                                 <tr>
                                     <td style="text-align: right;" class="col-md-10"><b>Grand Total</b></td>
                                     <td><input  type="text" size="10" class="form-control" value="<?php if(odbc_result($result, "Gtotal")==0){ echo '0.00';} else{ echo odbc_result($result, "Gtotal");}?>" name="gtotal" readonly="" id="gtotal" readonly=""/></td>
                                 </tr>
                            </table>
                           </div>
                           <div class="tab-pane face in" id="EnqTab2">
                               <table style="margin-top: 10px;">
                               <tr>
                                   <td><b>Terms and Conditions</b></td>
                               </tr>
                               <tr>
                                  
                                   <td> <textarea id="termncondition" name="termncondition" value="<?php echo odbc_result($resultterm, "Term Condition")?>"><?php echo odbc_result($resultterm, "Term Condition")?></textarea></td>
                               </tr>
                               </table>
                                <div class="row">
         <div class="col-md-12">
            <table style="margin-top: 10px;">
                                <tr>
                                    <td>
                                                    <input class="btn btn-primary" type="submit" name="submit" value="submit" id="submit" align="center"/>
                                    </td>          
                               </tr>
                              </table> 
         </div>
         </div> 
                           </div>
                          
                                                    
                       </div>

         </div>
            
         </div>
      </div>  
</form>
<?php require_once("../footer.php");?>