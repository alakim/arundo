<?php
require('../util.php');
require('../captcha/code.php');

$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$data = $_REQUEST["data"];

// if(!checkSession($con, $uid, $ticket)){
// 	$uid = null;
// }

if(!captcha_check($data["captcha"]["code"], $data["captcha"]["key"])){
	echo("{\"error\":\"Bad CAPTCHA code.\"}");
	die();
}


addRecord($con, "Users", array(
	"Name"=>getRequestField($data, "name", false),
	"Login"=>getRequestField($data, "login", false),
	"EMail"=>getRequestField($data, "email", false),
	"Password"=>crypt(getRequestField($data, "password", false), cryptKey)
));


echo("{\"success\":true}");


closeConnection($con);


