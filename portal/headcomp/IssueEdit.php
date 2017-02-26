<?php
    require_once("header.php");
    $id = $_GET['id'];

    $result = mysql_query("SELECT * FROM `complaint` WHERE `id`='$id'") or die(mysql_error());
    $row = mysql_fetch_array($result);
?>
<div class="container">
    <div class="table-responsive">
        <form method="post" action="IssueUpdate.php">
        <table class="table table-stripped">
            <tr>
                <td colspan="6">Complaint ID: <b><?php echo $row['ComplaintID'];?></b></td>
            </tr>
            <tr>
                <td>Call Date</td><td><?php echo date('d/M/Y',strtotime($row['CallDate'])); ?></td>
                <td>Call Status</td><td style="font-weight: bold"><?php echo $row['CallStatus']; ?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Category</td><td><?php echo $row['Category']; ?></td>
                <td>Module</td><td><?php echo $row['Module']; ?></td>
                <td>Sub-Module</td><td><?php echo $row['SubModule']; ?></td>
            </tr>
            <tr>
                <td>Description</td><td colspan="5"><?php echo $row['Description']; ?></td>
            </tr>
            <tr>
                <td>Snapshot</td>
                <td colspan="5">
                    <?php
                    if($row['Picture'] != ""){
                        $im = $row['Picture'];
                        echo "<img src='data:image/jpeg;base64,$im' width='500px' />";
                        //echo $im;
                    }
                    else{
                        echo "Not Available ...";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Responsible Person</td><td colspan="2">
                    <select name="ResponsiblePerson" required class="form-control">
                        <option value=""></option>
                        <?php
                            $rPerson = mysql_query("SELECT `FullName`, `LoginID` FROM `user` ORDER BY `FullName`") or die(mysql_error());
                            while($rp = mysql_fetch_array($rPerson)){
                                echo "<option value='$rp[1]'>$rp[0]</option>";
                            }
                        ?>
                    </select>

                </td>
                <td>Call Type</td><td colspan="2">
                    <select name="CallType" required class="form-control">
                        <option value=""></option>
                        <option value="Training">Training</option>
                        <option value="Bug">Bug</option>
                        <option value="Other">Other</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Attend Date</td><td colspan="2"><input type="text" readonly="true" name="CloseDate" value="<?php echo date('d/M/Y')?>" class="form-control"></td>
                <td>Call Status</td><td colspan="2">
                    <select name="CallStatus" class="form-control" required>
                        <option value=""></option>
                        <option value="Open">Open</option>
                        <option value="Closed">Closed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Action Taken</td><td colspan="5"><textarea style="resize: none;" name="ActionTaken" class="form-control"></textarea></td>
            </tr>
            <tr>
                <td>Remarks</td><td colspan="5">
                    <input type="text" name="Remarks" class="form-control">
                </td>
            </tr>
            <tr>
                <td><input type="hidden" value="<?php echo $id?>" name="id"></td>
                <td colspan="6"><input type="submit" value="Update" class="btn btn-primary"></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<?php require_once("../footer.php") ?>