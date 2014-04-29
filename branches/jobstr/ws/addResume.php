<?php
require('../util.php');
require('../captcha/code.php');

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


addRecord($con, "Resumes", array(
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
	"Date"=> date('Y-m-d'),
	"Owner"=> $uid
));


echo("{\"success\":true}");


closeConnection($con);


