<?php require_once("header.php");?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Fee in Pipeline <small>Fees not yet realised</small> </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>S/N</th>
                <th>Student<br />No.</th>
				<!--th>Customer No.</th-->
				<th>Name</th>
				<th>Class</th>
				<th>Payment<br />Mode</th>
				<th>Payment<br />Date</th>
				<th>Instr. No.</th>
				<th>Instr. Date</th>
				<th>Bank/<br />Branch<br />Name</th>
				<th>Amount</th>
			</tr>
		</thead>
	    <tbody>
	<?php 
		$i = 1;
		
		$query = "SELECT * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Payment Realization]=0";
		
		$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
		<tr>
			<td><?php echo $i; ?>
                        <?php $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='".odbc_result($rs, "Customer No")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn)); 
			$AdmissionNo = odbc_result($Admission, "No_");?>
                        <td><a href="Pipeline.php?cust=<?php echo odbc_result($rs, "Customer No");?>"><?php echo $AdmissionNo;?></a></td>
			<!--td><a href="Pipeline.php?cust=<--?php echo odbc_result($rs, "Customer No");?>"><--?php echo odbc_result($rs, "Customer No");?></a></td-->
			<?php 
				$cust = odbc_exec($conn, "SELECT [Name], [Class] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
			?>
			<td><?php echo odbc_result($cust, "Name")?></td>
			<td><?php echo odbc_result($cust, "Class")?></td>
			<td><?php echo odbc_result($rs, "Payment Mode")?></td>
			<td><?php echo date('d/M/Y', odbc_result($rs, "Payment Date"))?></td>
			<?php if(odbc_result($rs, "Cheque No")!=""){?>
            <td><?php echo odbc_result($rs, "Cheque No")?></td>
                <?php }else{ ?>
                 <td><?php echo "N/A"?></td>
                <?php } ?>
            <td><?php echo odbc_result($rs, "Cheque Date")!="1900-01-01 00:00:00.000"?date('d/M/Y', strtotime(odbc_result($rs, "Cheque Date"))):"";?></td>
			<?php if(odbc_result($rs, "Bank Name")!=""){ ?>
                        <td><?php echo odbc_result($rs, "Bank Name")?></td>
                        <?php }else{ ?>
                        <td><?php echo "CASH"?></td>
                        <?php } ?>
			<td style="text-align: right;"><?php echo number_format((odbc_result($rs, "Debit Amount")+odbc_result($rs, "Adv Fee")),2,'.','')?></td>
		</tr>
	<?php 
			$i++;
		}
	?>
        <tr style="font-weight: bold;">
                <td>TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">
                    <?php 
                    $tot_amt = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0") or die(odbc_errormsg($conn));
                    echo number_format(odbc_result($tot_amt, ""),2,'.','');
                    ?>
                </td>
        </tr>
	    </tbody>
	</table>

<!-- /Content -->
</div>
</div>
</div>
</div>
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

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>


<!-- Datatables -->
<script>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<!-- /Datatables -->


<?php require_once("../footer.php"); ?>