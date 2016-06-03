<?php
	session_start();
	if(isset($_SESSION['user_id'])) {
		$redirect = "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/poopupFront';
		header('Location: ' . $redirect);
	}
?>
<link rel="stylesheet" type="text/css" href="css/main.css">
<header class="header-login">
	<img class="logo" src="img/logo.png" alt="" />
</header>
<form id="login" action = "login.validation.php" method="POST"></br>
	Login :<input type="text" name="login"/></br>
	Password :<input type="password" name="mdp"/></br>
	<input class="button" type="submit" value="log in" />
</form>
