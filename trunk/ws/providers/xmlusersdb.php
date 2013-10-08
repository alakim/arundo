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
			echo("{\"id\":\"$parentID/userGroups\", \"text\":\"������ �������������\"}");
		}
		if($groups->length>0 && $users->length>0){echo(',');}
		if($users->length>0){
			echo("{\"id\":\"$parentID/userAccounts\", \"text\":\"������������\"}");
		}
	}
	
	function writeColumns($tblRef){
		$db = $tblRef['usersDBID'];
		$sectID = $tblRef['section'];
		
		if($db=='' || $sectID==''){echo('[]'); return;}
		
		echo('[');
		echo("{\"field\":\"id\",\"title\":\"�������������\"},");
		echo("{\"field\":\"name\",\"title\":\"��������\"}");
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
		echo("\"id\":{\"field\":\"id\",\"title\":\"�������������\",\"type\":\"text\"},");
		echo("\"name\":{\"field\":\"name\",\"title\":\"��������\",\"type\":\"text\"},");
		echo("\"bgnDate\":{\"field\":\"bgnDate\",\"title\":\"���� ������ �����������\",\"type\":\"date\"},");
		echo("\"endDate\":{\"field\":\"endDate\",\"title\":\"���� ����� �����������\",\"type\":\"date\"},");
		echo("\"groups\":{\"field\":\"groups\",\"title\":\"������\",\"type\":\"refList\"}");
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
}



