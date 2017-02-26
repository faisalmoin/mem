<?php
    require_once("header.php");

    echo "<br /><br /><br />";

    if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $fp = fopen($tmpName, 'r');
        $data = fread($fp, filesize($tmpName));
        $data = addslashes(base64_encode($data));
        fclose($fp);

        $countID=mysql_query("SELECT COUNT(`id`)+1 FROM `complaint`") or die(mysql_error());
        $cID=mysql_fetch_array($countID);

        $Email=mysql_query("SELECT `Email` FROM `user` WHERE `LoginID`='$LoginID'") or die(mysql_error());
        $eml = mysql_fetch_array($Email);

        $ComplaintID=strtoupper(substr($_REQUEST['Category'],0,3).date('ym').str_pad($cID[0],8,"0", STR_PAD_LEFT));

        $CallDate = date('Y-m-d H:s:i',strtotime(str_replace('/', '-', $_REQUEST['CallDate'])));
        $Category = $_REQUEST['Category'];
        $Module = $_REQUEST['Module'];
        $SubModule = $_REQUEST['SubModule'];
        $Description = $_REQUEST['Description'];

        $query = "INSERT INTO `complaint` SET ";
        $query .= "`Picture` = '$data', ";
        $query .= "`CallDate` = '$CallDate', ";
        $query .= "`Category` = '$Category', ";
        $query .= "`Module` = '$Module', ";
        $query .= "`SubModule` = '$SubModule', ";
        $query .= "`Description` = '$Description', ";
        $query .= "`LoggedBy` = '$LoginID', ";
        $query .= "`EmailAddress` = '$eml[0]', ";
        $query .= "`CallStatus` = 'Open', ";
        $query .= "`ComplaintID` = '$ComplaintID'";

        $results = mysql_query($query) or die(mysql_error());

        //Email
        $to = "schoolerp@educompschools.com, $eml[0]";
        $from = $eml[0];

        $subject = "School ERP // New Complaint // Complaint ID: $ComplaintID";

        $body="<html><body style='font-family: Arial, Helvetica, Sans-Serif; font-size: 13px'>
                <p align='justify'>Dear concern,</p>
                <br />
                <p align='justify'>We have noted a new complaint as per the details mentioned hereunder. Request to resolved at the earliest.</p>
                <br />
                <table width='100%'>
                    <tr><td>Complaint ID</td><td>$ComplaintID</td></tr>
                    <tr><td>CallDate</td><td>$CallDate</td></tr>
                    <tr><td>Category</td><td>$Category</td><td>Module</td><td>$Module</td><td>SubModule</td><td>$SubModule</td></tr>
                    <tr><td>Description</td><td colspa='5'>$Description</td></tr>
                    <tr><td>Snapshot</td><td colspan='5'><img src='data:image/jpeg;base64,".$data."' width='500px' /></td></tr>
                </table>
                <br />
                <p align='justify'>
                    Thanks & Regards,<br />
                    $LoginID<br />
                    $Comp[14]
                </p>
                </body></html>";
        require_once("../smtp.php");
        if($results){
            echo "<html><head><meta http-equiv='refresh' content='0;URL=Issue.php?q=1'></head></html>";
        }
        else{
            echo "<html><head><meta http-equiv='refresh' content='0;URL=Issue.php?q=0'></head></html>";
        }

    } else {
        echo "<html><head><meta http-equiv='refresh' content='0;URL=Issue.php?q=2'></head></html>";

    }

    require_once("../footer.php");

?>