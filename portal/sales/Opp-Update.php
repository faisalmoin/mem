<?php
	require_once("header.php");
	echo "<div class='container'>";
	$date = $_REQUEST['LeadDT'];
	if($_REQUEST['LeadDT'] != ""){
		$d = explode("/", $date);
		$dt1 = $d[0]." ".$d[1]." ".$d[2]." ".date("H:s:i");
		$dt = strtotime($dt1);
	}
	else{
		$dt = time();
	}
	
	//LOI Upload		
	if($_REQUEST['Stage'] === "Letter of Intent (LOI)" && $_REQUEST['Level'] === "Has signed LOI"){
	
		$file_name = $_FILES['LOI_signed']['name'];
		$file_tmp =$_FILES['LOI_signed']['tmp_name'];
		$file_size =$_FILES['LOI_signed']['size'];
		$newfile = "LOI".$_REQUEST['OppID'].$_FILES['LOI_signed']['name'];
		$data = "uploads/".$newfile;
		
			//if(move_uploaded_file($file_tmp,"uploads/".$file_name)){
			if(move_uploaded_file($file_tmp,"../uploads/".$newfile)){
				$files = ", [LOI file] ='".$data."' ";
			} else {
				echo "Error uploading LOI file ... ";
				exit();
			}
		
	}
	
	if($_REQUEST['Stage'] === "Agreement" && $_REQUEST['Level'] === "Agreement signed"){
	
		$file_name = $_FILES['MOU_signed']['name'];
		$file_tmp =$_FILES['MOU_signed']['tmp_name'];
		$file_size =$_FILES['MOU_signed']['size'];
		$newfile = "MOU".$_REQUEST['OppID'].$_FILES['MOU_signed']['name'];
		$data = "uploads/".$newfile;
		
			if(move_uploaded_file($file_tmp,"../uploads/".$newfile)){
				$files = ", [MOU file] ='".$data."' ";
			} else {
				echo "Error uploading MOU file ... ";
				exit();
			}
		
	}
	
	$sql = "UPDATE [CRM Oppurtunity] 
			SET 
				[Stage] = '".str_replace("'", "''",$_REQUEST['Stage'])."', 
				[Level]='".str_replace("'", "''",$_REQUEST['Level'])."'";
	$sql .= $files;
	$sql .= " WHERE [ID]='".$_REQUEST['id']."' ";
	
	$result = odbc_exec($conn, $sql)  or die(odbc_errormsg($conn));
	
	if($result){
		$act = odbc_exec($conn, "SELECT [Text] FROM [CRM Activity Master] WHERE [ID]='".$_REQUEST['Activity']."'") or die(odbc_errormsg($conn));
		odbc_exec($conn, "INSERT INTO [CRM Opp Activity] ([Opp ID], [Date], [Stage], [Level], [Start Time], [End Time], [Contact Person], [Contact No], 
						[Remarks], [Activity Status], [Post Date], [Assign To], [Activities], [Outcome]) 
		
					VALUES ('".$_REQUEST['OppID']."', '$dt', '".str_replace("'", "''",$_REQUEST['Stage'])."', '".str_replace("'", "''",$_REQUEST['Level'])."',
					'".$_REQUEST['StartTime']."', '".$_REQUEST['EndTime']."', '".$_REQUEST['ContactPerson']."', '".$_REQUEST['ContactNo']."', '".str_replace("'", "''",$_REQUEST['LeadRem'])."',
					 '".$_REQUEST['LeadStat']."',  '".strtotime(date('Y-m-d'))."', '$LoginID' ,  '".odbc_result($act, "Text")."', '".$_REQUEST['Outcome']."' ) ");
					 
		echo '<script>alert("Oppurtunity Status has been successfully updated ..."); window.location = "Opp-List.php";</script>';
	}
	else echo '<script>alert("Error encountered while creating Activity ..."); window.location = "Opp-Edit.php?id='.$_REQUEST['ID'].'";</script>';
	
	echo "</div>";
	require_once("../footer.php");
?>