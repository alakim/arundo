<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];

function writeColumns($treeCatID, $dbCatID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	$provider = ProviderFactory::getTable($tblRef);
	$provider->writeColumns($tblRef);
}

writeColumns($treeCatID, $dbCatID);


