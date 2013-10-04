<?php 
require('treeUtil.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeResult($treeCatID, $dbCatID, $recID){
	$tblRef = TreeUtility::getTableRef($treeCatID);
	if($tblRef['dbID']=='') return;
	
	echo("{\"error\":\"errSavingRecord\"}");
}

writeResult($treeCatID, $dbCatID, $recID);