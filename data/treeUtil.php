<?php 
class TreeUtility{
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	static function getTableRef($treeCatID){
		$treeDoc = new DOMDocument('1.0', 'UTF-8');
		$treeDoc->load("tree.xml");
		$treePath = new DOMXPath($treeDoc);
		$links = $treePath->query("//catalog[@id='$treeCatID']/link");
		if($links->length==0){echo("[]"); return;}

		$link = $links->item(0);
		$dbID = $link->getAttribute('xmldb');
		$tableID = $link->getAttribute('table');
		return array(
			"dbID"=>$dbID,
			"tableID"=>$tableID
		);
	}
}

