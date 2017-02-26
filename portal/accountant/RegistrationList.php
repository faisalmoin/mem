<?php
	require_once("header.php");
	
	if($_GET['rPage']=="" || $_GET['rPage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$e_max=50*$_GET['rPage'];
		$e_min = ($e_max - 50);
	}	
	
?>
<script language="javascript">
var popupWindow = null;
function positionedPopup(url,winName,w,h,t,l,scroll){
settings =
'height='+h+',width='+w+',top='+t+',left='+l+',scrollbars='+scroll+',resizable'
popupWindow = window.open(url,winName,settings)
}
</script>


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
</div>
<div class="x_content">
<!-- Content -->
<h1 class="text-primary">Registration List</h1>
<hr />

	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
		
		<thead>
			<tr>
				<th>Registration No.</th>
				<th>Registration <br> Form No.</th>
				<th>Candidate Name</th>
				<th>Class Applied</th>
				<th>Application <br>Status</th>
				<th>Sale Date</th>
				<th>Confirmation <br> Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
                $i=1;
				//$result=odbc_exec($conn, "SELECT TOP 50 [Enquiry No_],[No_], [Registration No_], [Name], [Class],[Registration Status],[Date of Sale], [Date of Receive]  FROM [Temp Application] WHERE [Registration Status] = 2  AND [Company Name]='$ms'");
				$result=odbc_exec($conn, "SELECT [Enquiry No_],[No_], [Registration No_], [Name], [Class],[Registration Status],[Date of Sale], [Date of Receive]  FROM ( 
									SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Receive] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] <> 0
									) a WHERE a.row > $e_min and a.row <= $e_max ORDER BY [Registration No_] ASC, [No_] ASC ") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($result)){
			?>
			<tr>
				<td><?php echo odbc_result($result, "No_")?></td>
				<td><?php echo odbc_result($result, "Registration No_")?></td>
				<td><?php echo odbc_result($result, "Name")?></td>
				<td><?php echo odbc_result($result, "Class")?></td>
				<td><?php
                    if(odbc_result($result, 'Registration Status') == 1) echo "SOLD";
                    if(odbc_result($result, "Registration Status")==2) echo "RECEIVED";
                    if(odbc_result($result, "Registration Status")==3) echo "SELECTED";
                    if(odbc_result($result, "Registration Status")==4) echo "PENDING APPROVAL";
                    if(odbc_result($result, "Registration Status")==5) echo "APPROVED";
                    if(odbc_result($result, "Registration Status")==6) echo "ADMITTED";
                    ?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Sale")))?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Receive")))?></td>
				<td>
					<div class="bs-example">	
						
						<?php
							//require("ModalRegistration.php");
						?>
						<a href="ReceiptRegistration.php?id=<?php echo odbc_result($result, "Enquiry No_")?>&ms=<?php echo $ms?>&LoginID=<?php echo $LoginID?>"
							onclick="positionedPopup(this.href,'myWindow','700','300','100','200','yes');return false">Receipt</a>
					</div>
					
				</td>
			</tr>
			<?php
                    $i += 1;
				}
			?>
			</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
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