<table style="margin-top: 5px;">
                              
                                   <tr>
                                          <td  class="col-md-2">PO No</td>
                                          <td  class="col-md-2"><input type="text" id="pono" name="pono" class="form-control" readonly="" size="10" value="<?php echo odbc_result($result1, "PO No") ?>"/></td>
                                          <td  class="col-md-2">PO Status</td>
                                          <td  class="col-md-2"> 
                                              <input type="text"  name="postatus" class="form-control" readonly="" size="10" value="<?php echo odbc_result($result1, "PO Status") ?>"/>
                                              
                                          </td>
                                           <td class="col-md-2">Vendor</td>
                                           <td class="col-md-2"><input type="text" name="supplier" id="vendorname" class="form-control" onkeypress="vendor();" onchange="getaddress();" placeholder="search vendor" required="" value="<?php echo odbc_result($result1, "Vendor") ?>" /></td>
                                   </tr>

                                    <tr>
                                          <td class="col-md-2">Purchase Date</td>
                                          <td class="col-md-2"><input type="text" id="date1" name="purchasedate" class="form-control" readonly="" value="<?php  echo date('d/M/Y', odbc_result($result1, "Purchase Date")) ?>"/></td>
                                           <td class="col-md-2">Received Date</td>
                                          <td class="col-md-2"><input type="text" id="date2" name="needdate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Received Date")) ?>"/></td>
                                          <td class="col-md-2">Expected Date</td>
                                          <td class="col-md-2"><input type="text" id="date3" name="expecteddate" class="form-control" readonly="" value="<?php echo date('d/M/Y',odbc_result($result1, "Expected Date")) ?>"/></td>
                                           
                                    </tr>
                                    
                                    <tr>
                                          <td class="col-md-2">Vendor Contact Name</td>
                                          <td class="col-md-2"><input type="text" id="vendorcontactname" name="vendorcontactname" class="form-control" readonly="" value="<?php echo odbc_result($result1, "Vendor Contact Name") ?>"/></td>
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
                                          <td class="col-md-2">Shipping Contact Name</td>
                                          <td class="col-md-2"><input type="text" id="shippingname" name="shippingname" class="form-control" onkeypress="shipping();" onchange="getaddress1();" required="" value="<?php echo odbc_result($result1, "Shipping Contact Name") ?>" /></td>
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
                                            
                                    </tr>

                                </table>
                                 
                               <table class="form-table" id="customFields" style="margin-top:10px;">
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
                                                            
                                                            <td><input type="text"  id="subtotal<?php echo $i?>" name="subtotal[]" class="subtotal" size="10"  value="<?php if(odbc_result($result,"Sub Total")=='0'){ 
                                                                 echo '0.00';} else { echo odbc_result($result,"Sub Total");}?>"/> </td>
                                                                                                                                                                           </td>
                                    </tr>
                                    <?php   $i++; }?>
                             </table>
                            <table style="width: 95%;">
                                 <tr>
                                     <td style="text-align: right;" class="col-md-10"><b>Grand Total</b></td>
                                     <td><input  type="text" size="10" class="form-control" value="<?php if(odbc_result($result, "Gtotal")==0){ echo '0.00';} else{ echo odbc_result($result, "Gtotal");}?>" name="gtotal" readonly="" id="gtotal" readonly=""/></td>
                                 </tr>
                            </table>