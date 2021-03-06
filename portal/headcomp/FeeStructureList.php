<?php
	require_once("SetupLeft.php");
	if(isset($_GET['delete_id']))
	{
		$Acad = odbc_exec($conn, "Delete FROM [Class Fee Line] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));
	
		echo '<META http-equiv="refresh" content="0;URL=FeeStructureList.php"> ';
	}
?>


<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- /Datatable -->

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
<h2>Fee Structure </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeStructureNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>	<tr style="font-weight: bold;color: #0B3B2E;font-size: 15px">
		<td>SN</td>
		<td>Academic<br />Year</td>
		<td>Curriculum</td>
		<td>Class</td>
		<td>Description</td>
		<td>Occurrence</td>
		<td align="center">Amount</td>
		<td align="center">Total<br />Amount</td>
        <td align="center">Monthly<br />Amount</td>
		<td align="center">Fee<br />Group</td>
                <!--td></td-->
	</tr></thead>
	<tbody>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i?></td>
		<td align="center" ><?php echo odbc_result($rs, "Academic Year"); ?></td>
		<td><?php 			
			$Curr = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Fee Header] WHERE [No_]='".odbc_result($rs, "Document No_")."'");
			echo odbc_result($Curr, "Curriculum");  ?></td>
                <?php if(odbc_result($rs, "Class")==""){?>
                <td><?php echo "AllClass"; ?></td>
                <?php }else {?>
		<td><?php echo odbc_result($rs, "Class"); ?></td>
                <?php } ?>
		<td><a href="FeeStructureEdit.php?Id=<?php echo odbc_result($rs, "ID")?>"><?php echo odbc_result($rs, "Description"); ?></a></td>
		<td align="center"><?php 
                $a=odbc_result($rs, "No_ of months");
                $b=odbc_result($rs, "Group Code");
               
                                                if(($a == 1) && ($b =="REG" || $b =="ADM")) {echo "One Time";} 
						if(odbc_result($rs, "No_ of months") ==12) echo "Monthly"; 
						if(odbc_result($rs, "No_ of months") ==4) echo "Quarterly"; 
						if(odbc_result($rs, "No_ of months") ==2) echo "Half Yearly";
						if(odbc_result($rs, "Group Code") =="INV" && odbc_result($rs, "No_ of months")==1) echo "Annually"; 
		?></td>
		<td align="right"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?></td>		
		<td align="right"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
		<td align="right"><?php echo number_format(odbc_result($rs, "Monthly Amount"),2,'.',','); ?></td>
		
		<td align="center"><?php echo odbc_result($rs, "Group Code"); ?></td>
		<!--td><a href="javascript:delete_id(<?php echo odbc_result($rs, "ID")?>)"><img src="wrong.jpeg" alt="Delete" style="width:20px;height:20px;" /></a></td-->
		<!--<td align="right"><?php /*
				if(odbc_result($rs, "No_ of months") ==0) echo number_format(odbc_result($rs, "Total Amount"),2,'.',',');
				if(odbc_result($rs, "No_ of months") ==1) echo number_format(odbc_result($rs, "Total Amount")*12,2,'.',',');
				if(odbc_result($rs, "No_ of months") ==3) echo number_format(odbc_result($rs, "Total Amount")*4,2,'.',',');
				if(odbc_result($rs, "No_ of months") ==6) echo number_format(odbc_result($rs, "Total Amount")*2,2,'.',','); 
				if(odbc_result($rs, "No_ of months") ==12) echo number_format(odbc_result($rs, "Total Amount")*12,2,'.',',');
				//echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); 
		*/?></td> -->
	</tr>
	<?php
			$i++;
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

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
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


<script type="text/javascript">
function delete_id(ID)
{
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='FeeStructureList.php?delete_id='+ID;
     }
}
</script>

<?php require_once("SetupRight.php"); ?>