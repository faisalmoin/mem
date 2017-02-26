<?php require_once("../db.txt");?>

<!--h1 class="text-primary">Fee Structure</h1-->
<table class="table table-responsive">
	<tr style="font-weight: bold; background-color:#FFE4B5;" >
		<td>SN</td>
		<td>Academic Year</td>
		<td>Curriculum</td>
		<td>Class</td>
		<td>Description</td>
		<td>Occurrence</td>
		<td align="center">Amount</td>
		<td align="center">Total Amount</td>
		<td align="center">Fee Group</td>
	</tr>
	<?php
		$i=1;
		if($_REQUEST['AcadYear'] !='')
		{
			$where = $where." AND [Academic Year]='".$_REQUEST['AcadYear']."'";
		}
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$ms' $where ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i?></td>
		<td align="center" ><?php echo odbc_result($rs, "Academic Year"); ?></td>
		<td><?php 			
			$Curr = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Fee Header] WHERE [No_]='".odbc_result($rs, "Document No_")."'");
			echo odbc_result($Curr, "Curriculum");  ?></td>
                <?php if(odbc_result($rs, "Class")=="") {?>
                <td><?php echo "All Class"; ?></td>
                <?php }else { ?>
		<td><?php echo odbc_result($rs, "Class"); ?></td>
                <?php }?>
		<td><?php echo odbc_result($rs, "Description"); ?></td>
		<td align="right"><?php 
						if(odbc_result($rs, "No_ of months") ==0) echo "One Time"; 
						if(odbc_result($rs, "No_ of months") ==1) echo "Monthly"; 
						if(odbc_result($rs, "No_ of months") ==2) echo "Quarterly"; 
						if(odbc_result($rs, "No_ of months") ==3) echo "Half Yearly"; 
						if(odbc_result($rs, "No_ of months") ==4) echo "Annually"; 
		?></td>
		<td align="right"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?></td>		
		<td align="right"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
		<td><?php echo odbc_result($rs, "Group Code"); ?></td>
		
	</tr>
	<?php
			$i++;
		}
	?>
</table>

