<?php
	require_once("header.php");
	$e=isset($_REQUST['e']);
	$Enqr=isset($_REQUEST['enq']);
	if($Enqr != ""){
		if($e=1){
			$msg = "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> Enquiry No. - ".$_REQUEST['enq'].", has been updated.
					</div>
				</div>
			</div></div>";
		}
		if($e=0){
			$msg = "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Error!</strong> There is some error, kindly check.
					</div>
				</div>
				</div>";
		}
	}
	
	if($_GET['ePage']=="" || $_GET['ePage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$eCurr = $_GET['ePage'];
		$e_max=50*$eCurr;
		$e_min = ($e_max - 50);
	}
?>

<style>
ul.pagination {
    display: inline-block;
    padding: 0;
    margin: 0;
}

ul.pagination li {display: inline;}

ul.pagination li a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
}

ul.pagination li a.active {
    background-color: #428bca;
    color: white;
}

ul.pagination li a:hover:not(.active) {background-color: #ddd;}

div.center {text-align: center;}
</style>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


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
<h2>Enquiry List </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
		<?php
			if($msg!=""){echo $msg;}
		?>
		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th> # </th>
					<th>Enquiry<br />No.</th>
					<th>Enquiry<br />Date</th>
					<th>Candidate<br />Name</th>
					<th>Father's<br />Name</th>
					<th>Conact<br />Nos.</th>
					<th>Admission<br />For Year</th>
					<th>Class</th>
					<th>Registration<br />Status</th>
					<th>Admission<br />Status</th>
					<th>Enquiry<br />Source</th>
					<th>Enquiry<br />Status</th>					
					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$result=odbc_exec($conn, "SELECT *   FROM ( 
							SELECT *, ROW_NUMBER() OVER (ORDER BY [Enquiry Date] DESC,[No_] DESC ) as row FROM [Temp Enquiry] WHERE [Company Name]='$ms'
							) a WHERE a.row > $e_min and a.row <= $e_max ") or die(odbc_errormsg($conn));                                        
					if(!$result){
						exit("Error in SQL execution...");
					}
					while(odbc_fetch_row($result)){
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php 
							if(odbc_result($result, "System Genrated No_") != "") echo  odbc_result($result, "System Genrated No_");
							else echo odbc_result($result, "No_");
						?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Enquiry Date")))?></td>
					<td><b><?php echo odbc_result($result, "Name")?></b></td>
					<td><?php echo odbc_result($result, "Father_s Name")?></td>
					<td><?php 
							if(odbc_result($result, "Mobile Number") != "" ) echo "<span class='glyphicon glyphicon-phone'></span>: ".odbc_result($result, "Mobile Number") ." <br />";
							if(odbc_result($result, "Phone Number") != "" ) echo "<span class='glyphicon glyphicon-phone-alt'></span>: ".odbc_result($result, "Phone Number") ." <br />";
							if(odbc_result($result, "Father Mobile") != "" ) echo "F<span class='glyphicon glyphicon-phone'></span>:".odbc_result($result, "Father Mobile") ."<br />";
							if(odbc_result($result, "Mother Mobile") != "" ) echo "M<span class='glyphicon glyphicon-phone'></span>:".odbc_result($result, "Mother Mobile") ."<br />";
						?></td>
					<td><?php echo odbc_result($result, "Admission For Year")?></td>
					<td><?php echo odbc_result($result, "Class Applied")?></td>
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
					
					<td>
							<?php
								if(odbc_result($result, "Registration Status") == 0 && odbc_result($result, "AdmissionStatus") == 0 ){
							?>
							<a href="EditEnquiry.php?id=<?php echo odbc_result($result, "No_")?>" class="text-success" data-toggle="modal">Edit</a>
							<?php
								}
							?>
							<a href="ListEnquiry.php?id=<?php echo odbc_result($result, "No_")?>#myModal<?php echo $i?>"
							 class="text-primary"  data-toggle="modal" data-target=".bs-example-modal-lg">View</a>

							 <?php
								//require("ModalEnquiry.php");
							?>
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