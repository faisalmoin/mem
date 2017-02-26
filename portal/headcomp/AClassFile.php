<?php require_once('SetupLeft.php');?>
<h1 class="text-primary">Attendance upload</h1>
<form action="AClassFileAdd.php" enctype="multipart/form-data" method="POST">
<table class="table table-responsive">
   <tr style="color:#008B8B">
        <th>SN</th>
        <th>Class Code</th>
        <th>Class</th>
        <th>Academic Year</th>
	<th>Curriculum</th>
        <th>Upload File</th>
   </tr>
	<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [class section] WHERE [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
        ?>
   <tr>
	<td><?php echo $i?></td>
		
        <td><?php echo odbc_result($rs, "Class Code")?>
            <input type="hidden" name="Code<?php echo $i; ?>" value="<?php echo odbc_result($rs, "Class Code"); ?>">
        </td>
        <td><?php echo odbc_result($rs, "Class")?>
            <!--input type="hidden" name="Class<--?php echo $i; ?>" value="<--?php echo odbc_result($rs, "Class"); ?>"-->
        </td>
	<td><?php echo odbc_result($rs, "Academic Year")?>
            <!--input type="hidden" name="Academic<--?php echo $i; ?>" value="<--?php echo odbc_result($rs, "Academic Year"); ?>"-->
        </td>
	<td><?php echo odbc_result($rs, "Curriculum")?>
            <!--input type="hidden" name="Curriculum<--?php echo $i; ?>" value="<--?php echo odbc_result($rs, "Curriculum"); ?>"-->
        </td>
	<td><input type="file" name="fileUpload<?php echo $i; ?>" id="fileUpload">
            <small>File Size <= 300KB</small></td>
   </tr>
       
	<?php
			$i++;
		}
	?>
    <tr><td><button type="submit" class="btn btn-success">Submit</button></td></tr>
</table>
      <input type="hidden" value="<?php echo $i; ?>" name="fee_count">
</form>
<?php require_once('SetupRight.php'); ?>