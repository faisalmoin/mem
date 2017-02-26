<?php require_once("../db.txt"); ?>
<!--h1 class="text-primary">Discount Fee Category</h1-->
<table class="table table-responsive">
	<tr style="font-weight: bold; background-color: #FFE4B5;">
		<td>SN</td>
		<td>Academic Year</td>
		<td>Code</td>
		<td>Description</td>
		<td>Curriculum</td>
	</tr>
	<?php
		$i=1;
		if($_REQUEST['AcadYear'] !='')
		{
			$where = $where." AND [Academic Year]='".$_REQUEST['AcadYear']."'";
		}
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$ms' $where");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i?></td>
		<td><?php echo odbc_result($rs, "Academic Year")?></td>
		<td><?php echo odbc_result($rs, "No_")?></td>
		
		<td><?php
			$get = odbc_exec($conn, "SELECT [Description] FROM [Fee Classification] WHERE [Code]='".odbc_result($rs, "Fee Clasification Code")."' AND [Company name]='$CompName'");
			echo odbc_result($get, "Description");
		?></td>
		
		<td><?php echo odbc_result($rs, "Curriculum")?></td>
	</tr>
	<?php
			$i++;
		}
	?>
</table>
