<?php
	session_start(); 
	$ticket = $_SESSION["ticket"];
?>

<?php 
	require('ws/util.php');
	require('ws/providers/factory.php');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Авторизация пользователя</title>
	<script type="text/javascript" src="ui/jquery.min.js"></script>
	<script type="text/javascript" src="ui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/lib/html.js"></script>
	<script type="text/javascript" src="js/lib/jspath.js"></script>
	<script type="text/javascript" src="js/arundo.js"></script>
	
	<script type="text/javascript">
		Arundo.view = {init: function(){}};
		$(function(){
			var title = Arundo.locale.getItem("userAuthorization");
			document.title = title;
		});
	</script>
	
	<script type="text/javascript" src="locale/arundo-lang-ru.js"></script>
	
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
	<h1 class="local" ar-locale-id="userAuthorization">Авторизация пользователя</h1>
	<?php

		$usr = $_POST["tbLogin"];
		$psw = $_POST["tbPassword"];
		$action = $_POST["hAction"];
		
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
		
		$sessionProvider = ProviderFactory::getSessions(null);

		if($action=="logoff"){
			$sessionProvider->closeSession($ticket);
			$ticket = '';
		}
		else if($action="logon"){
			$userProvider = new XmlUsersDB();
			if($userProvider->checkUser($usr, $psw)){
				$ticket = getUserHash();
				$sessionProvider->setSession($usr, $ticket);
			}
		}
		$_SESSION["ticket"] = $ticket;
		
		$authorizedUser = $sessionProvider->getAuthorizedUser($ticket);
		$userProvider = ProviderFactory::getUsers();
		$authorizedUserName = $userProvider->getUserName($authorizedUser);
		
		
		
		if($ticket==''){
	?>
		
	<div id="authorizationPanel">
		<form action="logon.php" method="post">
			<div><span class="local" ar-locale-id="login">Логин</span>: <input type="text" name="tbLogin"/></div>
			<div><span class="local" ar-locale-id="password">Пароль</span>: <input type="password" name="tbPassword"/></div>
			<input type="hidden" name="hAction" value="logon"/>
			<div><input class="local" ar-locale-id="logon" ar-locale-target="value" type="submit" value="Вход"/></div>
		</form>
	</div>
	<?php }
		else{
		?>
		<form action="logon.php" method="post">
			<div><span class="local" ar-locale-id="hello">Hello</span>, <?php echo($authorizedUserName); ?></div>
			<input type="hidden" name="hAction" value="logoff"/>
			<div><input class="local" ar-locale-id="logoff" ar-locale-target="value" type="submit" value="Выход"/></div>
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