<?php
	require_once("header.php");
	
	$LoginID=$_REQUEST['LoginID'];
	
	if($LoginID == ""){
?>
<br /><br /><br />
		<center>
		<div class="container">
			<form role="form" name="form">
				<div class="form-group">
					<label>User Name</label>
					<select name="LoginID" onChange="this.form.submit()" style="padding: 8px;">
						<option value=""></option>
						<?php
							$temp=mysql_query("SELECT `LoginID`, `FullName` FROM `user` ORDER BY `FullName`") or die(mysql_error());
							while($tmp=mysql_fetch_array($temp)){
								echo "<option value='$tmp[0]'>$tmp[1] ($tmp[0])</option>";
							}
						?>
					</select>
				</div>
			</form>
		</div>
		</center>
<?php
	}
	else{
		$User=mysql_query("SELECT * FROM `user` WHERE `LoginID`='$LoginID'") or die(mysql_error());
		$usr=mysql_fetch_array($User);
?>

	<div class="container">
		<h1 class="text-primary">Assign Company to <strong><?php echo $usr['FullName']?></strong></h1>
		<form action="AddMapUser.php">
			<input type="hidden" name="UserTableID" value="<?php echo $usr[0]?>" />
			<input type="hidden" name="UserLoginID" value="<?php echo $usr[3]?>" />
		<table  class="table table-striped table-hover">
			<thead>
			<tr style="font-weight: bold;">
				<td></td>
				<td>SN</td>
				<td>ERP Code</td>
				<td>Company Name</td>
				<td>City</td>
				<td>State</td>
			</tr>
			</thead>
			<?php
				$i=1;
				$Company=mysql_query("SELECT `id`, `ERPCode`, `Name`, `City`, `State` FROM `company` ORDER BY `Name`") or die(mysql_error());
				while($Comp=mysql_fetch_array($Company)){
			?>
			<tr>
				<td><input type="checkbox" name="CompanyTableID<?php echo $i?>" value="<?php echo $Comp[0]?>" /></td>
				<input type="hidden" name="CompanyERPCode<?php echo $i?>" value="<?php echo $Comp[1]?>" />
				<td><?php echo $i?></td>
				<td><?php echo $Comp[1]?></td>
				<td><?php echo $Comp[2]?></td>
				<td><?php echo $Comp[3]?></td>
				<td><?php echo $Comp[4]?></td>
			</tr>
			<?php
					$i += 1;
				}				
			?>
			<input type="hidden" name="count" value="<?php echo $i?>" />
			<tr>
				<td colspan="6" align="center">
					<input type="submit" value="Assign" class="btn btn-primary" />
				</td>
			</tr>
		</table>
		</form>
	</div>
<?php
	}
	require_once("../footer.php");
?>