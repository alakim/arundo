<?php 

require("settings.php");

function openConnection(){
	global $Settings;
	
	$con=mysqli_connect($Settings['dbServer'], $Settings['dbUser'], $Settings['dbPassword'], $Settings['dbName']);

	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		return false;
	}
	
	// mysqli_query($con, "SET NAMES '".$Settings['encoding']."'"); 

	
	return $con;
}

function closeConnection($con){
	mysqli_close($con);
}

function execSql($con, $sql){
	$res = mysqli_query($con, $sql);
	if ($res){
		//echo("Success<br/>");
		return $res;
	}
	else{
		echo "Error: " . mysqli_error($con)."<br/>";
	}
}

function tableExists($con, $tableName){
	if(execSql($con, "show tables like \"".$tableName."\"")->num_rows>0){
		return true;
	}
	return false;
}

function getOwner($con, $tableName, $recID){
	if($recID==null){
		writeError("Record ID not set");
		die();
	}
	
	$sql = "SELECT Owner FROM ".$tableName." WHERE ID=".$recID;
	$res = mysqli_query($con, $sql);
	$row = $res->fetch_array();
	return $row[0];
}

function SqlValue($v){
	if(is_null($v)){
		return "NULL";
	}
	else if(is_string($v)){
		return "'".$v."'";
	}
	return $v;
}
	
function addRecord($con, $tableName, $data){
	$fields = implode(",", array_keys($data));
	$aValues = array_values($data);
	for($i=0; $i<count($aValues); $i++){
		$aValues[$i] = SqlValue($aValues[$i]);
	}
	$values = implode(",", $aValues);
	$sql = "INSERT INTO ".$tableName." (".$fields.") VALUES (".$values.")";
	// echo($sql."<hr/>");
	execSql($con, $sql);
}
	
function saveRecord($con, $tableName, $rowID, $data){
	$aVal = array();
	foreach(array_keys($data) as $k){
		array_push($aVal, $k."=".SqlValue($data[$k]));
	}

	$sql = "UPDATE ".$tableName." SET ".(implode(",", $aVal))." WHERE ID=".$rowID;
	// echo($sql."<hr/>");
	execSql($con, $sql);
}

function writeJsonField($row, $fldName, $stringMode){
	$fld = strtolower($fldName);
	$val = $row[$fldName];
	if(is_null($val)){ $val = "null";}
	else if($stringMode) {$val = "\"".str_replace("\"", "\\\"", $val)."\"";}
	echo("\"".$fld."\":".$val);
}

function getRequestField($data, $fldName, $intMode){
	global $Settings;
	
	$val = $data[$fldName];
	if(is_null($val)) {return null;}
	if($intMode) {return (int)$val;}
	
	if($Settings['writeConversion']!=false){
		$enc = explode('/', $Settings['writeConversion']);
		$val = mb_convert_encoding($val, $enc[0], $enc[1]);
	}
	if(get_magic_quotes_gpc()){$val = stripslashes($val);}
	return $val;
}

function getRecordCount($con, $tableName, $owner){
	$result = mysqli_query($con, "SELECT Count(*) FROM ".$tableName." WHERE Owner=".$owner);
	$row = $result->fetch_array();
 	return $row[0];
} 

function checkSession($con, $uid, $ticket){
	$result = mysqli_query($con,"SELECT Name FROM Users WHERE ID='".$uid."' AND Ticket='".$ticket."'");
	return $result->num_rows==1;
}

function writeError($msg){
	echo("{\"error\":\"".$msg."\"}");
}



