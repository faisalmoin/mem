<?php

require_once("classes/empdbobject.php");
require_once("classes/leavetype.php");

class HalfDay extends EmpDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Half Day Off";
		$this->idcol = "half_day_id";
		$this->tablename = "emp_half_days ";
		$this->sql_fields = 'SELECT eh.half_day_id, eh.half_date, eh.start_time, eh.submit_date, eh.approved, eh.approved_by, ';
		$this->sql_fields .= "eh.approval_date, eh.type_id, eh.emp_id ";
		$this->sql_from = ' FROM emp_half_days eh ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT eh.half_day_id ';
		$this->subject_id = 20;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 21 AND editable = 1");
		$sql = "SELECT hdate from holidays where company_id = ".$this->page->config['company_id'];
		$this->hdays = $this->dbc->query($sql);
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE eh.emp_id = '.$this->page->ctrl['subrecord'];
		return $sql;
	}

	public function checkData() {
		$test = $this->control->checkPOST($this);
		// test 1 check for overlap with any existing leave application
		$sql = "SELECT count(*) as cnt FROM emp_leave WHERE '".$this->data[0]['half_date']."' BETWEEN start_date AND end_date
				  AND emp_id =".$this->page->ctrl['subrecord'];
		$data = $this->dbc->query($sql);
		if ($data[0]['cnt'] > 0 ) {
			$test = false;
			$this->error->add("This application overlaps with an existing leave application and can therefore not be processed.");
		}
		// test 2 check for overlap with an existing half-day application
		$sql = "SELECT count(*) as cnt FROM emp_half_days WHERE '".$this->data[0]['half_date']."' = half_date
				  AND emp_id=".$this->page->ctrl['subrecord'];
		$data = $this->dbc->query($sql);
		if ($data[0]['cnt'] > 0 ) {
			$test = false;
			$this->error->add("This application overlaps with an existing half-day application and can therefore not be processed.");
		}
		// test 3 enough leave left
		$this->ltype = new LeaveType($this->page, $this->dbc, $this->error);
		$this->ltype->load($this->data[0]['type_id']);
		if ($this->ltype->data[0]['isAnnual'] == 1) {
			$sql = "SELECT a.leave_left FROM annual_leave a INNER JOIN business_years b ON a.year_id = b.business_year_id ";
			$sql .= "WHERE a.emp_id = ".$this->page->ctrl['subrecord']." AND b.year_start < '".$this->data[0]['half_date']."'";
			$sql .= " AND b.year_end > '".$this->data[0]['half_date']."'";
			$result = $this->dbc->query($sql);
			$rem_leave = $result[0]['leave_left'];
			if ($rem_leave == 0) {
				$test = false;
				$this->error->add("You need at least 1 day of annual leave, but you haven't got it. Sorry, dude!");
			}
		}
		// test 4 holidays
		if ($this->isHoliday($this->data[0]['half_date'])) {
			$test = false;
			$this->error->add("This application falls on a holiday. Unless you work on holidays, this cannot be accepted.");
		}
		// test 5 weekend
		$info = date('l',strtotime($this->data[0]['half_date']));
		if ($info == 'Sunday' || $info == 'Saturday') {
			$test = false;
			$this->error->add("This application is on a weekend. Unless you work on weekends, this cannot be accepted.");
		}
		// test 6 in the past
		if(strtotime($this->data[0]['half_date']) < (time()-86400)) {
			$test = false;
			$this->error->add("This application is in the past. You cannot apply for an exception in the past.");
		}
		return $test;
	}
	
	private function isHoliday(&$value) {
		$date = date('Y-m-d', $value);
		foreach ($this->hdays as $hday) {
			if ($date == $hday) { return true; }
		}
		return false;
	}
	
	public function add() {
	
		$keystring = ',emp_id, submit_date, approved';
		$values = $this->page->ctrl['subrecord'].", curdate(), 0";
		$where = " WHERE emp_id=".$this->page->ctrl['subrecord']; 
		$this->add2db($keystring, $values, $where);
		$this->updateEmployee();
	}

	private function updateEmployee() {
	//only execute this for a new application !!
		if ($this->ltype->data[0]['isAnnual'] == 1){
			$sql = "UPDATE annual_leave a, business_years b SET a.leave_left = a.leave_left - 0.5 ";
			$sql .= " WHERE a.emp_id =".$this->page->ctrl['subrecord']." AND a.year_id = b.business_year_id AND b.year_start<='".$this->data[0]['half_date']."'";
			$sql .= " AND b.year_end >= '".$this->data[0]['half_date']."'";
			$this->dbc->exec($sql);
		}
	}

	public function delete() {
		// delete the current record from the database and move to the next. If this was the last record, move to the previous.
		$this->ltype = new LeaveType($this->page, $this->dbc, $this->error);
		$this->ltype->load($this->data[0]['type_id']);
		if ($this->checkDependencies() == true ) {
			$sql = "DELETE FROM ".$this->tablename." where ".$this->idcol." = ".$this->page->ctrl['record'];
			$this->dbc->exec($sql);
			$sql = "UPDATE annual_leave a, business_years b SET a.leave_left = a.leave_left + 0.5 ";
			$sql .= " WHERE a.emp_id =".$this->page->ctrl['subrecord']." AND a.year_id = b.business_year_id AND b.year_start<='".$this->data[0]['half_date']."'";
			$sql .= " AND b.year_end >= '".$this->data[0]['half_date']."'";
			$this->dbc->exec($sql);
		}
	}
	
	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Half Day Off";
		}
		return "Half Day Off for ".$this->page->ctrl['title'];
	}
	
	public function approve() {
		$sql = "UPDATE emp_half_days SET approved = 1, approval_date = curdate(), approved_by=".$this->page->config['user_id'];
		$sql .= " WHERE half_day_id=".$this->data[0]['half_day_id'];
		$this->dbc->exec($sql);
	}
	
	public function decline() {
		$sql = "UPDATE emp_half_days SET approved = 0, approval_date = curdate(), approved_by=".$this->page->config['user_id'];
		$sql .= " WHERE half_day_id=".$this->data[0]['half_day_id'];
		$this->dbc->exec($sql);
	}

	public function activities() {
	
		$rec = $this->page->ctrl['record'];
		$dis = $this->page->ctrl['display'];
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','edit');\">Edit</a></td>";
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Employee</a></td></tr>\n";
		if ($this->page->ctrl['record'] != 0) {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','del');\">Remove this allowance</a></td>";
			$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all allowances</a></td></tr>\n";
			if ($this->page->config['user_level'] > lu_employee && $this->page->config['user_id'] != $this->data[0]['emp_id']) {
				$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','approve')\">Approve this application</a></td>"; 
				$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','decline')\">Decline this application</a></td></tr>\n";
			}
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>