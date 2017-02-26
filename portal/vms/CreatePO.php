 <table style="margin-top: 10px;">
                              
                                   <tr>
                                        <td class="col-md-2">Vendor</td>
                                           <td class="col-md-2"><input type="text" name="supplier" id="vendorname" class="form-control" onkeypress="vendor();" onchange="getaddress();" placeholder="search vendor" required="" /></td>
                                   <input type="hidden" name="pono" value="<?php echo $newpoid;?>"/>
                                          <td  class="col-md-2">PO Status</td>
                                          <td  class="col-md-2"> <select name="postatus" class="form-control">
                                                                        <option value="Open">Open</option>
                                                                        <option value="Cancel">Cancel</option>
                                                                        <option value="Short Closed">Short Closed</option>
                                                                        <option value="Pending Approval">Pending Approval</option>
                                                                          <option value="Released">Released</option>
                                                                        <option value="Closed">Closed</option>
                                                                      </select> 
                                          </td>
                                          <td colspan="2">&nbsp;</td>
                                           </tr>

                                    <tr>
                                          <td class="col-md-2">Purchase Date</td>
                                          <td class="col-md-2"><input type="text" id="date1" name="purchasedate" class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Received Date</td>
                                          <td class="col-md-2"><input type="text" id="date2" name="needdate" class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Expected Date</td>
                                          <td class="col-md-2"><input type="text" id="date3" name="expecteddate" class="form-control" readonly=""/></td>
                                           
                                    </tr>
                                    
                                    <tr>
                                          <td class="col-md-2">Vendor Contact Name</td>
                                          <td class="col-md-2"><input type="text" id="vendorcontactname" name="vendorcontactname" class="form-control" readonly=""/></td>
                                           <td class="col-md-2">Vendor Quote No</td>
                                          <td class="col-md-2"><input type="text" id="vendorquoteno" name="vendorquoteno" class="form-control" /></td>
                                          <td class="col-md-2">Mobile</td>
                                          <td class="col-md-2"><input type="text" id="mobile" name="mobile" class="form-control" readonly=""/></td>
                                          
                                    </tr>
                                 
                                 
                                    <tr>
                                          <td class="col-md-2">Email</td>
                                          <td class="col-md-2"><input type="text" name="email" id="email" class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Address</td>
                                          <td class="col-md-2"><input type="text" name="address" id="address"class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Postal Code</td>
                                          <td class="col-md-2"><input type="text" id="postcode" name="postcode" class="form-control"  readonly=""/></td>
                                             
                                    </tr>
                                   
                                    <tr>
                                            
                                            <td class="col-md-2">State</td>
                                           <td class="col-md-2"><input type="text" name="state" id="state" class="form-control" readonly=""/></td>
                                            <td class="col-md-2">City</td>
                                            <td class="col-md-2"><input type="text" name="city" id="city" class="form-control" readonly=""/></td>
                                            <td class="col-md-2">Country</td>
                                            <td class="col-md-2"><input type="text" name="country" id="country" class="form-control" readonly=""/></td>
                                            
                                    </tr>
                                    <tr>
                                          <td class="col-md-2">Shipping Contact Name</td>
                                          <td class="col-md-2"><input type="text" id="shippingname" name="shippingname" class="form-control" onkeypress="shipping();" onchange="getaddress1();" required=""/></td>
                                          <td class="col-md-2">Mobile</td>
                                          <td class="col-md-2"><input type="text" id="shippingmobile" name="shippingmobile" class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Email</td>
                                          <td class="col-md-2"><input type="text" name="shippingemail" id="shippingemail" class="form-control" readonly=""/></td>
                                          
                                    </tr>
                                 
                                 
                                    <tr>
                                          <td class="col-md-2">Address</td>
                                          <td class="col-md-2"><input type="text" name="shippingaddress" id="shippingtoaddress" class="form-control" readonly=""/></td>
                                          <td class="col-md-2">Postal Code</td>
                                          <td class="col-md-2"><input type="text" id="shippingpostcode" name="shippingpostcode" class="form-control"  readonly=""/></td>
                                         <td class="col-md-2">State</td>
                                         <td class="col-md-2"><input type="text" name="shippingstate" id="shippingstate" class="form-control" readonly=""/></td>
                                              
                                    </tr>
                                   
                                    <tr>
                                            
                                            <td class="col-md-2">City</td>
                                            <td class="col-md-2"><input type="text" name="shippingcity" id="shippingcity" class="form-control" readonly=""/></td>
                                            <td class="col-md-2">Country</td>
                                            <td class="col-md-2"><input type="text" name="shippingcountry" id="shippingcountry" class="form-control" readonly=""/></td>
                                            
                                    </tr>

                                </table>

                               <table class="form-table" id="customFields" style="margin-top:10px; overflow-y: auto" >
                                    <tr>
                                                        <th>Item Type</th>
                                                        <th>Item Code</th>
                                                        <th>Item Description</th>
                                                        <th style="text-align: center">UOM</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>VAT/CST</th>
                                                        <th>Service Tax</th>
                                                        <th>Warranty</th>
                                                        <th>Tick</th>
                                                        <th style="text-align: center">Line Amount</th>
                                    </tr>
                                    <tr id="1">
                                                           <td><select name="itemtype[]" id="itemtype1">
                                                                      
                                                                        <option value="Item">Item</option>
                                                                        <option value="GL Master">GL Master</option>
                                                            </select>
                                                           </td>
                                                           <td><input type="text"  id="itemname1" name="itemname[]" onkeypress="check(1);" onchange="check_s(1);" size="10" required=""/></td>
                                                            <td><input type="text" name="specifications[]" readonly id="specifications1" onchange="specifications(<?php echo odbc_result($result,"ID")?> )" />
                                                                <input type="hidden" name="hiddenitemid" value="<?php echo odbc_result($result,"Item ID") ?>"/>
                                                            </td>
                                                            <td><input type="text"  id="uom1"   name="uom[]" readonly size="10"/> </td>
                                                            <td><input type="text"  id="qty1"   name="qty[]"  size="10" value="0" onkeyup="vat(1);" required="" /> </td>
                                                            <td><input type="text"  id="price1" name="price[]" value="0.00" onkeyup="vat(1);"  required="" size="10"/> </td>
                                                            <td>
                                                            <?php 
                                                              $SQLTAX1 = "SELECT * FROM [VMS Tax Master]";
                                                              $resulttax1 = odbc_exec($conn, $SQLTAX1) or die(odbc_errormsg($conn));?>
                                                                <select  id="vatcst1" name="vatcst[]"  onchange="vat(1);">
                                                                    <option value="0">--select--</option>
                                                                      <?php   while(odbc_fetch_array($resulttax1)) {?>
                                                               
                                                                        <option value="<?php echo odbc_result($resulttax1,"Value") ?>"><?php echo odbc_result($resulttax1,"Code") ?></option>
                                                              <?php } ?>
                                                                      </select>
                                                            </td>
                                                            
                                                             <td>
                                                            <?php 
                                                              $SQLServiceTAX1 = "SELECT * FROM [VMS Service Tax Master]";
                                                              $resultservicetax1 = odbc_exec($conn, $SQLServiceTAX1) or die(odbc_errormsg($conn));?>
                                                                <select id="vatservice1" name="vatservice[]"    onchange="vat(1);">
                                                                <option value="0">--select--</option>                                                           
                                                                 <?php   while(odbc_fetch_array($resultservicetax1)) {?>

                                                                        <option value="<?php echo odbc_result($resultservicetax1,"Total Service Tax") ?>"><?php echo odbc_result($resultservicetax1,"Total Service Tax") ?></option>
                                                              <?php } ?>
                                                                      </select>
                                                            </td>
                                                            
                                                            <td>Warranty</td>
                                                            <td><input type="checkbox" name="warranty" id="warranty" class="warranty" value="warranty"/></td>
                                                            <td><input id='other-text' placeholder='please enter animal' type='text'/></td>
                                                            <td><input  type="text" class="subtotal"  id="subtotal1" name="subtotal[]" size="10" value="0.00" readonly=""/> </td>
                                                            <td> <a href="javascript:void(0);"  onclick="addrow();">Add</a>
                                                            </td>
                                    </tr>
                             </table>
                             <table style="width: 95%;">
                                 <tr>
                                     <td style="text-align: right;" class="col-md-10"><b>Grand Total</b></td>
                                 <td><input  type="text" size="10" class="form-control" value="0.00" name="gtotal" readonly="" id="gtotal" readonly=""/></td>
                                 </tr>
                            </table>