<?php 
$rootID = $_REQUEST["rootID"];
$depth = $_REQUEST["depth"];
$includeRoot = $_REQUEST["includeRoot"];
$excludeBranch = $_REQUEST["excludeBranch"];

$xmlDoc = new DOMDocument('1.0', 'UTF-8');
$xmlDoc->load("tree.xml");

$xpath = new DOMXPath($xmlDoc);
$query = "/tree/catalog";
if($rootID) $query = "//catalog[@id='".$rootID."']";
$elements = $xpath->query($query);

function conv($str){
	return iconv("UTF-8", "windows-1251", $str);
}

function writeElements($elements, $recursive){
	echo("[");
	if($includeRoot){
		echo("{\"id\":null, \"text\":\"/\"}");
	}
	if(!is_null($elements)){
		$first = true && !$includeRoot;
		foreach($elements as $el){
			if($el->nodeType!=1) continue; // исключаем текстовые узлы
			$id = $el->getAttribute("id");
			if($excludeBranch==$id) continue;
			
			if($first) $first = false; else echo(",");
			echo("{\"id\":\"".$id."\", \"text\":\"".conv($el->getAttribute("name"))."\", \"priority\":".$el->getAttribute("priority"));
			if($recursive && $el->hasChildNodes()){
				echo(",\"children\":");
				writeElements($el->childNodes, true);
			}
			echo("}");
		}
	}
	echo("]");
}

writeElements($elements, $depth!="1");