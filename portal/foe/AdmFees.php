<?php require_once("header.php");?>
<table id="results" class="table table-responsive">
<tr style="font-weight: bold;">
		<td>SN</td>
		<td>Academic Year</td>
		<td>Curriculum</td>
		<td>Class</td>
		<td>Description</td>
		<td>Occurrence</td>
		<td style="text-align: center;">Amount</td>
		<td style="text-align: center;">Total Amount</td>
	</tr>
	
	<?php 
	
		if($_REQUEST['Class'] !='')
		{
			$where = $where." AND [Class]='".$_REQUEST['Class']."'";
		}
		$Acadmc=$_REQUEST['AdmissionYear'];
		if($_REQUEST['AdmissionYear'] !='')
		{
			$where = $where." AND [Academic Year]='".$_REQUEST['AdmissionYear']."'";
		}
		
	 		
		$f=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		//echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where ORDER BY [Academic Year], [Group Code]";
		while(odbc_fetch_array($rs)){
	?>
	
	  <tr>
		<td><?php echo $f?></td>
		<td><?php echo odbc_result($rs, "Academic Year"); ?></td>
		<td><?php 			
			$Curr = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Fee Header] WHERE [No_]='".odbc_result($rs, "Document No_")."'");
			echo odbc_result($Curr, "Curriculum");  ?></td>
		<td><?php echo odbc_result($rs, "Class"); ?></td>
		<td><?php echo odbc_result($rs, "Description"); ?></td>
		<!--td><--?php echo odbc_result($rs, "Document No_"); ?></td-->
		<td><?php 
						if(odbc_result($rs, "No_ of months") ==0) echo "One Time"; 
						if(odbc_result($rs, "No_ of months") ==1) echo "Monthly"; 
						if(odbc_result($rs, "No_ of months") ==2) echo "Quarterly"; 
						/*if(odbc_result($rs, "No_ of months") ==3) echo "Quarter 2"; 
						if(odbc_result($rs, "No_ of months") ==4) echo "Quarter 3"; 
						if(odbc_result($rs, "No_ of months") ==5) echo "Quarter 4"; */
						if(odbc_result($rs, "No_ of months") ==3) echo "Half Yearly"; 
						if(odbc_result($rs, "No_ of months") ==4) echo "Annually"; 
		?></td>
		<td style="text-align: right;"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?></td>		
		<td style="text-align: right;"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>		
		
	    <?php if(odbc_result($rs, "Group Code")== "ADM")
	    {	?>
	    <td><input type="hidden" name="fee<?php echo $f?>" value="1" /> 	
	    </td>
	    <?php }
	    else{ ?>
		<td><input type="checkbox" name="fee<?php echo $f?>" value="1" />
	    <?php }?>
		<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="fee_Id<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Description"); ?>" name="Description<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Document No_"); ?>" name="DocumentNo_<?php echo $f; ?>">
		</td>
	    </tr>
	    <?php
		$f++;
		 }
	    ?>
	   <input type="hidden" value="<?php echo $f?>" name="fee_count">
    </table>
