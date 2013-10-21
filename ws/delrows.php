<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');
require('providers/xmlUserSessions.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$ticket = $_REQUEST["ticket"];
$rowIDs = $_REQUEST["rowIDs"];

function writeResult($treeCatID, $dbCatID, $rowIDs){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	$provider = ProviderFactory::getTable($tblRef);
	if(Util::checkAccess($ticket, $catRef)){
		$provider->deleteRows($tblRef, $rowIDs);
	}
}

writeResult($treeCatID, $dbCatID, $rowIDs);