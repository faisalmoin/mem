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
		<!--td style="text-align: center;">Total Amount</td-->
	</tr>
	<?php 
	     
              $Admissionno=$_REQUEST['invoice'];
               $Customer = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [Registration No_]='$Admissionno'  ");
              $Customerno=odbc_result($Customer, "No_");
		
		$Acadmc=$_REQUEST['AdmissionYear'];
		if(odbc_result($row, "Academic Year")!='')
		{
		 $where = $where." AND [Academic Year]='".odbc_result($row, "Academic Year")."'"; 
		}
		
	
            $f=0;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND ([Group Code]= 'INV' OR [Group Code]= 'ADM') $where AND ([Class]='".odbc_result($row, "Class")."' OR [Class]='') ORDER BY [Academic Year], [No_ of months], [Group Code] ") or die(odbc_errormsg($conn));
	     while(odbc_fetch_array($rs)){
               
             ?>
	
	
	 <tr>
		<td><?php echo $f?></td>
		<td><?php echo odbc_result($rs, "Academic Year"); ?></td>
		<td><?php 			
			$Curr = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Fee Header] WHERE [No_]='".odbc_result($rs, "Document No_")."'");
			echo odbc_result($Curr, "Curriculum");  ?></td>
		<?php if(odbc_result($rs, "Class")!="") {?>
		<td><?php echo odbc_result($rs, "Class"); ?></td>
                <?php } else{?>
                <td><?php echo "AllClass"; ?></td>
                <?php }?>
		<td><?php echo odbc_result($rs, "Description"); ?>
		<input type="hidden" value="<?php echo odbc_result($rs, "Description"); ?>" name="Description1<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Document No_"); ?>" name="DocumentNo1_<?php echo $f; ?>"></td>
		<td><?php 
                $a=odbc_result($rs, "No_ of months");
                $b=odbc_result($rs, "Group Code");
               
                        if(($a == 1) && ($b =="REG" || $b =="ADM")) {echo "One Time";} 
                       // if(odbc_result($rs, "No_ of months") ==1) echo "One Time"; 
                        if(odbc_result($rs, "No_ of months") ==12) echo "Monthly"; 
                        if(odbc_result($rs, "No_ of months") ==4) echo "Quarterly";
                        if(odbc_result($rs, "No_ of months") ==2) echo "Half Yearly"; 
                        //if(odbc_result($rs, "No_ of months") ==1) echo "Annually"; 
                        if(odbc_result($rs, "Group Code") =="INV" && odbc_result($rs, "No_ of months")==1) echo "Annually"; 
		?></td>
		<td style="text-align: right;"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?></td>		
		<!--td style="text-align: right;"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td-->		
		
                
                
                
                <?php if(odbc_result($rs, "Group Code")!= "ADM")
	    {	?>
	    <td><input type="hidden" name="fee<?php echo $f?>" value="1" /> 	
	    </td>
	    <?php }
	    else{ ?>
            <td><input type="checkbox" name="fee<?php echo $f;?>" value="1"
                                    <?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                            ?></td>
	    <?php }?>
                    
                    
               
                
	      <!--td><input type="checkbox" name="fee<?php echo $f;?>" value="1"
                                    <?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                            ?></td-->
            
            
            
		<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="fee_Id<?php echo $f; ?>">
		
		
                <input type="hidden" value="<?php echo $Admissionno; ?>" name="Customerno">
                 <input type="hidden" value="<?php echo odbc_result($rs, "Class"); ?>" name="Class">
                  <input type="hidden" value="<?php echo odbc_result($rs, "Academic Year"); ?>" name="AcademicYear">
              
		
	    </tr>
	    <?php
		$f++;
		 }
	    
           // }
            ?>
	   <input type="hidden" value="<?php echo $f?>" name="fee_count">
    </table>
