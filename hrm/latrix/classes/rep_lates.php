<?php
/*
	Lateness Report.
	
	The lateness report shows the following columns:
	
	Department, team, employee name, date, expected start/end/hours, real start/end/hours, difference, lateness, reason, flags
	
	There is tons of heavy data processing happening here. 
	Subtotals are calculated for each employee, team and department.

*/
class Report extends ReportBase {

	public function __construct(&$db_conn, $par, $config, $err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->sheaders =  array("Expected","Real");
		$this->headers = array("PayID","Dept./Team/Empl.","Date","Start","End","Hours","Start","End","Hours","Diff.","Lates","Reason","Flags");
		$this->page_title = 'Lateness Report';
		$this->today = date('Y-m-d');
		$this->subEmp['req_time'] = 0;
		$this->subEmp['real_time'] = 0;
		$this->subEmp['diff'] = 0;
		$this->subEmp['late'] = 0;
		$this->subTeam['req_time'] = 0;
		$this->subTeam['real_time'] = 0;
		$this->subTeam['diff'] = 0;
		$this->subTeam['late'] = 0;
		$this->subDept['req_time'] = 0;
		$this->subDept['real_time'] = 0;
		$this->subDept['diff'] = 0;
		$this->subDept['late'] = 0;
		$this->subComp['req_time'] = 0;
		$this->subComp['real_time'] = 0;
		$this->subComp['diff'] = 0;
		$this->subComp['late'] = 0;
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
		for($cnt=0; $cnt<count($this->emps);$cnt++) {
			//now load the leave data
			$this->loadLeave($cnt, $this->days[0], $this->days[count($this->days)-1],false );
			$this->loadExceptions($cnt, $this->days[0], $this->days[count($this->days)-1] );
			$this->loadShifts($cnt, $this->days[0], $this->days[count($this->days)-1] );
			$this->loadAttendance($cnt, $this->days[0], $this->days[count($this->days)-1] );
			}
	}
	
