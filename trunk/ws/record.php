<?php 
require('treeUtil.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeRecordData($treeCatID, $dbCatID, $recID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	if($tblRef['xmlDBID']=='') return;
	
	$dbDoc = new DOMDocument('1.0', 'UTF-8');
	$dbDoc->load('xmlData/'.$tblRef['xmlDBID']);
	$dbPath = new DOMXPath($dbDoc);
	
	$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);

	$rec = $dbPath->query("//table[@name='{$tblRef['tableID']}']/data//row[@id='$recID']");
	if($rec->length==0){echo('{"error":"RecordMissing"}'); return;}
	$rec = $rec->item(0);
	
	$columns = $dbPath->query("//table[@name='{$tblRef['tableID']}']/columns/col");
	
	echo("{\"columns\":{");
	$firstCol = true;
	foreach($columns as $col){
		if($firstCol) $firstCol=false; else echo(',');
		$id = $col->getAttribute("id");
		$name = TreeUtility::conv($col->getAttribute("name"));
		$type = $col->getAttribute("type");
		if($type=='') $type = "text";
		echo("\"$id\":{\"field\":\"$id\",\"title\":\"$name\",\"type\":\"$type\"}");
	}
	echo('},');
	echo("\"data\":{\"id\":\"$recID\",");
	$firstCol = true;
	foreach($columns as $col){
		if($firstCol) $firstCol=false; else echo(',');
		$colID = $col->getAttribute('id');
		$val = TreeUtility::conv($rec->getAttribute($colID));
		echo("\"$colID\":\"$val\"");
	}
	echo('}');
	echo('}');
}

writeRecordData($treeCatID, $dbCatID, $recID);