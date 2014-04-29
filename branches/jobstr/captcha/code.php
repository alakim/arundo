<?php 

function captcha_generateCode($key) {
	$str = md5(md5($key));
	$str = substr($str, 1, 6);
	return $str;
}

function captcha_check($userCode, $key){
	return $userCode==captcha_generateCode($key);
}

