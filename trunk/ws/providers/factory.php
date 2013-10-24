<?php 
require('xmlTree.php');

class ProviderFactory{
	static function getSessions($baseDir){
		return new XmlUsersSessions($baseDir);
	}

	static function getTree(){
		return new XmlTree();
	}

	static function getUsers(){
		return new XmlUsersDB();
	}
	
	static function getTable($tblRef){
		$provName = $tblRef['srcType'];
		if($provName==''){
			echo("{\"error\":\"errMissingDataProvider\"}");
			die();
		};
		$provider = new $provName;
		return $provider;
	}
	
}