<?php 
class Util{
	
	static function conv($str){
		return iconv("UTF-8", "windows-1251", $str);
	}
	
	static function checkAccess($ticket, $catID){
		$sessions = ProviderFactory::getSessions('xmlData/');
		$userID = $sessions->getAuthorizedUser($ticket);
		if($userID==null){
			self::writeError('errAuthorizationRequired');
			die();
		}
		return true;
	}
	
	static function getUserPermissions($ticket){
		$sessions = ProviderFactory::getSessions('xmlData/');
		$userID = $sessions->getAuthorizedUser($ticket);

		if($userID==null){
			self::writeError('errAuthorizationRequired');
			die();
		}

		$userProvider = ProviderFactory::getUsers();
		return $userProvider->getUserPermissions($userID);
	}
	
	static function writeError($errCode){
		echo("{\"error\":\"$errCode\"}");
	}
	
	static function writeErrorData($errCode, $errData){
		echo("{\"error\":\"$errCode\",\"data\":\"$errData\"}");
	}
	
	static function writeWarning($errCode){
		echo("{\"warning\":\"$errCode\"}");
	}
	
	static function writeWarningData($errCode, $errData){
		echo("{\"warning\":\"$errCode\",\"data\":\"$errData\"}");
	}
}

