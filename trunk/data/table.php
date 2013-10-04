<?php 
require('treeUtil.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeTableRows($treeCatID, $dbCatID){
	$tblRef = TreeUtility::getTableRef($treeCatID);
	
	$dbDoc = new DOMDocument('1.0', 'UTF-8');
	$dbDoc->load($tblRef['dbID']);
	$dbPath = new DOMXPath($dbDoc);
	
	$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);
	$columns = $dbPath->query('columns/col', $table);
	$rows;
	if($dbCatID=='')
		$rows = $dbPath->query("data/row", $table);
	else
		$rows = $dbPath->query("data//catalog[@id='$dbCatID']/row", $table);
	
	echo('[');
	$first = true;
	foreach($rows as $row){
		if($first) $first=false; else echo(',');
		$rID = $row->getAttribute('id');
		echo("{\"id\":\"$rID\",");
		$firstCol = true;
		foreach($columns as $col){
			if($firstCol) $firstCol=false; else echo(',');
			$colID = $col->getAttribute('id');
			$val = TreeUtility::conv($row->getAttribute($colID));
			echo("\"$colID\":\"$val\"");
		}
		echo('}');
	}
	echo(']');
}


writeTableRows($treeCatID, $dbCatID);


