<?php

class GenericTable{
	public $tableName = "";
	
	public function drop($con){
		execSql($con, "DROP TABLE ".$this->tableName);
	}
	
	public function rebuild($con){
		$this->create($con);
		$this->testFill($con);
	}
}

