<?php require_once("header.php");?>
<table id="results2" class="table table-responsive">
	<tr style="font-weight: bold;">
		<td style="text-align: center;">SN</td>
		<td style="text-align: center;">Academic Year</td>
		<td>Class</td>
		<td style="text-align: center;">Curriculum</td>
		<td>Document No</td>
		<td>Fee Code</td>
		<td>Description</td>
		<!--td>Discount % </td-->
		<td></td>
	</tr>
	<?php
	/*
        $class=$_GET['cls'];
		
		if($_GET['cls'] !='')
		{
			$where1 = $where." AND [Class]='".$_GET['cls']."'";
		}
		$Acadmc=$_GET['AYear'];
		if($_GET['AYear'] !='')
		{
			$where = $where." AND [Academic Year]='".$_GET['AYear']."'";
		}
	
	   */
           /*
		if($_REQUEST['Class'] !='')
		{
			$where1 = $where1." AND [Class]='".$_REQUEST['Class']."'";
		}
                */
      
		$Acadmc=$_REQUEST['AdmissionYear'];
		if($_REQUEST['AdmissionYear'] !='')
		{
			$where1 = $where1." AND [Academic Year]='".$_REQUEST['AdmissionYear']."'";
		}
		
	  if($_REQUEST['EWS'] != 0){
	   $d=1;
       
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$CompName' AND [Fee Clasification Code]='RTE' $where1 AND ([Class]='PRENUR' OR [Class]='') ORDER BY [Academic Year]");
         
       while(odbc_fetch_array($rs)){
			
		?>
	<tr>
		<td style="text-align: center;"><?php echo $d;?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Academic Year');?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Class');
                if(odbc_result($rs, 'Class') == '') { echo "All Class"; }?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Curriculum');?></td>
		
		<td><?php echo odbc_result($rs, 'No_');?></td>
		<td><?php echo odbc_result($rs, 'Fee Clasification Code');?></td>
		<!--td><--?php echo number_format(odbc_result($rs, 'Discount%'),2,'.',',');?></td-->
		<td><?php			
			$cls = odbc_exec($conn, "select [Description] from [Fee Classification] where [Code]='".odbc_result($rs, 'Fee Clasification Code')."' AND [Company Name]='$CompName' ");
			echo odbc_result($cls, 'Description');
		?></td>
		<!--td><input checked type="checkbox" name="discount<--?php echo $d?>" value="1" /-->
		<td><input type="hidden" name="discount<?php echo $d?>" value="1" />
			<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="discount_Id<?php echo $d;?>" />
		</td>
		</tr>
	
	<?php
			$d++;
		}
	  }
	  else{
	
		$d=1;
		
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$CompName' $where1 AND [Fee Clasification Code] <> 'RTE' AND ([Class]='PRENUR' OR [Class]='') ORDER BY [Academic Year]");
		while(odbc_fetch_array($rs)){
			
		?>
	<tr>
		<td style="text-align: center;"><?php echo $d;?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Academic Year');?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Class');
                 if(odbc_result($rs, 'Class') == '') { echo "All Class"; } ?></td>
		<td style="text-align: center;"><?php echo odbc_result($rs, 'Curriculum');?></td>
		
		<td><?php echo odbc_result($rs, 'No_');?></td>
		<td><?php echo odbc_result($rs, 'Fee Clasification Code');?></td>
		<!--td><--?php echo number_format(odbc_result($rs, 'Discount%'),2,'.',',');?></td-->
		<td><?php			
			$cls = odbc_exec($conn, "select [Description] from [Fee Classification] where [Code]='".odbc_result($rs, 'Fee Clasification Code')."' AND [Company Name]='$CompName' ");
			echo odbc_result($cls, 'Description');
		?></td>
		<td><input type="checkbox" name="discount<?php echo $d?>" value="1" />
			<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="discount_Id<?php echo $d;?>" />
		<input type="hidden" value="<?php echo odbc_result($cls, 'Description'); ?>" name="Description<?php echo $d;?>" />
		
		<input type="hidden" value="<?php echo odbc_result($rs, "No_"); ?>" name="No_<?php echo $d;?>" /></td>
		</tr>
	
	<?php
			$d++;
		}
      }
	?>
	<input type="hidden" name="Dis_count" value ="<?php echo $d; ?>" />
	
</table>
