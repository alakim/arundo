<?php
require_once('db/dbUsers.php');

class DbUsersTest extends DbUsers{
	
	private function stdCrypt($str){
		return crypt($str, cryptKey);
	}
	
	public function testFill($con){
		$fields = "Name, Login, Password";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Системный администратор\", \"sa\", \"".(DbUsersTest::stdCrypt("sa"))."\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Администратор\", \"admin\", \"".(DbUsersTest::stdCrypt("admin"))."\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Иванов И.И.\", \"ivanov\", \"".(DbUsersTest::stdCrypt("ivanov"))."\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Петров П.П.\", \"petrov\", \"".(DbUsersTest::stdCrypt("petrov"))."\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сидоров С.С.\", \"sidorov\", \"".(DbUsersTest::stdCrypt("sidorov"))."\")");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

