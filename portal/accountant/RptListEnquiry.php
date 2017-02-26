<?php
	require_once("header.php");
	$e=isset($_REQUST['e']);
	$Enqr=isset($_REQUEST['enq']);
	if($Enqr != ""){
		if($e=1){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User enqury has been updated.
					</div>
				</div>
			</div></div>";
		}
		if($e=0){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Error!</strong> There is some error, kindly check.
					</div>
				</div>
				</div>";
		}
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
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Enquiry List  </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
			<thead>
				<tr>
					<td>SN</td>
					<td>Enquiry<br />No.</td>
					<td>Registration<br />Status</td>
					<td>Admission<br />Status</td>
					<td>Enquiry<br />Source</td>
					<td>Enquiry<br />Status</td>
					<td>Candidate<br />Name</td>
					<td>Father's<br />Name</td>
					<td>Follow-up<br />1</td>
					<td>Follow-up<br />2</td>
					<td>Follow-up<br />3</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$result=odbc_exec($conn, "SELECT [No_], [Registration Status], [AdmissionStatus],[Enquiry Source], [Enquiry Status],[Name],[Mother_s Name],[Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3]    FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND YEAR([Enquiry Date])='".$_GET['y']."' AND MONTH([Enquiry Date]) LIKE '".$_GET['m']."%' ORDER BY [Enquiry Date] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($result)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i?></td>
					<td><?php echo odbc_result($result, "No_")?></td>
					<td align="center"><?php
							$row1=odbc_result($result, "Registration Status");
							if($row1==1){ echo "<font class='text-success'>&#x2713;</font>";}
							if($row1==0){ echo "<font class='text-danger'>&#x2717;</font>";}
							if($row1==""){ echo "<font class='text-danger'>&#8212;</font>";}
						?></td>
					<td align="center"><?php
							$row2=odbc_result($result, "AdmissionStatus");
							if($row2=="1") echo "<font class='text-danger'>&#x2713;</font>";
							if($row2=="0") echo "<font class='text-danger'>&#x2717;</font>";
							if($row2=="") echo "<font class='text-danger'>&#8212;</font>";							
						?></td>
					<td><?php echo odbc_result($result, "Enquiry Source")?></td>
					<td align="center"><?php
						$enqStat = odbc_result($result, "Enquiry Status");
						if($enqStat == 0) echo "Hot";
						if($enqStat == 1) echo "Cold";
						if($enqStat == 2) echo "Warm";
					?></td>
					<td><?php echo odbc_result($result, "Name")?></td>
					<td><?php echo odbc_result($result, "Father_s Name")?></td>
					<td><?php echo odbc_result($result, "FollowUP1")?></td>
					<td><?php echo odbc_result($result, "FollowUP2")?></td>
					<td><?php echo odbc_result($result, "FollowUP3")?></td>
					<td>
						<div class="bs-example">
							<a href="ListEnquiry.php?id=<?php echo odbc_result($result, "No_")?>#myModal<?=$i?>" class="text-primary" data-toggle="modal">View</a>
							 <?php
								require("RptModalEnquiry.php");
							?>
						</div>
					</td>
				</tr>
				<?php
						$i += 1;
					}					
				?>
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

<?php
	require_once("../footer.php");
?>