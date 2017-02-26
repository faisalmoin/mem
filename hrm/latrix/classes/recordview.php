<?php

require_once("classes/navigator.php");

switch ($config->ctrl['subject']) {

	case 'Config':
		require_once("classes/company.php");
		break;
	case 'Departments':
		require_once("classes/department.php");
		break;
	case 'Teams':
		require_once("classes/team.php");
		break;
	case 'Employees':
		require_once("classes/employee.php");
		break;
	case 'Locations':
		require_once("classes/location.php");
		break;
	case 'Shifts':
		require_once("classes/shift.php");
		break;
	case 'Holidays':
		require_once("classes/holiday.php");
		break;
	case 'Blocks':
		require_once("classes/block.php");
		break;
	case 'Employee Shifts':
		require_once("classes/emp-shift.php");
		break;
	case 'Leave':
		require_once("classes/leave.php");
		break;
	case 'Employee Attendance':
		require_once("classes/emp-attendance.php");
		break;
	case 'Exceptions':
		require_once("classes/exception.php");
		break;
	case 'Leave Types':
		require_once("classes/leavetype.php");
		break;
	case 'Department Blocks':
		require_once("classes/departmentblock.php");
		break;
	case 'Titles':
		require_once("classes/title.php");
		break;
	case 'Business Years':
		require_once("classes/businessyear.php");
		break;
	case 'Annual Leave':
		require_once("classes/annualleave.php");
		break;
	case 'Shift Schedule':
		require_once("classes/shiftschedule.php");
		break;
	case 'Half days off':
		require_once("classes/halfday.php");
		break;
	case 'Email Templates':
		require_once("classes/email_template.php");
	}


class	RecordView {

/* This class provides the framework for the detail view of each subject. Many of them are very similar
	and therefore use the same basic structure.
	department, team, employee: all have details on the left, with activity links underneath, and some graphs on the right
	locations, shifts, holidays: same as above, but no graphs
	reports and config are handled with a completely separate page (although leave types use a similar layout for display and editing)

	The activities and the graphs are different for each subject, that is where individual classes are used for each subject
	The detail view itself is programmed via the data_columns in the database. The same is true for the edit form.
	Handling the actions (delete, save, add) for each subject is left to the individual classes.

*/
	var $page;
	var $db_conn;
	var $error;
	var $item;
	var $isFaulty;
	var $count;
	var $navbar;

	public function __construct(&$page, &$db_conn, &$errorbox) {
	
		$this->isFaulty = false;
		$this->page = $page;
		$this->error = $errorbox;
		switch ($page->ctrl['subject']) {
		
			case 'Config':
				$this->item = new Company($page,$db_conn,$errorbox);
				break;
			case 'Departments':
				$this->item = new Department($page,$db_conn,$errorbox);
				break;
			case 'Teams':
				$this->item = new Team($page,$db_conn,$errorbox);
				break;
			case 'Employees':
				$this->item = new Employee($page,$db_conn,$errorbox);
				break;
			case 'Locations':
				$this->item = new Location($page,$db_conn,$errorbox);
				break;
			case 'Shifts':
				$this->item = new Shift($page,$db_conn,$errorbox);
				break;
			case 'Holidays':
				$this->item = new Holiday($page,$db_conn,$errorbox);
				break;
			case 'Blocks':
				$this->item = new Block($page,$db_conn,$errorbox);
				break;
			case 'Employee Shifts':
				$this->item = new EmpShift($page,$db_conn,$errorbox);
				break;
			case 'Leave':
				$this->item = new EmpLeave($page,$db_conn,$errorbox);
				break;
			case 'Employee Attendance':
				$this->item = new EmpAtt($page,$db_conn,$errorbox);
				break;
			case 'Exceptions':
				$this->item = new EmpException($page,$db_conn,$errorbox);
				break;
			case 'Leave Types':
				$this->item = new LeaveType($page,$db_conn,$errorbox);
				break;
			case 'Department Blocks':
				$this->item = new DepartmentBlock($page,$db_conn,$errorbox);
				break;
			case 'Titles':
				$this->item = new Title($page,$db_conn,$errorbox);
				break;
			case 'Business Years':
				$this->item = new BusinessYear($page,$db_conn,$errorbox);
				break;
			case 'Annual Leave':
				$this->item = new AnnualLeave($page,$db_conn,$errorbox);
				break;
			case 'Shift Schedule':
				$this->item = new ShiftSchedule($page,$db_conn,$errorbox);
				break;
			case 'Half days off':
				$this->item = new HalfDay($page,$db_conn,$errorbox);
				break;
			case 'Email Templates':
				$this->item = new EmailTemplate($page,$db_conn,$errorbox);
				break;
			default:
				$this->isFaulty = true;
		}
		if($this->isFaulty == false) {
			$this->item->loadNavNumbers($this->page->ctrl['record']);
			$this->count = $this->item->getCount();
			$this->navbar = new Navigator($page,$this->count);	//need to put in the correct parameters here. Where do they come from ?
			if ($this->page->ctrl['record'] <> 0) {
				$this->navbar->setVisible(true);
				$this->item->load($this->page->ctrl['record']);
			} else {
				$this->navbar->setVisible(false);
				$this->item->setNew(true);
			}
		}
		$data = $db_conn->query("SELECT help_url FROM subjects where name='".$page->ctrl['subject']."'");
		$this->help_url = $data[0]['help_url'];
	}
	
