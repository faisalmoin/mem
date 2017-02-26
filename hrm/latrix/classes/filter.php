<?php

class Filter {

/*
	The filter works on any subject. It can be shown anywhere on the table view page. It displays 2 combos and a value control.
	The first combo contains the column names, which are received from the subject. 
	The second combo contains the operators, which are based on the column data types as per column descriptors.
	The value control is dependant in type on the operator selected. It can be a text input, a combo or a checkbox.  

	The filter uses AJAX. Once a subject page is loaded, any subsequent change to the column selection or operator selection triggers
	a callback to the server to update the content for the other input controls. 
	When the user clicks on 'Apply', the page is submitted for reloading with the filter condition applied. Any change of subject 
	must reset the filter.
	
	In order to do all of this there are 3 elements to the filter: 
	a) the class that is instantiated in the table view.
	b) the javascript that handles the events and the callbacks
	c) the callback class that thandles the calls from the browser
	
	How to test:
	1) filter methods: constructor, 
	
	
	construct
	pass descriptor array in
	set current filter settings (column, operator, value)
	retrieve query condition	
	produce the filter bar
	

*/
	public static $ops = array(
				'EQUAL'		=> array( 'value'=>'=', 'text'=>'is equal to'),
				'MORE'		=> array( 'value'=>'>', 'text'=>'is greater than'),
				'LESS'		=> array( 'value'=>'<', 'text'=>'is less than'),
				'LIKE'		=> array( 'value'=>'LIKE', 'text'=>'contains'),
				'IN'			=> array( 'value'=>'IN', 'text'=>'is one of'),
				'EQUAL_MORE'=> array( 'value'=>'>=', 'text'=>'is equal or greater than'),
				'EQUAL_LESS'=> array( 'value'=>'=<', 'text'=>'is equal or less than'),
				);

	var $_operator;
	var $_column;
	var $_value;
	var $_cols;

	public function __construct(&$cols) {
		$this->_cols = $cols;
		if (!isset($_POST['fl_op'])) {
			$this->_operator = '=';
		} else {
			$this->_operator = $_POST['fl_op'];
		}
		if (!isset($_POST['fl_column'])) {
			$this->_column = '';
		} else {
			$this->_column = $_POST['fl_column'];
		}
		if (!isset($_POST['fl_value'])) {
			$this->_value = '';
		} else {
			$this->_value = $_POST['fl_value'];
		}
	}
	
	public function getCondition() {
		if ($this->_value == '') { return ''; }
		return $this->_column.' '.Filter::$ops[$this->_operator]['value'].' '.$this->_value;
	}
	
	public function setOperator($op) {
		if (Filter::$ops[$op]['value'] == '') {
			throw new Exception('Undefined filter operator: '.$op);
		}
		$this->_operator = $op;
	}

	public function setColumn($col) {
		$this->_column = $col;
	}

	public function setValue($val) {
		$this->_value = $val;
	}
	
	private function getColumnData() {
		$out = '';
		foreach ($this->_cols as $col) {
			$out .= $col['db_name'].','.$col['type'].':';
		}
		return $out;
	}

	private function combo_columns() {
		$out = "<select name=\"fl_column\" id=\"fl_column\" size=\"1\" ";
		$out .= "class=\"nav-bar\" onchange=\"changeColumn(this);\">\n";
		if (count($this->_cols) > 0) {
			foreach ($this->_cols as $col) {
				if ($col['db_name'] == $this->_column) {
					$out .= "\t<option selected value=\"".$col['db_name']."\">".$col['title']."</option>\n";
				} else {
					$out .= "\t<option value=\"".$col['db_name']."\">".$col['title']."</option>\n";
				}
			}
		}
		$out .= "</select>\n";
		return $out;
	}
	
	private function combo_ops() {
		$out = "<select name=\"fl_op\" id=\"fl_op\" size=\"1\" ";
		$out .= "class=\"nav-bar\">\n";
		foreach (Filter::$ops as $op) {
			if ($op['value'] == $this->_operator) {
				$out .= "\t<option selected value=\"".$op['value']."\">".$op['text']."</option>\n";
			} else {
				$out .= "\t<option value=\"".$op['value']."\">".$op['text']."</option>\n";
			}
		}
		$out .= "</select>\n";
		return $out;
	}
	
	public function show() {
		// We need a combobox for the column names, a combobox for the operator and an input control for the value
		// the input control for the value depends on the type of the selected column.
		// We also need a couple of hidden inputs to persist the filter settings. And we need two sets, for the main subject and the sub
		// subject.
		$out = '<div id="filter-bar" class="nav-bar">'."\n";
		$out .= '<input type="hidden" id="filter_column" name="filter_column" value="">'."\n"; 
		$out .= '<input type="hidden" id="filter_op" name="filter_op" value="">'."\n"; 
		$out .= '<input type="hidden" id="filter_value" name="filter_value" value="">'."\n"; 
		$out .= '<input type="hidden" id="sub_filter_column" name="sub_filter_column" value="">'."\n"; 
		$out .= '<input type="hidden" id="sub_filter_op" name="sub_filter_op" value="">'."\n"; 
		$out .= '<input type="hidden" id="sub_filter_value" name="sub_filter_value" value="">'."\n";
		$out .= '<input type="hidden" id="coldata" name="coldata" value="'.$this->getColumnData().'">'."\n";
		$out .= "<b>Filter:</b> ";
		$out .= $this->combo_columns();
		$out .= '&nbsp;'."\n";
		$out .= $this->combo_ops();
		$out .= '&nbsp;'."\n";
		$out .= '<input class="nav-bar" type="text" id="fl_value" name="fl_value" value="">';
		$out .= '&nbsp;'."\n";
		$out .= '<input class="nav-bar" onclick="applyFilter();" type="button" id="btn_filter_apply" name="btn_filter_apply" value="Apply">&nbsp;'."\n";
		$out .= '<input class="nav-bar" onclick="resetFilter();" type="button" id="btn_filter_reset" name="btn_filter_reset" value="Reset">'."\n";
		$out .= '</div>'."\n";
		return $out;
	}

}
?>
