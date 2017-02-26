<?php
    //require_once("header.php");
?>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#Category").change(function()
            {
                var id=$(this).val();
                var dataString = 'id='+ id;

                $.ajax
                ({
                    type: "POST",
                    url: "get_category.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#Module").html(html);
                    }
                });
            });


            $("#Module").change(function()
            {
                var id=$(this).val();
                var dataString = 'id='+ id;

                $.ajax
                ({
                    type: "POST",
                    url: "get_Module.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#SubModule").html(html);
                    }
                });
            });
        });
    </script>
<div class="container">
    <div class="table-responsive">
        <form role="form" enctype="multipart/form-data" action="IssueTrackerAdd.php" method="post">
            <table class="table table-stripped">
            <tr>
                <td>Log Date</td>
                <td>
                    <input type="text" readonly name="CallDate" value="<?php echo date('d/M/Y'); ?>" class="form-control" />
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="Category" class="form-control" id="Category" required>
                        <option value=""></option>
                        <?php
                            $Categ=mysql_query("SELECT `Module` FROM `complaint_module` ORDER BY `Module`") or die(mysql_error());
                            while($Cat=mysql_fetch_array($Categ)){
                                echo "<option value='$Cat[0]'>$Cat[0]</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Module</td>
                <td>
                    <select name="Module" class="form-control" id="Module" required>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Sub-Module</td>
                <td>
                    <select name="SubModule" class="form-control" id="SubModule" required>
                        <option value=""></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td>
                    <textarea class="form-control" name="Description" required style="resize: none;"></textarea>
                </td>
            </tr>
            <tr>
                <td>Snapshot</td>
                <td>
                    <input name="MAX_FILE_SIZE" value="999999" type="hidden">
                    <input name="image" accept="image/jpeg" type="file"> <small>File Type: JPG | File Size <= 300KB</small>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </td>
            </tr>
        </table>
        </form>
    </div>
</div>
<?php
    //require_once("../footer.php");
?>