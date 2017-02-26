<?php
	//require_once("header.php");
	require_once("../db.txt");
	?>
<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 13px;
					padding: 0px;
				}
				table td {
					width: 160px;
					height: 40px;
					border: 1px solid #d3d3d3;
					font-size: 13px;
				}
				
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
			
			<table width='100%'>
				<tr style='background-color: #0080cc'>
					<td style='padding: 15px;  border: none;'>
						<h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						Royalty Setup
						</h2>
					</td>
					<td style='padding: 15px; border: none; color: #ffffff;' valign='top'>
						<!--?php require_once("menu.php")?-->
				</td></tr>
				<tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
					<!-- Workspace Starts here -->
					<!-- Royalti Setup -->
					<div class="container">
					<?php
					//print_r($_POST);
						$count = $_REQUEST['count'];
						$CompName = $_REQUEST['CompName'];
						
						for($i =0; $i<=$count; $i++){
							//Check
							$check = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$CompName' AND [Fee Description]='".$_REQUEST['FeeDescription'.$i]."' ") or die(odbc_errormsg($conn));
							
							if(odbc_num_rows($check) == 0 && $_REQUEST['select'.$i]==1){
								//Insert
								//odbc_exec($conn, "INSERT INTO [Royalty Setup]([Company Name], [Fee Description]) VALUES ('$CompName', '".$_REQUEST['FeeDescription'.$i]."')") or die(odbc_errormsg($conn));
								odbc_exec($conn, "INSERT INTO [Royalty Setup]([Company Name], [Fee Description], [Fee Code], [Amount], [Class], [Academic Year]) VALUES ('$CompName', '".$_REQUEST['FeeDescription'.$i]."', '', 0, '', '')") or die(odbc_errormsg($conn));
								
							}
							else if(odbc_num_rows($check) == 1 && ($_REQUEST['select'.$i]=="" || $_REQUEST['select'.$i]==0)){
								//Delete
								odbc_exec($conn, "DELETE FROM [Royalty Setup] WHERE [Company Name]='$CompName' AND [Fee Description]='".$_REQUEST['FeeDescription'.$i]."'  ") or die(odbc_errormsg($conn));
							}
							
						}
					?>							
						</div>
						<META http-equiv="refresh" content="0;URL=RoyaltySetup.php?pg_id=1"> 
					<!-- Workspace ends here -->
				</td>
			</tr>
		</table>