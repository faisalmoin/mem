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
//		$this->ltypes = $this->dbc->query("SELECT * from leave_types WHERE company_id=".$this->config->company['company_id']);
		$this->page_title = 'ID Cards Report';
	}

	public function initialise() {

		$this->loadEmployees(); 
	}
	
	public function process() {
	
	}
	
	protected function write2CSV (){
		// overrides the function in reportbase.php for more detailed exporting (string enclosures, etc.)
		$this->error->add('The ID Card Report cannot be exported to CSV.');
	}

	protected function write2HTML() {

		$fheader = fopen('include/idcard-header.php', 'r');
		$buffer = fread($fheader,filesize('include/idcard-header.php'));
		if (!fwrite($this->fhandle,$buffer)) {
			$this->error->add('Could not write to the temporary file, contact system administrator');
			return false;
		}
		if (!isset($this->emps) || count($this->emps) == 0) {
			$this->error->add('There is nothing to report on here.');	
		} else {
			//build the cards. Each card is in a cell of a table with two columns.
			$cnt=1;
			$out = '';
			foreach ($this->emps as $row) {
				if ($cnt%2 == 1) {
					$out .= "<tr><td style=\"width: 50%;\">\n";
				} else {
					$out .= "<td style=\"width: 50%;\">\n";
				}
				$out .= "<div class=\"cardframe\">\n";
				$out .= "<p class=\"emp-name\">".$row['name']."</p>\n";
				$out .= "<p class=\"dep-name\">Team : ".$row['team']."<br>\n";
				$out .= "Department : ".$row['dep']."<br>\n";
				$out .= "Location : ".$row['loc']."</p>\n";
		//		echo "<p class=\"key-code\">*".$row['keycode']."*</p>\n";
				$out .= "<p><img src=\"../include/barcode.php?keycode=".strtoupper($row['keycode'])."&amp;hide=1\" alt=\"not 
found\">"; 
				$out .= "</p>";
				$out .= "<p class=\"note\">This ID card is property of ".$this->config->company['name'].". If found, please call ".$this->config->company['contact_phone'].".</p>\n";
				if ($cnt%2 == 1) {
					$out .= "</div></td>\n";
				} else {
					$out .= "</div></td></tr>\n";
				}
				$cnt++;
			}
			if ($cnt%2 != 1) {
					$out .= "<td style=\"width: 50%;\"></td></tr>\n";
			}
		}
		$out .= '</table></body></html>';
		fwrite($this->fhandle, $out);
	}
}

?>
