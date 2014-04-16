<?php
require_once('db/dbResumes.php');

class DbResumesTest extends DbResumes{
	
	public function testFill($con){
		$fields = "Title, Salary, Age";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сварщик\", \"35000\", 33)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Электрик\", \"30000\", 38)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Программист\", \"50000\", 27)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Водитель\", \"40000\", 43)");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

