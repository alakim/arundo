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
	
	function writeColumns($tblRef, $allMode){
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
			echo("{\"field\":\"$colID\",\"title\":\"$colNm\"");
			if($allMode){
				$colType = $col->getAttribute('type');
				if($colType=='') $colType = 'text';
				echo(",\"type\":\"$colType\"");
			}
			echo('}');
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
		if($rec->length==0){Util::writeErrorData('RecordMissing', $recID); return;}
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
		echo("\"data\":{\"id\":\"$recID\",\"catID\":\"$dbCatID\",");
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
	
	function saveRecordData($tblRef, $dbCatID, $recID, $data){
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDocFile = 'xmlData/'.$tblRef['xmlDBID'];
		$dbDoc->load($dbDocFile);
		$dbPath = new DOMXPath($dbDoc);
		if($recID==''){
			$cat = $dbPath->query("//data//catalog[@id='$dbCatID']");
			if($cat->length<1){
				Util::writeErrorData('errCatNotExist', $dbCatID); return;
			}
			$cat = $cat->item(0);
			$row = $dbDoc->createElement('row');
			$cat->appendChild($row);
			$row->setAttribute('id', com_create_guid());
		}
		else{
			$rows = $dbPath->query("//data//row[@id='$recID']");
			if($rows->length<1){
				Util::writeErrorData('RecordMissing', $recID); return;
			}
			$row = $rows->item(0);
			foreach(array_keys($data) as $fld){
				$row->setAttribute($fld, $data[$fld]);
			}
		}
		foreach(array_keys($data) as $fld){
			$row->setAttribute($fld, $data[$fld]);
		}
		$dbDoc->save($dbDocFile);
		echo("[]");
	}
	
	function deleteRows($tblRef, $rowIDs){
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDocFile = 'xmlData/'.$tblRef['xmlDBID'];
		$dbDoc->load($dbDocFile);
		$xp = new DOMXPath($dbDoc);
		
		$rowIDs = explode(';', $rowIDs);
		foreach($rowIDs as $rowID){
			$row = $xp->query("//data//row[@id='$rowID']");
			if($row->length<1) continue;
			$row = $row->item(0);
			$cat = $row->parentNode;
			$cat->removeChild($row);
		}
		$dbDoc->save($dbDocFile);
		echo('[]');
	}
	
	function writeCatData($tblRef, $dbCatID){
		$dbDoc = new DOMDocument('1.0', 'UTF-8');
		$dbDocFile = 'xmlData/'.$tblRef['xmlDBID'];
		$dbDoc->load($dbDocFile);
		$xp = new DOMXPath($dbDoc);
		
		$cat = $xp->query("//data//catalog[@id='$dbCatID']");
		if($cat->length<1){Util::writeErrorData('errCatNotExist', $dbCatID); die();}
		$cat = $cat->item(0);
		$cNm = $cat->getAttribute('name');
		$cPrt = $cat->parentNode->getAttribute("id");
		$cPriority = $cat->getAttribute("priority");
		echo("{\"total\":4,");
		echo("\"rows\":[");
		//echo("{\"name\":\"ID\", \"value\":\"$dbCatID\", \"hidden\":true, \"editor\":\"none\"}");
		echo("{\"name\":\"Name\", \"value\":\"$cNm\", \"editor\":\"text\"}");
		if($cPrt!='')
			echo(",{\"name\":\"Parent\", \"value\":\"$cPrt\", \"editor\":{\"type\":\"combotree\"}}");
		if($cPriority!='')
			echo(",{\"name\":\"Priority\", \"value\":$cPriority, \"editor\":\"text\"}");
		echo(']}');
	}
}


