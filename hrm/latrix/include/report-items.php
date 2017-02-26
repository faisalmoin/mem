<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006 Manticore Software

	 For contact details or details of the license refer to index.php
*/

function show_combo_box(&$data, $name, $multi) {
	return show_combobox($data, $name, $multi, 12);
}

function show_combobox(&$data, $name, $multi, $lines) {
// shows a list box with single selection
	if ($multi) {
		$out = "<select multiple"; 
	} else {
		$out = "<select";
	}
	if ($lines > 1) {
		$out .= " size=".$lines." name=\"".$name."\" id=\"".$name."\">\n";
	} else {
		$out .= " name=\"".$name."\" id=\"".$name."\">\n";
	}
	if ($data != NULL && count($data) > 0) {
		foreach ($data as $row) {
			$out .= "\t<option ";
			if ($row[0] == $data[0][0]) {
				$out .= "selected";
			}
			$out .= " value=\"${row[0]}\">${row[1]}</option>\n";
			}
//		} else {
//			$out .= "<option value=\"0\">empty</option>\n";
		} 
	$out .= "</select>\n";
	$out .= "<input type=\"hidden\" name=\"".$name."_text\" id=\"".$name."_text\">\n";
	return $out;
}

function show_employees($cid){
	global $db_conn;
	global $config;
	$show_enabled_sql = "";
	if ($config->company['show_disabled_items'] == 0) {
		$show_enabled_sql = " AND e.enabled = 1 ";
	}
	switch ($config->config['user_level']) {
		case lu_employee:
			$sql = "SELECT emp_id as ID, concat(sname, ', ',fname) as name 
					  FROM employees WHERE company_id=".$cid." AND emp_id =".$config->config['user_id']." ORDER BY name ASC;";
			break;
		case lu_manager:
			$sql = "SELECT emp_id as ID, concat(sname, ', ',fname) as name FROM employees e
					  INNER JOIN teams t USING (team_id) INNER JOIN departments d on t.dept_id = d.dept_id
					  WHERE d.company_id=".$cid.$show_enabled_sql." AND (e.emp_id=".$config->config['user_id']." OR d.manager_id=".$config->config['user_id'].") ORDER BY name ASC";
			break;
		case lu_admin:
		case lu_gm:
		case lu_owner:
			$sql = "SELECT emp_id as ID, concat(sname, ', ',fname) as name 
					  FROM employees e WHERE company_id=".$cid.$show_enabled_sql." ORDER BY name ASC;";
	}
	$data = $db_conn->query($sql);
	return show_combo_box($data,"sel_emp",true);
}

function show_teams($cid){
	global $db_conn;
	global $config;
	switch ($config->config['user_level']) {
		case lu_employee:
			$sql = "SELECT team_id as ID, name FROM teams where company_id=".$cid." AND 1 = 0 ORDER BY name ASC"; 
			break;
		case lu_manager:
			$sql = "SELECT team_id as ID, t.name FROM teams t INNER JOIN departments d USING (dept_id)
					  WHERE d.company_id=".$cid." AND d.manager_id=".$config->config['user_id']." ORDER BY name ASC";
			break;
		case lu_admin:
		case lu_gm:
		case lu_owner:
			$sql = "SELECT team_id as ID, name FROM teams where company_id=".$cid." ORDER BY name ASC";
	}
	$data = $db_conn->query($sql);
	return show_combo_box($data,"sel_team",true);
}

function show_departments($cid){
	global $db_conn;
	global $config;
	switch ($config->config['user_level']) {
		case lu_employee:
			$sql = "SELECT dept_id as ID, name FROM departments WHERE company_id=".$cid." AND 1 = 0 ORDER BY name ASC"; 
			break;
		case lu_manager:
			$sql = "SELECT dept_id as ID, name FROM departments d WHERE company_id=".$cid." 
					  AND d.manager_id=".$config->config['user_id']." ORDER BY name ASC"; 
			break;
		case lu_admin:
		case lu_gm:
		case lu_owner:
			$sql = "SELECT dept_id as ID, name FROM departments d WHERE company_id=".$cid." ORDER BY name ASC"; 
			break;
	}
	$data = $db_conn->query($sql);
	return show_combo_box($data,"sel_dep",true);
}

function show_months($cid){

	/*	This builds a list of 12 months prior and after the current month. */
	$month = date('n');
	$year = date('Y')-1;
	for ($cnt=0;$cnt <25;$cnt++) {
		$value = date('Y-m', mktime(12,0,0,$month+$cnt,10,$year));
		$data[$cnt] = array($value, $value);
	}
	return show_combo_box($data,"sel_months",true);
}

function show_years($cid){
	global $db_conn;
	$data = $db_conn->query("SELECT business_year_id as ID, year_name FROM business_years WHERE company_id=".$cid);
	return show_combo_box($data,"sel_years",false);
}

function show_leave_types($cid){
	global $db_conn;
	$data = $db_conn->query("SELECT leave_type_id as ID, name FROM leave_types WHERE company_id=".$cid);
	return show_combobox($data,"sel_leave_type",true,4);
}
?>