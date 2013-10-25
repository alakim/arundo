<?php 
require('providers/factory.php');

$ticket = $_REQUEST["ticket"];

function writeDBTypes($ticket){
	if(!Util::checkAccess($ticket, null)){
		Util::writeError('errAuthorizationRequired');
		die();
	}

	$types = ProviderFactory::getDBTypes();
	
	echo('[');
	echo('{"id":"none","text":"---"}');
	foreach(array_keys($types) as $k){
		$t = $types[$k];
		echo(",{\"id\":\"$k\",\"text\":\"$t\"}");
	}
	echo(']');
}


writeDBTypes($ticket);

