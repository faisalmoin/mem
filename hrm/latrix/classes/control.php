<?php

class	Control {

/* Input controls are built with this helper class. The only public function takes as arguments the column descriptor and the data row.
	It also accesses the POST to see whether there is any data available (in case the form has been called before and the save was
	not successful). If there is data in the POST, it takes priority.
	Checking of submitted values against validity rules is done by the subject item itself.
*/
	var $dbc;
	var $errflags;
	var $company;
	var $userlevel;

	public function __construct(&$dbc, $company, $userlevel) {
		$this->dbc = $dbc;
		$this->company = $company;
		$this->userlevel = $userlevel;
		}

	public function build(&$col, &$row) {
	
		if (isset($_POST["in_".$col['db_name']])) {
			$this->value = $_POST["in_".$col['db_name']];
		} else {
			$this->value = $row[$col['db_name']];
		}
		$this->name = $col['db_name'];
		$this->size = $col['width'];
		$this->length = $col['size'];
		$this->comment = $col['comment'];
		$this->errflag = $this->errflags[$col['db_name']];
		$this->required = $col['required'];
		switch($col['type']) {
			case 'N':	// numeric input
			case 'C':	// character field
			case 'T':	//time
				return $this->input();
			case 'P':	// password
				return $this->password();
			case 'X':	// special, type password if the user is at employee level, character otherwise
				if ($userlevel < lu_manager) {
					return $this->input();
				} else {
					return $this->password();
				}
			case 'D':	// date, with date picker
				return $this->date();
			case 'S':	//select combo box
				$sql = str_replace("%company%", $this->company,$col['query']);
				$sql = str_replace("%userlevel%", $this->userlevel, $sql);
				$this->lookup = $this->dbc->query($sql);
				return $this->combobox(1, false);
			case 'R':	//radio button
				return $this->radio();
			case 'I':	
				return $this->image();
			case 'B':
				if (isset($_POST["in_".$col['db_name']])) {
					if ($_POST["in_".$col['db_name']] == 'on' || $row[$col['db_name']] == 1) {
						$this->value = 1;
					} else {
						$this->value = 0;
					}
				} else {
					$this->value = $row[$col['db_name']];
				}
				return $this->checkbox();
			case 'M':	// multiple line input
				return $this->multiline();
			case 'E':	// html editor
				return $this->editor();
		}
	
	}

	private function getClass() {
		if ($this->errflag) {
			if ($this->required == 1) {
				$out = "class=\"requ-ctrl-error\" ";
			} else {
				$out = "class=\"edit-ctrl-error\" ";
			}
		} else {
			if ($this->required == 1) {
				$out = "class=\"requ-ctrl\" ";
			} else {
				$out = "class=\"edit-ctrl\" ";
			}
		}
		return $out;
	}

	private function checkbox() {
		$out = "<input type=checkbox ";
		$out .= $this->getClass();
		if ($this->value == 1) { 
			$out .= "checked";
		}
		$out .= " name=\"in_".$this->name."\" id=\"in_".$this->name."\">".$this->comment."\n";
		return $out;
	}

	private function input() {
		if ($this->name == 'keycode' && $this->userlevel < lu_admin) {
			$out = "<input type=password size=\"".$this->size."\" ";
		} else {
			$out = "<input type=text size=\"".$this->size."\" ";
		}
		$out .= $this->getClass();
		if ($this->name == 'keycode' && $this->userlevel < lu_admin) {
			$out .= ' readonly ';
		}
		if ($this->name == 'payroll' && $this->userlevel < lu_admin) {
			$out .= ' readonly ';
		}
		$out .= "value=\"".$this->value."\" name=\"in_".$this->name."\" id=\"in_".$this->name."\" maxlength=\"".$this->length."\">".$this->comment."\n";
		return $out;
	}

	private function password() {
		$out = "<input type=password size=\"".$this->size."\" ";
		$out .= $this->getClass();
		$out .= "value=\"".$this->value."\" name=\"in_".$this->name."\" id=\"in_".$this->name."\" maxlength=\"".$this->length."\">".$this->comment."\n";
		return $out;
	}

	private function date() {
		$out = "<input type=text size=\"".$this->size."\" ";
		$out .= $this->getClass();
		$out .= "value=\"".$this->value."\" name=\"in_".$this->name."\" id=\"in_".$this->name."\" maxlength=\"".$this->length."\">";
		$out .= "<img class=\"\" src=\"images/scw.gif\" onclick=\"scwShow(scwID('in_".$this->name."'),this);\">";
		$out .= $this->comment."\n";
		return $out;
	}

	private function combobox($lines, $hasdefaults) {
		$out = '';
		$ctlname = 'in_'.$this->name;
		$ctlstatus = '';
		if (($this->name == 'team_id' || $this->name == 'location_id') && $this->userlevel < lu_admin) {
			/* these two input controls must be disabled for employees, but at the same time a value
			   must be submitted in the form, otherwise the check of the POST fails. However, disabled
			   controls do not submit a value, so we must provide a hidden control that contains the
			   actual value to be submitted.
			*/
			$out .= '<input type=hidden name="in_'.$this->name.'" id="in_'.$this->name.'" value="'.$this->value.'">'."\n";
			$ctlname = 'dis_'.$this->name;
			$ctlstatus = ' disabled ';
		}
		$out .= "<select name=\"".$ctlname."\" id=\"".$ctlname."\" size=\"".$lines."\" ";
		$out .= $this->getClass();
		$out .= $ctlstatus.">\n";
		if ($hasdefaults == true) { 
			$out .= "<option value=\"-3\">None</option>\n";
			$out .= "<option value=\"-2\">All</option>\n";
			$out .= "<option value=\"-1\">Default</option>\n";
		}
		if (count($this->lookup) > 0) {
			foreach ($this->lookup as $lrow) {
				if ($lrow['ID'] == $this->value) {
					$out .= "<option selected value=\"".$lrow['ID']."\">".$lrow['name']."</option>\n";
				} else {
					$out .= "<option value=\"".$lrow['ID']."\">".$lrow['name']."</option>\n";
				}
			}
		}
		$out .= "</select>".$this->comment."\n";
		return $out;
	}

