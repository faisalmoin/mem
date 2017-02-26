<?php
	require_once("header.php");
	$sql =odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [Assign To]='$LoginID' AND [Status] <> 'Open' AND [Level]='Agreement signed' AND [Stage]='Agreement' ORDER BY [Opp Date] DESC") or die(odbc_errormsg($conn));
?>

<div class="container">
	
	<div class="row">
		<div class="col-sm-8">
			<h3 class="text-primary" >Agreement List</h3>
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
		<!--div class="col-sm-2">
			<a href="Lead-New.php" class="btn btn-success">Create Lead</a>
		</div-->
	</div>
	<table class="table table-responsive table-hover table-striped" style="border: 1px solid #d3d3d3; border-style: dashed;" id="tblData">
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
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo $i?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo date('d/M/Y', odbc_result($sql, "Opp Date")); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Opp No"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Lead No"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Name"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "City"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "State"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Mobile"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Email"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Likely Brand"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Stage"); ?></td>			
			<td style="border: 1px solid #d3d3d3; border-style: dashed;"><?php echo odbc_result($sql, "Level"); ?></td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;">
				<?php 
					echo (odbc_result($sql, "LOI file") != "") ? '<a href="../'.odbc_result($sql, "LOI file").'" target="_BLANK">LOI</a>' : '';
					echo "&nbsp;";
					echo (odbc_result($sql, "MOU file") != "") ? '<a href="../'.odbc_result($sql, "MOU file") .'" target="_BLANK">MOU</a>' : "";
				?>				
			</td>
			<td style="border: 1px solid #d3d3d3; border-style: dashed;">
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