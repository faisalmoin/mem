<?php require_once("../db.txt");?>
<!--h1 class="text-primary">Discount Fee Structure</h1-->
<table class="table table-responsive">
	<tr style="font-weight: bold;background-color: #FFE4B5;">
		<td>SN</td>
		<td>Academic Year</td>
		<td>Class</td>
		<td>Document No</td>
		<td>Fee Code</td>
		<td>Discount % </td>
		<td>Description</td>
	</tr>
	<?php
		$i=1;
		if($_REQUEST['AcadYear'] !='')
		{
			$where = $where." AND [Academic Year]='".$_REQUEST['AcadYear']."'";
		}
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Line] WHERE [Company Name]='$ms' $where ORDER BY [Academic Year]");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td align="center"><?php echo odbc_result($rs, 'Academic Year');?></td>
		<td><?php 
			$cls = odbc_exec($conn, "SELECT [Class] FROM [Discount Fee Header] WHERE [No_]='".odbc_result($rs, 'Document No_')."' AND [Company Name]='$ms' ");
			echo odbc_result($cls, 'Class');
		if(odbc_result($cls, 'Class') == '') { echo "All Class"; } ?></td>
		<td><?php echo odbc_result($rs, 'Document No_');?></td>
		<td><?php echo odbc_result($rs, 'Fee Code');?></td>
		<td align="right"><?php echo number_format(odbc_result($rs, 'Discount%'),2,'.',',');?></td>
		<td><?php echo odbc_result($rs, 'Description');?></td>
	</tr>
	<?php
			$i++;
		}
	?>
</table>

