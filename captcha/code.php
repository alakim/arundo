<?php function generate_code($key) {	$str = md5(md5($key));	$str = substr($str, 1, 6);	return $str;}function checkCaptcha($userCode, $key){	$code = generate_code($key);	return $userCode==$code;}