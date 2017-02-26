<?php

require_once("classes/empdbobject.php");
require_once("classes/leavetype.php");
require_once("classes/employee.php");

class EmpLeave extends EmpDBObject{

	var $hdays;
	var $ltype;
	var $emp;
	var $wdays;
	var $old_wdays;
	var $remove_approval;

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Leave";
		$this->idcol = "emp_leave_id";
		$this->tablename = "emp_leave ";
		$this->sql_fields = 'SELECT emp_leave_id, emp_id, start_date, end_date, workdays, type_id, is_half_day, is_am, note, submit_date, approved, approval_date, approval_emp_id ';
		$this->sql_from = ' FROM emp_leave e ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT e.emp_leave_id ';
		$this->subject_id = 10;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 10 AND editable = 1 order by sequence ASC");
		$sql = "SELECT hdate from holidays where company_id = ".$this->page->config['company_id'];
		$this->hdays = $this->dbc->query($sql);
		$this->wdays = 0;
		$this->old_wdays = 0;
		$this->remove_approval = false;
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE e.emp_id = '.$this->page->ctrl['subrecord'];
		return $sql;
	}

	public function checkData() {
	
		// Perform all the standard tests first 
		$test = $this->control->checkPOST($this);
		// Half day applications must have start and end date on the same day
		if ($this->data[0]['is_half_day'] == 1) {
			if ($this->data[0]['start_date'] != $this->data[0]['end_date']) {
				$test = false;
				$this->control->errflags['start_date'] = true;
				$this->control->errflags['end_date'] = true;
				$this->error->add('Half day applications must have start and end on the same day');
			}
		}
		// First calc the number of workdays, for both the new app. data and the existing data (if this is an edit) 
		// At the same time get the leave type.
		// From there work out the remaining leave (before and after)
		// first we need to work out how many workdays are actually in the requested period. 
		$this->ltype = new LeaveType($this->page, $this->dbc, $this->error);
		$this->ltype->load($this->data[0]['type_id']);
		if ($this->ltype->data[0]['isAnnual'] == 1) {
			$this->wdays = $this->getWorkdays($this->data[0]['start_date'], $this->data[0]['end_date'], $this->data[0]['is_half_day']);
		} else {
			$this->wdays = 0;
		}
		// we also need to know how many workdays were in the leave application, in the case of an edit
		if ($this->data[0]['emp_leave_id'] != 0 ) { 
			//get the previous number of workdays and deduct them from the figure of leave_left for the employee
			$sql = "SELECT start_date, end_date, type_id, is_half_day, isAnnual FROM emp_leave el INNER JOIN leave_types lt ON el.type_id = lt.leave_type_id  
					  WHERE emp_leave_id=".$this->data[0]['emp_leave_id'];
			$old = $this->dbc->query($sql);
			if ($old[0]['isAnnual'] == 1) {
				$this->old_wdays = $this->getWorkdays($old[0]['start_date'], $old[0]['end_date'],$old[0]['is_half_day']);
			} else {
				$this->old_wdays = 0;
			}
		} else {
			$this->old_wdays = 0;
		}
		$this->error->debug('new work days: '.$this->wdays.', old work days: '.$this->old_wdays);
		// Get the amount of remaining leave.
		$sql = "SELECT a.leave_left FROM annual_leave a INNER JOIN business_years b ON a.year_id = b.business_year_id ";
		$sql .= "WHERE a.emp_id = ".$this->page->ctrl['subrecord']." AND b.year_start <= '".$this->data[0]['start_date']."'";
		$sql .= " AND b.year_end >= '".$this->data[0]['start_date']."'";
		$result = $this->dbc->query($sql);
		$rem_leave = $result[0]['leave_left'] + $this->old_wdays;
		
		if ($this->ltype->data[0]['needsNote'] == 1 && trim($this->data[0]['note']) == '') {
			$this->control->errflags['note'] = true;
			$test = false;
			$this->error->add('This leave application requires a note, but you have not supplied one.');
		}
		if ($this->page->config['user_level'] < $this->ltype->data[0]['user_level']) {
			$test = false;
			$this->error->add('You are not authorised to apply for this type of leave. Speak to your manager.');
		}
		if ($this->data[0]['approved'] == 1) {
			if ($this->page->config['user_level'] < lu_admin) {
				$test = false;
				$this->error->add('This application has already been approved, you cannot change it any longer.');
			} else {
				$this->remove_approval = true;
			}
		}
		
		if ($this->ltype->data[0]['isAnnual'] == 1) {
			// Test 1: We then also need a check for applications that cross the business year end -> not allowed.
			if ($this->data[0]['start_date'] < $this->page->company['year_start']) {
				if ($this->data[0]['end_date'] > $this->page->company['year_start']) {
					$test = false;
					$this->error->add('You cannot apply for annual leave across the end of the business year. Split your application into two.');
				}
			}  
			// Test 2: Enough remaining annual leave
			// When performed after a save, the previous amount of leave would have been deducted already and must therefore be ignored !! 
			if ($this->wdays > $rem_leave) {
				$test = false;
				$this->error->add('This application requires '.$this->wdays.' days, but you only have '.$rem_leave.' day(s) left.');
			}
		}
		// Test 2: Application is in the past (current day excluded) and user is not at least the GM 
		if (strtotime($this->data[0]['start_date']) < (time()-86400) && $this->page->config['user_level'] < lu_gm) {
			$test = false;
			$this->control->errflags['start_date'] = true;
			$this->error->add('You cannot submit or modify a leave application that starts in the past.');
		}
		// Test 3: Start date is before end date
		if ($this->data[0]['start_date'] > $this->data[0]['end_date']) {
			$test = false;
			$this->control->errflags['start_date'] = true;
			$this->control->errflags['end_date'] = true;
			$this->error->add('The start date must be earlier than the end date.');
		}
		// Test 4: Does not overlap with an existing leave application
		// Neither the start date nor the end date must lie between start and end of any existing leave. 
		// If this check is performed after a save (e.g. when a date is modified), then it must exclude the current record.
		// The exception to this rule is if the current application is for a half day and the existing application is also a 
		// half day. 
		$sql = "SELECT * FROM emp_leave WHERE ('".$this->data[0]['start_date']."' BETWEEN start_date AND end_date ";
		$sql .= " OR '".$this->data[0]['end_date']."' BETWEEN start_date AND end_date) AND emp_id =".$this->page->ctrl['subrecord'];
		if($this->data[0]['emp_leave_id'] != 0) {
			$sql .= " AND emp_leave_id <> ".$this->data[0]['emp_leave_id'];
		}
		$this->error->debug($sql);
		$lcnt = $this->dbc->query($sql);
		if (count($lcnt) > 0) {
			if ($this->data[0]['is_half_day'] == 0 || $lcnt[0]['is_half_day'] == 0) {
				$test = false;
				$this->error->add('This application overlaps with another existing leave application, please check and try again.');
			} else {
				// this could be an exception, we need to check the existing leave application to make a decision
				if ($lcnt[0]['is_am'] == $this->data[0]['is_am']) {
					$test = false;
					$this->error->add('This application overlaps with another existing leave application, please check and try again.');
				}
			}
		}
		if ($this->isHoliday($this->data[0]['start_date']) || $this->isHoliday($this->data[0]['end_date'])) {
			$test = false;
			$this->error->add('Either the start date or the end date is a public holiday, please check and try again.');
		}
		// The other tests (block, max leave length) are done after the save and result only in warnings plus escalation
		return $test;
	}
	
	private function checkAfterSave() {
		if ($this->wdays > $this->page->company['max_leave_block']) {
			$this->error->add('Your application exceeds the maximum size of a single block of leave. It will be escalated to the Board and will need their approval.');
		}
		$this->emp = new Employee($this->page,$this->dbc,$this->error);
		$this->emp->load($this->page->ctrl['subrecord']);
		$sql = "SELECT count(*) AS cnt FROM blocks b INNER JOIN dept_blocks db USING(block_id) INNER JOIN teams t on db.dept_id = t.dept_id ";
		$sql .= "WHERE ('".$this->data[0]['start_date']."' BETWEEN block_start AND block_end ";
		$sql .= " OR '".$this->data[0]['end_date']."' BETWEEN block_start AND block_end) ";
		$sql .= "AND b.company_id =".$this->page->company['company_id']." AND t.team_id =".$this->emp->data[0]['team_id'];
//		$this->error->debug($sql);
		$bcnt = $this->dbc->query($sql);
		if ($bcnt[0]['cnt'] > 0) {
			$this->error->add('Your application conflicts with a period where leave is blocked, it will be escalated and will need the approval of the Board.');
		}
		if ($this->remove_approval == true) {
			$sql = "UPDATE emp_leave SET approved = 0, approval_date = '0000-00-00', approval_emp_id = 0 WHERE emp_leave_id = ".$this->data[0]['emp_leave_id']; 
			$this->dbc->exec($sql);
			$this->error->add('Your have modifed an approved application. It now requires new approval.');
		}
	}

	private function getWorkdays($start,$end,$halfday) {
		$date = strtotime($start);
		$last = strtotime($end);
		$cnt = 0;
		if ($halfday == 1) {
			$info = getdate($date);
			if ($info['weekday'] != 'Sunday' && $info['weekday'] != 'Saturday' && !$this->isHoliday($date)) {
				return 0.5;
			} else {
				return 0;
			}
		}
		while ($date <= $last) {
			$info = getdate($date);
			if ($info['weekday'] != 'Sunday' && $info['weekday'] != 'Saturday' && !$this->isHoliday($date)) {
				$cnt++;
			}
			$date += 60*60*24;
		}
		return $cnt;
	}
	
	private function isHoliday(&$value) {
		$date = date('Y-m-d', $value);
		foreach ($this->hdays as $hday) {
			if ($date == $hday['hdate']) { return true; }
		}
		return false;
	}
	
	public function add() {
		$keystring = ",emp_id, submit_date, approved";
		$values = $this->page->ctrl['subrecord'].", curdate(), 0";
		$where = " WHERE emp_id=".$this->page->ctrl['subrecord'];
		$this->add2db($keystring, $values, $where);
		$this->updateEmployee();
		$this->error->add("Your leave application has been submitted. It must be approved by your manager or HR to come into effect.");
		$this->checkAfterSave();
		$this->sendMessages('application');
	}
		
	public function save() {
		parent::save();
		$this->updateEmployee();
		$this->error->add("Your leave application has been updated. It must be approved by your manager or HR to come into effect.");
		$this->checkAfterSave();
		$this->sendMessages('application');
	}
	
	private function sendMessages($msg_type) {
		// if messaging is disabled then exit
		if ($this->page->company['send_email'] == false) {
			$this->error->add('Sending of email is currently disabled');
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
		$params = array($maildata[0]['fullname'], $this->data[0]['start_date'], $this->data[0]['end_date'], "", 
							 $this->wdays." day(s)", "", "", date('d/m/Y'), $maildata[0]['fullname'], 
							 $this->ltype->data[0]['name'], "","");
		switch ($msg_type) {
			case 'application':
				// build the URL strings for the email: need the record id, subject and subsubject. 
				// Order column and direction are irrelevant, as is mode. Company is determined from the cookie/login. 
				// Actions are available on the actual target page (which is determined by subject and subsubject). 
				// The target is always the landing page, which forwards to the admin page. 
				$gets = $this->page->ctrl['record'].':'.$this->page->ctrl['subject'].':'.$this->page->ctrl['subsubject'];
				$params[PAR_URL] = 'http://'.$_SERVER['SERVER_NAME'].str_replace('admin','lander',$_SERVER['REQUEST_URI']).'?parms='.urlencode($gets);
				$params[PAR_RESULT] = "yet to be approved";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APP_LEAVE_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APP_LEAVE_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APP_LEAVE_MGR, $params);
				}
				break;
			case 'cancelation':
				$params[PAR_RESULT] = "canceled";
				$this->sendTemplateMail($maildata[0]['email'], TPL_DEL_LEAVE_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_DEL_LEAVE_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_DEL_LEAVE_MGR, $params);
				}
				break;
			case 'approval':
				$params[PAR_RESULT] = "approved";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APR_LEAVE_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APR_LEAVE_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APR_LEAVE_MGR, $params);
				}
				break;
			case 'decline':
				$params[PAR_RESULT] = "declined";
				$this->sendTemplateMail($maildata[0]['email'], TPL_APR_LEAVE_EMP, $params);
				$params[PAR_RECEIVER] = $maildata[0]['mgr_fullname'];
				$this->sendTemplateMail($maildata[0]['mgr_email'], TPL_APR_LEAVE_MGR, $params);
				if ($this->page->company['hr_email_adr'] != '') {
					$params[PAR_RECEIVER] = 'HR Admin staff';
					$this->sendTemplateMail($this->page->company['hr_email_adr'], TPL_APR_LEAVE_MGR, $params);
				}
		}
	}

	private function updateEmployee() {
		
		$sql = "UPDATE annual_leave a, business_years b SET a.leave_left = a.leave_left - ".($this->wdays-$this->old_wdays);
		$sql .= " WHERE a.emp_id =".$this->page->ctrl['subrecord']." AND a.year_id = b.business_year_id 
					AND b.year_start<='".$this->data[0]['start_date']."' AND b.year_end >='".$this->data[0]['start_date']."';";
		$this->dbc->exec($sql);
		$sql = "UPDATE emp_leave SET workdays = ".$this->wdays;
		$sql .= " WHERE emp_leave_id = ".$this->page->ctrl['record'].";";
		$this->dbc->exec($sql);
	}

	public function delete() {
		// delete the current record from the database and move to the next. If this was the last record, move to the previous.
		$this->ltype = new LeaveType($this->page, $this->dbc, $this->error);
		$this->ltype->load($this->data[0]['type_id']);
		if ($this->checkDependencies() == true ) {
			if ($this->ltype->data[0]['isAnnual'] == 1) {
				$this->old_wdays = $this->getWorkdays($this->data[0]['start_date'], $this->data[0]['end_date'], $this->data[0]['is_half_day']);
			} else {
				$this->old_wdays = 0;
			}
			$this->wdays = 0;		// no new application -> use 0
			$sql = "DELETE FROM ".$this->tablename." where ".$this->idcol." = ".$this->page->ctrl['record'];
			$this->dbc->exec($sql);
			$this->updateEmployee();
			$this->sendMessages('cancelation');
		}
	}
	
	public function editdetails() {
	
		$out = "    <table width=\"100%\"><tr><td width=\"50%\" valign=top>\n"; 
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Edit ".$this->name." Details</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		//$this->error->debug('AM: '.$this->data[0]['is_am'].', Halfday: '.$this->data[0]['is_half_day']);
		foreach ($this->columns as $col) {
			$out .= "        <tr><td class=\"td-right\">".$col['title']." : </td>\n";
			$out .= "        <td class=\"td-left-show\">".$this->control->build($col,$this->data[0])."</td></tr>\n";
		}
		$out .= "        <tr><td></td><td class=\"td-left\">\n";
		$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'save');\">Save</a>  |  \n";
		if ($this->isNew == true) {
			$out .= "          <a href=\"#\" onclick=\"RestoreSubject();\">Cancel</a></td></tr>\n";
		} else {
			$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'view');\">Cancel</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		$out .= "    </td><td valign=top>\n";
		$out .= $this->graph_bottom();
		$out .= "    </td></tr>\n";
		return $out;
	}
	
	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Leave Application";
		}
		return "Leave for ".$this->page->ctrl['title'];
	}
	
	public function approve() {
		$this->ltype = new LeaveType($this->page, $this->dbc, $this->error);
		$this->ltype->load($this->data[0]['type_id']);
		if ($this->page->config['user_level'] < $this->ltype->data[0]['approver_level']) {
			$this->error->add('You are not authorised to approve this type of leave. Speak to your manager.');
			return;
		}
		$sql = "UPDATE emp_leave SET approved = 1, approval_date = curdate(), approval_emp_id=".$this->page->config['user_id'];
		$sql .= " WHERE emp_leave_id=".$this->data[0]['emp_leave_id'];
		$this->dbc->exec($sql);
		$this->wdays = $this->getWorkdays($this->data[0]['start_date'], $this->data[0]['end_date'], $this->data[0]['is_half_day']);
		$this->sendMessages('approval');
	}
	
	public function decline() {
		$sql = "UPDATE emp_leave SET approved = 0, approval_date = curdate(), approval_emp_id=".$this->page->config['user_id'];
		$sql .= " WHERE emp_leave_id=".$this->data[0]['emp_leave_id'];
		$this->dbc->exec($sql);
		$this->wdays = $this->getWorkdays($this->data[0]['start_date'], $this->data[0]['end_date'], $this->data[0]['is_half_day']);
		$this->sendMessages('decline');
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Notices</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\">Please note the following rules about leave applications:<br>";
		$out .= "		<ol><li>you cannot apply for more annual leave than you have left.";
		$out .= "		<li>if your application falls into a blocked period (see below), it will be escalated to the board.";
		$out .= "		<li>if your application is longer than the maximum allowed period, it will be escalated to the board.";
		$out .= "		<li>After successful submission of the application, your manager or HR needs to approve your leave.";
		$out .= "		   This approval will result in an e-mail to you (i.e. no approval message = no leave !!).</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$sql = 'SELECT b.year_name, a.leave_left FROM annual_leave a INNER JOIN business_years b ON a.year_id = b.business_year_id
				  WHERE b.year_end >= curdate() AND a.emp_id =' .$this->page->ctrl['subrecord'].' ORDER BY b.year_start ASC;';
		$allow = $this->dbc->query($sql);
//		$this->error->debug($sql);
		if ($allow[0]['leave_left'] <> 0) {
			$remleave = $allow[0]['leave_left'];
		} else {
			$remleave = 0;
		}
		$sql = 'SELECT reason, block_start, block_end FROM blocks b INNER JOIN dept_blocks db USING(block_id)';
		$sql .= ' INNER JOIN teams t on db.dept_id = t.dept_id INNER JOIN employees e on t.team_id = e.team_id WHERE e.emp_id='.$this->page->ctrl['subrecord'];
		$blocks = $this->dbc->query($sql);
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=3 width=\"100%\" class=\"td-left\"><h2>Block periods</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td colspan=3 class=\"bold\">For the current business year and following years you have this many days of leave left:\n";
		$out .= "				<ul>\n";
		if ($allow != NULL) {
			foreach ($allow as $allowance) {
				$out .= "				<li>".$allowance['year_name'].': '.$allowance['leave_left']." days</li>";
			}
		} else {
				$out .= "            <li>You do not have a leave allowance for the current year!</li>";
		}
		$out .= "				</ul>\n";
		$out .= "			</td></tr>\n"; 
		$out .= "        <tr><td colspan=3>This is a list of all applicable block periods.</td></tr>\n";
		if (count($blocks) == 0) {
			$out .= "        <tr><td colspan=3>There are currently no restrictions.</td></tr>\n";
		} else {
			$out .= "<tr><td class=\"td-left\">Block reason</td><td class=\"td-right\">Start date</td><td class=\"td-right\">End Date</td></tr>\n";
			foreach ($blocks as $block) {
				$out .= "        <tr><td class=\"td-left\">".$block['reason']."</td><td class=\"td-right\">".$block['block_start']."</td>";
				$out .= "<td class=\"td-right\">".$block['block_end']."</td></tr>\n";
			}
		}
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
			$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all leave applications</a></td></tr>\n";
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