<?php
require_once('db/dbResumes.php');

class DbResumesTest extends DbResumes{
	
	public function testFill($con){
		$fields = "Title, Salary, Age";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�������\", \"35000\", 33)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"��������\", \"30000\", 38)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�����������\", \"50000\", 27)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"��������\", \"40000\", 43)");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

