<?php
	require_once("classes/".$par['rb_type'].".php");

abstract class ReportBase {

	var $dbc;
	var $par;
	var $config;
	var $page_title;
	var $rep_title;
	var $emps;
	var $days;
	var $holidays;
	var $ltypes;
	var $default_shift;
	var $default_shift_wend;
	var $headers;
	var $data;
	var $error;
	var $fhandle;
	var $filename;

	static function getInstance($dbc,$par,$config, $err) {
		return new Report($dbc,$par,$config, $err);
	}
	
	public function __construct(&$db_conn, &$par, &$config, &$err) {
		$this->dbc = $db_conn;
		$this->par = $par;
		$this->config = $config;
		$this->error = $err;
		$this->titles = array (
					 'W' => 'Weekend',
					 'D' => 'Default Shift',
					 'H' => 'Holiday',
					 'HD' => 'Half Day Leave',
					 'L' => 'Leave',
					 'U' => 'Unapproved Leave',
					 'A' => 'Absent without Leave',
					 'E' => 'Exception',
					 'B' => 'Break taken',
					 'S' => 'System adjusted end time',
					 'F' => 'Future date',
					 'T' => 'Transfer occurred');
	}

	public function initialise() {
		print("Initialisation is not implemented for this report.");
	}

	public function process() {
		print("Processing is not implemented for this report.");
	}
	
	public function createFile() {
	
		if ($this->error->isEmpty() == false) {		$sql .= $where." ORDER BY dep, team, name";

			return;
		}
		if ($this->par['rb_action'] == 'html') {
			$fformat = 'html';
		} else {
			$fformat = $this->par['in_file'];
		}
		if ($fformat == 'pdf') {
			$rname = 'files/output'.$this->config->config['user_id'].'.html';
		} else {
			$rname = 'files/output'.$this->config->config['user_id'].'.'.$fformat;
		}
		$this->filename = $rname;
		//$this->error->debug('Filename is : '.$rname);
		if (file_exists($rname)) {
			if (!unlink($rname)) {
				$this->error->add('Could not remove the old temporary file, please check permissions.');
				return false;
			}
		}
		$this->fhandle = fopen($rname,'w');
		if ($this->fhandle == false) {
			$this->error->add('Could not open the temporary file, please check permissions.');
			return false;
		}
		switch ($fformat) {
			case 'html':
				$this->write2HTML();
				fflush ($this->fhandle);
				fclose ($this->fhandle);
				break;
			case 'csv':
				$this->write2CSV();
				fflush ($this->fhandle);
				fclose ($this->fhandle);
				break;
			case 'pdf':
				$this->write2HTML();
				fflush ($this->fhandle);
				fclose ($this->fhandle);
				$this->convert2PDF();
				break;
		}
		return $this->page_title;
	}
	
	
	public function getFileName() {
		return $this->filename;
	}
	protected function write2CSV (){
		// this is the simplest case. We simply stream the header line and the contents into the file.
		// each line is ended with the appropriate character.
		// this particular implementation is very crude and should be overridden by individual reports to allow
		// for a more differentiated export.
		fwrite($this->fhandle, implode(',',$this->headers));
		foreach($this->data as $line) {
			fwrite ($this->fhandle, implode (',',$line));
		}
		
	}
	
	protected function write2HTML() {
		$this->error->add('This report does not implement output to an HTML page.');
	}

	protected function writeReportHeader() {
		$fheader = fopen('include/report-header.php', 'r');
		$buffer = fread($fheader,filesize('include/report-header.php'));
		$buffer = str_replace('%TITLE%',$this->page_title,$buffer);
		$buffer = str_replace('%USERINFO%',$this->getUserInfo(), $buffer);
		$buffer = str_replace('%SHORTVERSION%',la_short_version, $buffer);
		if (!fwrite($this->fhandle,$buffer)) {
			$this->error->add('Could not write to the temporary file, contact system administrator');
			return false;
		}
	}

