<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');
require('providers/xmlUserSessions.php');

$rootID = $_REQUEST["rootID"];
$depth = $_REQUEST["depth"];
$includeRoot = $_REQUEST["includeRoot"];
$excludeBranch = $_REQUEST["excludeBranch"];
$ticket = $_REQUEST["ticket"];

$permissions = Util::getUserPermissions($ticket);

$xmlDoc = new DOMDocument('1.0', 'UTF-8');
$xmlDoc->load(TreeUtility::$treeDoc);

$xpath = new DOMXPath($xmlDoc);
$query = "/tree/catalog";
if($rootID) $query = "//catalog[@id='".$rootID."']";
$elements = $xpath->query($query);

echo("[");
TreeUtility::writeElements($elements, $depth!="1", $xpath, null);
echo("]");
