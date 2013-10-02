[<?php 
	$rootID = $_REQUEST["rootID"];
	$depth = $_REQUEST["depth"];
	$includeRoot = $_REQUEST["includeRoot"];
	$excludeBranch = $_REQUEST["excludeBranch"];
	
	$xmlDoc = new DOMDocument('1.0', 'UTF-8');
	$xmlDoc->load("tree.xml");
	
	$xpath = new DOMXPath($xmlDoc);
	
	$elements = $xpath->query("//catalog");
	
	function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	if(!is_null($elements)){
		$first = true;
		foreach($elements as $el){
			if($first) $first = false; else echo(",");
			echo("{\"id\":\"".$el->getAttribute("id")."\", \"text\":\"".conv($el->getAttribute("name"))."\", \"priority\":".$el->getAttribute("priority")."}");
		}
	}

?>
]