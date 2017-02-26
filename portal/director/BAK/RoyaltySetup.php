<?php
	require_once("header.php");
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
						<?php require_once("menu.php")?>
				</td></tr>
				<tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
					<form method="post" action="RoyaltySetup02.php">
					<!-- Workspace Starts here -->
					<!-- Royalti Setup -->
						<div class="container">
							<div class="jumbotron">
								<h3>School Name: </h3>
								
								<select name="CompName" class="form-control" style="width: 380px;padding: 8px;" required>
									<option value=""></option>
									<?php
										$cmp = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] ORDER BY [Name]") or die(odbc_errormsg($conn));
										while(odbc_fetch_array($cmp)){
											echo '<option value="'.odbc_result($cmp, "ID").'">'.odbc_result($cmp, "Name").'</option>';
										}
									?>
								</select>
								<br />
								<button class="btn btn-primary">Next</button>
							</div>
						</div>
						
					</form>
					<!-- Workspace ends here -->
				</td>
			</tr>
		</table>