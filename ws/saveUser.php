<?php
require('../util.php');
require('../captcha/code.php');

$tableName = "Users";

$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$data = $_REQUEST["data"];


if(!checkSession($con, $uid, $ticket)){
	writeError("Access denied.");
	die();
}

saveRecord($con, $tableName, $uid, array(
	"Name"=>getRequestField($data, "name", false),
	"Login"=>getRequestField($data, "login", false),
	"EMail"=>getRequestField($data, "email", false),
	"Password"=>crypt(getRequestField($data, "password", false), cryptKey)
));


echo("{\"success\":true}");


closeConnection($con);

