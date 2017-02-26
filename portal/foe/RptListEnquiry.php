<?php
	require_once("header.php");
	$e=isset($_REQUST['e']);
	$Enqr=isset($_REQUEST['enq']);
	if($Enqr != ""){
		if($e=1){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User enqury has been updated.
					</div>
				</div>
			</div></div>";
		}
		if($e=0){
			echo "<div class='container'>
				<div class='bs-example'>
					<div class='alert alert-danger alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Error!</strong> There is some error, kindly check.
					</div>
				</div>
				</div>";
		}
	}
	
?>
<div class="container" style="overflow-x: hidden;">
	<h1 class="text-primary">Enquiry List</h1>
	<div class="table-responsive">
		<table class="table  table-striped table-hover">
			<thead>
				<tr>
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
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$result=odbc_exec($conn, "SELECT [No_], [Registration Status], [AdmissionStatus],[Enquiry Source], [Enquiry Status],[Name],[Mother_s Name],[Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3]    FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND YEAR([Enquiry Date])='".$_GET['y']."' AND MONTH([Enquiry Date]) LIKE '".$_GET['m']."%' ORDER BY [Enquiry Date] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($result)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i?></td>
					<td><?php echo odbc_result($result, "No_")?></td>
					<td align="center"><?php
							$row1=odbc_result($result, "Registration Status");
							if($row1==1){ echo "<font class='text-success'>&#x2713;</font>";}
							if($row1==0){ echo "<font class='text-danger'>&#x2717;</font>";}
							if($row1==""){ echo "<font class='text-danger'>&#8212;</font>";}
						?></td>
					<td align="center"><?php
							$row2=odbc_result($result, "AdmissionStatus");
							if($row2=="1") echo "<font class='text-danger'>&#x2713;</font>";
							if($row2=="0") echo "<font class='text-danger'>&#x2717;</font>";
							if($row2=="") echo "<font class='text-danger'>&#8212;</font>";							
						?></td>
					<td><?php echo odbc_result($result, "Enquiry Source")?></td>
					<td align="center"><?php
						$enqStat = odbc_result($result, "Enquiry Status");
						if($enqStat == 0) echo "Hot";
						if($enqStat == 1) echo "Cold";
						if($enqStat == 2) echo "Warm";
					?></td>
					<td><?php echo odbc_result($result, "Name")?></td>
					<td><?php echo odbc_result($result, "Father_s Name")?></td>
					<td><?php echo odbc_result($result, "FollowUP1")?></td>
					<td><?php echo odbc_result($result, "FollowUP2")?></td>
					<td><?php echo odbc_result($result, "FollowUP3")?></td>
					<td>
						<div class="bs-example">
							<a href="ListEnquiry.php?id=<?php echo odbc_result($result, "No_")?>#myModal<?=$i?>" class="text-primary" data-toggle="modal">View</a>
							 <?php
								require("RptModalEnquiry.php");
							?>
						</div>
					</td>
				</tr>
				<?php
						$i += 1;
					}					
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
	require_once("../footer.php");
?>