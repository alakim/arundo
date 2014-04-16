<?php
require_once('db/dbVacancies.php');

class DbVacanciesTest extends DbVacancies{
	
	public function testFill($con){
		$fields = "Title, Salary, Organization";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сварщик\", \"30000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Бухгалтер\", \"60000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Фрезеровщик\", \"32000\", \"OOO Кирпич\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Руководитель проектов\", \"65000\", \"OOO Кирпич\")");
	
	}
	
		
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}

}

