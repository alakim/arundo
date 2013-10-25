<?php 
require('util.php');

class XmlTree{
	// Документ, содержащий описание дерева
	private static $treeDoc = 'xmlData/tree.xml';
	
	function getTableRef($treeCatID, $dbCatID){
		$treeDoc = new DOMDocument('1.0', 'UTF-8');
		$treeDoc->load(self::$treeDoc);
		$treePath = new DOMXPath($treeDoc);
		$links = $treePath->query("//catalog[@id='$treeCatID']/link");
		if($links->length==0){return;}

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
	
	function writeTree($rootID, $recursive, $parentID, $permissions, $defaultVisibility){
		$xmlDoc = new DOMDocument('1.0', 'UTF-8');
		$xmlDoc->load(self::$treeDoc);

		$xpath = new DOMXPath($xmlDoc);
		$query = "/tree/catalog";
		if($rootID) $query = "//catalog[@id='".$rootID."']";
		$elements = $xpath->query($query);

		self::writeElements($elements, $recursive, $xpath, $parentID, $permissions, $defaultVisibility);
	}
	
	function writeCatData($treeCatID){
		$xmlDoc = new DOMDocument('1.0', 'UTF-8');
		$xmlDoc->load(self::$treeDoc);
		$xpath = new DOMXPath($xmlDoc);
		
		$cat = $xpath->query("//catalog[@id='$treeCatID']");
		if($cat->length<1){Util::writeErrorData('errCatNotExist', $treeCatID); die();}
		$cat = $cat->item(0);
	
		$cNm = Util::conv($cat->getAttribute("name"));
		$cPriority = $cat->getAttribute("priority");
		if($cPriority=='') $cPriority = 0;
		$cPrt = $cat->parentNode->getAttribute("id");
		
		echo("{\"total\":4,");
		echo("\"rows\":[");
		echo("{\"name\":\"ID\", \"group\":\"TreeNode\", \"value\":\"$treeCatID\", \"editor\":\"text\"}");
		echo(",{\"name\":\"Name\", \"group\":\"TreeNode\", \"value\":\"$cNm\", \"editor\":\"text\"}");
		echo(",{\"name\":\"Parent\", \"group\":\"TreeNode\", \"value\":\"$cPrt\", \"editor\":{\"type\":\"combotree\"}}");
		echo(",{\"name\":\"Priority\", \"group\":\"TreeNode\", \"value\":$cPriority, \"editor\":\"text\"}");
			
			
		$lnkType = '';
		$lnkDB = '';
		$lnkTable = '';

		$link = $xpath->query('link', $cat);
		if($link->length>0){
			$link = $link->item(0);
			if($link->getAttribute('xmlUsersDB')!=''){
				$lnkType = "XmlUsersDB";
				$lnkDB = $link->getAttribute('xmlUsersDB');
			}
			else if($link->getAttribute('xmldb')!=''){
				$lnkType = "XmlDB";
				$lnkDB = $link->getAttribute('xmldb');
				$lnkTable = $link->getAttribute('table');
			}
		}
		echo(",{\"name\":\"LinkType\", \"group\":\"Link\", \"value\":\"$lnkType\", \"editor\":\"linkTypes\"}");
		echo(",{\"name\":\"LinkDB\", \"group\":\"Link\", \"value\":\"$lnkDB\", \"editor\":\"text\"}");
		echo(",{\"name\":\"LinkTable\", \"group\":\"Link\", \"value\":\"$lnkTable\", \"editor\":\"text\"}");
		
		
		echo(']}');
		
	}

	private static function addLinkedTree($el, $xpath, $permissions, $defaultVisibility){
		$lnks = $xpath->query("link", $el);
		if(is_null($lnks) || $lnks->length==0) return;
		$link = $lnks->item(0);
		
		if($link->getAttribute("xmldb")!='')$provider = new XmlDB($link->getAttribute("xmldb"));
		if($link->getAttribute("xmlUsersDB")!='') $provider = new XmlUsersDB();
		
		if(!is_null($provider)) $provider->writeLinkedNodes($link, $el, $permissions, $defaultVisibility);
	}


	static function writeElements($elements, $recursive, $xpath, $parentID, $permissions, $defaultVisibility){
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
				
				$iconClass = '';
				$links = $el->getElementsByTagName('link');
				if($links->length>0 && $links->item(0)->parentNode===$el) $iconClass = 'linkNode';
				if($iconClass!='') echo(",\"iconCls\":\"$iconClass\"");
				
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

