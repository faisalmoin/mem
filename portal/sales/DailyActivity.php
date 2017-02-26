<?php
	require_once("header.php");
?>
<div class="container">
    <h3 class="text-primary">Daily Activity</h3>
    <div class="row" style="background-color: #eee; font-weight: bold;padding: 10px;">
        <div class="col-md-1">SN</div>
        <div class="col-md-1">Date</div>
        <div class="col-md-1">Opp ID</div>
        <div class="col-md-2">Name</div>
        <div class="col-md-2">City</div>
        <div class="col-md-1">Stage</div>
        <div class="col-md-2">Activity</div>
        <div class="col-md-2">Remarks</div>
    </div>
    <?php
        $i=1;
        $rs = odbc_exec($conn, "SELECT * FROM [CRM Opp Activity] WHERE [Assign To]='$LoginID' ORDER BY [Date] DESC") or die(odbc_errormsg($conn));
        while(odbc_fetch_array($rs)){
    ?>
    <div class="row" style="padding: 5px;border-bottom: 1px solid #eee;">
        <div class="col-md-1"><?php echo $i; ?></div>
        <div class="col-md-1"><?php echo date('d/M/Y', odbc_result($rs, "Date")); ?></div>
        <div class="col-md-1"><?php echo odbc_result($rs, "Opp ID"); ?></div>
        <div class="col-md-2"><?php echo odbc_result($rs, "Contact Person"); ?></div>
        <div class="col-md-2"><?php echo odbc_result($rs, "Contact No"); ?></div>
        <div class="col-md-1"><?php echo odbc_result($rs, "Stage"); ?></div>
        <div class="col-md-2"><?php echo odbc_result($rs, "Activities"); ?></div>
        <div class="col-md-2"><?php echo odbc_result($rs, "Remarks"); ?></div>
    </div>
    <?php
            $i++;
        }
    ?>
</div>
<?php require_once("../footer.php"); ?>