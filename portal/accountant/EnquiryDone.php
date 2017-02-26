<?php
	require_once("header.php");
	
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
<h2>Sale of Registration </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

		<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			<thead>
				<tr>				
					<th>Enquiry<br />No.</th>
					<th>Candidate<br>Name</th>
					<th>Mother's<br>Name</th>
					<th>Father's<br>Name</th>
					<th>Registration<br>Status</th>
					<th>Admission<br>Status</th>
					<th>Enquiry<br>Source</th>
					<th>Enquiry<br>Status</th>					
					<th></th>
				</tr>
			</thead>
            <tbody>
            <?php
            $i=1;
            //$sql="SELECT [No_],[Registration Status],[AdmissionStatus],[Enquiry Source],[Enquiry Status],[Name], [Mother_s Name], [Father_s Name] ,[Registration Status]  FROM [Temp Enquiry] WHERE [Registration Status] = 0 AND [Company Name]='$ms' ORDER BY [Enquiry Date] DESC";
	    $sql = "SELECT [No_],[Registration Status],[AdmissionStatus],[Enquiry Source],[Enquiry Status],[Name], [Mother_s Name], [Father_s Name] ,[Registration Status], [System Genrated No_] FROM ( 
			SELECT *, ROW_NUMBER() OVER (ORDER BY [Enquiry Date] DESC) as row FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND [Registration Status] = 0 AND [Inactive]=0
			) a WHERE a.row > $e_min and a.row <= $e_max ";
					$result = odbc_exec($conn, $sql);
					while($rs = odbc_fetch_array($result)){
                        ?>
                        <tr>
                            <td><?php 
					if(odbc_result($result, "System Genrated No_") != "") {
						echo  odbc_result($result, "System Genrated No_");
					}
					else {
						echo odbc_result($result, "No_");
					}
				?></td>
				<td><?php  echo odbc_result($result, "Name");?></td>
                <td><?php  echo odbc_result($result, "Mother_s Name"); ?></td>
                <td><?php  echo odbc_result($result, "Father_s Name");?></td>
                <td>
                    <?php
                    if(odbc_result($result, "Registration Status")==1) echo "&#x2713;";
                    if(odbc_result($result, "Registration Status")==0) echo "&#x2717;";
                    ?>
                </td>
                <td><?php
                    if(odbc_result($result, "AdmissionStatus")==1) echo "&#x2713;";
                    if(odbc_result($result, "AdmissionStatus")==0) echo "&#x2717;";
                    ?></td>
                <td><?php echo odbc_result($result, "Enquiry Source"); ?></td>
                <td><?php
                        if(odbc_result($result, "Enquiry Status")==0) echo "Hot";
                        if(odbc_result($result, "Enquiry Status")==1) echo "Cold";
                        if(odbc_result($result, "Enquiry Status")==2) echo "Warm";
                    ?></td>
                <td>
                    <div class="bs-example">
                    <?php
                    	if(odbc_result($result, "Registration Status")==0){
						if(odbc_result($result, "System Genrated No_") != "") {
                    ?>
                    <a href="NewRegistrationDetails.php?EnquiryNo=<?php echo odbc_result($result, 'No_')?>" class="btn btn-lg btn-primary btn-sm" data-toggle="modal">Register</a>
                    <?php
						}
                    }
                    else{
                        echo "<a href='ViewRegistrationDetails.php?EnquiryNo=".odbc_result($result, 'No_') ."' class='btn btn-lg btn-primary btn-sm' data-toggle='modal'>View</a>";
                    }
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