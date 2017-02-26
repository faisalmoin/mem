<?php
    require_once 'header.php';
    
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
		$apr_e = $t_yr."-04-30 11:59:59";
		$may_s = $t_yr."-05-01 00:00:00";
		$may_e = $t_yr."-05-31 11:59:59";
		$jun_s = $t_yr."-06-01 00:00:00";
		$jun_e = $t_yr."-06-30 11:59:59";
		$jul_s = $t_yr."-07-01 00:00:00";
		$jul_e = $t_yr."-07-31 11:59:59";
		$aug_s = $t_yr."-08-01 00:00:00";
		$aug_e = $t_yr."-08-31 11:59:59";
		$sep_s = $t_yr."-09-01 00:00:00";
		$sep_e = $t_yr."-09-30 11:59:59";
		$oct_s = $t_yr."-10-01 00:00:00";
		$oct_e = $t_yr."-10-31 11:59:59";
		$nov_s = $t_yr."-11-01 00:00:00";
		$nov_e = $t_yr."-11-30 11:59:59";
		$dec_s = $t_yr."-12-01 00:00:00";
		$dec_e = $t_yr."-12-31 11:59:59";
		
		$jan_s = $n_yr."-01-01 00:00:00";
		$jan_e = $n_yr."-01-31 11:59:59";
		$feb_s = $n_yr."-02-01 00:00:00";
		
		if(date('L', $n_yr) == 0) $feb_e = $n_yr."-02-28 11:59:59";
		else if(date('L', $n_yr) == 1) $feb_e = $n_yr."-02-29 11:59:59";
		
		$mar_s = $n_yr."-03-01 00:00:00";
		$mar_e = $n_yr."-03-31 11:59:59";		
		
        }
	else if($today > strtotime(date("Y")."-01-01 00:00:00") && $today < strtotime((date("Y"))."-03-31 23:59:59")){
		$FinYr = date('y')."-".(date('y')+1);
		$t_yr = date('Y')-1;
		$n_yr = date('Y');
		
		//Month
		$apr_s = $t_yr."-04-01 00:00:00";
		$apr_e = $t_yr."-04-30 11:59:59";
		$may_s = $t_yr."-05-01 00:00:00";
		$may_e = $t_yr."-05-31 11:59:59";
		$jun_s = $t_yr."-06-01 00:00:00";
		$jun_e = $t_yr."-06-30 11:59:59";
		$jul_s = $t_yr."-07-01 00:00:00";
		$jul_e = $t_yr."-07-31 11:59:59";
		$aug_s = $t_yr."-08-01 00:00:00";
		$aug_e = $t_yr."-08-31 11:59:59";
		$sep_s = $t_yr."-09-01 00:00:00";
		$sep_e = $t_yr."-09-30 11:59:59";
		$oct_s = $t_yr."-10-01 00:00:00";
		$oct_e = $t_yr."-10-31 11:59:59";
		$nov_s = $t_yr."-11-01 00:00:00";
		$nov_e = $t_yr."-11-30 11:59:59";
		$dec_s = $t_yr."-12-01 00:00:00";
		$dec_e = $t_yr."-12-31 11:59:59";
		
		$jan_s = $n_yr."-01-01 00:00:00";
		$jan_e = $n_yr."-01-31 11:59:59";
		$feb_s = $n_yr."-02-01 00:00:00";		
		if(date('L', $n_yr) == 0) $feb_e = $n_yr."-02-28 11:59:59";
		else if(date('L', $n_yr) == 1) $feb_e = $n_yr."-02-29 11:59:59";
		
		$mar_s = $n_yr."-03-01 00:00:00";
		$mar_e = $n_yr."-03-31 11:59:59";
		
	}
    $q1 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($jul_s)."' ") or die(odbc_errormsg($conn));
    $q2 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($jul_s)."' ") or die(odbc_errormsg($conn));
    $q3 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] BETWEEN '".strtotime($jul_s)."' AND '".strtotime($oct_s)."' ") or die(odbc_errormsg($conn));
    $q4 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] BETWEEN '".strtotime($jul_s)."' AND '".strtotime($oct_s)."' ") or die(odbc_errormsg($conn));
    $q5 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] BETWEEN '".strtotime($oct_s)."' AND '".strtotime($jan_s)."' ") or die(odbc_errormsg($conn));
    $q6 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] BETWEEN '".strtotime($oct_s)."' AND '".strtotime($jan_s)."' ") or die(odbc_errormsg($conn));
    $q7 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] BETWEEN '".strtotime($jan_s)."' AND '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $q8 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] BETWEEN '".strtotime($jan_s)."' AND '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $q9 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($mar_e)."' ") or die(odbc_errormsg($conn));
    $q10 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($mar_e)."' ") or die(odbc_errormsg($conn));
    $q11 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Date] < '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $q12 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Date] < '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    
    $r1 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($jul_s)."' ") or die(odbc_errormsg($conn));
    $r2 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($jul_s)."' ") or die(odbc_errormsg($conn));
    $r3 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] BETWEEN '".strtotime($jul_s)."' AND '".strtotime($oct_s)."' ") or die(odbc_errormsg($conn));
    $r4 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] BETWEEN '".strtotime($jul_s)."' AND '".strtotime($oct_s)."' ") or die(odbc_errormsg($conn));
    $r5 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] BETWEEN '".strtotime($oct_s)."' AND '".strtotime($jan_s)."' ") or die(odbc_errormsg($conn));
    $r6 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] BETWEEN '".strtotime($oct_s)."' AND '".strtotime($jan_s)."' ") or die(odbc_errormsg($conn));
    $r7 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] BETWEEN '".strtotime($jan_s)."' AND '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $r8 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] BETWEEN '".strtotime($jan_s)."' AND '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $r9 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($mar_e)."' ") or die(odbc_errormsg($conn));
    $r10 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] BETWEEN '".strtotime($apr_s)."' AND '".strtotime($mar_e)."' ") or die(odbc_errormsg($conn));
    $r11 = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Date] < '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
    $r12 = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Date] < '".strtotime($apr_s)."' ") or die(odbc_errormsg($conn));
                            

