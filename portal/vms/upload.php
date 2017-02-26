
<?php
 require_once 'Header1.php';
 
 
  $SQL = "SELECT * FROM [VMS Create PO] WHERE ID = (SELECT MAX(ID) AS [ID] FROM [VMS Create PO])";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
    
?>
<head>
    
 
    
    <style>
@import 'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin';*,:after,:before{box-sizing:inherit}
html{box-sizing:border-box;font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-size:14px}
body{background:#ffffff;font-family:Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.33;color:rgba(0,0,0,.8);font-smoothing:antialiased}
</style>
    <script type="text/javascript">
        function printContent(el){
        var printButton = document.getElementById("print");
        printButton.style.visibility = 'hidden';
        var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
    
 </script>
 
</head>

<form action="" enctype="multipart/form-data" method="POST">
 
   <div class="container">
        <div class="col-sm-12 col-md-12" id="p1" >
        <div class="col-md-12" >
            <table style="width:100%; margin-top: 15px;" >
                 <tr>
                    <td><input class="btn btn-link" onclick="printContent('p1');" name="submit" value="Click To Print" id="print"/></td> <td colspan="3" align="left"> <h3><b>Purchase Order</b></</h3></td>
                </tr>
                
                <tr>

                
                    <td style="width:20%;" rowspan="3"><img src="<?php echo odbc_result($result1, "Picture")?>" style="width: 100px; height: 100px"></td><td style="width:20%;"> <b><?php echo $SchName;?></b></td><td style="width:30%;">PO No</td><td style="width:20%;"><?php echo odbc_result($result,"PO NO") ?></td>
                </tr>
                
                <tr>
                    <td style="width:30%;"><?php echo $address;?></td><td style="width:20%;">PO Date</td><td style="width:30%;"><?php  echo date('d/M/Y', odbc_result($result, "Purchase Date")) ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><?php echo $city;?>;</td><td style="width:20%;">PO Status</td><td style="width:30%;"><?php echo odbc_result($result,"PO Status") ?></td>
                </tr>
                
                <tr><td colspan="4"><hr> </tr>
                <tr>
                    <td colspan="2"><b><u>Vendor</u></b></td><td colspan="2"><b><u>Shipping Address</u></b></td>
                </tr>
                <tr>
                     <td>Vendor</td><td><?php echo odbc_result($result,"Vendor") ?></td><td>Contact Name</td><td><?php echo odbc_result($result,"Shipping Contact Name") ?></td>
                </tr>
                <tr>
                
                     <td>Contact Name</td><td><?php echo odbc_result($result,"Vendor Contact Name") ?></td><td>Mobile</td><td><?php echo odbc_result($result,"Shipping Mobile") ?></td>
                </tr>
                <tr>
                     <td>Mobile</td><td><?php echo odbc_result($result,"Mobile") ?></td></td><td>Email</td><td><?php echo odbc_result($result,"Shipping Email") ?></td>
                     
                </tr>
                <tr>
                     <td>Address</td><td><?php echo odbc_result($result,"Address") ?></td><td>Address</td><td><?php echo odbc_result($result,"Shipping Address") ?></td>
                    
                </tr>
                <tr>
                     <td>City</td><td><?php echo odbc_result($result,"City") ?></td><td>City</td><td><?php echo odbc_result($result,"Shipping City") ?></td>
                </tr>
                <tr>
                     <td>State</td><td><?php echo odbc_result($result,"State") ?></td><td>State</td><td><?php echo odbc_result($result,"Shipping State") ?></td>
                                      
                </tr>
                <tr>
                     <td>Country</td><td><?php echo odbc_result($result,"Country") ?></td><td>Country</td><td><?php echo odbc_result($result,"Shipping Country") ?></td>
                </tr>                   
               
            </table>
               
             </div>
    <div class="col-md-12">
                   <?php 
                  $SQL1 = "SELECT * FROM [VMS Final PO] WHERE [PO ID] ='".  odbc_result($result,"ID")."'";
                   $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
                   ?>
                    <table style="margin-top: 10px; width: 100%; border: 1px solid #d3d3d3; border-style: dashed;">
                       
                        <tr>
                            <th class="col-sm-4 col-md-1" style="border: 1px solid #d3d3d3; border-style: dashed;">Sr</th>
                            <th class="col-sm-4 col-md-2" style="border: 1px solid #d3d3d3; border-style: dashed;">Item&nbsp;Name</th>
                            <th class="col-sm-4 col-md-2" style="border: 1px solid #d3d3d3; border-style: dashed;">Specifications</th>
                            <th class="col-sm-4 col-md-1" style="border: 1px solid #d3d3d3; border-style: dashed;">UOM</th>
                            <th class="col-sm-4 col-md-1" style="border: 1px solid #d3d3d3; border-style: dashed;">Warranty(Yr)</th>
                            <th class="col-sm-4 col-md-1" style="border: 1px solid #d3d3d3; border-style: dashed;">Qty</th>
                            <th class="col-sm-4 col-md-2" style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Unit&nbsp;Price</th>
                            <th class="col-sm-4 col-md-1" style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">VAT/CST%</th>
                            <th class="col-sm-4 col-md-1" style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Service&nbsp;Tax%</th>
                            <th class="col-sm-4 col-md-1" style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Total</th>
                           
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result1)){?>
                        <tbody id='table' style="border: 1px solid #d3d3d3; border-style: dashed;">
                        <tr>
                            <td class="col-sm-4 col-md-1" style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo $i; ?></td>
                            <td class="col-sm-4 col-md-2" style="width: 15%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Item Name") ?></td>
                            <td class="col-sm-4 col-md-2" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Specifications") ?></td>
                            <td class="col-sm-4 col-md-1" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"UOM") ?></td>
                            <td class="col-sm-4 col-md-1" style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Warranty") ?></td>
                            <td class="col-sm-4 col-md-1" style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Qty") ?></td>
                            <td class="col-sm-4 col-md-2" align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Unit Price")=='0'){
                            echo '0.00';} else{ echo odbc_result($result1,"Unit Price"); }
                             ?></td>
                            <td class="col-sm-4 col-md-1" align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"VAT CST")=='0'){
                               echo '0.00';} else{ echo odbc_result($result1,"VAT CST"); }
                                ?></td>
                           
                            <td class="col-sm-4 col-md-1" align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Service Tax")=='0'){ 
                            echo '0.00';} else{ echo odbc_result($result1,"Service Tax"); }
                                ?></td>
                          
                            
                            <td class="col-sm-4 col-md-1" align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Sub Total")=='0'){
                                   echo '0.00';} else{ echo odbc_result($result1,"Sub Total"); }
                                    ?></td>
              
                           
                        </tr>
                       <?php $i++;}?>
                        <tr style="border: 1px solid #d3d3d3; border-style: dashed;">
                            <td colspan="8">
                                &nbsp;
                            </td>
                            <td style="text-align: center;">
                                Grand Total
                            </td>
                            <td align="center">
                                <?php echo odbc_result($result1,"Gtotal") ?>
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
                    <table style="width:100%; margin-top:255px;">
                    <tr>
                    <td style="text-align:right;"> Authorised Signatory</td></tr>
                    <tr>
                    <td style="text-align:right;"><?php echo "(".$SchName.")";?></td>
                    </tr>
                    </table>
                    <div>
                    <table style="margin-top: 10px; width: 100%;">
                       
                        <tr>
                            <td><b>Terms and Conditions</b></td>
                        </tr>
                        <tr>
                            <?php 
                             $SQLTERM = "SELECT * FROM [VMS Term Condition] WHERE ID = (SELECT MAX(ID) AS [ID] FROM [VMS Term Condition])";
                             $resultterm = odbc_exec($conn, $SQLTERM) or die(odbc_errormsg($conn));
                            ?>
                            <td><?php echo odbc_result($resultterm, "Term Condition") ?></td>
                        </tr>
                    </table>
                                                 
             </div>
        </div>
            
  </div>
  
</form>
