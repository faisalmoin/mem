<?php 
	require_once("header.php");
        
        $today = strtotime(date('Y-m-d'));
        $this_yr = strtotime(date("Y")."-04-01");
        $nxt_yr = strtotime((date("Y")+1)."-03-31");
        
        if($today > strtotime(date("Y")."-04-01") && $today < strtotime((date("Y")+1)."-03-31")){
            $FinYr = date('y')."-".(date('y')+1);
        }    
        
?>
<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="plugins/fusioncharts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.charts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.widgets.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.theme.fint.js"></script>

<div class="container" style='font-family: Quicksand, sans-serif; font-weight: 400; color: #000000;'>
	<table class="table table-responsive">
		<tr>
			<td width="40%" valign="top" style="height: 200px; border: none;">
				<?php 
					$sts0 = "";
					$q0 = odbc_exec($conn, "SELECT DISTINCT [State] FROM [CRM Oppurtunity] WHERE [Level]='Agreement signed' ") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($q0)){
						$sts0 .= "'".odbc_result($q0, "State")."', ";
					}
					$sts0 = substr($sts0, 0, -2);
				?>
				<script type='text/javascript'>//<![CDATA[
					window.onload=function(){
						FusionCharts.ready(function () {
						    var revenueChart = new FusionCharts({
						        type: 'mscolumn2d',
						        renderAt: 'chart-container',
						        width: '100%',
						        height: '250',
						        dataFormat: 'json',
						        dataSource: {
						            "chart": {
						                //"caption": "Comparison of Quarterly Revenue",
						                "xAxisname": "Region",
						                "yAxisName": "No. of Agreements",
						                //"numberPrefix": "$",
						                "plotFillAlpha" : "80",

						                //Cosmetics
						                "paletteColors" : "#0075c2,#1aaf5d",
						                "baseFontColor" : "#333333",
						                "baseFont" : "Helvetica Neue,Arial",
						                "captionFontSize" : "14",
						                "subcaptionFontSize" : "14",
						                "subcaptionFontBold" : "0",
						                "showBorder" : "0",
						                "bgColor" : "#ffffff",
						                "showShadow" : "0",
						                "canvasBgColor" : "#ffffff",
						                "canvasBorderAlpha" : "0",
						                "divlineAlpha" : "100",
						                "divlineColor" : "#999999",
						                "divlineThickness" : "1",
						                "divLineIsDashed" : "1",
						                "divLineDashLen" : "1",
						                "divLineGapLen" : "1",
						                "usePlotGradientColor" : "0",
						                "showplotborder" : "0",
						                "valueFontColor" : "#ffffff",
						                "placeValuesInside" : "1",
						                "showHoverEffect" : "1",
						                "rotateValues" : "1",
						                "showXAxisLine" : "1",
						                "xAxisLineThickness" : "1",
						                "xAxisLineColor" : "#999999",
						                "showAlternateHGridColor" : "0",
						                "legendBgAlpha" : "0",
						                "legendBorderAlpha" : "0",
						                "legendShadow" : "0",
						                "legendItemFontSize" : "10",
						                "legendItemFontColor" : "#666666"                
						            },
						            "categories": [
						                {
						                    "category": [
							                    //Get Region
							                    <?php 
							                    	$bZone = "";
							                    	$bar_zone = odbc_exec($conn, "SELECT DISTINCT [Region] FROM [postcode] WHERE [StateCode] IN (".$sts0.") ORDER BY [Region]") or die(odbc_errormsg($conn));
							                    	while(odbc_fetch_array($bar_zone)){
							                    		$bZone .= '{ "label" : "'.odbc_result($bar_zone, "Region").'" }, ';	
							                    	}
							                    	//echo substr($bZone, 0, -2);
							                    	echo $bZone;
							                    	
							                    ?>
						                    ]
						                }
						            ],
						            "dataset": [
						                {
						                    "seriesname": "Previous Year",
						                    "data": [
						                        { "value": "10000" }, 
						                        { "value": "11500" }, 
						                        { "value": "12500" }, 
						                        { "value": "15000" }
						                    ]
						                }, 
						                {
						                    "seriesname": "Current Year",
						                    "data": [
						                        { "value": "25400" }, 
						                        { "value": "29800" }, 
						                        { "value": "21800" }, 
						                        { "value": "26800" }
						                    ]
						                }
						            ],
						            /*
						            "trendlines": [
						                {
						                    "line": [
						                        {
						                            "startvalue": "12250",
						                            "color": "#0075c2",
						                            "displayvalue": "Previous{br}Average",
						                            "valueOnRight" : "1",
						                            "thickness" : "1",
						                            "showBelow" : "1",
						                            "tooltext" : "Previous year quarterly target  : $13.5K"
						                        },
						                        {
						                            "startvalue": "25950",
						                            "color": "#1aaf5d",
						                            "displayvalue": "Current{br}Average",
						                            "valueOnRight" : "1",
						                            "thickness" : "1",
						                            "showBelow" : "1",
						                            "tooltext" : "Current year quarterly target  : $23K"
						                        }
						                    ]
						                }
						            ]*/
						        }
						    });
						    
						    revenueChart.render();
						});
					};
				</script>
				<table class="table table-responsive table-bordered">
					<tr>
						<td style="height: 200px;">
							<span  style="font-weight: bold;">Signed Agreements</span><br /><br />
							<div id="chart-container" align="center"></div>
						</td>
					</tr>
				</table>
			</td>
			<td width="60%" valign="top" rowspan="2" style=" border: none;height: 400px;">
				<table class="table table-responsive table-bordered">
					<tr>
						<td style="height: 500px;" >
							<span  style="font-weight: bold;">Leads Status</span><br /><br />
							<!-- the mousewheel plugin -->
							<script type="text/javascript" src="http://jscrollpane.kelvinluck.com/script/jquery.mousewheel.js"></script>
							<!-- the jScrollPane script -->
							<script type="text/javascript" src="http://jscrollpane.kelvinluck.com/script/jquery.jscrollpane.min.js"></script>
							
							<link type="text/css" href="http://jscrollpane.kelvinluck.com/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
							<style type="text/css" id="page-css">
								/* Styles specific to this particular page */
								.scroll-pane
								{
									width: 100%;
									height: 500px;
									overflow: auto;
								}
								.horizontal-only
								{
									height: auto;
									max-height: 200px;
								}
							</style>
							<script type="text/javascript" id="sourcecode">
								$(function()
								{
									$('.scroll-pane').jScrollPane();
								});
							</script>
							<div  class="scroll-pane">							
							<table class="table table-responsive table-striped" style="">
								<tr>
									<th>State</th>
									<th>Brand</th>
									<th>Sales Rep</th>
									<th>Stage</th>
									<th>Status</th>
								</tr>
								<?php
									//Select Distinct ZONE
									$sts = "";
									$q1 = odbc_exec($conn, "SELECT DISTINCT [State] FROM [CRM Oppurtunity]") or die(odbc_errormsg($conn));
									while(odbc_fetch_array($q1)){
										$sts .= "'".odbc_result($q1, "State")."', ";
									}
									$sts = substr($sts, 0, -2);
									
									$Zone = odbc_exec($conn, "SELECT DISTINCT [Region] FROM [postcode] WHERE [StateCode] IN (".$sts.") ORDER BY [Region]");
									while(odbc_fetch_array($Zone)){
								?>
								<tr><td colspan="5" style="text-align: center; background-color: green; color: #FFFFFF; ">Zone : <b><?php echo odbc_result($Zone, "Region") ?></b></tr>
								<?php
										//Check if the States are available in the zonce
										$st_chk = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='".odbc_result($Zone, "Region")."'");
										//$st_chk = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='North'");
										while(odbc_fetch_array($st_chk)){
								
											$leads = odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [Status]='Qualified' AND [State]='".odbc_result($st_chk, "StateCode")."' ORDER BY [State]") or die(odbc_errormsg($conn));
											while(odbc_fetch_array($leads)){
								?>
								<tr>
									<td><?php
										$St = odbc_exec($conn, "SELECT [State] FROM [postcode] WHERE [StateCode]='".odbc_result($leads, "State")."' ");
										echo odbc_result($St, "State")?></td>
									<td><?php echo odbc_result($leads, "Likely Brand")?></td>
									<td><?php 
										$rep = odbc_exec($conn, "SELECT [FullName] FROM [user] WHERE [LoginID]='".odbc_result($leads, "Assign To")."' ") or die(odbc_errormsg($conn));
										echo odbc_result($rep, "FullName");									
									?></td>
									<td><?php echo (odbc_result($leads, "Stage")=="Conversion"?"Qualified":odbc_result($leads, "Stage"));  ?></td>
									<td><?php echo odbc_result($leads, "Level")?></td>
								</tr>
								<?php 
											}
										}
										
									}								
									
								?>
								
							</table>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="40%" valign="top" style="height: 200px; border: none;">				
				<table class="table table-responsive table-bordered" style="height: 200px;">
					<tr>
						<td>
							<span  style="font-weight: bold;">Financials</span><br /><br />
							<table class="table table-responsive" style="height: 200px;">
								<tr>
									<td style="border: none;">Total Franchisee Fee</td>
									<td style="border: none;">&#x20B9; 00.00</td>
								</tr>
								<tr>
									<td style="border: none;">Received till date</td>
									<td style="border: none;">&#x20B9; 00.00</td>
								</tr>
								<tr>
									<td style="border: none;">Due in current year</td>
									<td style="border: none;">&#x20B9; 00.00</td>
								</tr>
								<tr>
									<td style="border: none;">Balance for next year</td>
									<td style="border: none;">&#x20B9; 00.00</td>
								</tr>
								
							</table>
						</td>
					</tr>
				</table>	
			</td>
		</tr>
	</table>
</div>
<?php require_once("../footer.php"); ?>