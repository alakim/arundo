<?php 
require('treeUtil.php');
require('providers/factory.php');
require('providers/xmldb.php');
require('providers/xmlusersdb.php');

$grpID = $_REQUEST["grpID"];
$ticket = $_REQUEST["ticket"];

if($ticket==''){
	echo("{\"error\":\"errAuthorizationRequired\"}");
	die();
}


function writePermissions($grpID){
	$provider = ProviderFactory::getUsers();
	$provider->writeUserPermissions($grpID);
}


writePermissions($grpID);