	public function process() {
	
		$emp_cnt = 0;		// employee index
		$cnt = 0;			// output index
		foreach ($this->emps as $emp) {
			$scnt = 0;		// shift index
			$acnt = 0;		// attendance index
			$empty_days = 0;
			$emp_start = $cnt;
			foreach($this->days as $day) {
			/*
			1) we need to calculate the expected start and end time. This will come from the shift information.
				If there are any exception records or half_day leave records, they reduce the required attendance.
				However, if the employee is on approved leave or if this is a public holiday, then the expected
				work hours are 00:00 and the times default to "--:--" (only for full leave days !!).
				For full leave days set the "L" flag. For holidays set the "H" flag. For default shifts set the "D" flag.
				For half leave days set the "HD" flag. For an exception set the "E" flag. Default weekend shift = "W".
				Has taken a break = "B". Has been AWOL = "A"
				Any dates in the future get the additional "F" flag.
				If the employee is on leave or has an approved exception record, set the reason from the note.
			*/
				$flags = '';
				$reason = '';
				while ($day > $emp['shifts'][$scnt]['shift_date'] && $scnt < count($emp['shifts'])) {
					$scnt++;
					if ($day == $emp['shifts'][$scnt]['shift_date']) { break; }
				}
				if ($day == $emp['shifts'][$scnt]['shift_date']) {
					$shift =& $emp['shifts'][$scnt++];
				} else {
					if ($this->isWeekend($day)) {
						$shift =& $this->default_shift_wend[0];
						$flags .= 'W';
					} else {
						$shift =& $this->default_shift[0];
						$flags .= 'D';
					}
				}
				$day_start = $shift['start_time'];
				$day_end = $shift['end_time'];
				$day_length = $shift['shift_length'];	// number of seconds !!
				if ($day_length > $this->time2secs($this->config->company['default_hours'])) {
					// for most normal days this deducts the break hours. 
					// Future : may need a separate value for the default break length
					$day_length = $this->time2secs($this->config->company['default_hours']);
				}
				if ($this->isHoliday($day)) {
					$flags .= 'H';
					$day_length = 0;
					$day_start = '';
					$day_end = '';
				} elseif ($this->isOnLeave($emp, $day)) {
					$flags .= 'L';
					$day_length = 0;
					$day_start = '';
					$day_end = '';
					$reason = $this->getLeaveReason($emp, $day);
				} elseif ($day_start == $day_end) {
					$day_start = '';
					$day_end = '';
				} elseif (($halfday = $this->getHalfDay($emp, $day)) != NULL) {
					$flags .= 'HD';
					$reason = $halfday['note'];
					$day_length = $this->time2secs($this->config->company['default_hours'])/2;
					if ($day_start >= $halfday['start_time']) {
						// add half a day to the start time (which currently is the shift start time, a string value)
						$day_start = $this->secs2time($this->time2secs($day_start) + $this->time2secs($day_length));
					}
					if ($day_end <= $this->secs2time($this->time2secs($halfday['start_time']) + $this->time2secs($day_length))) {
						// remove half a day from the end time
						$day_end = $this->secs2time($this->time2secs($day_end) - $this->time2secs($day_length));
					}
				} elseif (($exc = $this->getException($emp, $day)) != NULL) {
					$flags .= 'E';
					$reason = $exc['reason'];
					$day_length -= $this->time2secs($exc['end_time']) - $this->time2secs($exc['start_time']);
					if ($day_start >= $exc['start_time']) { $day_start = $exc['end_time'];}
					if ($day_end <= $exc['end_time']) { $day_end = $exc['start_time'];} 
				}
//				$this->error->debug('Shift: '.$day_length.','.$this->secs2time($day_length));
			/*
			2) we need to calculate the total attendance time. For this we first get the earliest start time and 
				the latest stop time. This gives us raw attendance. Now we calculate total attendance by taking all
				the breaks into account. If there is no break record, use the default break time. If there is a 
				break record, use it (same if there is more than one, just add up the times). Deduct total break 
				time from raw attendance and we have total attendance. If breaks are present, set the "B" flag.
			*/
				$real_start = '';
				$real_end = '';
				$real_length = 0;
				while ($day > $emp['att'][$acnt]['att_date'] && $acnt < count($emp['att'])) {
					$acnt++;
					if ($day == $emp['att'][$acnt]['att_date']) {
						break;		// we have now found the next attendance record that will match
										// this is required for individual days, where it is possible to have 
										// attendance records for days that are not in the reporting range
					}
				}
				if ($day == $emp['att'][$acnt]['att_date']) {		// yippee, we have an attendance record (or more) 
					$real_start = $emp['att'][$acnt]['start_time'];
					do {
						// add up the attendance times.
						if ($emp['att'][$acnt]['end_time'] > $emp['att'][$acnt]['start_time']) {
							$real_length += $this->time2secs($emp['att'][$acnt]['end_time']) - $this->time2secs($emp['att'][$acnt]['start_time']);
						}
						if ($emp['att'][$acnt]['end_type'] == 5) {
							if (strpos($flags,'B') === false) { $flags .= 'B';}
						}
						if ($emp['att'][$acnt]['end_type'] == 9) {
							if (strpos($flags,'S') === false) { $flags .= 'S';}
						}
						$acnt++;
					} while ($emp['att'][$acnt]['att_date'] == $day);
					$real_end = $emp['att'][$acnt-1]['end_time'];
					if (strpos($flags, 'B') === false) {
						// no breaks were taken, deduct the default break time.
						$def_length = $this->time2secs($this->config->company['default_end_time']) - $this->time2secs($this->config->company['default_start_time']);
						$def_break = $def_length - $this->time2secs($this->config->company['default_hours']);
						$real_length = $real_length - $def_break;
					}
					if ($real_length < 0) { $real_length = 0; }
				} else { 							// oops, no attendance record -> you may have been awol.
					if ($day > $this->today) {	// no problem, this is in the future 
						$flags .= "F";
							$real_start = '-F-';
							$real_end = '-F-';
							$real_length = 0;
							$day_length = 0;
					} else {
						if (strpos($flags,'H') === false && strpos($flags,'L') === false && $day_length > 0){ 
							$flags .= 'A';
							$real_start = '-A-';
							$real_end = '-A-';
							$real_length = 0;
						}
					}
				}
			/*
			3) Now subtract required attendance from total attendance and we have the difference in hours.
				Subtract expected start time from first start time  and we have the lateness.
				Lateness only counts if it is positive (i.e. the employee really was late).
				Lateness and attendance only count if the employee was actually expected to be at work (i.e. the
				flags "L" and "H" are not set.
			*/
				if (!(strpos($flags,'L') === FALSE && strpos($flags,'H') === FALSE) && strpos($flags,'F') === false) {
					$diff_secs = 0;
					$late_secs = 0;
				} else {
					$diff_secs = $real_length - $day_length;
					$late_secs = $this->time2secs($real_start) - $this->time2secs($day_start);
					if ($late_secs < 0) {
						$late_secs = 0;
					}
					if ($late_secs > $day_length) {$late_secs = $day_length;} // can't be more late than what you should have worked.
				}
			/*
			4) Once we have all the figures, produce the output record and update the 3 sets of subtotals.
				Payroll ID, Department, team, employee name, date, expected start/end/hours, real start/end/hours, difference, lateness, reason, flags

			*/
				if ($day_length == 0) {
					$empty_days++;
				}
				$this->data[$cnt++] = array($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'], 
													 $day, $day_start, $day_end, 
													 $this->secs2time($day_length),
													 $real_start,$real_end, 
													 $this->secs2time($real_length),
													 $this->secs2time($diff_secs),
													 $this->secs2time($late_secs),
													 $reason, $flags);
				$cnt += $this->updateSubtotals($day_length, $real_length, $diff_secs, $late_secs);
				if ($day == $this->days[count($this->days)-1]) {
				   if ($empty_days == count($this->days) && !isset($this->par['cb_show_empty'])) {
				   	// not a single day with data to report on -> remove the lot
				   	do {
				   		array_pop($this->data);
				   	} while (count($this->data) > $emp_start);
				   	$cnt = $emp_start;
				   }
					$cnt += $this->printSubtotals($emp_cnt);
				}
			}						// end for all dates in range
			$emp_cnt++;
		}							// end for all employees
	}
	
