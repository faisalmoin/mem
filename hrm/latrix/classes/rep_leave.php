<?php
/*
	Leave Report.
	
	The leave report shows the following columns:
	
	Department, team, employee name, leave type, start_date, end_date, work_days, annual_days, submit_date, approved, approver, approval date, note
	
	There is basically no processing of data happening. All the data is loaded in from the database as required.
	Subtotals are calculated for the number of days taken (annual and total).
	The processing just prepares the final data set ready for output.
*/
class Report extends ReportBase {

	public function __construct(&$db_conn, $par, $config, $err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->headers = array("PayID","Dept.","Team","Empl.","OK","Note","Type","From","To","Days","Allow.","submitted","Approved by");
//		$this->ltypes = $this->dbc->query("SELECT * from leave_types WHERE company_id=".$this->config->company['company_id']);
		$this->page_title = 'Leave Report';
		$this->today = date('Y-m-d');
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
			$this->loadLeave($cnt, $this->days[0], $this->days[count($this->days)-1], true);
			}
	}
	
	public function process() {
	
		$cnt = 0;
		foreach ($this->emps as $emp) {
			$total_days = 0;
			$total_leave = 0;
			$lcnt = 0;
			while ($lcnt < count($emp['leave'])) {
//				var_dump($emp['leave']);
				if ($emp['leave'][$lcnt]['half_day'] == 1) {
					$days = 0.5;
					if ($this->isAnnual($emp['leave'][$lcnt])) {
						$leave = 0.5;
					} else {
						$leave = 0;
					}
				} else {
					$days = $this->getWorkDays($emp['leave'][$lcnt]['start_date'],$emp['leave'][$lcnt]['end_date']);
					if ($this->isAnnual($emp['leave'][$lcnt])) {
						$leave = $days;
					} else {
						$leave = 0;
					}
				}
				if ($emp['leave'][$lcnt]['approved'] == 1) {
					$approved = 'Yes';
				} else {
					$approved = 'No';
				}
				$total_days += $days;
				$total_leave += $leave;
				$this->data[$cnt++] = array($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'], 
													$approved,$emp['leave'][$lcnt]['note'],
													$emp['leave'][$lcnt]['name'],
													$emp['leave'][$lcnt]['start_date'],
													$emp['leave'][$lcnt]['end_date'],
													$days,
													$leave,
													$emp['leave'][$lcnt]['submit_date'],
													$emp['leave'][$lcnt]['approver']);
//				var_dump($this->data[$cnt-1]);
				$lcnt++;
			}						// end while leave exists for employee -> produce totals.
			if ($total_days > 0 || isset($this->par['cb_show_empty'])) {
				$this->data[$cnt++] = array ($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'].'(Total)', 
														'','','','','',$total_days, $total_leave,
														'','','');
			}
		}							// end for all employees, no grand totals. 
		if (count($this->data) == 0) {
			$this->error->add("There is no data within the range of selected parameters");
		}
	}
	
	private function getWorkDays($start,$end) {
		$date = strtotime($start);
		$last = strtotime($end);
//		echo ($start.'/'.$date.'/'.$end.'/'.$last);
		$cnt = 0;
		while ($date <= $last) {
			$info = getdate($date);
			if ($info['weekday'] != 'Sunday' && $info['weekday'] != 'Saturday' && !$this->isHoliday($date)) {
				$cnt++;
			}
			$date += 60*60*24;
		}
		return $cnt;
	}
	
	private function isAnnual(&$app) {
//		var_dump($app);
		foreach($this->ltypes as $ltype) {
			if ($ltype['name'] == $app['name']) {
				return ($ltype['isAnnual']);
			}
		}
		return 0;
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
//		"PayID","Dept.","Team","Empl.","Type","From","To","Days","Allow.","submitted","OK","by"
// at the moment this will always write department team and employee name, plus all details.
// in the future we will probably need the ability to suppress repeating text 
// plus possibly another option to only show summary data.
		foreach ($this->data as $line) {
			fwrite ($this->fhandle, '"'.$line[0].'",');		//Payroll ID
			fwrite ($this->fhandle, '"'.$line[1].'",');		//Department
			fwrite ($this->fhandle, '"'.$line[2].'",');		//Team
			fwrite ($this->fhandle, '"'.$line[3].'",');		//Employee
			fwrite ($this->fhandle, '"'.$line[4].'",');		//Approved 
			fwrite ($this->fhandle, '"'.$line[5].'",');		//Note
			fwrite ($this->fhandle, '"'.$line[6].'",');		//Leave Type
			fwrite ($this->fhandle, '"'.$line[7].'",');		//From
			fwrite ($this->fhandle, '"'.$line[8].'",');		//To
			fwrite ($this->fhandle, $line[9].',');				//Work Days
			fwrite ($this->fhandle, $line[10].',');				//Annual Leave Days
			fwrite ($this->fhandle, '"'.$line[11].'",');		//Submit date
			fwrite ($this->fhandle, '"'.$line[12].'",');		//Approval date
			fwrite ($this->fhandle, '"'.$line[13].'"');		//Approver
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
		$out .= "<tr><td class=\"bluehead\" colspan='".count($this->headers)."'>".$this->rep_title."</td></tr>".$CRLF;
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
//		"PayID","Dept.","Team","Empl.","Type","From","To","Days","Allow.","submitted","OK","by"
			if (isset($this->par['cb_show_details'])) {
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
					if ($cnt == 5) {
						if ($line[$cnt] != '') {
							$out .= "<td class=\"detail\"><span title=\"".$line[$cnt]."\">X</span></td>";
						} else {
							$out .= "<td class=\"detail\">&nbsp;</td>";
						}
					} else {
						$out .= "<td class=\"detail\">".$line[$cnt]."</td>";
					}
				}
				$out .= "</tr>".$CRLF;
			} else {													// show summary lines only
							// still need to implement the show_subtotals and showtotals options.
				if ($line[4] == '') {
					$out .= "<tr>";
					for ($cnt = 0; $cnt < count($line); $cnt++) {
						$out .= "<td class=\"detail\">".$line[$cnt]."</td>";
					}
					$out .= "</tr>".$CRLF;
				}
			}
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