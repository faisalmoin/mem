<?php
require_once('header1.php');

	$inv_dt = time();
    $inv_last_dt = date('t');

    $today = $inv_dt;
    $this_yr = strtotime(date("Y", $today)."-04-01");
    $nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
    $this_yr = strtotime(date("Y", $today)."-04-01");
    $nxt_yr = strtotime((date("Y", $today)+1)."-03-31");

if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
    $FinYr = date('y', $today)."-".(date('y', $today)+1);
}
	
?>
<head>
<style>

.tag a {
    color:   white  ;
}
</style>
<script src="../bs/js/Chart.js" language="JavaScript"></script>
<!-- Custom styles for this template -->
</head>
<div class="container">
	
    <div class="col-sm-10 col-sm-offset-1 main">
        <h1>Purchase Dashboard &emsp;&emsp;<small><a href="Create_PO_Order.php" class="btn btn-warning">New Purchase Order</a></small> </h1>
               
    <hr>
        <div class="row">
            
            <?php
	 $sql2 = "SELECT COUNT(*) FROM [VMS Create PO] WHERE  [PO Status] ='OPEN' AND [Company Name]='".$CompName."'";
	    $Reg = odbc_exec($conn,$sql2);
        ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #449d44;">
                    <div class="panel-right pull-center tag" style="background-color: #449d44; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <a href="Dashboard_Listing.php?Status=Open"><h1><?php echo odbc_result($Reg, "")?></h1></a> 
                        <strong> Open</strong>
                    </div>
                </div>
            </div>
            <?php
            $sql3 = "SELECT COUNT(*) FROM [VMS Create PO] WHERE  [PO Status] = 'Closed' AND [Company Name]='".$CompName."'";
	    $Sel = odbc_exec($conn,$sql3);
            ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-green" style="background-color: #DE70CC; border-color: #DE70CC;">
                    <div class="panel-right pull-center tag" style="background-color: #DE70CC; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <a href="Dashboard_Listing.php?Status=Closed"><h1><?php echo odbc_result($Sel, "")?></h1></a> 
                        <strong> Closed </strong>
                    </div>
                </div>
            </div>
            <?php
                $sql4 = "SELECT COUNT(*) FROM [VMS Create PO] WHERE  [PO Status] = 'Short-Closed' AND [Company Name]='".$CompName."'";
                $Adm = odbc_exec($conn,$sql4);
            ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #E6AB16; border-color: #E6AB16;">
                    <div class="panel-right pull-center tag" style="background-color: #E6AB16; color: #ffffff; font-weight: bolder;  font-size: 24px;">
                        <a href="Dashboard_Listing.php?Status=Short-Closed"><h1><?php echo odbc_result($Adm, "")?></h1></a> 
                        <strong>Short Closed</strong>
                    </div>
                </div>
            </div>
             <?php
                    $sql1 = "SELECT COUNT(*) FROM [VMS Create PO] WHERE  [Company Name]='".$CompName."' AND [PO Status]='Cancel' ";
                        $Enq = odbc_exec($conn,$sql1);
                ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-green" style="background-color: #0088cc;">
                    <div class="panel-right pull-center tag" style="background-color: #0088cc; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <a href="Dashboard_Listing.php?Status=Cancel"><h1><?php echo odbc_result($Enq, "")?></h1></a> 
                        <strong> Cancel</strong>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <table class="table table-striped" >
                            <thead>
                            <tr style="font-weight: bold; background-color: #E6AB16; color: #fff;">
                                <td>Total PO</td>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $EnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Create PO] WHERE  [Company Name]='".$SchName."'  ");
                            while(odbc_fetch_array($EnqStat)){
                                ?>
                                <tr>
                                    
                                    <td align="center">
                                        <?php
                                        $CntEnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Create PO] WHERE [Company Name]='".$CompName."'");?>
                                           <a href="PurchaseOrderList.php"><?php echo odbc_result($CntEnqStat, "")?></a>
                                       
                                    </td>
                                </tr>
                              
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                      
                              
                        <table class="table table-striped" >
                            <thead>
                            <tr style="font-weight: bold; background-color: #E6AB16; color: #fff;">
                                <td>Total Vendor</td>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $EnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Vendor Master] WHERE  [Company Name]='".$CompName."'  ");
                            while(odbc_fetch_array($EnqStat)){
                                ?>
                                <tr>
                                    
                                    <td align="center">
                                        <?php
                                        $CntEnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Vendor Master] WHERE  [Company Name]='".$CompName."'  ");?>
                                          <a href="VendorItemList.php"><?php echo odbc_result($CntEnqStat, "")?></a>
                                        
                                    </td>
                                </tr>
                              
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>   
                                
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                      
                              
                        <table class="table table-striped" >
                            <thead>
                            <tr style="font-weight: bold; background-color: #E6AB16; color: #fff;">
                                <td>Total Items</td>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                      
                            $EnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Item Master] WHERE  [Company Name]='".$CompName."'  ");
                            while(odbc_fetch_array($EnqStat)){
                                ?>
                                <tr>
                                    
                                    <td align="center">
                                        <?php
                                        $CntEnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [VMS Item Master] WHERE  [Company Name]='".$CompName."'  ");?>
                                          <a href="Item_List.php"><?php echo odbc_result($CntEnqStat, "")?></a>
                                      
                                    </td>
                                </tr>
                              
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>   
                                
                </div>
        </div>

        <hr>

        <div class="table-responsive">
            <h3>Previous Purchase Orders</h3>
            <?php
                $Followups = odbc_exec($conn, "SELECT TOP 10 * FROM [VMS Create PO]  WHERE [Company Name]='".$CompName."' ORDER BY ID DESC");
            ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr style="font-weight: bold; background-color: #0088cc; color: #fff;">
                        <td>SN</td>
                        <td>PO No</td>
                        <td>PO Date</td>
                        <td>Vendor</td>
                        <td>PO Status</td>
                        <td>Financial Year</td>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=1;
                        while(odbc_fetch_array($Followups)){
                    ?>
                    <tr> 
                        <td><?php echo $i?></td>
                         <td><a href="PurchaseOrderListView.php?ID=<?php echo odbc_result($Followups,"ID")?>"><?php echo odbc_result($Followups,"PO No")?></a></td>
                        <td><?php echo date('d/M/Y', odbc_result($Followups, "Purchase Date"))?></td>
                        <td><?php echo odbc_result($Followups,"Vendor")?></td>
                        <td><?php echo odbc_result($Followups,"PO Status")?></td>
                        <td><?php echo odbc_result($Followups,"Financial Year")?></td>

                        
                    </tr>
                    <?php
                            $i += 1;
                        }

                    ?>
                    <tr>
                    <td colspan="6" align="right"> <a href="PurchaseOrderList.php">+more</a></td>
                    </tr>
                </tbody>
            </table>

        </div>

        </div>
</div>