	private function updateSubtotals($req_time, $real_time, $diff, $late) {
		$this->subEmp['req_time'] += $req_time;
		$this->subEmp['real_time'] += $real_time;
		$this->subEmp['diff'] += $diff;
		$this->subEmp['late'] += $late;
		$this->subTeam['req_time'] += $req_time;
		$this->subTeam['real_time'] += $real_time;
		$this->subTeam['diff'] += $diff;
		$this->subTeam['late'] += $late;
		$this->subDept['req_time'] += $req_time;
		$this->subDept['real_time'] += $real_time;
		$this->subDept['diff'] += $diff;
		$this->subDept['late'] += $late;
		$this->subComp['req_time'] += $req_time;
		$this->subComp['real_time'] += $real_time;
		$this->subComp['diff'] += $diff;
		$this->subComp['late'] += $late;
		}
		
	private function printSubtotals($emp_index) {
		$added = 0;
		$emp =& $this->emps[$emp_index];
		if ($emp_index < count($this->emps)) {
			$next_emp =& $this->emps[$emp_index + 1];
		} else {
			$next_emp = false;
		}
		// end of the employee, print employee subtotals
		$this->data[count($this->data)] = array($emp['payroll'], '','',$emp['name'].'(totals)','','','',
															 $this->secs2time($this->subEmp['req_time']), '','',
															 $this->secs2time($this->subEmp['real_time']),
															 $this->secs2time($this->subEmp['diff']),
															 $this->secs2time($this->subEmp['late']),'','');
		$this->subEmp['req_time'] = 0;
		$this->subEmp['real_time'] = 0;
		$this->subEmp['diff'] = 0;
		$this->subEmp['late'] = 0;
		$added++;
		if ($emp['team'] != $next_emp['team'] || $next_emp == false) {
			//next team is different from this one -> print team subtotals, then reset
			$this->data[count($this->data)] = array('','',$emp['team'].'(totals)','','','','',
																 $this->secs2time($this->subTeam['req_time']),'','',
																 $this->secs2time($this->subTeam['real_time']),
																 $this->secs2time($this->subTeam['diff']),
																 $this->secs2time($this->subTeam['late']),'','');
			$this->subTeam['req_time'] = 0;
			$this->subTeam['real_time'] = 0;
			$this->subTeam['diff'] = 0;
			$this->subTeam['late'] = 0;
			$added++;
			if ($emp['dep'] != $next_emp['dep'] || $next_emp === false) {
				//next department is different from this one -> print department subtotals, then reset
				$this->data[count($this->data)] = array('',$emp['dep'].'(totals)','','','','','',
																	 $this->secs2time($this->subDept['req_time']), '','',
																	 $this->secs2time($this->subDept['real_time']),
																	 $this->secs2time($this->subDept['diff']),
																	 $this->secs2time($this->subDept['late']), '','');
				$this->subDept['req_time'] = 0;
				$this->subDept['real_time'] = 0;
				$this->subDept['diff'] = 0;
				$this->subDept['late'] = 0;
				$added++;
				if ($next_emp === null) {
					$this->data[count($this->data)] = array('','Company totals','','','','','',
																		 $this->secs2time($this->subComp['req_time']), '','',
																		 $this->secs2time($this->subComp['real_time']),
																		 $this->secs2time($this->subComp['diff']),
																		 $this->secs2time($this->subComp['late']), '','');
					$added++;
				}
			}
		}
		return $added;
	}

