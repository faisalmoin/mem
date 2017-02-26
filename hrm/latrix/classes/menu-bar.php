<?php 

class	MenuBar {

	var	$dbc;
	var	$page;
	var	$actions;
	var	$subjects; 

	public function __construct(&$page, &$db_conn) {
	
		$this->dbc = $db_conn;
		$this->page = $page;
		$sql = "SELECT a.* FROM actions a INNER JOIN subjects s USING (subject_id) WHERE s.name='".$page->ctrl['subject']."' AND user_level <=".$page->config['user_level'];
		$this->actions = $this->dbc->query($sql); 
		$sql = "SELECT * FROM subjects WHERE parent = 0 ORDER BY sequence ASC";
		$this->subjects = $this->dbc->query($sql);
	
	}

	public function build() { 
	
		$out = "<table cellpadding=\"0px\" cellspacing=\"0px\" class=\"menu-bar\">\n";
		$out .= "\t<tr>\n";
		foreach ($this->subjects as $subject) {
			$out .= "\t\t<td class=\"spacer\">&nbsp;</td>\n";
			if ($this->page->ctrl['subject'] == $subject['name']) {
				$out .= "\t\t<td class=\"selected\"><a href='#' onclick=\"SelectSubject('".$subject['name']."','show');\">".$subject['name']."</a></td>\n";
			} elseif ($this->page->config['user_level'] >= $subject['level']) {
				$out .= "\t\t<td class=\"normal\"><a href='#' onclick=\"SelectSubject('".$subject['name']."','show');\">".$subject['name']."</a></td>\n";
			} else {
				$out .= "\t\t<td class=\"disabled\">".$subject['name']."</td>\n";
			}
		}
		$out .= "\t\t<td class=\"spacer\">&nbsp;</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td>&nbsp;</td>\n";
		$out .= "\t\t<td colspan=".(count($this->subjects)*2-6)." class=\"menu-links\" style=\"text-align: left; height: 24pt;\">\n"; 
		if (count($this->actions) > 0) {
			foreach ($this->actions as $action) {
				$out .= "\t\t\t<a href='#' onclick=\"SubmitForm('".$this->page->ctrl['subject']."','".$action['action']."');\">".$action['name']."</a>";
				$out .= "&nbsp;::&nbsp;\n";
				}
			}
		if ($this->page->ctrl['subrecord'] != 0) {
			$out .= "\t\t\t<a href='#' onclick=\"RestoreSubject();\">Back to ".$this->page->ctrl['title']."</a>"; 
		} else {
			if ($this->page->ctrl['action'] != 'show' && $this->page->ctrl['action'] != 'none') {
				$out .= "\t\t\t<a href='#' onclick=\"BackToSubject();\">Back to ".$this->page->ctrl['subject']."</a>"; 
			}
		}
		$out .= "\t\t<input type=\"hidden\" name=\"txtsubject\" id=\"txtsubject\" value=\"".$this->page->ctrl['subject']."\">\n"; 
		$out .= "\t\t<input type=\"hidden\" name=\"txtsubsubject\" id=\"txtsubsubject\" value=\"".$this->page->ctrl['subsubject']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtrecord\" id=\"txtrecord\" value=\"".$this->page->ctrl['record']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtdisplay\" id=\"txtdisplay\" value=\"".$this->page->ctrl['display']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtsubrecord\" id=\"txtsubrecord\" value=\"".$this->page->ctrl['subrecord']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txttitle\" id=\"txttitle\" value=\"".$this->page->ctrl['title']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtaction\" id=\"txtaction\" value=\"".$this->page->ctrl['action']."\">\n"; 
		$out .= "\t\t<input type=\"hidden\" name=\"txtmode\" id=\"txtmode\" value=\"".$this->page->ctrl['mode']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtpage\" id=\"txtpage\" value=\"".$this->page->ctrl['page']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtcolumn\" id=\"txtcolumn\" value=\"".$this->page->ctrl['column']."\">\n";
		$out .= "\t\t<input type=\"hidden\" name=\"txtorder\" id=\"txtorder\" value=\"".$this->page->ctrl['order']."\">\n";
		$out .= "\t\t<input type=\"submit\" value=\"submit\" name=\"btnsubmit\" id=\"btnsubmit\" style=\"visibility: hidden;\">\n";

		$out .= "\t\t</td>\n";
		$out .= "\t\t<td class=\"td-right\" colspan=\"5\">".$this->page->getcompanyName()."</td><td></td>\n";
		$out .= "\t</tr>\n";
		$out .= "</table>\n";
		return $out;
	}
}

?>