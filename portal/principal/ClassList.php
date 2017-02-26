<?php
	require_once("header.php");
	if(isset($_GET['delete_id']))
	{
		$Acad = odbc_exec($conn, "Delete FROM [Class Section] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));
	
		echo '<META http-equiv="refresh" content="0;URL=ClassList.php"> ';
		 
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
<h2>Class Section </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content" style="overflow: auto">


	
	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<tr style="font-weight: bold; text-align: center">
			<td>Class</td>
			<td>SNA</td>

			<?php
				$header_section = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Class Section] WHERE 
					[Company Name]='$CompName' 
					AND [Section] <> 'SNA'
					ORDER BY [Section] ASC") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($header_section)){
				echo "<td>".odbc_result($header_section, "Section")."</td>";
				}
			?>
		</tr>
		</thead>
		
		<?php
			$Class = odbc_exec($conn, "SELECT [ID],[Code],[Description] FROM [Class] WHERE [Company Name]='$CompName' ORDER BY [Sequence]") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($Class)){
		?>
		
		<tr>
		
			<td style="font-weight: bold;"><?php echo odbc_result($Class, "Description")?></td>
			<td><table class="table table-responsive" style="width: 10%; font-size: 10px;">
			<tr style="font-weight: bold;color: #0B3B2E;font-size: 11px">
				<td>Curriculum</td>
				<td>Capacity</td>
				<td></td>
			</tr>
			<?php
				$SNA = odbc_exec($conn, "SELECT [Curriculum], [Capacity], [ID] FROM [Class Section] 
					WHERE [Company Name]='$CompName' AND [Class]='".odbc_result($Class, "Code")."' 
					AND [Section] = 'SNA'
					ORDER BY [Section] ASC") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($SNA)){
			?>
			<tr>
				<td><?php echo odbc_result($SNA, "Curriculum")?></td>
				<td><?php echo round(odbc_result($SNA, "Capacity"))?></td>
				</tr>
			<?php
				}
			?></table></td>
		
			<?php
				$Section = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Class Section] 
					WHERE [Company Name]='$CompName' AND [Class]='".odbc_result($Class, "Code")."' 
					AND [Section] <> 'SNA'
					ORDER BY [Section] ASC") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($Section)){
			?>
			<td>
				<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="width: 10%;  font-size: 10px;">
				<tr style="font-weight: bold;color: #0B3B2E;font-size: 11px">
					<td>Curriculum</td>
					<td>Capacity</td>
                    <td></td>
                    <td></td>
				</tr>
			<?php
				$Sec = odbc_exec($conn, "SELECT [Curriculum], [Capacity], [ID] FROM [Class Section] 
					WHERE [Company Name]='$CompName' AND [Class]='".odbc_result($Class, "Code")."' 
					AND [Section] <> 'SNA' AND [Section]='".odbc_result($Section, "Section")."'
					ORDER BY [Section] ASC") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($Sec)){
			?>
			<tr>
				<td><?php echo odbc_result($Sec, "Curriculum")?></td>
				<td><?php echo round(odbc_result($Sec, "Capacity"),0)?></td>
				<td><a href="ClassEdit.php?SectionID=<?php echo odbc_result($Sec, "ID")?>">Edit</a></td>
		       <td><a href="javascript:delete_id(<?php echo odbc_result($Sec, "ID")?>)">Delete</a></td>
			</tr>
			<?php
				}
			?>
			
				</table>
				</td>
			<?php
				}
			?>			
		</tr>
		<?php
			}
		?>
	</table>


</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
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
<script type="text/javascript">
function delete_id(ID)
{
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='ClassList.php?delete_id='+ID;
     }
}
</script>
<!-- /Datatables -->

<?php
	require_once("../footer.php");
?>