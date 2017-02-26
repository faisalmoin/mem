<?php

class DB_Conn {  

	private $fields;
	private $count;

	public function __construct() { 
		if (db_name == '%db_name%') header ('Location: setup/setup.php');
		global $errorbox;
		$this->dbc = mysql_connect(db_host, db_user, db_pw);
			if (mysql_error($this->dbc) != "") {
				$errorbox->add("Could not connect to database : " . mysql_error($this->dbc));
				return false; 
				}
		// echo 'Connected successfully';
		if (!$this->dbc || !mysql_select_db(db_name, $this->dbc)) {
			$errorbox->add('Could not select database');
			return false; 
		} else { 
		$this->count = 0;
		return true;
		}
	}

	public function query($sql) {
		global $errorbox;
		$return = NULL;
		if (!$this->dbq = mysql_query($sql, $this->dbc)) {
			$errorbox->add('Cannot execute query : '.mysql_error($this->dbc).' Query was: '.$sql); 
			return false;
		}
	   while ($row = mysql_fetch_array($this->dbq)) {
//	   	$errorbox->add('Data: '.$row[1]);
			$return[] = $row; 
	   }
	   $this->fields = mysql_num_fields($this->dbq);
	   $this->count++;
	   return $return;
	}

	public function exec($sql) {
		global $errorbox;
		if (!$result = mysql_query($sql, $this->dbc)) {
			$errorbox->add('Cannot execute query : '.mysql_error($this->dbc).' Query was: '.$sql);
			return false;
		}
	   $this->count++;
	   return true;
	}
	
	public function get_fields() {
		return $this->fields;
	}
	
	public function getCount() {
		return $this->count;
	}

}
?>
