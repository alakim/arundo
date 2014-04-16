<?php
require_once('db/dbResumes.php');

class DbResumesTest extends DbResumes{

	public function testFill($con){
		addRecord($con, $this->tableName, array(
			"Title"=>"инженер-сметчик",
			"Salary"=>"договорная",
			"Rubric"=>116,
			"Description"=>"Оформление и ведение рабочей документации; работа с КС2,КС3; знание программ AUTOCAD; WORD; Excel; СМЕТАру; Ответственность, целеустремленность, умение работать в коллективе, коммуникабельность, стрессоустойчивость, исполнительность.",
			"Fio"=>"Фурванова Екатерина Алексеевна",
			"Age"=>22,
			"Region"=>1,
			"Education"=>205,
			"Experience"=>224,
			"Phone"=>"89267600096",
			"Email"=>"furwanova-ekaterina@mail.ru",
			"Date"=>"2014-03-12"
		));
		addRecord($con, $this->tableName, array(
			"Title"=>"Руководитель проектов",
			"Salary"=>"50000",
			"Rubric"=>115,
			"Description"=>"",
			"Fio"=>"Аванян Владимир Семенович",
			"Age"=>29,
			"Region"=>2,
			"Education"=>205,
			"Experience"=>224,
			"Phone"=>"7 903 623 3231",
			"Email"=>"mishwwolozzm@yandex.ru",
			"Date"=>"2014-03-12"
		));
		addRecord($con, $this->tableName, array(
			"Title"=>"прораб",
			"Salary"=>"45000",
			"Rubric"=>114,
			"Description"=>"",
			"Fio"=>"Агапомов Семен",
			"Age"=>23,
			"Region"=>1,
			"Education"=>205,
			"Experience"=>224,
			"Phone"=>"8-926-593-27-35",
			"Email"=>"agapom.71@mail.ru",
			"Date"=>"2014-03-12"
		));
		
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

