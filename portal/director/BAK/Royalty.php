<?php
	require_once("header.php");
	
	$today = strtotime(date('d M Y'));
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	}
	
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
		$Qtr = "Q1";
	}
	//Q2 Calculation
	if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
		$Qtr = "Q2";
	}
	//Q3 Calculation
	if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
		$Qtr = "Q3";
	}
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
		$Qtr = "Q4";
	}
	
?>
		<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
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
						Royalty
						</h2>
					</td>
					<td style='padding: 15px; border: none; color: #ffffff;' valign='top'>
						<?php require_once("menu.php")?>
				</td></tr>
				<tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
					<!-- Royalti Calculation -->
					<h3 class="text-primary">Financial Year: <?php echo $FinYr; ?></h3>	
					<?php
						$c=1;
						$td ="";
						$FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup]") or die(odbc_errormsg($conn));
						$colspan = odbc_num_rows($FeeHead);
						while(odbc_fetch_array($FeeHead)){
							$td .= "<th>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
						}
					?>
					<table class="table table-responsive " border="1" width="100%" id="abc">
						<thead>
						<tr style="background-color: #000000; color: #ffffff;" class="statetablerow">
							<th rowspan="2" style="text-align: center;">S.N</th>
							<th rowspan="2" style="text-align: center;" >Company Name</th>
							<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Generated</th>
							<th colspan="<?php echo $colspan; ?>" style="text-align: center;">Collected</th>
						</tr>
						<tr style="background-color: #000000; color: #ffffff;" class="statetablerow">
							<?php echo $td; ?>
							<?php echo $td; ?>
						</tr>
						</thead>
						<?php
							//Get Quarter
							
							$rs = odbc_exec($conn, "SELECT [Name], [ID] FROM [Company Information] WHERE [Company Status]=1") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($rs)){
						?>
						<tr  class="level<?php echo $c?>" style="background-color: #E6E6E6; font-weight: bold;">
							<td style="text-align: center"><?php echo $c; ?></td>
						
							<td><?php echo odbc_result($rs, "Name")?></td>
							<?php
								$FeeHead = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup]  ") or die(odbc_errormsg($conn));
								while(odbc_fetch_array($FeeHead)){
									$Check_Fee = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");
									
									echo "<td style='text-align: right;'>";
									if(odbc_num_rows($Check_Fee) != 0){
									
									$Inv = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] 
											WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee, "Fee Description")))." payable' 
											AND [Company Name]='".odbc_result($rs, "ID")."' AND [FinYr]='$FinYr' ");						
									
									echo number_format(odbc_result($Inv, ""), "2", ".", "");
									}
									else{echo "0.00"; }
									echo "</td>";
									
								} // Fee Head
								
								$FeeHead1 = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] ") or die(odbc_errormsg($conn));
								while(odbc_fetch_array($FeeHead1)){
									$Check_Fee1 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead1, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");
									
									echo "<td style='text-align: right;'>";
									if(odbc_num_rows($Check_Fee1) != 0){
									$Pay = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] 
											WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee1, "Fee Description")))." payable' 
											AND [Company Name]='".odbc_result($rs, "ID")."' AND [FinYr]='$FinYr' ");
									
									echo number_format(odbc_result($Pay, ""), "2", ".", ""); 
									}
									else{echo "0.00"; }
									echo "</td>";
								}
							?>							
						</tr>
						<!-- Quarter-wise -->
						<?php
							$qtrly = odbc_exec($conn, "SELECT DISTINCT([Qtr]) FROM [Ledger Credit] ORDER BY [Qtr]") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($qtrly)){
						?>
						<tr class="level<?php echo $c?>a">
							<td></td>
							<td style="text-align: center;font-weight: bold;"><?php echo odbc_result($qtrly, "Qtr"); ?></td>
							<?php
								
								$FeeHead2 = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup]  ") or die(odbc_errormsg($conn));
								while(odbc_fetch_array($FeeHead2)){
									$Check_Fee2 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead2, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");
									
									echo "<td style='text-align: right;'>";									
									if(odbc_num_rows($Check_Fee2) != 0){
									$Inv = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] 
											WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee2, "Fee Description")))." payable' 
											AND [Company Name]='".odbc_result($rs, "ID")."' AND [FinYr]='$FinYr' AND [Qtr]='".odbc_result($qtrly, "Qtr")."' ");						
									
									echo number_format(odbc_result($Inv, ""), "2", ".", "");
									}
									else{echo "0.00"; }
									
									echo "</td>";
									
								} // Fee Head
								
								$FeeHead3 = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] ") or die(odbc_errormsg($conn));
								while(odbc_fetch_array($FeeHead3)){
									$Check_Fee3 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Fee Description]='".odbc_result($FeeHead3, "Fee Description")."' AND [Company Name]='".odbc_result($rs, "ID")."' ");
									
									echo "<td style='text-align: right;'>";
									if(odbc_num_rows($Check_Fee3) != 0){
									$Pay = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] 
											WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($Check_Fee3, "Fee Description")))." payable' 
											AND [Company Name]='".odbc_result($rs, "ID")."' AND [FinYr]='$FinYr' AND [Qtr]='".odbc_result($qtrly, "Qtr")."' ");
									
									echo number_format(odbc_result($Pay, ""), "2", ".", ""); 
									}
									else{echo "0.00"; }
									echo "</td>";
								}
							?>
							
						</tr>
						<?php } // End of Qtrly?>
						</tbody>
					<?php
					 $c++;
							} // Quarter							
						//} //Fin Year						
					?>
					</table>
				</td>
			</tr>
		</table>
		<script type='text/javascript'>//<![CDATA[
			$(window).load(function(){
				<?php for($k = 1; $k<= $c; $k++){ ?>
				$('#abc tr.level<?php echo $k?>a').hide();
				$('#abc tr.level<?php echo $k?>').click(function() {
					// all trs with level-1 class inside abc table
					$('#abc tr.level<?php echo $k?>a').toggle();
				});
				<?php } ?>
			});//]]> 

		</script>