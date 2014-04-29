<?php
require('../util.php');
require('../captcha/code.php');

$tableName = "Resumes";

$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$data = $_REQUEST["data"];

$rowID = $data["id"];
$owner = getOwner($con, $tableName, $rowID);


if(!checkSession($con, $uid, $ticket) && $owner!=$uid){
	writeError("Access denied.");
	die();
}

saveRecord($con, $tableName, $rowID, array(
	"Title"=>getRequestField($data, "post", false),
	"Salary"=>getRequestField($data, "salary", false),
	"Rubric"=>getRequestField($data, "rubric", true),
	"Description"=>getRequestField($data, "skills", false),
	"Fio"=>getRequestField($data, "fio", false),
	"Age"=>getRequestField($data, "age", true),
	"Region"=>getRequestField($data, "region", true),
	"Education"=>getRequestField($data, "education", true),
	"Experience"=>getRequestField($data, "experience", true),
	"Phone"=>getRequestField($data, "phone", false),
	"Email"=>getRequestField($data, "email", false),
	"Date"=> date('Y-m-d')
));


echo("{\"success\":true}");


closeConnection($con);

