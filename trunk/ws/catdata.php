<?php 
require('providers/factory.php');


$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$ticket = $_REQUEST["ticket"];

function writeCatData($treeCatID, $dbCatID, $ticket){
	$treeProvider = ProviderFactory::getTree();
	if($dbCatID==null){
		$treeProvider->writeCatData($treeCatID);
	}
	else{
		$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
		if($tblRef==null){Util::writeError("errCatPropertiesNotAvailable"); die();}
		if($tblRef['srcType']=='') die();
		$provider = ProviderFactory::getTable($tblRef);
		if(Util::checkAccess($ticket, $catRef)){
			$provider->writeCatData($tblRef, $dbCatID);
		}
	}
}

writeCatData($treeCatID, $dbCatID, $ticket);


