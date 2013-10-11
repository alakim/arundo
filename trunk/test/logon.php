<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Пример авторизации</title>

</head>
<body>
	<h1>Пример авторизации</h1>
	<p>Это пример авторизации с помощью передачи ticket'а.</p>
	<p><a href="logon.php">Reload</a></p>
	
	<?php
		include ("test/db.php");
		
		$db = new UsersDB();
			
		$usr = $_POST["tbLogin"];
		$psw = $_POST["tbPassword"];
		$action = $_POST["hAction"];
		$ticket = $_SESSION["ticket"];
		echo("ticket 1:".$ticket);
		$user = $db->getAuthorizedUser($ticket);
		
		if($action=="logoff"){
			$db->logoff($ticket);
		}
		else if($action="logon"){
			$ticket = $db->logon($usr, $psw);
			echo("ticket 2:".$ticket);
			$_SESSION["ticket"] = $ticket;
			$user = $db->getAuthorizedUser($ticket);
				
		}
		if($user==null){
	?>
		
	<div id="authorizationPanel">
		<form action="index.php" method="post">
			<div>Логин: <input type="text" name="tbLogin"/></div>
			<div>Пароль: <input type="password" name="tbPassword"/></div>
			<input type="hidden" name="hAction" value="logon"/>
			<div><input type="submit" value="Авторизоваться"/></div>
		</form>
	</div>
	<?php }
		else{
		?>
		<form action="index.php" method="post">
			<div>Hello, <?=$user->attributes->getNamedItem("login")->value?></div>
			<input type="hidden" name="hAction" value="logoff"/>
			<div><input type="submit" value="Выход"/></div>
		</form>
		
		<?php
		
		}
	?>
	
	
</body>
</html>