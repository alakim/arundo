<?php 
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');
require('providers/xmlUserSessions.php');


$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$allMode = $_REQUEST["all"]=='1';
$ticket = $_REQUEST["ticket"];

function writeColumns($treeCatID, $dbCatID, $allMode){
	$treeProvider = ProviderFactory::getTree();
	$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
	if($tblRef['srcType']=='') die();
	$provider = ProviderFactory::getTable($tblRef);
	if(Util::checkAccess($ticket, $catRef)){
		$provider->writeColumns($tblRef, $allMode);
	}
}

writeColumns($treeCatID, $dbCatID, $allMode);


