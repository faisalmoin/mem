<?php

require_once("classes/empdbobject.php");

class ShiftSchedule extends EmpDBObject{

	var $emp_shifts;
	var $shifts;
	var $week_start;
	var $last_start;

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Shift Schedule";
		$this->idcol = "emp_shift_id";
		$this->tablename = "emp_shifts ";
		$this->sql_fields = 'SELECT emp_shift_id, emp_id, shift_id, shift_date';
		$this->sql_from = ' FROM emp_shifts e';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT e.emp_shift_id ';
		$this->subject_id = 9;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 9 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE e.emp_id = '.$this->page->ctrl['subrecord'];
		return $sql;
	}

	public function checkData() {
		// Here we need to check that the total allocated work time per week adds up to 5 * daily work time.
		// This can obviously only be done for the first 2 weeks.
// taken out due to part-time workers. to get this working properly, each employee needs to have a 
// minimum work week length in hours.
		return true;

		$this->loadShifts();
		$cnt = 0;
		$this_day = $this->first_day;
		$att_time = strtotime($this->page->company['default_end_time']) - strtotime($this->page->company['default_start_time']);
		$breaktime =  $att_time - strtotime($this->page->company['default_hours']);
		$shifttime = 0;
		do {
			// get the POST value.
			$shift_id = $_POST['in_'.(date('z',$this_day))];
			// now find the relevant shift
			foreach ($this->shifts as $shift) {
				if ($shift_id == $shift['shift_id']) {
					// add the difference in work time minus standard break time
					if ($shift['end_time'] == $shift['start_time']) {
						$newtime = 0;
					} else {
						$newtime = strtotime($shift['end_time'])-strtotime($shift['start_time']);
						if ($newtime > $breaktime) {
							$newtime -= $breaktime;
						} else {
							$newtime = 0;
						}
					}
					$shifttime += $newtime;
					break;
				}
			}
			$this_day += 24*60*60;
			$cnt++;
		} while ($cnt < 7);
		$worktime = 5 * strtotime($this->page->company['default_hours']);
		if ($worktime > $shifttime) {
			$this->error->add('Your first week does not have enough scheduled time for a full working week.');
			return false;
		}
		return true;
	}
	
	private function loadShifts() {
		// get all shift records where the start_date is less than 14 weeks into the future
		$sql = "SELECT * FROM emp_shifts WHERE shift_date BETWEEN date_add(curdate(),interval 1 day) AND date_add(curdate(), interval 15 day) and emp_id = ".$this->page->ctrl['subrecord'];
		$this->emp_shifts = $this->dbc->query($sql);
//		$this->error->debug($sql);
		$sql = "SELECT * from shifts WHERE company_id = ".$this->page->company['company_id'];
		$this->shifts = $this->dbc->query($sql);
		$this->first_day = time() + 24*60*60;		//allocation always starts tomorrow 
		$this->last_day = $this->first_day + 14*24*60*60; // simple schedule is 14 days deep.
	}

	public function editdetails() {
	
		// OK, this one is completely different. We will show the next 13 weeks. For each week we show the week number, start date,
		// and a combo for the shift selection. Where a record exists in the database, we use it. If not, show the default shift.
		// At the bottom there is a link to edit the next 13 weeks (maybe in the future).
		$this->loadShifts();
		$cnt = 0;
		$this_day = $this->first_day;
		// the default shift can be found in the page->company collection
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Edit ".$this->name."</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		do {
			$wday = date('l', $this_day);
			$day = date('Y-m-d', $this_day);
			$out .= "        <tr><td class=\"td-right\" width=\"40%\">Shift starting on ".$wday.", ".$day." : </td>\n";
			if ($day == $this->emp_shifts[$cnt]['shift_date']) { 
				$shift_id = $this->emp_shifts[$cnt]['shift_id'];
				$cnt++;
			} else {
				if($wday == 'Sunday' || $wday == 'Saturday') {
					$shift_id = $this->page->company['default_shift_wend'];
				} else {
					$shift_id = $this->page->company['default_shift'];
				}
			}
			// now build the select combo
			$out .= "<td class=\"td-left\">\n";
			$out .= $this->getCombo($shift_id,$this->shifts,date('z',$this_day));
			$out .= "</td></tr>\n";
			$this_day += 24*60*60;
		} while ($this_day <= $this->last_day);
		$out .= "        <tr><td></td><td class=\"td-left\">\n";
		$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'save');\">Save</a>  |  \n";
		if ($this->isNew == true) {
			$out .= "          <a href=\"#\" onclick=\"RestoreSubject();\">Cancel</a></td></tr>\n";
		} else {
			$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'view');\">Cancel</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;
	}
	
	private function getCombo($index, &$rows, $name) {
		$out = "<select name=\"in_".$name."\" id=\"in_".$name."\" size=\"1\" ";
		$out .= "class=\"edit-ctrl\" >\n"; 
		if (count($rows) > 0) {
			foreach ($rows as $row) {
				if ($row['shift_id'] == $index) {
					$out .= "<option selected value=\"".$row['shift_id']."\">".$row['name']."</option>\n";
				} else {
					$out .= "<option value=\"".$row['shift_id']."\">".$row['name']."</option>\n";
				}
			}
		}
		$out .= "</select>\n";
		return $out;
	}
	
	public function add() {
		$this->save();			//There is no distinction between save and add for the shift schedule.
	}
	
	public function save() {
	
		$this->loadShifts();
		$cnt = 0;
		$this_day = $this->first_day;

		// OK, got all shift details loaded, plus existing shifts for this employee for the next 13 weeks.
		// Now we need to go through all 13 weeks and see whether there is an emp_shift record. 
		// If yes, update it (only if needed). If no, create a new one. 
		do {
			$day = date('z',$this_day);
			$selshift = $_POST['in_'.$day];
			if (date('Y-m-d', $this_day) == $this->emp_shifts[$cnt]['shift_date']) {
				//employee shift does exist -> update it if necessary. 
				if ($this->emp_shifts[$cnt]['shift_id'] != $selshift) {
					$sql = "UPDATE emp_shifts SET shift_id = ".$selshift." WHERE emp_shift_id=".$this->emp_shifts[$cnt]['emp_shift_id'];
					$this->dbc->exec($sql);
				}
				$cnt++;
			} else {
				//employee shift does not exist -> create a new record. 
				$sql = "INSERT INTO emp_shifts (emp_id, shift_id, shift_date) VALUES (";
				$sql .= $this->page->ctrl['subrecord'].",".$selshift.",'".date('Y-m-d', $this_day)."');";
				$this->dbc->exec($sql);
			}
			$this_day += 24*60*60;
		} while ($this_day <= $this->last_day);
	}
	
	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Shift Allocation for ".$this->page->ctrl['title'];
		}
		return "Shifts for ".$this->page->ctrl['title'];
	}
	
	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Notices</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\">Please note the following rules about leave applications:</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Team Lateness</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Lateness Graph will show here.</td></tr>\n";
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
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>