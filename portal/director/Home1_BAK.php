<?php 
	require_once("header.php");
        
$today = strtotime(date('Y-m-d H:i:s'));
        $this_yr = strtotime(date("Y")."-04-01 00:00:00");
        $nxt_yr = strtotime((date("Y")+1)."-03-31 23:59:59");
        
	//echo "<br /><br /><br /><br /><br /><br />";	
        
        if($today > strtotime(date("Y")."-04-01 00:00:00") && $today < strtotime((date("Y"))."-12-31 23:59:59")){
            $FinYr = date('y')."-".(date('y')+1);
	    $t_yr = date('Y');
	    $n_yr = (date('Y')+1);
	  
		//Month
		$apr_s = $t_yr."-04-01 00:00:00";
		$apr_e = $t_yr."-04-30 00:00:00";
		$may_s = $t_yr."-05-01 00:00:00";
		$may_e = $t_yr."-05-31 00:00:00";
		$jun_s = $t_yr."-06-01 00:00:00";
		$jun_e = $t_yr."-06-30 00:00:00";
		$jul_s = $t_yr."-07-01 00:00:00";
		$jul_e = $t_yr."-07-31 00:00:00";
		$aug_s = $t_yr."-08-01 00:00:00";
		$aug_e = $t_yr."-08-31 00:00:00";
		$sep_s = $t_yr."-09-01 00:00:00";
		$sep_e = $t_yr."-09-30 00:00:00";
		$oct_s = $t_yr."-10-01 00:00:00";
		$oct_e = $t_yr."-10-31 00:00:00";
		$nov_s = $t_yr."-11-01 00:00:00";
		$nov_e = $t_yr."-11-30 00:00:00";
		$dec_s = $t_yr."-12-01 00:00:00";
		$dec_e = $t_yr."-12-31 00:00:00";
		
		$jan_s = $n_yr."-01-01 00:00:00";
		$jan_e = $n_yr."-01-31 00:00:00";
		$feb_s = $n_yr."-02-01 00:00:00";
		
		if(date('L', $n_yr) == 0) $feb_e = $n_yr."-02-28 00:00:00";
		else if(date('L', $n_yr) == 1) $feb_e = $n_yr."-02-29 00:00:00";
		
		$mar_s = $t_yr."-03-01 00:00:00";
		$mar_e = $t_yr."-03-31 00:00:00";		
		
        }
	else if($today > strtotime(date("Y")."-01-01 00:00:00") && $today < strtotime((date("Y"))."-03-31 23:59:59")){
		$FinYr = date('y')."-".(date('y')+1);
		$t_yr = date('Y')-1;
		$n_yr = date('Y');
		
		//Month
		$apr_s = $t_yr."-04-01 00:00:00";
		$apr_e = $t_yr."-04-30 00:00:00";
		$may_s = $t_yr."-05-01 00:00:00";
		$may_e = $t_yr."-05-31 00:00:00";
		$jun_s = $t_yr."-06-01 00:00:00";
		$jun_e = $t_yr."-06-30 00:00:00";
		$jul_s = $t_yr."-07-01 00:00:00";
		$jul_e = $t_yr."-07-31 00:00:00";
		$aug_s = $t_yr."-08-01 00:00:00";
		$aug_e = $t_yr."-08-31 00:00:00";
		$sep_s = $t_yr."-09-01 00:00:00";
		$sep_e = $t_yr."-09-30 00:00:00";
		$oct_s = $t_yr."-10-01 00:00:00";
		$oct_e = $t_yr."-10-31 00:00:00";
		$nov_s = $t_yr."-11-01 00:00:00";
		$nov_e = $t_yr."-11-30 00:00:00";
		$dec_s = $t_yr."-12-01 00:00:00";
		$dec_e = $t_yr."-12-31 00:00:00";
		
		$jan_s = $n_yr."-01-01 00:00:00";
		$jan_e = $n_yr."-01-31 00:00:00";
		$feb_s = $n_yr."-02-01 00:00:00";		
		if(date('L', $n_yr) == 0) $feb_e = $n_yr."-02-28 00:00:00";
		else if(date('L', $n_yr) == 1) $feb_e = $n_yr."-02-29 00:00:00";
		
		$mar_s = $n_yr."-03-01 00:00:00";
		$mar_e = $n_yr."-03-31 00:00:00";
		
	}
	        
	//Count No. of distinct brand
	$brand = odbc_exec($conn, "SELECT DISTINCT [Likely Brand] AS [Brand] FROM [CRM Oppurtunity] ORDER BY [Likely Brand]");
	$cnt_brd = odbc_num_rows($brand);	
	
