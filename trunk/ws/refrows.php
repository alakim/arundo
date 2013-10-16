<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$data = $_REQUEST["data"];

function writeRefRows($treeCatID, $dbCatID, $recID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	$provider = ProviderFactory::getTable($tblRef);
	$provider->writeRefRows($tblRef, $dbCatID, $recID);
}


writeRefRows($treeCatID, $dbCatID, $recID);

