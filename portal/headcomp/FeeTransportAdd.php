<?php
	require_once("SetupLeft.php");

	$count = $_REQUEST['count'];
	
	for($i=0; $i<=$_REQUEST['count']; $i++){
		if($_REQUEST['SlabCode'][$i] != "" && $_REQUEST['SlabAmount'][$i] != "" ){
			/*if($_REQUEST['SlabDistance'][$i] == 1){$sDist = 0; $eDist = 1;}
			if($_REQUEST['SlabDistance'][$i] == 2){$sDist = 1; $eDist = 2;}
			if($_REQUEST['SlabDistance'][$i] == 3){$sDist = 2; $eDist = 3;}
			if($_REQUEST['SlabDistance'][$i] == 4){$sDist = 3; $eDist = 4;}
			if($_REQUEST['SlabDistance'][$i] == 5){$sDist = 4; $eDist = 5;}
			if($_REQUEST['SlabDistance'][$i] == 6){$sDist = 5; $eDist = 6;}
			if($_REQUEST['SlabDistance'][$i] == 7){$sDist = 6; $eDist = 7;}
			if($_REQUEST['SlabDistance'][$i] == 8){$sDist = 7; $eDist = 8;} */
			
			$sql = "INSERT INTO [Transport Slab] ([Slab Code], [Route No_],[Slab Name],[Slab Start Distance in KM],
				[Slab End Distance in KM],[Amount],[No_ of months],[Total Amount],[Group Code], [User ID], [Portal ID],[Effective Date],[Distance covered],[Synchronization],
				[Company Name],[InsertStatus],[UpdateStatus],[Monthly Amount]) 
				VALUES('".strtoupper($_REQUEST['SlabCode'][$i])."', '".strtoupper($_REQUEST['SlabRoute'][$i])."',  '".ucwords(strtolower($_REQUEST['SlabName'][$i]))."', 0,
				0, '".$_REQUEST['SlabAmount'][$i]."', '".$_REQUEST['Months'][$i]."', '".$_REQUEST['TotAmt'][$i]."', 'INV', '$LoginID', '$LoginID', '".date('d/M/Y')."', '".$_REQUEST['SlabDistance'][$i]."', 0,
				'$CompName', 1,0,'".$_REQUEST['MnthAmt'][$i]."')";
			
                  echo $sql."<br><br>";
			
			$result = odbc_exec($conn, $sql);
			if(!$result){
				exit("Unable to insert data in Transport Slab Table ...");
			}
		}
	}
	
?>
<meta http-equiv='refresh' content="0;URL='FeeTransportList.php'" />
<?php require_once("SetupRight.php"); ?>