<?php
require('../util.php');
$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$data = $_REQUEST["data"];

if(!checkSession($con, $uid, $ticket)){
	$uid = null;
}

if(!captcha_check($data["captcha"]["code"], $data["captcha"]["key"])){
	echo("{\"error\":\"Bad CAPTCHA code.\"}");
	die();
}

addRecord($con, "Vacancies", array(
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
	"Email"=>getRequestField($data, "email", false),
	"Owner"=> $uid
));


echo("{\"success\":true}");


closeConnection($con);


