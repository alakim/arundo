<?php function openConnection(){	$con=mysqli_connect("localhost","sa","123456","jobstr");	// Check connection	if (mysqli_connect_errno()){		echo "Failed to connect to MySQL: " . mysqli_connect_error();		return false;	}		return $con;}function closeConnection($con){	mysqli_close($con);}function execSql($con, $sql){	$res = mysqli_query($con, $sql);	if ($res){		//echo("Success<br/>");		return $res;	}	else{		echo "Error: " . mysqli_error($con)."<br/>";	}}function tableExists($con, $tableName){	if(execSql($con, "show tables like \"".$tableName."\"")->num_rows>0){		return true;	}	return false;}	function addRecord($con, $tableName, $data){	$fields = implode(",", array_keys($data));	$aValues = array_values($data);	for($i=0; $i<count($aValues); $i++){		$v = $aValues[$i];		if(is_string($v)){			$aValues[$i] = "'".$v."'";		}	}	$values = implode(",", $aValues);	$sql = "INSERT INTO ".$tableName." (".$fields.") VALUES (".$values.")";	// echo($sql."<hr/>");	execSql($con, $sql);}function chechSession($con, $uid, $ticket){	$result = mysqli_query($con,"SELECT Name FROM Users WHERE ID='".$uid."' AND Ticket='".$ticket."'");	return $result->num_rows==1;}$cryptKey = '$1$oy789FnX$n456FkIc4Hrm123PZ0IEO/';