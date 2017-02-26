<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    require_once("SetupLeft.php");
    

    /* draws a calendar */
    function draw_calendar($month,$year,$CompName){
        require '../db.txt';

        
        
        $today = date("d");

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
                if ($list_day == $today) {$style = 'style = "background-color: #999;"';}
                else {$style = "";}
		$calendar.= '<td class="calendar-day" '.$style.'>';
                        /* add in the day number */
                        
			$calendar.= '<div class="day-number" >'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/			
                        $date1 = strtotime($year.'-'.$month.'-'.str_pad($list_day, 2,0,STR_PAD_LEFT).' 00:00:00');
                        $date2 = strtotime($year.'-'.$month.'-'.str_pad($list_day, 2,0,STR_PAD_LEFT).' 23:59:59');
                        /*
                        $res = odbc_exec($conn, "SELECT * FROM [Calendar] 
                                    WHERE [Company Name]='".$CompName."' AND 
                                    ([Start Date] BETWEEN '$date1' AND '$date2') AND 
                                  ([End Date] BETWEEN '$date1' AND '$date2') ") or die(odbc_error($conn));
                        */
                        $res = odbc_exec($conn, "SELECT * FROM [Calendar] 
                                    WHERE [Company Name]='".$CompName."' AND 
                                    (([Start Date] > '$date1' AND 
                                   [End Date] <= '$date2')) ") or die(odbc_error($conn));
                        
                        
                    /*    echo "SELECT * FROM [Calendar] 
                                    WHERE [Company Name]='".$CompName."' AND 
                                    ([Start Date] >= '$date1' AND 
                                  [End Date] <= '$date2') ".date('d/M/Y', $date1)."<br />";
                        echo "SELECT * FROM [Calendar] 
                                    WHERE [Company Name]='".$CompName."' AND 
                                    (([Start Date] > '$date1' AND 
                                   [End Date] <= '$date2')) <br /> ------<br />";*/
                        //echo "Num: ". odbc_num_rows($result);
                        while(odbc_fetch_array($res)){
                            $calendar.= '<p>'.odbc_result($res, "Description").'</p>';
                            //echo '<p>'.odbc_result($result, "Description").'</p>';
                        }
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

$mnth = $_REQUEST['mnth'];
$yr = $_REQUEST['yr'];

$mn = $yr."-".$mnth."-01";

//echo '<h2>'.date("F", strtotime($mn)).' '.$yr.'</h2>';
//echo draw_calendar($mnth,$yr,$CompName);
//echo "Comp : ".$CompName;
?>
<style>
    /* calendar */
    table.calendar		{ border-left:1px solid #999; }
    tr.calendar-row	{  }
    td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
    td.calendar-day:hover	{ background:#eceff5; }
    td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
    td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
    div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
    /* shared */
    td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; height: 80px;}
</style>

<?php require_once("SetupRight.php");?>