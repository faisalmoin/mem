<?php

class Config{ 

	var $valid;
	var $location;
	var $company;
	var $ctrl;
	var $config;
	var $dbc;
	var $pagesize;

	public function __construct(&$db_conn) { 
	
	// this is not true any longer. The company details need to be loaded from the company ID stored in the cookie !!! 
	// only the location details can be loaded from the ip address, but there we need to ensure that this doesn't conflict with
	// the case where the owner logs in for a different company.
	
		$this->dbc = $db_conn;
		
		$this->setFromPost('subject','Employees');
		$this->setFromPost('subsubject','None');
		$this->setFromPost('record',0);
		$this->setFromPost('display',0);
		$this->setFromPost('subrecord',0);
		$this->setFromPost('title','');
		$this->setFromPost('action','none');
		$this->setFromPost('mode','show');
		$this->setFromPost('page',1);
		$this->setFromPost('column','name');
		$this->setFromPost('order','ASC');

		$this->config['company_id'] = 0;
		$this->config['user_level'] = 0;
		$this->config['user_name'] = 'nobody';
		$this->config['user_id'] = 0;
//		var_dump($this->ctrl['page']);
	}
	
	function setFromPost($key,$default) {
		$postkey = 'txt'.$key;
		if (isset($_POST[$postkey])) {
			$this->ctrl[$key] = $_POST[$postkey];
		} else {
			$this->ctrl[$key] = $default;
		}
	}
	
	public function setSession(&$login) {
		// create a unique session key. store it in the session database together with the other values: username, level and time
		$newkey = false;
		while (!$newkey) {
			$session_key = $this->makeKey(32);
			$SQL = "SELECT * FROM sessions WHERE session_key = '".$session_key."'";
			$check = $this->dbc->query($SQL);
			if ($check == '') {
				$newkey = true;
			}
		}
		$SQL = "INSERT INTO sessions (user_name, session_time, user_level, session_key, user_id, company_id) VALUES";
		$SQL .= " ('".$_POST['TxtUName']."', current_timestamp(), ".$login[0]['user_level_id'].", '$session_key', ".$login[0]['emp_id'].", ".$login[0]['company_id'].");";
		$this->dbc->exec($SQL);
		return $session_key;
	}
	
	public function setCookie($key) {
		//creates a cookie and sends it to the browser.
		//$done = setcookie("latrax-session",$key, time()+30*60,"/",$_SERVER['SERVER_NAME']);
		$server = false;
		if ($_SERVER['SERVER_NAME'] != 'localhost') {
			$server = $_SERVER['SERVER_NAME'];
		}
		setcookie("latrax-session",$key, time()+30*60,"/",$server);
	}
	
	public function updateSession($id, $key) {
		$SQL = "UPDATE sessions SET company_id=".$id." WHERE session_key = '".$key."'";
		$this->dbc->exec($SQL);
	}
	
	public function endSession($key) {
		$server = false;
		if ($_SERVER['SERVER_NAME'] != 'localhost') {
			$server = $_SERVER['SERVER_NAME'];
		}
		setcookie("latrax-session","",time()-3600,"/",$server); 
		$SQL = "DELETE FROM sessions WHERE session_key = '".$key."'";
		$this->dbc->exec($SQL);
		$SQL = "DELETE FROM sessions WHERE current_timestamp > timestampadd(MINUTE,30,session_time)";
		$this->dbc->exec($SQL);
		header ('Location: login.php');
	}

