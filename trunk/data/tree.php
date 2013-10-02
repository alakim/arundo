[<?php 
	$rootID = $_REQUEST["rootID"];
	$depth = $_REQUEST["depth"];
	$includeRoot = $_REQUEST["includeRoot"];
	$excludeBranch = $_REQUEST["excludeBranch"];
	
	$xmlDoc = new DOMDocument();
	$xmlDoc->encoding = "UTF-8";
	$xmlDoc->load("tree.xml");
	
	$xpath = new DOMXPath($xmlDoc);
	
	$elements = $xpath->query("//catalog");
	
	if(!is_null($elements)){
		$first = true;
		foreach($elements as $el){
			if($first) $first = false; else echo(",");
			echo("{\"id\":\"".$el->getAttribute("id")."\", \"text\":\"".$el->getAttribute("name")."\", \"priority\":".$el->getAttribute("priority")."}");
		}
	}

?>
]