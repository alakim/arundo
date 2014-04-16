<?php
require_once('db/GenericTable.php');

class DbResumes extends GenericTable{
	public $tableName = "Resumes";
	
	public function create($con){
		if(tableExists($con, $this->tableName)){
			$this->drop($con);
		}
		execSql($con, 
			"CREATE TABLE ".$this->tableName."(".
			"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), Owner INT, ".
			"Title CHAR(30), Salary CHAR(30), Age INT)"
		);
	}
	
}

