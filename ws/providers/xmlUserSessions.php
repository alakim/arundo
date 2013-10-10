<?php 

class XmlUsersSessions{
	// отдельный файл для хранения сессий чтобы не засорять SVN-репозиторий 
	// постоянно меняющимися значениями тикетов
	static $storageDoc = '/ws/xmlData/userSessions.xml';
	
	private function getDoc(){
		$xmlDoc = new DOMDocument('1.0', 'UTF-8');
		$xmlDoc->load(XmlUsersSessions::$storageDoc);
		return $xmlDoc;
	}
	
	private function getUser($xmlDoc, $usrID){
		$xpath = new DOMXPath($xmlDoc);
		return $xpath->query("/userSessions/user[@id='$usrID']");
	}
	
	// function checkSession($usrID, $ticket){
	// 	$user = getUser(getDoc(), $usrID);
	// 	if($user->length==0) return false;
	// 	if($user->item(0).getAttribute('ticket')!=$ticket) return false;
	// 	return true;
	// }
	
	function getAuthorizedUser($ticket){
		$xDoc = getDoc();
		$xpath = new DOMXPath($xDoc);
		$user = $xpath->query("/userSessions/user[@ticket='$ticket']");
		if($user->length==0) return;
		return $user->item(0)->getAttribute('id');
	}
	
	function setSession($usrID, $ticket){
		$xDoc = getDoc();
		$user = getUser($xDoc, $usrID);
		if($user->length!=0)
			$user = $user->item(0);
		else{
			$user = $xDoc->createElement("user");
			$xpath = new DOMXPath($xDoc);
			$section = $xpath->query("/userSessions")->item(0);
			$section->appendChild($user);
			$user->setAttribute('id', $usrID);
		}
		$user->setAttribute('ticket', $ticket);
	}
	
	function closeSession($usrID){
		$xDoc = getDoc();
		$user = getUser($xDoc, $usrID);
		if($user->length==0) return;
		
		$user = $user->item(0);
		$user.setAttribute('ticket', '');
	}
}