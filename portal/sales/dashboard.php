<?php
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
	
	

?>
<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="plugins/fusioncharts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.charts.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.widgets.js"></script>
<script type="text/javascript" src="plugins/fusioncharts.theme.fint.js"></script>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
FusionCharts.ready(function () {
//Funnel Chart
   var conversionChart = new FusionCharts({
        type: 'funnel',
        renderAt: 'chart-container',
        width: '350',
        height: '300',
	dataFormat: 'json',
        dataSource: {
            "chart": {
                //"caption": "Conversion Funnel Analysis for last year",
                //    "subcaption": "Harry's SuperMart Website",
                    "decimals": "1",
                    "labelDistance": "15",
                    "plotTooltext": "Success : $percentOfPrevValue",
                    //To show the values in percentage
                    //"showPercentValues": "1",
                    "theme": "fint",
		    "is2D": "1",
		    "showplotborder": "1",
		    "issliced": "0",
		    //Sort data
		    "streamlineddata": "0",
		    "plotborderthickness": "1",
		    
		    
            },
                "data": [
	    {
                "label": "Qualified",
                    "value": "<?php
			$qual = odbc_exec($conn, "SELECT COUNT(DISTINCT([ID])) FROM [CRM Oppurtunity] WHERE [Stage]='Conversion' AND [Assign To]='$LoginID' AND [Opp Date] BETWEEN '$this_yr' AND '$nxt_yr'") or die(odbc_errormsg($conn));
			echo odbc_result($qual, "");
		    ?>"
            }, {
                "label": "Discussion",
                    "value": "<?php			
			$qual = odbc_exec($conn, "SELECT COUNT(DISTINCT([ID])) FROM [CRM Oppurtunity] WHERE [Stage]='Discussions' AND [Assign To]='$LoginID' AND [Opp No] IN (SELECT [Opp ID] FROM [CRM Opp Activity] WHERE [Date] BETWEEN '$this_yr' AND '$nxt_yr')") or die(odbc_errormsg($conn));
			echo odbc_result($qual, "");
		    ?>"
            }, {
                "label": "LOI",
                    "value": "<?php			
			$qual = odbc_exec($conn, "SELECT COUNT(DISTINCT([ID])) FROM [CRM Oppurtunity] WHERE [Stage]='Letter of Intent (LOI)' AND [Level] <> 'Has signed LOI' AND [Assign To]='$LoginID' AND [Opp No] IN (SELECT [Opp ID] FROM [CRM Opp Activity] WHERE [Date] BETWEEN '$this_yr' AND '$nxt_yr')") or die(odbc_errormsg($conn));
			echo odbc_result($qual, "");
		    ?>"
            }, {
                "label": "Agreement",
                    "value": "<?php			
			$qual = odbc_exec($conn, "SELECT COUNT(DISTINCT([ID])) FROM [CRM Oppurtunity] WHERE [Stage]='Agreement' AND [Level] <> 'Agreement signed' AND [Assign To]='$LoginID' AND [Opp No] IN (SELECT [Opp ID] FROM [CRM Opp Activity] WHERE [Date] BETWEEN '$this_yr' AND '$nxt_yr')") or die(odbc_errormsg($conn));
			echo odbc_result($qual, "");
		    ?>"
            }
	    ]
        }
    }).render();


//Bar Chart
    var topStores = new FusionCharts({
        type: 'bar2d',
        renderAt: 'barchart-container',
        width: '300',
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
			$Reference = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Reference' AND [Assign To]='$LoginID' AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr'   ") or die(odbc_errormsg($conn));
			echo odbc_result($Reference, "");
		    ?>"
                }, 
                {
                    "label": "Website",
                    "value": "<?php
			$Website = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Website' AND [Assign To]='$LoginID'  AND [Lead Date] BETWEEN  '$this_yr' AND '$nxt_yr'  ") or die(odbc_errormsg($conn));
			echo odbc_result($Website, "");
		    ?>"
                }, 
                {
                    "label": "Campaign",
                    "value": "<?php
			$Campaign = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Campaign' AND [Assign To]='$LoginID'  ") or die(odbc_errormsg($conn));
			echo odbc_result($Campaign, "");		    
		    ?>"
                }, 
                {
                    "label": "WOM",
                    "value": "<?php
			$Word = odbc_exec($conn, "SELECT COUNT([id]) FROM [CRM Lead] WHERE [Source]='Word of Mouth' AND [Assign To]='$LoginID'  ") or die(odbc_errormsg($conn));
			echo odbc_result($Word, "");
		    ?>"
                }
            ]
        }
    })
    .render();
    
