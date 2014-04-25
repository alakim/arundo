<?php
require_once('db/dbUsers.php');

class DbUsersTest extends DbUsers{
	
	private function stdCrypt($str){
		return crypt($str, cryptKey);
	}
	
	public function testFill($con){
		$fields = "Name, Login, Password, EMail";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"��������� �������������\", \"sa\", \"".(DbUsersTest::stdCrypt("sa"))."\", \"sa423@mail.ru\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"�������������\", \"admin\", \"".(DbUsersTest::stdCrypt("admin"))."\", \"admin234@mail.ru\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������ �.�.\", \"ivanov\", \"".(DbUsersTest::stdCrypt("ivanov"))."\", \"ivanov@mail.ru\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������ �.�.\", \"petrov\", \"".(DbUsersTest::stdCrypt("petrov"))."\", \"petrov@mail.ru\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"������� �.�.\", \"sidorov\", \"".(DbUsersTest::stdCrypt("sidorov"))."\", \"sidorov@mail.ru\")");
	
	}
	
	public function rebuild($con){
		GenericTable::rebuild($con);
		$this->testFill($con);
	}
}

