<?php
	require_once("header.php");
	$e=isset($_REQUST['e']);
	//$e=isset($_REQUST['e']);
	//$Enqr=isset($_REQUEST['enq']);

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
	<h1 class="text-primary">Registration List</h1>
	<div class="table-responsive">
		<table class="table  table-striped table-hover">
			<form action="directorRptRegistration.php" name="form" method="get">
			<input type="hidden" name="c"  value="<?php echo $_GET['c'];?>" />
			<input type="hidden" name="sd"  value="<?php echo $_GET['sd'];?>" />
			<input type="hidden" name="ed"  value="<?php echo $_GET['ed'];?>" />
			<input type="hidden" name="y"  value="<?php echo $_GET['y'];?>" />
			
			<tr style="background-color: #ffffff;">
				<td colspan="12" align="right"> Go to page
					<select name="ePage" onchange="this.form.submit()">						
						<?php
                                                      	$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Application] WHERE [Admission For Year]='".$_GET['y']."' AND [Company Name]='".$_GET['c']."'");
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
					<td>Candidate Name</td>
					<td>Addresse </td>
					<td>Class</td>
					<td>Admission For Year</td>
						
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php
				
				 $i=1;
					$result=odbc_exec($conn, "SELECT *   FROM ( 
							SELECT *, ROW_NUMBER() OVER (ORDER BY [Class] DESC) as row FROM [Temp Application] WHERE [Admission For Year]='".$_GET['y']."' AND [Company Name]='".$_GET['c']."'
							) a WHERE a.row > $e_min and a.row <= $e_max") or exit(odbc_errormsg($conn));
					while(odbc_fetch_array($result)){
				?>
				<tr style="font-size: 12px;">
					<td><?php echo  odbc_result($result, "row")?></td>
					<td><?php echo odbc_result($result, "Name")?></td>
					<td ><?php echo odbc_result($result, "Addressee");?></td>
					<td><?php echo odbc_result($result, "Class")?></td>
					<td><?php echo odbc_result($result, "Academic Year")?></td>
					
					
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