<?php
	require_once("SetupLeft.php");
	
?>
<a href="CompanyNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="50px" alt="Create New"></a>
<h1 class="text-primary">Company List</h1>
<table class="table table-striped table-hover">
	<thead>
		<tr style="font-weight: bold;">
			<td>SN</td>
			<td>School Name</td>
			<td>City</td>
			<td>State</td>
			<td>Phone No.</td>
			<td>Trust Name</td>
			<td>Brand</td>
			<td>Company Status</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
	<?php
		$i = 1;
		$rs=odbc_exec($conn, "SELECT * FROM [Company Information] ORDER BY [School Name]") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td>
			<a href="#" data-toggle="modal" data-target="#myModal<?php echo $i?>">
			<?php echo odbc_result($rs, "School Name"); ?>
			</a>
		</td>
		<td><?php echo odbc_result($rs, "City"); ?></td>
		<td><?php echo odbc_result($rs, "State"); ?></td>
		<td><?php echo odbc_result($rs, "Phone No_"); ?></td>
		<td><?php echo odbc_result($rs, "Trust"); ?></td>
		<td><?php 
				echo odbc_result($rs, "Brand")==1?"TKS":""; 
				echo odbc_result($rs, "Brand")==2?"TMS":""; 
				echo odbc_result($rs, "Brand")==3?"UA":""; 
				echo odbc_result($rs, "Brand")==4?"PSBB MS":""; 
				echo odbc_result($rs, "Brand")==5?"TSMS":""; 
			?>
		</td>
		<td><?php 
				echo odbc_result($rs, "Company Status")==0? "In-Active": "";
				echo odbc_result($rs, "Company Status")==1? "Active": "";
				echo odbc_result($rs, "Company Status")==3? "Others": "";
			?></td>
		<td></td>
		</tr>
		<!-- Modal Start -->
		<div class="modal fade" id="myModal<?php echo $i?>" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Company Information</h4>
					</div>
					<div class="modal-body">
					
							<?php //require "CompanyModal.php"?>
						
					</div> <!-- End of Modal content -->
					<div class="modal-footer">
						<a href="CompanyEdit.php?id=<?php echo odbc_result($rs, "id")?>" type="button" class="btn btn-default" >Edit</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
		<!-- Modal End -->
	
	<?php
			$i++;
		}
	?>
	</tbody>
</table>

<?php
	require_once("SetupRight.php")
?>