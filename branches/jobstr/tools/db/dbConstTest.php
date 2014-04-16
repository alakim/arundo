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
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 1, \"������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 2, \"���������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 3, \"�����-���������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 4, \"�������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 5, \"������������ �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 6, \"���������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 7, \"��������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 8, \"��������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 9, \"���������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 10, \"�������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 11, \"�������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (1, 12, \"����������� �������\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 101, \"������������, ��������� �������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 102, \"������� ���������������� ���������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 103, \"�������-�����������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 104, \"��������� �����������-�������� �����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 105, \"����������, ���������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 106, \"�����������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 107, \"�������-������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 108, \"������� �� ������� ������������ �����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 109, \"������������ ���������������, ���\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 110, \"��������-���������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 111, \"��������-���������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 112, \"��������-����������, ������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 113, \"������� ������.-��������� �����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 114, \"������������� ����� (�������)\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 115, \"���������� ��������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 116, \"����������, ��������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 117, \"����������� ������������ � ������ ������������ ��������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 118, \"������ ����� � ��\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 119, \"�����������, ������������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 120, \"���������������, ��������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (2, 121, \"�������������� ���������� � �������������\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 201, \"�����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 202, \"�������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 203, \"������� �����������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 204, \"�������� ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (3, 205, \"������\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 221, \"�����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 222, \"���\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 223, \"1 - 2 ����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 224, \"2 - 5 ���\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 225, \"����� 5 ���\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (4, 226, \"��� ����� ������\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 241, \"�����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 242, \"������ ������� ����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 243, \"�������� ������� ����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 244, \"���������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (5, 245, \"�������\")");
		
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 261, \"25\")");
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 262, \"50\")");
		// execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (6, 263, \"100\")");
		
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 271, \"�� ��������� �����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 272, \"�� ��������� 3 ���\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 273, \"�� ��������� ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 274, \"�� ��������� 2 ������\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 275, \"�� ��������� �����\")");
		execSql($con, "INSERT INTO ".$this->tableName." (".$fields.") VALUES (7, 276, \"�� �������\")");
	
	}
	
	public function rebuild($con){
		$this->create($con);
		$this->testFill($con);
	}
}

