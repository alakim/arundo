<?php 

class XmlUsersDB{

	function writeLinkedNodes($link, $el){
		$db = $link->getAttribute("xmlUsersDB");
		$parentID = $el->getAttribute("id");
		
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		$groups = $xp->query('//groups');
		$users = $xp->query('//users');
		
		if($groups->length>0){
			echo("{\"id\":\"$parentID/userGroups\", \"text\":\"Группы пользователей\"}");
		}
		if($groups->length>0 && $users->length>0){echo(',');}
		if($users->length>0){
			echo("{\"id\":\"$parentID/userAccounts\", \"text\":\"Пользователи\"}");
		}
	}
	
	function writeColumns($tblRef){
		if($tblRef['usersDBID']=='') return;
		
		echo('[');
		echo("{\"field\":\"id\",\"title\":\"Идентификатор\"},");
		echo("{\"field\":\"name\",\"title\":\"Название\"}");
		echo(']');
	}
}



