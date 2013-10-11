<?php 

class ProviderFactory{
	static function getSessions($baseDir){
		return new XmlUsersSessions($baseDir);
	}

	static function getUsers(){
		return new XmlUsersDB();
	}
	
	
}