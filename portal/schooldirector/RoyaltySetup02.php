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
					<form method="post" action="RoyaltySetup03.php">
					<!-- Workspace Starts here -->
					<!-- Royalti Setup -->
						<div class="container">
							<div class="jumbotron">
								<?php
									$CompName = $_REQUEST['CompName'];
									
									$Comp = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$CompName'") or die(odbc_errormsg($conn));
									echo "<h3>".odbc_result($Comp, "Name")."</h3>";
								?>
							</div>
						
						<?php
							$FeeComp = odbc_exec($conn, "select [Description] from [Fee Components] WHERE [Company Name]='".$CompName."' ORDER BY [Description]") or die(odbc_errormsg($conn));
						?>
						<table class="table table-responsive table-stripped">
							<tr>
								<th>SN</th>
								<th>Fee Component</th>
								<th></th>
							</tr>
							<?php
								$j=1;
								while(odbc_fetch_array($FeeComp)){
							?>
							<tr>
								<td style="border: none;"><?php echo $j; ?></td>
								<td style="border: none;">
									<?php echo odbc_result($FeeComp, "Description"); ?>
									<input type="hidden" name="FeeDescription<?php echo $j?>" value="<?php echo odbc_result($FeeComp, "Description"); ?>" />
								</td>
								<td style="border: none;" align="right">
									<input type="checkbox" name="select<?php echo $j;?>" value="1"
									<?php
										$Check = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$CompName' AND [Fee Description]='".odbc_result($FeeComp, "Description")."' ") or die(odbc_errormsg($conn));
										if(odbc_num_rows($Check) == 1) echo " checked";
									?>
									>
								</td>
							</tr>
							<?php
									$j++;
								}
							?>
							<tr>
								<td colspan="3" align="right" style="border: none;" >
									<input type="hidden" name="count" value="<?php echo $j;?>">
									<input type="hidden" name="CompName" value="<?php echo $CompName;?>">
									<input type="submit" value="Submit" class="btn btn-primary">
								</td>
							</tr>
						</table>
						</div>
					</form>
					<!-- Workspace ends here -->
				</td>
			</tr>
		</table>