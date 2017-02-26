<?php

require_once("classes/dbobject.php");

abstract class	EmpDBObject extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
		parent::__construct($page,$db_conn,$errorbox);
	}

	public function add() {
		$where = " WHERE emp_id=".$this->page->ctrl['subrecord'];
		$this->add2db(',emp_id', $this->page->ctrl['subrecord'], $where);
	}
	
}
