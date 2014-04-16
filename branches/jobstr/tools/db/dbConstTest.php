<?php
require_once('db/dbConst.php');

class DbConstTest extends DbConstants{
	
	public function testFill($con){
		$fields = "ID, Name";
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (1, \"regions\")");
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (2, \"rubrics\")");
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (3, \"educations\")");
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (4, \"experiences\")");
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (5, \"schedules\")");
		//execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (6, \"searchOptionsCounts\")");
		execSql($con, "INSERT INTO ".$this->sectTableName." (".$fields.") VALUES (7, \"searchOptionsPeriods\")");
		
		
		$fields = "Section, ID, Name";
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 1, \"Москва\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 2, \"Московская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 3, \"Санкт-Петербург\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 4, \"Брянская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 5, \"Владимирская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 6, \"Ивановская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 7, \"Калужская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 8, \"Рязанская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 9, \"Смоленская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 10, \"Тверская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 11, \"Тульская область\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 12, \"Ярославская область\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 101, \"Разнорабочие, начальный уровень\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 102, \"Рабочие общестроительных профессий\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 103, \"Рабочие-отделочники\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 104, \"Машинисты строительно-дорожных машин\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 105, \"Сантехники, вентиляционщики\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 106, \"Электромонтажники\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 107, \"Электро-газосварщики\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 108, \"Слесаря по ремонту строительных машин\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 109, \"Производство стройматериалов, ЖБИ\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 110, \"Инженеры-строители\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 111, \"Инженеры-электромеханики\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 112, \"Инженеры-геодезисты, гидротехники\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 113, \"Мастера строит.-монтажных работ\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 114, \"Производители работ (прорабы)\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 115, \"Начальники участков\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 116, \"Экономисты, сметчики\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 117, \"Обеспечение безопасности и охрана строительных объектов\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 118, \"Охрана труда и ТБ\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 119, \"Архитекторы, конструкторы\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 120, \"Благоустройство, ландшафт\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 121, \"Информационные технологии в строительстве\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 201, \"Любое\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 202, \"Среднее\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 203, \"Среднее специальное\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 204, \"Неполное высшее\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 205, \"Высшее\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 221, \"Любой\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 222, \"Нет\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 223, \"1 - 2 года\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 224, \"2 - 5 лет\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 225, \"Более 5 лет\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 226, \"Нет опыта работы\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 241, \"Любой\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 242, \"Полный рабочий день\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 243, \"Неполный рабочий день\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 244, \"Свободный\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 245, \"Сменный\")");
		
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 261, \"25\")");
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 262, \"50\")");
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 263, \"100\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 271, \"за последние сутки\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 272, \"за последние 3 дня\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 273, \"за последнюю неделю\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 274, \"за последние 2 недели\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 275, \"за последний месяц\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 276, \"за квартал\")");
	
	}
	
	public function rebuild($con){
		$this->create($con);
		$this->testFill($con);
	}
}