	protected function writeReportFooter() {
		// write the footer
		$ffooter = fopen('include/report-footer.php', 'r');
		$buffer = fread($ffooter,filesize('include/report-footer.php'));
		$buffer = str_replace('%ERROR%',$this->error->out(),$buffer);
		$buffer = str_replace('%LOADTIME%',$this->getLoadTime(), $buffer);
		$buffer = str_replace('%SHORTVERSION%',la_short_version, $buffer);
		if (!fwrite($this->fhandle,$buffer)) {
			$this->error->add('Could not write to the temporary file, contact system administrator');
			return false;
		}
	}	
	
	protected function convert2PDF() {
		$this->error->add('This report does not implement output to a PDF file.');
	}

	protected function loadEmployees() {
	
		$sql = "SELECT d.name as dep, t.name as team, concat(e.sname, ', ', e.fname) as name, e.emp_id, e.keycode, e.payroll, l.name as loc
				  FROM departments d INNER JOIN teams t ON d.dept_id = t.dept_id INNER JOIN employees e on t.team_id = e.team_id
				  LEFT JOIN locations l on e.location_id = l.location_id";
		switch ($this->par['rb_att_group']) {
		case 'att_emp': 
			$where = " WHERE e.emp_id IN (".$this->par['sel_emp_text'].")";
			if (!isset($this->par['cb_show_visitors'])) {
				$sql .= " AND e.visitor = 0";
			}
			break;
		case 'att_team':
			$where = " WHERE t.team_id IN (".$this->par['sel_team_text'].")";
			$this->rep_title .= "All employees in "; 
			if (!isset($this->par['cb_show_visitors'])) {
				$sql .= " AND t.visitor = 0 AND e.visitor = 0";
			}
			break;
		case 'att_dep':
			$where = " WHERE d.dept_id IN (".$this->par['sel_dep_text'].")";
			$this->rep_title .= "All employees in "; 
			if (!isset($this->par['cb_show_visitors'])) {
				$sql .= " AND d.visitor = 0 AND t.visitor = 0 AND e.visitor = 0";
			}
			break;
		case 'att_all':
			$where = " WHERE d.company_id = ".$this->config->company['company_id'];
			$this->rep_title .= "All employees";
			if (!isset($this->par['cb_show_visitors'])) {
				$sql .= " AND d.visitor = 0 AND t.visitor = 0 AND e.visitor = 0";
			}
			break; 
		}
		$sql .= $where;
		if (!isset($this->par['cb_show_inactive'])) {
			$sql .= " AND e.enabled <> 0 ";
		}
		if ($this->par['rb_sort'] == 'sort_payroll') {
			$sql .= " ORDER BY payroll";
		} else {
			$sql .= " ORDER BY dep, team, name";
		}
//		$this->error->debug($sql);
		$this->emps = $this->dbc->query($sql);
		if (count($this->emps) == 0) {
			$this->error->add('The selected employee range does not contain any employees, so there is nothing to report on.');
			return;
		}
		switch ($this->par['rb_att_group']) {
		case 'att_emp':
			for ($cnt=0;$cnt<count($this->emps);$cnt++){
				$this->rep_title .= $this->emps[$cnt]['name'];
				if ($cnt+1 < count($this->emps)) {
					$this->rep_title .= ", ";
				}
			}
			break;
		case 'att_team':
			$this->rep_title .= $this->emps[0]['team'];
			break;
		case 'att_dep':
			$this->rep_title .= $this->emps[0]['dep'];
			break;
		}
	}
	
