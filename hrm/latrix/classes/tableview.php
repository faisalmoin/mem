<?php 

require_once("classes/navigator.php");
require_once("classes/filter.php");

class	TableView {

	public function __construct(&$page,&$db_conn, &$errorbox) {
	
		$this->dbc = $db_conn;
		$this->errorbox = $errorbox;
		$this->page = $page;
		$this->subject = $page->ctrl['subject'];
		$sql = "SELECT dc.* FROM data_columns dc INNER JOIN subjects s USING (subject_id) WHERE dc.visible = true AND s.name='".$this->subject."' ORDER BY dc.sequence ASC";
		$this->cols = $this->dbc->query($sql);
		$this->isFaulty = false;
		$data = $this->dbc->query("SELECT query, help_url FROM subjects where name='".$this->subject."'");
		$sql = $data[0]['query'];
		$this->help_url = $data[0]['help_url'];
		if ($page->ctrl['subsubject'] != 'None') {
			$sql = str_replace("%employee%", $page->ctrl['subrecord'], $sql);
			$sql = str_replace("%department%", $page->ctrl['subrecord'], $sql);
			}
		// here we need to add the conditions limiting the data to the userlevel, we'll use the %company% placeholder for this, which 
		// has to be in every query anyway and if it is not there, no damage will be done.
		// owner or director or admin = no restrictions
		// manager = only members of the department or teams of the department or the department itself
		// WHERE e.company_id = <cid> AND d.dept_id = <manager's dept id> for employees
		// WHERE t.company_id = <cid> AND d.dept_id = <manager's dept id> for teams
		// WHERE t.company_id = <cid> AND d.dept_id = <manager's dept id> for departments
		// employee  = only himself, no teams, no departments
		// WHERE e.company_id = <cid> AND e.emp_id = <own id> for employees
		switch ($page->config['user_level']) {
			case lu_employee:
					$where = $page->company['company_id'].' AND e.emp_id='.$page->config['user_id'];
					break;
			case lu_manager:
					$where = $page->company['company_id'].' AND (d.manager_id='.$page->config['user_id'].' OR e.emp_id='.$this->page->config['user_id'].')';
					break;
			case lu_admin:
			case lu_gm:
			case lu_owner:
					$where = $page->company['company_id'];
		}
		if ($page->company['show_disabled_items'] == 0 && $page->ctrl['subject'] == 'Employees') {
			$where .= ' AND e.enabled = 1';
		}
		$sql = str_replace("%company%", $where, $sql);
		$sql = str_replace("%order%", $this->page->ctrl['column']." ".$this->page->ctrl['order'], $sql);
		
		// this next section retrieves the total number of records in this view. this is required by the navigator. 
		$pos_from = strpos($sql,"FROM ");
		$pos_order = strpos($sql, "ORDER BY ");
		if ($pos_from === false || $pos_order === false) {
			//$this->errorbox->debug($sql);
			//what to do ? This query should include the keyword FROM !!!. Must display an error and prevent further execution.
			$this->errorbox->add('The database has been damaged (subject queries), please contact the system administrator.');
			$this->isFaulty = true;
		} else {
			$data = $this->dbc->query("SELECT count(*) as rows ".substr($sql,$pos_from, $pos_order-$pos_from));
			if (strpos($sql, "GROUP BY ") > 0) {
				$this->count = count($data);
			} else {
				$this->count = $data[0]['rows'];
			}
		}
		$this->sql = $sql." LIMIT ".($page->ctrl['page']-1)*$page->company['page_size'].",".$page->company['page_size'];
		$this->errorbox->debug($this->sql);
		$this->navbar = new Navigator($page,$this->getCount());
		$this->filter = new Filter($this->cols);
	}
	
	public function getCount() {
	
		if ($this->isFaulty) {
			return 0;
		}
		return $this->count;
	}
	
