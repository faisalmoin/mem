<?php
include('../db.txt');
if($_POST['sid'])
{
    $sid=$_POST['sid'];
	$comp = $_POST['comp'];
    $stmt = odbc_exec($conn, "SELECT DISTINCT([Class]) FROM [class section] WHERE [Curriculum]='$sid' AND [Company Name]='$comp' ");
    ?><option selected="selected" value="">Select Class :</option>
        <option selected="selected" value="AllClass">All Class</option>
        <?php
    while(odbc_fetch_array($stmt))
    {
        ?>
        <option value="<?php echo odbc_result($stmt, "Class"); ?>"><?php echo odbc_result($stmt, "Class"); ?></option>
    <?php
    }
}
?>