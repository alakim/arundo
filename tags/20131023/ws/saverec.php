<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');
require('providers/xmlUserSessions.php');

$recID = $_REQUEST["recID"];

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$ticket = $_REQUEST["ticket"];
$data = $_REQUEST["data"];

function writeResult($treeCatID, $dbCatID, $recID, $data){
	$tblRef = TreeUtility::getTableRef($treeCatID, $dbCatID);
	if($tblRef['srcType']=='') die();
	$provider = ProviderFactory::getTable($tblRef);
	if(Util::checkAccess($ticket, $catRef)){
		$provider->saveRecordData($tblRef, $dbCatID, $recID, $data);
	}
}

writeResult($treeCatID, $dbCatID, $recID, $data);