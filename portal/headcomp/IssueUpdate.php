<?php
    require_once("header.php");

    $id=$_REQUEST['id'];
    $ResponsiblePerson = $_REQUEST['ResponsiblePerson'];
    $CallType = $_REQUEST['CallType'];
    $CallStatus = $_REQUEST['CallStatus'];
    $CloseDate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_REQUEST['CloseDate'])));
    $ActionTaken = $_REQUEST['ActionTaken'];
    $Remarks = $_REQUEST['Remarks'];

    $sql = "UPDATE `complaint` SET `ResponsiblePerson`='$ResponsiblePerson', `CallType`='$CallType', `CallStatus`='$CallStatus', `CloseDate`='$CloseDate', `ActionTaken`='$ActionTaken', `Remarks`='$Remarks' WHERE `id`='$id'";

    $result = mysql_query($sql) or die(mysql_error());

    //Email Address & Complaint ID
    $EmailTo = mysql_query("SELECT * FROM `complaint` WHERE `id`='$id'") or die(mysql_error());
    $eTo = mysql_fetch_array($EmailTo);
    $EmailFrom = mysql_query("SELECT `Email`, `FullName` FROM `user` WHERE `LoginID`='$ResponsiblePerson' ") or die(mysql_error());
    $eFrom=mysql_fetch_array($EmailFrom);

    $to = $eTo['EmailAddress'].", schoolerp@educompschools.com, $eFrom[0]";
    $from = $eFrom[0];
    $subject = "SchoolERP // Complaint Update // Complaint ID: ".$eTo['ComplaintID'];

    $body = "<html><head></head><body style='font-family: arial, sans-serif; font-size: 13px'><p align='justify'>Dear ".$eTo['LoggedBy'].",</p><br />
                <p align='justify'>This is with reference to complaint no - <b>".$eTo['ComplaintID']."</b>. This is to inform yu that, your call has been attended by $eFrom[1] and call status is <b>$CallStatus</b>. Summary of the call is as follows:</p>
                <p align='justify'>
                    <table width='100%' border='1'>
                        <tr>
                            <td>Call Date:</td><td>".date('m/D/Y', strtotime($eTo['CallDate']))."</td>
                            <td>Category:</td><td>".$eTo['Category']."</td>
                            <td>Module:</td><td>".$eTo['Module']."</td>
                            <td>Sub-Module:</td><td>".$eTo['SubModule']."</td>
                        </tr>
                        <tr>
                            <td>Description:</td><td colspan='7'>".$eTo['Description']."</td>
                        </tr>
                        <tr>
                            <td>Snapshot: </td><td colspan='7'><img src='data:image/jpeg;base64,".$eTo['Picture']."' width='500px' /></td>
                        </tr>
                        <tr>
                            <td>Responsible Person:</td><td>".$eFrom[1]."</td>
                            <td>Call Type:</td><td>".$eTo['CallType']."</td>
                            <td>Attend Date:</td><td>".date('m/D/Y', strtotime($eTo['CloseDate']))."</td>
                            <td>Call Status:</td><td>".$eTo['CallStatus']."</td>
                        </tr>
                        <tr>
                            <td>Action Taken: </td><td colspan='7'>".$eTo['ActionTaken']."</td>
                        </tr>
                        <tr>
                            <td>Remarks: </td><td colspan='7'>".$eTo['Remarks']."</td>
                        </tr>
                    </table>
                </p>
                <br />
                <p align='justify'>
                Thanks & Regards, <br />
                Support Team<br />
                ESIML, Gurgaon
                </p>
            </body></html>";

    require_once("../smtp.php");
    //echo $body;
    if($result){
        echo "<html><head><meta http-equiv='refresh' content='0;URL=ListComplaint.php?q=1'></head></html>";
    }
    else{
        echo "<html><head><meta http-equiv='refresh' content='0;URL=ListComplaint.php?q=0'></head></html>";
    }

    require_once("../footer.php");
?>