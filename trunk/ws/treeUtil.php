<?php 
require('util.php');

class TreeUtility{
	// Документ, содержащий описание дерева
	static $treeDoc = 'xmlData/tree.xml';
	
	static function getTableRef($treeCatID, $dbCatID){
		$treeDoc = new DOMDocument('1.0', 'UTF-8');
		$treeDoc->load(self::$treeDoc);
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
	

	static function addLinkedTree($el, $xpath, $permissions, $defaultVisibility){
		$lnks = $xpath->query("link", $el);
		if(is_null($lnks) || $lnks->length==0) return;
		$link = $lnks->item(0);
		
		if($link->getAttribute("xmldb")!='') $provider = new XmlDB();
		if($link->getAttribute("xmlUsersDB")!='') $provider = new XmlUsersDB();
		
		if(!is_null($provider)) $provider->writeLinkedNodes($link, $el, $permissions, $defaultVisibility);
	}


	function writeElements($elements, $recursive, $xpath, $parentID, $permissions, $defaultVisibility){
		if($includeRoot){
			echo("{\"id\":null, \"text\":\"/\"}");
		}
		if(!is_null($elements)){
			$first = true && !$includeRoot;
			foreach($elements as $el){
				if($el->nodeType!=1) continue; // исключаем текстовые узлы
				$id = $el->getAttribute("id");
				if(!is_null($permissions)){
					if($permissions[$id]!=null){
						if(!($permissions[$id]["r"])) continue;
						else $defaultVisibility = true;
					}
					else if(!$defaultVisibility) continue;
				}
				if($excludeBranch==$id) continue;
				$prefix = $parentID?$parentID.'/':'';
				
				if($first) $first = false; else echo(",");
				$name = Util::conv($el->getAttribute("name"));
				$priority = $el->getAttribute("priority"); if($priority=="") $priority = 0;
				
				echo("{\"id\":\"".$prefix.$id."\", \"text\":\"".$name."\", \"priority\":".$priority);
				
				if($recursive && $el->hasChildNodes()){
					echo(",\"children\":[");
					self::writeElements($xpath->query("catalog", $el), true, $xpath, $parentID, $permissions, $defaultVisibility);
					self::addLinkedTree($el, $xpath, $permissions, $defaultVisibility);
					echo("]");
				}
				echo("}");
			}
		}
	}
}

