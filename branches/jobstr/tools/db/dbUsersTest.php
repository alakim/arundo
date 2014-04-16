<?php
require_once('db/dbUsers.php');

class DbUsersTest extends DbUsers{
	
	public function testFill($con){
		$fields = "Name, Login, Password";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Системный администратор\", \"sa\", \"sa\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Администратор\", \"admin\", \"admin\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Иванов И.И.\", \"ivanov\", \"ivanov\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Петров П.П.\", \"petrov\", \"petrov\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сидоров С.С.\", \"sidorov\", \"sidorov\")");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

