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
	      // $Customerno=$_REQUEST['invoice'];
              $Admissionno=$_REQUEST['id'];
               $Customer = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [No_]='$Admissionno'  ");
              // $Class=$_REQUEST['Class'];
               $Customerno=odbc_result($Customer, "Registration No_");
		/*if($_REQUEST['Class'] !='')
		{
			$where = $where." AND [Class]='".$_REQUEST['Class']."'";
		}*/
		$Acadmc=$_REQUEST['AdmissionYear'];
		if(odbc_result($row, "Academic Year")!='')
		{
			//$where = $where." AND [Academic Year]='".$_REQUEST['AdmissionYear']."'";
                   $where = $where." AND [Academic Year]='".odbc_result($row, "Academic Year")."'"; 
		}
		
	 	/*if(odbc_result($row, "EWS")){	
		$f=0;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where AND ([Class]='".odbc_result($row, "Class")."' OR [Class]='') ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		//$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where AND ([Class]='".$_REQUEST['Class']."' OR [Class]='') ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		
                //echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where ORDER BY [Academic Year], [Group Code] ";
                while(odbc_fetch_array($rs)){
                $Check = odbc_exec($conn, "Select DISTINCT([FeeNo]) FROM [StudentFee] where [ApplicationNo]='$Customerno' AND [CompanyName]='$CompName' AND [FeeNo]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn)); 
             ?>
	
	
	 <!--tr <--?php if(odbc_num_rows($Check) == 1){echo 'style="color: red;font-weight: bold;"';}?> -->
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
		<td><?php echo odbc_result($rs, "Description"); ?></td>
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
		<td style="text-align: right;"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>		
		
                
                
                
             
                    
                
	      <td><input type="checkbox" name="fee<?php echo $f;?>" value="1"
                                    <?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                            ?></td>
            
            
            
		<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="fee_Id<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Description"); ?>" name="Description<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Document No_"); ?>" name="DocumentNo_<?php echo $f; ?>">
                <input type="hidden" value="<?php echo $Customerno; ?>" name="Customerno">
                 <input type="hidden" value="<?php echo odbc_result($rs, "Class"); ?>" name="Class">
                  <input type="hidden" value="<?php echo odbc_result($rs, "Academic Year"); ?>" name="AcademicYear">
              
		
	    </tr>
	    <?php
		$f++;
		 }
	  
            }else
            {
            */
            $f=0;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where AND ([Class]='".odbc_result($row, "Class")."' OR [Class]='') ORDER BY [Academic Year], [No_ of months], [Group Code] ") or die(odbc_errormsg($conn));
		//$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where AND ([Class]='".$_REQUEST['Class']."' OR [Class]='') ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		
                //echo "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName'AND [Group Code]<> 'REG' $where ORDER BY [Academic Year], [Group Code] ";
                while(odbc_fetch_array($rs)){
                $Check = odbc_exec($conn, "Select DISTINCT([FeeNo]) FROM [StudentFee] where [ApplicationNo]='$Customerno' AND [CompanyName]='$CompName' AND [FeeNo]='".odbc_result($rs, "ID")."' ") or die(odbc_errormsg($conn)); 
             ?>
	
	
	 <!--tr <--?php if(odbc_num_rows($Check) == 1){echo 'style="color: red;font-weight: bold;"';}?> -->
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
		<td><?php echo odbc_result($rs, "Description"); ?></td>
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
		
                
                
                
                <!--?php if(odbc_result($rs, "Group Code")== "ADM")
	    {	?>
	    <td><input type="hidden" name="fee<--?php echo $f?>" value="1" /> 	
	    </td>
	    <--?php }
	    else{ ?>
            <td><input type="checkbox" name="fee<--?php echo $f;?>" value="1"
                                    <--?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                            ?></td>
	    <--?php }?-->
                    
                    
               
                
	      <!--td><input type="checkbox" name="fee<?php echo $f;?>" value="1"
                                    <?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                            ?></td-->
            
            
            
		<input type="hidden" value="<?php echo odbc_result($rs, "ID"); ?>" name="fee_Id<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Description"); ?>" name="Description<?php echo $f; ?>">
		<input type="hidden" value="<?php echo odbc_result($rs, "Document No_"); ?>" name="DocumentNo_<?php echo $f; ?>">
                <input type="hidden" value="<?php echo $Customerno; ?>" name="Customerno">
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
