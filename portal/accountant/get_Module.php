<?php
include('../db.txt');
if($_POST['id'])
{
    $id=$_POST['id'];

    $stmt = mysql_query("SELECT DISTINCT(`SubModule`) FROM complaint_submodule WHERE Module='$id'");
    ?><option selected="selected" value="">Select Sub-Module :</option><?php
    while($row=mysql_fetch_array($stmt))
    {
        ?>
        <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
    <?php
    }
}
?>