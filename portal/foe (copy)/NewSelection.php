<?php
	require_once("header.php");
	
	$err=$_REQUEST['err'];
	$ClassApplied=$_REQUEST['ClassApplied'];
	$ApplicationNo=$_REQUEST['ApplicationNo'];
	$RegistrationNo=$_REQUEST['RegistrationNo'];
    $StuName = $_REQUEST['StuName'];

    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE UPPER([Class])=UPPER('$ClassApplied') AND UPPER([Name]) LIKE UPPER('%$StuName%') OR (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([Name]) LIKE UPPER('%$StuName%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND (UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo != "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND (UPPER([Name]) LIKE UPPER('%$StuName%') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName == ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo != "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%')) AND (UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') OR UPPER([Name]) LIKE UPPER('%$StuName%')) AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName != ""){
        $where=" WHERE (UPPER([Class])=UPPER('$ClassApplied') OR UPPER([No_]) LIKE UPPER('%$ApplicationNo%') OR UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%')) AND UPPER([Name]) LIKE UPPER('%$StuName%') AND [Registration Status] = 2";
    }
    if($ClassApplied == "" && $ApplicationNo == "" && $RegistrationNo == "" && $StuName == ""){
        $where=" WHERE  [Registration Status] = 2";
    }
    if($ClassApplied != "" && $ApplicationNo != "" && $RegistrationNo != "" && $StuName != ""){
        $where=" WHERE UPPER([Class])=UPPER('$ClassApplied') AND UPPER([No_]) LIKE UPPER('%$ApplicationNo%') AND UPPER([Registration No_]) LIKE UPPER('%$RegistrationNo%') AND UPPER([Name]) LIKE UPPER('%$StuName%') AND [Registration Status] = 2";
    }

    $SQL = "SELECT [No_], [Registration No_], [Enquiry No_], [Name], [Gender], [Father_s Name], [Mother_s Name], [Date Of Birth], [Mobile Number], [Class], [Admission for Year] FROM [Temp Application] ".$where."AND [Company Name]='$ms'";;
    //echo $SQL;
    $result=odbc_exec($conn, $SQL);

    if(odbc_num_rows($result) == 0){
        $msg="<div class='alert alert-danger alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Error!</strong> No candidate was found ...
			</div>";
    }
    /*else{
        $msg="<div class='alert alert-success alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Success!</strong> Selected student(s) has been selected for admission.
			</div>";
    }*/

	if($err == "0"){
		$msg="<div class='alert alert-danger alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Error!</strong> There is some error, kindly check.
			</div>";
	}
	if($err == "1"){
		$msg="<div class='alert alert-success alert-error'>
				<a href='#' class='close' data-dismiss='alert'>&times;</a>
				<strong>Success!</strong> Selected student(s) has been selected for admission.
			</div>";
	}
    if($err == "2"){
        $msg="<div class='alert alert-danger alert-error'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Error!</strong> Kindly select atleast 1 (One) candidate ...
                </div>";
    }
?>
<script type='text/javascript'>
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag=odbc_exec($conn, "SELECT [No_], [Name], [Enquiry No_], [Registration No_] FROM [Temp Application] WHERE [Registration Status] = 2 AND [Company Name]='$ms'");
                while(odbc_fetch_array($City_Tag)){
                    echo "'". odbc_result($City_Tag, "No_")."', '". odbc_result($City_Tag, "Name")."', '".odbc_result($City_Tag, "Enquiry No_")."', '". odbc_result($City_Tag, "Registration No_")."'";
                }
            ?> ];

        $( "#application, #registration, #applicant" ).autocomplete({
            source: availableTags
        });
    });
</script>

