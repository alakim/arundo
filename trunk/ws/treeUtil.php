<?php 
class TreeUtility{
	// Документ, содержащий описание дерева
	static $treeDoc = 'xmlData/tree.xml';
	
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	static function getTableRef($treeCatID, $dbCatID){
		$treeDoc = new DOMDocument('1.0', 'UTF-8');
		$treeDoc->load(TreeUtility::$treeDoc);
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
	

	function writeElements($elements, $recursive, $xpath, $parentID){
		if($includeRoot){
			echo("{\"id\":null, \"text\":\"/\"}");
		}
		if(!is_null($elements)){
			$first = true && !$includeRoot;
			foreach($elements as $el){
				if($el->nodeType!=1) continue; // исключаем текстовые узлы
				$id = $el->getAttribute("id");
				if($excludeBranch==$id) continue;
				$prefix = $parentID?$parentID.'/':'';
				
				if($first) $first = false; else echo(",");
				$name = TreeUtility::conv($el->getAttribute("name"));
				$priority = $el->getAttribute("priority"); if($priority=="") $priority = 0;
				
				echo("{\"id\":\"".$prefix.$id."\", \"text\":\"".$name."\", \"priority\":".$priority);
				
				if($recursive && $el->hasChildNodes()){
					echo(",\"children\":[");
					TreeUtility::writeElements($xpath->query("catalog", $el), true, $xpath, $parentID);
					addLinkedTree($el, $xpath);
					echo("]");
				}
				echo("}");
			}
		}
	}
}

