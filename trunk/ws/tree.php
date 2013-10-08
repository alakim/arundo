<?php 
require('treeUtil.php');

$rootID = $_REQUEST["rootID"];
$depth = $_REQUEST["depth"];
$includeRoot = $_REQUEST["includeRoot"];
$excludeBranch = $_REQUEST["excludeBranch"];

$xmlDoc = new DOMDocument('1.0', 'UTF-8');
$xmlDoc->load("xmlData/tree.xml");

$xpath = new DOMXPath($xmlDoc);
$query = "/tree/catalog";
if($rootID) $query = "//catalog[@id='".$rootID."']";
$elements = $xpath->query($query);

function writeElements($elements, $recursive, $xpath, $parentID){
	if($includeRoot){
		echo("{\"id\":null, \"text\":\"/\"}");
	}
	if(!is_null($elements)){
		$first = true && !$includeRoot;
		foreach($elements as $el){
			if($el->nodeType!=1) continue; // исключаем текстовые узлы
			$id = $el->getAttribute("id");
			if($excludeBranch==$id) continue;
			$prefix = $parentID?$parentID.'/':'';
			
			if($first) $first = false; else echo(",");
			$name = TreeUtility::conv($el->getAttribute("name"));
			$priority = $el->getAttribute("priority"); if($priority=="") $priority = 0;
			
			echo("{\"id\":\"".$prefix.$id."\", \"text\":\"".$name."\", \"priority\":".$priority);
			
			if($recursive && $el->hasChildNodes()){
				echo(",\"children\":[");
				writeElements($xpath->query("catalog", $el), true, $xpath, $parentID);
				addLinkedTree($el, $xpath);
				echo("]");
			}
			echo("}");
		}
	}
}

function addLinkedTree($el, $xpath){
	$lnks = $xpath->query("link", $el);
	if(is_null($lnks) || $lnks->length==0) return;
	$link = $lnks->item(0);
	
	addLinkedXmlDB($link->getAttribute("xmldb"), $link->getAttribute("table"), $el->getAttribute("id"));
	addLinkedXmlUsersDB($link->getAttribute("xmlUsersDB"), $el->getAttribute("id"));
}

function addLinkedXmlDB($db, $tableName, $parentID){
	if($db=='') return;
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->load('xmlData/'.$db);
	$xp = new DOMXPath($doc);
	$table = $xp->query('//table[@name="'.$tableName.'"]');
	$catalogs = $xp->query('data/catalog', $table->item(0));
	writeElements($catalogs, true, $xp, $parentID);
}

function addLinkedXmlUsersDB($db, $parentID){
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

echo("[");
writeElements($elements, $depth!="1", $xpath, null);
echo("]");
