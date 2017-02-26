/*
    LATimer - attendance tracking and reporting
    Version 0.1
    Copyright (C) 2006 Manticore Software

	 For contact details or details of the license refer to index.php

*/

function gI(name) { return document.getElementById(name); }
function gN(name) { return document.getElementsByName(name); }

function ShowDiv(item){

	var controls, cnt;

	switch (item.value){
	case 'rep_cards':
		gI('div_rb_range').style.visibility = 'hidden';
		gI('div_days').style.visibility = 'hidden';
		gI('div_weeks').style.visibility = 'hidden';
		gI('div_months').style.visibility = 'hidden';
		gI('div_years').style.visibility = 'hidden';
		gI('div_options').style.visibility = 'hidden';
		ShowLeaveTypes('hidden');
		break;
	case 'rep_leave':
		gI('div_rb_range').style.visibility = 'visible';
		controls = gN('rb_att_range');
		for (cnt=0;cnt<controls.length; cnt++) {
			if (controls.item(cnt).checked == true) {
				ShowDiv(controls.item(cnt));
			}
		}
		gI('div_options').style.visibility = 'visible';
		ShowLeaveTypes('visible');
		break;
	case 'rep_attend':
	case 'rep_shift':
	case 'rep_exception':
	case 'rep_lates':
	case 'rep_transfer':
	case 'rep_presence':
		ShowLeaveTypes('hidden');
		gI('div_rb_range').style.visibility = 'visible';
		controls = gN('rb_att_range');
		for (cnt=0;cnt<controls.length; cnt++) {
			if (controls.item(cnt).checked == true) {
				ShowDiv(controls.item(cnt));
			}
		}
		gI('div_options').style.visibility = 'visible';
		break;
	case 'att_emp':
		gI('div_emp').style.visibility = 'visible';
		gI('div_team').style.visibility = 'hidden';
		gI('div_dep').style.visibility = 'hidden';
		gI('div_all').style.visibility = 'hidden';
		break;
	case 'att_team':
		gI('div_emp').style.visibility = 'hidden';
		gI('div_team').style.visibility = 'visible';
		gI('div_dep').style.visibility = 'hidden';
		gI('div_all').style.visibility = 'hidden';
		break;
	case 'att_dep':
		gI('div_emp').style.visibility = 'hidden';
		gI('div_team').style.visibility = 'hidden';
		gI('div_dep').style.visibility = 'visible';
		gI('div_all').style.visibility = 'hidden';
		break;
	case 'att_all':
		gI('div_emp').style.visibility = 'hidden';
		gI('div_team').style.visibility = 'hidden';
		gI('div_dep').style.visibility = 'hidden';
		gI('div_all').style.visibility = 'visible';
		break;
	case 'att_day':
		gI('div_days').style.visibility = 'visible';
		gI('div_weeks').style.visibility = 'hidden';
		gI('div_months').style.visibility = 'hidden';
		gI('div_years').style.visibility = 'hidden';
		gI('div_days').style.zIndex = 101;
		gI('div_weeks').style.zIndex = 100;
		gI('div_months').style.zIndex = 100;
		gI('div_years').style.zIndex = 100;
		gI('in_date').focus();
		break;
	case 'att_week':
		gI('div_days').style.visibility = 'hidden';
		gI('div_weeks').style.visibility = 'visible';
		gI('div_months').style.visibility = 'hidden';
		gI('div_years').style.visibility = 'hidden';
		gI('div_days').style.zIndex = 100;
		gI('div_weeks').style.zIndex = 101;
		gI('div_months').style.zIndex = 100;
		gI('div_years').style.zIndex = 100;
		gI('in_week').focus();
		break;
	case 'att_month':
		gI('div_days').style.visibility = 'hidden';
		gI('div_weeks').style.visibility = 'hidden';
		gI('div_months').style.visibility = 'visible';
		gI('div_years').style.visibility = 'hidden';
		gI('div_days').style.zIndex = 100;
		gI('div_weeks').style.zIndex = 100;
		gI('div_months').style.zIndex = 101;
		gI('div_years').style.zIndex = 100;
		break;
	case 'att_year':
		gI('div_days').style.visibility = 'hidden';
		gI('div_weeks').style.visibility = 'hidden';
		gI('div_months').style.visibility = 'hidden';
		gI('div_years').style.visibility = 'visible';
		gI('div_days').style.zIndex = 100;
		gI('div_weeks').style.zIndex = 100;
		gI('div_months').style.zIndex = 100;
		gI('div_years').style.zIndex = 101;
		break;
	case '1':		// This is the combobox for the schedule selection;
		gI('div_weekdays').style.visibility = 'hidden';
		gI('div_monthdays').style.visibility = 'hidden';
		break;
	case '2':		// This is the combobox for the schedule selection;
		gI('div_weekdays').style.visibility = 'hidden';
		gI('div_monthdays').style.visibility = 'hidden';
		break;
	case '3':		// This is the combobox for the schedule selection;
		gI('div_weekdays').style.visibility = 'visible';
		gI('div_monthdays').style.visibility = 'hidden';
		break;
	case '4':		// This is the combobox for the schedule selection;
		gI('div_weekdays').style.visibility = 'hidden';
		gI('div_monthdays').style.visibility = 'visible';
		break;
	}
}

