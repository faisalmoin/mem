<?php

require_once("classes/dbobject.php");

abstract class	SubDBObject extends DBObject{

	public function __construct(&$page,&$db_conn,&$errorbox) {
		parent::__construct($page,$db_conn,$errorbox);
	}

	public function add() {
		$this->add2db('',0,'');
	}

}
