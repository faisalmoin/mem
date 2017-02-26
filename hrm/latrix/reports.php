<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
	require_once("include/defs.inc");
	require_once("classes/db_conn.php");
	require_once("classes/errorbox.php");
	require_once("include/report-items.php");
	require_once("classes/config.php");
	require_once("classes/menu-bar.php");
	
$page_load_start = microtime(true);
$pagetitle = "Reports";
$help_url = 'http://www.latrix.org.uk/node/42';
$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$config->checkUser();						// this checks the cookie and loads company information 
$cid = $config->getCompanyID();
$config->ctrl['subject'] = 'Reports';
$menubar = new Menubar($config, $db_conn);

	require_once("include/header.php");
?>
<body onload="ShowCombos();">
<script type="text/javascript" src="include/StandardScripts.js"></script>
<script type="text/javascript" src="include/scw.js"></script>
<script type="text/javascript" src="include/showdiv.js"></script>
<form id="latform" method="post" action="reportbuilder.php">
<table class="maintable" cellspacing="0px" cellpadding="0px">
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr><td colspan="6">
<?php echo $menubar->build() ?>
</td></tr>
<tr>
	<td>
		<table width="100%">
			<tr>
				<td class="td-left-top">Report Type</td>
				<td class="td-left-top">
				<input type="radio" name="rb_type" id="rep_cards" value="rep_cards" onClick="javascript: ShowDiv(this);"> ID Cards<br>
				<input type="radio" name="rb_type" id="rep_leave" value="rep_leave" onClick="javascript: ShowDiv(this);"> Leave<br>
				<input type="radio" name="rb_type" id="rep_shift" value="rep_shift" onClick="javascript: ShowDiv(this);"> Shifts<br>
				<input type="radio" name="rb_type" id="rep_attend" value="rep_attend" onClick="javascript: ShowDiv(this);"> Raw Attendance<br>
				</td>
				<td><div id="div_lt"><?php echo show_leave_types($cid); ?></div>
				</td>
				<td class="td-left-top" colspan="3">
				<input type="radio" name="rb_type" id="rep_lates" value="rep_lates" checked onClick="javascript: ShowDiv(this);"> Lateness/Attendance<br>
				<input type="radio" name="rb_type" id="rep_transfer" value="rep_transfer" onClick="javascript: ShowDiv(this);"> Transfer Times<br>
				<input type="radio" name="rb_type" id="rep_exception" value="rep_exception" onClick="javascript: ShowDiv(this);"> Exceptions<br>
				<input type="radio" name="rb_type" id="rep_presence" value="rep_presence" onClick="javascript: ShowDiv(this);"> Raw Presence<br>
				</td>
			</tr>
			<tr><td colspan="6"><hr class="separator"></td></tr>
			<tr style="height: 250px">
				<td class="td-left-top">Options</td>
				<td class="td-left-top">
				<div id="div_rb_group">
				Show for :<br>
				<input type="radio" name="rb_att_group" id="rb_att_emp" value="att_emp" checked onClick="javascript: ShowDiv(this);"> Employee<br>
				<?php 
					if ($config->config['user_level'] > lu_employee) {
				?>
				<input type="radio" name="rb_att_group" id="rb_att_team" value="att_team" onClick="javascript: ShowDiv(this);"> Team<br>
				<input type="radio" name="rb_att_group" id="rb_att_dep" value="att_dep" onClick="javascript: ShowDiv(this);"> Department<br>
				<?php 
					}
					if ($config->config['user_level'] > lu_manager) {
				?>
				<input type="radio" name="rb_att_group" id="rb_att_all" value="att_all" onClick="javascript: ShowDiv(this);"> All<br>
				<?php 
					}
				?>
				</div>
				<hr>
				<div id="div_rb_sort">Sort By:<br>
				<input type="radio" name="rb_sort" id="rb_sort_name" value="sort_name"> Employee Name<br>
				<input type="radio" name="rb_sort" id="rb_sort_payroll" checked value="sort_payroll"> Payroll Number<br>
				</div>
				</td>
				<td class="td-left-top" style="width: 200px">
				<?php 
				// This is where we do a trick: we'll have 4 <div>s and the one connected to the selected 
				// radio button shows. Could get interesting in MS IE, as we have listboxes on them. 
				echo "<div id=\"div_group\" style=\"position: relative\">\n";
				echo "<div class=\"overlay\" id=\"div_emp\">Select one or more employees<br>\n";
				echo show_employees($cid)."\n"; 
				echo "</div>\n<div class=\"overlay\" id=\"div_team\">Select one or more teams<br>\n";
				echo show_teams($cid)."<br>\n";
				echo "</div>\n<div class=\"overlay\" id=\"div_dep\">Select one or more departments<br>\n";
				echo show_departments($cid)."<br>\n";
				echo "</div>\n<div class=\"overlay\" id=\"div_all\">This will show all employees<br>\n";
				echo "</div>\n";
				echo "</div>\n";
				?>
				</td>
				<td class="td-left-top">
				<div id="div_rb_range" style="position: relative">
				Time range :<br>
				<input type="radio" name="rb_att_range" id="rb_att_day" value="att_day" checked onClick="javascript: ShowDiv(this);"> Days<br>
				<input type="radio" name="rb_att_range" id="rb_att_week" value="att_week" onClick="javascript: ShowDiv(this);"> Weeks<br>
				<input type="radio" name="rb_att_range" id="rb_att_month" value="att_month" onClick="javascript: ShowDiv(this);"> Months<br>
				<input type="radio" name="rb_att_range" id="rb_att_year" value="att_year" onClick="javascript: ShowDiv(this);"> Year<br>
				</div>
				</td>
				<td class="td-left-top" style="width: 200px">
				<div id="div_range" style="position: relative">
					<span class="overlay" id="div_days">Enter/Select a day<br>
						<input type="text" name="in_date" id="in_date">
						<img src="images/scw.gif" onclick="scwShow(scwID('in_date'),this);" alt="Select a date"><br>
						<a href="#" onclick="AddItem('in_date','in_dates');">Add</a> :: 
						<a href="#" onclick="RemoveItem('in_dates');">Remove</a> :: 
						<a href="#" onclick="ClearList('in_dates');">Clear List</a><br>
						<select name="in_dates" id="in_dates" multiple size="10" onclick="SelectItem('in_date','in_dates');">
							<option value="0">Add a date</option>
						</select>
						<input type="hidden" name="in_dates_text" id="in_dates_text">
					</span>
					<span class="overlay" id="div_weeks">Enter/Select a week<br>
						<input type="text" value="2007-" name="in_week" id="in_week" ><br>
						Enter a year and a week number (e.g. 2007-31)<br>
						<a href="#" onclick="AddItem('in_week','in_weeks');">Add</a> :: 
						<a href="#" onclick="RemoveItem('in_weeks');">Remove</a> :: 
						<a href="#" onclick="ClearList('in_weeks');">Clear List</a><br>
						<select name="in_weeks" id="in_weeks" multiple size="10" onclick="SelectItem('in_week','in_weeks');">
							<option value="0">Add a week</option>
						</select>
						<input type="hidden" name="in_weeks_text" id="in_weeks_text">
					</span>
					<span class="overlay" id="div_months">Select a month<br>
					<?php echo show_months($cid)."<br>\n"; ?>
					</span>
					<span class="overlay" id="div_years">Select a year<br>
					<?php echo show_years($cid)."<br>\n"; ?>
					</span>
				</div>
				</td>
				<td class="td-left-top">
				<div id="div_options" style="position: relative">
				Select the relevant options:<br>
				<hr>
				<input type="checkbox" name="cb_show_details" id="cb_show_details"> Show Details<br>
				<input type="checkbox" name="cb_show_subtotals" id="cb_show_subtotals"> Show Subtotals<br>
				<input type="checkbox" name="cb_show_totals" id="cb_show_totals"> Show Totals<br>
				<hr>
				<input type="checkbox" name="cb_show_visitors" id="cb_show_visitors"> Show Visitors<br>
				<input type="checkbox" name="cb_show_inactive" id="cb_show_inactive"> Show inactive employees<br>
				<hr>
				<input type="checkbox" name="cb_show_empty" id="cb_show_empty"> Show empty resultsets<br>
				</div>
				</td>
			</tr>
			<tr><td colspan="6"><hr class="separator"></td></tr>
			<tr>
				<td class="td-left-top" style="line-height:15pt" >Actions</td>
				<td class="td-left-top" style="line-height:15pt" >
				<input type="radio" name="rb_action" id="rb_html" value="html" checked onClick="javascript: ShowDiv(this);"> Show as page<br>
				<input type="radio" name="rb_action" id="rb_file" value="file" onClick="javascript: ShowDiv(this);"> Download as file<br>
				<input type="radio" name="rb_action" id="rb_mail" value="mail" onClick="javascript: ShowDiv(this);"> Email to:<br>
				<input type="radio" name="rb_action" id="rb_sched" value="sched" onClick="javascript: ShowDiv(this);"> Schedule :<br>
				</td>
				<td class="td-left-top" style="line-height:15pt" >&nbsp;<br> File format: <br>
				<input type="radio" name="rb_mailto" id="rb_me" value="me" checked> To me
				<input type="radio" name="rb_mailto" id="rb_other" value="other"> To this addr.:
				<br> run
				<select name="in_sched" id="in_sched" onchange="javascript: ShowDiv(this);">
				<option selected value="1">Daily</option>
				<option value="2">Mon. - Fri.</option>
				<option value="3">Weekly</option>
				<option value="4">Monthly</option>
				</select></td>
				<td class="td-left-top" style="line-height:15pt" colspan="3">&nbsp;<br>
				<select name="in_file" id="in_file">
				<option selected value="pdf">PDF</option>
				<option value="csv">CSV</option>
				<option value="html">HTML</option>
				</select> format.<br>
				<input type="text" name="mail_adr" id="mail_adr" size="50"><br>
				<div id="div_sched" style="position: relative">
				<div class="overlay" style="visibility: hidden" id="div_weekdays"> on&nbsp;
				<select name="in_schedday" id="in_schedday">
				<option selected value="0">Sunday</option>
				<option value="1">Monday</option>
				<option value="2">Tuesday</option>
				<option value="3">Wednesday</option>
				<option value="4">Thursday</option>
				<option value="5">Friday</option>
				<option value="6">Saturday</option>
				</select> (email as above)</div>
				<div class="overlay" style="visibility: hidden" id="div_monthdays"> on day&nbsp;
				<input type="text" size="10" name="in_monthday" id="in_monthday"> (email as above)
				</div></div>				
				</td>
			</tr>
			<tr><td colspan="6"><hr class="separator"></td></tr>
			<tr>
				<td class="td-left-top" colspan="6" style="text-align:center"> 
					<input type="button" name="btn_run" id="btn_run" value="Perform Selected Action on Selected Report" onclick="SubmitReport();">
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
	<?php include 'include/lfooter.php'; ?>
	</td>
</tr>
</table>
</form>
</body>
</html>

