<?php require_once("header.php"); ?>

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
<h2>Student Card Approval </h2>
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

    <?php 
        $id=$_REQUEST['id'];
       
        $Admission = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
    ?>
       <form name="form" action='StudentCardUpdateAdd.php' method='POST'>
        <table style="border: none;" class="table table-responsive">
		<tr style="border: none;">
			<td style="border: none; width: 40%;" valign="top">
				<table class="table table-responsive" style="border: none; background-color: #e4f1fe;">
					<tr>
						<td colspan="2"><h4>Account Information</h4></td>
					<tr>
					<tr>  <td style="border: none; ">Student No</td>
                                                <td style="border: none; "><span class="text-danger" style="font-weight: bold;"><?php echo strtoupper(odbc_result($Admission, "No_"))?></span></td>
						<td style="border: none; ">Student Name</td>
                                                <td style="border: none; "><span class="text-danger" style="font-weight: bold;"><?php echo strtoupper(odbc_result($Admission, "Name"))?></span></td>
						<td style="border: none; ">Academic Year</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo strtoupper(odbc_result($Admission, "Academic Year"))?></span></td>
					</tr>
					
					<tr>
						<td style="border: none; ">Class</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($Admission, "Class")?></span></td>
						<td style="border: none; ">Section</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo strtoupper(odbc_result($Admission, "Section"))?></span></td>
					</tr>
				</table>
    </td></tr>
    <tr style="border: none;"><td>
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" />
		<thead>
		<tr>
			<th>SN</th>
			<th>Requsting Date</th>
			<th>Field Name</th>
			<th>New Value</th>
			<th>Old Value</th>
			<th>Generate Date</th>
            <th>Action</th>
            <th>Remark</th>
            <th>Requested By</th>
            <th>Approve</th>
		</tr>
		</thead>
		<?php
			$i=1;
			
			$result = odbc_exec($conn, "SELECT * FROM [Student Card Changes] WHERE [Company Name]='$ms' AND [Status]=0 AND [Student No_]= '$id' ORDER BY [ID] ASC") or die(mysql_error());
                while(odbc_fetch_array($result)){
					
		?>
		<tr>
			<td><?php echo $i;?></td>
			
			<td><?php echo date('d/M/Y', odbc_result($result, "Changes Date"));?></td>
			<td><?php echo odbc_result($result, 'Field Name');?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Field Name'); ?>" name="FieldName<?php echo $i;?>" /></td>
			<td><?php echo odbc_result($result, 'New Value');?>
             <input type="hidden" value="<?php echo odbc_result($result, 'New Value'); ?>" name="NValue<?php echo $i;?>" /></td>
			<td><?php echo odbc_result($result, "Old Value");?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Old Value'); ?>" name="OValue<?php echo $i;?>" /></td>
            <td><?php echo odbc_result($result, "Invoice Date");?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Invoice Date'); ?>" name="InvoiceDate<?php echo $i;?>" /></td>
            <td><?php echo odbc_result($result, "Action");?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Action'); ?>" name="Action<?php echo $i;?>" /></td>
            <td><?php echo odbc_result($result, "Remark");?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Remark'); ?>" name="Remark<?php echo $i;?>" /></td>
            <td><?php echo odbc_result($result, "Login");?>
            <input type="hidden" value="<?php echo odbc_result($result, 'Login'); ?>" name="Login<?php echo $i;?>" /></td>
            <input type="hidden" value="<?php echo odbc_result($result, 'Table Name'); ?>" name="TableName<?php echo $i;?>" /></td>
            <td><select name='ApproveStatus<?php echo $i?>' class="form-control">
                <option value='0'></option>
                <option value='1'>Yes</option>
                <option value='2'>No</option>
                </select></td>
            <input type="hidden" value="<?php echo odbc_result($result, "id")?>" name="tbl_id<?php echo $i; ?>"
			
		</tr>
		<?php
				$i++;
			}
		?>
	        <input type="hidden" value="<?php echo $id; ?>" name="id" />
	        <input type="hidden" value="<?php echo $i?>" name="count">
	        <tr> <td colspan="8"><input type="submit" value="Submit" class="btn btn-success"></td></tr>
	</table>
                       
    </td></tr></table>
    </form>
        

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
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

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

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