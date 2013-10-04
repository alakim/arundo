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

function writeElements($elements, $recursive, $xpath, $parentID){
	if($includeRoot){
		echo("{\"id\":null, \"text\":\"/\"}");
	}
	if(!is_null($elements)){
		$first = true && !$includeRoot;
		foreach($elements as $el){
			if($el->nodeType!=1) continue; // ��������� ��������� ����
			$id = $el->getAttribute("id");
			if($excludeBranch==$id) continue;
			$prefix = $parentID?$parentID.'/':'';
			
			if($first) $first = false; else echo(",");
			$name = conv($el->getAttribute("name"));
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
	
	$xmldb = $link->getAttribute("xmldb");
	if(!is_null($xmldb))
		addLinkedXmlDB($xmldb, $link->getAttribute("table"), $el->getAttribute("id"));
}

function addLinkedXmlDB($db, $tableName, $parentID){
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->load($db);
	$xp = new DOMXPath($doc);
	$table = $xp->query('//table[@name="'.$tableName.'"]');
	$catalogs = $xp->query('data/catalog', $table->item(0));
	writeElements($catalogs, true, $xp, $parentID);
}

echo("[");
writeElements($elements, $depth!="1", $xpath, null);
echo("]");