//Column 2D
    var topStores = new FusionCharts({
        type: 'column2d',
        renderAt: 'col-chart-container',
        width: '300',
        height: '200',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                //"caption": "Top 5 Stores by Sales",
                //"subCaption": "Last month",
                "yAxisName": "Signed / Closed",
                //"numberPrefix": "$",
                "paletteColors": "#0075c2",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placeValuesInside": "1",
		"rotatevalues": "1",
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
            "label": "Apr '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$apr = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($apr_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($apr, "");
	    ?>"
        },
        {
            "label": "May '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$may = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($may_s)."' AND '".strtotime($may_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($may, "");
	    ?>"
        },
        {
            "label": "Jun '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$jun = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($jun_s)."' AND '".strtotime($jun_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($jun, "");
	    ?>"
        },
        {
            "label": "Jul '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$jul = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($jul_s)."' AND '".strtotime($jul_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($jul, "");
	    ?>"
        },
        {
            "label": "Aug '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$aug = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($aug_s)."' AND '".strtotime($aug_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($aug, "");
	    ?>"
        },
        {
            "label": "Sep '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$sep = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($sep_s)."' AND '".strtotime($sep_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($sep, "");
	    ?>"
        },
        {
            "label": "Oct '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$oct = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($oct_s)."' AND '".strtotime($oct_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($oct, "");
	    ?>"
        },
        {
            "label": "Nov '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$nov = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($nov_s)."' AND '".strtotime($nov_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($nov, "");
	    ?>"
        },
        {
            "label": "Dec '<?php echo substr($t_yr,0-2)?>",
            "value": "<?php
		$dec = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($dec_s)."' AND '".strtotime($dec_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($dec, "");
	    ?>"
        },
	{
            "label": "Jan '<?php echo substr($n_yr,0-2)?>",
            "value": "<?php
		$jan = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($jan_s)."' AND '".strtotime($jan_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($jan, "");
	    ?>"
        },
        {
            "label": "Feb '<?php echo substr($n_yr,0-2)?>",
            "value": "<?php
		
		$feb = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($feb_s)."' AND '".strtotime($feb_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($feb, "");
	    ?>"
        },
        {
            "label": "Mar '<?php echo substr($n_yr,0-2)?>",
            "value": "<?php
		$mar = odbc_exec($conn, "SELECT COUNT([ID]) FROM [CRM Oppurtunity] WHERE [Opp Date] BETWEEN '".strtotime($mar_s)."' AND '".strtotime($mar_e)."' AND [Stage]='Agreement' AND [Level]='Agreement signed' AND [Assign To]='$LoginID' ") or die(odbc_errormsg($conn));
		echo odbc_result($mar, "");
	    ?>"
        }
            ]
        }
    })
    .render();
});

var ageGroupChart = new FusionCharts({
        type: 'pie2d',
        renderAt: 'pie-chart-container',
        width: '350',
        height: '200',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                //"caption": "Splot of visitors by age group",
                //    "subCaption": "Last year",
                    "paletteColors": "#008ee4,#6baa01,#f8bd19,#e44a00,#33bdda",
                    "bgAlpha": "1",
                    "borderAlpha": "20",
                    "use3DLighting": "1",
                    "showShadow": "0",
                    "enableSmartLabels": "1",
                    "startingAngle": "20",
                    "showLabels": "0",
                    "showLegend": "1",
                    "legendShadow": "0",
                    "legendBorderAlpha": "0",
                    "enableMultiSlicing": "0",
                    "slicingDistance": "0",
		    "showBorder" : "0",
                    "showPercentValues": "1",
                    "showPercentInTooltip": "0",
                    "decimals": "1"
            },
                "data": [{
                "label": "3-4 Crore",
                    "value": "1250400"
            }, {
                "label": "4-5 Crore",
                    "value": "1463300"
            }, {
                "label": "5+ Crore",
                    "value": "1050700"
            }]
        }
    }).render();

    //ageGroupChart


}
</script>

