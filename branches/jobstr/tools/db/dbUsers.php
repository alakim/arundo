<?php
require_once('db/GenericTable.php');

class DbUsers extends GenericTable{
	public $tableName = "Users";
	
	public function create($con){
		if(tableExists($con, $this->tableName)){
			$this->drop($con);
		}
		execSql($con, 
			"CREATE TABLE ".$this->tableName."(".
			"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),".
			"Name CHAR(30), Login CHAR(30), EMail CHAR(30), Password CHAR(36), Ticket CHAR(36))"
		);
	}
	
}

