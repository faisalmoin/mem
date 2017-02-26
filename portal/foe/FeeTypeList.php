<?php require_once("../db.txt");?>
<!--h1 class="text-primary">Fee Type</h1-->
<table class="table table-responsive">
	<tr style="font-weight: bold; background-color: #FFE4B5;">
		<td>SN</td>
		<td>Fee Type</td>
		<td>Fee Description</td>
	</tr>
	<?php
		$i = 1;
		$rs = odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [Company Name]='$ms'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo odbc_result($rs, "Code")?></td>
		<td><?php echo odbc_result($rs, "Description"); ?></td>
		</tr>
	<?php
			$i++;
		}
	?>
</table>
