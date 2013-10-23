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

function writeCatData($treeCatID, $dbCatID){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	if($tblRef==null){Util::writeError("errCatDataNotAvailable"); die();}
	if($tblRef['srcType']=='') die();
	$provider = ProviderFactory::getTable($tblRef);
	if(Util::checkAccess($ticket, $catRef)){
		$provider->writeCatData($tblRef, $dbCatID);
	}
}

writeCatData($treeCatID, $dbCatID);


