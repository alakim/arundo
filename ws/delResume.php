<?php
require('../util.php');

$tableName = "Resumes";

$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$resID = $_REQUEST["resID"];

$owner = getOwner($con, $tableName, $resID);

if(!checkSession($con, $uid, $ticket) && $owner!=$uid){
	writeError("Access denied.");
	die();
}


execSql($con, "DELETE FROM ".$tableName." WHERE ID=".$resID);

echo("{\"success\":true}");


closeConnection($con);


