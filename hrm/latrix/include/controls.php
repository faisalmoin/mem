<?php

function show_list_box(&$data,&$selrow) {
// shows a list box with single selection
	$out = "<select size=20 name=\"seldata\" id=\"seldata\" onChange=\"javascript: UpdateItems(this);\">\n";
	if ($data != NULL && count($data) > 0) {
		$cnt = 0;
		foreach ($data as $row) {
			$out .= "\t<option ";
			if ($cnt == $selrow) {
				$out .= "selected";
				}
			$out .= " value=\"${row[0]}\">${row[1]}</option>\n";
			$cnt++;
			}
		} else {
			$out .= "<option value=\"0\"><empty></option>\n";
		}
	$out .= "</select>";
	return $out;
}

function show_combo_box(&$data,&$selrow,$idx) {
// shows a combo box with single selection
	$out = "<select size=1 name=\"selsub${idx}\" id=\"selsub${idx}\">\n";
	$out .= "<option value=\"0\">&lt;none&gt;</option>\n"; 
	if ($data != NULL && count($data) > 0) {
		foreach ($data as $row) {
			$out .= "\t<option ";
			if ($row[0] == $selrow) {
				$out .= "selected";
				}
			$out .= " value=\"${row[0]}\">${row[1]}</option>\n";
			} 
		}
	$out .= "</select>";
	return $out;
}

function ifNULL($value) {
	if (!isset($value)) {
		return "00:00:00";
	}
	if (is_null($value)) {
		return "00:00:00";
	}
	return $value;
}

?>