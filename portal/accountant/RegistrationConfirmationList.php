<?php
	require_once("header.php");
	
	/*if($_GET['id'] != ""){
		echo "<div class='container'>
				<div class='alert alert-success alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Success!</strong> Application No. - ".$_GET['id'].", has been RECEIVED and Registered.
				</div>
			</div>";
		}*/
	
	if($_GET['gPage']=="" || $_GET['gPage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$eCurr = $_GET['gPage'];
		$e_max=50*$eCurr;
		$e_min = ($e_max - 50);
	}
	
?>

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
	<?php if($_GET['id'] != ""){
		echo "<div class='container'>
				<div class='alert alert-success alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Success!</strong> Application No. - ".$_GET['id'].", has been RECEIVED and Registered.
				</div>
			</div>";
		}?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Registration Confirmation </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->
	<div class="table-responsive">
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />			
			<thead>
				<tr>
					<th>Registration<br />No.</th>
					<th>Registration<br />Form No.</th>
					<th>Candidate<br />Name</th>
					<th>Class<br />Applied</th>
					<th>Application<br />Status</th>
					<th>Sale<br />Date</th>
					<th>Confirmation<br />Date</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				//$rs=odbc_exec($conn, "SELECT TOP 50 [Enquiry No_], [No_],[Registration No_],[Name],[Class],[Registration Status], [Date of Sale],  [Date of Receive]  FROM [Temp Application] WHERE [Registration Status] = 1 AND [Company Name]='$ms'");
				$rs=odbc_exec($conn, "SELECT [Enquiry No_], [No_],[Registration No_],[Name],[Class],[Registration Status], [Date of Sale],  [Date of Receive] FROM ( 
			SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Sale] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] = 1 AND [Date of Receive] = ''
			) a WHERE a.row > $e_min and a.row <= $e_max");
				while(odbc_fetch_array($rs)){
			?>
			<tr>
				<td><?php echo odbc_result($rs, "No_")?></td>
				<td><?php echo odbc_result($rs, "Registration No_")?></td>
				<td><?php echo odbc_result($rs, "Name")?></td>
				<td><?php echo odbc_result($rs, "Class")?></td>
				<td><?php
                        if(odbc_result($rs, "Registration Status")==1) echo "SOLD";
                        if(odbc_result($rs, "Registration Status")==2) echo "RECEIVED";
                        if(odbc_result($rs, "Registration Status")==3) echo "SELECTED";
                        if(odbc_result($rs, "Registration Status")==4) echo "PENDING APPROVAL";
                        if(odbc_result($rs, "Registration Status")==5) echo "APPROVED";
                        if(odbc_result($rs, "Registration Status")==6) echo "ADMITTED";
                    ?></td>
				<td><?php 
					$date1 = date('d/M/Y', strtotime(odbc_result($rs, "Date of Sale")));
					if($date1 == '01/Jan/1753' || $date1 == '01/Jan/1970'){
					    echo "-";
					}
					else{
					    echo $date1;
					}
				?></td>
				<td><?php
                        $date = date('d/M/Y', strtotime(odbc_result($rs, "Date of Receive")));
                        if($date == '01/Jan/1753' || $date == '01/Jan/1970'){
                            echo "-";
                        }
                        else{
                            echo $date;
                        }
                     ?></td>
				<td>
					<div class="bs-example">						
						<?php
							if(odbc_result($rs, "Registration Status") == 1){
						?>
							<a href="NewRegistrationConfirm.php?id=<?php echo odbc_result($rs, 'Enquiry No_')?>" class="btn btn-lg btn-primary btn-sm" data-toggle="modal">Confirm</a>
						 <?php
						 }
						 else{
							echo "<a href='ViewRegistrationConfirm.php?odbc_result($rs, 'Enquiry No_')' class='btn btn-lg btn-primary btn-sm' data-toggle='modal'>View</a>";
						 }
						 ?>
					</div>
					
				</td>
			</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>

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

 

<?php require_once("../footer.php");?>