	private function getCount() {
		if ($this->isFaulty) {
			return 0;
		}
		return $this->count;
	}

	public function show() {
	
	/*	The detail view has a top bar similar to the table view, except it shows the name of the detail record on the left 
		and a record navigator on the right. The top bar has a white background. The whole view is surrounded by a 1px frame.
		Underneath are the various sections.
	*/
		if($this->isFaulty == true) {
			$this->error->add("Cannot show details, the item is not defined properly. Call support!");
			return "";
		}
		if($this->page->ctrl['mode'] == 'edit') {
			return $this->edit();
		}
		$out = "\t<table class=\"data-table\" width=\"100%\" cellpadding=\"0px\" cellspacing=\"0px\" >\n";
		$out .= "\t<thead>\n";
		$out .= "\t\t<tr><td class=\"td-left\" width=\"50%\"><h1>".$this->item->getTitle()."</h1></td>\n";
//		$out .= "\t\t<td class=\"td-right\">".$this->navbar->build4records($this)."</td></tr>\n";
		$out .= "\t\t<td class=\"td-right\">&nbsp;</td></tr>\n";
		$out .= "\t</thead>\n";
		$out .= "\t<tbody>\n";
		$out .= "\t\t<tr><td valign=\"top\">\n";			// This is the left hand side column.
		$out .= $this->item->showdetails();
		$out .= $this->item->activities();
		$out .= "\t\t</td><td valign=\"top\">\n";		// This is the right hand side column.
		$out .= $this->item->graph_top();
		$out .= $this->item->graph_bottom();
		$out .= "\t\t</td></tr>\n";
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	}
	
	public function edit() {
	
		$out = "\t<table class=\"data-table\" width=\"100%\" cellpadding=\"0px\" cellspacing=\"0px\" >\n";
		$out .= "\t<thead>\n";
		$out .= "\t\t<tr><td class=\"td-left\" width=\"50%\"><h1>".$this->item->getTitle()."</h1></td>\n";
//		$out .= "\t\t<td class=\"td-right\">".$this->navbar->build4records($this)."</td></tr>\n";
		$out .= "\t\t<td class=\"td-right\">&nbsp;</td></tr>\n";
		$out .= "\t</thead>\n";
		$out .= "\t<tbody>\n";
		$out .= "\t\t<tr><td valign=top colspan=2>\n";			// This is the left hand side column.
		$out .= $this->item->editdetails();
		$out .= "\t\t</td></tr>\n";
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	
	}

}

?>