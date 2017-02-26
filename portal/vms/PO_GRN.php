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



  $release=odbc_result($result1,"Release");
  $posts=odbc_result($result1,"PO Status");
 echo  $VendorInvoiceDate=odbc_result($result1,"VendorInvoiceDate");
 echo  $VendorInvoiceNo=odbc_result($result1,"VendorInvoiceNo");
 echo  $PostingGrnDate=odbc_result($result1,"PostingGRNDate");
  if($release==1){
    $read="readonly='true'";
  }
  else if($release==0){
    $read="readonly='false'";
  }
?>
<head>
     <style> .submenu { z-index: 999; }</style>
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
                
            $("#customFields").append('<tr id="'+rowCount+'" valign="top"> <td><select name="itemtype[]" id="itemtype'+rowCount+'"><option value="GL">GL</option><option value="Master">Master</option></select></td><td><input type="text" id="itemname'+rowCount+'"  name="itemname[]" onkeypress="check('+rowCount+');" onchange="check_s('+rowCount+');" size="10";/></td><td><input type="text" id="specifications'+rowCount+'" readonly name="specifications[]" onkeypress="check('+rowCount+');" onchange="check_s('+rowCount+'); " /></td><td><input type="text" class="uom" id="uom'+rowCount+'" readonly name="uom[]" size="10"/></td><td><input type="text" class="qty" id="qty'+rowCount+'"  name="qty[]" size="10" value="0" onkeyup="vat('+rowCount+');" required=""/></td><td><input type="text" class="price" id="price'+rowCount+'" name="price[]" value="0.00" onkeyup="vat('+rowCount+');" size="10" required=""/></td><td><select  id="vatcst'+rowCount+'" name="vatcst[]"  onchange="vat('+rowCount+');"><option value="0.00">--select--</option><?php   while(odbc_fetch_array($resulttax)) {?><option value="<?php echo odbc_result($resulttax,"Value") ?>"><?php echo odbc_result($resulttax,"Code") ?></option> <?php } ?></select></td><td><select  id="vatservice'+rowCount+'" name="vatservice[]"  onchange="vat('+rowCount+');"><option value="0.00">--select--</option><?php   while(odbc_fetch_array($resultservicetax)) {?><option value="<?php echo odbc_result($resultservicetax,"Total Service Tax") ?>"><?php echo odbc_result($resultservicetax,"Total Service Tax") ?></option> <?php } ?></select></td><td><input type="text" class="subtotal" id="subtotal'+rowCount+'" class="subtotal" name="subtotal[]" size="10" value="0.00" readonly=""/></td><td><input type="checkbox" id="chk'+rowCount+'" onclick="ShowHideDiv('+rowCount+')" /></td><td><select name="site[]" id="site'+rowCount+'" style="display: none"> <option value="">-select-</option><option value="On-Site">On-Site</option><option value="Off-Site">Off-Site</option></select></td><td><select name="warranty[]" id="warranty'+rowCount+'" style="display: none"><option value="">-select-</option><option value="1">1 Yr</option><option value="2">2 Yr</option><option value="3">3 Yr</option><option value="4">4 Yr</option><option value="5">5 Yr</option></select></td><td><input type="textbox" name="qtytoreceived[]" id="qtytoreceived'+rowCount+'" size="10" onkeypress="qty('+rowCount+');" onkeyup="comp('+rowCount+');"/></td><td><input type="textbox" name="qtyreceived[]" id="qtyreceived'+rowCount+'" size="10"  readonly /><td><input type="textbox" name="outstandingqty[]" size="10" id="outstanding'+rowCount+'" readonly=""/></td><td> <a href="javascript:void(0);" class="remCF" onclick="remove(0,'+id+');">Remove</a></td></tr>');
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

      $("#vinvoicedate").datepicker({ minDate: 0,});
        $("#dt1").datepicker({ 
            //minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
            minDate:0,
            //maxDate: 0, 
            changeMonth: true, 
            changeYear: true
        });
  
           });
  $(function() {

      $("#grndate").datepicker({ minDate: 0,});
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
      </script> 
</head>
  
<form action="PO_GRNUpdate.php?ID=<?php echo $_REQUEST['ID']?>" enctype="multipart/form-data" method="POST">
    
    <div class="container">
     <div class="row">
        <div class="col-md-12">
           
            
                    <h3 class="text-primary">GRN</h3>
             
            </div>
            
                   
<ul class="nav nav-tabs" id="Enq">
   <li class="active"><a href="#EnqTab1" data-toggle="tab">GRN</a></li>
   <li><a href="#EnqTab2" data-toggle="tab">Edit Terms & Conditions</a></li>
</ul>

<div class="tab-content" id="EnqContent">
   <div class="tab-pane face in active" id="EnqTab1">
          <table style="margin-top: 5px;">
     
          
           <tr>
                  <td  class="col-md-2">PO No</td>
                  <td  class="col-md-2">
                    <input type="text" id="pono" name="pono" class="form-control" readonly="" size="10"   value="<?php echo odbc_result($result1, "PO No") ?>"/></td>
                  <td  class="col-md-2">PO Status</td>
                  <td  class="col-md-2"> 
                     
                     <input type="text" readonly name="postatus" value="<?php echo $posts; ?>" class="form-control">
                  </td>
                   <td class="col-md-2">Vendor Code</td>
                   <td class="col-md-2"><input type="text" name="vendorcode" id="vendorname" class="form-control" onkeypress="vendor();" onchange="getaddress();" placeholder="search vendor Code" required="" value="<?php echo odbc_result($result1, "VendorCode") ?>"  <?php if($release==1){ ?>readonly <?php } ?>/></td>
           </tr>
            

            <tr>
                  <td class="col-md-2">Purchase Date</td>
                  <td class="col-md-2"><input type="text" name="purchasedate" class="form-control" readonly="" value="<?php  echo date('d/M/Y', odbc_result($result1, "Purchase Date")) ?>"/></td>
                   <td class="col-md-2">Requested Received Date</td>
                  <td class="col-md-2"><input type="text"  name="needdate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Received Date")) ?>"/></td>
                  <td class="col-md-2">Expected Date</td>
                  <td class="col-md-2"><input type="text"  name="expecteddate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Expected Date")) ?>"/></td>
                   
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
                  <td class="col-md-2"><input type="text" id="shippingname" name="storecode" class="form-control" onkeypress="shipping();" onchange="getaddress1();" required="" value="<?php echo odbc_result($result1, "StoreCode") ?>" <?php if($release==1){ ?>readonly <?php } ?>/></td>
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
                    <td class="col-md-2"><input type="text" name="vinvoicedate" <?php  if($VendorInvoiceDate==""){ ?>id="vinvoicedate" <?php } ?> class="form-control"   value="<?php if($VendorInvoiceDate!=""){ echo date('d/M/Y',odbc_result($result1, "VendorInvoiceDate"));}?>" <?php if($VendorInvoiceDate!=""){?><?php echo $read; }?>/></td>
                    <td class="col-md-2">Vendor Invoice No for GRN</td>
                    <td class="col-md-2"><input type="text" onkeyup="checkAvailability();" name="vinvoicegrn" id="vinvoicegrn" class="form-control"  value="<?php if($VendorInvoiceNo!=""){ echo $VendorInvoiceNo;}?>" <?php if($VendorInvoiceNo!=""){?><?php echo $read; }?> /></td>
                    <td class="col-md-2">Posting GRN Date</td>
                    <td class="col-md-2"><input type="text" name="grndate" <?php  if($PostingGrnDate==""){ ?>id="grndate" <?php } ?> class="form-control"    value="<?php  if($PostingGrnDate!=""){ echo date('d/M/Y',odbc_result($result1, "PostingGRNDate"));}?>" <?php if($PostingGrnDate!=""){?><?php echo $read; }?>/></td>
                   
            </tr>

        </table>
         <div style="overflow-x: auto"> 
       <table class="form-table"  id="customFields" style="margin-top:10px;">
            
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
                               <?php if($release==1){?>
                               <th>Qty to Receive</th>
                               <th>Qty Received</th>
                               <th>Outstanding Qty</th>
                               <?php }?>
                               
            </tr>

            <?php $i=1; while(odbc_fetch_array($result)){$release; $read; $blr="onfocus='this.blur()'"?>
                 <td>
                      <select name="itemtype[]" id="itemtype1" <?php echo  $read; ?>>
                        <option value="GL">GL</option>
                        <option value="Master">Master</option>
                      </select>
                  </td>
                  <td>
                      <input type="text" <?php echo $read;  ?> <?php echo $blr;?> id="itemname<?php echo $i?>"  name="itemname[]" onkeypress="check(<?php echo $i?>);" value="<?php echo odbc_result($result,"Item Name")?> " onchange="check_s(<?php echo $i?>);" size="10" required="" />
                  </td>
                  <td>
                       <input type="text" name="specifications[]" readonly id="specifications<?php echo $i?>" onchange="specifications(<?php echo odbc_result($result,"ID")?> )"  value="<?php  echo odbc_result($result,"Specifications") ?>" <?php echo $read; ?> <?php echo $blr;?>/>
                        <input type="hidden" name="hiddenfinalpoid[]" value="<?php echo odbc_result($result,"ID") ?>"/>
                 </td>
                <td>
                    <input type="text"  id="uom<?php echo $i?>"   name="uom[]" readonly size="10" value="<?php  echo odbc_result($result,"UOM") ?>" <?php echo $read; ?> <?php echo $blr;?>/> 
                </td>
               <td>
                   <input type="text" <?php echo $read." ".$blr; ?>  id="qty<?php echo $i?>"   name="qty[]"  size="10"  onkeyup="vat(<?php echo $i?>);" required="" value="<?php  echo odbc_result($result,"Qty") ?>"  <?php echo $blr;?>/>
               </td>
                <td>
                  <input type="text"  id="price<?php echo $i?>" name="price[]"  onkeyup="vat(<?php echo $i?>);" size="10" required="" value="<?php  if(odbc_result($result,"Unit Price")=='0'){
                  echo '0.00';} else { echo odbc_result($result,"Unit Price");}?>" <?php echo $read." ".$blr; ?> /> 
                </td>
                <td>
                   <input type="textbox" size="10" <?php echo $blr; ?> name="vatcst[]"
                          value="<?php if(odbc_result($result,"VAT CST")=='0'){echo '0.00';} else {echo odbc_result($result,"VAT CST");} ?>"/>
     
               </td>
              
               <td>
                                                                     
                        <input type="textbox" size="10" <?php echo $blr; ?> name="vatservice[]"
                          value="<?php if(odbc_result($result,"Service Tax")=='0'){echo '0.00';} else {echo odbc_result($result,"Service Tax");} ?>"/>

               </td>
                     <td align="right"><input type="text"  id="subtotal<?php echo $i?>" name="subtotal[]" class="subtotal" size="10"  value="<?php if(odbc_result($result,"Sub Total")=='0'){ 
                       echo '0.00';} else { echo odbc_result($result,"Sub Total");}?>" readonly=""/> </td>      
               <td>
                   <?php if($read="") {?>
                     <input type="checkbox" id="chk<?php echo $i?>"  <?php if(odbc_result($result,"Warranty")!="") { echo "checked"; }?> name="chktk[]" onclick="ShowHideDiv(<?php echo $i?>)" value="0"/>
                    <?php }else{?>
                     <input type="checkbox" id="chk<?php echo $i?>"  <?php if(odbc_result($result,"Warranty")!="") { echo "checked"; }?> name="chktk[]" value="0" disabled/>
                     <?php }?>

              </td>
         
              <td>
                  <?php if($release==0) {?>
                      <select id="site<?php echo $i?>"  <?php  if(odbc_result($result,"Warranty")==""){?>style="display: none" <?php }?> name="site[]">

                          <option <?php if(odbc_result($result,"Site")==""){echo 'selected';}?> value="">-select-</option>
                          <option <?php if(odbc_result($result,"Site")=="On-Site"){echo 'selected';}?> value="On-Site">On-Site</option>
                          <option <?php if(odbc_result($result,"Site")=="Off-Site"){echo 'selected';}?> value="Off-Site">Off-Site</option>
                      
                     </select>
                  <?php } else if(odbc_result($result,"Site")!=""){?>
                <input type="textbox" name="site[]"size="10" readonly="" value="<?php echo odbc_result($result,"Site");?>"/>
                <?php }?>
            </td>
            <td>
               <?php if($read="") {?>
                <select id="warranty<?php echo $i?>"  <?php  if(odbc_result($result,"Warranty")==""){?>  style="display: none" <?php }?> name="warranty[]">
                      <option <?php if(odbc_result($result,"Warranty")==""){echo 'selected';}?>  value="">-select-</option>
                      <option <?php if(odbc_result($result,"Warranty")=="1"){echo 'selected';}?> value="1">1 Yr</option>
                      <option <?php if(odbc_result($result,"Warranty")=="2"){echo 'selected';}?> value="2">2 Yr</option>
                      <option <?php if(odbc_result($result,"Warranty")=="3"){echo 'selected';}?> value="3">3 Yr</option>
                      <option <?php if(odbc_result($result,"Warranty")=="4"){echo 'selected';}?> value="4">4 Yr</option>
                      <option <?php if(odbc_result($result,"Warranty")=="5"){echo 'selected';}?> value="5">5 Yr</option>
               </select>
                <?php } else if(odbc_result($result,"Warranty")!=""){?>
                <input type="textbox" name="warranty[]" size="10" readonly="" value="<?php echo odbc_result($result,"Warranty");?>"/>
                <?php }?> 
            </td>
            <?php 
          
           $qryledger="SELECT [Qtyreceived],[Outstandingqty] FROM [VMS Final PO] where [Item Name]='".trim(odbc_result($result,"Item Name"))."' AND [PO ID]='".$getid."'";
              $resultledger = odbc_exec($conn, $qryledger) or die(odbc_errormsg($conn));
                       ?>
              <?php if($release==1){?>         
              <td><input type="textbox" name="qtytoreceived[]" id="qtytoreceived<?php echo $i; ?>" size="10" onkeypress="qty(1);" onkeyup="comp(<?php echo $i ?>);" value="0"/>
                  </td>
            <td><input type="textbox"  name="qtyreceived[]" id="qtyreceived<?php echo $i; ?>" size="10" value="<?php echo odbc_result($resultledger,"Qtyreceived");?>"; readonly=""/></td>
                                                    <td><input type="textbox" name="outstandingqty[]" size="10" id="outstanding<?php echo $i; ?>" value="<?php echo odbc_result($resultledger,"Outstandingqty");?>" readonly=""/></td>
                   <?php }?>
                                  
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

