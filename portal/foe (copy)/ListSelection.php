<?php
	require_once("header.php");
	
	if($_GET['eid']!="" && $_GET['Stu']!=""){
		echo "<div class='container'>
	                <div class='bs-example'>
	                    <div class='alert alert-success alert-error'>
	                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
	                        <strong>Success!</strong> Application No. <strong>".$_GET['eid']." (Student Name: ".$_GET['Stu'].")</strong> has been registered. You will get the status after few minutes.
	                    </div>
	                </div></div>";
	}
	
	//$Student=mysql_query("SELECT b.`RegistrationNo`, b.`RegistrationFormNo`, b.`EnquiryNo`, a.`StudentName`, a.`Gender`, a.`FatherName`, a.`MotherName`, a.`DOB`, a.`Mobile`, a.`Email`, a.`ClassApplied`, a.`AcadYear`, b.`id`, b.`AdmissionNo` FROM `enquiry` a, `registration` b WHERE a.`SchoolERPCode`='$Comp[1]' ") or die(mysql_error());
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
	<h1 class="text-primary">Selected Student List</h1>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<form name="form" method="get">
			<tr style="background-color: #ffffff;">
				<td colspan="12" align="right"> Go to page
					<select name="ePage" onchange="this.form.submit()">						
						<?php							
							$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Application] WHERE [Registration Status]=3 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
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
			<tr style="background-color: #A9E2F3; font-weight: bold;">
				<td>Application No</td>
				<td>Registration No</td>
				<!--<td>Enquiry No</td>-->
				<td>Candidate Name</td>
				<td>Gender</td>
				<td>Father Name</td>
				<td>Mother Name</td>
				<td>Date of Birth</td>
				<!--<td>Mobile</td>-->
				<td>Class</td>
				<td>Addmission for Year</td>
				<td></td>
			</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
                //$SQL1 = "SELECT [No_],[Registration No_],[Enquiry No_],[Name],[Gender],[Father_s Name],[Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year] FROM [Temp Application] WHERE [Registration Status]=3 AND [Company Name]='$ms'";
                $SQL1 = "SELECT [No_],[Registration No_],[Enquiry No_],[Name],[Gender],[Father_s Name],[Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year]  FROM ( 
							SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Receive] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] = 3 AND [Allot Student]=0
							) a WHERE a.row > $e_min and a.row <= $e_max ";
                $SelSQL=odbc_exec($conn, $SQL1);
				while(odbc_fetch_array($SelSQL)){
			?>
			<tr >
                <td><?php echo odbc_result($SelSQL, "No_");?></td>
                <td><?php echo odbc_result($SelSQL, "Registration No_");?></td>
                <!--<td><?php //echo odbc_result($SelSQL, "Enquiry No_");?></td>-->
                <td><?php echo odbc_result($SelSQL, "Name");?></td>
                <td><?php
                    if(odbc_result($SelSQL, "Gender")==1) echo "Boy";
                    if(odbc_result($SelSQL, "Gender")==2) echo "Girl";
                    ?></td>
                <td><?php echo odbc_result($SelSQL, "Father_s Name");?></td>
                <td><?php echo odbc_result($SelSQL, "Mother_s Name");?></td>
                <td><?php echo date('d/M/Y', strtotime(odbc_result($SelSQL, "Date Of Birth")));?></td>
                <!--<td><?php //echo odbc_result($SelSQL, "Mobile Number");?></td>-->
                <td><?php echo odbc_result($SelSQL, "Class");?></td>
                <td><?php echo odbc_result($SelSQL, "Admission for Year");?></td>
				<td>
					<?php
						if($Stu[13] == ""){
					?>
					<a href="NewAdmission.php?id=<?php echo odbc_result($SelSQL, "Enquiry No_");?>" class="btn btn-primary">Admission</a>
					<?php
						}
						if($Stu[13] != ""){
						
					?>
					<a href="ListAdmission.php?id=<?php echo odbc_result($SelSQL, "Enquiry No_");?>" class="btn btn-primary">View</a>
					<?php 
						}
					?>
				</td>
			</tr>
			<?php
					$i += 1;
				}
			?>
		</table>
	</div>
</div>
<?php
	require_once("../footer.php");
?>