<?php

require_once("classes/subdbobject.php");

class LeaveType extends SubDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Leave Type";
		$this->idcol = "leave_type_id";
		$this->tablename = "leave_types ";
		$this->sql_fields = 'SELECT leave_type_id, company_id, name, description, isPaid, isAWOL, isAnnual, needsNote, user_level, approver_level ';
		$this->sql_from = ' FROM leave_types l ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT l.leave_type_id ';
		$this->subject_id = 14;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 14 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE l.company_id = '.$this->page->company['company_id'];
		return $sql;
	}

	public function checkData() {
	
		$test = $this->control->checkPOST($this);
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
				$sql .= ',company_id) VALUES (';
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
				$sql .= ",".$this->page->company['company_id'].");";
			} else {
				$sql .= ',';
			}
		}
		$this->dbc->exec($sql);
		// now we also need to update the employee record to reflect the new leave (only if this is annual leave). 
		$sql = "SELECT max(".$this->idcol.") as new_id FROM ".$this->tablename." WHERE company_id=".$this->page->company['company_id'];
		$data = $this->dbc->query($sql);
		$this->page->ctrl['record'] = $data[0]['new_id'];
		$this->loadNavNumbers($this->page->ctrl['record']);
	}
	
	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Leave Type";
		}
		return $this->data[0]['name'];
	}
	
	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Notices</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>This will show some general notices about leave applications and escalation.</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Block periods</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>This will show all applicable block periods.</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	

	}
	public function activities() {
	
		$rec = $this->page->ctrl['record'];
		$dis = $this->page->ctrl['display'];
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','edit');\">Edit</a></td>";
		$out .= "		      <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all leave types</a></td></tr>\n";
		$out .= "		  <tr><td>&nbsp;</td>\n";
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Config</a></td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>