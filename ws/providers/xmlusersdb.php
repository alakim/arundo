<?php 

class XmlUsersDB{
	function writeColumns($tblRef){
		if($tblRef['usersDBID']=='') return;
		
		echo('[');
		echo("{\"field\":\"id\",\"title\":\"�������������\"},");
		echo("{\"field\":\"name\",\"title\":\"��������\"}");
		echo(']');
	}
}



