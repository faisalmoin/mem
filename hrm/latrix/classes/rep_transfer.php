<?php
/*
	Transfer Report.
	
	The transfer report shows the following columns:
	
	Department, team, employee name, transfer date, location out, time_out, time_in, location in, transfer time
	
	There is basically no processing of data happening. All the data is loaded in from the database as required.
	The processing just prepares the final data set ready for output.
*/
class Report extends ReportBase {

	public function __construct(&$db_conn, &$par, &$config, &$err) {
		parent::__construct($db_conn, $par, $config, $err);
		$this->headers = array("PayID","Dept.","Team","Empl.","Date","From","Time out","Time in","To","Transfer Time");
		$this->page_title = 'Transfer Report';
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
			$this->loadRawPresence($cnt, $this->days[0], $this->days[count($this->days)-1] );
			}
	}
	
	public function process() {
	
		$cnt = 0;
		foreach ($this->emps as $emp) {
			$lcnt = 0;
			$total_time = 0;
			while ($lcnt < count($emp['pres'])) {
//				var_dump($emp['pres']);
				/*
					This a bit of an odd one, as transfers are spread over two presence records.
					The first record gives the transfer out data, the second the transfer in data.
					The second record can also be the start for the next transfer.
					We can safely ignore all records that do not have transfer type.
				*/
				if ($emp['pres'][$lcnt]['end_type'] == 'Transfer Out') {
					if ($lcnt+1 < count($emp['pres']) && $emp['pres'][$lcnt+1]['start_type'] == 'Transfer In') {
						$time_in = $emp['pres'][$lcnt+1]['start_time'];
						$loc_in = $emp['pres'][$lcnt+1]['name'];
						$transfer_time = $this->time2secs($time_in) - $this->time2secs($emp['pres'][$lcnt]['end_time']);
						$total_time += $transfer_time;
					} else {
						$time_in = '-A-';
						$loc_in = 'N/A';
						$transfer_time = 0;
					}
//	"PayID","Dept.","Team","Empl.","Date","From","Time out","Time in","To","Transfer Time"
					$this->data[$cnt++] = array($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'], 
														$emp['pres'][$lcnt]['att_date'],
														$emp['pres'][$lcnt]['name'],
														$emp['pres'][$lcnt]['end_time'],
														$time_in, $loc_in,
														$this->secs2time($transfer_time));
				}
//				var_dump($this->data[$cnt-1]);
				$lcnt++;
			}						// end while leave exists for employee -> produce totals.
			if ($total_time > 0 || isset($this->par['cb_show_empty'])) {
				$this->data[$cnt++] = array ($emp['payroll'], $emp['dep'], $emp['team'], $emp['name'].'(Total)', 
														'','','','','',$this->secs2time($total_time));
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
//		"Dept.","Team","Empl.","Type","From","To","Days","Allow.","submitted","OK","by"
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
//	"PaydID","Dept.","Team","Empl.","Date","From","Time out","Time in","To","Transfer Time"
			if (isset($this->par['cb_show_details'])) {
				if ($old_dep <> $line[1] || $old_team <> $line[2] || $old_emp <> $line[3]) {
					$out .= '<tr><td class="detail">'.$line[0].'</td>';
				} else {
					$out .= '<tr><td class="detail">&nbsp</td>';
				}
				if ($old_dep <> $line[1]) {				// new department -> show the name
					$out .= "<tr><td class=\"detail\">".$line[1]."</td>";
				} else {
					$out .= "<tr><td class=\"detail\">&nbsp;</td>";
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