	protected function loadDateRange() {
	
		$daysecs = la_day_secs;						// this may need an adjustment for days with daylight savings changes.
		$cnt = 0;
		switch ($this->par['rb_att_range']) { 
		case 'att_day':								// this is simple. the POST already contains the day(s) selected.
															// watch out: the select combo creates an array -> multiple selects are possible.
			if (count($this->par['in_dates']) == 0) {
				$this->error->add('You must add at least one date for this report to work.');
				return;
			}
			$this->days = explode(",", $this->par['in_dates_text']);
			break;
		case 'att_week':
			if (count($this->par['in_weeks']) == 0) {
				$this->error->add('You must add at least one week for this report to work.');
				return;
			}
			$this->weeks = explode(",", $this->par['in_weeks_text']);
			foreach($this->weeks as $week){
				/* this is a bit tricky. First extract the year. Then get the unixtime for the 1st of Jan. of 
				that year, using strtotime. Then add 60*60*24 until the weekday is a Sunday. That is Sunday of week 1
				Then add 60*60*24*7*(week-1) and convert back into a date string. That is the starting day of the week.
				Special cases are obviously week 0 and week 53. In week 0 we don't add anything and the week stops at the first 
				Saturday. For week 53 we do the usual routing, but the week stops prematurely.
				Once we have the start of the week, we simply add 7 dates to the array (unless we are in week 53).
				*/
				$start = strtotime('01/01/'.substr($week,0,4));			// timestamp for the first of Jan.
				if (substr($week,5,2) != '00') {							// if we are not in week 0
					while (date('D',$start) != 'Sun'){						// then go to the first Sunday
						$start += $daysecs;
						}
					$start += $daysecs*7*(substr($week,5,2)-2);				//go to the start of the week
				}
				do {																	// add rows 
					$this->days[$cnt++] = date('Y-m-d',$start);
					$start += $daysecs;
				} while ((date('D',$start) != 'Sun')||(date('W',$start) != substr($week,5,2)));
																						// until we hit a Sunday or the week number changes
			}
			break;
		case 'att_month': 
			$this->months = explode(",", $this->par['sel_months_text']);
			foreach($this->months as $month){
				$start = strtotime($month.'-01');		// go to the first day in the month
				do {
					$this->days[$cnt++] = date('Y-m-d',$start);
					$start += $daysecs;
				} while (date('m',$start) == substr($month,5,2));		// until the month changes
			}
			break;
		case 'att_year':
			$sql = "SELECT unix_timestamp(year_start) AS year_start, unix_timestamp(year_end) AS year_end FROM business_years 
					  WHERE business_year_id in (".$this->par['sel_years_text'].")";
			$byears = $this->dbc->query($sql);
			foreach($byears as $byear){
				$start = $byear['year_start'];
				do {
					$this->days[$cnt++] = date('Y-m-d',$start);
					$start += $daysecs;
				} while ($start <= $byear['year_end']);
			}
			break;
		}
	}
	
	protected function loadRawAttendance($index, $start, $end) {
		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT a.att_date, a.start_time, a.end_time, ass.name as start_type, ase.name as end_type, l.name 
				  FROM attendance a INNER JOIN locations l using (location_id) 
				  INNER JOIN att_types ass on a.start_type = ass.type_id INNER JOIN att_types ase on a.end_type = ase.type_id
				  WHERE a.att_date BETWEEN '".$start."' AND '".$end."' AND a.emp_id=".$emp_id."
				  ORDER BY att_date, start_time";
		$this->emps[$index]['att'] = $this->dbc->query($sql);
	}

	protected function loadAttendance($index,$start, $end) {
	
		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT a.att_date, a.start_time, a.end_time, a.start_type, a.end_type, l.name 
				  FROM attendance a INNER JOIN locations l using (location_id)
				  WHERE a.att_date BETWEEN '".$start."' AND '".$end."' AND a.emp_id=".$emp_id."
				  ORDER BY att_date, start_time";
		$this->emps[$index]['att'] = $this->dbc->query($sql);
	}
	
	protected function loadRawPresence($index, $start, $end) {

		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT a.att_date, a.start_time, a.end_time, ass.name as start_type, ase.name as end_type, l.name 
				  FROM presence a INNER JOIN locations l using (location_id) 
				  INNER JOIN att_types ass on a.start_type = ass.type_id INNER JOIN att_types ase on a.end_type = ase.type_id
				  WHERE a.att_date BETWEEN '".$start."' AND '".$end."' AND a.emp_id=".$emp_id."
				  ORDER BY att_date, start_time";
		$this->emps[$index]['pres'] =  $this->dbc->query($sql);
	}
	
