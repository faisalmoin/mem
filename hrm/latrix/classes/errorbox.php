<?php 
// The errorbox class allows other objects to store messages that are printed at the end of the page in a defined
// space to prevent error messages from distroying a page completely.

class Errorbox {

private $message = '';

	public function __construct() {
		$this->message = '';
		return true;
	}

	public function add ($newmsg) {
		if (strlen($this->message)!=0) {
			$this->message = $this->message . "<br>\n" .$newmsg;
		} else {
			$this->message = $newmsg;
		}
		return true;
	}
	
	public function debug ($newmsg) {
		if (debugging_on != 1) { return true; }
		if (strlen($this->message)!=0) {
			$this->message = $this->message . "<br>\n" .$newmsg;
		} else {
			$this->message = $newmsg;
		}
		return true;
	}
	
	public function out() {
	if (strlen($this->message) > 0) {
		return "<div class=errorbox>\n".$this->message."</div>\n";
		}
	}
	
	public function printme() {
	if (strlen($this->message) > 0) {
		echo $this->message;
		}
	}
	
	public function isEmpty() {
		if (strlen($this->message) > 0) {
			return false;
		}
		return true;
	}
}

?>