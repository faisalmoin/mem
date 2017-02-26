<?php

require_once("classes/control.php");
require_once("Mail.php");
require_once("Mail/mime.php");

abstract class	DBObject {

	var $dbc;
	var $error;
	var $page;
	var $control;
	var $columns;
	var $title;
	var $idcol;
	var $subject_id;
	var $tablename;
	var $sql_fields;
	var $sql_from;
	var $sql_where;
	var $sql_count;
	var $record;
	var $data;
	var $count;
	var $name;
	var $isNew;
	var $requiresTinyMCE;
 	
	public function __construct(&$page,&$db_conn,&$errorbox) {
		$this->dbc = $db_conn;
		$this->error = $errorbox;
		$this->page = $page;
		$this->control = new Control($db_conn, $this->page->company['company_id'], $this->page->config['user_level']);
//		$errorbox->debug("User level: ".$this->page->config['user_level']);
		$this->isNew = false;
		$this->requiresTinyMCE = false;
	}

	public function getCount() {
		return $this->count;
	}
	
	public function setNew($value) {
		if ($value) {
			$this->isNew = true; 
		} else {
			$this->isNew = false;
		}
	}

	public function load($record) {
		$sql = $this->sql_fields.$this->sql_from.' WHERE '.$this->idcol.' = '.$record;
		$this->error->debug("SQL: ".$sql);
		$this->data = $this->dbc->query($sql);
		//var_dump($this->data);
	}

	public function loadNavNumbers($record) { 
	
		$this->record = $record;
		$sql = $this->sql_count.$this->sql_from.$this->sql_where; 
		$cdata = $this->dbc->query($sql); 
		if (strpos($this->idcol, '.') > 0) {
			$elements = explode('.', $this->idcol);
			$idcol = $elements[1];
		} else {
			$idcol = $this->idcol;
		}
		if (count($cdata) > 1) {
			$this->firstrecord = $cdata[0][$idcol];
			$this->lastrecord = $cdata[count($cdata)-1][$idcol]; 
			$this->count = count($cdata);
		} else {
			$this->firstrecord = 0;
			$this->lastrecord = 0;
			$this->count = 1;
		}
//		var_dump($this->count);
//		$this->error->debug($sql);
		for ($i=0;$i<count($cdata);$i++) {
			if ($record == $cdata[$i][$idcol]) {
				if ($i > 0) {
					$this->prevrecord = $cdata[$i-1][$idcol];
				} else {
					$this->prevrecord = 0; 
				} 
				if ($i < count($cdata)-1) {
					$this->nextrecord = $cdata[$i+1][$idcol];
				} else {
					$this->nextrecord = 0; 
				}
			}			// end if record found
		}				// end for
	} 
	
	public function loadPOST() {

		foreach ($this->columns as $col) {
			switch ($col['type']) {
				case 'C':
				case 'N':
				case 'P':
				case 'T':
				case 'X':
				case 'D':
				case 'S':
				case 'I':
				case 'M':
				case 'E':
					if (isset($_POST['in_'.$col['db_name']])) {
						$this->data[0][$col['db_name']] = $_POST['in_'.$col['db_name']];
					} else {
						$this->data[0][$col['db_name']] = '';
					}
					break;
				case 'R':
					if (isset($_POST['in_'.$col['db_name'].'yes'])) {
							$this->data[0][$col['db_name']] = 1;
						} else {
							$this->data[0][$col['db_name']] = 0;
						}
					break;
				case 'B':
					if (isset($_POST['in_'.$col['db_name']])) {
							$this->data[0][$col['db_name']] = 1;
						} else {
							$this->data[0][$col['db_name']] = 0;
						}
					break;
			}
		}
	}
	
	public function add() {
		$where = " WHERE company_id=".$this->page->company['company_id'];
		$this->add2db(',company_id',$this->page->company['company_id'],$where);
	}
	
