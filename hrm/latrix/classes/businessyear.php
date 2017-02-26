<?php

require_once("classes/dbobject.php");

class BusinessYear extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Business Year";
		$this->idcol = "business_year_id";
		$this->tablename = "business_years";
		$this->sql_fields = 'SELECT b.business_year_id, b.year_name, b.year_start, b.year_end ';
		$this->sql_from = ' FROM business_years b ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT b.business_year_id ';
		$this->subject_id = 19;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 19 AND editable = 1 ORDER BY sequence");
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE b.company_id = '.$this->page->company['company_id'];
		return $sql;
	}

	public function checkData() {
	
		// need to parse all the POST data through various checkers using the data_columns. String length is not a problem, though.
		return $this->control->checkPOST($this);
	}

	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Business Year";
		}
		return $this->data[0]['year_name'];
	}

	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Something</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Whatever</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Something else</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>Whatever</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	

	}
	public function activities() {
	
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Activities</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','edit');\">Edit</a></td>\n";
		$out .= "            <td class=\"td-right\">&nbsp;</td></tr>\n";
		$out .= "        <tr><td class=\"td-left\"><a href=\"#\" onclick=\"SetAction('";
		$out .= $this->page->ctrl['record']."','".$this->page->ctrl['display']."','delete');\">Delete</a></td>\n";
		$out .= "				<td>&nbsp;</td>";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>