	protected function loadLeave($index,$start, $end, $types) {
	
		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT lt.name, l.start_date, l.end_date, lt.isAWOL, l.submit_date, l.approved, l.approval_date, 
				  concat(e.fname, ' ',e.sname) as approver, l.note, '00:00:00' as start_time, is_half_day as half_day
				  FROM emp_leave l INNER JOIN leave_types lt on l.type_id = lt.leave_type_id left JOIN employees e ON l.approval_emp_id = e.emp_id
				  WHERE ((start_date BETWEEN '".$start."' AND '".$end."' OR end_date BETWEEN '".$start."' AND '".$end."') 
				  OR (start_date < '".$start."' and end_date between '".$start."' and '".$end."') 
				  OR (start_date between '".$start."' and '".$end."' and end_date > '".$end."')
				  OR (start_date < '".$start."' and end_date > '".$end."'))
				  AND l.emp_id = ".$emp_id;
		if ($types == true) {
			$sql .= " AND lt.leave_type_id in (".$this->par['sel_leave_type_text'].")"; 
		}
		$sql .= " ORDER BY start_date;"; 
//				  UNION ALL
//				  SELECT lt.name, l.half_date as start_date, l.half_date as end_date, lt.isAWOL, l.submit_date, l.approved, l.approval_date,
//				  concat(e.fname, ' ',e.sname) as approver, l.note, l.start_time, 1 as half_day
//				  FROM emp_half_days l INNER JOIN leave_types lt on l.type_id = lt.leave_type_id LEFT JOIN employees e ON l.approved_by = e.emp_id
//				  WHERE l.half_date BETWEEN '".$start."' AND '".$end."' 
//				  AND l.emp_id = ".$emp_id." ORDER BY start_date;";
	
		$this->emps[$index]['leave'] = $this->dbc->query($sql);
	}
	
	protected function loadShifts($index, $start, $end) {
		
		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT es.shift_date, s.name, s.start_time, s.end_time, time_to_sec(end_time) - time_to_sec(start_time) as shift_length
				  FROM emp_shifts es INNER JOIN shifts s USING (shift_id)
				  WHERE shift_date BETWEEN '".$start."' AND '".$end."' AND es.emp_id = ".$emp_id." ORDER BY shift_date";
		$this->emps[$index]['shifts'] = $this->dbc->query($sql);
	}
	
	protected function loadExceptions($index,$start, $end) {
	
		$emp_id = $this->emps[$index]['emp_id'];
		$sql = "SELECT x.exception_date, x.start_time, x.end_time, x.submit_date, x.approved, x.approval_date,
				  concat(e.fname, ' ', e.sname) as approver, x.reason, time_to_sec(end_time) - time_to_sec(start_time) as exc_length
				  FROM exceptions x LEFT JOIN employees e ON x.approval_emp_id = e.emp_id
				  WHERE exception_date BETWEEN '".$start."' AND '".$end."' 
				  AND x.emp_id = ".$emp_id." ORDER BY exception_date";
		$this->emps[$index]['exc'] = $this->dbc->query($sql);
	}
	
	protected function loadHolidays($start, $end) {
		
		$sql = "SELECT hdate from holidays WHERE company_id = ".$this->config->company['company_id']." 
				  AND hdate BETWEEN '".$start."' AND '".$end."' ORDER BY hdate ASC";
		$this->holidays = $this->dbc->query($sql);
	}
	
