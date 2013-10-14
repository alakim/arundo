<?php 

class XmlDB{
	function writeLinkedNodes($link, $el, $permissions, $defaultVisibility){
		$db = $link->getAttribute("xmldb");
		$tableName = $link->getAttribute("table");
		$parentID = $el->getAttribute("id");
		
		if($db=='') return;
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->load('xmlData/'.$db);
		$xp = new DOMXPath($doc);
		$table = $xp->query('//table[@name="'.$tableName.'"]');
		$catalogs = $xp->query('data/catalog', $table->item(0));
		TreeUtility::writeElements($catalogs, true, $xp, $parentID, $permissions, $defaultVisibility);
	}
	
	function writeColumns($tblRef){
		if($tblRef['xmlDBID']=='') return;
	
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDoc->load('xmlData/'.$tblRef['xmlDBID']);
		$dbPath = new DOMXPath($dbDoc);
		$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);
	
		$columns = $dbPath->query('columns/col', $table);
		
		echo('[');
		$first = true;
		foreach($columns as $col){
			$colID = $col->getAttribute('id');
			$colNm = Util::conv($col->getAttribute('name'));
			
			if($first) $first = false; else echo(',');
			echo("{\"field\":\"$colID\",\"title\":\"$colNm\"}");
		}
		echo(']');
	}
	
	function writeTableRows($tblRef, $dbCatID){
		if($tblRef['xmlDBID']=='') return;
		
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDoc->load('xmlData/'.$tblRef['xmlDBID']);
		$dbPath = new DOMXPath($dbDoc);
		
		$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);
		$columns = $dbPath->query('columns/col', $table);
		$rows;
		if($dbCatID=='')
			$rows = $dbPath->query("data/row", $table);
		else
			$rows = $dbPath->query("data//catalog[@id='$dbCatID']/row", $table);
		
		echo('[');
		$first = true;
		foreach($rows as $row){
			if($first) $first=false; else echo(',');
			$rID = $row->getAttribute('id');
			echo("{\"id\":\"$rID\",");
			$firstCol = true;
			foreach($columns as $col){
				if($firstCol) $firstCol=false; else echo(',');
				$colID = $col->getAttribute('id');
				$val = Util::conv($row->getAttribute($colID));
				echo("\"$colID\":\"$val\"");
			}
			echo('}');
		}
		echo(']');
	}
	
	function writeRecordData($tblRef, $dbCatID, $recID){
		if($tblRef['xmlDBID']=='') return;
		
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDoc->load('xmlData/'.$tblRef['xmlDBID']);
		$dbPath = new DOMXPath($dbDoc);
		
		$table = $dbPath->query("//table[@name='{$tblRef['tableID']}']")->item(0);

		$rec = $dbPath->query("//table[@name='{$tblRef['tableID']}']/data//row[@id='$recID']");
		if($rec->length==0){echo('{"error":"RecordMissing"}'); return;}
		$rec = $rec->item(0);
		
		$columns = $dbPath->query("//table[@name='{$tblRef['tableID']}']/columns/col");
		
		echo("{\"columns\":{");
		$firstCol = true;
		foreach($columns as $col){
			if($firstCol) $firstCol=false; else echo(',');
			$id = $col->getAttribute("id");
			$name = Util::conv($col->getAttribute("name"));
			$type = $col->getAttribute("type");
			if($type=='') $type = "text";
			echo("\"$id\":{\"field\":\"$id\",\"title\":\"$name\",\"type\":\"$type\"}");
		}
		echo('},');
		echo("\"data\":{\"id\":\"$recID\",");
		$firstCol = true;
		foreach($columns as $col){
			if($firstCol) $firstCol=false; else echo(',');
			$colID = $col->getAttribute('id');
			$val = Util::conv($rec->getAttribute($colID));
			echo("\"$colID\":\"$val\"");
		}
		echo('}');
		echo('}');
	}
}



