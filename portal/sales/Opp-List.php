<?php
	require_once("header.php");
	$sql =odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [Assign To]='$LoginID' 
					AND [Level] <> 'Agreement signed' ORDER BY [Opp Date] DESC") or die(odbc_errormsg($conn));
?>

<div class="container">
	
	<div class="row">
		<div class="col-sm-8">
			<h3 class="text-primary" >Opportunity List</h3>
		</div>
		<div class="col-sm-2" align="right">
			<div class="inner-addon right-addon">
				<i class="glyphicon glyphicon-search"></i>
				<input type="text" 
				class="form-control"
				id="search"
				style="border: 1px solid #d3d3d3; width: 180px;" 
				placeholder="Type to search ..." />
			</div>		
		</div>
		<div class="col-sm-2">
			<a href="Lead-New.php" class="btn btn-success">Create Lead</a>
		</div>
	</div>
	<table class="table table-responsive table-hover table-striped" id="tblData">
		<tr style="background-color: #0404B4; color: #ffffff;">
			<th>SN</th>
			<th>Date</th>
			<th>Opp ID</th>
			<th>Lead ID</th>
			<th>Name</th>
			<th>City</th>
			<th>State</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Brand</th>
			<th>Stage</th>
			<th>Level</th>
			<th>Download</th>
			<th></th>
		</tr>
		<?php
			$i = 1;
			while(odbc_fetch_array($sql)){
		?>
		<tr>
			<td><?php echo $i?></td>
			<td><?php echo date('d/M/Y', odbc_result($sql, "Opp Date")); ?></td>
			<td><?php echo odbc_result($sql, "Opp No"); ?></td>
			<td><?php echo odbc_result($sql, "Lead No"); ?></td>
			<td><?php echo odbc_result($sql, "Name"); ?></td>
			<td><?php echo odbc_result($sql, "City"); ?></td>
			<td><?php echo odbc_result($sql, "State"); ?></td>
			<td><?php echo odbc_result($sql, "Mobile"); ?></td>
			<td><?php echo odbc_result($sql, "Email"); ?></td>
			<td><?php echo odbc_result($sql, "Likely Brand"); ?></td>
			<td><?php echo odbc_result($sql, "Stage"); ?></td>			
			<td><?php echo odbc_result($sql, "Level"); ?></td>
			<td>
				<?php 
					echo (odbc_result($sql, "LOI file") != "") ? '<a href="'.odbc_result($sql, "LOI file").'" target="_BLANK">LOI</a>' : '';
					echo "&nbsp;";
					echo (odbc_result($sql, "MOU file") != "") ? '<a href="'.odbc_result($sql, "MOU file") .'" target="_BLANK">MOU</a>' : "";
				?>				
			</td>
			<td>
				<?php if(odbc_result($sql, "Level") != "Agreement signed"){  ?>
				<a href="Opp-Edit.php?id=<?php echo odbc_result($sql, "ID"); ?>">Edit</a>
				<?php } ?>
			</td>
		</tr>
		<?php
				$i++;
			}
		?>
	</table>
</div>
<?php require_once("../footer.php"); ?>