<?php require_once("SetupLeft.php");
$Company = odbc_exec($conn, "SELECT * FROM [RegFormToDate] WHERE [Company Name]= '$CompName' ") or exit(odbc_errormsg($conn));
while(odbc_fetch_array($Company))	
?>
<h1 class="text-primary">Registration From </h1>

<table class="table table-responsive">
     <tr>
	    <td colspan="2" style="color:#7B2000;">Copy The Link to Your Website To Open in the Form</td>
	</tr>
	<tr>
	   <th>Form Url</th>
	   <td><a href="../Company.php?cid=<?php echo odbc_result($Company, "Company Name")?>&sec=<?php echo odbc_result($Company, "Security")?>"target="Starfall"><?php echo odbc_result($Company, "Url")."&sec=". odbc_result($Company, "Security");?></a></td>
	</tr>
	<tr>
	    <th>URL Status</th>
	    <td>
	      <?php if(odbc_result($Company, "Status") == 1) echo "Active";?>
	       <?php if(odbc_result($Company, "Status") == "") echo "Inactive";?>
	    </td>
	</tr>
		
	<tr>
		<th>Url Validity</th>
		<td><?php echo date('d/M/Y', odbc_result($Company, "Start Date"));?> To <?php echo date('d/M/Y', odbc_result($Company, "End Date"));?></td>
	</tr>
	<tr>
		<td><a href="FormDateEdit.php?dateid=<?php echo odbc_result($Company, "ID")?>">Edit Validity Date</a></td>
	</tr>
	
</table>
<?php require_once("SetupRight.php");?>