function ShowCombos() {
	var cnt, control;
	var list, lcnt;
	list = ['rb_type','rb_att_group','rb_att_range','rb_action'];
	for (lcnt=0;lcnt<list.length;lcnt++) {
		controls = gN(list[lcnt]);
		for (cnt=0;cnt<controls.length; cnt++) {
			if (controls.item(cnt).checked == true) {
				ShowDiv(controls.item(cnt));
			}
		}
	}
	ShowDiv(gI('in_sched'));
}

function ShowLeaveTypes(visibility) {
	gI('div_lt').style.visibility = visibility;
}

function AddItem(control_name, list_name) {
	var element;
	var list;
	var insert_element;
	var insert_index;
	var newvalue;
	var cnt;
	list = gI(list_name);
	newvalue = gI(control_name).value;
	if (list.options.length == 1) {
		if (list.options.item(0).value == 0) {
			list.remove(0);
		}
	}
	insert_element = null;
	insert_index = list.options.length;
	for (cnt=0;cnt<list.options.length;cnt++) {
		if (list.options.item(cnt).value == newvalue) {
			alert('This item is already on the list.');
			return;
		}
		if (list.options.item(cnt).value > newvalue) {
			insert_element = list.options.item(cnt);
			insert_index = cnt;
			break;
		}
	}
	element = document.createElement('OPTION');
	element.value = newvalue;
	element.text = newvalue;
	try {
		list.add(element,insert_element);
	} catch (e) {
		list.add(element, insert_index);
	}
}

function RemoveItem(list_name) {
	var cnt;
	var list;
	
	list = gI(list_name);
	for (cnt=0;cnt<list.options.length;cnt++) {
		if (list.options.item(cnt).selected == true) {
			list.remove(cnt);
		}
	}
	if (list.options.length == 0) SetListDefault(list);
}

function SetListDefault(list) {
	element = document.createElement('OPTION');
	element.value = 0;
	if (list.id == 'in_dates') {
		element.text = 'Add a date';
	} else {
		element.text = 'Add a week';
	}
	try {
		list.add(element,null);
	} catch (e) {
		list.add(element, 0);
	}
}

function ClearList(list_name) {
	var list;
	list = gI(list_name);
	while (list.length > 0) {
		list.remove(0);
	}
	SetListDefault(list);
}

function SelectItem(control_name, list_name) {
	var item;
	var options;
	options = gI(list_name).options;
	item = options.item(gI(list_name).selectedIndex);
	gI(control_name).value = item.value;
}

function ConvertOptions(list_name) {
	list = gI(list_name);
	item_text = '';
	for (cnt=0; cnt < list.options.length; cnt++) {
		if (list.options.item(cnt).selected == true) {
			if (item_text != '') item_text += ',';
			item_text += list.options.item(cnt).value;
		}
	}
	hidden_item = gI(list_name+'_text');
	hidden_item.value = item_text;
}

function SubmitReport() {
	var list, cnt;
	list = gI('in_dates');
	if (!gI('rep_cards').checked) {
		if (gI('rb_att_day').checked == true && list.options.length == 1 && list.options.item(0).value == 0) {
			alert ('You must add at least one date.');
			return; 
		}
		for (cnt=0; cnt < list.options.length; cnt++) {
			list.options.item(cnt).selected = true;
		}
		list = gI('in_weeks');
		if (gI('rb_att_week').checked == true && list.options.length == 1 && list.options.item(0).value == 0) {
			alert ('You must add at least one week.');
			return; 
		}
		for (cnt=0; cnt < list.options.length; cnt++) {
			list.options.item(cnt).selected = true;
		}
	}
	ConvertOptions('in_dates');
	ConvertOptions('in_weeks');
	ConvertOptions('sel_months');
	ConvertOptions('sel_years');
	ConvertOptions('sel_emp');
	ConvertOptions('sel_team');
	ConvertOptions('sel_dep');
	ConvertOptions('sel_leave_type');
	gI('latform').submit();
}