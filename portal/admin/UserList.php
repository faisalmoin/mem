<?php
    require_once("SetupLeft.php");
    $result = odbc_exec($conn, "SELECT * FROM [user]") or die(odbc_errormsg($conn));
?>
<h1 class="text-primary">User List</h1>
	<div class="table-responsive">
		<a href="NewUser.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="50px" alt="Create New"></a>
		<table class="table table-responsive">
			<thead>
			<tr style="font-weight: bold;">
				<td>SN</td>
				<td>Name</td>
				<td>Contact No.</td>
				<td>Email</td>
				<td>UserType</td>
				<td>Status</td>
				<td>Online Status</td>
			</tr>
			</thead>
		<tbody>
		<?php
			$i=1;
			while(odbc_fetch_array($result)){
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><a href="UserEdit.php?id=<?php echo odbc_result($result, "id");?>"><?php echo odbc_result($result, "FullName");?></a></td>
			<td><?php echo odbc_result($result, "ContactNo");?></td>
			<td><?php echo odbc_result($result, "Email");?></td>
			<td><?php echo odbc_result($result, "UserType")?></td>
			<td><?php echo odbc_result($result, "UserStatus"); ?></td>
			<td><?php
				$Online = odbc_exec($conn, "select [ActiveStat] FROM [login] 
						WHERE [Login] IN (SELECT [LoginID] FROM [user] WHERE ID=".odbc_result($result, "id").") AND
						[LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login] IN 
						(SELECT [LoginID] FROM [user] WHERE ID=".odbc_result($result, "id").")
						)") or exit(odbc_errormsg($conn));
				if(odbc_result($Online, "ActiveStat")==1){
					echo "<div style='width: 14px;height: 14px;background: rgb(0,255,0);-moz-border-radius: 70px;-webkit-border-radius: 70px;border-radius: 70px;'> </div>";
				}
				if(odbc_result($Online, "ActiveStat")==0){
					echo	"<div style='width: 14px;height: 14px;background: rgb(128,128,128);-moz-border-radius: 70px;-webkit-border-radius: 70px;border-radius: 70px;'></div>";
				}
				?></td>
		</tr>
		<?php	
				$i++;
			}
		?>
		</tbody>
		</table>
	</div>

<?php require_once("SetupRight.php"); ?>

