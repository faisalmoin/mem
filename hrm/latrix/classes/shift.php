<?php

require_once("classes/dbobject.php");

class Shift extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Shift";
		$this->idcol = "shift_id";
		$this->tablename = "shifts";
		$this->sql_fields = 'SELECT s.name, s.description, s.start_time, s.end_time';
		$this->sql_from = ' FROM shifts s ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT s.shift_id ';
		$this->subject_id = 5;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 5 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE s.company_id = '.$this->page->company['company_id'];
		return $sql;
	}

	public function checkData() {
	
		return $this->control->checkPOST($this);
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Shift";
		}
		return $this->data[0]['name'];
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Dept. Attendance</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Graphical representation of the shift will show here.</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Dept. Lateness</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Some usage data about the shift will show here</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	

	}
	public function activities() {
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','edit');\">Edit</a></td></tr>\n";
		if ($this->page->config['user_level'] > 'la_employee') {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
			$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>