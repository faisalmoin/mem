<?php
	require_once("SetupLeft.php");
?>
<table class="table table-responsive">
    <tr>
        <td colspan="5" style="border: none;" valign="top"><h1>Calendar <small>2016</small></h1></td>
        <td style="border: none; text-align: right;">
            <a href="CalendarNew.php" class="btn btn-success">Create New</a>
            <a href="CalendarView.php?mnth=<?php echo date("m")?>&yr=<?php echo date("Y")?>">View</a>
        </td>
    </tr>
    <tr style="background-color: #eee;">
            <th>SN</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Description</th>
            <th>Event Type</th>
            <th style="text-align: center;">No.  of Days</th>
    </tr>
    <?php
            $i = 1;

            $result= odbc_exec($conn, "SELECT * FROM [Calendar] WHERE [Company Name]='$CompName' ORDER BY [Start Date] ASC") or die(odbc_errormsg($conn));
            while(odbc_fetch_array($result)){
    ?>
    <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo date('d/M/Y', odbc_result($result, "Start Date")); ?></td>
    <td><?php echo date('d/M/Y', odbc_result($result, "End Date")); ?></td>
    <td><a href="CalendarEdit.php?id=<?php echo odbc_result($result, "ID");?>"><?php echo odbc_result($result, "Description"); ?></a></td>
    <td><?php 
        if(odbc_result($result, "Activity Type")==1) echo "Holiday"; 
        if(odbc_result($result, "Activity Type")==2) echo "Event"; 
        if(odbc_result($result, "Activity Type")==3) echo "Weekly off"; 
    ?></td>
    <td style="text-align: center;">
        <?php echo round(floor((odbc_result($result, "End Date"))-(odbc_result($result, "Start Date")))/(60*60*24)); ?>
    </td>
    </tr>
    <?php
                    $i++;
            }
    ?>

</table>
<?php
	require_once("SetupRight.php");
?>
