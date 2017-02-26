<?php require_once("header.php");?>
<div class="container">
<form role="form" method="post" action="" name="AdmForm1">


<table id="results" class="table table-responsive">
  
	          <tr style="font-weight: bold; background-color: #d3d3d3;">
                    <td>SN</td>
                    <td>Admission No.</td>
                    <td>Student Name</td>
                    <td>Academic Year</td>
                    <td>Class & Section</td>
                    <td>Date of Birth</td>
                    <td>Gender</td>
                    <td>Addresse</td>
                    <td>Contact No</td>
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
		
		$rs = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [Student Status]=1  $where ORDER BY [Academic Year] ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	
	     <tr>
		      <td><?php echo $f; ?></td>
                    <td><?php echo odbc_result($rs, "No_"); ?></td>
                    <td><?php echo odbc_result($rs, "Name"); ?></td>
                    <td><?php echo odbc_result($rs, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($rs, "Class")." ".odbc_result($rs, "Section"); ?></td>
                    <td><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Date Of Birth"))); ?></td>
                    <td><?php 
			if(odbc_result($rs, "Gender")==1) echo "Boy"; 
			if(odbc_result($rs, "Gender")==2) echo "Girl"; 
		    ?></td>
                    <td><?php echo odbc_result($rs, "Addressee"); ?></td>
                    <td><?php echo odbc_result($rs, "Mobile Number"); ?></td>		
               
			
			<td><input type="hidden" name="RegistrationNo" value="<?php echo odbc_result($rs, "Registration No_")?>" /></td>
			<td><input type="checkbox" name="fee<?php echo $f?>" value="1" />
			
		</td>
	
	
	 </tr>
	
	<?php
			$f++;
		}
	?>
	<input type="hidden" value="<?php echo $f?>" name="fee_count">
	</table>
	<button class="btn btn-primary">Submit</button>
	

</form>
</div>