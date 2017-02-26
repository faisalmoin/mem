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
		<td></td>
	</tr>
	<?php
	
        $Admissionno=$_REQUEST['invoice'];
        $Customer = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [Registration No_]='$Admissionno' ");
        
        $Customerno=odbc_result($Customer, "No_");
		$Acadmc=$_REQUEST['AdmissionYear'];
		if(odbc_result($row, "Academic Year") !='')
		{
			 $where1 = $where1." AND [Academic Year]='".odbc_result($row, "Academic Year")."'";
                    
		}

	
		$d=0;
		
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [Company Name]='$CompName' $where1 AND ([Class]='".odbc_result($row, "Class")."' OR [Class]='') ORDER BY [Academic Year]");
		while(odbc_fetch_array($rs)){
                $Check = odbc_exec($conn, "Select DISTINCT([DiscountNo]) FROM [StudentDiscountDetails] where [ApplicationNo]='$Admissionno' AND [CompanyName]='$CompName' AND [DocumentNo_]='".odbc_result($rs, "No_")."' ") or die(odbc_errormsg($conn)); 
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
                <td><input type="checkbox" name="discount<?php echo $d;?>" value="1" <?php if(odbc_num_rows($Check) == 1) echo " checked "; ?> /></td>
		<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="discount_Id<?php echo $d;?>" />
		<input type="hidden" value="<?php echo odbc_result($cls, 'Description'); ?>" name="Description2<?php echo $d;?>" />
		<input type="hidden" value="<?php echo odbc_result($rs, "No_"); ?>" name="No_<?php echo $d;?>" />
	</tr>	
	<?php
			$d++;
		}
	?>
	<input type="hidden" name="Dis_count" value ="<?php echo $d; ?>" />
	
</table>