?>
<link href='https://fonts.googleapis.com/css?family=Quicksand:400,300' rel='stylesheet' type='text/css'>
<div class="container">
	<div class="row">
		<div class="col-md-6">
		<span style="font-size: 18px;color: #0075c2;" >Upfront</span>            
	<table class="table table-responsive" style="background-color: #ffffff;border: 1px solid #d5dbdb;">
                <tr style="background-color: #f2f4f4;">
                    <th>Qtr</th>
                    <th style="text-align: center;">Invoice Amt.</th>
                    <th style="text-align: center;">Payment Received</th>
                    <th style="text-align: center;">O/S Amount</th>
                </tr>
                <tr>
                    <td style="text-align: justify;font-family: Quicksand, sans-serif;">Q1</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q1, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q2, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q1, "")-odbc_result($q2, ""), 2, ".", ",");
                        ?>
                    </td>                    
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q2</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q3, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q4, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q3, "")-odbc_result($q4, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q3</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q5, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q6, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q5, "")-odbc_result($q6, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q4</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q7, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q8, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q7, "")-odbc_result($q8, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total (Current Yr.)</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q9, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q10, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q9, "")-odbc_result($q10, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total (Prev. Yrs.)</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q11, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q12, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($q11, "")-odbc_result($q12, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q9, "")+odbc_result($q11, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($q10, "")+odbc_result($q12, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(((odbc_result($q9, "")+odbc_result($q11, ""))-(odbc_result($q10, "")+odbc_result($q12, ""))), 2, ".", ",");
                        ?>
                    </td>
                </tr>
            </table>	
		</div>
		<div class="col-md-6">
			<!-- Some graph -->
                <script type="text/javascript" src="plugins/fusioncharts.js"></script>
                <script type="text/javascript" src="plugins/fusioncharts.charts.js"></script>
                <script type="text/javascript" src="plugins/fusioncharts.theme.fint.js"></script>
                
                <script type='text/javascript'>//<![CDATA[
                window.onload=function(){
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        type: 'mscolumn2d',
                        renderAt: 'chart-container',
                        width: '100%',
                        height: '300',
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "Quarterly Outstanding",
                                "xAxisname": "Quarter",
                                "yAxisName": "Revenues (In INR)",
                                "numberPrefix": "Rs.",
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
                                        { "label": "Q1" },
                                        { "label": "Q2" },
                                        { "label": "Q3" },
                                        { "label": "Q4" }
                                    ]
                                }
                            ],
                            "dataset": [
                                {
                                    "seriesname": "Upfront",
                                    "data": [
                                        { "value": "<?php echo (odbc_result($q1, "")-odbc_result($q2, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($q3, "")-odbc_result($q4, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($q5, "")-odbc_result($q6, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($q7, "")-odbc_result($q8, ""));?>" }
                                    ]
                                }, 
                                {
                                    "seriesname": "Royalty",
                                    "data": [
                                        { "value": "<?php echo (odbc_result($r1, "")-odbc_result($r2, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($r3, "")-odbc_result($r4, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($r5, "")-odbc_result($r6, ""));?>" }, 
                                        { "value": "<?php echo (odbc_result($r7, "")-odbc_result($r8, ""));?>" }
                                    ]
                                }
                            ]/*,
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
                }//]]> 

                </script>
                <div  id="chart-container"></div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
		<span style="font-size: 18px;color: #0075c2;" >Royalty</span>
            <table class="table table-responsive" style="background-color: #ffffff;border: 1px solid #d5dbdb;">
                <tr  style="background-color: #f2f4f4;">
                    <th>Qtr</th>
                    <th style="text-align: center;">Invoice Amt.</th>
                    <th style="text-align: center;">Payment Received</th>
                    <th style="text-align: center;">O/S Amount</th>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q1</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r1, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r2, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r1, "")-odbc_result($r2, ""), 2, ".", ",");
                        ?>
                    </td>                    
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q2</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r3, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r4, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r3, "")-odbc_result($r4, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q3</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r5, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r6, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r5, "")-odbc_result($r6, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Q4</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r7, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r8, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r7, "")-odbc_result($r8, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total (Current Yr.)</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r9, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r10, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r9, "")-odbc_result($r10, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total (Prev. Yrs.)</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r11, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r12, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(odbc_result($r11, "")-odbc_result($r12, ""), 2, ".", ",");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style='font-family: Quicksand, sans-serif;'>Total</td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r9, "")+odbc_result($r11, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php
                            echo number_format(odbc_result($r10, "")+odbc_result($r12, ""), 2, ".", ",");
                        ?>
                    </td>
                    <td style="text-align: right;font-family: Quicksand, sans-serif;">
                        <?php                         
                            echo number_format(((odbc_result($r9, "")+odbc_result($r11, ""))-(odbc_result($r10, "")+odbc_result($r12, ""))), 2, ".", ",");
                        ?>
                    </td>
                </tr>
            </table>
		</div>
		<div class="col-md-6">
		<span style="font-size: 18px;color: #0075c2;" >Overdue Customers</span>
            <table class="table table-responsive" style="background-color: #ffffff;border: 1px solid #d5dbdb;">
                <tr style="background-color: #f3f2f2">
                    <th>Name</th>
                    <th style="text-align: center;">Overdue Amount</th>
                </tr>
                <?php
                    $o = "";
                    $s = odbc_exec($conn, "SELECT DISTINCT([Trust ID]) FROM [MemFin Franchisee Credit]") or  die(odbc_errormsg($conn));
                    while(odbc_fetch_array($s)){
                        $o = odbc_exec($conn, "SELECT * FROM [CRM Agreement] WHERE [ID]='".odbc_result($s, "Trust ID")."'");
                        $so = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Trust ID]='".odbc_result($s, "Trust ID")."' ") or die(odbc_errormsg($conn));
                        $sp = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Trust ID]='".odbc_result($s, "Trust ID")."' ") or die(odbc_errormsg($conn));
                        
                        //$calc1 = number_format(odbc_result($sp, "")/number_format(odbc_result($so, "")*100), 2, ".","");
                        $calc1 = (odbc_result($sp, "")/odbc_result($so, "")*100);
                        if($calc1 <= 50){
                        echo "<tr><td style='font-family: Quicksand, sans-serif;'>";
                        echo odbc_result($o, "Trust Name").", ".odbc_result($o, "City").", ".odbc_result($o, "State");
                        echo "</td><td style='text-align: right;font-family: Quicksand, sans-serif;'>";
                        //Calculate amount
                        echo number_format(odbc_result($so, "")-odbc_result($sp, ""), 2, ".", ",") ." (".round(100-$calc1,2)."%)";
                        echo "</td></tr>";
                        }
                    }
                    
                    $t = odbc_exec($conn, "SELECT DISTINCT([Company Name]) FROM [MemFin Royalty Credit]");
                    while(odbc_fetch_array($t)){
                        $p = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='".odbc_result($t, "Company Name")."'");
                        $sq = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Royalty Credit] WHERE [Company Name]='".odbc_result($t, "Company Name")."' ") or die(odbc_errormsg($conn));
                        $sr = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Royalty Debit] WHERE [Company Name]='".odbc_result($t, "Company Name")."' ") or die(odbc_errormsg($conn));
                        $calc2 = (odbc_result($sr, "")/odbc_result($sq, "")*100);
                        
                        if($calc2 <= 50){
                        echo "<tr><td style='font-family: Quicksand, sans-serif;'>";
                        echo odbc_result($p, "School Name").", ".odbc_result($p, "City").", ".odbc_result($p, "State");
                        echo "</td><td style='text-align: right;font-family: Quicksand, sans-serif;'>";
                        //Calculate amount
                        echo number_format(odbc_result($sq, "")-odbc_result($sr, ""), 2, ".", ",") ." (".round(100-$calc2,2)."%)" ;
                        echo "</td></tr>";
                        }
                    }
                    
                ?>                
            </table>
		</div>
	</div>
    
</div>

<?php
require_once '../footer.php';
?>
