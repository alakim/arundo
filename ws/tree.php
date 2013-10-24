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
$treeProvider->writeTree($rootID, $depth!="1", null, $permissions, false);
echo("]");
