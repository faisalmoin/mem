<?php

	require_once("header.php");
	echo "<br /><br /><br /><br />";
	$dt = explode("/", $_REQUEST['MOUDt']);
	$MOUDt = strtotime($dt[0]." ".$dt[1]." ".$dt[2]." ".date('H:s:i'));
	
	$frm = explode("/", $_REQUEST['FromDt']);
	$FromDt = strtotime($frm[0]." ".$frm[1]." ".$frm[2]." ".date('H:s:i'));
	
	
	$dur = $_REQUEST['Duration'];
	$days = 0;
	for($d = ($frm[2]+1); $d<($frm[2]+$dur); $d++){
		
		if(($d) % 4 == 0){
			$days = $days + 1;
		}
	}
	
	$days = 365  * $dur + $days;	
	$ToDt = $frm[0]."/".$frm[1]."/".($frm[2]+$dur);
		
	//MOU_ID
	$ag = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [CRM Agreement]") or die($odbc_errormsg($conn));	
	$AgrNo = "AG".str_pad(odbc_result($ag, "") , 6, 0, STR_PAD_LEFT)."";	
	
	//GET Fiiles
	$files = odbc_exec($conn, "SELECT [MOU File], [LOI File], [User ID], [Assign To] FROM [CRM Oppurtunity] WHERE [Opp No]='".$_REQUEST['OppNo']."' ");
	$MOUFile = "../".odbc_result($files, "MOU File");
	$LOIFile = "../".odbc_result($files, "LOI File");
	
	$SQL = "INSERT INTO [CRM Agreement]
           ([Opp No]
           ,[Trust Name]
           ,[Name]
           ,[City]
           ,[State]
           ,[Duration]
           ,[From Date]
           ,[To Date]
           ,[Brand]
           ,[Franchisee Fee]
           ,[Royaly %]
           ,[No]
           ,[LOI File]
           ,[MOU File]
           ,[ST]
           ,[Created By]
           ,[Assign To]
           ,[R_Tax]
           ,[Sign Date])
     VALUES 
           ('".$_REQUEST['OppNo']."'
           ,'".$_REQUEST['Trust']."'
           ,'".$_REQUEST['Client']."'
           ,'".$_REQUEST['City']."'
           ,'".$_REQUEST['State']."'
           ,'".$days."'
           ,'$FromDt'
           ,'$ToDt'
           ,'".$_REQUEST['Brand']."'
           ,'".$_REQUEST['Fee']."'
           ,'".$_REQUEST['Royalty']."'
           ,'$AgrNo'
           ,'$LOIFile'
           ,'$MOUFile'
           ,'".$_REQUEST['taxes']."'
           ,'".odbc_result($files, "User ID")."'
           ,'".odbc_result($files, "Assign To")."'
           ,'".$_REQUEST['r_taxes']."'
           ,'$MOUDt') 
   ";
	
	$result = odbc_exec($conn, $SQL);
	
	if($result){
		$subject = "MEMPL ERP: Agreement signup - ".$_REQUEST['Client'];
		$body ='
		<style>
			td{
				padding: 10px;
			}
			body, table{
				font-family: arial, times ;
			}
		</style>
		<table style="width:60%; " align="center">
			<tr>
				<td colspan="4"><h1>Agreement New <hr  style="border-bottom:1px solid #abb2b9; " /></td>
			</tr>
			<tr>
				<td>Oppurtunity No</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST["OppNo"].'</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>MOU signing Date</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['MOUDt'].'</td>
				<td>Brand</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['Brand'].'</td>
			</tr>
			<tr>
				<td>Trust</td>
				<td colspan="3" style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['Trust'].'</td>
			</tr>
			<tr>
				<td>Client Name</td>
				<td colspan="3" style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['Client'].'</td>
			</tr>
			<tr>
				<td>City</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['City'].'</td>
				<td>State</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['State'].'</td>
			</tr>
			<tr>
				<td>From Date</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['FromDt'].'</td>
				<td>To Date</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$ToDt.'</td>			
			</tr>
			<tr>
				<td>Franchisee Fee</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['Fee'].'</td>
				<td>Royalty %</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">'.$_REQUEST['Royalty'].'</td>
			</tr>
			<tr>
				<td>Taxes</td>
				<td style="font-weight: bold; font-size: 16px; color: #1a5276">';
					if($_REQUEST['taxes']=="1") $body .= 'Exclusive';
					if($_REQUEST['taxes']=="-1") $body .= 'Inclusive';
				
		$body .= '</td>
				<td colspan="2">Attachment</td>
				<td>';
		$body .= '<a href="http://202.54.232.178/portal/'.odbc_result($files, "MOU File").'" target="_BLANK">MOU</a>';
		$body .= '</td>
			</tr>
			</table>';
		
		require_once "../bs/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "125.16.64.67";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "erpadministrator@mempl.com";  // SMTP username
		$mail->Password = "access@1234"; // SMTP password
		$mail->SMTPDebug = 1;
		
		$mail->From = "erpadministrator@mempl.com";
		$mail->FromName = "MEM ERP";
		
		//Get user Name
		$dr = odbc_exec($conn, "SELECT [FullName], [Email] FROM [user] WHERE [UserType]='Director' AND [UserStatus]='Active' ");
		while(odbc_fetch_array($dr)){
			$mail->AddAddress(odbc_result($dr, "Email"), odbc_result($dr, "FullName"));
		}
		//CC & BCC Email
		echo "SELECT [FullName], [Email] FROM [user] WHERE [UserType]='Sales' AND [UserStatus]='Active' AND [LoginID]='$LoginID' ";
		$cc_adr = odbc_exec($conn, "SELECT [FullName], [Email] FROM [user] WHERE [UserType]='Sales' AND [UserStatus]='Active' AND [LoginID]='$LoginID' ");
		$mail->addCC(odbc_result($cc_adr, "Email"), odbc_result($cc_adr, "FullName"));
		$mail->addBCC("erpadministrator@mempl.com", "MEM ERP");
		$mail->AddReplyTo("erpadministrator@mempl.com", "MEM ERP");

		$mail->AddAttachment($MOUFiile);         // add attachments
		//$mail->AddAttachment($LOIFile);    // optional name
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $body;
		$mail->Body;
			
		if(!$mail->Send())
		{
		   echo "<p>Message could not be sent.";
		   echo "Mailer Error: " . $mail->ErrorInfo."</p>";
		}
		else{
			echo "<p>Message has been sent</p>";		
		}
		
		//Page redirect
		echo '<script>alert("Agreement details has been successfully inserted ..."); window.location = "Agr-List.php";</script>';
	}
	else{
		echo '<div class="container"><div class="container-fluid"><div class="alert alert-danger">
					<!--a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a -->
					<a href="Agr-New.php" class="text-danger"><strong>Error!</strong> Unable to INSERT record of <b>'.$_REQUEST['Client'].'</b><p>'.$SQL.'</p> <br />'.odbc_errormsg($conn).' ...</a>
				</div></div></div>';
	}
	
	require_once("../footer.php");
?>