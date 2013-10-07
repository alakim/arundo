<?php 
require('treeUtil.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];

function writeColumns($treeCatID, $dbCatID){
	$tblRef = TreeUtility::getTableRef($treeCatID);
	if($tblRef['xmlDBID']=='') return;

	$dbDoc = new DOMDocument('1.0', 'UTF-8');
	$dbDoc->load($tblRef['xmlDBID']);
	$dbPath = new DOMXPath($dbDoc);
	$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);
	
	$columns = $dbPath->query('columns/col', $table);
	
	echo('[');
	$first = true;
	foreach($columns as $col){
		$colID = $col->getAttribute('id');
		$colNm = TreeUtility::conv($col->getAttribute('name'));
		
		if($first) $first = false; else echo(',');
		echo("{\"field\":\"$colID\",\"title\":\"$colNm\"}");
	}
	echo(']');
}

writeColumns($treeCatID, $dbCatID);


