<?php
	$userDB = 'usersDB.xml';
	
	session_start(); 
	$ticket = $_SESSION["ticket"];
?>

<?php 
	require('ws/providers/xmlusersdb.php');
	require('ws/providers/xmlUserSessions.php');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>����������� ������������</title>
	<style type="text/css">
		body{
			font-family: Verdana, Arial, Sans-Serif;
			font-size: 14px;
			text-align: center;
			margin: 20px;
			
		}
		h1{
			margin-top: 80px;
			text-align: center;
		}
		#authorizationPanel{
			border:1px solid #888;
			/*width: 300px;*/
			padding:25px;
			margin:50px 350px 0 350px;
		}
	</style>
</head>
<body>
	<h1>����������� ������������</h1>
	<?php

		$usr = $_POST["tbLogin"];
		$psw = $_POST["tbPassword"];
		$action = $_POST["hAction"];
		
		function getUserHash(){
			return md5(generateCode(10));
		}
		
		# ������� ��� ��������� ��������� ������
		function generateCode($length=6) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
			$code = "";
			$clen = strlen($chars) - 1;  
			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0,$clen)];  
			}
			return $code;
		}
		
		$sessionProvider = new XmlUsersSessions();

		if($action=="logoff"){
			$sessionProvider->closeSession($ticket);
			$ticket = '';
		}
		else if($action="logon"){
			$userProvider = new XmlUsersDB();
			if($userProvider->checkUser($userDB, $usr, $psw)){
				$ticket = getUserHash();
				$sessionProvider->setSession($usr, $ticket);
			}
		}
		$_SESSION["ticket"] = $ticket;
		
		$authorizedUser = $sessionProvider->getAuthorizedUser($ticket);
		
		
		if($ticket==''){
	?>
		
	<div id="authorizationPanel">
		<form action="logon.php" method="post">
			<div>�����: <input type="text" name="tbLogin"/></div>
			<div>������: <input type="password" name="tbPassword"/></div>
			<input type="hidden" name="hAction" value="logon"/>
			<div><input type="submit" value="����"/></div>
		</form>
	</div>
	<?php }
		else{
		?>
		<form action="logon.php" method="post">
			<div>Hello, <?php echo($authorizedUser); ?></div>
			<input type="hidden" name="hAction" value="logoff"/>
			<div><input type="submit" value="�����"/></div>
		</form>
		<script type="text/javascript">
			setTimeout(function(){
				window.location.href = "index.php";
			}, 1000);
		</script>
		
		<?php
		}
		?>
</body>
</html>