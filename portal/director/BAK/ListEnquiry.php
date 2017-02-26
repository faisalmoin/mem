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
						<strong>Success!</strong> User enquiry has been updated.
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
	//$result=mysql_query("SELECT * FROM `enquiry` WHERE `RegistrationStatus`='' AND `SchoolERPCode`='".$UsrComp[1]."' AND `UserLoginID`='$LoginID'") or die(mysql_error());
	//$result=odbc_exec($conn, "SELECT [No_],[Registration Status], [AdmissionStatus], [Enquiry Source], [Enquiry Status], [Name], [Mother_s Name], [Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3], [timestamp] FROM [".$ms."Enquiry] WHERE ([Registration Status]=0 OR [AdmissionStatus]=0) AND [User ID]='$LoginID'") or die(mysql_error());
	//$result=odbc_exec($conn, "SELECT [No_], [Registration Status], [AdmissionStatus],[Enquiry Source], [Enquiry Status],[Name],[Mother_s Name],[Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3]    FROM [Temp Enquiry] WHERE ([Registration Status]=0 OR [AdmissionStatus]=0) AND [User ID]='$LoginID' AND [Company Name]='$ms'") or die(mysql_error());
	//$result=odbc_exec($conn, "SELECT [No_], [Registration Status], [AdmissionStatus],[Enquiry Source], [Enquiry Status],[Name],[Mother_s Name],[Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3]    FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND [User ID]='$LoginID' ORDER BY [Enquiry Date] DESC") or die(mysql_error());
	
	if($_GET['ePage']=="" || $_GET['ePage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$eCurr = $_GET['ePage'];
		$e_max=50*$eCurr;
		$e_min = ($e_max - 50);
	}
?>

<div class="container" style="overflow-x: hidden;">
	<h1 class="text-primary">Enquiry List</h1>
	<div class="table-responsive">
		<table class="table table-striped table-hover  sticky-header">
			<form name="form" method="get">
			<tr style="background-color: #ffffff;">
				<td colspan="12" align="right"> Go to page
					<select name="ePage" onchange="this.form.submit()">						
						<?php							
							$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Enquiry] WHERE [Company Name]='$ms'") or die(odbc_errormsg($conn));
							for($e=1; $e<=odbc_result($enqCount,""); $e++){
								echo "<option value='$e' ";
								if($e == $_GET['ePage']) echo "selected";
								echo ">$e</option>";
							}
						?>
					</select>
				</td>
			</tr>
			</form>
			<thead>
				<tr style="background-color: #d3d3d3; font-weight: bold;">
					<td>SN</td>
					<td>Enquiry No.</td>
					<td>Enquiry Date</td>
					<td>Registration Status</td>
					<td>Admission Status</td>
					<td>Enquiry Source</td>
					<td>Enquiry Status</td>
					<td>Candidate Name</td>
					<td>Father's Name</td>
					<td>Conact Nos.</td>
					<td>Admission For Year</td>
					<td>Last Follow-up Remark</td>
					<td>Next Follow-up Date</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php
				
					$i=1;
					//$result=odbc_exec($conn, "SELECT [No_], [Registration Status], [AdmissionStatus],[Enquiry Source], [Enquiry Status],[Name],[Mother_s Name],[Father_s Name], [FollowUP1], [FollowUP2], [FollowUP3]   FROM ( 
					$result=odbc_exec($conn, "SELECT *   FROM ( 
							SELECT *, ROW_NUMBER() OVER (ORDER BY [Enquiry Date] DESC) as row FROM [Temp Enquiry] WHERE [Company Name]='$ms'
							) a WHERE a.row > $e_min and a.row <= $e_max ") or die(mysql_error());
					if(!$result){
						exit("Error in SQL execution...");
					}
					while(odbc_fetch_row($result)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i?></td>
					<td><?php 
							if(odbc_result($result, "System Genrated No_") != "") echo  odbc_result($result, "System Genrated No_");
							else echo odbc_result($result, "No_");
						?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Enquiry Date")))?></td>
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
					<td><b><?php echo odbc_result($result, "Name")?></b></td>
					<td><?php echo odbc_result($result, "Father_s Name")?></td>
					<td><?php 
							if(odbc_result($result, "Mobile Number") != "" ) echo "<span class='glyphicon glyphicon-phone'></span>: ".odbc_result($result, "Mobile Number") ." <br />";
							if(odbc_result($result, "Phone Number") != "" ) echo "<span class='glyphicon glyphicon-phone-alt'></span>: ".odbc_result($result, "Phone Number") ." <br />";
							if(odbc_result($result, "Father Mobile") != "" ) echo "F<span class='glyphicon glyphicon-phone'></span>:".odbc_result($result, "Father Mobile") ."<br />";
							if(odbc_result($result, "Mother Mobile") != "" ) echo "M<span class='glyphicon glyphicon-phone'></span>:".odbc_result($result, "Mother Mobile") ."<br />";
						?></td>
					<td><?php echo odbc_result($result, "Admission For Year")?></td>
					<td><?php 
							if(odbc_result($result, "FollowUP1") != "" && odbc_result($result, "FollowUP2") == "" && odbc_result($result, "FollowUP3") == "") echo odbc_result($result, "FollowUP1");
							if(odbc_result($result, "FollowUP1") != "" && odbc_result($result, "FollowUP2") != "" && odbc_result($result, "FollowUP3") == "") echo odbc_result($result, "FollowUP2");
							if(odbc_result($result, "FollowUP1") != "" && odbc_result($result, "FollowUP2") != "" && odbc_result($result, "FollowUP3") != "") echo odbc_result($result, "FollowUP3");
						?>
					</td>
					<td><?php echo ((strtotime(odbc_result($result, "Next FollowUp Date")) > 0 )? date('d/M/Y', strtotime(odbc_result($result, "Next FollowUp Date"))) : ""); ?></td>
					<td>
						<div class="bs-example">
							<?php
								if(odbc_result($result, "Registration Status") == 0 && odbc_result($result, "AdmissionStatus") == 0 ){
									//if(odbc_result($result, "Registration Status") == 0){
							?>
							<a href="EditEnquiry.php?id=<?php echo odbc_result($result, "No_")?>" class="text-success" data-toggle="modal">Edit</a>
							<?php
								}
							?>
							<a href="ListEnquiry.php?id=<?php echo odbc_result($result, "No_")?>#myModal<?=$i?>" class="text-primary" data-toggle="modal">View</a>
							 <?php
								require("ModalEnquiry.php");
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