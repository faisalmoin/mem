<?php
include('../db.txt');
if($_POST['id'])
{
    $id=$_POST['id'];

    $stmt = mysql_query("SELECT DISTINCT(`Module`) FROM complaint_submodule WHERE `Category`='$id'");
    ?><option selected="selected" value="">Select Module :</option><?php
    while($row=mysql_fetch_array($stmt))
    {
        ?>
        <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
    <?php
    }
}
?>