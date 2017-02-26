<?php
	require_once("header.php");
	
	if($_GET['id'] != ""){
		echo "<div class='container'>
				<div class='alert alert-success alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Success!</strong> Application No. - ".$_GET['id'].", has been RECEIVED and Registered.
				</div>
			</div>";
		}
	
	if($_GET['gPage']=="" || $_GET['gPage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$eCurr = $_GET['gPage'];
		$e_max=50*$eCurr;
		$e_min = ($e_max - 50);
	}
	
?>
<div class="container">
<h1 class="text-primary">Registration Confirmation</h1>
<hr />
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<form name="form" method="get">
			<tr>
				<td colspan="9" align="right"> Go to page
					<select name="gPage" onchange="this.form.submit()">
						
						<?php							
							$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Application] WHERE [Registration Status]=1 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
							for($e=1; $e<=odbc_result($enqCount,""); $e++){
								echo "<option value='$e' ";
								if($e == $_GET['gPage']) echo "selected";
								echo ">$e</option>";
							}
						?>
					</select>
				</td>
			</tr>
			</form>
			<thead>
				<tr style="font-weight: bold; background-color: #A9E2F3;">
					<td>Enquiry No.</td>
					<td>Registration No.</td>
					<td>Registration Form No.</td>
					<td>Candidate Name</td>
					<td>Class Applied</td>
					<td>Application Status</td>
					<td>Sale Date</td>
					<td>Confirmation Date</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
			<?php
				//$rs=odbc_exec($conn, "SELECT TOP 50 [Enquiry No_], [No_],[Registration No_],[Name],[Class],[Registration Status], [Date of Sale],  [Date of Receive]  FROM [Temp Application] WHERE [Registration Status] = 1 AND [Company Name]='$ms'");
				$rs=odbc_exec($conn, "SELECT [Enquiry No_], [No_],[Registration No_],[Name],[Class],[Registration Status], [Date of Sale],  [Date of Receive] FROM ( 
			SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Sale] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] = 1 AND [Date of Receive] = ''
			) a WHERE a.row > $e_min and a.row <= $e_max");
				while(odbc_fetch_array($rs)){
			?>
			<tr>
				<td><?php echo odbc_result($rs, "Enquiry No_")?></td>
				<td><?php echo odbc_result($rs, "No_")?></td>
				<td><?php echo odbc_result($rs, "Registration No_")?></td>
				<td><?php echo odbc_result($rs, "Name")?></td>
				<td><?php echo odbc_result($rs, "Class")?></td>
				<td><?php
                        if(odbc_result($rs, "Registration Status")==1) echo "SOLD";
                        if(odbc_result($rs, "Registration Status")==2) echo "RECEIVED";
                        if(odbc_result($rs, "Registration Status")==3) echo "SELECTED";
                        if(odbc_result($rs, "Registration Status")==4) echo "PENDING APPROVAL";
                        if(odbc_result($rs, "Registration Status")==5) echo "APPROVED";
                        if(odbc_result($rs, "Registration Status")==6) echo "ADMITTED";
                    ?></td>
				<td><?php 
					$date1 = date('d/M/Y', strtotime(odbc_result($rs, "Date of Sale")));
					if($date1 == '01/Jan/1753' || $date1 == '01/Jan/1970'){
					    echo "-";
					}
					else{
					    echo $date1;
					}
				?></td>
				<td><?php
                        $date = date('d/M/Y', strtotime(odbc_result($rs, "Date of Receive")));
                        if($date == '01/Jan/1753' || $date == '01/Jan/1970'){
                            echo "-";
                        }
                        else{
                            echo $date;
                        }
                     ?></td>
				<td>
					<div class="bs-example">						
						<?php
							if(odbc_result($rs, "Registration Status") == 1){
						?>
							<a href="NewRegistrationConfirm.php?id=<?php echo odbc_result($rs, 'Enquiry No_')?>" class="btn btn-lg btn-primary btn-sm" data-toggle="modal">Confirm</a>
						 <?php
						 }
						 else{
							echo "<a href='ViewRegistrationConfirm.php?odbc_result($rs, 'Enquiry No_')' class='btn btn-lg btn-primary btn-sm' data-toggle='modal'>View</a>";
						 }
						 ?>
					</div>
					
				</td>
			</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once("../footer.php");?>