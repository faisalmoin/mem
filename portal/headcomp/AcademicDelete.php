<?php 

require_once("SetupLeft.php");

$Acad = odbc_exec($conn, "Delete FROM [Academic Year] WHERE [ID]='{$_REQUEST['ID']}'") or exit(odbc_errormsg($conn));


echo '<META http-equiv="refresh" content="0;URL=AcademicYearList.php"> ';

require_once("SetupRight.php");
?>

