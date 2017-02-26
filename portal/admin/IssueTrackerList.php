<?php
    //require_once("header.php");
?>
<div class="container">
    <div class="table-responsive">
        <table class="table table-responsive">
            <thead>
            <tr>
                <td>SN</td>
                <td>Call Date</td>
                <td>Category</td>
                <td>Module</td>
                <td>Description</td>
                <td>Call Status</td>
                <td>Attend Date</td>
                <td align="center">NOD</td>
                <td align="center"></td>
            </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                $result = mysql_query("SELECT * FROM `complaint` WHERE `CallStatus`='Open' ORDER BY `CallDate` DESC") or die(mysql_error());
                while($row=mysql_fetch_array($result)){
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo date('d/M/Y', strtotime($row['CallDate']));?></td>
                <td><?php echo $row['Category'];?></td>
                <td><?php echo $row['Module'];?></td>
                <td><?php echo substr($row['Description'], 0, 100);?> ... </td>
                <td><?php echo $row['CallStatus'];?></td>
                <td><?php echo (($row['CloseDate']!="0000-00-00 00:00:00")?date('d/M/Y', strtotime($row['CloseDate'])):"-");?></td>
                <td align="center"><?php
                    $now = time();
                    if($row['CloseDate'] == "0000-00-00 00:00:00"){
                        echo floor(($now - strtotime($row['CallDate']))/(60*60*24));
                    }
                    else{
                        echo floor((strtotime($row['CloseDate']) - strtotime($row['CallDate']))/(60*60*24));
                    }?></td>
                <td align="right">
                    <a href="Issue.php?id=<?php echo $row['id']?>#myModal<?=$i?>" class="text-primary" data-toggle="modal">View</a>
                    <?php require("ModalIssue.php"); ?>
                    <a href="IssueEdit.php?id=<?php echo $row['id']?>" class="text-primary" data-toggle="modal">Edit</a>
                </td>
            </tr>
            <?php
                    $i += 1;
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php //require_once("../footer.php");?>