	public function show() {
	
		if ($this->isFaulty) { return;}

		$data = $this->dbc->query($this->sql);
		$displayID = (($this->page->ctrl['page']-1)*$this->page->company['page_size'])+1;
		if (count($this->cols)>1) { $span=2;} else { $span=1;}
	
		$out = '<table cellpadding="0px" cellspacing="0px" class="data-table">'."\n";
		$out .= "\t<thead>\n";
		$out .= "\t<tr>\n";
		$out .= "\t\t<td class=\"td-left\" colspan=".$span."><h1>".$this->subject;
		if ($this->page->ctrl['subsubject'] != 'None') {
			$out .= " for ".$this->page->ctrl['title'];
		}
		$out .= "</h1></td>\n";
		$out .= "\t\t<td class=\"td-right\" colspan=\"".(count($this->cols)-1)."\">\n";
//		$out .= $this->filter->show();
		$out .= $this->navbar->build4pages();
		$out .= "\t\t</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t<tr>\n";

		// First we build the header row
		foreach ($this->cols as $col) {
			$out .= "\t\t<td class=\"data-head\"";
			if ($col['width'] > 25 ) {
				$width = 25;
			} else {
				$width = $col['width'];
			}
			$out .= " style=\"width:".$width."%; text-align:";
			switch ($col['align']) {
				case 'R':
					$out .= " right;";
					break;
				case 'L':
					$out .= " left;";
					break;
				case 'C':
					$out .= " center;";
					break;
				}
			$out .= "\">";
			if ($col['db_name'] == $this->page->ctrl['column']) {
				//this is the order column 
				if ($this->page->ctrl['order'] == 'ASC') {
					$out .= "<a href=\"#\" title=\"Order by this column\" onclick=\"SetOrder('".$col['db_name']."','DESC');\">".$col['title'];
					$out .= "&nbsp;<img src=\"images/up.gif\" alt=\"up\"></a></td>\n";
				} else {
					$out .= "<a href=\"#\" title=\"Order by this column\" onclick=\"SetOrder('".$col['db_name']."','ASC');\">".$col['title'];
					$out .= "&nbsp;<img src=\"images/down.gif\" alt=\"down\"></a></td>\n";
				}
			} else {
				//this not the order column
				$out .= "<a href=\"#\" title=\"Order by this column\" onclick=\"SetOrder('".$col['db_name']."','ASC');\">".$col['title']."</a></td>\n";
			}
		}
		//the final column is always the action column, with links for edit, delete, e-mail (only for employees).
		$out .= "\t\t<td class=\"data-head\" style=\"text-align:right;\">Action</td>\n";
		$out .= "\t</tr>\n";
		$out .= "\t</thead>\n";
		
		if ($data == '') {
			$out .= "</table>\n";
			$this->errorbox->add('There are no records to display.');
			return $out;
		}

		$out .= "\t<tbody>\n";
		//Now we loop through the data
		$cnt = 1;
		foreach ($data as $row) {
			// the first column is always a link to view the details;
			if ($cnt++ % 2 == 0) {
				if ($this->isOpenApplication($row)) {
					$out .= "\t\t<tr class=\"odd-row-open\">\n";
				} else {
					$out .= "\t\t<tr class=\"odd-row\">\n";
				}
			} else {
				if ($this->isOpenApplication($row)) {
					$out .= "\t\t<tr class=\"even-row-open\">\n";
				} else {
					$out .= "\t\t<tr class=\"even-row\">\n";
				}
			}
			$out .= "\t\t<td style=\"text-align:";
			switch ($this->cols[0]['align']) {
				case 'R':
					$out .= " right;";
					break;
				case 'L':
					$out .= " left;";
					break;
				case 'C':
					$out .= " center;";
					break;
				}
			$out .= "\"><a href=\"#\" title=\"Show Details\" onclick=\"SetAction('".$row[0]."','".$displayID."','view');\">".$row[$this->cols[0]['db_name']]."</a></td>\n";
			for ($i = 1; $i < count($this->cols); $i++) {
				$out .= "\t\t<td class=\"data-table\"";
				$out .= " style=\"text-align:";
				switch ($this->cols[$i]['align']) {
					case 'R':
						$out .= " right;";
						break;
					case 'L':
						$out .= " left;";
						break;
					case 'C':
						$out .= " center;";
						break;
					}
				$out .= "\">";
				if($this->cols[$i]['type'] == 'B') {
					if ($row[$this->cols[$i]['db_name']] == 0) {
						$out .= "No</td>\n";
					} else {
						$out .= "Yes</td>\n";
					}
				} elseif($this->cols[$i]['type'] == 'D') {
					if ($row[$this->cols[$i]['db_name']] == '0000-00-00') {
						$out .= "---</td>\n";
					} else {
						$out .= $row[$this->cols[$i]['db_name']]."</td>\n";
					}
				} elseif($this->cols[$i]['format'] != '') {
					$out .= sprintf($this->cols[$i]['format'], $row[$this->cols[$i]['db_name']])."</td>\n";
				} else {
					$out .= $row[$this->cols[$i]['db_name']]."</td>\n";
				}
			}
			//
			$out .= "\t\t<td class=\"data-table\" style=\"text-align:right;\">\n"; 
			$out .= "\t\t\t<a href=\"#\" title=\"Edit this record\" onclick=\"SetAction('".$row[0]."','".$displayID."','edit');\"><img src=\"images/edit.gif\" alt=\"edit this record\" class=\"img-link2\"></a>\n";
			if ($this->subject != 'Email Templates' && $this->subject != 'Config') {
				$out .= "\t\t\t<a href=\"#\" title=\"Delete this record\" onclick=\"SetAction('".$row[0]."','".$displayID."','delete');\"><img src=\"images/delete.gif\" alt=\"delete this record\" class=\"img-link2\"></a>\n";
			}
			if ($this->subject == 'Employees' || $this->subject == 'Teams' || $this->subject == 'Departments') {
				$out .= "\t\t\t<a href=\"#\" title=\"Send e-mail\" onclick=\"SetAction('".$row[0]."','".$displayID."','mail');\"><img src=\"images/sendmail.gif\" alt=\"send a message\" class=\"img-link2\"></a>\n";
			} elseif (($this->subject == 'Exceptions' || $this->subject == 'Leave' || $this->subject == 'Half days off') && 
						  $this->page->config["user_id"] != $row["emp_id"]) {
				$out .= "\t\t\t<a href=\"#\" title=\"Approve this application\" onclick=\"SetAction('".$row[0]."','".$displayID."','approve')\";><img src=\"images/accept.gif\" alt=\"approve\" class=\"img-link2\"></a>\n";
				$out .= "\t\t\t<a href=\"#\" title=\"Decline this application\" onclick=\"SetAction('".$row[0]."','".$displayID."','decline')\";><img src=\"images/decline.gif\" alt=\"decline\" class=\"img-link2\"></a>\n";
			}
			$out .= "\t\t</td></tr>\n";
			$displayID++;
		}
		// now show another navigator to make life easier.
		$out .= "\t<tr>\n";
		$out .= "\t\t<td class=\"td-right-nav\" colspan=\"".(count($this->cols)+1)."\">\n";
		$out .= $this->navbar->build4pages();
		$out .= "\t\t</td>\n";
		$out .= "\t</tr>\n"; 
		$out .= "\t</tbody>\n";
		$out .= "\t</table>\n";
		return $out;
	}
	
	private function isOpenApplication($row) {
		if ($this->subject == 'Exceptions' || $this->subject == 'Leave' || $this->subject == 'Half days off') {
			if ($row['approval_date'] == '0000-00-00') {
				return true;
			} else {
				return false;
			}
		}
	}

}

?>