	private function radio() {
		// this can only handle simple yes/no radio buttons
		$out = "<input type=radio class=\"edit-ctrl\" name=\"in_".$this->name."\" id=\"in_".$this->name."_yes\" ";
		if ($this->value != 0) { $out .= "checked";}
		$out .= "> Yes \n";
		$out = "<input type=radio class=\"edit-ctrl\" name=\"in_".$this->name."\" id=\"in_".$this->name."_no\" ";
		if ($this->value == 0) { $out .= "checked";}
		$out .= "> No (".$this->comment.")\n";
		return $out;
	}

	private function image() {
		// images are displayed in reduced size. we'll do the reduction on the server, this reduces transfer time.
		// images also require a facility to support upload of a new image -> this is handled by a file select box.
		$out = "<input type=\"file\" ";
		$out .= $this->getClass();
		$out .= "size=".$this->size." value=\"".$this->value."\" name=\"in_".$this->name."\" ";
		$out .= ">".$this->comment."\n";
		return $out;
	}
	
	private function multiline() {
		$out = "<textarea ";
		$out .= $this->getClass();
		$out .= "cols=\"".$this->size."\" rows=\"".$this->length."\" name=\"in_".$this->name."\" ";
		$out .= ">".$this->value."</textarea>".$this->comment."\n";
		return $out;
	}
	
	private function editor() {
		$out = "<textarea ";
		$out .= $this->getClass();
		$out .= "cols=\"".$this->size."\" rows=\"".$this->length."\" name=\"in_".$this->name."\" id=\"in_".$this->name."\" ";
		$out .= ">".$this->value."</textarea>".$this->comment."\n";
		return $out;
	}
	
	public function checkPOST(&$item) {
	
	$cnt = 0;
	$test = true;
		foreach ($item->columns as $col) {
			$this->errflags[$col['db_name']] = false;
			if (isset($_POST['in_'.$col['db_name']])) {
				$value = $_POST['in_'.$col['db_name']];
			} else {
				$value = '';
			}
			if ($col['required'] && $value == '') {				// required, but no value -> fail
				$this->errflags[$col['db_name']] = true;
				$item->error->add("The value for the field ".$col['title']." is required.");
				$test = false;
			} elseif ($value != '') {								// has a value -> test it
				switch ($col['type']) {
					case 'N':
						if (!is_numeric($value)) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The value in ".$col['title']." is not a number.");
							$test = false;
						}
						break;
					case 'D':
						// the ereg only tests for correct format, we also need to test whether this value is actually a valid date.
						if (!ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$value)) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The value in ".$col['title']." is not in date format (YYYY-MM-DD)");
							$test = false;
						}
					   list($yy,$mm,$dd)=explode("-",$value);						
					   if (checkdate($mm, $dd, $yy) == false) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The value in ".$col['title']." is not a valid date");
							$test = false;
					   }
						break;
					case 'T':
						// the ereg only tests for correct format, we also need to test whether this value is actually a valid time.
						if (!ereg("([0-2][0-9])\:([0-5][0-9]:[0-5][0-9])",$value)) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The value in ".$col['title']." is not in time format (hh:mm:ss)");
							$test = false;
						}
						if (strtotime($value) == false) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The value in ".$col['title']." is not a valid time.");
							$test = false;
						}
						break;
					case 'P':
						if (!ereg("([^[:alnum:]])*",$value)) {
							$this->errflags[$col['db_name']] = true;
							$item->error->add("The password in ".$col['title']." contains unpermitted characters");
							$test = false;
						}
					   if ($this->company['strict_password'] == true) {
					   	if (strlen($value) < 8) {
								$this->errflags[$col['db_name']] = true;
								$item->error->add("The password in ".$col['title']." is too short (8 characters minimum)");
								$test = false;
					   	}
					   	if (!ereg(".*[0-9]+.*",$value)) {
								$this->errflags[$col['db_name']] = true;
								$item->error->add("The password in ".$col['title']." does not contain numbers");
								$test = false;
					   	}
					   	if (!ereg(".*[A-Z]+.*",$value)) {
								$this->errflags[$col['db_name']] = true;
								$item->error->add("The password in ".$col['title']." does not contain uppercase letters");
								$test = false;
					   	}
					   }
				}
			}
			$cnt++;
		}
		return $test;
	}
	
	public function checkemail($value,$emp_id) {
		if ($value == '') { return true;}			//email address is not mandatory, but must be unique
		if (!strstr($value, '@')) {
			return false;
			}
		if (!strstr($value, '.')) {
			return false;
			}
		if (strlen($value) < 8) { 
			return false;
			}
		$sql = "select emp_id from employees where company_id = ".$this->company." and email = '".$value."'";
		$data = $this->dbc->query($sql);
		if ($data == NULL) return false;
		if (count($data) > 1) { return false;}
		if (count($data) == 1) {
			if ($data[0]['emp_id'] == $emp_id) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

}


?>