<?php

class DbResumes extends GenericTable{
	public $tableName = "Resumes";
	
	public function create($con){
		if(tableExists($con, $this->tableName)){
			$this->drop($con);
		}
		execSql($con, 
			"CREATE TABLE ".$this->tableName."(".
			"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),".
			"Title CHAR(30), Salary CHAR(30), Age INT)"
		);
	}
	
	public function testFill($con){
		$fields = "Title, Salary, Age";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Сварщик\", \"35000\", 33)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Электрик\", \"30000\", 38)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Программист\", \"50000\", 27)");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (\"Водитель\", \"40000\", 43)");
	
	}
}

