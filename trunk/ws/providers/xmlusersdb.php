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
	
	function writeTableRows($tblRef, $dbCatID){
		$db = $tblRef['usersDBID'];
		$sectID = $tblRef['section'];
		
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$q = $sectID=='userGroups'?'//groups/group':(
			$sectID=='userAccounts'?'//users/user':'');
			
		if($q=='') return;
		$rows = $xp->query($q);
		
		echo('[');
		$first = true;
		foreach($rows as $row){
			$rID = $row->getAttribute('id');
			$rNm = TreeUtility::conv($row->getAttribute('name'));
			if($first) $first = false; else echo(',');
			echo("{\"id\":\"$rID\",\"name\":\"$rNm\"}");
		}
		echo(']');
	}
	
	function writeRecordData($tblRef, $dbCatID, $recID){
		$db = $tblRef['usersDBID'];
		$sectID = $tblRef['section'];
		
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$q = $sectID=='userGroups'?"//groups/group[@id='$recID']":(
			$sectID=='userAccounts'?"//users/user[@id='$recID']":'');
			
		if($q=='') return;
		$rows = $xp->query($q);
		if($rows->length<1){echo("{\"error\":\"errUserOrGrpNotExist\"}"); return;}
		$row = $rows->item(0);
		
		$itmName = TreeUtility::conv($row->getAttribute('name'));
		
		echo("{\"columns\":{");
		echo("\"id\":{\"field\":\"id\",\"title\":\"Идентификатор\",\"type\":\"text\"},");
		echo("\"name\":{\"field\":\"name\",\"title\":\"Название\",\"type\":\"text\"}");
		echo('},');
		echo("\"data\":{\"id\":\"$recID\",");
		echo("\"id\":\"{$row->getAttribute('id')}\",");
		echo("\"name\":\"{$itmName}\"");
		echo('}');
		echo('}');
	}
}



