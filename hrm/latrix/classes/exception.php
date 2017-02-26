<?php

require_once("classes/empdbobject.php");
require_once("classes/employee.php");

class EmpException extends EmpDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Exception";
		$this->idcol = "exception_id";
		$this->tablename = "exceptions ";
		$this->sql_fields = 'SELECT exception_id, emp_id, start_time, end_time, exception_date, reason, submit_date, approved, approval_date, approval_emp_id ';
		$this->sql_from = ' FROM exceptions e ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT e.exception_id ';
		$this->subject_id = 12;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 12 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE e.emp_id = '.$this->page->ctrl['subrecord'];
		return $sql;
	}

	public function checkData() {
	
		// need to check for remaining leave, blocks, max leave block length, overlapping applications.
		// also need to fail the test if the start date is in the past.
		$test = $this->control->checkPOST($this);
		// first we need to work out how many workdays are actually in the requested period. 
		// Test 2: Exception is in the past and user is not at least GM
		if (strtotime($this->data[0]['exception_date']) < (time()-86400) && $this->page->config['user_level'] < lu_gm) {
			$test = false;
			$this->error->add('You cannot submit or modify an exception that is in the past.');
		}
		// Test 3: Start time is before end time
		if ($this->data[0]['start_time'] > $this->data[0]['end_time']) {
			$test = false;
			$this->error->add('The start time must be earlier than the end time.');
		}
		// Test 4: Does not overlap with an existing exception
		// If this check is performed after a save (e.g. when a date is modified), then it must exclude the current record. 
		$sql = "SELECT count(*) as cnt FROM exceptions WHERE '".$this->data[0]['exception_date']."' = exception_date ";
		$sql .= " AND emp_id =".$this->page->ctrl['subrecord'];
		if($this->data[0]['exception_id'] != 0) {
			$sql .= " AND exception_id <> ".$this->data[0]['exception_id'];
		}
		$lcnt = $this->dbc->query($sql);
		if ($lcnt[0]['cnt'] > 0) {
			$test = false;
			$this->error->add('This application overlaps with another existing exception, please check and try again.');
		}
		return $test;
	}
	
	public function add() {
		$keystring = ",emp_id, submit_date, approved";
		$values = $this->page->ctrl['subrecord'].", curdate(), 0";
		$where = " WHERE emp_id=".$this->page->ctrl['subrecord'];
		$this->add2db($keystring, $values, $where);
		$this->error->add("Your exception application has been submitted. It must be approved by your manager or HR to come into effect.");
		$this->sendMessages('application');
	}
	
	public function save() {
		parent::save();
		$this->error->add("Your exception application has been updated. It must be approved by your manager or HR to come into effect.");
		$this->sendMessages('application');
	}
	
	public function delete() {
		parent::delete();
		$this->sendMessages('cancelation');
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Exception";
		}
		return "Exception for ".$this->page->ctrl['title'];
	}
	
	public function approve() {
		$sql = "UPDATE exceptions SET approved = 1, approval_date = curdate(), approval_emp_id=".$this->page->config['user_id'];
		$sql .= " WHERE exception_id=".$this->data[0]['exception_id'];
		$this->dbc->exec($sql);
		$this->sendMessages('approval');
	}
	
	public function cancel() {
		$sql = "UPDATE exceptions SET approved = 0, approval_date = curdate(), approval_emp_id=".$this->page->config['user_id'];
		$sql .= " WHERE exception_id=".$this->data[0]['exception_id'];
		$this->dbc->exec($sql);
		$this->sendMessages('decline');
	}

	private function sendMessages($msg_type) {
		// if messaging is disabled then exit
		if ($this->page->company['send_email'] == false) {
			return;
		}
		// retrieve the email address, full name and manager name and manger email address 
		// of the employee from $this->page->ctrl['subrecord']
		$sql = "SELECT e.email, concat(e.fname, ' ', e.sname) AS fullname, mgr.email AS mgr_email, ";
		$sql .= "concat(mgr.fname, ' ', mgr.sname) AS mgr_fullname  FROM employees e ";
		$sql .= "INNER JOIN teams t ON e.team_id = t.team_id ";
		$sql .= "INNER JOIN departments d ON t.dept_id = d.dept_id ";
		$sql .= "INNER JOIN employees mgr ON d.manager_id = mgr.emp_id WHERE e.emp_id=".$this->page->ctrl['subrecord'];
		$maildata = $this->dbc->query($sql);
		$this->getMailParams();
		$params = array($maildata[0]['fullname'], $this->data[0]['exception_date'], "", "", "", "", "", date('d/m/Y'), 
							 $maildata[0]['fullname'], $this->ltype->data[0]['name'],$this->data[0]['start_time'], $this->data[0]['end_time']);
		switch ($msg_type) {
			case 'application':
				$params[PAR_RESULT] = "yet to be approved";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APP_EXC_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APP_EXC_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APP_EXC_MGR, $params);
				}
				break;
			case 'cancelation':
				$params[PAR_RESULT] = "canceled";
				$this->sendTemplateMail($maildata[0]['email'], TPL_DEL_EXC_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_DEL_EXC_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_DEL_EXC_MGR, $params);
				}
				break;
			case 'approval':
				$params[PAR_RESULT] = "approved";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APR_EXC_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APR_EXC_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APR_EXC_MGR, $params);
				}
				break;
			case 'decline':
				$params[PAR_RESULT] = "declined";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APR_EXC_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APR_EXC_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APR_EXC_MGR, $params);
				}
		}
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Notices</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\">Please note the following rules about exceptions:<br>";
		$out .= "		<ol><li>you cannot modify any exceptions that are in the past.";
		$out .= "		<li>the start time must be before the end time.";
		$out .= "		<li>you can only have one exception per day.";
		$out .= "		<li>After successful submission of the application, your manager or HR needs to approve your application.";
		$out .= "		   This approval will result in an e-mail to you (i.e. no approval message = no exception !!).</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Space for something</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>We will think of something useful for this area.</td></tr>\n";
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
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Employee</a></td></tr>\n";
		if ($this->page->ctrl['record'] != 0) {
			$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','delete');\">Remove this application</a></td>";
			$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all exceptions</a></td></tr>\n";
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