<?php
/*
	Exception Report.
	
	The exception report shows the following columns:
	
	Department, team, employee name, exception_date, start_time, end_time, total time, submit_date, approved, approver, approval date, reason
	
	There is basically no processing of data happening. All the data is loaded in from the database as required.
	The processing just prepares the final data set ready for output.
*/
class Report extends ReportBase {

	public function __construct(&$db_conn, $par, $config, $err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->headers = array("PayID","Dept.","Team","Empl.","Date","From","To","Time","submitted","OK","Approved by","Reason");
		$this->page_title = 'Exception Report';
	}

	public function initialise() {

		$this->loadEmployees(); 
		$this->loadDateRange();			// this is only required to establish the first and the last day, so that
												// the loadLeave can work. Best to use this as the user may select a weird
												// collection of weeks or months.
		if ($this->error->isEmpty() == false) {
			return;
		}
		for($cnt=0; $cnt<count($this->emps);$cnt++) {
			//now load the leave data
			$this->loadExceptions($cnt, $this->days[0], $this->days[count($this->days)-1] );
			}
	}
	
	public function process() {
	
		$cnt = 0;
		foreach ($this->emps as $emp) {
			$lcnt = 0;
			$exc_time = 0;
			while ($lcnt < count($emp['exc'])) {
//				var_dump($emp['leave']);
				if ($emp['exc'][$lcnt]['approved'] == 1) {
					$approved = 'Yes';
				} else {
					$approved = 'No';
				}
				$exc_time += $emp['exc'][$lcnt]['exc_length'];
				$this->data[$cnt++] = array($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'], 
													$emp['exc'][$lcnt]['exception_date'],
													$emp['exc'][$lcnt]['start_time'],
													$emp['exc'][$lcnt]['end_time'],
													$this->secs2time($emp['exc'][$lcnt]['exc_length']),
													$emp['exc'][$lcnt]['submit_date'],
													$approved,
													$emp['exc'][$lcnt]['approver'],
													$emp['exc'][$lcnt]['reason']);
//				var_dump($this->data[$cnt-1]);
				$lcnt++;
			}						// end while leave exists for employee -> produce totals.
			if ($exc_time > 0 || isset($this->par['cb_show_empty'])) {
				$this->data[$cnt++] = array ($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'].'(Total)', 
														'','','',$this->secs2time($exc_time),
														'','','','');
			}
		}							// end for all employees, no grand totals.
		if (count($this->data) == 0) {
			$this->error->add("There is no data within the range of selected parameters");
		}
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
//		"Dept.","Team","Empl.","Date","From","Time","To","submitted","OK","Approved by","Reason"
// at the moment this will always write department team and employee name, plus all details.
// in the future we will probably need the ability to suppress repeating text 
// plus possibly another option to only show summary data.
		foreach ($this->data as $line) {
		$out = '';
			for ($cnt=0;$cnt < count($line)-1;$cnt++) {
				$out .= '"'.$line[$cnt].'",';
			}
			$out .= '"'.$line[$cnt].'"\n';
			fwrite($this->fhandle, $out);
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
//		"PayID","Dept.","Team","Empl.","Date","From","Time","To","submitted","OK","Approved by","Reason"
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
					$out .= "<td class=\"detail\">".$line[$cnt]."</td>";
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