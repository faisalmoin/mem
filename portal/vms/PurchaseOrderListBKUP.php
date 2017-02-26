
<?php
 require_once 'Header1.php';
 
 
  $SQL = "SELECT * FROM [VMS Create PO] WHERE ID = (SELECT MAX(ID) AS [ID] FROM [VMS Create PO])";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		$SQL1 = "SELECT Picture FROM [Company Information] WHERE ID = '".$CompName."'";
 $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
  $SQLTERM = "SELECT * FROM [VMS Term Condition] WHERE ID = (SELECT MAX(ID) AS [ID] FROM [VMS Term Condition])";
                             $resultterm = odbc_exec($conn, $SQLTERM) or die(odbc_errormsg($conn));
?>
<head>
    
 
    
    <style>
@import 'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin';*,:after,:before{box-sizing:inherit}
html{box-sizing:border-box;font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-size:14px}
body{background:#ffffff;font-family:Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.33;color:rgba(0,0,0,.8);font-smoothing:antialiased}
 @media print {
        thead {display: table-header-group;}
        tfoot {display: table-footer-group;}
        tfoot {page-break-after: always;}
        page {page-break-after: always;}
        .page-break { display: block; page-break-before: always; }
    }

     tr.breakhere {page-break-after: always}

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
<div class="container" id="p1">
  <table border=0px style="width: 100%;">
    <thead>
    <tr>
        <td>
          <img src="<?php echo odbc_result($result1, "Picture")?>" style="width: 100px; height: 100px">
        </td>
        <td>
          <input class="btn btn-link" onclick="printContent('p1');" name="submit" value="Click To Print" id="print"/>
        </td>
           <td colspan="4">
            <table>
                <tr>
                   <td> <b style="font-size: 28px;"><?php echo $SchName;?></b></td>
                </tr>
                <tr>
                   <td> <?php echo $address;?></td>
                </tr>
                <tr>
                    <td> <?php echo $city;?></td>
                </tr>
            </table>
       </td>
    </tr>
     <tr>
      <td>
        <b>PO No</b>
      </td>
      <td > <?php echo odbc_result($result,"PO NO") ?></td>
       <td>
        <b>PO Date</b>
        </td>
         <td colspan="3">
         <?php  echo date('d/M/Y', odbc_result($result, "Purchase Date")) ?>
        </td>
    </tr>
    </thead>
   
    <tr>
       <td colspan="6" style="background-color:#eee ;">
           <h5 style="font-weight: bold; ">Vendor</h5>
       </td>

    </tr>
    <tr>
       <td colspan="6" >
           <?php echo odbc_result($result,"Vendor") ?>
       </td>
       
    </tr>
    <tr>
     <td colspan="6">
          <?php echo odbc_result($result,"Mobile") ?>
       </td>
    </tr>
    <tr>
    <td colspan="6">
          <?php echo odbc_result($result,"Email") ?>
       </td>
    </tr>
    <tr>
     <td>
          <?php echo odbc_result($result,"Address").",".odbc_result($result,"City").",".odbc_result($result,"State").",".odbc_result($result,"Country") ?>
       </td>
    </tr>
     <tr>
        <td>
          <b> PO Status</b>
        </td>
        <td colspan="5">
          <?php echo odbc_result($result,"PO Status") ?>
        </td>
        
    </tr>
    <tr>
       <td colspan="6" style="background-color:#eee ;">
           <h5 style="font-weight: bold; ">Shipping Details</h5>
       </td>
    </tr>
   
     <tr>
       
       <td>
          Name
       </td>
       <td colspan="5">
          <?php echo odbc_result($result,"Shipping Contact Name") ?>
       </td>
    </tr>
     <tr>
       
       <td>
          Mobile
       </td>
       <td colspan="5">
          <?php echo odbc_result($result,"Shipping Mobile") ?>
       </td>
    </tr>
    <tr>
      
       <td>
          Email
       </td>
       <td colspan="5">
          <?php echo odbc_result($result,"Shipping Email") ?>
       </td>
    </tr>
     <tr>
      
       <td>
         Address
       </td>
       <td colspan="5">
           <?php echo odbc_result($result,"Shipping Address")."," .odbc_result($result,"Shipping City").",".odbc_result($result,"Shipping State").",".odbc_result($result,"Shipping Country")?>
       </td>
    </tr>
    <tr><td colspan="6" style="margin-top:10px;"><b><u>Terms and Conditions</u></b></td></tr>
     <tr>
         <td colspan="6">    
                    
                    <table style="width: 100%; margin-top:10px;">
                       
                        <tr>
                            <td><?php echo odbc_result($resultterm, "Term Condition") ?></td>
                        </tr>
                    </table>
         </td>
        </tr>
        
    <tr class="page-break">
       <td colspan="6" style="background-color:#eee ;">
           <h5 style="font-weight: bold; ">Item Details</h5>
       </td>
    </tr>

    
    <tr>
      <td colspan="6">
               <?php 
                  $SQL1 = "SELECT * FROM [VMS Final PO] WHERE [PO ID] ='".  odbc_result($result,"ID")."'";
                   $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
                   ?>
                    <table style="border: 1px solid #d3d3d3; border-style: dashed;">
                       
                        <tr>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">Sr</th>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">Item&nbsp;Name</th>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">Specifications</th>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">UOM</th>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">Warranty(Yr)</th>
                            <th  style="border: 1px solid #d3d3d3; border-style: dashed;">Qty</th>
                            <th  style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Unit&nbsp;Price</th>
                            <th  style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">VAT/CST%</th>
                            <th  style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Service&nbsp;Tax%</th>
                            <th  style="text-align: right; border: 1px solid #d3d3d3; border-style: dashed;">Total</th>
                           
                        </tr>
                       <?php $i=1;while(odbc_fetch_array($result1)){?>
                        <tbody id='table' style="border: 1px solid #d3d3d3; border-style: dashed;">
                        <tr>
                            <td  style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo $i; ?></td>
                            <td  style="width: 15%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Item Name") ?></td>
                            <td  style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Specifications") ?></td>
                            <td  style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"UOM") ?></td>
                            <td  style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Warranty") ?></td>
                            <td  style="width: 5%; border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($result1,"Qty") ?></td>
                            <td  align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Unit Price")=='0'){
                            echo '0.00';} else{ echo odbc_result($result1,"Unit Price"); }
                             ?></td>
                            <td  align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"VAT CST")=='0'){
                               echo '0.00';} else{ echo odbc_result($result1,"VAT CST"); }
                                ?></td>
                            <td  align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Service Tax")=='0'){ 
                            echo '0.00';} else{ echo odbc_result($result1,"Service Tax"); }
                                ?></td>
                          
                            
                            <td  align="right" style="width: 10%; border: 1px solid #d3d3d3; border-style: dashed;"><?php if(odbc_result($result1,"Sub Total")=='0'){
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
                            <td align="right">
                                <?php echo odbc_result($result1,"Gtotal") ?>
                            </td>
                        </tr>
                        
                        </tbody>
                    </table>
              </td>
         </tr>
            
       <tfoot>
         <tr>
           <td colspan="6">

                    <table style="width:100%; margin-top:155px;">
                      <tr>
                        <td style="text-align:left;"> Authorised Signatory</td>
                      </tr>
                      <tr>
                        <td style="text-align:left;"><?php echo "(".$SchName.")";?></td>
                      </tr>
                    </table>
            </td>
        </tr>
        </tfoot>
     </table>
  </div>

	
</form>
