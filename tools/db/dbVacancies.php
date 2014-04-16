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
			"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),".
			"Title CHAR(30), Salary CHAR(30), Organization CHAR(30))"
		);
	}
	
}

