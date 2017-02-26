<?php

require_once("classes/dbobject.php");

class Block extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Block Period";
		$this->idcol = "block_id";
		$this->tablename = "blocks";
		$this->sql_fields = 'SELECT b.block_id, b.reason as name, b.block_end, b.block_start';
		$this->sql_from = ' FROM blocks b ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT b.block_id ';
		$this->subject_id = 15;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 15 AND editable = 1");
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
				$sql = ' WHERE b.company_id = '.$this->page->company['company_id'];
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
			return "New Block Period";
		}
		return $this->data[0]['name'];
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Block Period Calendar</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Show a list of departments linked to the current block period</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Block Period Distribution</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Show a diagram of periods over the year.</td></tr>\n";
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
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td></tr>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','block_apply');\">Apply to Teams/Departments/etc.</a></td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>