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
<h2>Fee Reversal </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

			<!--  <form action="FeeReceiptEntry.php" method="get"> -->
			<form action="#" method="get">
				<table class="table table-responsive">
					<tr>
						<td style="border: none;">Fee Invoice No.</td>
						<td style="border: none;"><input type="text" name="invoice" class="form-control" placeholder="Invoice number" autofill="false" required></td>
						<td style="border: none;"><input type="submit" value="Submit" class="btn btn-primary"></td>
					</tr>
				</table>
			</form>

</div>
</div>
</div>
</div>
			

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Search for <?php echo $_GET['invoice']?> ...</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
	
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
		<thead>
			<tr>
				<th>SN</th>
				<!--th>Customer No.</th-->
                                <th>Student No.</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Academic Year</th>
				<th>Class</th>
				<th style="text-align: center;">Fee Amount</th>
				<th style="text-align: center;">Paid</th>
				<th style="text-align: center;">O/S Amount</th>
				<!--th>Action</th-->
			</tr>
		</thead>
		<tbody>
		<?php
                //invoice
                 $query2 = "SELECT * FROM [Ledger Invoice] WHERE [Company Name]='$ms' AND ([Invoice No]='".$_GET['invoice']."')";
		$rs2 = odbc_exec($conn, $query2) or die(odbc_errormsg($conn));	
                //admission no
              /*  $query1 = "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND ([No_]='".$_GET['invoice']."')";
		$rs1 = odbc_exec($conn, $query1) or die(odbc_errormsg($conn));	*/
                 $i = 1;
			if($_SERVER['REQUEST_METHOD'] == 'GET' && $_REQUEST['invoice'] != ""){
                                $query = "SELECT * FROM [Temp Application] WHERE [Company Name]='$ms' AND ([System Genrated No_]='".$_GET['invoice']."' OR [System Genrated No_]='".odbc_result($rs2, "Customer No")."' OR [Name] LIKE '%".$_GET['invoice']."%')";
                                /*if(odbc_num_rows($query)==0){
                                    $query = "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND ([No_]='".$_GET['invoice']."' OR [Name] LIKE '%".$_GET['invoice']."%')";
                                }
                            	*/
				$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
                                    $Admissionno = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [Registration No_]='".odbc_result($rs, "System Genrated No_")."'") or die(odbc_errormsg($conn));
		?>
                <form role="form" method="post" action="RevInvoceCalcEdit.php" name="AdmForm1" onkeypress="return event.keyCode != 13;">
		<tr>
			<td><?php echo $i?></td>
                       
                        <!--td><a href="FeeReceiptEntry.php?invoice=<--?php echo odbc_result($rs, "System Genrated No_")?>"><--?php echo odbc_result($rs, "System Genrated No_");?></a></td-->
                        <!--td><a href="RevFeeReceiptNew.php?ID=<--?php echo odbc_result($Admissionno, "Registration No_")?>&invoice=<--?php echo $_REQUEST['invoice'];?>"><--?php echo odbc_result($Admissionno, "No_");?></a></td-->
			 <td><?php echo odbc_result($Admissionno, "No_");?></td>
                         <td><a href="RevFeeReceiptNew.php?ID=<?php echo odbc_result($Admissionno, "Registration No_")?>&invoice=<?php echo $_REQUEST['invoice'];?>"><?php echo odbc_result($rs, "Name");?></a></td>
			<td><?php 
				if(odbc_result($rs, "Gender")==1) echo "Boy";
				if(odbc_result($rs, "Gender")==2) echo "Girl";
			?></td>
			<td><?php echo odbc_result($rs, "Academic Year");?></td>
			<td><?php echo odbc_result($rs, "Class");?></td>
			<td style="text-align: right;">
				<?php 
					$fee_amt = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Reverse]=0 AND [Company Name]='$ms' AND [Customer No]='".odbc_result($rs, "System Genrated No_")."'") or die(odbc_errormsg($conn));
					echo number_format(odbc_result($fee_amt, ""), 2, '.', '');
				?>
			</td>
			<td style="text-align: right;">
				<?php 
					$pay_amt = odbc_exec($conn, "SELECT SUM([Debit Amount]+[Adv Fee]) FROM [Ledger Debit] WHERE [Reverse]=0 AND [Company Name]='$ms' AND [Customer No]='".odbc_result($rs, "System Genrated No_")."'") or die(odbc_errormsg($conn));
					echo number_format(odbc_result($pay_amt, ""), 2, '.', '');
				?>
			</td>
			<td style="text-align: right;">
				<?php 
					echo number_format(odbc_result($fee_amt, ""), 2, '.', '') - number_format(odbc_result($pay_amt, ""), 2, '.', ''); 
				?>
			</td>
			 <!--td><select name="ReverseStatus" class="form-control">
                <option value='1'>Reverse</option>
                <option value='2'>Reverse And Genrste</option>
                </select></td-->
                         <input type="hidden" name="ID" class="form-control" value="<?php echo odbc_result($Admissionno, "Registration No_")?>">
                 <input type="hidden" name="invoice" class="form-control" value="<?php echo $_REQUEST['invoice'];?>">
                        <!--td style="text-align: right;"><input type="submit" style=" background-color: Green;" value="Reverse Invoice" class="btn btn-primary"></td-->
               
                </tr>
		<?php 
					$i++;
				}
			}
		?>
                </form>
		
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