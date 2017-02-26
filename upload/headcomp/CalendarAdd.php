<?php
	require_once("SetupLeft.php");

	$Yr = $_REQUEST['year'];
	$count = $_REQUEST['count'];
	$err = 0;
	
	for ($i=0; $i<=($count-1); $i++){
		//if(($_REQUEST['date'][$i] != "") && ($_REQUEST['Description'][$i] != "")){
                    $s_dt = strtotime(str_replace("/", " ",$_REQUEST['s_date'][$i]." ".$_REQUEST['s_time'][$i]));
                    $e_dt = strtotime(str_replace("/", " ",$_REQUEST['e_date'][$i]." ".$_REQUEST['e_time'][$i]));
                    
                    $sql = "INSERT INTO [Calendar] VALUES ('".$_REQUEST['Description'][$i]."', '$CompName',  "
                            . "'".$_REQUEST['ActivityType'][$i]."', '$e_dt', '$s_dt', '".$_REQUEST['s_time'][$i]."', "
                            . "'".$_REQUEST['e_time'][$i]."', '$Yr')";
                    
                    $result = odbc_exec($conn, $sql);

                    if(!result){
                            exit("Error inserting value for '".$_REQUEST['date'][$i]."', '".$_REQUEST['Description'][$i]."', '".$_REQUEST['ActivityType'][$i]."'");
                    }
                //}

	}

	echo "<script>window.location.href = 'CalendarNew.php';</script>";
	require_once("SetupRight.php");	
?>