	public function checkUser() {
		// check for cookies. If the user has a session going, there must be a cookie with the session ID inside
		if (isset($_COOKIE['latrax-session'])) {
			$key = $_COOKIE['latrax-session'];
			$SQL = "SELECT * FROM sessions WHERE session_key = '".$key."'";
			$data = $this->dbc->query($SQL);
			if ($data == NULL) {					//no session by this key -> login, fella.
				header ('Location: login.php');
			}
			if (strtotime($data[0]['session_time']) < time() - 30*60) {	//session has expired -> login, fella. 
				$this->endSession($key);
			}
			$this->config = $data[0];
			if ($this->config['company_id'] != $this->company['company_id']) {	
				// owner has logged in, change the company to whatever he has selected
				$SQL = "SELECT * from companies where company_id = ".$data[0]['company_id'];
				$data = $this->dbc->query($SQL);
				$this->company = $data[0];
			}
			$SQL = "SELECT dept_id FROM departments WHERE manager_id = ".$this->config['user_id'];
			$data = $this->dbc->query($SQL);
			if ($data != '') {
				$this->config['dept_id'] = $data[0]['dept_id'];
			} else {
				$this->config['dept_id'] = 0;
			}
			// now update the session to expire in 5 minutes;
			$SQL = "UPDATE sessions SET session_time = current_timestamp() WHERE session_key='".$key."'";
			$this->dbc->exec($SQL);
			$this->setCookie($key);
		} else {
			header ('Location: login.php');
		}
	}
	
	private function makeKey($length) {
		$key = '';
	   $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
   	for($i=0;$i<$length;$i++) {
			$key .= $pattern{rand(0,35)};
   	}
   	return $key;
  	}

	public function isValid() {
		return $this->valid;
	}

	public function checkLocation() {
		$ipadr = $_SERVER['REMOTE_ADDR'];
//		var_dump($ipadr);
		$SQL = "SELECT l.location_id, l.name as loc_name, l.company_id from locations l where l.ipaddress ='".$ipadr."';";
		$data = $this->dbc->query($SQL);
		if ($data == NULL) {
			$this->valid = false;
			header ('Location: badlocation.php');
		}
		$this->location = $data[0];
		if (count($data) >= 1) {
			$this->valid = true;
		} else {
			$this->valid = false;
			header ('Location: badlocation.php');
		}
		// now use the company_id to load the company data
		$SQL = "SELECT * from companies where company_id = ".$data[0]['company_id'];
		$data = $this->dbc->query($SQL);
		$this->company = $data[0];
	}
	
	public function getLocationFromCode() {
		$SQL = "SELECT * from companies where inandout_code = '".$_POST['txtaccesscode']."'";
		$data = $this->dbc->query($SQL);
		if ($data == NULL) return false;
		if (count($data) != 1) {
			return false;
		}
		$this->company = $data[0];
		$SQL = "SELECT l.location_id, l.name as loc_name, l.company_id from locations l where l.company_id = ".$this->company['company_id']." LIMIT 1";
		$data = $this->dbc->query($SQL);
		$this->location = $data[0];
		$this->valid = true;
		return true;
	}
	
	public function getCompanyID() {
		return $this->company['company_id'];	
	}
	
	public function getLocationID() {
		return $this->location['location_id'];	
	}

	public function getLocationName() {
		return $this->location['loc_name'];	
	}

	public function getCompanyName() {
		return $this->company['name'];	
	}
	
	public function loadFromUser($userid) {
		$sql = "SELECT e.emp_id, c.company_id, l.location_id, e.user_level_id, e.username 
				  FROM employees e INNER JOIN lcations l USING (location_id)
				  INNER JOIN companies c on e.company_id = c.company_id where e.emp_id=".$userid;
		$data = $this->dbc->query($sql);
		$this->config['company_id'] = $data[0]['company_id'];
		$this->config['user_level'] = $data[0]['user_level_id'];
		$this->config['user_name'] = $data[0]['username'];
		$this->config['user_id'] = $userid;
		$sql = "SELECT * from companies WHERE company_id = ".$data[0]['company_id'];
		$data = $this->dbc->query($sql);
		$this->company = $data[0];
		$sql = "SELECT l.location_id, l.name as loc_name, l.company_id from locations l where l.location_id=".$data[0]['location_id'];
		$data = $this->dbc->query($sql);
		$this->location = $data[0];
	}
} 
?>