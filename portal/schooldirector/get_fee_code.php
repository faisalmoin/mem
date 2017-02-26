<?php
include('../db.txt');
if($_POST['sid'])
{ 
	$sid=$_POST['sid'];
	//echo "SID: $sid // CMP: ".$_REQUEST['cmp'];
	$j=1;
	$query = "SELECT [Academic Year], [Curriculum], [Class] FROM [Discount Fee Header] WHERE [No_]='".$_POST['sid']."' AND [Company Name]='".$_POST['cmp']."'";
	$rs = odbc_exec($conn, $query);
	
	$qry = "SELECT DISTINCT([Fee Code]) FROM [Class Fee Line] 
			WHERE 
			[Company Name]='".$_POST['cmp']."' AND 
			[Academic Year]='".odbc_result($rs, "Academic Year")."' AND 
			[Class]='".odbc_result($rs, "Class")."' ";
	
	$fCode = odbc_exec($conn, $qry);
	echo "<table class='table table-responsive'><tr>
		<td>SN</td>
		<td>Fee Code</td>
		<td>Discount %</td>
		<td>Description</td>
	</tr>";
	while(odbc_fetch_array($fCode)){
	?>
	
	<tr>
		<td><?php echo $j?></td>
		<td><input type="hidden" name="FeeCode<?php echo $j?>" value="<?php echo odbc_result($fCode, "Fee Code")?>" ><?php echo odbc_result($fCode, "Fee Code")?></td>
		<td><input type='text' class="form-control" name="Discount<?php echo $j?>" maxlength="3" style="text-align: right; width: 100px;" class='form-class'></td>
		<td><input type='text' class="form-control" name="Description<?php echo $j?>" maxlength="30" ></td>
	</tr>
	<?php	
		$j++;
	}
	echo "</table>";
	echo "<input type='hidden' 
		value='".$j."' name='count' id='count' />
	<button type='submit' class='btn btn-success'>Submit</button>";
}
?>