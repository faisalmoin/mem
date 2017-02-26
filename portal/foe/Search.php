<?php
	require_once("header.php");

	//$AdmNo=$_REQUEST['Keyword'];
?>
<div class="container">
	<h3 class="text-primary">Search for "<b><?php echo $_REQUEST['AdmNo']?></b>" ...</h3>
	
	<?php
		//Check in enquiry table
		$QryEnq = "SELECT * FROM [Temp Enquiry] WHERE [Company Name] = '$ms' 
				AND (
				lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Mobile Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Phone Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([System Genrated No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
		//exit($QryEnq);
		$Enq = odbc_exec($conn, $QryEnq) or die(odbc_errormsg());
		if(odbc_num_rows($Enq) > 0){
	?>
	<hr />
	<h3 class="text-primary">Enquiry ...</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr style="background-color: #d3d3d3; font-weight: bold;">
					<td>SN</td>
					<td>Enquiry No.</td>
					<td>Registration Status</td>
					<td>Admission Status</td>
					<td>Enquiry Source</td>
					<td>Enquiry Status</td>
					<td>Candidate Name</td>
					<td>Father's Name</td>
					<td>Follow-up 1</td>
					<td>Follow-up 2</td>
					<td>Follow-up 3</td>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
				while(odbc_fetch_row($Enq)){
			?>
				<tr style="font-size: 12px;">
					<td><?php echo $i?></td>
					<td><a href="EditEnquiry.php?id=<?php echo odbc_result($Enq, "No_")?>"><?php echo odbc_result($Enq, "No_")?></a></td>
					<td align="center"><?php
							$row1=odbc_result($Enq, "Registration Status");
							if($row1==1){ echo "<font class='text-success'>&#x2713;</font>";}
							if($row1==0){ echo "<font class='text-danger'>&#x2717;</font>";}
							if($row1==""){ echo "<font class='text-danger'>&#8212;</font>";}
						?></td>
					<td align="center"><?php
							$row2=odbc_result($Enq, "AdmissionStatus");
							if($row2=="1") echo "<font class='text-danger'>&#x2713;</font>";
							if($row2=="0") echo "<font class='text-danger'>&#x2717;</font>";
							if($row2=="") echo "<font class='text-danger'>&#8212;</font>";							
						?></td>
					<td><?php echo odbc_result($Enq, "Enquiry Source")?></td>
					<td align="center"><?php
						$enqStat = odbc_result($Enq, "Enquiry Status");
						if($enqStat == 0) echo "Hot";
						if($enqStat == 1) echo "Cold";
						if($enqStat == 2) echo "Warm";
					?></td>
					<td><b><?php echo odbc_result($Enq, "Name")?><b></td>
					<td><?php echo odbc_result($Enq, "Father_s Name")?></td>
					<td><?php echo odbc_result($Enq, "FollowUP1")?></td>
					<td><?php echo odbc_result($Enq, "FollowUP2")?></td>
					<td><?php echo odbc_result($Enq, "FollowUP3")?></td>					
				</tr>
				<?php
					$i++;
					}			
				?>
			</tbody>
		</table>
		<?php
		}
			$i=1;
			//Application table
			$QryApp = "SELECT * FROM [Temp Application] WHERE [Company Name] = '$ms' 
				AND (
				lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Registration No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Enquiry No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([System Genrated No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
			
			$App = odbc_exec($conn, $QryApp) or die(odbc_errormsg($conn));
			if(odbc_num_rows($App) > 0){
		?>
		<hr />
		<h3 class="text-primary">Application ...</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr style="background-color: #d3d3d3; font-weight: bold;">
					<td>SN</td>
					<td>App No.</td>
					<td>Name</td>
					<td>Father's Name</td>
					<td>Admission for Year</td>
					<td>Class</td>
					<td>Registration No.</td>
					<td>Date of Sale</td>
					<td>Date of Receive</td>					
					<td>Registration Status</td>
				</tr>
			</thead>
			<tbody>
			<?php
				while(odbc_fetch_array($App)){
			?>
				<tr style="font-size: 12px;">
					<td><?php echo $i?></td>
					<td><?php echo odbc_result($App, 'No_')?></td>
					<td><?php echo odbc_result($App, 'Name')?></td>
					<td><?php echo odbc_result($App, 'Father_s Name')?></td>
					<td><?php echo odbc_result($App, 'Admission for Year')?></td>					
					<td><?php echo odbc_result($App, 'Class')?></td>					
					<td><?php echo odbc_result($App, 'Registration No_')?></td>					
					<td><?php echo date('d/M/Y', strtotime(odbc_result($App, 'Date of Sale')))?></td>					
					<td><?php echo ((strtotime(odbc_result($App, 'Date of Receive')) > 0)?date('d/M/Y', strtotime(odbc_result($App, 'Date of Receive'))):'-'); ?></td>					
					<td><?php 
							$regStat=odbc_result($App, 'Registration Status');
							if($regStat==1) echo "Sold";
							if($regStat==2) echo "Received";
							if($regStat==3) echo "Selected";
							if($regStat==4) echo "Pending Approval";
						?></td>					
				</tr>
			<?php
					$i++;
				}
			?>
			</tbody>
		</table>
		<?php	
			}
			$i=1;
			//Student Table
			$QryStu = "SELECT * FROM [Temp Student] WHERE [Company Name] = '$ms' AND 
				[Student Status] <3 AND (
				lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Mobile Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Phone Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Enquiry No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Application No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR 
				lower([Registration No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
			
			$Student = odbc_exec($conn, $QryStu) or die(odbc_errormsg($conn));
			if(odbc_num_rows($Student) > 0){
		?>
		<hr />
		<h3 class="text-primary">Student ...</h3>
		<table class="table table-striped table-hover">
			<thead>
				<tr style="background-color: #d3d3d3; font-weight: bold;">
					<td>SN</td>
					<td>Registration No</td>
					<td>Student Name</td>
					<td>Gender</td>
					<td>Class</td>
					<td>Section</td>
					<td>Academic Year</td>
					<td>Status</td>
				</tr>
			</thead>
			<tbody>
			<?php
				while(odbc_fetch_array($Student)){
			?>
				<tr style="font-size: 12px;">
					<td><?php echo $i; ?></td>
					<td>
						<a href="StudentCard.php?id=<?php echo odbc_result($Student, "No_")?>" class="text-primary"><?php echo odbc_result($Student, "No_"); ?></a>
					</td>
					<td><?php echo odbc_result($Student, "Name"); ?></td>
					<td><?php
						if(odbc_result($Student, "Gender") == 1) echo "Boy";
						if(odbc_result($Student, "Gender") == 2) echo "Girl";
					?></td>
					<td><?php echo odbc_result($Student, "Class"); ?></td>
					<td><?php echo odbc_result($Student, "Section"); ?></td>
					<td><?php echo odbc_result($Student, "Academic Year"); ?></td>
					<td><?php
						if(odbc_result($Student, "Student Status")== 0) echo "";
						if(odbc_result($Student, "Student Status")== 1) echo "Active";
						if(odbc_result($Student, "Student Status")== 2) echo "In-Active";
						if(odbc_result($Student, "Student Status")== 3) echo "Alumni";
					?></td>
				</tr>
			<?php
				$i += 1;
			}
			?>
			</tbody>
		</table>
		<?php
			}
		?>
</div>
<?php
	require_once("../footer.php"); 
?>