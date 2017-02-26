<?php
	require_once("header.php");
	
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
<div class="container">
<h1 class="text-primary">Sale of Registration</h1>
<hr />
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<form name="form" method="get">
			<tr>
				<td colspan="9" align="right"> Go to page
					<select name="ePage" onchange="this.form.submit()">						
						<?php							
							$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Enquiry] WHERE [Registration Status]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
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
				<tr style="font-weight: bold; background-color: #A9E2F3;">				
					<td>Enquiry No.</td>
					<td>Registration Status</td>
					<td>Admission Status</td>
					<td>Enquiry Source</td>
					<td>Enquiry Status</td>
					<td>Candidate Name</td>
					<td>Mother's Name</td>
					<td>Father's Name</td>
					<td></td>
				</tr>
			</thead>
            <tbody>
            <?php
            $i=1;
            //$sql="SELECT [No_],[Registration Status],[AdmissionStatus],[Enquiry Source],[Enquiry Status],[Name], [Mother_s Name], [Father_s Name] ,[Registration Status]  FROM [Temp Enquiry] WHERE [Registration Status] = 0 AND [Company Name]='$ms' ORDER BY [Enquiry Date] DESC";
	    $sql = "SELECT [No_],[Registration Status],[AdmissionStatus],[Enquiry Source],[Enquiry Status],[Name], [Mother_s Name], [Father_s Name] ,[Registration Status], [System Genrated No_] FROM ( 
			SELECT *, ROW_NUMBER() OVER (ORDER BY [Enquiry Date] DESC) as row FROM [Temp Enquiry] WHERE [Company Name]='$ms' AND [Registration Status] = 0 AND [Inactive]=0
			) a WHERE a.row > $e_min and a.row <= $e_max ";
					$result = odbc_exec($conn, $sql);
					while($rs = odbc_fetch_array($result)){
                        ?>
                        <tr>
                            <td><?php 
					if(odbc_result($result, "System Genrated No_") != "") {
						echo  odbc_result($result, "System Genrated No_");
					}
					else {
						echo odbc_result($result, "No_");
					}
				?></td>
                            <td>
                                <?php
                                if(odbc_result($result, "Registration Status")==1) echo "&#x2713;";
                                if(odbc_result($result, "Registration Status")==0) echo "&#x2717;";
                                ?>
                            </td>
                            <td><?php
                                if(odbc_result($result, "AdmissionStatus")==1) echo "&#x2713;";
                                if(odbc_result($result, "AdmissionStatus")==0) echo "&#x2717;";
                                ?></td>
                            <td><?php echo odbc_result($result, "Enquiry Source"); ?></td>
                            <td><?php
                                    if(odbc_result($result, "Enquiry Status")==0) echo "Hot";
                                    if(odbc_result($result, "Enquiry Status")==1) echo "Cold";
                                    if(odbc_result($result, "Enquiry Status")==2) echo "Warm";
                                ?></td>
                            <td><?php  echo odbc_result($result, "Name");?></td>
                            <td><?php  echo odbc_result($result, "Mother_s Name"); ?></td>
                            <td><?php  echo odbc_result($result, "Father_s Name");?></td>
                            <td>
                                <div class="bs-example">
                                    <?php
                                    if(odbc_result($result, "Registration Status")==0){
					if(odbc_result($result, "System Genrated No_") != "") {
                                    ?>
                                    <a href="NewRegistrationDetails.php?EnquiryNo=<?php echo odbc_result($result, 'No_')?>" class="btn btn-lg btn-primary btn-sm" data-toggle="modal">Register</a>
                                    <?php
					}
                                    }
                                    else{
                                        echo "<a href='ViewRegistrationDetails.php?EnquiryNo=".odbc_result($result, 'No_') ."' class='btn btn-lg btn-primary btn-sm' data-toggle='modal'>View</a>";
                                    }
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

<?php require_once("../footer.php"); ?>