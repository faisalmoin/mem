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
	<h1 class="text-primary">Admission List</h1>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td>SN</td>
					<td>Admission No.</td>
					<td>Student Name</td>
					<td>Gender</td>
					<td>Academic Year</td>
					<td>Class & Section</td>
					<td>TC No.</td>
					<td>TC Issue Date</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					//echo "SELECT [TC No_], [Student Name], [Academic Year], [Class], [Section], [Academic Year], [Student No_], [Date of Issue], [Gender] FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND YEAR([Date of Issue])='".$_GET['y']."' AND MONTH([Date of Issue]) LIKE '".$_GET['m']."%' AND [TC Issued]=1 AND [Approval Status]=2 ORDER BY [Date of Issue] DESC";
					$stu3=odbc_exec($conn, "SELECT [TC No_], [Student Name], [Academic Year], [Class], [Section], [Academic Year], [Student No_], [Date of Issue], [Gender] FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND YEAR([Date of Issue])='".$_GET['y']."' AND MONTH([Date of Issue]) LIKE '".$_GET['m']."%' AND [TC Issued]=1 ORDER BY [Date of Issue] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($stu3)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i; ?></td>
					<td><a href="StudentTCApply.php?id=<?php echo odbc_result($stu3, "Student No_"); ?>"><?php echo odbc_result($stu3, "Student No_"); ?></a></td>
					<td><?php echo odbc_result($stu3, "Student Name"); ?></td>
					<td><?php 
							if(odbc_result($stu3, "Gender")==1) echo "Boy"; 
							if(odbc_result($stu3, "Gender")==2) echo "Girl";
							else echo odbc_result($stu3, "Gender")
					?></td>
					<td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
					<td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
					<td><?php echo odbc_result($stu3, "TC No_"); ?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($stu3, "Date of Issue"))); ?></td>
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