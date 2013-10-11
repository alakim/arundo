<?php 

class XmlUsersSessions{
	// ��������� ���� ��� �������� ������ ����� �� �������� SVN-����������� 
	// ��������� ����������� ���������� �������
	static $storageDoc = 'ws/xmlData/userSessions.xml';
	
	private function getDoc(){
		$xmlDoc = new DOMDocument('1.0', 'UTF-8');
		$xmlDoc->load(self::$storageDoc);
		return $xmlDoc;
	}
	
	private function getUser($xmlDoc, $usrID){
		$xpath = new DOMXPath($xmlDoc);
		return $xpath->query("/userSessions/user[@id='$usrID']");
	}
	
	function getAuthorizedUser($ticket){
		$xDoc = self::getDoc();
		$xpath = new DOMXPath($xDoc);
		$user = $xpath->query("/userSessions/user[@ticket='$ticket']");
		if($user->length==0) return;
		return $user->item(0)->getAttribute('id');
	}
	
	function setSession($usrID, $ticket){
		$xDoc = self::getDoc();
		$user = self::getUser($xDoc, $usrID);
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
		$xDoc->save(self::$storageDoc);
	}
	
	function closeSession($ticket){
		$xDoc = self::getDoc();
		$xpath = new DOMXPath($xDoc);
		$user = $xpath->query("/userSessions/user[@ticket='$ticket']");
		if($user->length==0) return;
		
		$user = $user->item(0);
		$user->setAttribute('ticket', '');
		$xDoc->save(self::$storageDoc);
	}
}