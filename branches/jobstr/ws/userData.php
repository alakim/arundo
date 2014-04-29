<?php
require('../util.php');
$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];

if(!checkSession($con, $uid, $ticket)){
	echo("{\"error\":\"User not authorized\"}");
	die();
}


$result = mysqli_query($con, "SELECT Name, Login, EMail FROM Users WHERE ID=".$uid." ");
 if($result->num_rows==1){
 	$row = $result->fetch_array();
	$resCount = getRecordCount($con, "Resumes", $uid);
	$vacCount = getRecordCount($con, "Vacancies", $uid);
 	echo("{");
	writeJsonField($row, "Name", true); echo(",");
	writeJsonField($row, "Login", true); echo(",");
	writeJsonField($row, "EMail", true); echo(",");
	echo("\"resCount\":".$resCount.", \"vacCount\":".$vacCount);
 	echo("}");
 }
 else{
 	echo("{\"error\":\"Bad user ID\"}");
 }

closeConnection($con);


