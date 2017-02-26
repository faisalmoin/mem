<?php
	require_once("header.php");
	//$pay_dt = strtotime(str_replace("/", " ", $_REQUEST['PaymentDt']));
	//echo "<br /><br /><br />";
	for($i=0; $i<$_REQUEST['count']; $i++){
		if($_REQUEST['PaymentDt'.$i]){
			$sql_update = "UPDATE [Ledger Debit] SET 
					[Realization Date] = '".strtotime(str_replace("/", " ", $_REQUEST['PaymentDt'.$i]))."',
					[Payment Realization]=1
					where [ID]='".$_REQUEST['id'.$i]."' ";
			odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
			//echo $sql_update. "<br />";
			
		
		}
	}
	if($sql_update){
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    window.history.go(-2);
    </SCRIPT>");
	}
	//echo '<META http-equiv="refresh" content="0;URL=Pipeline.php"> ';
	
	require_once("../footer.php");
?>