<?php require_once("../db.txt"); ?>

<!--h1 class="text-primary">Payment Method</h1-->
<table class="table table-responsive">
	<tr style="font-weight: bold; background-color: #FFE4B5;">
		<td>SN</td>
		<td>Code</td>
		<td>Description</td>
	</tr>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Payment Method] WHERE [Company Name]='$ms'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo odbc_result($rs, "Code")?></td>
		<td><?php echo odbc_result($rs, "Description");?></td>
		
		
	</tr>
	<?php
			$i++;
		}
	?>
</table>