	protected function add2db($key_string, $key, $where_clause) {
		// build the SQL string for the new record from the POST and execute it. The change the current control settings to point to the new
		// record and reload the object;
		$sql = "INSERT INTO ".$this->tablename." (";
		$last = $this->columns[count($this->columns)-1]['db_name'];
		foreach($this->columns as $col) {
			$sql .= $col['db_name'];
			if ($last == $col['db_name']) {
				$sql .= $key_string.') VALUES (';
			} else {
				$sql .= ',';
			}
		}
		foreach ($this->columns as $col) {
			switch($col['type']){
				case 'D':	//Date, Time, Char, Password, Image all need quotes around the value
				case 'T':
				case 'C':
				case 'I':
				case 'X':
				case 'M':	//multi-line text and editor text may require some additional escaping !! 
				case 'E':	//otherwise users can't use single quotes.
					$sql .= "'".$this->data[0][$col['db_name']]."'";
					break;
				case 'P':
					$sql .= "AES_ENCRYPT('".$this->data[0][$col['db_name']]."','".la_aes_key."')";
					break;
				case 'N':	// Number, checkBox, Select, Radio don't need quotes
				case 'B':
				case 'S':
				case 'R':
					$sql .= $this->data[0][$col['db_name']];
					break;
			}
			if ($col['db_name'] == $last) {
				if ($key_string != '') {
					$sql .= ",".$key.");";
				} else {
					$sql .= ")";
				}
			} else {
				$sql .= ',';
			}
		}
		$this->error->debug($sql);
		$this->dbc->exec($sql);
		$sql = "SELECT max(".$this->idcol.") as new_id FROM ".$this->tablename.$where_clause;
		$data = $this->dbc->query($sql);
		$this->page->ctrl['record'] = $data[0]['new_id'];
		$this->loadNavNumbers($this->page->ctrl['record']);
	}
	
	public function delete() {
		// delete the current record from the database and move to the next. If this was the last record, move to the previous.
		if ($this->checkDependencies() == true ) {
			$sql = "DELETE FROM ".$this->tablename." where ".$this->idcol." = ".$this->page->ctrl['record'];
			$this->dbc->exec($sql);
		}
	}
	
	protected function checkDependencies() {
		$sql = "SELECT * from dependencies WHERE subject_id=".$this->subject_id;
		$deps = $this->dbc->query($sql);
		if (count($deps) == 0) {
			return true;
		}
		foreach ($deps as $dep) {
			$sql = "SELECT count(*) AS cnt FROM ".$dep['table_name']." WHERE ".$dep['key_name']." = ".$this->page->ctrl['record'];
			$count = $this->dbc->query($sql);
			if ($count[0]['cnt'] > 0) {
				$this->error->add("Sorry, you cannot delete this record, one or more ".$dep['subject_name']." depend on it.");
				return false;
			}
		}
		return true;
	}
	
	public function save() {
		// finally build the SQL string for the updated record from the POST and execute it. All other settings stay the same.
		$sql = "UPDATE ".$this->tablename." SET ";
		$last = $this->columns[count($this->columns)-1]['db_name'];
		foreach ($this->columns as $col) {
			switch($col['type']){
				case 'D':	//Date, Time, Char, Password, Image all need quotes around the value
				case 'T':
				case 'C':
				case 'I':
				case 'X':
				case 'M':
				case 'E':
					$sql .= $col['db_name']." = '".$this->data[0][$col['db_name']]."'";
					break;
				case 'P':
					$sql .= $col['db_name']." = AES_ENCRYPT('".$this->data[0][$col['db_name']]."','".la_aes_key."')";
					break;
				case 'N':	// Number, checkBox, Select, Radio don't need quotes
				case 'B':
				case 'S':
				case 'R':
					$sql .= $col['db_name'].' = '.$this->data[0][$col['db_name']];
					break;
			}
			if ($col['db_name'] != $last) {
				$sql .= ',';
			}
		}
		$sql .= " WHERE ".$this->idcol."=".$this->page->ctrl['record'];
		$this->error->debug($sql);
		$this->dbc->exec($sql);
		return true;
	}
	
	protected function getMailParams() {
		$this->placeholders = array("%emp%" , "%start%", "%end%", "%result%", "%days%", "%username%", "%password%", 
											 "%curdate%", "%receiver%", "%leavetype%","%start_time%","%end_time%","%url%");
	}
	
