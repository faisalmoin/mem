<?php
    require_once("header.php");
    echo "<br /><br />";
    if($_REQUEST['Category'] != ""){

        $CheckCat = mysql_query("SELECT `Module` FROM `complaint_module` WHERE `Module`='".strtoupper(addslashes($_REQUEST['Category']))."'") or die(mysql_error());

        if(mysql_num_rows($CheckCat) < 1){
            mysql_query("INSERT INTO `complaint_module` SET `Module`='".addslashes(strtoupper($_REQUEST['Category']))."'") or die(mysql_error());
            $msg = "<div class='bs-example'><div class='alert alert-success alert-success' style='background-color: #990000;color: #ffffff;'><strong>".strtoupper(addslashes($_REQUEST['Category']))." has been registered ... </strong></div></div>";
        }
        else{
            $msg = "<div class='bs-example'><div class='alert alert-danger alert-error' style='background-color: #990000;color: #ffffff;'><strong>".strtoupper(addslashes($_REQUEST['Category']))." already registered ... </strong></div></div>";
        }
    }
    else{
        echo "<div class='container'><div class='bs-example'><div class='alert alert-danger alert-error' style='background-color: #990000;color: #ffffff;'><strong>There is some issues, kindly check ... </strong></div></div></div>";
    }
?>
<div class="container">
<div class="container">
    <form class="form">
    <div class="table">
        <table class="table-responsive table-hover">
            <tr>
                <td><label>New Category</label></td>
                <td><input type="text" name="Category" class="form-control" required /></td>
                <td><input type="submit" value="Submit" class="form-control btn btn-primary" /></td>
            </tr>
        </table>
    </div>
    </form>
    <?php echo $msg; ?>
</div>
<hr />
<div class="container">
    <div class="table">
        <table class="table-responsive table">
            <thead>
            <tr><td>SN</td><td>Category</td></tr>
            </thead>
            <tbody>
            <?php
                $i=1;
                $result = mysql_query("SELECT `Module` FROM `complaint_module` ORDER BY `Module`") or die(mysql_error());
                while($row=mysql_fetch_array($result)){
                    echo "<tr><td>$i</td><td>$row[0]</td></tr>";
                    $i += 1;
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php require_once("../footer.php") ?>