<div class="container">
    <h2 class="text-primary">Student Selection Process</h2>
	<?php echo $msg; ?>
	<div class="table-responsive">
            <form name="form1">
            
            <table class="table table-bordered">
                <tr style="background-color: #A9E2F3; color: #ffffff; font-weight: bold;">
                    <td colspan="5">Get Applicant</td>
                </tr>
                <tr>
                    <td height="40px">Class</td>
                    <td height="40px">Application No</td>
                    <td height="40px">Registration No</td>
                    <td height="40px">Applicant Name</td>
                    <td height="40px" rowspan="2" valign="middle"><input type="submit" class="btn btn-primary" value="Submit" /></td>
                </tr>
                 <tr>
                    <td height="40px">
                        <select name="ClassApplied" id="class" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" >
                            <option value=""></option>
                            <?php
                                $AppClass = odbc_exec($conn, "SELECT DISTINCT([Class]) FROM [Temp Application] WHERE [Company Name]='$ms' ORDER BY [Class]");
                                while(odbc_fetch_array($AppClass)){
                                     echo "<option value='".odbc_result($AppClass, 'Class')."'>".odbc_result($AppClass, 'Class')."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td height="40px"><input type="text" id="application" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="ApplicationNo" /></td>
                    <td height="40px"><input type="text" id="registration" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="RegistrationNo" /></td>
                    <td height="40px"><input type="text" id="applicant" value="" style="padding: 4px; width: 165px; border: 1px solid #c3c3c3;" name="StuName" /></td>
                </tr>
            </table>
            </form>		
	</div>
</div>
<hr />
    <script type='text/javascript'>//<![CDATA[
        $(function(){
            var checkboxes = $("input[type='checkbox']"),
                submitButt = $("input[id='submit']");
            checkboxes.click(function() {
                submitButt.attr("disabled", !checkboxes.is(":checked"));
            });
        });//]]>

    </script>
<form name="form2" method="POST" action="UpdateSelection.php" onkeypress="return event.keyCode != 13;">
<div class="container">
	<div class="table-responsive">
		<table class="table table-striped table-hover table-bordered">
			<thead>
			<tr style="background-color: #A9E2F3; color: #ffffff; font-weight: bold;">
				<td>Application No</td>
				<td>Registration No</td>
				<td>Enquiry No</td>
				<td>Candidate Name</td>
				<td>Gender</td>
				<td>Father Name</td>
				<td>Mother Name</td>
				<td>Date of Birth</td>
				<td>Mobile</td>
				<td>Class</td>
				<td>Addmission for Year</td>
				<td>Select</td>
			</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
                $SelSQL=odbc_exec($conn, $SQL);
				while(odbc_fetch_array($SelSQL)){
			?>
			<tr>
				<td><?php echo odbc_result($SelSQL, "No_");?></td>
				<td><?php echo odbc_result($SelSQL, "Registration No_");?></td>
				<td><?php echo odbc_result($SelSQL, "Enquiry No_");?></td>
				<td><?php echo odbc_result($SelSQL, "Name");?></td>
				<td><?php
                        if(odbc_result($SelSQL, "Gender")==1) echo "Boy";
                        if(odbc_result($SelSQL, "Gender")==2) echo "Girl";
                    ?></td>
				<td><?php echo odbc_result($SelSQL, "Father_s Name");?></td>
				<td><?php echo odbc_result($SelSQL, "Mother_s Name");?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($SelSQL, "Date Of Birth")));?></td>
				<td><?php echo odbc_result($SelSQL, "Mobile Number");?></td>
				<td><?php echo odbc_result($SelSQL, "Class");?></td>
				<td><?php echo odbc_result($SelSQL, "Admission for Year");?></td>
				<td><input type="checkbox" id="checkme" style="padding: 4px" name="id<?=$i?>" value="<?php echo odbc_result($SelSQL, "Enquiry No_");?>" /></td>
			</tr>
			<?php
					$i += 1;
				}
			?>
			<input type="hidden" name="Count" value= "<?=$i?>" />
			<tr>
				<td colspan="14" align="right">
				<!--input type="submit" class="btn btn-success" id="submit" disabled value="Update Status"  /-->
					<input type="submit" class="btn btn-primary" id="submit" disabled value="Update Status"  />
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
</form>


<?php require_once("../footer.php");?>
