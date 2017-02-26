<?php
	require_once("header.php");
echo "<br /><br /><br /><br />";
	
	$Stud = odbc_exec($conn, "SELECT TOP 1 [No_],[Class] FROM [Temp Student] WHERE [Company Name]='6' AND [Student Status]=1 AND [EWS]=0");
	echo "Student : ".odbc_result($Stud, "No_");
	
	 $sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND ([Class]='".odbc_result($Stud, "Class")."' OR [Class]='') AND [Group Code]='INV' ";
	// echo $sql;
	 $rs22 = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
	 $i=0;
	 while(odbc_fetch_array($rs22)){
     echo "Student : ".odbc_result($rs22, "Description");
     $i++;
     } 
	require_once("../footer.php");
?>