<?php 
class Util{
	
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
}

