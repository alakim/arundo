<?php
require_once('db/GenericTable.php');

class DbVacancies extends GenericTable{
	public $tableName = "Vacancies";
	
	public function create($con){
		if(tableExists($con, $this->tableName)){
			$this->drop($con);
		}
		execSql($con, 
			"CREATE TABLE ".$this->tableName."(".
			"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), Owner INT, ".
			"Title CHAR(30), ".
			"Salary CHAR(30), ".
			"Date DATE, ".
			"Rubric INT,".
			"Organization CHAR(30),".
			"Description CHAR(125),".
			"Contact CHAR(30),".
			"Phone CHAR(30),".
			"Email CHAR(30)".
			")"
		);
	}
	
}

