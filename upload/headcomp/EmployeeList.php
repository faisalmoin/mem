<?php 
require_once("SetupLeft.php"); 

if(isset($_GET['delete_id']))
{
	$Acad = odbc_exec($conn, "Delete FROM [Employee] WHERE [ID]='{$_REQUEST['delete_id']}'") or exit(odbc_errormsg($conn));

	echo '<META http-equiv="refresh" content="0;URL=EmployeeList.php"> ';
}
?>
<script type="text/javascript">
function delete_id(ID)
{
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='EmployeeList.php?delete_id='+ID;
     }
}
</script>

<a href="EmployeeNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="50px" alt="Create New"></a>
<h1 class="text-primary">Employee List</h1>
<table class="table table-responsive">
	<tr>
            <td>SN</td>
            <td>Employee ID</td>
            <td>Name</td>
            <td>Department</td>
            <td>Job type</td>
            <td>Status</td>
            <td></td>
            <td></td>
        </tr>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Employee] WHERE [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><a href="EmployeeDetails.php?Id=<?php echo odbc_result($rs, "ID")?>"><?php echo odbc_result($rs, "No_")?></a></td>
		<td><?php echo odbc_result($rs, "First Name");?></td>
                <td><?php echo odbc_result($rs, "Department");?></td>
                <td><?php echo odbc_result($rs, "Job Title");?></td>
                <td><?php if(odbc_result($rs, "Status") == 1) { echo "Active"; }
                if(odbc_result($rs, "Status") == 0) { echo "InActive"; }?></td>
                <td><a href="EmployeeEdit.php?Id=<?php echo odbc_result($rs, "ID")?>"><img src="Edit.png" alt="Delete" style="width:17px;height:17px;" /></a></td>
		<td><a href="javascript:delete_id(<?php echo odbc_result($rs, "ID")?>)"><img src="wrong.jpeg" alt="Delete" style="width:20px;height:20px;" /></a></td>
		
	</tr>
	<?php
			$i++;
		}
	?>
</table>
<?php require_once("SetupRight.php"); ?>