<?php
require('../util.php');
require('../captcha/code.php');

$tableName = "Vacancies";

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
	"Salary"=>getRequestField($data, "salaryMin", true)." - ".getRequestField($data, "salaryMax", true),
	"Date"=> date('Y-m-d'),
	"Rubric"=>getRequestField($data, "rubric", true),
	"Region"=>getRequestField($data, "region", true),
	"Organization"=>getRequestField($data, "organization", false),
	"Description"=>getRequestField($data, "skills", false),
	"Education"=>getRequestField($data, "education", true),
	"Contact"=>getRequestField($data, "contact", false),
	"Phone"=>getRequestField($data, "phone", false),
	"Email"=>getRequestField($data, "email", false)
));


echo("{\"success\":true}");


closeConnection($con);


