<?php
require_once('db/dbUsers.php');

class DbUsersTest extends DbUsers{
	
	public function testFill($con){
		$fields = "Name, Login, Password";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"��������� �������������\", \"sa\", \"sa\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�������������\", \"admin\", \"admin\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������ �.�.\", \"ivanov\", \"ivanov\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������ �.�.\", \"petrov\", \"petrov\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������� �.�.\", \"sidorov\", \"sidorov\")");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