	protected function write2CSV (){
		// overrides the function in reportbase.php for more detailed exporting (string enclosures, etc.)
		$cnt = 0;
		fwrite($this->fhandle, '"","","","","","Expect.","","","Real","","","","","",""');
		foreach($this->headers as $header) {
			fwrite($this->fhandle, '"'.$header.'"');
			$cnt++;
			if ($cnt < count($this->headers)) {
				fwrite($this->fhandle, ",");
			}
		}
		fwrite($this->fhandle,"\n");
//	PayID, Department, team, employee name, date, expected start/end/hours, real start/end/hours, difference, lateness, reason, flags
// at the moment this will always write department team and employee name, plus all details.
// in the future we will probably need the ability to suppress repeating text 
// plus possibly another option to only show summary data.
		foreach ($this->data as $line) {
			for ($cnt=0;$cnt<count($line)-1;$cnt++){
				fwrite ($this->fhandle, '"'.$line[$cnt].'",');
			}
			fwrite ($this->fhandle, '"'.$line[$cnt].'"\n');
		}		
	}

	protected function write2HTML() {
	
		$CRLF = "\r\n";
		// write the header
		$this->writeReportHeader();
		// write the body
		// first the title bar with the column headers
		$out = "<table width=\"100%\">".$CRLF;
		$out .= "<tr><td class=\"bluehead\" colspan='".count($this->headers)."'>".$this->rep_title."</td></tr>".$CRLF;
		$out .= "<tr>";
		$out .= "<td></td><td></td><td class=\"bluesubhead\" colspan=\"3\">Expected</td><td class=\"bluesubhead\" colspan=\"3\">Real</td>";
		$out .= "<td></td><td></td><td></td><td></td>\n";
		$out .= "</tr><tr>\n";
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
//	PayID, Department, team, employee name, date, expected start/end/hours, real start/end/hours, difference, lateness, reason, flags
// First work out whether to show the line or not

			if ((isset($this->par['cb_show_details']) && $line[1] != '' && $line[2] != '' && $line[3] != '') ||
				 (isset($this->par['cb_show_subtotals']) && $line[1] == '' ) ||
				 (isset($this->par['cb_show_totals']) && $line[1] != '' && $line[2] == '' && $line[3] == '')) {
				$out .= '<tr><td class="detail">';
				$first_col = true;
				if ($old_dep <> $line[1] && $line[1] != '') {				// new department -> show the name
					$out .= $line[0].'</td><td class="detail">';
					$out .= $line[1].' -> ';
					$first_col = false;
				}
				if ($old_team <> $line[2] && $line[2] != '') {				// new team -> show the name
					if ($first_col == true) {
						$out .= $line[0].'</td><td class="detail">';
					}
					$out .= $line[2].' -> ';
					$first_col = false;
				}
				if ($old_emp <> $line[3]) {				// first line for this employee -> show 
					if ($first_col == true) {
						$out .= $line[0].'</td><td class="detail">';
					}
					$out .= $line[3];
					$first_col = false;
				}
				$out .= "</td>";
				if ($first_col == true) {
					$out .= '<td class="detail">&nbsp</td>';
				}
				for ($cnt = 4;$cnt < count($line);$cnt++) {
					$style = 'detail';
					switch ($cnt) {
						case 7:	// real start
						case 8:  // real end
						case 9:	// real hours
							if (ereg("([LHW])",$line[14])) {
								$style = 'detail-green';
							} elseif (ereg("([S])",$line[14])) {
								$style = 'detail-yellow';
							} elseif ($line[8] == '-A-') {
								$style = 'detail-red';
							}
							break;
						case 10:	// difference
							$pos = strpos($line[$cnt],'-');
							if (!($pos === false)) {
								$style = 'detail-orange';
							}
							break;
						case 11:	// lateness
							if (!($line[$cnt] == '  0:00:00')) {
								$style = 'detail-orange';
							}
							break;
					}
					if ($cnt > 4 && $cnt < 13) {
						$value = $this->getShortTime($line[$cnt]);
					} else {
						$value = $line[$cnt];
					}
					if ($value == '  0:00') { $value = ''; }
					if ($cnt == count($line)-1) {
						$out .= $this->getFlagCell($line[$cnt], $style);
					} else {
						$out .= "<td class=\"".$style."\">".$value."</td>";
					}
				}
				$out .= "</tr>".$CRLF;
			}
//			var_dump($out);
			fwrite($this->fhandle, $out);
			$old_dep = $line[1];
			$old_team = $line[2];
			$old_emp = $line[3];
		}
/*
				For full leave days set the "L" flag. For holidays set the "H" flag. For default shifts set the "D" flag.
				For half leave days set the "HD" flag. For an exception set the "E" flag. Default weekend shift = "W".
				Has taken a break = "B". Has been AWOL = "A"
*/		
		$out = "<tr><td colspan=\"".count($this->headers)."\">Legend: D = Default Shift used, W = Default Weekend Shift used,";
		$out .= " L = is on leave, E = is on exception, HD = is on half day leave, B = has taken a break, A = has been AWOL</td></tr>";
		fwrite($this->fhandle,$out.$CRLF);
		fwrite($this->fhandle,"</table>".$CRLF);
		// write the footer
		$this->writeReportFooter();
	}
	
	private function getShorttime($value) {
		$pos = strrpos($value,':');
		if ( $pos === false) {
			return $value;
		} else {
			return substr($value,0,$pos);
		}
	}
	
	private function getHalfDay($emp, $day) {
		if ($emp['leave'] == NULL) { return NULL;}
		foreach ($emp['leave'] as $leave) {
			if ($day == $leave['start_date'] && $leave['half_day'] == 1 && $leave['approved'] == 1) {
				return $leave;
			}
		}
		return NULL;
	}
	
	private function getLeaveReason($emp, $day) {
		foreach ($emp['leave'] as $leave) {
			if ($day >= $leave['start_date'] && $day <= $leave['end_date'] && $leave['approved'] == 1) {
				return $leave['note'];
			}
		}
	}
}

?>