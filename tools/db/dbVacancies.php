<?php

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
	
	public function testFill($con){
		$fields = "Title, Salary, Organization";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сварщик\", \"30000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Бухгалтер\", \"60000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Фрезеровщик\", \"32000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Руководитель проектов\", \"65000\", \"OOO Кирпич\")");
	
	}
}