<div class="container">
	<!-- top tiles -->
	<!--div class="row placeholders" class="background-color: #f9ebea;">
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				$TotAdm = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE [Admission for Year]='$FinYr' AND [Company Name] <> '2' ");
				//echo round(odbc_result($TotAdm, ""),0);
			?></h1>
			<span class="text-muted">Total Admission</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				$TotInactive_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".(date('Y')-1)."-01-01' AND '".(date('Y')-1)."-12-31') AND [Student Status]=2 AND [Admission For Year] = '$FinYr'  AND [Company Name] <> '2' ");
				$TotInactive_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".date('Y')."-01-01' AND '".$dl2."-12-31') AND [Student Status]=2 AND [Company Name] <> '2'   ");
				$TotInactive = round(odbc_result($TotInactive_2, ""),0)-round(odbc_result($TotInactive_1, ""),0);
				
				$TotTC_1 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".(date('Y')-1)."-01-01' AND '".(date('Y')-1)."-12-31') AND [Student Status]=3 AND [Admission For Year] = '$FinYr' AND [Company Name] <> '2'   ");
				$TotTC_2 = odbc_exec($conn, "SELECT COUNT([No_]) From [Temp Student] WHERE ([Date of Leaving] BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31') AND [Student Status]=3 AND [Company Name] <> '2'  ");
				$TotTC = (round(odbc_result($TotTC_2, ""),0) - round(odbc_result($TotTC_1, ""),0));
				
				$TotWD = $TotInactive+$TotTC;
				//echo round($TotWD,0);
			?></h1>
			<span class="text-muted">Total Withdrawal</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;border-right: 2px solid #eaecee;">
			<h1><?php
				//echo  (round(odbc_result($TotAdm, ""),0)-(round($TotWD,0)));
			?></h1>
			<span class="text-muted">Net Admission</span>
		</div>
		<div class="col-xs-6 col-sm-3 placeholder" style="text-align: center;">
			<h1 style="color: #1abc9c"><a href="AdmDash.php" style="text-decoration: none;color: #1abc9c;">
			<?php
				$TotStu = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Student] WHERE [Student Status]=1 AND [Company Name] <> '2' ");
				//echo odbc_result($TotStu, "");
			?>
			</a></h1>
			<span class="text-muted">Total Student Strength</span>
		</div>
	</div-->
          <!-- /top tiles -->
	<br />
	<!--h3 class="text-primary">Dashboard</h3 -->
	<table class="table table-responsive table" style="min-height: 100%;height: 100%;">
		<tr> <!-- style="border: none;" -->
			<td rowspan="2" style="border: none;"  valign="top" width="30%" height="300px">
				<table  class="table table-responsive table-bordered" style="min-height: 100%;height: 80%;">
					<tr>
						<td style="width: 40%">
							<span style="font-weight: bold;">Open Opportunity</span>
							<br /><br />
							<div id="chart-container" align="center"></div>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" style="width:200px; height:30%;border: none;">
				<table  class="table table-responsive table-bordered" style="min-height: 100%;height: 100%;">
					<tr>
						<td>
							<span style="font-weight: bold;">Agreement Closure Status</span>
							<br /><br />
							<div id="col-chart-container"></div>							
						</td>
					</tr>
				</table>
			</td>
			<td style="width:200px; height:30%;border: none;">
				<table  class="table table-responsive table-bordered" style="min-height: 100%;height: 100%;">
					<tr>
						<td>
							<span style="font-weight: bold;">Investment based potentials</span>
							<br /><br />
							<div id="pie-chart-container" align="center"></div>	
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>			
			<td style="height:200px;border: none;" colspan="2" rowspan="2">
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
						height: 310px;
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
				<table  class="table table-responsive table-bordered" style="min-height: 100%; height: 100%;">
					<tr>
						<td>
							<span style="font-weight: bold;">Planned Activities</span>
							<br /><br />
							<div  class="scroll-pane">
								<table class="table table-responsive table-striped" style="width: 100%; ">
									<tr>
										<td>SN</td>
										<td>Date</td>
										<td>ID</td>
										<td>Contact Person</td>
										<td>Activities</td>
										<td>Remarks</td>
										<td>Status</td>
									</tr>
									</thead>
									<tbody style="font-size: 12px">
									<?php
										$a = 1;
										
										//$act = odbc_exec($conn, "SELECT  * FROM [CRM Daily Activity] WHERE [Assign To]='$LoginID' ORDER BY [Date] DESC") or die(odbc_result($conn));
										//echo "SELECT  * FROM [CRM Opp Activity] WHERE [Assign To]='$LoginID' AND [Date] >= '".$today."' ORDER BY [Date] DESC";
										$act = odbc_exec($conn, "SELECT  * FROM [CRM Opp Activity] WHERE [Assign To]='$LoginID' AND [Date] >= '1459449000' ORDER BY [Date] DESC") or die(odbc_result($conn));
										while(odbc_fetch_array($act)){
											echo "<tr style='font-family: Quicksand, sans-serif; font-weight: 400; color: #000000;'>";
											echo "<td style='border: none;'>$a</td>";
											
											echo "<td style='border: none;'>".date('d/M/Y', odbc_result($act, "Date"))."</td>";
											echo "<td style='border: none;'>".odbc_result($act, "Opp ID")."</td>";
											echo "<td style='border: none;'>".odbc_result($act, "Contact Person")."</td>";
											echo "<td style='border: none;'>".odbc_result($act, "Activities")."</td>";
											echo "<td style='border: none;'>".odbc_result($act, "Remarks")."</td>";
											echo "<td style='border: none;'>".odbc_result($act, "Activity Status")."</td>";											
											echo "</tr>";
											
											$a++;
										}
									?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</td>			
		</tr>
		<tr>
			<td style="height: 200px;border: none;" align="center">
				<table  class="table table-responsive table-bordered" style="min-height: 100%;height: 100%;">
					<tr>
						<td height="200px" width="100%">
							<span style="font-weight: bold;">Lead by Source</span>
							<br /><br />							
							<div id="barchart-container"></div>
						</td>
					</tr>
				</table>	
			</td>
			
		</tr>		
	</table>
	<sup style="color: #990000;font-weight: bold;"> * </sup> For Financial Year - <?php echo $FinYr;?>
</div>
