<?php
require('../util.php');

$tableName = "Vacancies";

$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$vacID = $_REQUEST["vacID"];

$owner = getOwner($con, $tableName, $vacID);

if(!checkSession($con, $uid, $ticket) && $owner!=$uid){
	writeError("Access denied.");
	die();
}


execSql($con, "DELETE FROM ".$tableName." WHERE ID=".$vacID);

echo("{\"success\":true}");


closeConnection($con);


