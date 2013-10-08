<?php 
require('treeUtil.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];

function writeColumns($treeCatID, $dbCatID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	$provider = new $tblRef['srcType'];
	$provider->writeColumns($tblRef);
}

writeColumns($treeCatID, $dbCatID);