	public function sendTemplateMail($to_address, $template_id, $params) {

	// params must be a 2-dimensional array and should be obtained with getMailParams() 
		$sql = "SELECT subject, body, html_body FROM mail_templates WHERE template_id=".$template_id." AND company_id=";
		$sql .= $this->page->config['company_id'];
		$items = $this->dbc->query($sql);
		$subject = str_replace($this->placeholders, $params,$items[0]['subject']);
		$body = str_replace($this->placeholders, $params, $items[0]['body']);
		$html_body = str_replace($this->placeholders, $params, $items[0]['html_body']);
		$this->sendMail($to_address, $subject, $body, $html_body, la_from_email);
	}
	
	public function sendMail($to_address, $subject, $body, $html_body, $from_address) {
		if ($to_address == '') {
		   $this->error->add('WARNING: There is no recipient address, cannot send message.');
		}
		if ($from_address == '') {
		   $this->error->add('WARNING: There is no sender address, cannot send message.');
		}
		if ($body == '') {
		   $this->error->add('WARNING: There is no message body, cannot send message.');
		}
		$crlf = "\n";
		$mime = new Mail_mime($crlf);
		$headers = array('From' 	=> $from_address,
							  'Subject' => $subject,
							  // 'To' => 'wolfgangs@manticoreit.com');
							  // commented out for debugging purposes
							  'To'		=> $to_address);
		$mime->setTXTBody($body);
		// at the moment we won't do HTML messages, that's something for the future
		$mime->setHTMLBody($html_body);
		$msg_body = $mime->get();
		$headers = $mime->headers($headers);
		$mail =& Mail::factory('SMTP');
		if($err = $mail->send($to_address, $headers, $msg_body) != true) {
			$this->error->add($err->toString()); 
//		if($err = $mail->send(la_admin_email, $headers, $msg_body) != true) {
//			$this->error->add($err->toString()); 
		}
		$this->error->debug('message sent to: '.$to_address);
	}
	
	public function showdetails() {
		$out = "    <table width=\"100%\">\n";
		$out .= "      <thead class=\"detail-head\"><tr><td colspan=\"2\" width=\"100%\" class=\"td-left\"><h2>".$this->name." Details</h2></td></tr></thead>\n";
		$out .= "      <tbody>\n";
		foreach ($this->columns as $col) {
			$out .= "<tr><td class=\"td-right\">".$col['title']." : </td>";
			if ($col['type'] == 'S') {
				$sql = str_replace('%company%',$this->page->company['company_id'], $col['query']);
				$sql = str_replace('%userlevel%',$this->page->config['user_level'], $sql);
				$this->error->debug($sql);
				$lookup = $this->dbc->query($sql);
				if (count($lookup) > 0) {
					foreach ($lookup as $lrow) {
						if ($lrow['ID'] == $this->data[0][$col['db_name']]) {
							$out .= "<td class=\"td-left-show\">".$lrow['name']."</td>\n";				
						}
					}
				} else {
					$out .= "<td class=\"td-left-show\">&nbsp;</td>\n";
				}
			} elseif ($col['type'] == 'B') {
				if ($this->data[0][$col['db_name']] == 0) {
					$out .= "<td class=\"td-left-show\">No</td>\n";				
				} else {
					$out .= "<td class=\"td-left-show\">Yes</td>\n";				
				}
			} elseif (($col['type'] == 'P' || ($col['type'] == 'X') && $this->page->config['user_level'] < lu_manager)) {
				$out .= "<td class=\"td-left-show\">********</td>\n";
			} elseif ($col['type'] == 'M' || $col['type'] == 'E') {
				$out .= "<td class=\"td-left-show\">".str_replace("\n","<br>",$this->data[0][$col['db_name']])."</td>\n";
			} else {
				$out .= "<td class=\"td-left-show\">".$this->data[0][$col['db_name']]."</td>\n";
			}
		}
		$out .= "      </tbody>\n";
		$out .= "    </table>\n";
		return $out;	
	}

	public function editdetails() {
	
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
	}
	
	public function graph_top() {
		return '';
	}
	public function graph_bottom() {
		return '';
	}
	public function activities() {
		return '';
	}
}

?>
