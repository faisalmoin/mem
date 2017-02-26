<?php
	require_once("header.php");
	$sql = odbc_exec($conn, "SELECT * FROM [CRM Agreement] WHERE [Created By]='$LoginID' ORDER BY [Sign Date] DESC");
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
		<div class="col-sm-2">
			<a href="Agr-New.php" class="btn btn-success">New Agreement</a>
		</div>
	</div>
	<table class="table table-responsive table-hover table-striped" id="tblData">
		<tr style="background-color: #0404B4; color: #ffffff;">
			<th>SN</th>
			<th>Date</th>
			<th>Name of Trust</th>
			<th>Customer Name</th>
			<th>City</th>
			<th>State</th>
			<th>Duration</th>
			<th>Brand</th>
			<th>Franchisee Fee</th>
			<th>Royalty %</th>
			<th><span class="glyphicon glyphicon-download-alt"></span></th>
			<th></th>
		</tr>
		<?php
			$i = 1;
			while(odbc_fetch_array($sql)){
		?>
		<tr>
			<td><?php echo $i?></td>
			<td><?php echo date('d/M/Y', odbc_result($sql, "Sign Date")); ?></td>
			<td><?php echo odbc_result($sql, "Trust Name"); ?></td>
			<td><?php echo odbc_result($sql, "Name"); ?></td>
			<td><?php echo odbc_result($sql, "City"); ?></td>
			<td><?php echo odbc_result($sql, "State"); ?></td>
			<td><?php echo round(odbc_result($sql, "Duration")/365); ?> Yrs</td>
			<td><?php echo odbc_result($sql, "Brand"); ?></td>
			<td style="text-align: right;">&#8377;  <?php echo odbc_result($sql, "Franchisee Fee"); ?></td>
			<td style="text-align: center;"><?php echo odbc_result($sql, "Royaly %"); ?></td>
			<td><a href="<?php echo odbc_result($sql, "MOU FIle"); ?>" target="_BLANK">MOU</a></td>			
			<td>
			
			</td>
		</tr>
		<?php
				$i++;
			}
		?>
	</table>
</div>
<?php require_once("../footer.php"); ?>