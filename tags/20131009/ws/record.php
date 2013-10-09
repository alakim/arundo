<?php 
require('treeUtil.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeRecordData($treeCatID, $dbCatID, $recID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	$provider = new $tblRef['srcType'];
	$provider->writeRecordData($tblRef, $dbCatID, $recID);
}

writeRecordData($treeCatID, $dbCatID, $recID);