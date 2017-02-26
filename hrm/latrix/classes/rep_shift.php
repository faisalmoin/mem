<?php
/*
	Shift Report.
	
	The shift report shows the following columns:
	
	Department, team, employee name, date, shift name, shift start, shift end, flags.
	
	There is basically no processing of data happening. All the data is loaded in from the database as required.
	The processing just prepares the final data set ready for output.
	For days where the employee is on leave, the report shows "LEAVE" in the shift name column and "L" as flag.
	For public holidays the report will show "HOLIDAY" in the shift name column and a "H" in the flags column.
	Where no shifts are defined, the default shifts are used. These are marked with a "D" in the flags column.

*/
class Report extends ReportBase {

	public function __construct(&$db_conn, &$par, &$config, &$err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->headers = array("Dept.","Team","Empl.","Date","Shift","Start Time","End Time","Flags");
		$this->page_title = 'Shift Report';
	}

	public function initialise() {

		$this->loadEmployees(); 
		$this->loadDateRange();			// this is only required to establish the first and the last day, so that
												// the loadLeave can work. Best to use this as the user may select a weird
												// collection of weeks or months.
		if ($this->error->isEmpty() == false) {
			return;
		}
		$this->loadHolidays($this->days[0], $this->days[count($this->days)-1]);
		$this->loadHelpers();
		if (count($this->emps) < 1) {
			$this->error->add('There is no employee data, therefore also no report.');
			return;
		}
		for($cnt=0; $cnt<count($this->emps);$cnt++) {
			//now load the leave data and the shift data
			$this->loadLeave($cnt, $this->days[0], $this->days[count($this->days)-1],false);
			$this->loadShifts($cnt, $this->days[0], $this->days[count($this->days)-1] );
		}
	}
	
	public function process() {
	
		$cnt = 0;
		foreach ($this->emps as $emp) {
			$scnt = 0;
			foreach($this->days as $day) {
				if ($this->isHoliday($day)) {
					$this->data[$cnt++] = array($emp['dep'], $emp['team'], $emp['name'], 
														$day, 'HOLIDAY', '--:--:--', '--:--:--','H');
				} elseif ($this->isOnLeave($emp,$day)) {
					$this->data[$cnt++] = array($emp['dep'], $emp['team'], $emp['name'], 
														$day, 'LEAVE', '--:--:--', '--:--:--','L');
				} elseif ($emp['shifts'][$scnt]['shift_date'] == $day) {
					$this->data[$cnt++] = array($emp['dep'], $emp['team'], $emp['name'], 
														 $emp['shifts'][$scnt]['shift_date'],
														 $emp['shifts'][$scnt]['name'],
														 $emp['shifts'][$scnt]['start_time'],
														 $emp['shifts'][$scnt]['end_time'],'');
					$scnt++;
				} else {
					$date = strtotime($day);
					$info = getdate($date);
					if ($info['weekday'] == 'Sunday' || $info['weekday'] == 'Saturday') {
						$this->data[$cnt++] = array($emp['dep'], $emp['team'], $emp['name'], 
															$day,
															$this->default_shift_wend[0]['name'],
															$this->default_shift_wend[0]['start_time'],
															$this->default_shift_wend[0]['end_time'],'D');
					} else {
						$this->data[$cnt++] = array($emp['dep'], $emp['team'], $emp['name'], 
															$day,
															$this->default_shift[0]['name'],
															$this->default_shift[0]['start_time'],
															$this->default_shift[0]['end_time'],'D');
					}
				}
			}						// end for all dates for employee -> no subtotals
		}							// end for all employees, no grand totals. 
	}
	
	protected function write2CSV (){
		// overrides the function in reportbase.php for more detailed exporting (string enclosures, etc.)
		$cnt = 0;
		foreach($this->headers as $header) {
			fwrite($this->fhandle, '"'.$header.'"');
			$cnt++;
			if ($cnt < count($this->headers)) {
				fwrite($this->fhandle, ",");
			}
		}
		fwrite($this->fhandle,"\n");
//	Department, team, employee name, date, shift name, shift start, shift end, flags.
// at the moment this will always write department team and employee name, plus all details.
// in the future we will probably need the ability to suppress repeating text 
// plus possibly another option to only show summary data.
		foreach ($this->data as $line) {
			fwrite ($this->fhandle, '"'.$line[0].'",');		//Department
			fwrite ($this->fhandle, '"'.$line[1].'",');		//Team
			fwrite ($this->fhandle, '"'.$line[2].'",');		//Employee
			fwrite ($this->fhandle, '"'.$line[3].'",');		//Date
			fwrite ($this->fhandle, '"'.$line[4].'",');		//Shift Name
			fwrite ($this->fhandle, '"'.$line[5].'",');		//Shift Start
			fwrite ($this->fhandle, '"'.$line[6].'",');		//Shift End
			fwrite ($this->fhandle, '"'.$line[7].'"');		//Flags
			fwrite ($this->fhandle, "\n");
		}		
	}

	protected function write2HTML() {
	
		$CRLF = "\r\n";
		// write the header
		$this->writeReportHeader();
		// write the body
		// first the title bar with the column headers
		$out = "<table width=\"100%\">".$CRLF;
		$out .= "<tr><td class=\"bluehead\" colspan=\"".count($this->headers)."\">".$this->rep_title."</td></tr>".$CRLF;
		$out .= "<tr>";
		foreach ($this->headers as $header){
			$out .= "<td class=\"bluesubhead\">".$header."</td>";
		}	
		$out.= "</tr>".$CRLF;
		if (!fwrite($this->fhandle,$out)) {
			$this->error->add('Could not write to the temporary file, contact system administrator');
			return false;
		}
		// now the data. If the details box is checked, we show all the lines. Otherwise only the subtotals.
		// subtotals are defined by the fact that in the next line the employee name changes.
		$old_emp = '';
		$old_dep = '';
		$old_team = '';
		foreach ($this->data as $line) {
			$out = '';
//			var_dump($line);
//			Department, team, employee name, date, shift name, shift start, shift end, flags.
			if ($old_dep <> $line[0]) {				// new department -> show the name
				$out .= "<tr><td class=\"detail\">".$line[0]."</td>";
			} else {
				$out .= "<tr><td class=\"detail\">&nbsp;</td>";
			}
			if ($old_team <> $line[1]) {				// new team -> show the name
				$out .= "<td class=\"detail\">".$line[1]."</td>";
			} else {
				$out .= "<td class=\"detail\">&nbsp;</td>";
			}
			if ($old_emp <> $line[2]) {				// first line for this employee -> show 
				$out .= "<td class=\"detail\">".$line[2]."</td>";
			} else {
				$out .= "<td class=\"detail\">&nbsp;</td>";
			}
			for ($cnt = 3;$cnt < count($line);$cnt++) {
				if ($cnt == count($line)-1) {
					$out .= $this->getFlagCell($line[$cnt], 'detail');
				} else {
					$out .= "<td class=\"detail\">".$line[$cnt]."</td>";
				}
			}
			$out .= "</tr>".$CRLF;
//			var_dump($out);
			fwrite($this->fhandle, $out);
			$old_dep = $line[0];
			$old_team = $line[1];
			$old_emp = $line[2];
		}
		$out = "<tr><td colspan=\"".count($this->headers)."\">Flags: D : default shift</td></tr>"; 
		fwrite($this->fhandle,$out);
		fwrite($this->fhandle,"</table>".$CRLF);
		// write the footer
		$this->writeReportFooter();
	}
}

?>