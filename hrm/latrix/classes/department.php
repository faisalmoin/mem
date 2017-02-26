<?php

require_once("classes/dbobject.php");

class Department extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Department";
		$this->idcol = "dept_id";
		$this->tablename = "departments";
		$this->sql_fields = 'SELECT d.name, concat(e.sname,", ",e.fname) as manager, d.manager_id ';
		$this->sql_from = ' FROM departments d INNER JOIN employees e ON d.manager_id = e.emp_id';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT d.dept_id ';
		$this->subject_id = 1;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 1 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		// the number of records available for navigation depends on the user level. The employee himself can only see one record (his own).
		// the manager can see everyone in the department
		// the admin and everybody else can see everyone in the company.
		switch ($this->page->config['user_level']) {
			case lu_manager:
				$sql = ' WHERE d.manager_id = '.$this->page->ctrl['record'];
				break;
			case lu_employee:
			case lu_admin:
			case lu_gm:
			case lu_owner:
				$sql = ' WHERE d.company_id = '.$this->page->company['company_id'];
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
			return "New Department";
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
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','edit');\">Edit</a></td>\n";
		$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Department Blocks','show','".$this->data[0]['name']."');\">Show Blocks</a></td></tr>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td>\n";
		$out .= "				<td>&nbsp;</td>";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>