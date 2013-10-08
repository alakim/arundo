<?php 
class TreeUtility{
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	static function getTableRef($treeCatID, $dbCatID){
		$treeDoc = new DOMDocument('1.0', 'UTF-8');
		$treeDoc->load('xmlData/tree.xml');
		$treePath = new DOMXPath($treeDoc);
		$links = $treePath->query("//catalog[@id='$treeCatID']/link");
		if($links->length==0){echo("[]"); return;}

		$link = $links->item(0);
		$xmlDBID = $link->getAttribute('xmldb');
		if($xmlDBID!=''){
			$tableID = $link->getAttribute('table');
			return array(
				'srcType'=>'XmlDB',
				'xmlDBID'=>$xmlDBID,
				'tableID'=>$tableID
			);
		}
		
		$usersDBID = $link->getAttribute('xmlUsersDB');
		if($usersDBID!=''){
			return array(
				'srcType'=>'XmlUsersDB',
				'usersDBID'=>$usersDBID,
				'section'=>$dbCatID
			);
		}
	}
}

