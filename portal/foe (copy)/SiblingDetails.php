<?php
	require_once("../db.txt");
	$id = $_GET['id'];
	$ms = $_GET['ms'];
	
	if(isset($_REQUEST['submit'])) {
        if (!empty($_REQUEST['AdmNo'])) {
            $Stu = "SELECT * FROM [Temp Student] WHERE [Company Name] = '$ms' AND [Student Status] <2 AND [No_] <> '$id'
			AND (lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Mobile Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Phone Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Enquiry No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Application No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Registration No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
	    
            $check = odbc_exec($conn, $Stu);
            if(odbc_num_rows($check) < 1){
                echo("<div class='container'>
				        <div class='bs-example'>
					        <div class='alert alert-danger alert-error'>
						        <a href='#' class='close' data-dismiss='alert'>&times;</a>
						        <strong>Error!</strong> Data not found, kindly check ...
					        </div>
				        </div>
				    </div>");
            }
            /*else{
                header("Location: StudentCard.php?q=".odbc_result($check, 'No_'));
            }*/
        } else {
            echo "<div class='container'>
				    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Error!</strong> Please provide Student's Enrollment/Admission Number ...
                        </div>
				    </div>
				</div>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="../favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Educomp School Portal</title>
    
	<!-- Bootstrap core CSS -->
	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	
	<!-- Custom styles for this template -->
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	
	 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="../bs/js/jquery-1.10.2.js"></script>
	<script src="../bs/js/jquery-ui.js"></script>
	
	<script src="../bs/js/logout.js"></script>

	
</head>
	
<body  oncontextmenu="return false">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="text-primary">Student's Card</h3></div>
			<div class="panel-body">
				<form role="form" method="get">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				<input type="hidden" name="ms" value="<?php echo $ms;?>">
				<div class="row form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-2"><label class="control-label">Student Enrollment No.</label></div>
					<div class="col-sm-4"><input type="text" name="AdmNo" title="Enter Student's Name / Application No / Registration No / Mobile Number / Phone Number / Enquiry No. ..." class="form-control input-lg" required autocomplete="Off" autofocus="true" style="text-transform: uppercase" /></div>
					<div class="col-sm-2"><button type="submit" class="btn btn-primary input-lg" name="submit">Submit</button></div>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="text-primary">Sibling List</h3></div>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-responsive">
					<thead>
						<tr style="font-weight: bold;" class="warning">
							<td>SN</td>
							<td>Registration No</td>
							<td>Student Name</td>
							<td>Gender</td>
							<td>Class</td>
							<td>Section</td>
							<td>Date of Birth</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
					<?php
						$i = 1;
						$Student = odbc_exec($conn, $Stu);
						while(odbc_fetch_array($Student)){
						?>
					<tr>
						<td><input type="radio" 
								value="<?php echo odbc_result($Student, "No_"); ?>" 
								name="<?php echo odbc_result($Student, "No_"); ?>"
								id="ddlCode<?php echo $i?>"
								onclick="SetName<?php echo $i?>();" />							 
						</td>
						<td>
							<?php echo odbc_result($Student, "No_"); ?>
						</td>
						<td><?php echo odbc_result($Student, "Name"); ?><input type="hidden" name="ddlName<?php echo $i?>" id="ddlName<?php echo $i?>" value="<?php echo odbc_result($Student, "Name"); ?>"></td>
						<td><?php
							if(odbc_result($Student, "Gender") == 1) echo "Boy";
							if(odbc_result($Student, "Gender") == 2) echo "Girl";
						?></td>
						<td><?php echo odbc_result($Student, "Class"); ?><input type="hidden" name="ddlClass<?php echo $i?>" id="ddlClass<?php echo $i?>" value="<?php echo odbc_result($Student, "Class"); ?>"></td>
						<td><?php echo odbc_result($Student, "Section"); ?><input type="hidden" name="ddlSection<?php echo $i?>" id="ddlSection<?php echo $i?>" value="<?php echo odbc_result($Student, "Section"); ?>"></td>
						<td><?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth"))); ?><input type="hidden" name="ddlDOB<?php echo $i?>" id="ddlDOB<?php echo $i?>" value="<?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth"))); ?>"></td>
						<td><?php
							if(odbc_result($Student, "Student Status")== 0) echo "";
							if(odbc_result($Student, "Student Status")== 1) echo "Active";
							if(odbc_result($Student, "Student Status")== 2) echo "In-Active";
							if(odbc_result($Student, "Student Status")== 3) echo "Alumni";
						?><input type="hidden" name="ddlNo<?php echo $i?>" id="ddlNo<?php echo $i?>" value="<?php echo odbc_result($Student, "Student Status"); ?>"></td>						
					</tr>
					<script type="text/javascript">
						function SetName<?php echo $i?>() {
							if (window.opener != null && !window.opener.closed) {
								var txtCode = window.opener.document.getElementById("SiblingCode");
								var txtName = window.opener.document.getElementById("SiblingName");
								var txtDOB = window.opener.document.getElementById("SiblingDOB");
								var txtClass = window.opener.document.getElementById("SiblingClass");
								var txtSection = window.opener.document.getElementById("SiblingSection");
								var txtNo = window.opener.document.getElementById("SiblingNo");
								
								txtCode.value = document.getElementById("ddlCode<?php echo $i?>").value;								
								txtName.value = document.getElementById("ddlName<?php echo $i?>").value;								
								txtDOB.value = document.getElementById("ddlDOB<?php echo $i?>").value;								
								txtClass.value = document.getElementById("ddlClass<?php echo $i?>").value;								
								txtSection.value = document.getElementById("ddlSection<?php echo $i?>").value;
								txtNo.value = document.getElementById("ddlNo<?php echo $i?>").value;
							
							}
							window.close();
						}
					</script>
					<?php
						
						$i += 1;
					}
					?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	</body>
</html>
