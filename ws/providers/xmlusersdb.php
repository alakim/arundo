<?php 

class XmlUsersDB{
	static $idField = "usersDBID";
	
	static $defaultDoc = 'usersDB.xml';
	
	function __construct(){
		$this->dbDoc = self::$defaultDoc;
	}
	
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
		$db = $tblRef[self::$idField];
		$sectID = $tblRef['section'];
		
		if($db=='' || $sectID==''){echo('[]'); return;}
		
		echo('[');
		echo("{\"field\":\"id\",\"title\":\"�������������\"},");
		echo("{\"field\":\"name\",\"title\":\"��������\"}");
		echo(']');
	}
	
	function writeTableRows($tblRef, $dbCatID){
		$db = $tblRef[self::$idField];
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
			$rNm = Util::conv($row->getAttribute('name'));
			if($first) $first = false; else echo(',');
			echo("{\"id\":\"$rID\",\"name\":\"$rNm\"}");
		}
		echo(']');
	}
	
	function writeRecordData($tblRef, $dbCatID, $recID){
		$db = $tblRef[self::$idField];
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
		
		$itmName = Util::conv($row->getAttribute('name'));
		
		echo("{\"columns\":{");
		echo("\"id\":{\"field\":\"id\",\"title\":\"�������������\",\"type\":\"text\"},");
		echo("\"name\":{\"field\":\"name\",\"title\":\"��������\",\"type\":\"text\"}");
		if($sectID=='userGroups'){
			echo(',');
			echo("\"permissions\":{\"field\":\"permissions\",\"title\":\"����� ������������\",\"type\":\"rights\"}");
		}
		else if($sectID=='userAccounts'){
			echo(',');
			echo("\"bgnDate\":{\"field\":\"bgnDate\",\"title\":\"���� ������ �����������\",\"type\":\"date\"},");
			echo("\"endDate\":{\"field\":\"endDate\",\"title\":\"���� ����� �����������\",\"type\":\"date\"},");
			echo("\"groups\":{\"field\":\"groups\",\"title\":\"������\",\"type\":\"refList\"}");
		}
		echo('},');
		echo("\"data\":{\"id\":\"$recID\",");
		echo("\"id\":\"{$row->getAttribute('id')}\",");
		echo("\"name\":\"{$itmName}\",");
		if($sectID=='userGroups'){
			echo("\"permissions\":[]");
		}
		else if($sectID=='userAccounts'){
			echo("\"bgnDate\":\"{$row->getAttribute('bgnDate')}\",");
			echo("\"endDate\":\"{$row->getAttribute('endDate')}\",");
			echo("\"groups\":\"\"");
		}
		echo('}');
		echo('}');
	}
	
	function writeUserPermissions($grpID){
		echo("[{\"id\":\"g1\",\"name\":\"Group1\",\"read\":\"on\",\"write\":\"off\",\"children\":[");
		echo("{\"id\":\"g11\",\"name\":\"Group11\",\"read\":\"off\",\"write\":\"off\"},");
		echo("{\"id\":\"g12\",\"name\":\"Group12\",\"read\":\"off\",\"write\":\"on\"}");
		echo("]}]");
	}
	
	function writeRefRows($tblRef, $dbCatID, $recID){
		$db = $tblRef[self::$idField];
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
			$grNm = Util::conv($grp->getAttribute('name'));
			echo("{\"id\":\"$grID\", \"text\":\"$grNm\"");
			foreach($usrGroups as $uGrp){
				if($grID==$uGrp->textContent){echo(',"selected":true'); break;}
			}
			echo("}");
		}
		echo(']');
	
	}
	
	function checkUser($usrID, $password){
		$db = $this->dbDoc;
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('ws/xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$users = $xp->query("//users/user[@id='$usrID']");
		if($users->length==0) return false;
		return $users->item(0)->getAttribute('password')==md5($password);
	}
	
	function getUserName($usrID){
		$db = $this->dbDoc;
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('ws/xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$users = $xp->query("//users/user[@id='$usrID']");
		if($users->length==0) return;
		return Util::conv($users->item(0)->getAttribute('name'));
	}
	
	function getUserPermissions($usrID){
		$db = $this->dbDoc;
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		
		$res = array();
		$groups = $xp->query("//users/user[@id='$usrID']/member/@group");
		
		foreach($groups as $grp){
			$grpID = $grp->value;
			$catPermissions = $xp->query("//groups/group[@id='$grpID']/permissions/cat");
			foreach($catPermissions as $catPerm){
				$catID = $catPerm->getAttribute('id');
				$perm = $catPerm->getAttribute('permissions');
				$res[$catID] = array(
					'r'=>strpos($perm, 'r')!==false,
					'w'=>strpos($perm, 'w')!==false
				);
			}
		}
		
		return $res;
	}
	
}



