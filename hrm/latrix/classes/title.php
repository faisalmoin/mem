<?php

require_once("classes/subdbobject.php");

class Title extends SubDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Title";
		$this->idcol = "title_id";
		$this->tablename = "titles ";
		$this->sql_fields = 'SELECT title_id, name';
		$this->sql_from = ' FROM titles ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT title_id ';
		$this->subject_id = 17;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 17 AND editable = 1");
	}
	
	private function getSQLCondition() {
	
		//$sql = ' WHERE company_id = '.$this->page->company['company_id'];
		return $sql;
	}

	public function checkData() {
	
		$test = $this->control->checkPOST($this);
		return $test;
	}
	
	public function getTitle() {
		if ($this->page->ctrl['action'] == 'add') {
			return "New Title";
		}
		return $this->data[0]['name'];
	}
	
	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>Empty</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>What about some adverts here ?</td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}
	public function graph_bottom() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>No idea</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td>&nbsp;</td></tr>\n";
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
		$out .= "		      <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all titles</a></td></tr>\n";
		$out .= "		  <tr><td>&nbsp;</td>\n";
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Config</a></td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>