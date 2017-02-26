<?php
	
	$myServer = "10.0.0.37";
	$myUser = "pallab.db";
	$myPass = "access@1234";
	$myDB = "schoolerp_test";

	$conn = odbc_connect("Driver={SQL Server};Server=$myServer;Database=$myDB;", $myUser, $myPass);
	
	if(!$conn){
		echo "<p style='color: #990000;'>Connection to DB via ODBC failed ... <br />";
		echo odbc_error($conn)."<br />-------------<br />".odbc_errormsg($conn );
		echo "</p>\n";
		exit();
	}
	else{

        //$ms = "Training Company-TMS\$";

        //echo "<br /><br /><br /><br />Success";
	}
?>