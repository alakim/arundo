<?php 
class Util{
	
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	static function getUserPermissions($ticket){
		$sessions = ProviderFactory::getSessions('xmlData/');
		$userID = $sessions->getAuthorizedUser($ticket);

		if($userID==null){
			echo('{error:"errAuthorizationRequired"}');
			die();
		}

		$userProvider = ProviderFactory::getUsers();
		return $userProvider->getUserPermissions($userID);
	}
}

