<?php
	$userDB = 'usersDB.xml';
	
	session_start(); 
	$ticket = $_SESSION["ticket"];
	if($ticket!=''){
		// header('Location: index.php');
		// die();
	}
?>

<?php 
	require('ws/providers/xmlusersdb.php');
	require('ws/providers/xmlUserSessions.php');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Авторизация пользователя</title>

</head>
<body>
	<h1>Авторизация пользователя</h1>
	<p><a href="/">main page</a></p>
	<?php

		$usr = $_POST["tbLogin"];
		$psw = $_POST["tbPassword"];
		$action = $_POST["hAction"];
		
		$sessionProvider = new XmlUsersSessions();
		$authorizedUser = $sessionProvider->getAuthorizedUser($ticket);
		
		function getUserHash(){
			return md5(generateCode(10));
		}
		
		# Функция для генерации случайной строки
		function generateCode($length=6) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
			$code = "";
			$clen = strlen($chars) - 1;  
			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0,$clen)];  
			}
			return $code;
		}

		
		
		
		echo("<p>action: $action</p>");
		
		
		
		if($action=="logoff"){
			$ticket = '';
			$sessionProvider->closeSession($usr);
		}
		else if($action="logon"){
			$userProvider = new XmlUsersDB();
			if($userProvider->checkUser($userDB, $usr, $psw)){
				$ticket = getUserHash();
			}
		}
		$_SESSION["ticket"] = $ticket;
		
		echo("ticket 1: '$ticket'");
		
		// function checkSession(){
		// 	// $'userSessions.xml';
		// }
		
		if($ticket==''){
	?>
		
	<div id="authorizationPanel">
		<form action="logon.php" method="post">
			<div>Логин: <input type="text" name="tbLogin"/></div>
			<div>Пароль: <input type="password" name="tbPassword"/></div>
			<input type="hidden" name="hAction" value="logon"/>
			<div><input type="submit" value="Вход"/></div>
		</form>
	</div>
	<?php }
		else{
		?>
		<form action="logon.php" method="post">
			<div>Hello, <?php echo($authorizedUser); ?></div>
			<input type="hidden" name="hAction" value="logoff"/>
			<div><input type="submit" value="Выход"/></div>
		</form>
		
		<?php
		}
		?>
</body>
</html>