<?php 
require('util.php');
require('providers/factory.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];


function writeTableRows($treeCatID, $dbCatID){
	$treeProvider = ProviderFactory::getTree();
	$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
	if($tblRef['srcType']=='') die();
	$provider = ProviderFactory::getTable($tblRef);
	$provider->writeTableRows($tblRef, $dbCatID);
}


writeTableRows($treeCatID, $dbCatID);