	protected function loadHelpers() {
		$sql = "SELECT * FROM leave_types WHERE company_id=".$this->config->company['company_id'];
		$this->ltypes = $this->dbc->query($sql);
		$sql = "SELECT s.name, s.start_time, s.end_time, time_to_sec(end_time) - time_to_sec(start_time) as shift_length
				  FROM shifts s WHERE s.shift_id =".$this->config->company['default_shift'];
		$this->default_shift = $this->dbc->query($sql);
		$sql = "SELECT s.name, s.start_time, s.end_time, time_to_sec(end_time) - time_to_sec(start_time) as shift_length
				  FROM shifts s WHERE s.shift_id =".$this->config->company['default_shift_wend'];
		$this->default_shift_wend = $this->dbc->query($sql);
	}
	
	protected function isWeekend(&$value) {
		$info = getdate(strtotime($value)); 
		if ($info['weekday'] == 'Sunday' || $info['weekday'] == 'Saturday') {
			return true;
		}
		return false;
	}

	protected function isHoliday(&$value) {
		if ($this->holidays == NULL) { return false;}
		foreach ($this->holidays as $hday) {
			if ($value == $hday['hdate']) { return true; }
		}
		return false;
	}
	
	protected function isOnLeave(&$emp, $day) {
		if ($emp['leave'] == NULL) { return false;}
		foreach ($emp['leave'] as $leave) {
			if ($day >= $leave['start_date'] && $day <= $leave['end_date'] && $leave['approved'] == 1) {
				return true;
			}
		}
		return false;
	}
	
	protected function isOnUnapprovedLeave(&$emp, $day) {
		if ($emp['leave'] == NULL) { return false;}
		foreach ($emp['leave'] as $leave) {
			if ($day >= $leave['start_date'] && $day <= $leave['end_date'] && $leave['approved'] == 0) {
				return true;
			}
		}
		return false;
	}
	
	protected function getException(&$emp, $day) {
		if ($emp['exc'] == NULL) { return NULL;}
		foreach ($emp['exc'] as $exc) {
			if ($exc['exception_date'] == $day && $exc['approved'] == 1) {
				return $exc;
			}
		}
		return NULL;
	}
	
	protected function getUserInfo() {

		$out = 'printed by: '.$this->config->config['user_name'].' from '.$this->config->getLocationName()."<br>\n";
		$out .= 'printed on: '.date('Y-m-d H:i', time());
		return $out;
	}
	
	protected function secs2time($value) {
		// this will only work for time values up to 24 hours, beyond that the result is undefined
		$sign = '';
		if ($value < 0) {
			$sign = '-';
			$value = abs($value);
		}
		$hours = floor($value / 3600);
		$value -= $hours * 3600;
		$mins = floor($value / 60);
		$secs = $value - $mins * 60;
		return sprintf('%s%3d:%02d:%02d',$sign,$hours,$mins, $secs);
	}
	
	protected function time2secs($value) {
		// value must be in hh:mm:ss format
		return substr($value,0,2)*3600 + substr($value,3,2)*60 + substr($value,6,2);
	}
	
	protected function getLoadTime() {
		global $page_load_start;
		$page_load_time = microtime(true)-$page_load_start;
		return round($page_load_time,4);
	}

	protected function getFlagCell($value, $style) {
		// returns a string for a table cell with a DIV inside that provides a popup-explanation when the mouse
		// hovers over the cell. The explanation shows the meanings of the underlying flags 
		// Possible flag values are: (W)eekend, (D)efault Shift, (H)oliday, (L)eave, (A)wol, (HD)alf Day, (E)xception
		// (B)reak taken, (S)ystem adjusted end time, (F)uture date
		if (strlen($value) == 0) {
			return "<td class=\"".$style."\">&nbsp;</td>";
		}
		$title = '';
		for ($cnt=0;$cnt < strlen($value); $cnt++) {
			if ($value[$cnt] == 'H') {
				if ($value[$cnt+1] == 'D') {
					$title .= $this->titles['HD'];
				} else {
					$title .= $this->titles[$value[$cnt]];
				}
			} else {
				$title .= $this->titles[$value[$cnt]];
			}
			if ($cnt < strlen($value)-1) { $title .= ', ';}
		}
		return "<td class=\"".$style."\"><div title=\"".$title."\">".$value."</div></td>";
	}
	
}
?>