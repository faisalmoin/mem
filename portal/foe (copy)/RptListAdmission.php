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
					<td>Academic Year</td>
					<td>Class & Section</td>
					<td>Addresse</td>
					<td>Contact No</td>
					<td>Date Joined</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					$stu3=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number], [Date Joined] FROM [Temp Student] WHERE [Company Name]='$ms' AND YEAR([Date Joined])='".$_GET['y']."' AND MONTH([Date Joined]) LIKE '".$_GET['m']."%' ORDER BY [Date Joined] DESC") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($stu3)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo $i; ?></td>
					<td><a href="StudentCard.php?id=<?php echo odbc_result($stu3, "No_"); ?>"><?php echo odbc_result($stu3, "No_"); ?></a></td>
					<td><?php echo odbc_result($stu3, "Name"); ?></td>
					<td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
					<td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
					<td><?php echo odbc_result($stu3, "Addressee"); ?></td>
					<td><?php echo odbc_result($stu3, "Mobile Number"); ?></td>
					<td><?php echo date('d/M/Y', strtotime(odbc_result($stu3, "Date Joined"))); ?></td>
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