?>
<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="plugins/fusioncharts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.charts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.widgets.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.theme.fint.js"></script>

<div class="container" >	
	<!--b style='font-family: Quicksand, sans-serif; font-weight: bold; font-size: 18px; color: #000000;'>Financials</b><br /><br />
	<!-- top tiles -->
	<div class="row placeholders">
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$FinYr' ");
				echo round(odbc_result($TotAdm, ""),0);
			?></h1>
			<span class="text-muted">Total Admission</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				$TotInactive_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".(date('Y')-1)."-01-01' AND '".(date('Y')-1)."-12-31') AND [Student Status]=2 AND [Admission For Year] = '$FinYr' ");
				$TotInactive_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".date('Y')."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2  ");
				$TotInactive = round(odbc_result($TotInactive_2, ""),0)-round(odbc_result($TotInactive_1, ""),0);
				
				$TotTC_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".(date('Y')-1)."-01-01' AND '".(date('Y')-1)."-12-31') AND [Student Status]=3 AND [Admission For Year] = '$FinYr'  ");
				$TotTC_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31') AND [Student Status]=3 ");
				$TotTC = (round(odbc_result($TotTC_2, ""),0) - round(odbc_result($TotTC_1, ""),0));
				
				$TotWD = $TotInactive+$TotTC;
				echo round($TotWD,0);
			?></h1>
			<span class="text-muted">Total Withdrawal</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				echo  (round(odbc_result($TotAdm, ""),0)-(round($TotWD,0)));
			?></h1>
			<span class="text-muted">Net Admission</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;">
			<h1 style="color: #16a085">
			<?php
				$TotStu = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Student] WHERE [Student Status]=1");
				echo odbc_result($TotStu, "");
			?>
			</h1>
			<span class="text-muted">Total Student Strength</span>
		</div>
	</div>
          <!-- /top tiles -->
	<br />
	<div class="row">
		<div class="col-md-3" style="">
			<div class="col-md-12" style="background-color: #ffffff;padding:10px;border: 1px solid #eaecee;min-height: 250px;">
			<b style='font-family: Quicksand, sans-serif; font-weight: bold; font-size: 18px; color: #000000;'>Franchisee Fee</b><hr />
				<div class="row">
					<div class="col-md-8 " style="padding:10px;">Total franchisee fee</div>
					<div class="col-md-4 " style="padding:10px;text-align: right;">&#8377; 0.00</div>
				</div>
				<div class="row" >
					<div class="col-md-8 " style="padding:10px;">Received till date</div>
					<div class="col-md-4 " style="padding:10px;text-align: right;">&#8377; 0.00</div>
				</div>
				<div class="row" >
					<div class="col-md-8 " style="padding:10px;">Due in current year</div>
					<div class="col-md-4 " style="padding:10px;text-align: right;">&#8377; 0.00</div>
				</div>
				<div class="row" >
					<div class="col-md-8 " style="padding:10px;">Balance for next year</div>
					<div class="col-md-4 " style="padding:10px;text-align: right;">&#8377; 0.00</div>
				</div>
			</div>
			<div class="col-md-12" style="min-height: 20px;"></div>
			<div class="col-md-12" style="background-color: #ffffff;padding:10px;border: 1px solid #eaecee;min-height: 250px;">
			<b style='font-family: Quicksand, sans-serif; font-weight: bold; font-size: 18px; color: #000000;'>Lead by Source</b><hr />
				<div id="barchart-container">Chart</div>
				
				<script>
					window.onload=function(){
					FusionCharts.ready(function () {
					//Bar Chart
					    var topStores = new FusionCharts({
						type: 'bar2d',
						renderAt: 'barchart-container',
						width: '100%',
						height: '200',
						dataFormat: 'json',
						dataSource: {
						    "chart": {
							//"caption": "Top 5 Stores by Sales",
							//"subCaption": "Last month",
							"yAxisName": "Leads",
							//"numberPrefix": "$",
							"paletteColors": "#0075c2",
							"bgColor": "#ffffff",
							"showBorder": "0",
							"showCanvasBorder": "0",
							"usePlotGradientColor": "0",
							"plotBorderAlpha": "10",
							"placeValuesInside": "1",
							"valueFontColor": "#ffffff",
							"showAxisLines": "1",
							"axisLineAlpha": "25",
							"divLineAlpha": "10",
							"alignCaptionWithCanvas": "0",
							"showAlternateVGridColor": "0",
							"captionFontSize": "14",
							"subcaptionFontSize": "14",
							"subcaptionFontBold": "0",
							//"toolTipColor": "#ffffff",
							//"toolTipBorderThickness": "0",
							//"toolTipBgColor": "#000000",
							//"toolTipBgAlpha": "80",
							//"toolTipBorderRadius": "2",
							//"toolTipPadding": "5"
						    },
						    
						    "data": [
							{
							    "label": "Cold Call",
							    "value": "<?php
								$cold_call = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Cold Call' AND [Assign To]='$LoginID' AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr' ") or die(odbc_errormsg($conn));
								echo odbc_result($cold_call, "");
							    ?>"
							}, 
							{
							    "label": "Email",
							    "value": "<?php
								$Email = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Email' AND [Assign To]='$LoginID' AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr'   ") or die(odbc_errormsg($conn));
								echo odbc_result($Email, "");
							    ?>"
							}, 
							{
							    "label": "Reference",
							    "value": "<?php
								$Reference = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Reference'  AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr'   ") or die(odbc_errormsg($conn));
								echo odbc_result($Reference, "");
							    ?>"
							}, 
							{
							    "label": "Website",
							    "value": "<?php
								$Website = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Website'   AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr'  ") or die(odbc_errormsg($conn));
								echo odbc_result($Website, "");
							    ?>"
							}, 
							{
							    "label": "Campaign",
							    "value": "<?php
								$Campaign = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Campaign'   ") or die(odbc_errormsg($conn));
								echo odbc_result($Campaign, "");		    
							    ?>"
							}, 
							{
							    "label": "WOM",
							    "value": "<?php
								$Word = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Word of Mouth'   ") or die(odbc_errormsg($conn));
								echo odbc_result($Word, "");
							    ?>"
							}
						    ]
						}
					    })
					    .render();
					});
					}
				</script>
			</div>
		</div>
		
		<div class="col-md-6  ">
			<div class="col-md-12" style="background-color: #ffffff;padding:10px;border: 1px solid #eaecee;min-height: 500px;">
				<b style='font-family: Quicksand, sans-serif; font-weight: bold; font-size: 18px; color: #000000;'>Oppurtunity Status</b><hr />
				<table class="table table-responsive table-bordered">
					<thead style="background-color: #2980b9; color: #ffffff; ">
					<tr>
						<th rowspan="2">Zone</th>
						<th rowspan="2" style="text-align: center; ">Opportunity</th>
						<th rowspan="2">Stages</th>
						<th colspan="<?php echo $cnt_brd?>" style="text-align: center; ">Brand</th>			
					</tr>
					<tr>
					<?php
						while(odbc_fetch_array($brand)){
					?>	
						<th style="text-align: center; "><?php echo odbc_result($brand, "Brand")?></th>
					<?php
							$d_brand .= odbc_result($brand, "Brand")."; ";
						}
					?>
					</tr>
					</thead>
					<?php 
						$sts0 = "";
						$q0 = odbc_exec($conn, "SELECT DISTINCT [State] FROM [CRM Oppurtunity] ") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($q0)){
							$sts0 .= "'".odbc_result($q0, "State")."', ";
						}
						$sts0 = substr($sts0, 0, -2);
						
						$q1 = odbc_exec($conn, "SELECT DISTINCT [Region] FROM [postcode] WHERE ([StateCode] IN (".$sts0.") OR [State] IN (".$sts0.") ) ORDER BY [Region]") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($q1)){
					?>
					<tr>
						<td rowspan="5" style="vertical-align:middle; "><?php echo odbc_result($q1, "Region")?></td>
						<td rowspan="5" style="text-align: center;vertical-align:middle; ">
						<?php
							//Get State Code
							$stcode = "";
							
							$st_code = odbc_exec($conn, "SELECT DISTINCT [State] FROM [postcode] WHERE [Region]='".odbc_result($q1, "Region")."' ") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($st_code)){
								$stcode .= "'".odbc_result($st_code, "State")."', ";
							}				
							$stcode = substr($stcode, 0, -2);
							
							$opp = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [State] IN ($stcode)");
							echo odbc_result($opp, "");
						?>
						</td>
						<td style="background-color: #eaf2f8; ">Qualified</td>
						<?php
							for($i=1; $i<= $cnt_brd; $i++){
								$dbd = explode("; ", $d_brand);
								$q2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [Stage]='Conversion' AND [State] IN ($stcode) AND [Likely Brand]='".$dbd[$i-1]."' ");
								echo "<td style='text-align: center;background-color: #eaf2f8; '>";
								echo (odbc_result($q2, "") != 0?odbc_result($q2, "") :"");
								echo "</td>";
							}
						?>
					</tr>
					<tr style="background-color: #fdf2e9; ">
						<td>Discussions</td>
						<?php
							for($i=1; $i<= $cnt_brd; $i++){
								$dbd = explode("; ", $d_brand);
								echo "<td style='text-align: center; '>";
								$q2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [Stage]='Discussions' AND [State] IN ($stcode) AND [Likely Brand]='".$dbd[$i-1]."' ");
								echo (odbc_result($q2, "") != 0?odbc_result($q2, "") :"");
								echo "</td>";
							}
						?>
					</tr>
					<tr style="background-color: #eaf2f8; ">
						<td>LOI</td>
						<?php
							for($i=1; $i<= $cnt_brd; $i++){
								$dbd = explode("; ", $d_brand);
								echo "<td style='text-align: center; '>";
								$q2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [Stage]='Letter of Intent (LOI)' AND [State] IN ($stcode) AND [Likely Brand]='".$dbd[$i-1]."' ");
								echo (odbc_result($q2, "") != 0?odbc_result($q2, "") :"");
								echo "</td>";
							}
						?>
					</tr>
					<tr style="background-color: #f2f4f4; ">
						<td>Agreement</td>
						<?php
							for($i=1; $i<= $cnt_brd; $i++){
								$dbd = explode("; ", $d_brand);
								echo "<td style='text-align: center; '>";
								$q2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [Stage]='Agreement' AND [Level]<>'Agreement signed' AND [State] IN ($stcode) AND [Likely Brand]='".$dbd[$i-1]."' ");
								echo (odbc_result($q2, "") != 0?odbc_result($q2, "") :"");
								echo "</td>";
							}
						?>
					</tr>
					<tr style="background-color: #a9dfbf; ">
						<td>Completed</td>
						<?php
							for($i=1; $i<= $cnt_brd; $i++){
								$dbd = explode("; ", $d_brand);
								echo "<td style='text-align: center; '>";
								$q2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [State] IN ($stcode) AND [Likely Brand]='".$dbd[$i-1]."' ");
								echo (odbc_result($q2, "") != 0?odbc_result($q2, "") :"");
								echo "</td>";
							}
						?>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div>
		<div class="col-md-3" >
			<div class="col-md-12" style="background-color: #ffffff;padding:10px;border: 1px solid #eaecee;min-height: 500px;">
			<b style='font-family: Quicksand, sans-serif; font-weight: bold; font-size: 18px; color: #000000;'>Planned Activities </b><hr />
				<ul>
				<?php
					$gDate = odbc_exec($conn, "SELECT DISTINCT([Date]) FROM [CRM Opp Activity] WHERE [Date] > '$today' ORDER BY [Date] DESC");
					while(odbc_fetch_array($gDate)){
						echo "<li style='font-size: 16px;color: #2980b9; font-family: Quicksand, sans-serif;'>".date('d/M/Y', odbc_result($gDate, "Date"))."</li>";
						
						$Opp = odbc_exec($conn, "SELECT * FROM [CRM Opp Activity] WHERE [Date]='".odbc_result($gDate, "Date")."'");
						while(odbc_fetch_array($Opp)){
							echo "<p style='color: #808b96;  font-family: Quicksand, sans-serif;'>";
							$user = odbc_exec($conn, "SELECT [FullName] FROM [user] WHERE [LoginID]='".odbc_result($Opp, "Assign To")."' ");
							echo "<b><u>".odbc_result($user, "FullName")."</u></b>";
							echo " aligned with ";
							$OppDtl = odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [Opp No]='".odbc_result($Opp, "Opp ID")."' ");
							echo odbc_result($OppDtl, "Name");
							echo " of ";
							echo odbc_result($OppDtl, "City") ." ".odbc_result($OppDtl, "State").", for ";
							echo "<i>".odbc_result($OppDtl, "Level")."</i> in <i>".odbc_result($OppDtl, "Stage")."</i> stage.";
							echo "</p>";
						}
						
					}
				?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php require_once("footer.php"); ?>