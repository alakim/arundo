<?php
	session_start(); 
	$ticket = $_SESSION["ticket"];
	if($ticket!=''){
		// header('Location: index.php');
		// die();
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Авторизация пользователя</title>

</head>
<body>
	<h1>Авторизация пользователя</h1>
	
	<?php

		$usr = $_POST["tbLogin"];
		$psw = $_POST["tbPassword"];
		$action = $_POST["hAction"];
		
		echo("<p>action: $action</p>");
		if($action=="logoff"){
			$ticket = '';
		}
		else if($action="logon"){
			$ticket = 'ttt';
		}
		$_SESSION["ticket"] = $ticket;
		
		echo("ticket 1: '$ticket'");
		
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
			<div>Hello,</div>
			<input type="hidden" name="hAction" value="logoff"/>
			<div><input type="submit" value="Выход"/></div>
		</form>
		
		<?php
		
		}
	?>
	
	
	<div>
		<?php
			
		?>
	</div>
</body>
</html>