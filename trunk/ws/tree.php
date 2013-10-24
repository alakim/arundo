<?php 
require('providers/factory.php');

$rootID = $_REQUEST["rootID"];
$depth = $_REQUEST["depth"];
$includeRoot = $_REQUEST["includeRoot"];
$excludeBranch = $_REQUEST["excludeBranch"];
$ticket = $_REQUEST["ticket"];
$thisDBOnly = $_REQUEST["thisDBOnly"]=='true';

$permissions = Util::getUserPermissions($ticket);


$treeProvider = ProviderFactory::getTree();

echo("[");
if(strpos($rootID, "/")>0){
	$catRef = explode("/", $rootID);
	$treeCatID = $catRef[0];
	$dbCatID = $catRef[1];
	$tblRef = $treeProvider->getTableRef($treeCatID, $dbCatID);
	$dbProvider = ProviderFactory::getTable($tblRef);
	//var_dump($tblRef);
	$dbProvider->writeTableTree($tblRef['tableID'], $treeCatID);
}
else{
	$treeProvider->writeTree($rootID, $depth!="1", null, $permissions, false);
}
echo("]");
