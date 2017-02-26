
<?php
 require_once 'header.php';
 
  
 $SQL = "SELECT * FROM [VMS Create PO] WHERE ID = '".$_REQUEST['ID']."'";
 $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
	
 $SQL1 = "SELECT Picture FROM [Company Information] WHERE ID = '".$CompName."'";
 $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
  $SQLTERM = "SELECT * FROM [VMS Term Condition] WHERE [PO ID] = '".$_REQUEST['ID']."'";
                             $resultterm = odbc_exec($conn, $SQLTERM) or die(odbc_errormsg($conn));
?>

<!-- Body -->
<div class="right_col" role="main" style="border-left: 1px solid #d2d2d2;">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<!-- Section 1 -->
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>PO Details </h2> <!-- Page Name -->

<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Section Content -->

  <div class="col-md-8 col-lg-8 col-sm-7">
    <img src="<?php echo odbc_result($result1, "Picture")?>" style="width: 100px; height: 100px;" align="left">
    <h1><?php echo $SchName;?></h1>
    <?php echo $address;?><br />
    <?php echo $city;?>
  </div>
  <div class="col-md-4 col-lg-4 col-sm-5">
    <p><strong>PO No. :</strong> <?php echo odbc_result($result,"PO NO") ?></p>
    <p><strong>PO Date. :</strong> <?php echo date("d/M/Y", odbc_result($result,"Purchase Date")) ?></p>
    <p><strong>PO Status :</strong> <?php echo odbc_result($result,"PO Status") ?></p>
  </div>

<!-- /Section Content -->
</div>
</div>
</div>
</div>

<!-- /Section 1 -->
<div class="row">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Shipping Address</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <p><strong><?php echo odbc_result($result,"Shipping Contact Name") ?></strong></p>
      <p><?php echo odbc_result($result,"Shipping Address")."," .odbc_result($result,"Shipping City").",".odbc_result($result,"Shipping State").",".odbc_result($result,"Shipping Country")?></p>
      <p><?php echo odbc_result($result,"Shipping Mobile") ?></p>
      <p><?php echo odbc_result($result,"Shipping Email") ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <!-- /Section 1 -->
    <div class="x_panel">
      <div class="x_title">
        <h2>Vendor</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <p><strong><?php echo odbc_result($result,"Vendor") ?></strong></p>
        <p><?php echo odbc_result($result,"Address").",".odbc_result($result,"City").",".odbc_result($result,"State").",".odbc_result($result,"Country") ?></p>
        <p><?php echo odbc_result($result,"Mobile") ?></p>
        <p><?php echo odbc_result($result,"Email") ?></p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Terms and Conditions</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p><?php echo odbc_result($resultterm, "Term Condition") ?></p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Item Details</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php 
          $SQL1 = "SELECT * FROM [VMS Final PO] WHERE [PO ID] ='".  odbc_result($result,"ID")."'";
          $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
        ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th align="center"> # </th>
              <th>Item&nbsp;Name</th>
              <th>Specifications</th>
              <th align="center">UOM</th>
              <th align="center">Warranty(Yr)</th>
              <th align="center">Qty</th>
              <th align="center">Unit&nbsp;Price</th>
              <th align="center">VAT/CST%</th>
              <th align="center">Service&nbsp;Tax%</th>
              <th>Total</th>             
            </tr>
          </thead>
          <tbody>
            <?php $i=1;while(odbc_fetch_array($result1)){?>
            <tr>
              <td align="center"><?php echo $i; ?></td>
              <td><?php echo odbc_result($result1,"Item Name") ?></td>
              <td><?php echo odbc_result($result1,"Specifications") ?></td>
              <td align="center"><?php echo odbc_result($result1,"UOM") ?></td>
              <td align="center"><?php echo odbc_result($result1,"Warranty") ?></td>
              <td align="center"><?php echo odbc_result($result1,"Qty") ?></td>
              <td align="center" ><?php if(odbc_result($result1,"Unit Price")=='0'){
              echo '0.00';} else{ echo odbc_result($result1,"Unit Price"); }
              ?></td>
              <td  align="center" ><?php if(odbc_result($result1,"VAT CST")=='0'){
              echo '0.00';} else{ echo odbc_result($result1,"VAT CST"); }
              ?></td>
              <td  align="center" ><?php if(odbc_result($result1,"Service Tax")=='0'){ 
              echo '0.00';} else{ echo odbc_result($result1,"Service Tax"); }
              ?></td>
              <td  align="right" ><?php if(odbc_result($result1,"Sub Total")=='0'){
              echo '0.00';} else{ echo '<span class="fa fa-inr"></span> '.odbc_result($result1,"Sub Total"); }
              ?></td>
            </tr>
            <?php $i++;}?>
            <tr style="font-size:18px;">
              <td colspan="9">
              Grand Total
              </td>
              <td align="right">
                <span class="fa fa-inr"></span> <?php echo odbc_result($result1,"Gtotal") ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- /Section Content -->
</div>
</div>
</div>
</div>
<!-- /Section 1 -->

<!-- /Section Content -->
</div>
</div>
</div>
</div>
<!-- /Section 2 -->

</div>
</div>
</div>
<!-- /Body -->


<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php require_once("../footer.php");?>