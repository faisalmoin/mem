<?php

require_once("classes/subdbobject.php");

class EmailTemplate extends SubDBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
	
		parent::__construct($page,$db_conn,$errorbox);
		$this->name = "Email Template";
		$this->idcol = "id";
		$this->tablename = "mail_templates ";
		$this->sql_fields = 'SELECT id, template_id, subject, body, html_body';
		$this->sql_from = ' FROM mail_templates ';
		$this->sql_where = $this->getSQLCondition();
		$this->sql_count = 'SELECT id ';
		$this->subject_id = 22;
		$this->columns = $this->dbc->query("SELECT * FROM data_columns WHERE subject_id = 22 AND editable = 1");
		$this->requiresTinyMCE = true;
		$this->editor_elements = "in_html_body";
	}
	
	private function getSQLCondition() {
	
		$sql = ' WHERE company_id = '.$this->page->company['company_id'];
		return $sql;
	}

	public function checkData() {
	
		$test = $this->control->checkPOST($this);
		return $test;
	}
	
	public function getTitle() {
		return $this->data[0]['name'];
	}
	
	public function editdetails() {
	
		$out = "    <table width=\"100%\"><tr><td width=\"60%\" valign=top>\n"; 
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Edit ".$this->name." Details</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		//$this->error->debug('AM: '.$this->data[0]['is_am'].', Halfday: '.$this->data[0]['is_half_day']);
		foreach ($this->columns as $col) {
			$out .= "        <tr><td class=\"td-right\">".$col['title']." : </td>\n";
			$out .= "        <td class=\"td-left-show\">".$this->control->build($col,$this->data[0])."</td></tr>\n";
		}
		$out .= "        <tr><td></td><td class=\"td-left\">\n";
		$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'save');\">Save</a>  |  \n";
		if ($this->isNew == true) {
			$out .= "          <a href=\"#\" onclick=\"RestoreSubject();\">Cancel</a></td></tr>\n";
		} else {
			$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->record.",".$this->record.",'view');\">Cancel</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		$out .= "    </td><td valign=top width=\"40%\">\n";
		$out .= $this->graph_top();
		$out .= "    </td></tr>\n";
		return $out;

	/*
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=2 width=\"100%\" class=\"td-left\"><h2>Edit ".$this->name." Details</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		foreach ($this->columns as $col) {
			$out .= "        <tr><td class=\"td-right\" width=\"40%\">".$col['title']." : </td>\n";
			$out .= "        <td class=\"td-left-show\">".$this->control->build($col,$this->data[0])."</td></tr>\n";
		}
		$out .= "        <tr><td></td><td class=\"td-left\">\n";
		$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->page->ctrl['record'].",".$this->page->ctrl['record'].",'save');\">Save</a>  |  \n";
		if ($this->isNew == true) {
		$out .= "          <a href=\"#\" onclick=\"RestoreSubject();\">Cancel</a></td></tr>\n";
		} else {
		$out .= "          <a href=\"#\" onclick=\"SetAction(".$this->page->ctrl['record'].",".$this->page->ctrl['record'].",'view');\">Cancel</a></td></tr>\n";
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;
		*/
	}
	
	public function graph_top() {

		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td width=\"100%\" class=\"td-left\"><h2>About placeholders</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		$out .= "        <tr><td class=\"td-left\">When editing the body for a mail template, the following placeholders can be used:\n";
		$out .= "                <ul>\n";
		$out .= "                    <li>%emp%        The employee's name.</li>\n";
		$out .= "                    <li>%receiver%   The person receiving the email</li>\n";
		$out .= "                    <li>%start%      The start date (for leave and exception applications)</li>\n";
		$out .= "                    <li>%end%        The end date (for leave and exception applications)</li>\n";
		$out .= "                    <li>%result%     The result, i.e. either approved or declined</li>\n";
		$out .= "                    <li>%days%       The number of days applied for</li>\n";
		$out .= "                    <li>%username%   The name of the user account concerned</li>\n";
		$out .= "                    <li>%password%   The forgotten or new password</li>\n";
		$out .= "                    <li>%curdate%    The current date</li>\n";
		$out .= "                    <li>%leavetype%  The type of leave applied for</li>\n";
		$out .= "                    <li>%start_time% The start time of an exception</li>\n";
		$out .= "                    <li>%end_time%   The end time of an exception</li>\n";
		$out .= "                    <li>%url%        The target url to action the item</li>\n";
		$out .= "                </ul>\n";
		$out .= "            </td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
		$this->placeholders = array("%emp%" , "%start%", "%end%", "%result%", "%days%", "%username%", "%password%", 
											 "%curdate%", "%receiver%", "%leavetype%","%start_time%","%end_time%","%url%");
	
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
		$out .= "		      <td class=\"td-right\"><a href=\"#\" onclick=\"SetAction('".$rec."','".$dis."','show');\">Show all mail templates</a></td></tr>\n";
		$out .= "		  <tr><td>&nbsp;</td>\n";
		$out .= "				<td class=\"td-right\"><a href=\"#\" onclick=\"RestoreSubject();\">Back to Config</a></td></tr>\n";
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	
	}

}
?>