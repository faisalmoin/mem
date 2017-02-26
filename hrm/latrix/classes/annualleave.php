<?php

require_once("classes/empdbobject.php");

class AnnualLeave extends EmpDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Leave Allowance";
		$this->idcol = "annual_leave_id";
		$this->tablename = "annual_leave ";
		$this->sql_fields = 'SELECT a.annual_leave_id, a.allowance, a.leave_left, a.year_id, a.emp_id ';
		$this->sql_from = ' FROM annual_leave a ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT a.annual_leave_id ';
		$this->subject_id = 20;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 20 AND editable = 1");
		$this->leavediff = 0;
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE a.emp_id = '.$this->page->ctrl['subrecord'];
		return $sql;
	}

	public function checkData() {
	
		$test = $this->control->checkPOST($this);
		$sql = "SELECT count(*) as years FROM annual_leave WHERE emp_id = ".$this->page->ctrl['subrecord']." AND year_id=".$this->data[0]['year_id'];
		if (isset($this->data[0]['annual_leave_id'])) {
			$sql .= " AND annual_leave_id <> ".$this->data[0]['annual_leave_id'];
		}
		$data = $this->dbc->query($sql);
		if ($data[0]['years'] > 0) {
			$test = false;
			$this->error->add("You can only have one annual leave allowance per business year for each employee.");
		}
		// If this is an update, then we need the old saved data to calculate the difference and perform some 
		// more checks
		if (isset($this->data[0]['annual_leave_id'])) {
			$sql = "SELECT * FROM business_years WHERE business_year_id=".$this->data[0]['year_id'];
			$bus_year = $this->dbc->query($sql);
			if ($bus_year[0]['year_end'] < date('Y-m-d')) {
				$test = false;
				$this->error->add("You cannot edit leave allowances for business years in the past.");
				return $test;
			}	
		
			$sql = $this->sql_fields.$this->sql_from." WHERE a.annual_leave_id =".$this->data[0]['annual_leave_id'];
			$old = $this->dbc->query($sql);
			$this->leave_diff = $this->data[0]['allowance'] - $old[0]['allowance'];
			var_dump($this->leave_diff);
			
			if ($this->leave_diff + $old[0]['leave_left'] < 0) {
				$test = false;
				$this->error->add("You cannot reduce the annual leave below the level of reamining leave.");
			} else {
				$this->data[0]['leave_left'] += $this->leave_diff;
			}
		}
		return $test;
	}
	
	public function add() {
		// build the SQL string for the new record from the POST and execute it. The change the current control settings to point to the new
		// record and reload the object;
		$sql = "INSERT INTO ".$this->tablename." (";
		$last = $this->columns[count($this->columns)-1]['db_name'];
		foreach($this->columns as $col) {
			$sql .= $col['db_name'];
			if ($last == $col['db_name']) {
				$sql .= ',leave_left, emp_id) VALUES (';
			} else {
				$sql .= ',';
			}
		}
		foreach ($this->columns as $col) {
			switch($col['type']){
				case 'D':	//Date, Time, Char, Password, Image all need quotes around the value
				case 'T':
				case 'C':
				case 'P':
				case 'I':
					$sql .= "'".$this->data[0][$col['db_name']]."'";
					break;
				case 'N':	// Number, checkBox, Select, Radio don't need quotes
				case 'B':
				case 'S':
				case 'R':
					$sql .= $this->data[0][$col['db_name']];
					break;
			}
			if ($col['db_name'] == $last) {
				$sql .= ",".$this->data[0]['allowance'].",".$this->page->ctrl['subrecord'].");";
			} else {
				$sql .= ',';
			}
		}
//		var_dump($sql);
		$this->dbc->exec($sql);
		$sql = "SELECT max(".$this->idcol.") as new_id FROM ".$this->tablename." WHERE emp_id=".$this->page->ctrl['subrecord'];
		$data = $this->dbc->query($sql);
		$this->page->ctrl['record'] = $data[0]['new_id'];
		$this->loadNavNumbers($this->page->ctrl['record']);
	}
	
	public function save() {
		parent::save();
		if ($this->leave_diff != 0) {
			$sql = "UPDATE annual_leave SET leave_left =".$this->data[0]['leave_left'];
			$sql .= " WHERE annual_leave_id = ".$this->data[0]['annual_leave_id'];
			$this->dbc->exec($sql);
			$this->error->debug($sql);
		}
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Leave Allowance";
		}
		return "Leave Allowance for ".$this->page->ctrl['title'];
	}
	
	public function activities() {
	
		$rec = $this->record;
		$dis = $this->page->ctrl['display'];
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','edit');\">Edit</a></td>";
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Employee</a></td></tr>\n";
		if ($this->page->ctrl['record'] != 0) {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','del');\">Remove this allowance</a></td>";
			$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all allowances</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>