<?php
	
	class DB{
		
		const DOCPATH = "test/db.xml";
		
		function __construct(){
			$this->xmlDoc = new DOMDocument();
			$this->xmlDoc->load(self::DOCPATH);
		}
		
		function __destruct(){
			//$this->save();
		}
		
		function save(){
			$this->xmlDoc->save(self::DOCPATH);
		}
		
		function getXNode($query){
			$xpath = new DOMXPath($this->xmlDoc);
			$dbNode = $this->xmlDoc->getElementsByTagName('db')->item(0);
			$nodes = $xpath->evaluate($query, $dbNode);
			return $nodes->item(0);
		}
		
		function setAttribute($el, $nm, $value){
			$el->setAttribute($nm, $value);
			$this->save();
		}
		
		function removeAttribute($el, $nm){
			$el->removeAttribute($nm);
			$this->save();
		}
	}
	
	
	class UsersDB{
		function __construct(){
			$this->db = new DB();
		}
		
		public function logon($login, $password){
			echo("logon:".$login.";".$password);
			$user = $this->getUser($login);
			if(!$this->checkUser($user, $password)) return null;
			$hash = self::getUserHash();
			$this->db->setAttribute($user, "hash", $hash);
			return $hash;
		}
		
		public function logoff($hash){
			$user = $this->getAuthorizedUser($hash);
			if($user==null) return;
			$this->db->removeAttribute($user, "hash");
		}
		
		public function getAuthorizedUser($hash){
			return $this->db->getXNode("/db/users/user[@hash='".$hash."']");
		}
		
		
		private function getUser($login){
			return $this->db->getXNode("/db/users/user[@login='".$login."']");
		}
		
		private function checkUser($user, $password){
			if($user==null) return null;
			return $user->attributes->getNamedItem("password")->value==$password;
		}
		
		
		static function getUserHash(){
			return md5(self::generateCode(10));
		}
		
		# Функция для генерации случайной строки
		static function generateCode($length=6) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
			$code = "";
			$clen = strlen($chars) - 1;  
			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0,$clen)];  
			}
			return $code;
		}
	}
	

?>