<?php
require_once('db/dbVacancies.php');

class DbVacanciesTest extends DbVacancies{
	
	public function testFill($con){
		$fields = "Title, Salary, Organization";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�������\", \"30000\", \"OOO ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"���������\", \"60000\", \"OOO ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�����������\", \"32000\", \"OOO ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������������ ��������\", \"65000\", \"OOO ������\")");
	
	}
	
		
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}

}

