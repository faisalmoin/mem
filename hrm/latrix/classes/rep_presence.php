<?php 
/*
	Raw Presence Report. 
	This simply shows a list of all the raw attendance data, complete with type information and location.
	Columns: Dept, Team, Name, Date, Arrive, Type, Depart, Type, Location, Flags
	Needed : Attendance, Presence, Holidays, Leave (incl. half-days)
	Flags : H = holiday, L = Leave (approved), U = Leave (unapproved), W = Weekend, A = AWOL, S = System adjusted
*/
class Report extends ReportBase {

	public function __construct(&$db_conn, $par, $config, $err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->headers = array("PayID","Dept.","Team","Empl.","Date","Type","Start","Type","End","Location","Flags");
		$this->page_title = 'Raw Presence Report';
		$this->today = date('Y-m-d');
	}

	public function initialise() {

		$this->loadEmployees();
		$this->loadDateRange();
		if ($this->error->isEmpty() == false) {
			return;
		}
		$this->loadHolidays($this->days[0], $this->days[count($this->days)-1]);
		$this->loadHelpers();
		for($cnt=0; $cnt<count($this->emps);$cnt++) {
			//now load the attendance data
			$this->loadRawPresence($cnt, $this->days[0], $this->days[count($this->days)-1] );
			$this->loadLeave($cnt, $this->days[0], $this->days[count($this->days)-1],false );
		}
	}
	
	public function process () {

		$cnt = 0;
		foreach ($this->emps as $emp) {
			$acnt = 0;
			$emp_start = $cnt;
			$flags = '';
			foreach ($this->days as $day) {
				if ($this->isWeekend($day)) {
					$flags = 'W';
				} elseif ($this->isHoliday($day)) {
					$flags = 'H';
				} elseif ($this->isOnLeave($emp, $day)) {
					$flags = 'L';
				} elseif ($this->isOnUnapprovedLeave($emp, $day)) {
					$flags = 'U';
				} else {
					$flags = '';
				}
				if ($day == $emp['pres'][$acnt]['att_date']) {
					do {
//					$this->error->debug('Day: '.$day.', Att.Date: '.$emp['pres'][$acnt]['att_date'].'<br>');
					// OK, we have at least one presence/attendance record, possibly more.
					// now we need to output them in order of time. 
//	Columns: PayID, Dept, Team, Name, Date, Start, Type, Stop, Type, Location, Flags
						$this->data[$cnt++] = array($emp['payroll'],$emp['dep'], $emp['team'], $emp['name'], $day,
															 $emp['pres'][$acnt]['start_type'],
															 $emp['pres'][$acnt]['start_time'],
															 $emp['pres'][$acnt]['end_type'],
															 $emp['pres'][$acnt]['end_time'],
															 $emp['pres'][$acnt]['name'],$flags);
						$acnt++;
					} while ($day == $emp['pres'][$acnt]['att_date']);
				} else {
					if ($day > $this->today) {
						// This is in the future, there is no data.
						$flags .= 'F';
					} else {
						if ($flags == '' || $flags == 'U') {
							// no presence records and no other excuse -> you been a'missin my friend
							$flags .= 'A';
						}
					}
					$this->data[$cnt++] = array($emp['payroll'],$emp['dep'], $emp['team'], $emp['name'], $day,
														 "-","--:--","-","--:--",
														 " ", $flags);
				}
			}
			if ($acnt == 0 && !isset($this->par['cb_show_empty'])) {
				do {
					array_pop($this->data);
				} while (count($this->data) > $emp_start);
				$cnt = $emp_start;
				$this->data[$cnt++] = array($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'], "no data",
													 "-","--:--","-","--:--",
													 " ", $flags);
			}				// end if no data for this employee
		}
	}
	
	public function write2CSV () {
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
		foreach ($this->data as $line) {
			$out = '';
			for ($cnt=0;$cnt<count($line)-1;$cnt++) {
				$out .= '"'.$line[$cnt].'",';
			}
			$out .= '"'.$line[$cnt].'"';
			$out .= "\n";
			fwrite ($this->fhandle, $out);
		}		
	}
	
	public function write2HTML() {
	
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
//	Columns: PayID, Dept, Team, Name, Date, Arrive, Start, Break Out/In, Transfer Out/In, Stop, Depart, Location, Flags
		$old_emp = '';
		$old_dep = '';
		$old_team = '';
		foreach ($this->data as $line) {
			$out = '';
			if ($old_dep <> $line[1] || $old_team <> $line[2] || $old_emp <> $line[3]) {
				$out .= '<tr><td class="detail">'.$line[0].'</td>';
			} else {
				$out .= '<tr><td class="detail">&nbsp</td>';
			}
			if ($old_dep <> $line[1]) {				// new department -> show the name
				$out .= "<td class=\"detail\">".$line[1]."</td>";
			} else {
				$out .= "<td class=\"detail\">&nbsp;</td>";
			}
			if ($old_team <> $line[2]) {				// new team -> show the name
				$out .= "<td class=\"detail\">".$line[2]."</td>";
			} else {
				$out .= "<td class=\"detail\">&nbsp;</td>";
			}
			if ($old_emp <> $line[3]) {				// first line for this employee -> show 
				$out .= "<td class=\"detail\">".$line[3]."</td>";
			} else {
				$out .= "<td class=\"detail\">&nbsp;</td>";
			}
			for ($cnt = 4;$cnt < count($line);$cnt++) {
				if ($cnt == count($line)-1) {
					$out .= $this->getFlagCell($line[$cnt], 'detail');
				} else {
					$out .= "<td class=\"detail\">".$line[$cnt]."</td>";
				}
			}
			$out .= "</tr>".$CRLF;
//			var_dump($out);
			fwrite($this->fhandle, $out);
			$old_dep = $line[1];
			$old_team = $line[2];
			$old_emp = $line[3];
		}
		fwrite($this->fhandle,"</table>".$CRLF);
		// write the footer
		$this->writeReportFooter();
	}

}

?>
