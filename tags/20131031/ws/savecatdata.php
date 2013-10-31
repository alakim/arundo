<?php 
require('util.php');
require('providers/factory.php');

$catRef = explode("/", $_REQUEST["catID"]);
$treeCatID = $catRef[0];
$dbCatID = $catRef[1];
$data = $_REQUEST["data"];
$ticket = $_REQUEST["ticket"];

function saveCatalogProperties($catRef, $treeCatID, $dbCatID, $data, $ticket){
	// var_dump(array($treeCatID, $dbCatID, $data, $ticket));
	if(!Util::checkAccess($ticket, $catRef)){
		Util::writeError('errAuthorizationRequired');
		die();
	}
	
	$treeProvider = ProviderFactory::getTree();
	if($dbCatID==null){
		$treeProvider->saveTreeNode($treeCatID, $data);
	}
	else{
		$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
		$provider = ProviderFactory::getTable($tblRef);
		$provider->saveTreeNode($dbCatID, $data);
	}

	// $treeProvider = ProviderFactory::getTree();
	// $tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
	// if($tblRef['srcType']=='') die();
	// $provider = ProviderFactory::getTable($tblRef);
	// if(Util::checkAccess($ticket, $catRef)){
		// $provider->saveRecordData($tblRef, $dbCatID, $recID, $data);
	// }
}

saveCatalogProperties($catRef, $treeCatID, $dbCatID, $data, $ticket);