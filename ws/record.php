<?php 
require('util.php');
require('providers/factory.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeRecordData($treeCatID, $dbCatID, $recID){
	$treeProvider = ProviderFactory::getTree();
	$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
	if($tblRef['srcType']=='') die();
	$provider = ProviderFactory::getTable($tblRef);
	$provider->writeRecordData($tblRef, $dbCatID, $recID);
}

writeRecordData($treeCatID, $dbCatID, $recID);