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
		$db = $tblRef['usersDBID'];
		$sectID = $tblRef['section'];
		
		if($db=='' || $sectID==''){echo('[]'); return;}
		
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
			
		if($q=='') {echo('[]'); return;}
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
		if($sectID=='userAccounts'){
			echo(',');
			echo("\"bgnDate\":{\"field\":\"bgnDate\",\"title\":\"Дата начала регистрации\",\"type\":\"date\"},");
			echo("\"endDate\":{\"field\":\"endDate\",\"title\":\"Дата конца регистрации\",\"type\":\"date\"},");
			echo("\"groups\":{\"field\":\"groups\",\"title\":\"Группы\",\"type\":\"refList\"}");
		}
		echo('},');
		echo("\"data\":{\"id\":\"$recID\",");
		echo("\"id\":\"{$row->getAttribute('id')}\",");
		echo("\"name\":\"{$itmName}\",");
		echo("\"bgnDate\":\"{$row->getAttribute('bgnDate')}\",");
		echo("\"endDate\":\"{$row->getAttribute('endDate')}\",");
		echo("\"groups\":\"\"");
		echo('}');
		echo('}');
	}
	
	function writeRefRows($tblRef, $dbCatID, $recID){
		$db = $tblRef['usersDBID'];
		$sectID = $tblRef['section'];
		
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$groups = $xp->query("//groups/group");
		$usrGroups = $xp->query("//users/user[@id='$recID']/member/@group");
		
		$first = true;
		echo('[');
		foreach($groups as $grp){
			if($first) $first = false; else echo(',');
			$grID = $grp->getAttribute('id');
			$grNm = TreeUtility::conv($grp->getAttribute('name'));
			echo("{\"id\":\"$grID\", \"text\":\"$grNm\"");
			foreach($usrGroups as $uGrp){
				if($grID==$uGrp->textContent){echo(',"selected":true'); break;}
			}
			echo("}");
		}
		echo(']');
	
	}
	
	function checkUser($db, $usrID, $password){
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('ws/xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$users = $xp->query("//users/user[@id='$usrID']");
		if($users->length==0) return false;
		return $users->item(0)->getAttribute('password')==md5($password);
	}
}



