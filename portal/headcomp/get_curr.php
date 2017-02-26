<?php
include('../db.txt');
echo "SELECT DISTINCT([Curriculum]) FROM [class section] WHERE [Academic Year]='$id' AND [Company Name]='".$_REQUEST[$comp]."' <br />";
if($_POST['id'])
{
    $id=$_POST['id'];
	$comp = $_POST['comp'];
    $stmt = odbc_exec($conn, "SELECT DISTINCT([Curriculum]) FROM [class section] WHERE [Academic Year]='$id' AND [Company Name]='$comp'");
    ?><option selected="selected" value="">Select :</option><?php
    while(odbc_fetch_array($stmt))
    {
	//	echo odbc_result($stmt, "Curriculum")."<br />";
        ?>
        <option value="<?php echo odbc_result($stmt, "Curriculum")?>"><?php echo odbc_result($stmt, "Curriculum"); ?></option>
    <?php
	
    }
}
else{
	echo "Error";
}
?>