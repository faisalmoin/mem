<?php
    require_once("header.php");
    if($_REQUEST['Category'] != "" && $_REQUEST['Module'] != "" && $_REQUEST['SubModule'] != ""){
        $validate = mysql_query("SELECT * FROM `complaint_submodule` WHERE `Category` = '".addslashes(strtoupper($_REQUEST['Category']))."' AND `Module` = '".addslashes(strtoupper($_REQUEST['Module']))."' AND `SubModule` = '".addslashes(strtoupper($_REQUEST['SubModule']))."'") or die(mysql_error());
        if(mysql_num_rows($validate) <= 0){
            mysql_query("INSERT INTO `complaint_submodule` SET `Category` = '".addslashes(strtoupper($_REQUEST['Category']))."', `Module` = '".addslashes(strtoupper($_REQUEST['Module']))."', `SubModule` = '".addslashes(strtoupper($_REQUEST['SubModule']))."' ") or die(mysql_error());
            $msg = "<div class='bs-example'><div class='alert alert-success alert-success'><strong>".strtoupper(addslashes($_REQUEST['Category']))." has been registered ... </strong></div></div>";
        }
        else{
            $msg = "<div class='bs-example'><div class='alert alert-danger alert-error'><strong>".strtoupper(addslashes($_REQUEST['Category']))." already registered ... </strong></div></div>";
        }
    }
?>
<div class="container">
    <div class="table">
        <form class="form">
        <h1>Complaint Module</h1>
        <table class="table table-responsive">
            <tr>
                <td>Category</td>
                <td><select name="Category" class="form-control" required="true">
                        <option value=""></option>
                        <?php
                            $Cate = mysql_query("SELECT `Module` FROM `complaint_module` ORDER BY `Module`") or die(mysql_error());
                            while($cat = mysql_fetch_array($Cate)){
                                echo "<option value='$cat[0]'>$cat[0]</option>";
                            }
                        ?>
                    </select>
                </td>
                <td>Module</td>
                <td><input type="text" class="form-control" name="Module" required></td>
                <td>Sub-Module</td>
                <td><input type="text" class="form-control" name="SubModule" required></td>
                <td><input type="submit" value="Submit" class="form-control btn btn-primary" /></td>
            </tr>
        </table>
            <?php echo $msg; ?>
        </form>
    </div>
    <div class="table">
        <h3>Category</h3>
        <table class="table table-responsive">
            <tr>
                <td>SN</td>
                <td>Category</td>
                <td>Module</td>
                <td>Sub-Module</td>
            </tr>
            <?php
                $i=1;
                $result=mysql_query("SELECT * FROM `complaint_submodule` ORDER BY `Category`, `Module`, `SubModule`") or die(mysql_error());
                while($row=mysql_fetch_array($result)){
                    echo "<tr><td>$i</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>";
                    $i += 1;
                }
            ?>
        </table>
    </div>
</div>
<?php require_once("../footer.php") ?>