<?php
require_once('db/GenericTable.php');

class DbConstants extends GenericTable{
	public $tableName = "Constants";
	public $sectTableName = "ConstantSections";
	
	public function create($con){
		if(tableExists($con, $this->tableName)){
			$this->drop($con);
		}
		execSql($con, 
			"CREATE TABLE ".$this->tableName."(".
			"ID INT, PRIMARY KEY(ID), ".
			"Name CHAR(50), Section INT)"
		);
		
		if(tableExists($con, $this->sectTableName)){
			$this->drop($con);
		}
		execSql($con,
			"CREATE TABLE ".$this->sectTableName."(".
			"ID INT, PRIMARY KEY(ID), ".
			"Name CHAR(50))"
		);
	}
	
	public function drop($con){
		execSql($con, "DROP TABLE ".$this->tableName);
		execSql($con, "DROP TABLE ".$this->sectTableName);
	}

	
}

