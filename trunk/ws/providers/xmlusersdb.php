<?php 

class XmlUsersDB{
	function writeColumns($tblRef){
		if($tblRef['usersDBID']=='') return;
		
		echo('[');
		echo("{\"field\":\"id\",\"title\":\"Идентификатор\"},");
		echo("{\"field\":\"name\",\"title\":\"Название\"}");
		echo(']');
	}
}



