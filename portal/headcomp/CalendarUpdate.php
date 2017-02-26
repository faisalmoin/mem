<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    require_once("SetupLeft.php");
    
    $s_dt = strtotime(str_replace("/", " ",$_REQUEST['s_date']." ".$_REQUEST['s_time']));
    $e_dt = strtotime(str_replace("/", " ",$_REQUEST['e_date']." ".$_REQUEST['e_time']));
    
    $result = odbc_exec($conn, "UPDATE [Calendar] SET [Description]='".$_REQUEST['Description']."', 
                                            [Start Date]='".$s_dt."',
                                            [End Date]='".$e_dt."',
                                            [Start Time]='".$_REQUEST['s_time']."',
                                            [End Time]='".$_REQUEST['e_time']."',
                                            [Activity Type]='".$_REQUEST['ActivityType']."' "
            . "WHERE [ID]='".$_REQUEST['id']."'") or die(odbc_errormsg($conn));
    if(!$result){
        echo '<div class="alert alert-danger">
                <strong>Error!</strong> Unable to update event - '.$_REQUEST['Description'].'.
            </div>';
    }
    else{
        echo "<script>window.location.href = 'CalendarList.php';</script>";
    }
    require_once("SetupRight.php");

?>