<?php require_once("header.php");?>
      <div class="container">
       <h2 class="text-primary">Student List</h2>
       <form action="qut.php" method="POST">
      <h2 style="float: right;" class="text-primary"> <button class="btn btn-primary">Generation School Term Fee</button></h2>
       <table class="table table-responsive">
		<thead>
			<tr>
				<th>SN</th>
				<th>Cust. No.</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Academic Year</th>
				<th>Class</th>
			</tr>
		   </thead>
		   <tbody>
		   <?php 
		   $FeeType=$_REQUEST['FeeType'];
			$i = 1;
			//if($_REQUEST['ClssCode'] != ""){
				/*$query = "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND 
						[Student Status]=1 AND [Class Code] ='".$_REQUEST['ClssCode']."' ";*/
				$query = "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND 
						[Student Status]=1 ";
						
				$rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
		   ?>
		   <tr>
			<td><?php echo $i?></td>
			<!--td><a href="qut.php?CustomerNo=<--?php echo odbc_result($rs, "System Genrated No_")?>"><--?php echo odbc_result($rs, "System Genrated No_");?></a></td-->
			<td><?php echo odbc_result($rs, "System Genrated No_");?></td>
			<td><?php echo odbc_result($rs, "Name");?></td>
			<td><?php 
				if(odbc_result($rs, "Gender")==1) echo "Boy";
				if(odbc_result($rs, "Gender")==2) echo "Girl";
			?></td>
			<td><?php echo odbc_result($rs, "Academic Year");?></td>
			<td><?php echo odbc_result($rs, "Class");?></td>
		
			<td><input type="checkbox" name="fee<?php echo $i?>" value="1" checked />
			<input type="hidden" name="registration<?php echo $i?>" value="<?php echo odbc_result($rs, "Registration No_");?>" />
			<input type="hidden" name="Class<?php echo $i?>" value="<?php echo odbc_result($rs, "Class");?>" />
			</td>
		  
		  </tr>
		  <?php 
					$i++;
				}
			//}
			
		  ?><tr><td>
		    <input type="hidden" name="Academic" value="<?php echo odbc_result($rs, "Academic Year");?>" />
		    <input type="hidden" value="<?php echo $i;?>" name="fee_count">
			<input type="hidden" value="<?php echo $FeeType;?>" name="FeeType">
		  </td> </tr>
		</tbody>
	    </table>
	    <!--button class="btn btn-primary">Submit</button-->
	    </form>
	    </div>
	<?php require_once("../footer.php"); ?>