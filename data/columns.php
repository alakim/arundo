<?php 
$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];

function conv($str){
	return iconv("UTF-8", "windows-1251", $str);
}

function writeColumns($treeCatID, $dbCatID){
	$treeDoc = new DOMDocument('1.0', 'UTF-8');
	$treeDoc->load("tree.xml");
	$treePath = new DOMXPath($treeDoc);
	$links = $treePath->query("//catalog[@id='$treeCatID']/link");
	if($links->length==0){echo("[]"); return;}

	$link = $links->item(0);
	$dbID = $link->getAttribute('xmldb');
	$tableID = $link->getAttribute('table');
	
	$dbDoc = new DOMDocument('1.0', 'UTF-8');
	$dbDoc->load($dbID);
	$dbPath = new DOMXPath($dbDoc);
	$table = $dbPath->query("//table[@name='$tableID']")->item(0);
	
	$columns = $dbPath->query('columns/col', $table);
	
	echo('[');
	$first = true;
	foreach($columns as $col){
		$colID = $col->getAttribute('id');
		$colNm = conv($col->getAttribute('name'));
		
		if($first) $first = false; else echo(',');
		echo("{\"field\":\"$colID\",\"title\":\"$colNm\"}");
	}
	echo(']');
}

writeColumns($treeCatID, $dbCatID);