</div> 
   </div>
  
                                                    
                       </div>
                      
             <input type="hidden" id="rowcn" value="<?php echo $i-1; ?>" />
         </div>
            <div class="col-md-12">
            <table style="margin-top: 10px;">
                                <tr>
                                    <td>
                                            
                                          <?php if($posts!=Closed){?>  <input class="btn btn-primary" type="submit" name="submit" value="submit" id="submit" align="center"  onclick="return myFunction()"/><?php }?>
                                    </td>          
                               </tr>
                              </table> 
         </div>
         </div>
      </div>  
</form>
<?php require_once("../footer.php");?>

<script>
function myFunction() {
  var row=$('#rowcn').val()
  var ar = new Array();
  var ary=0;

for(var i=1; i<=row; i++){
     ar[i] = $('#qtytoreceived'+i).val();
      ary=+ary + +ar[i];
     }
     if(+ary==0)
     {
alert("qty to receive can not be - "+ary);
 return false;
 }
 
    var textinput19 = $('#vinvoicedate').val();
    var textinput20 = $('#vinvoicegrn').val();
    var textinput21 = $('#grndate').val();
    
      
     if(textinput19=="")
      {
      alert('pls fill Invoice Date');
      return false;
    }
    else if(textinput20=="")
      {
      alert('pls fill Invoice No');
      return false;
    }
    else if(textinput21=="")
      {
      alert('pls fill GRN Date');
      return false;
    }
   
      
}
function checkAvailability() {
var textinput1 = $('#vinvoicegrn').val();
var textinput2 = $('#vendorname').val();

var datastring='textinput1='+textinput1+'&textinput2='+textinput2;

jQuery.ajax({
url: "check_availability.php",
data: datastring,
type: "POST",
success:function(data){
 if(data>0){
  alert('This Invoice No Already Exist');
   $('#submit').prop('disabled', true);
 }
  else{
   $('#submit').prop('disabled', false);
 }
},
error:function (){}
});
}

</script>