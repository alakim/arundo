<?php 
require('treeUtil.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];

function writeRefRows($treeCatID, $dbCatID, $recID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);

	$provider = new $tblRef['srcType'];
	$provider->writeRefRows($tblRef, $dbCatID, $recID);
}


writeRefRows($treeCatID, $dbCatID, $recID);

