<?php

require_once("classes/dbobject.php");

class Company extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Config";
		$this->idcol = "c.company_id";
		$this->tablename = "companies c";
		$this->sql_fields = 'SELECT c.name, c.manager_id, concat(e.sname,", ",e.fname) as manager, c.double_login, c.lone_worker_warning,';
		$this->sql_fields .= 'c.show_self_cert, c.leave_login, c.holiday_login, c.max_leave_block, c.default_end_time, c.default_start_time, ';
		$this->sql_fields .= 'c.default_hours, c.year_start, c.send_email, strict_password, page_size, default_shift, default_shift_wend, ';
		$this->sql_fields .= 'c.inandout_code, c.hr_email_adr, c.show_disabled_items, c.contact_phone ';
		$this->sql_from = ' FROM companies c INNER JOIN employees e ON c.manager_id = e.emp_id';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT c.company_id ';
		$this->subject_id = 8;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 8 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		// the number of records available for navigation depends on the user level. The employee himself can only see one record (his own).
		// the manager can see everyone in the department
		// the admin and everybody else can see everyone in the company.
		switch ($this->page->config['user_level']) {
			case lu_manager:
			case lu_employee:
			case lu_admin:
				$sql = 'WHERE 1 = 2';
				break;	//nobody below GM can access this subject
			case lu_gm:
			case lu_owner:
				$sql = ' WHERE c.company_id = '.$this->page->company['company_id'];
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
			return "New Company";
		}
		return $this->data[0]['name'];
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Overall Attendance</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Attendance Graph will show here.</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Overall Lateness</h2></td></tr></thead>\n";
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
		$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Leave Types','show','".$this->page->company['name']."');\">Leave types</a></td></tr>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Business Years','show','".$this->page->company['name']."');\">Business Years</a></td>\n";
		if ($this->page->config['user_level'] > lu_gm) {		// only the owner can delete companies. This should also remove all other records for this company. 
			$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Titles','show','all companies');\">Titles</a></td></tr>\n";
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
			$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td>\n"; 
			$out .= "            <td class=\"td-right\"><a href=\"#\" onclick=\"SelectSubSubject('Countries','show','all companies');\">Countries</a></td></tr>\n";
		}
		$out .= "      <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SelectSubSubject('Email Templates','show','".$this->page->company['name']."');\">Email Templates</a></td>";
		$out .= "          <td class=\"td-right\"></td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>