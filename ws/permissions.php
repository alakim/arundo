<?php 
require('providers/factory.php');

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

