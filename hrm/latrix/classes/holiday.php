<?php

require_once("classes/dbobject.php");

class Holiday extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Holiday";
		$this->idcol = "holiday_id";
		$this->tablename = "holidays";
		$this->sql_fields = 'SELECT h.name, h.hdate';
		$this->sql_from = ' FROM holidays h ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT h.holiday_id ';
		$this->subject_id = 6;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 6 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		// the number of records available for navigation depends on the user level. The employee himself can only see one record (his own).
		// the manager can see everyone in the department
		// the admin and everybody else can see everyone in the company.
		switch ($this->page->config['user_level']) {
			case lu_manager:
			case lu_employee:
			case lu_admin:
			case lu_gm:
			case lu_owner:
				$sql = ' WHERE h.company_id = '.$this->page->company['company_id'];
		}
		return $sql;
	}

	public function checkData() {
	
		// need to parse all the POST data through various checkers using the data_columns. String length is not a problem, though.
		// e.g. numbers must only have digits, e-mail addresses must have a "@" and a ".".
		return $this->control->checkPOST($this);
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Holiday";
		}
		return $this->data[0]['name'];
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Dept. Attendance</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Attendance Graph will show here.</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Dept. Lateness</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Lateness Graph will show here.</td></tr>\n";
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
		if ($this->page->config['user_level'] > la_employee) {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
			$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>