/* 
	Filter.js

	This file contains the browser side functionality for the record filters in LATRIX
	The filter is available in all subjects and sub-subjects, in table view mode.
	The user can select a column, an operator and a value, then apply or reset the filter
	Filter settings are persisted across record actions.
	
	When a user selects a column, the list of operators is limited to those that are applicable to
	the column type. In order to enable this, the relevant meta-data about columns is loaded into the 
	browser by means of a long string, where columns are separated by ":" and items by ",".
	Column selection also alters the input control that is shown, according to the list below.
	
							Operator				=		>		<		LIKE	IN		>=		<=
	
	Type					Control
	N Numeric			text					.		.		.		n/a	.		.		.
	C String				text					.		n/a	n/a	.		.		n/a	n/a
	T Time				text					.		.		.		n/a	.		.		.		(requires syntax check before submit)
	P Password			text					.		n/a	n/a	.		.		n/a	n/a
	D Date				text w. picker		.		.		.		n/a	.		.		.		(requires syntax check before submit)
	S Combobox			list					.		n/a	n/a	n/a	.		.		.		(with multi-select box)
	R Radio button		yes/no				.		n/a	n/a	n/a	n/a	n/a	n/a		
	I Image				not implemented yet
	B Checkbox			yes/no				.		n/a	n/a	n/a	n/a	n/a	n/a	
 
 	The LIKE operator must enclose the value with percent signs.

	The metadata about columns in the recordset contains for each column:
	db_name, type,  

*/ 

var	controls;
var	columns;
var 	operators;
var 	i;

function initFilter() {

	controls = new Array(new Array('N',1,1,1,0,1,1,1),
								new Array('C',1,0,0,1,1,0,0),
								new Array('T',1,1,1,0,1,1,1),
								new Array('P',1,0,0,1,0,0,0),
								new Array('D',1,1,1,0,1,1,1),
								new Array('S',1,0,0,1,1,1,1),
								new Array('R',1,0,0,0,0,0,0),
								new Array('I',0,0,0,0,0,0,0),
								new Array('B',1,0,0,0,0,0,0));
	operators = new Array(
						new Array('EQUAL', '=', 'is equal to'),
						new Array('MORE',  '>', 'is greater than'),
						new Array('LESS',  '<', 'is less than'),
						new Array('LIKE',  'LIKE', 'contains'),
						new Array( 'IN',   'IN', 'is one of'),
						new Array('EQUAL_MORE', '>=', 'is equal or greater than'),
						new Array('EQUAL_LESS', '=<', 'is equal or less than')
				);
	columns = document.getElementById('coldata').value.split(":");
	for (i=0; i<columns.length; i++) {
		columns[i] = columns[i].split(",");
		}
	}

function changeColumn(select_col) {
	for (i=0; i<columns.length; i++) {
		if (columns[i][0] == select_col.value) {
			column = columns[i];
		}
	}
	for (i=0; i<controls.length; i++) {
		if (controls[i][0] == column[1]) {
			control = controls[i];
		}
	}
	// now empty the operator comobox, then fill it with the applicable items.
	list = document.getElementById('fl_op');
	while (list.length > 0) {
		list.remove(0);
	}
	insert_element = null;
	insert_index = 0;
	for(i=0; i<operators.length; i++) {
		if (control[i+1] == 1) {
			element = document.createElement('OPTION');
			element.value = operators[i][1];
			element.text = operators[i][2];
			try {
				list.add(element,insert_element);
			} catch (e) {
				list.add(element, insert_index);
			}
			insert_index++;
			insert_element = element;
		}
	}
	// create a new control
	ctrl = document.createElement('INPUT');
	ctrl.id = 'fl_value';
	ctrl.setAttribute('name','fl_value');
	ctrl.setAttribute('class','nav-bar');
	ctrl2 = null;
	switch(column[1]) {
		case 'N':
		case 'C':
		case 'T':
		case 'P':
				// these all require a text control
				ctrl.setAttribute('type','TEXT');
				ctrl.setAttribute('size',20);
				break;
		case 'D':
				// requires a text control with date picker
				ctrl.setAttribute('type','TEXT');
				ctrl.setAttribute('size',20);
				ctrl2 = ctrl;
				ctrl = document.createElement('IMG');
				ctrl.setAttribute('src','images/scw.gif');
				if (ctrl.addEventListener) {
					ctrl.addEventListener('onclick',scwShow(scwID('fl_value'),this),false);
				} else {
					ctrl.attachEvent('onclick',scwShow(scwID('fl_value'),this));
				}
				break;
		case 'S':
				// requires a combobox, filled by ajax call-back
				ctrl.setAttribute('type','SELECT');
				ctrl.setAttribute('size',1);
				// now get the stuff to make up the options
				break;
		case 'R':
		case 'B': 
				// requires two radio buttons
				ctrl.setAttribute('type','RADIO')
				ctrl.id = 'fl_value_yes';
				ctrl.checked = true;
				ctrl.setAttribute('value','Yes');
				ctrl2 = document.createElement('INPUT');
				ctrl2.setAttribute('type','RADIO')
				ctrl2.id = 'fl_value_no';
				ctrl2.setAttribute('name','fl_value');
				ctrl2.setAttribute('class','nav-bar');
				ctrl2.checked = false;
				ctrl2.setAttribute('value','No');
				break;
		case 'I':
				// not yet implemented, possibly doesn't make much sense. 
				// requires two radio buttons 
				break;
	}
	
	// replace the value control.
	filter = document.getElementById('filter-bar');
	input_ctrl= document.getElementById('fl_value');
	if (ctrl2 != null) {
		filter.replaceChild(ctrl2,input_ctrl);
		filter.insertBefore(ctrl,ctrl2);
	} else {
		filter.replaceChild(ctrl,input_ctrl);
	}
}


function applyFilter() {
}

function resetFilter() {
}
